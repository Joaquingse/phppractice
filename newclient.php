<?php
include_once "db_connect.php";
session_start();
session_regenerate_id();
if (!isset($_SESSION['username'])) {
  header('Location: index.php');
  exit();
}

if (isset($_POST['enviar_form'])) {
  //$con = mysqli_connect($db_host, $db_user, $db_pass, $db_database);
  $nombre = sanitizar($con, $_POST['nombre']);
  $apellido = sanitizar($con, $_POST['apellido']);
  $email = sanitizar($con, $_POST['email']);
  $clave = sanitizar($con, $_POST['clave']);
  $dni = sanitizar($con, $_POST['dni']);
  $direccion = sanitizar($con, $_POST['direccion']);

  $query = "INSERT INTO clientes (nombre, apellido, email, clave, dni, direccion)
   VALUES ('$nombre','$apellido', '$email', md5('$clave'), '$dni','$direccion')";
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
        <div class="card">
          <div class="card-header">
            <h1>NUEVO CLIENTE</h1>
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
                <label for="" class="form-label col-12">Apellido:
                  <input type="text" class="form-control" name="apellido"
                    placeholder="Escribe los apellidos">
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
                <label class="form-label"> DNI:
                  <input type="text" class="form-control" name="dni" placeholder="Introduce el DNI">
                </label>
              </div>
              <div class="mb-3">
                <label for="" class="form-label col-12">Dirección:
                  <input type="text" class="form-control" name="direccion"
                    placeholder="Escribe la dirección">
                </label>
              </div>
              <div class="d-grid gap-2 d-md-flex justify-content-between mr-2">
                <button type="submit" class="btn btn-primary" name="enviar_form"><i
                    class="fas fa-save mr-2"></i>Save</button>
                <a href="panel.php?modulo=clientes" class="btn btn-danger" name="go_back"><i
                    class="fas fa-ban mr-2"></i>Cancelar</a>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>