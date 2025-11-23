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
$tipoMensaje = ""; // Éxito o error para darle color

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM clientes WHERE id_cliente = $id";
    $resultado = $conexion->query($sql);
    $cliente = $resultado->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $apellido_p = $_POST['apellido_p'];
    $apellido_M = $_POST['apellido_M'];
    $correo = $_POST['correo'];
    $domicilio = $_POST['domicilio'];
    $telefono = $_POST['telefono'];

    $sqlUpdate = "UPDATE clientes SET 
        nombre='$nombre', 
        apellido_p='$apellido_p', 
        apellido_M='$apellido_M', 
        correo='$correo', 
        domicilio='$domicilio', 
        telefono='$telefono' 
        WHERE id_cliente=$id";

    if ($conexion->query($sqlUpdate) === TRUE) {
        $mensaje = "¡Cliente actualizado con éxito!";
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
  <title>Perfil Cliente</title>
<link rel="stylesheet" href="../CSS/actualizar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* TOAST (notificación flotante) */
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

.toast.exito {
    background-color: #28a745;
}

.toast.error {
    background-color: #e63946;
}

.toast.show {
    right: 20px;
}
</style>
</head>
<body>

<!-- NOTIFICACIÓN -->
<?php if ($mensaje != ""): ?>
<div id="toast" class="toast <?php echo $tipoMensaje; ?>">
  <?php echo $mensaje; ?>
</div>
<?php endif; ?>

<header>
  <nav class="navbar">
    <div class="menu-icon" onclick="toggleMenu()">
      <i class="fas fa-bars"></i>
    </div>
    
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

<form method="post">
   <h1>Editar Cliente</h1>
    <input type="hidden" name="id" value="<?php echo $cliente['id_cliente']; ?>">
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $cliente['nombre']; ?>"><br>
    <label>Apellido Paterno:</label>
    <input type="text" name="apellido_p" value="<?php echo $cliente['apellido_P']; ?>"><br>
    <label>Apellido Materno:</label>
    <input type="text" name="apellido_M" value="<?php echo $cliente['apellido_M']; ?>"><br>
    <label>Correo:</label>
    <input type="email" name="correo" value="<?php echo $cliente['correo']; ?>"><br>
    <label>Domicilio:</label>
    <input type="text" name="domicilio" value="<?php echo $cliente['domicilio']; ?>"><br>
    <label>Teléfono:</label>
    <input type="text" name="telefono" value="<?php echo $cliente['telefono']; ?>"><br>
    <button type="submit">Actualizar</button>
    <a href="mantener_cliente.php"><i class="fas fa-arrow-left"></i> Cancelar</a>
</form>

<footer>
  <p>&copy; 2025 Veterinaria Super Pets</p>
  <p>Ramirez San Martin Angeles Valeria, Rositas Santiago Evelyn Johana</p>
</footer>

<script>
// Mostrar notificación animada
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

<?php mysqli_close($conexion); ?>

</body>
</html>