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
    $nombre = $_POST['nombre'];
    $apellido_p = $_POST['apellido_p'];
    $apellido_m = $_POST['apellido_m'];
    $puesto = $_POST['puesto'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $turno = $_POST['turno'];

    $sqlInsert = "INSERT INTO veterinario (nombre, apellido_P, apellido_M, puesto, correo, telefono, turno)
                  VALUES ('$nombre', '$apellido_p', '$apellido_m', '$puesto', '$correo', '$telefono', '$turno')";

    if ($conexion->query($sqlInsert) === TRUE) {
        header("Location: mantener_veterinario.php"); // Redirige a la lista de veterinarios
        exit();
    } else {
        echo "Error al agregar veterinario: " . $conexion->error;
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
      <a href="../codigos php/mantener_veterinario.php" target="_blank"><i class="fas fa-stethoscope"></i> Veterinarios</a>
      <a href="../codigos php/mantener_empleado.php" target="_blank"><i class="fas fa-user-tie"></i> Empleados</a>
      <a href="../codigos php/mantener_mascota.php" target="_blank"><i class="fa-solid fa-paw"></i> Mascotas</a>
      <a href="../Paginas html/sesion.html" target="_blank"><i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión</a>
    </div>
  </nav>
</header>

<main class="profile-container">
  <div class="profile-card">
   <form method="post" action="guardar_veterinario.php">

      <h1>Agregar Nuevo Veterinario</h1>

      <!-- Nombre -->
      <label for="nombre">Nombre:</label>
      <input type="text" id="nombre" name="nombre" placeholder="Ej. Juan" required>

      <!-- Apellido Paterno -->
      <label for="apellido_p">Apellido Paterno:</label>
      <input type="text" id="apellido_p" name="apellido_p" placeholder="Ej. Pérez" required>

      <!-- Apellido Materno -->
      <label for="apellido_m">Apellido Materno:</label>
      <input type="text" id="apellido_m" name="apellido_m" placeholder="Ej. López" required>

      <!-- Puesto -->
      <label for="puesto">Puesto:</label>
      <select id="puesto" name="puesto" required>
        <option value="" disabled selected>Seleccione un puesto</option>
        <option value="Veterinario General">Veterinario General</option>
        <option value="Veterinario Especialista">Veterinario Especialista</option>
        <option value="Cirujano">Cirujano</option>
        <option value="Anestesiólogo">Anestesiólogo</option>
        <option value="Dermatólogo">Dermatólogo</option>
      </select>

      <!-- Correo -->
      <label for="correo">Correo:</label>
      <input type="email" id="correo" name="correo" placeholder="Ej. veterinario@correo.com" required>

      <!-- Teléfono -->
      <label for="telefono">Teléfono:</label>
      <input type="text" id="telefono" name="telefono" placeholder="Ej. 555-123-4567" required>

      <!-- Turno -->
      <label for="turno">Turno:</label>
      <select id="turno" name="turno" required>
        <option value="" disabled selected>Seleccione un turno</option>
        <option value="Matutino">Matutino</option>
        <option value="Vespertino">Vespertino</option>
        <option value="Nocturno">Nocturno</option>
      </select>

      <!-- Botones -->
      <input type="submit" value="Guardar">
      <input type="reset" value="Limpiar">
      <div class="regresar">
        <a href="mantener_veterinario.php"><i class="fas fa-arrow-left"></i> Regresar</a>
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