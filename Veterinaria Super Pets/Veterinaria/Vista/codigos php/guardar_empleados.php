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
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido_p = $_POST['apellido_p'];
    $apellido_M = $_POST['apellido_M'];
    $puesto = $_POST['puesto'];
    $turno = $_POST['turno'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
   $fecha = date("Y-m-d");

    // Consulta SQL para insertar los datos
    $sql = "INSERT INTO empleados (id, nombre, apellido_p, apellido_M, puesto, turno, correo, telefono, fecha)
            VALUES ('$id', '$nombre', '$apellido_p', '$apellido_M', '$puesto', '$turno', '$correo', '$telefono', '$fecha')";

  // Ejecutar la consulta
    if ($conexion->query($sql) === TRUE) {
        $mensaje = "¡Empleado registrado con éxito!";
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
        window.location.href = "mantener_empleado.php"; // Redirige después de mostrar el mensaje
    }, 3000);
<?php endif; ?>
</script>

</body>
</html>
