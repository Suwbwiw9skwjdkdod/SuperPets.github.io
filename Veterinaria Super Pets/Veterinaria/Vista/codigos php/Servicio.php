<?php
// Conexión a la base de datos
$server = "localhost";
$user = "root";
$pass = "";
$db = "Veterinaria";

$conexion = mysqli_connect($server, $user, $pass, $db);
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Insertar datos cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreServicio = $_POST['nombreServicio'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $duracion = $_POST['duracion'];
    $disponibilidad = $_POST['disponibilidad'];

    $sqlInsert = "INSERT INTO servicio (nombreServicio, descripcion, precio, duracion, disponibilidad)
                  VALUES ('$nombreServicio', '$descripcion', '$precio', '$duracion', '$disponibilidad')";

    if ($conexion->query($sqlInsert) === TRUE) {
        header("Location: mantener_servicio.php"); // Redirige a la lista de servicios
        exit();
    } else {
        echo "Error al agregar servicio: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil Administrador</title>

  <!-- CSS SEPARADO -->
  <link rel="stylesheet" href="../CSS/agregar.css">

  <!-- ICONOS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">    
</head>
<body>

<!-- NAVBAR -->
<header>
  <nav class="navbar">
    <div class="menu-icon" onclick="toggleMenu()">
      <i class="fas fa-bars"></i>
    </div>
    
    <img src="../Imagenes/logo-sf.png">

    <div class="nav-links" id="menu">
      <a href="../codigos php/mantener_cliente.php" target="_blank"><i class="fas fa-user"></i> Cliente</a>
      <a href="../codigos php/mantener_servicio.php" target="_blank"><i class="fas fa-concierge-bell"></i> Servicios</a>
      <a href="VeterinarioMenu.html" target="_blank"><i class="fas fa-stethoscope"></i> Veterinarios</a>
      <a href="../codigos php/mantener_empleado.php" target="_blank"><i class="fas fa-user-tie"></i> Empleados</a>
      <a href="../codigos php/mantener_mascota.php" target="_blank"><i class="fa-solid fa-paw"></i> Mascotas</a>
      <a href="../Paginas html/sesion.html" target="_blank"><i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión</a>
    </div>
  </nav>
</header>

<main class="profile-container">
  <div class="profile-card">
    
    <form method="post" action="guardar_servicio.php">

    <h1>Agregar Nuevo Servicio</h1>

        <!-- Nombre del servicio como lista -->
        <label for="nombreServicio">Nombre del Servicio:</label>
        <select id="nombreServicio" name="nombreServicio" required>
            <option value="" disabled selected>Seleccione un servicio</option>
            <option value="Hospitalizacion">Hospitalización</option>
            <option value="Estetica">Estética</option>
            <option value="Cremacion">Cremación</option>
        </select>

        <!-- Descripción -->
        <label for="descripcion">Descripción:</label>
        <input type="text" id="descripcion" name="descripcion" placeholder="Ej. Atención médica completa" required>

        <!-- Precio -->
        <label for="precio">Precio:</label>
        <input type="text" id="precio" name="precio" placeholder="Ej. $500 MXN" required>

        <!-- Duración -->
        <label for="duracion">Duración:</label>
        <input type="text" id="duracion" name="duracion" placeholder="Ej. 2 horas" required>

        <!-- Disponibilidad -->
        <label for="disponibilidad">Disponibilidad:</label>
        <input type="text" id="disponibilidad" name="disponibilidad" placeholder="Ej. Lunes a Viernes" required>

        <!-- Botones -->
        <input type="submit" name="guardar"></input>
        <input type="reset" value="Limpiar">
        <div class="regresar">
        <a href="mantener_servicio.php"><i class="fas fa-arrow-left"></i> Regresar</a>
        </div>
    </form>
  </div>
</main>

<footer>
  <p>&copy; 2025 Veterinaria Super Pets</p>
  <p>Ramirez San Martin Angeles Valeria, Rositas Santiago Evelyn Johana</p>
</footer>

<script>
  function toggleMenu() {
    const menu = document.getElementById('menu');
    menu.classList.toggle('active');
  }
</script>

</body>
</html>