<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "Veterinaria");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consulta para obtener todas las citas
$sql = "SELECT id_cita, nombreMascota, servicio, fechaCita, horariosDisponibles, motivo, raza FROM citas";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Agendar Cita</title>
<link rel="stylesheet" href="../CSS/lista_citas.css">
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

<!-- TÍTULO -->
<h1>Gestión de Citas</h1>

<!-- Barra superior -->
<div class="top-bar">
    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Buscar por nombre de mascota...">
    </div>
</div>

<!-- Tabla de citas -->
<table id="citasTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Mascota</th>
            <th>Servicio</th>
            <th>Fecha</th>
            <th>Horario</th>
            <th>Motivo</th>
            <th>Raza</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>
                    <td>{$fila['id_cita']}</td>
                    <td>{$fila['nombreMascota']}</td>
                    <td>{$fila['servicio']}</td>
                    <td>{$fila['fechaCita']}</td>
                    <td>{$fila['horariosDisponibles']}</td>
                    <td>{$fila['motivo']}</td>
                    <td>{$fila['raza']}</td>
                    <td>

                         <a href='consulta_cita.php?id={$fila['id_cita']}' class='btn-edit'>
                           <i class='fa-solid fa-eye'></i>
                        </a>


                        <a href='editar_cita.php?id={$fila['id_cita']}' class='btn-edit'>
                            <i class='fas fa-edit'></i>
                        </a>
                        

                        <a href='#' class='btn-delete'
                           onclick=\"mostrarModal('eliminar_cita.php?id={$fila['id_cita']}')\">
                           <i class='fas fa-trash-alt'></i>
                        </a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No hay citas registradas</td></tr>";
    }
    ?>
    </tbody>
</table>

<!-- BOTÓN REGRESAR -->
<div class="back-button" style="margin: 15px;">
   <a href="../Paginas html/Citas_Cliente.html"><i class="fas fa-arrow-left"></i> Regresar</a>
</div>

<!-- FOOTER -->
<footer>
    <p>&copy; 2025 Veterinaria Super Pets</p>
    <p>Ramirez San Martin Angeles Valeria, Rositas Santiago Evelyn Johana</p>
</footer>

<script>
    // Filtro por nombre
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#citasTable tbody tr');

        rows.forEach(row => {
            let nombre = row.cells[1].textContent.toLowerCase();
            row.style.display = nombre.includes(filter) ? '' : 'none';
        });
    });

    // Menú desplegable
    function toggleMenu() {
        const menu = document.getElementById('menu');
        menu.classList.toggle('active');
    }
</script>

<!-- Modal de confirmación -->
<div class="modal" id="modal" style="display: none;">
  <div class="modal-content">
    <h2>¿Estás seguro de que quieres cancelar la cita?</h2>
    <div style="margin-top: 15px;">
      <button id="btnAceptar">Aceptar</button>
      <button onclick="cerrarModal()">Cancelar</button>
    </div>
  </div>
</div>

<script>
let urlEliminar = "";

// Mostrar modal
function mostrarModal(url) {
    urlEliminar = url;
    document.getElementById('modal').style.display = 'flex';
}

// Cerrar modal
function cerrarModal() {
    document.getElementById('modal').style.display = 'none';
}

// Aceptar eliminación
document.getElementById('btnAceptar').addEventListener('click', function() {
    window.location.href = urlEliminar;
});
</script>

</body>
</html>

<?php
$conexion->close();
?>