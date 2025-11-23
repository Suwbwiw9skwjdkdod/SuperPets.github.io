
<?php
session_start();

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: sesion.html");
    exit();
}

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "Veterinaria");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$correo = $_SESSION['usuario'];

// Consulta datos del cliente
$sql_cliente = "SELECT id_cliente, nombre, apellido_P, apellido_M, correo, domicilio, telefono 
                FROM clientes WHERE correo = '$correo'";
$result_cliente = mysqli_query($conexion, $sql_cliente);

if ($result_cliente && mysqli_num_rows($result_cliente) > 0) {
    $cliente = mysqli_fetch_assoc($result_cliente);
    $id_cliente = $cliente['id_cliente'];
} else {
    echo "No se encontraron datos del cliente.";
    exit();
}

// Consulta mascotas del cliente (todas las que estén registradas con su ID)
$sql_mascotas = "SELECT nombreMascota, especie, raza, fechaNacimiento, sexo 
                 FROM mascotas WHERE id_cliente = $id_cliente";
$result_mascotas = mysqli_query($conexion, $sql_mascotas);

// Contar cuántas mascotas tiene
$total_mascotas = ($result_mascotas) ? mysqli_num_rows($result_mascotas) : 0;

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil Cliente</title>

  <!-- CSS -->
  <link rel="stylesheet" href="../CSS/perfil_cliente.css">

  <!-- FontAwesome -->
  <link rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<header>
  <nav class="navbar">
    
    <div class="menu-icon" onclick="toggleMenu()">
      <i class="fas fa-bars"></i>
    </div>

    <img src="../Imagenes/logo-sf.png" alt="Logo">

      <a href="../Paginas html/Servicios_Cliente.html"><i class="fa-solid fa-store"></i>Servicios</a>
      <a href="../Paginas html/Citas_Cliente.html"><i class="fa-solid fa-cart-shopping"></i>Citas</a>
      <a href="../Paginas html/Articulos_Cliente.html"><i class="fa-solid fa-paw"></i>Articulos</a>  
      <a></a>
      <a></a>
      <a href="../Paginas html/sesion.html"><i class="fa-solid fa-user"></i>Cerrar Sesion</a>
    </div>
  </nav>
</header>

<section class="hero">
  <h1>¡Bienvenido, <?php echo $cliente['nombre']; ?>!</h1>
</section>

<main class="profile-container">
  <div class="profile-card">
    
    <h2>
      <?php 
      echo $cliente['nombre'] . ' ' . $cliente['apellido_P'] . ' ' . $cliente['apellido_M']; 
      ?>
    </h2>

    <p><strong>ID:</strong> <?php echo $cliente['id_cliente']; ?></p>
    <p><strong>Correo:</strong> <?php echo $cliente['correo']; ?></p>
    <p><strong>Teléfono:</strong> <?php echo $cliente['telefono']; ?></p>
    <p><strong>Dirección:</strong> <?php echo $cliente['domicilio']; ?></p>
  </div>

  <div class="mascotas-card">
    <h3>Tus Mascotas (<?php echo $total_mascotas; ?>):</h3>
    <?php
    if ($total_mascotas > 0) {
        echo "<ul>";
        while ($mascota = mysqli_fetch_assoc($result_mascotas)) {
            echo "<li><strong>" . htmlspecialchars($mascota['nombreMascota']) . "</strong> - " 
                 . htmlspecialchars($mascota['especie']) . " (" . htmlspecialchars($mascota['raza']) 
                 . "), Nacimiento: " . htmlspecialchars($mascota['fechaNacimiento']) 
                 . ", Sexo: " . htmlspecialchars($mascota['sexo']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No tienes mascotas registradas.</p>";
    }
    ?>
  </div>
</main>

<footer>
  <p>&copy; 2025 Veterinaria Super Pets</p>
  <p>Ramirez San Martin Angeles Valeria, Rositas Santiago Evelyn Johana</p>
</footer>

<script>
  function toggleMenu() {
    const menu = document.getElementById('menu');
    menu.classList.toggle('null');
  }
</script>

</body>
</html>

