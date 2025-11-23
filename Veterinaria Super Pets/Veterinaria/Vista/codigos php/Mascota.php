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
      <a href="../codigos php/mantener_empleado.php" target="_blank"><i class="fas fa-concierge-bell"></i> Servicios</a>
      <a href="VeterinarioMenu.html" target="_blank"><i class="fas fa-stethoscope"></i> Veterinarios</a>
      <a href="../codigos php/mantener_empleado.php" target="_blank"><i class="fas fa-user-tie"></i> Empleados</a>
      <a href="../codigos php/mantener_mascota.php" target="_blank"><i class="fa-solid fa-paw"></i> Mascotas</a>
      <a href="../Paginas html/sesion.html" target="_blank"><i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión</a>
    </div>
  </nav>
</header>

<main class="profile-container">
  <div class="profile-card">
    <h1>Registrar Nueva Mascota</h1>
     <form method="post" action="../codigos php/guardar_mascota.php">
        
        <!-- Nombre -->
        <label for="nombreMascota">Nombre:</label>
        <input type="text" id="nombreMascota" name="nombreMascota" placeholder="Ej. Max" required><br>

        <!-- Especie -->
        <label for="especie">Especie:</label>
        <select name="especie" id="especie" required>
            <option value="" disabled selected>Seleccione especie</option>
            <option value="Perro">Perro</option>
            <option value="Gato">Gato</option>
            <option value="Ave">Ave</option>
        </select><br>

        <!-- Raza -->
        <label for="raza">Raza:</label>
        <select name="raza" id="raza" required>
            <option value="" disabled selected>Seleccione raza</option>
        </select><br>

        <!-- Fecha de nacimiento -->
        <label for="fechaNacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fechaNacimiento" name="fechaNacimiento" required><br>

        <!-- Sexo -->
        <label for="sexo">Sexo:</label>
        <select name="sexo" id="sexo" required>
            <option value="" disabled selected>Seleccione</option>
            <option value="Macho">Macho</option>
            <option value="Hembra">Hembra</option>
        </select><br>

        <!-- Dueño -->
        <label for="dueno">Dueño:</label>
        <select name="dueno" id="dueno" required>
            <option value="" disabled selected>Seleccione dueño</option>
            <?php
            $sqlClientes = "SELECT nombre, apellido_P FROM clientes";
            $resultClientes = $conexion->query($sqlClientes);
            if ($resultClientes->num_rows > 0) {
                while ($cliente = $resultClientes->fetch_assoc()) {
                    $nombreCompleto = $cliente['nombre']." ".$cliente['apellido_P'];
                    echo "<option value='$nombreCompleto'>$nombreCompleto</option>";
                }
            } else {
                echo "<option>No hay clientes registrados</option>
                <a href='mantener_mascota.php'<i class='fas fa-arrow-left'></i> Regresar</a>";
            }
            ?>
        </select><br>

        <!-- Botones -->
       <input type="submit" name="guardar"></input>
        <input type="reset" value="Limpiar">
        <div class="regresar">
         <a href="mantener_mascota.php"><i class="fas fa-arrow-left"></i> Regresar</a>
        </div>
    </form>
  </div>
</main>

<footer>
  <p>&copy; 2025 Veterinaria Super Pets</p>
  <p>Ramirez San Martin Angeles Valeria, Rositas Santiago Evelyn Johana</p>
</footer>

<!-- Script para razas dinámicas -->
<script>
    const especieSelect = document.getElementById('especie');
    const razaSelect = document.getElementById('raza');

    const razas = {
        Perro: ["Labrador", "Bulldog", "Chihuahua", "Pastor Alemán"],
        Gato: ["Persa", "Siamés", "Maine Coon", "Bengalí"],
        Ave: ["Canario", "Periquito", "Loro", "Cacatúa"]
    };

    function actualizarRazas() {
        const especieSeleccionada = especieSelect.value;
        razaSelect.innerHTML = "<option value='' disabled selected>Seleccione raza</option>";
        if (razas[especieSeleccionada]) {
            razas[especieSeleccionada].forEach(raza => {
                const option = document.createElement('option');
                option.value = raza;
                option.textContent = raza;
                razaSelect.appendChild(option);
            });
        }
    }

    especieSelect.addEventListener('change', actualizarRazas);
</script>

</body>
</html>