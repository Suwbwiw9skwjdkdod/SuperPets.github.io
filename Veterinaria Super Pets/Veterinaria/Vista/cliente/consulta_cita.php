<?php
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

// Sanitizar ID
$idCita = intval($idCita);

// Consultar datos de la cita
$sql = "SELECT * FROM citas WHERE id_cita = $idCita";
$resultado = mysqli_query($conexion, $sql);
$cita = mysqli_fetch_assoc($resultado);

if (!$cita) {
    die("No se encontró la cita.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Agendar Cita</title>
<link rel="stylesheet" href="../CSS/consulta_cliente.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">    
</head>
<body>

<header class="hero">
  <nav class="navbar">
     <div class="menu-icon" onclick="toggleMenu()">
      <i class="fas fa-bars"></i>
    </div>
   
    <img src="../Imagenes/logo-sf.png" class="logo">

    <a href="../cliente/perfil_cliente.php"><i class="fa-solid fa-house"></i>Inicio</a>
    <a href="../Paginas html/Servicios_Cliente.html"><i class="fa-solid fa-store"></i>Servicios</a>
    <a href="../Paginas html/Articulos_Cliente.html"><i class="fa-solid fa-paw"></i>Articulos</a>   
    <a href="../Paginas html/Citas_Cliente.html"><i class="fa-solid fa-cart-shopping"></i>Citas</a>
    <a href="../Paginas html/sesion.html"><i class="fa-solid fa-user"></i>Cerrar Sesion</a>
  </nav>
</header>



<section>
    <h2>Detalle de la Cita</h2>

    <p><strong>ID:</strong> <?php echo $cita['id_cita']; ?></p>
    <p><strong>Mascota:</strong> <?php echo $cita['nombreMascota']; ?></p>
    <p><strong>Raza:</strong> <?php echo $cita['raza']; ?></p>
    <p><strong>Servicio:</strong> <?php echo $cita['servicio']; ?></p>
    <p><strong>Fecha:</strong> <?php echo $cita['fechaCita']; ?></p>
    <p><strong>Horario:</strong> <?php echo $cita['horariosDisponibles']; ?></p>
    <p><strong>Motivo:</strong> <?php echo $cita['motivo']; ?></p>
</section>

<section>
    <a href="lista_citas.php">Regresar</a>
</section>

<footer>
    <p>&copy; 2025 Veterinaria Super Pets</p>
    <p>Ramirez San Martin Angeles Valeria, Rositas Santiago Evelyn Johana</p>
</footer>

</body>
</html>

<?php mysqli_close($conexion); ?>