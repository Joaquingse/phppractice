<?php
//importamos los datos para conectar desde el fichero db_connect.php
include_once "db_connect.php";

//para pruebas en local
session_start();
session_regenerate_id();
if (!isset($_SESSION['username'])) {
  header('Location: index.php');
  exit();
} 
//impide mostrar los errores del sistema
//ini_set("display_errors", 0);
//ini_set("display_startup_errors", 0);

//anula los reportes de error de mysql
//mysqli_report(MYSQLI_REPORT_OFF);

//creamos el objeto para la conexión
//$con = mysqli_connect($db_host, $db_user, $db_pass, $db_database);
$id = $_REQUEST["id"];
//creamos un if para los errores de conexión
//Personalizamos el mensaje de error
if (mysqli_connect_errno()) {
  //die mata el proceso y muestra el error que queremos nosotros 
  die("<p>Error de conexión Nº: " . mysqli_connect_errno() . " - " . mysqli_connect_error() . "</p>\n</body>\n</html>");
}


$query = "SELECT * FROM usuarios WHERE id= $id";
$resultset = mysqli_query($con, $query);
if ($con->errno) {
  die("<p>Error en la consulta:$con->error </p>\n</body>\n</html>");
}
if (isset($_POST['edit_user'])) {
  $nombre = sanitizar($con, $_POST['nombre']);
  $email = sanitizar($con, $_POST['email']);
  $clave = sanitizar($con, $_POST['clave']);
  $tipo = sanitizar($con, $_POST['tipo']);
  //$con = mysqli_connect($db_host, $db_user, $db_pass, $db_database);
  $query = "UPDATE usuarios SET nombre='$nombre', email='$email', clave=md5('$clave'), tipo='$tipo' WHERE id=$id";
  if (mysqli_connect_errno()) {
    die("<p>Error de conexión Nº: " . mysqli_connect_errno() . " - " . mysqli_connect_error() . "</p>\n</body>\n</html>");
  }

  $resultset = mysqli_query($con, $query);

  if ($con->errno) {
    die("<p>Error en la consulta:$con->error </p>\n</body>\n</html>");
  }
  print "<meta http-equiv='refresh' content='0; url=panel.php?modulo=usuarios'> ";

}

?>
<section class="content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-md-8 mx-auto mt-4">
        <div class="card col-12">
          <div class="card-header">
            <h1>EDITAR USUARIO</h1>
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
                <!-- <div class="mb-3 ml-2">
                  <label class="form-label"> Tipo:
                    <input type="text" class="form-control" name="tipo" value="<?php print $row["tipo"] ?>">
                  </label>
                </div> -->
                <div class="mb-3 form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="tipo"
                      value="<?php print $row["tipo"] = 'empleado' ?>">
                    Empleado
                  </label>
                </div>
                <div class="mb-3 form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="tipo"
                      value="<?php print $row["tipo"] = 'administrador' ?>">
                    Administrador
                  </label>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-between mr-2">
                  <button type="submit" class="btn btn-primary" name="edit_user"><i
                      class="fas fa-save mr-2"></i>Guardar</button>
                  <a href="panel.php?modulo=usuarios" class="btn btn-danger"><i
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