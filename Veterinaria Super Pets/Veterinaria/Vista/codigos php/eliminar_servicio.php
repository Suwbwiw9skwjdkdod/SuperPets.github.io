<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "Veterinaria";

$conexion = mysqli_connect($server, $user, $pass, $db);
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitiza el ID
    $sql = "DELETE FROM servicio WHERE id_servicio = $id";

    if ($conexion->query($sql) === TRUE) {
        header("Location: mantener_servicio.php"); // Redirige a la lista de servicios
        exit();
    } else {
        echo "Error al eliminar: " . $conexion->error;
         echo" <div class='regresar'>
               <a href='mantener_servicio.php'>Regresar</a>
            </div>";
    }
}

$conexion->close();
?>