<?php
session_start();

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "Veterinaria");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Validar datos enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos del formulario
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

 

    // --- Verificar en administradores ---
    $stmt_admin = $conexion->prepare("SELECT contrasena FROM administradores WHERE correo = ?");
    $stmt_admin->bind_param("s", $correo);
    $stmt_admin->execute();
    $resultado_admin = $stmt_admin->get_result();

    if ($resultado_admin && $resultado_admin->num_rows > 0) {
        $admin = $resultado_admin->fetch_assoc();
        if (password_verify($contrasena, $admin['contrasena'])) {
            $_SESSION['usuario'] = $correo;
            header("Location: ../Paginas html/administrador.html");
            exit();
        }
    }

    // --- Verificar en clientes ---
    $stmt_cliente = $conexion->prepare("SELECT contrasena FROM clientes WHERE correo = ?");
    $stmt_cliente->bind_param("s", $correo);
    $stmt_cliente->execute();
    $resultado_cliente = $stmt_cliente->get_result();

    if ($resultado_cliente && $resultado_cliente->num_rows > 0) {
        $cliente = $resultado_cliente->fetch_assoc();
        if (password_verify($contrasena, $cliente['contrasena'])) {
            $_SESSION['usuario'] = $correo;
            header("Location: ../cliente/perfil_cliente.php");
            exit();
        }
    }

       echo '<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
   <link rel="stylesheet" href="../CSS/sesion.css">
 <link rel="stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">    
</head>
<body>



<header class="hero">
 <img src="../Imagenes/logo-sf.png" class="logo">
  <nav class="navbar">
 
    <a></a>
    <a></a>
    <a></a>
    <a></a>
      <a href="../index.html"><i class="fa-solid fa-house"></i>Inicio</a>
  </nav>
</header>

<h1>¡Contraseña incorrecta!</h1>
 <a href="../Paginas html/sesion.html"><i class="fas fa-arrow-left"></i> Vuelve a intentarlo </a>

<footer>

      <p>&copy; 2025 Veterinaria Super Pets</p>
   <p>Ramirez San Martin Angeles Valeria, Rositas Santiago Evelyn Johana</p>
    
  
</footer>

</body>
</html>';
    }


mysqli_close($conexion);
?>