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

$mensaje = "";
$tipoMensaje = "";

// Obtener datos del veterinario
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM veterinarios WHERE id_veterinario = $id";
    $resultado = $conexion->query($sql);
    $veterinario = $resultado->fetch_assoc();
}

// Actualizar datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $apellido_p = $_POST['apellido_p'];
    $apellido_M = $_POST['apellido_M'];
    $puesto = $_POST['puesto'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $turno = $_POST['turno'];

    $sqlUpdate = "UPDATE veterinarios SET 
        nombre='$nombre',
        apellido_P='$apellido_p',
        apellido_M='$apellido_M',
        puesto='$puesto',
        correo='$correo',
        telefono='$telefono',
        turno='$turno'
        WHERE id_veterinario=$id";

   if ($conexion->query($sqlUpdate) === TRUE) {
        $mensaje = "¡Veterinario actualizado con éxito!";
        $tipoMensaje = "exito";
    } else {
        $mensaje = "Error al actualizar: " . $conexion->error;
        $tipoMensaje = "error";
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
  <link rel="stylesheet" href="../CSS/actualizar.css">

  <!-- ICONOS -->
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
   
    <form method="post">
       <h1>Editar Veterinario</h1>
        <input type="hidden" name="id" value="<?php echo $veterinario['id_veterinario']; ?>">

        <!-- Nombre -->
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $veterinario['nombre']; ?>" required>

        <!-- Apellido Paterno -->
        <label for="apellido_p">Apellido Paterno:</label>
        <input type="text" id="apellido_p" name="apellido_p" value="<?php echo $veterinario['apellido_P']; ?>" required>

        <!-- Apellido Materno -->
        <label for="apellido_M">Apellido Materno:</label>
        <input type="text" id="apellido_M" name="apellido_M" value="<?php echo $veterinario['apellido_M']; ?>" required>

        <!-- Puesto como lista -->
        <label for="puesto">Puesto:</label>
        <select id="puesto" name="puesto" required>
            <option value="Veterinario General" <?php if($veterinario['puesto']=='Veterinario General') echo 'selected'; ?>>Veterinario General</option>
            <option value="Veterinario Especialista" <?php if($veterinario['puesto']=='Veterinario Especialista') echo 'selected'; ?>>Veterinario Especialista</option>
            <option value="Cirujano" <?php if($veterinario['puesto']=='Cirujano') echo 'selected'; ?>>Cirujano</option>
            <option value="Anestesiólogo" <?php if($veterinario['puesto']=='Anestesiólogo') echo 'selected'; ?>>Anestesiólogo</option>
            <option value="Dermatólogo" <?php if($veterinario['puesto']=='Dermatólogo') echo 'selected'; ?>>Dermatólogo</option>
        </select>

        <!-- Correo -->
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?php echo $veterinario['correo']; ?>" required>

        <!-- Teléfono -->
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo $veterinario['telefono']; ?>" required>

        <!-- Turno -->
        <label for="turno">Turno:</label>
        <select id="turno" name="turno" required>
            <option value="Matutino" <?php if($veterinario['turno']=='Matutino') echo 'selected'; ?>>Matutino</option>
            <option value="Vespertino" <?php if($veterinario['turno']=='Vespertino') echo 'selected'; ?>>Vespertino</option>
            <option value="Nocturno" <?php if($veterinario['turno']=='Nocturno') echo 'selected'; ?>>Nocturno</option>
        </select>

        <!-- Botones -->
        <button type="submit" class="btn-actualizar"><i class="fas fa-sync-alt"></i> Actualizar</button>
        <a href="mantener_veterinario.php"><i class="fas fa-arrow-left"></i> Cancelar</a>
    </form>
  </div>
</main>

<footer>
  <p>&copy; 2025 Veterinaria Super Pets</p>
  <p>Ramirez San Martin Angeles Valeria, Rositas Santiago Evelyn Johana</p>
</footer>
<script>
<?php if ($mensaje != ""): ?>
    let toast = document.getElementById("toast");
    toast.classList.add("show");
    setTimeout(() => {
        toast.classList.remove("show");
        window.location.href = "mantener_veterinario.php";
    }, 3000);
<?php endif; ?>

function toggleMenu() {
    document.getElementById('menu').classList.toggle('active');
}
</script>

</body>
</html>
<?php mysqli_close($conexion); ?>
