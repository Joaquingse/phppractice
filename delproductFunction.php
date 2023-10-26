<?php
include_once "db_connect.php";
/* session_start();
session_regenerate_id(); */

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    //console_log($id);
    $query = "DELETE FROM productos WHERE id=$id;";
    //$con = mysqli_connect($db_host, $db_user, $db_pass, $db_database);
    //console_log($query);
    $resultset = mysqli_query($con, $query);
    if (!$resultset) {
        die("<p>Error en la consulta:$con->error, no se ha podido borrar el producto especificado </p>\n</body>\n</html>");
    }
    //console_log($resultset);
    $mensaje = "Producto borrado exitosamente!!";
    echo "<meta http-equiv='refresh' content='0; url=panel.php?modulo=productos&mensaje=$mensaje'>";
}

?>