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

// Obtener datos del empleado por ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM empleados WHERE id = $id";
    $resultado = $conexion->query($sql);
    $empleado = $resultado->fetch_assoc();
}

// Actualizar datos del empleado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $apellido_P = $_POST['apellido_P'];
    $apellido_M = $_POST['apellido_M'];
    $puesto = $_POST['puesto'];
    $turno = $_POST['turno'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $fecha = $_POST['fecha'];

    $sqlUpdate = "UPDATE empleados SET 
        nombre='$nombre', 
        apellido_P='$apellido_P', 
        apellido_M='$apellido_M', 
        puesto='$puesto', 
        turno='$turno', 
        correo='$correo', 
        telefono='$telefono', 
        fecha='$fecha'
        WHERE id=$id";

    if ($conexion->query($sqlUpdate) === TRUE) {
        $mensaje = "¡Empleado actualizado con éxito!";
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
  <title>Editar Empleado</title>
<link rel="stylesheet" href="../CSS/actualizar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
.toast.exito { background: #28a745; }
.toast.error { background: #e63946; }
.toast.show { right: 20px; }
</style>
</head>
<body>

<!-- TOAST -->
<?php if ($mensaje != ""): ?>
<div id="toast" class="toast <?php echo $tipoMensaje; ?>">
    <?php echo $mensaje; ?>
</div>
<?php endif; ?>

<header>
<nav class="navbar">
    <div class="menu-icon" onclick="toggleMenu()"><i class="fas fa-bars"></i></div>
    <img src="../Imagenes/logo-sf.png">
    <div class="nav-links" id="menu">
      <a href="../codigos php/mantener_cliente.php"><i class="fas fa-user"></i> Cliente</a>
      <a href="../codigos php/mantener_servicio.php"><i class="fas fa-concierge-bell"></i> Servicios</a>
      <a href="../codigos php/mantener_veterinario.php"><i class="fas fa-stethoscope"></i> Veterinarios</a>
      <a href="../codigos php/mantener_empleado.php"><i class="fas fa-user-tie"></i> Empleados</a>
      <a href="../codigos php/mantener_mascota.php"><i class="fa-solid fa-paw"></i> Mascotas</a>
      <a href="../Paginas html/sesion.html"><i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión</a>
    </div>
</nav>
</header>

<form method="post" class="form-editar">
  <h1>Editar Empleado</h1>
  <input type="hidden" name="id" value="<?php echo $empleado['id']; ?>">

  <label>Nombre:</label>
  <input type="text" name="nombre" value="<?php echo $empleado['nombre']; ?>" required><br>

  <label>Apellido Paterno:</label>
  <input type="text" name="apellido_P" value="<?php echo $empleado['apellido_P']; ?>" required><br>

  <label>Apellido Materno:</label>
  <input type="text" name="apellido_M" value="<?php echo $empleado['apellido_M']; ?>" required><br>

  <label>Puesto:</label>
  <select name="puesto" required>
      <option value="Recepcionista" <?php if($empleado['puesto']=="Recepcionista") echo "selected"; ?>>Recepcionista</option>
      <option value="Estilista" <?php if($empleado['puesto']=="Estilista") echo "selected"; ?>>Estilista</option>
  </select><br>

  <label>Turno:</label>
  <select name="turno" required>
      <option value="Matutino" <?php if($empleado['turno']=="Matutino") echo "selected"; ?>>Matutino</option>
      <option value="Vespertino" <?php if($empleado['turno']=="Vespertino") echo "selected"; ?>>Vespertino</option>
      <option value="Nocturno" <?php if($empleado['turno']=="Nocturno") echo "selected"; ?>>Nocturno</option>
  </select><br>

  <label>Correo:</label>
  <input type="email" name="correo" value="<?php echo $empleado['correo']; ?>" required><br>

  <label>Teléfono:</label>
  <input type="text" name="telefono" value="<?php echo $empleado['telefono']; ?>" required><br>

  <label>Fecha de contratación:</label>
  <input type="date" name="fecha" value="<?php echo $empleado['fecha']; ?>" required><br>

  <button type="submit" class="btn-actualizar"><i class="fas fa-sync-alt"></i> Actualizar</button>
  <a href="mantener_empleado.php"><i class="fas fa-arrow-left"></i> Cancelar</a>
</form>

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
    }, 4000);
<?php endif; ?>

function toggleMenu() {
    document.getElementById('menu').classList.toggle('active');
}
</script>

</body>
</html>