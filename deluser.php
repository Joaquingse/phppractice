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
$conexion = mysqli_connect($db_host, $db_user, $db_pass, $db_database);
if (mysqli_connect_errno()) {
  die("<p>Error de conexión Nº: " . mysqli_connect_errno() . " - " . mysqli_connect_error() . "</p>\n</body>\n</html>");
}

$query = "SELECT * FROM usuarios WHERE id=$id";
$resultset = mysqli_query($conexion, $query);
$user = mysqli_fetch_assoc($resultset);
$mensaje = "Usuario eliminado correctamente.";
if ($conexion->errno) {
  die("<p>Error en la consulta:$conexion->error </p>\n</body>\n</html>");
}

?>

<section class="content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-md-6 mx-auto mt-4">
        <div class="card col-12">
          <div class="card-header">
            <h1>ELIMINAR USUARIO</h1>
          </div>
          <?php if ($user) { ?>
            <div class="card-body col-12">
              <h5 class="card-title mb-3">Nombre de usuario:
                <strong><?php print $user["nombre"] ?></strong>
              </h5>
              <p class="card-text">Va a eliminar al usuario <em><strong
                    style="color: grey;"><?php print $user["nombre"] ?></strong></em> con correo
                electrónico <em><strong
                    style="color: grey;"><?php print $user["email"] ?></strong></em>
                y tipo <em><strong style="color: grey;"><?php print $user["tipo"] ?></strong></em>,
                ¿está seguro de la acción?</p>
              <div class="d-grid gap-2 d-md-flex justify-content-between mr-2">
                <a href="deluserFunction.php?id=<?php echo $user['id'] ?>" class="btn btn-primary">
                  <i class="fas fa-trash mr-2"></i>Eliminar</a>
                <a href="panel.php?modulo=usuarios" class="btn btn-danger"><i
                    class="fas fa-ban mr-2"></i>Cancelar</a>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>