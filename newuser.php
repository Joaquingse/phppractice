<?php
include_once "db_connect.php";

//para pruebas en local
session_start();
session_regenerate_id();
if (!isset($_SESSION['username'])) {
  header('Location: index.php');
  exit();
}

if (isset($_POST['enviar_form'])) {
  //$con = mysqli_connect($db_host, $db_user, $db_pass, $db_database);
  $nombre = sanitizar($con, $_POST['nombre']);
  $email = sanitizar($con, $_POST['email']);
  $clave = sanitizar($con, $_POST['clave']);
  $tipo = sanitizar($con, $_POST['tipo']);
  $query = "INSERT INTO usuarios (nombre, email, clave, tipo) VALUES ('$nombre', '$email', md5('$clave'), '$tipo')";
  if (mysqli_connect_errno()) {
    die("<p>Error de conexión Nº: " . mysqli_connect_errno() . " - " . mysqli_connect_error() . "</p>\n</body>\n</html>");
  }

  $resultset = mysqli_query($con, $query);

  if ($con->errno) {
    echo "<p>Error en la consulta:$con->error </p>\n</body>\n</html>";
    die("<p>Error en la consulta:$con->error </p>\n</body>\n</html>");
  }
  print "<meta http-equiv='refresh' content='0; url=panel.php?modulo=usuarios' ";

}
?>

<section class="content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-md-8 mx-auto mt-4">
        <div class="card">
          <div class="card-header">
            <h1>NUEVO USUARIO</h1>
          </div>
          <div class="card-body col-12">
            <form class="" action="" method="post">
              <div class="mb-3">
                <label for="" class="form-label col-12">Nombre:
                  <input type="text" class="form-control" name="nombre"
                    placeholder="Escribe el nombre">
                </label>
              </div>
              <div class="mb-3">
                <label class="form-label col-12">Email:
                  <input type="email" class="form-control" name="email"
                    placeholder="Escribe el email">
                </label>
              </div>
              <div class="mb-3">
                <label class="form-label col-12">Password:
                  <input type="password" class="form-control" name="clave"
                    placeholder="Escribe el password">
                </label>
              </div>
              <div class="mb-3 ml-2">
                <label class="form-label"> Tipo:
                  <input type="text" class="form-control" name="tipo"
                    placeholder="Empleado o administrador">
                </label>
              </div>
              <div class="d-grid gap-2 d-md-flex justify-content-md-end mr-2">
                <button type="submit" class="btn btn-primary" name="enviar_form"><i
                    class="fas fa-save mr-2"></i>Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>