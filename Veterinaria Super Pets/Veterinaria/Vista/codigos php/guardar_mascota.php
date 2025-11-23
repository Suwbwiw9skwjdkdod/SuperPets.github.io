<?php
// Conexión a la base de datos
$server = "localhost";
$user = "root";
$pass = "";
$db = "Veterinaria";

$conexion = mysqli_connect($server, $user, $pass, $db);

// Verificar conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$mensaje = "";
$tipoMensaje = "";

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombreMascota = $_POST['nombreMascota'];
    $especie = $_POST['especie'];
    $raza = $_POST['raza'];
    $fechaNacimiento = date("Y-m-d");
    $sexo = $_POST['sexo'];
    $dueno = $_POST['dueno'];

    // Consulta SQL para insertar los datos
    $sql = "INSERT INTO mascotas (nombreMascota, especie, raza, fechaNacimiento, sexo, dueno)
            VALUES ('$nombreMascota', '$especie','$raza', '$fechaNacimiento', '$sexo', '$dueno')";

     // Ejecutar la consulta
    if ($conexion->query($sql) === TRUE) {
        $mensaje = "¡Mascota registrada con éxito!";
        $tipoMensaje = "exito";
    } else {
        $mensaje = "Error al registrar: " . $conexion->error;
        $tipoMensaje = "error";
    }
}

// Cerrar la conexión
$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Empleado</title>
<link rel="stylesheet" href="../CSS/actualizar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
.toast {
    position: fixed;
    top: 20px;
    right: -300px;
    padding: 15px 20px;
    color: white;
    border-radius: 8px;
    font-size: 16px;
    transition: .5s ease;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.3);
    z-index: 9999;
}
.toast.exito { background-color: #28a745; }
.toast.error { background-color: #e63946; }
.toast.show { right: 20px; }
</style>
</head>
<body>

<!-- NOTIFICACIÓN -->
<?php if ($mensaje != ""): ?>
<div id="toast" class="toast <?php echo $tipoMensaje; ?>">
    <?php echo $mensaje; ?>
</div>
<?php endif; ?>

<script>
<?php if ($mensaje != ""): ?>
    let toast = document.getElementById("toast");
    toast.classList.add("show");
    setTimeout(() => {
        toast.classList.remove("show");
        window.location.href = "mantener_mascota.php"; // Redirige después de mostrar el mensaje
    }, 3000);
<?php endif; ?>
</script>

</body>
</html>
