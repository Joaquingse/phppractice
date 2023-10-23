<?php
include_once "db_connect.php";

//para pruebas en local
/* session_start();
session_regenerate_id();
if (!isset($_SESSION['username'])) {
  header('Location: index.php');
  exit();
}  */
//funcion para sacar por consola mensages

ini_set("display_errors", 0);
ini_set("display_startup_errors", 0);

//anula los reportes de error de mysql
//mysqli_report(MYSQLI_REPORT_OFF);

//$con = mysqli_connect($db_host, $db_user, $db_pass, $db_database);
$id = $_REQUEST["id"];
if (mysqli_connect_errno()) {
  die("<p>Error de conexión Nº: " . mysqli_connect_errno() . " - " . mysqli_connect_error() . "</p>\n</body>\n</html>");
}
if ($con->connect_errno) {
  die("<p>Error de conexión Nº: $con->connect_errno - $con->connect_error</p>\n</body>\n</html>");
}

$query = "SELECT * FROM clientes WHERE id= $id";
$resultset = mysqli_query($con, $query);
if ($con->errno) {
  die("<p>Error en la consulta:$con->error </p>\n</body>\n</html>");
}

if (isset($_POST['edit_client'])) {
  //$con = mysqli_connect($db_host, $db_user, $db_pass, $db_database);
  $nombre = sanitizar($con, $_POST['nombre']);
  $apellido = sanitizar($con, $_POST['apellido']);
  $email = sanitizar($con, $_POST['email']);
  $clave = sanitizar($con, $_POST['clave']);
  $dni = sanitizar($con, $_POST['dni']);
  $query = "UPDATE clientes 
        SET nombre='$nombre', apellido='$apellido', email='$email', clave=md5('$clave'), dni='$dni',  
        WHERE id=$id";
  if (mysqli_connect_errno()) {
    die("<p>Error de conexión Nº: " . mysqli_connect_errno() . " - " . mysqli_connect_error() . "</p>\n</body>\n</html>");
  }
  $resultset = mysqli_query($con, $query);

  if ($con->errno) {
    die("<p>Error en la consulta:$con->error </p>\n</body>\n</html>");
  }
  print "<meta http-equiv='refresh' content='0; url=panel.php?modulo=clientes' ";

}
?>

<section class="content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-md-8 mx-auto mt-4">
        <div class="card col-12">
          <div class="card-header">
            <h1>EDITAR CLIENTE</h1>
          </div>
          <div class="card-body col-12">
            <form action="" method="post">
              <?php
              while ($row = mysqli_fetch_assoc($resultset)) {
                ?>
                <div class="mb-3">
                  <label class="form-label col-12">Nombre:
                    <input type="text" class="form-control" name="nombre"
                      value="<?php print $row["nombre"] ?>">
                  </label>
                </div>
                <div class="mb-3">
                  <label class="form-label col-12">Apellido:
                    <input type="text" class="form-control" name="apellido"
                      value="<?php print $row["apellido"] ?>">
                  </label>
                </div>
                <div class="mb-3">
                  <label class="form-label col-12">Email:
                    <input type="email" class="form-control" name="email"
                      value="<?php print $row["email"] ?>">
                  </label>
                </div>
                <div class="mb-3">
                  <label class="form-label col-12">Password:
                    <input type="password" class="form-control" name="clave"
                      value="<?php print $row["clave"] ?>">
                  </label>
                </div>
                <div class="mb-3 col-6">
                  <label class="form-label"> Dni:
                    <input type="text" class="form-control" name="dni"
                      value="<?php print $row["dni"] ?>">
                  </label>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-between mb-3">
                  <button type="submit" class="btn btn-primary" name="edit_client"><i
                      class="fas fa-save mr-2"></i>Save</button>
                  <a href="panel.php?modulo=clientes" class="btn btn-danger" name="go_back"><i
                      class="fas fa-ban mr-2"></i>Cancelar</a>
                </div>
              <?php } ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>