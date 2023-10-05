<?php
include_once "db_connect.php";
session_start();
session_regenerate_id();


if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $query = "DELETE FROM clientes WHERE id=$id";
    $conexion = mysqli_connect($db_host, $db_user, $db_pass, $db_database);
    $resultset = mysqli_query($conexion, $query);
    if (!$resultset) {
        die("<p>Error en la consulta:$conexion->error, no se ha podido borrar el cliente especificado </p>\n</body>\n</html>");
    }
    $mensaje = "Cliente borrado exitosamente!!";
    echo "<meta http-equiv='refresh' content='0; url=panel.php?modulo=productos&mensaje=$mensaje'>";
}

?>