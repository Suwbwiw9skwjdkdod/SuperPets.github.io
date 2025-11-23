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
    $id = intval($_GET['id']);
    $sql = "DELETE FROM clientes WHERE id_cliente = $id";

    if ($conexion->query($sql) === TRUE) {
        header("Location: mantener_cliente.php"); // Redirige a la tabla
        exit();
    } else {
        echo "Error al eliminar: " . $conexion->error;
         echo" <div class='regresar'>
               <a href='mantener_cliente.php'>Regresar</a>
            </div>";
        
    }
}

$conexion->close();
?>
