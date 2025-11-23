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

// Obtener datos de la mascota por ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM mascotas WHERE id_mascota = $id";
    $resultado = $conexion->query($sql);
    $mascota = $resultado->fetch_assoc();
}

// Actualizar datos de la mascota
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $nombreMascota = $_POST['nombreMascota'];
    $especie = $_POST['especie'];
    $raza = $_POST['raza'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $sexo = $_POST['sexo'];
    $dueno = $_POST['dueno'];

    $sqlUpdate = "UPDATE mascotas SET 
        nombreMascota='$nombreMascota', 
        especie='$especie', 
        raza='$raza', 
        fechaNacimiento='$fechaNacimiento', 
        sexo='$sexo', 
        dueno='$dueno'
        WHERE id_mascota=$id";

    if ($conexion->query($sqlUpdate) === TRUE) {
        $mensaje = "¡Mascota actualizada con éxito!";
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
  <title>Editar Mascota</title>

  <link rel="stylesheet" href="../CSS/actualizar.css">
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

<form method="post">
    <h1>Editar Mascota</h1>
    <input type="hidden" name="id" value="<?php echo $mascota['id_mascota']; ?>">

    <label>Nombre:</label>
    <input type="text" name="nombreMascota" value="<?php echo $mascota['nombreMascota']; ?>" required><br>

    <label>Especie:</label>
<select name="especie" id="especie" required>
    <option value="Perro" <?php if($mascota['especie'] == 'Perro') echo 'selected'; ?>>Perro</option>
    <option value="Gato" <?php if($mascota['especie'] == 'Gato') echo 'selected'; ?>>Gato</option>
    <option value="Ave" <?php if($mascota['especie'] == 'Ave') echo 'selected'; ?>>Ave</option>
</select><br>

<label>Raza:</label>
<select name="raza" id="raza" required>
</select><br>

    <label>Fecha de Nacimiento:</label>
    <input type="date" name="fechaNacimiento" value="<?php echo $mascota['fechaNacimiento']; ?>" required><br>

    <label>Sexo:</label>
<select name="sexo" required>
    <option value="Macho" <?php if($mascota['sexo'] == 'Macho') echo 'selected'; ?>>Macho</option>
    <option value="Hembra" <?php if($mascota['sexo'] == 'Hembra') echo 'selected'; ?>>Hembra</option>
</select><br>

<label>Dueño:</label>
<select name="dueno" required>
<?php
$sqlClientes = "SELECT id_cliente, nombre, apellido_p FROM clientes";
$resultClientes = $conexion->query($sqlClientes);

if ($resultClientes->num_rows > 0) {
    while ($cliente = $resultClientes->fetch_assoc()) {
        $nombreCompleto = $cliente['nombre'] . " " . $cliente['apellido_p'];
        $selected = ($mascota['dueno'] == $nombreCompleto) ? 'selected' : '';
        echo "<option value='{$nombreCompleto}' $selected>{$nombreCompleto}</option>";
    }
} else {
    echo "<option value=''>No hay clientes registrados</option>";
}
?>
</select><br>

<button type="submit" class="btn-actualizar"><i class="fas fa-sync-alt"></i> Actualizar</button>
<a href="mantener_mascota.php"><i class="fas fa-arrow-left"></i> Cancelar</a>
</form>

<footer>
  <p>&copy; 2025 Veterinaria Super Pets</p>
  <p>Ramirez San Martin Angeles Valeria, Rositas Santiago Evelyn Johana</p>
</footer>

<script>
// Mostrar notificación
<?php if ($mensaje != ""): ?>
    let toast = document.getElementById("toast");
    toast.classList.add("show");
    setTimeout(() => {
        toast.classList.remove("show");
        window.location.href = "mantener_mascota.php";
    }, 3000);
<?php endif; ?>

function toggleMenu() {
    document.getElementById('menu').classList.toggle('active');
}
</script>
<!--Evaluacion de la opcion de razas-->
<script>
    const razaSelect = document.getElementById('raza');
    const especieSelect = document.getElementById('especie');

    // Listas de razas por especie
    const razas = {
        Perro: ["Labrador", "Bulldog", "Chihuahua", "Pastor Alemán"],
        Gato: ["Persa", "Siamés", "Maine Coon", "Bengalí"],
        Ave: ["Canario", "Periquito", "Loro", "Cacatúa"]
    };

    // Función para actualizar las opciones de raza
    function actualizarRazas() {
        const especieSeleccionada = especieSelect.value;
        razaSelect.innerHTML = ""; // Limpiar opciones

        if (razas[especieSeleccionada]) {
            razas[especieSeleccionada].forEach(raza => {
                const option = document.createElement('option');
                option.value = raza;
                option.textContent = raza;
                razaSelect.appendChild(option);
            });
        }
    }

    // Inicializar con la especie actual
    actualizarRazas();

    // Actualizar cuando cambie la especie
    especieSelect.addEventListener('change', actualizarRazas);
</script>

</body>
</html>