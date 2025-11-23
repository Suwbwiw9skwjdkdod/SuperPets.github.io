<?php
session_start();
$mensaje = "";

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "Veterinaria");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener ID de la cita desde la URL
$idCita = $_GET['id'] ?? null;
if (!$idCita) {
    die("ID de cita no proporcionado.");
}

// Consultar datos de la cita
$sql = "SELECT * FROM citas WHERE id_cita = $idCita";
$resultado = mysqli_query($conexion, $sql);
$cita = mysqli_fetch_assoc($resultado);

// Procesar actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id_cita'];
    $nombreMascota = $_POST['nombreMascota'];
    $raza = $_POST['raza'];
    $servicio = $_POST['servicio'];
    $fechaCita = $_POST['fechaCita'];
    $horariosDisponibles = $_POST['horariosDisponibles'];
    $motivo = $_POST['motivo'];

    $sqlUpdate = "UPDATE citas SET 
        nombreMascota='$nombreMascota',
        raza='$raza',
        servicio='$servicio',
        fechaCita='$fechaCita',
        horariosDisponibles='$horariosDisponibles',
        motivo='$motivo'
        WHERE id_cita = $id";

    if (mysqli_query($conexion, $sqlUpdate)) {
        $mensaje = "¡Cita actualizada con éxito!";

        // Actualizar valores mostrados
        $cita = [
            'id_cita' => $id,
            'nombreMascota' => $nombreMascota,
            'raza' => $raza,
            'servicio' => $servicio,
            'fechaCita' => $fechaCita,
            'horariosDisponibles' => $horariosDisponibles,
            'motivo' => $motivo
        ];
    } else {
        $mensaje = "Error al actualizar: " . mysqli_error($conexion);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Cita</title>
<link rel="stylesheet" href="../CSS/citas_cliente.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
.modal {
    position: fixed; top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex; justify-content: center; align-items: center;
}
.modal-content {
    background: #fff; padding: 20px; border-radius: 8px; text-align: center;
}
button { margin: 5px; padding: 10px 15px; }
</style>

</head>
<body>

<header class="hero">
  <nav class="navbar">
    <img src="../Imagenes/logo-sf.png" class="logo">

    <a href="../cliente/perfil_cliente.php"><i class="fa-solid fa-house"></i> Inicio</a>
    <a href="../Paginas html/Servicios_Cliente.html"><i class="fa-solid fa-store"></i> Servicios</a>
    <a href="../Paginas html/Articulos_Cliente.html"><i class="fa-solid fa-paw"></i> Artículos</a>
    <a href="../Paginas html/Citas_Cliente.html"><i class="fa-solid fa-cart-shopping"></i> Citas</a>
    <a href="../Paginas html/sesion.html"><i class="fa-solid fa-user"></i> Cerrar Sesión</a>
  </nav>
</header>



<form method="post" class="form-cita">

    <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">
    <h1>Editar Cita</h1>

    <label>Mascota:</label>
    <input type="text" name="nombreMascota" value="<?php echo $cita['nombreMascota']; ?>" required>

    <label>Raza:</label>
    <input type="text" name="raza" value="<?php echo $cita['raza']; ?>" required>

    <label>Servicio:</label>
    <input type="text" name="servicio" value="<?php echo $cita['servicio']; ?>" required>

    <label>Fecha:</label>
    <input type="date" name="fechaCita" value="<?php echo $cita['fechaCita']; ?>" required>

    <label>Horario:</label>
    <input type="text" name="horariosDisponibles" value="<?php echo $cita['horariosDisponibles']; ?>" required>

    <label>Motivo:</label>
    <input type="text" name="motivo" value="<?php echo $cita['motivo']; ?>" required>

    <button type="submit">Actualizar</button>

</form>

<footer>
  <p>&copy; 2025 Veterinaria Super Pets</p>
  <p>Ramirez San Martin Angeles Valeria, Rositas Santiago Evelyn Johana</p>
</footer>

<!-- MODAL -->
<div class="modal" id="modal" style="display: <?php echo $mensaje ? 'flex' : 'none'; ?>;">
  <div class="modal-content">
    <h2><?php echo $mensaje; ?></h2>
    <button onclick="document.getElementById('modal').style.display='none'">Aceptar</button>
  </div>
</div>

</body>
</html>

<?php mysqli_close($conexion); ?>