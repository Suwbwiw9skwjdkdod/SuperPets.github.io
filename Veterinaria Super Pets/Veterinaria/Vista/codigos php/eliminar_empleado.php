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
    $sql = "DELETE FROM empleados WHERE id = $id";

    if ($conexion->query($sql) === TRUE) {
        header("Location: mantener_empleado.php"); // Redirige a la lista de empleados
        exit();
    } else {
        echo "Error al eliminar: " . $conexion->error;
         echo" <div class='regresar'>
               <a href='mantener_empleado.php'>Regresar</a>
            </div>";
    }
}

$conexion->close();
?>