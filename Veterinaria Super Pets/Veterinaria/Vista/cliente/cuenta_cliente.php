<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "Veterinaria";

$conexion = mysqli_connect($server, $user, $pass, $db);
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$mensaje = "";
$tipoMensaje = "";
$cliente = null;


// ------------------------------------------------------------------
// 1. SI VIENE DEL FORMULARIO "CLIENTE EXISTENTE"
//    SOLO SE AGREGA CONTRASEÑA, EL CORREO SOLO IDENTIFICA EL REGISTRO
// ------------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $correo = $_POST['correo'];      // Solo para buscar al cliente
    $contrasena = $_POST['contraseña']; // Solo se guardará la contraseña

    // Buscar cliente existente por el correo
    $sql = "SELECT * FROM clientes WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 0) {
        // Correo NO existente en la base de datos
        $mensaje = "Este correo no está registrado en la veterinaria.";
        $tipoMensaje = "error";

    } else {

        // Si existe → Actualizar contraseña
        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

        $update = $conexion->prepare("
            UPDATE clientes SET contrasena = ?
            WHERE correo = ?
        ");
        $update->bind_param("ss", $contrasenaHash, $correo);

        if ($update->execute()) {

            $mensaje = "¡Cuenta registrada exitosamente!";
            $tipoMensaje = "exito";

            // Obtener datos del cliente actualizado
            $cliente = $resultado->fetch_assoc();

        } else {
            $mensaje = "Error al actualizar: " . $update->error;
            $tipoMensaje = "error";
        }

        $update->close();
    }

    $stmt->close();
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Cliente</title>

    <link rel="stylesheet" href="../CSS/registro.css">

    <style>
        /* Notificación flotante */
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

        .datos-registrados {
            width: 90%;
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            border-radius: 12px;
            background: #ffffffd6;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            font-size: 18px;
        }
        .datos-registrados h2 {
            text-align: center;
        }
    </style>

</head>
<body>

<?php if ($mensaje != ""): ?>
<div id="toast" class="toast <?php echo $tipoMensaje; ?>">
    <?php echo $mensaje; ?>
</div>
<?php endif; ?>


<header class="hero">
   <nav class="navbar">
      <img src="../Imagenes/logo-sf.png" class="logo">
      <a href="../index.html"><i class="fa-solid fa-house"></i> Inicio</a>
      <a href="Servicios.html"><i class="fa-solid fa-store"></i> Servicios</a>
      <a href="Citas.html"><i class="fa-solid fa-cart-shopping"></i> Citas</a>
      <a href="Articulos.html"><i class="fa-solid fa-paw"></i> Artículos</a>   
   </nav>
</header>


<!-- Mostrar datos del cliente SOLO si la cuenta se registró -->
<?php if ($cliente && $tipoMensaje == "exito"): ?>
<div class="datos-registrados">
    <h2>Cuenta Activada</h2>

    <p><strong>Nombre:</strong> <?php echo $cliente['nombre']; ?></p>
    <p><strong>Apellido Paterno:</strong> <?php echo $cliente['apellido_P']; ?></p>
    <p><strong>Apellido Materno:</strong> <?php echo $cliente['apellido_M']; ?></p>
    <p><strong>Correo:</strong> <?php echo $cliente['correo']; ?></p>

    <br>
    <a href="../Paginas html/sesion.html" style="text-decoration:none; color:#007bff;">Iniciar Sesión</a>
</div>
<?php endif; ?>


<footer>
  <p>&copy; 2025 Veterinaria Super Pets</p>
</footer>


<script>
// Animación de notificación
<?php if ($mensaje != ""): ?>
    let toast = document.getElementById("toast");
    toast.classList.add("show");
    setTimeout(() => {
        toast.classList.remove("show");
    }, 4000);
<?php endif; ?>
</script>

</body>
</html>