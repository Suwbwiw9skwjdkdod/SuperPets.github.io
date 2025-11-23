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

// Consulta para obtener todos los empleados
$sql = "SELECT id, nombre, apellido_P, apellido_M, puesto, turno, correo, telefono, fecha FROM empleados";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil Administrador</title>

  <!-- CSS SEPARADO -->
  <link rel="stylesheet" href="../CSS/tablas.css">

  <!-- ICONOS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">    
<style>
/* ------------------- MODAL ------------------- */
.modal {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    opacity: 0;
    transition: opacity .3s ease;
}

.modal.show {
    display: flex;
    opacity: 1;
}

.modal-content {
    background: white;
    padding: 25px;
    border-radius: 10px;
    width: 350px;
    text-align: center;
    animation: aparecer 0.3s ease;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
}

@keyframes aparecer {
    from { transform: scale(0.8); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.modal-content h2 {
    font-size: 18px;
    margin-bottom: 20px;
}

.modal-content button {
    margin: 10px;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    border-radius: 6px;
    font-size: 16px;
    color: white;
}

.btn-cancelar {
    background: #d62828;
}

.btn-eliminar {
    background: #2a9d8f;
}
</style>
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
      <a href="mantener_cliente.php" target="_blank"><i class="fas fa-user"></i> Cliente</a>
      <a href="mantener_servicio.php" target="_blank"><i class="fas fa-concierge-bell"></i> Servicios</a>
      <a href="mantener_veterinario.php" target="_blank"><i class="fas fa-stethoscope"></i> Veterinarios</a>
      <a href="mantener_mascota.php" target="_blank"><i class="fa-solid fa-paw"></i> Mascotas</a>
      <a href="../Paginas html/sesion.html" target="_blank"><i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión</a>
    </div>
  </nav>
</header>

<!-- CONTENIDO -->
<h1>Gestión de Empleados</h1>

<!-- Barra superior -->
<div class="top-bar">
  <a href="../Paginas html/Empleado.html"><i class="fas fa-user-plus"></i> Agregar Empleado</a>
    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Buscar por nombre...">
    </div>
</div>

<!-- Tabla de empleados -->
<table id="empleadosTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Puesto</th>
            <th>Turno</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>
                    <td>{$fila['id']}</td>
                    <td>{$fila['nombre']}</td>
                    <td>{$fila['apellido_P']}</td>
                    <td>{$fila['apellido_M']}</td>
                    <td>{$fila['puesto']}</td>
                    <td>{$fila['turno']}</td>
                    <td>{$fila['correo']}</td>
                    <td>{$fila['telefono']}</td>
                    <td>{$fila['fecha']}</td>
                    <td>
                        <a href='editar_empleado.php?id={$fila['id']}' class='btn-edit'>
                            <i class='fas fa-edit'></i>
                        </a>
                     <button class='btn-delete' onclick='confirmarEliminacion({$fila['id']})'>
                        <i class='fas fa-trash-alt'></i>
                    </button>

                    </td>
                  </tr>";
        }
   } else {
    echo "<tr><td colspan='10'>No hay empleados registrados</td></tr>";
}
    ?>
    </tbody>
</table>

<!-- MODAL DE CONFIRMACIÓN -->
<div class="modal" id="modalConfirmacion">
    <div class="modal-content">
        <h2>¿Estás seguro de que deseas eliminar el registro?</h2>
        <button class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
        <button class="btn-eliminar" id="btnEliminar">Eliminar</button>
    </div>
</div>

<script>
// Filtro por nombre
document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#empleadosTable tbody tr');

    rows.forEach(row => {
        let nombre = row.cells[1].textContent.toLowerCase();
        row.style.display = nombre.includes(filter) ? '' : 'none';
    });
});

// Menú responsive
function toggleMenu() {
    document.getElementById('menu').classList.toggle('active');
}

// Modal
let modal = document.getElementById('modalConfirmacion');
let btnEliminar = document.getElementById('btnEliminar');
let idEmpleado = null;

// Mostrar modal
function confirmarEliminacion(id) {
    idEmpleado = id;
    modal.style.display = 'flex';
    setTimeout(() => modal.classList.add("show"), 10);
}

// Cerrar modal
function cerrarModal() {
    modal.classList.remove("show");
    setTimeout(() => modal.style.display = 'none', 300);
}

// Cerrar si se da clic fuera
window.onclick = function(event) {
    if (event.target == modal) {
        cerrarModal();
    }
};

// Confirmar eliminación
btnEliminar.addEventListener('click', function() {
    window.location.href = 'eliminar_empleado.php?id=' + idEmpleado;
});
</script>

<div class="back-button" style="margin:15px;">
<a href=" ../Paginas html/administrador.html"><i class="fas fa-arrow-left"></i> Regresar</a>
</div>

<footer>
  <p>&copy; 2025 Veterinaria Super Pets</p>
  <p>Ramirez San Martin Angeles Valeria, Rositas Santiago Evelyn Johana</p>
</footer>

</body>
</html>

<?php
$conexion->close();
?>
