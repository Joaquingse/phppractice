<?php
include_once "db_connect.php";
session_start();
session_regenerate_id();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
  }
//ini_set("display_errors", 0);
//ini_set("display_startup_errors", 0);

$id = $_REQUEST["id"];
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_database);
if (mysqli_connect_errno()) {
    die("<p>Error de conexión Nº: " . mysqli_connect_errno() . " - " . mysqli_connect_error() . "</p>\n</body>\n</html>");
}

$query = "SELECT * FROM productos WHERE id=$id";
$resultset = mysqli_query($con, $query);
$product = mysqli_fetch_assoc($resultset);
if ($con->errno) {
    die("<p>Error en la consulta:$con->error </p>\n</body>\n</html>");
}

?>

<section class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6 mx-auto mt-4">
                <div class="card col-12">
                    <div class="card-header">
                        <h1>ELIMINAR PRODUCTO</h1>
                    </div>
                    <?php if ($product) { ?>
                        <div class="card-body col-12">
                            <h5 class="card-title mb-3">Producto:
                                <strong><?php print $product["nombre"] ?></strong>
                            </h5>
                            <p class="card-text">Va a eliminar el producto <em><strong
                                        style="color: grey;"><?php print $product["nombre"] ?></strong></em>
                                con precio<em><strong
                                        style="color: grey;"><?php print $product["precio"] ?></strong></em>
                                y cantidad <em><strong
                                        style="color: grey;"><?php print $product["cantidad"] ?></strong></em>,
                                ¿está seguro de la acción?</p>
                            <div class="d-grid gap-2 d-md-flex justify-content-between mr-2">
                                <a href="delproductFunction.php?id=<?php echo $product = $id; ?>"
                                    class="btn btn-primary">
                                    <i class="fas fa-trash mr-2"></i>Eliminar</a>
                                <a href="panel.php?modulo=productos" class="btn btn-danger"><i
                                        class="fas fa-ban mr-2"></i>Cancelar</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>