<?php
session_start();
$mensaje = "";

// --- EJEMPLO: el ID del dueño debe existir en la sesión ---
$idDueno = $_SESSION['id_cliente'] ?? 1;

// Conexión a base de datos (se necesita antes del formulario)
$conexion = mysqli_connect("localhost", "root", "", "Veterinaria");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

/* =====================================================
   1) OBTENER MASCOTAS DEL DUEÑO (para autocompletar)
   ===================================================== */
$sqlMascotas = "SELECT nombreMascota FROM mascotas WHERE id_cliente = $idDueno";
$mascotas = mysqli_query($conexion, $sqlMascotas);

/* =====================================================
   2) OBTENER SERVICIOS (para autocompletar)
   ===================================================== */
$sqlServicio = "SELECT nombreServicio FROM servicio";
$servicios = mysqli_query($conexion, $sqlServicio);


/* =====================================================
   3) PROCESAR FORMULARIO
   ===================================================== */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombreMascota = $_POST['nombreMascota'];
    $servicio = $_POST['servicio'];
    $fechaCita = $_POST['fechaCita'];
    $horariosDisponibles = $_POST['horariosDisponibles'];
     $motivo = $_POST['motivo'];
$raza = $_POST['raza'];

   $sql = "INSERT INTO citas (nombreMascota, servicio, fechaCita, horariosDisponibles, motivo, raza)
        VALUES ('$nombreMascota', '$servicio', '$fechaCita', '$horariosDisponibles', '$motivo', '$raza')";

    if ($conexion->query($sql) === TRUE) {
        $mensaje = "¡Cita registrada con éxito!";
    } else {
        $mensaje = "Error al registrar: " . $conexion->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Agendar Cita</title>
<link rel="stylesheet" href="../CSS/citas_cliente.css">
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


<!-- FORMULARIO -->
<form method="post" class="form-cita">

<h1>Agendar Nueva Cita</h1>
    <!-- CAMPO MASCOTA CON BÚSQUEDA PREDICTIVA -->
    <label>Mascota:</label>
    <input list="listaMascotas" name="nombreMascota" required>
    <datalist id="listaMascotas">
        <?php
        if ($mascotas && $mascotas->num_rows > 0) {
            while ($fila = $mascotas->fetch_assoc()) {
                echo "<option value='{$fila['nombreMascota']}'>";
            }
        }
        ?>
    </datalist>


    <!-- Campo Raza con búsqueda predictiva -->
<label>Raza:</label>
<input list="listaRazas" name="raza" required>
<datalist id="listaRazas">
    <?php
    // Consulta para obtener razas desde la tabla mascotas
    $sqlRazas = "SELECT DISTINCT raza FROM mascotas";
    $razas = mysqli_query($conexion, $sqlRazas);
    if ($razas && $razas->num_rows > 0) {
        while ($fila = $razas->fetch_assoc()) {
            echo "<option value='{$fila['raza']}'>";
        }
    }
    ?>
</datalist>


    <!-- CAMPO SERVICIO CON BÚSQUEDA PREDICTIVA -->
    <label>Servicio:</label>
    <input list="listaServicios" name="servicio" required>
    <datalist id="listaServicios">
        <?php
        if ($servicios && $servicios->num_rows > 0) {
            while ($fila = $servicios->fetch_assoc()) {
                echo "<option value='{$fila['nombreServicio']}'>";
            }
        }
        ?>
    </datalist>

    <label>Fecha:</label>
    <input type="date" name="fechaCita" required>

    
<!-- Campo Motivo -->
<label>Motivo:</label>
<input type="text" name="motivo" placeholder="Describe el motivo" required>


    <label>Horario:</label>
    <select name="horariosDisponibles" required>
        <?php 
        for ($h = 8; $h <= 21; $h++) {
            $hora = str_pad($h, 2, "0", STR_PAD_LEFT) . ":00";
            echo "<option value='$hora'>$hora</option>";
        }
        ?>
    </select>


   

    <button type="submit" class="btn-agendar">Agendar</button>
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