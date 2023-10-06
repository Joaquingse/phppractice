<?php
//importamos los datos para conectar desde el fichero db_connect.php
include_once "db_connect.php";
/* 
//para pruebas en local
session_start();
session_regenerate_id();
if (!isset($_SESSION['username'])) {
  header('Location: index.php');
  exit();
} */
//impide mostrar los errores del sistema
//ini_set("display_errors", 0);
//ini_set("display_startup_errors", 0);

//anula los reportes de error de mysql
//mysqli_report(MYSQLI_REPORT_OFF);

//creamos el objeto para la conexión
//$con = mysqli_connect($db_host, $db_user, $db_pass, $db_database);

//creamos un if para los errores de conexión
//Personalizamos el mensaje de error
if (mysqli_connect_errno()) {
  //die mata el proceso y muestra el error que queremos nosotros 
  die("<p>Error de conexión Nº: " . mysqli_connect_errno() . " - " . mysqli_connect_error() . "</p>\n</body>\n</html>");
}
/*   if ($con->connect_errno) {
    die("<p>Error de conexión Nº: $con->connect_errno - $con->connect_error</p>\n</body>\n</html>");
  } */

$query = "SELECT id, nombre, email, tipo FROM usuarios";

$resultset = mysqli_query($con, $query);

if ($con->errno) {
  echo "<p>Error en la consulta:$con->error </p>\n</body>\n</html>";
  die("<p>Error en la consulta:$con->error </p>\n</body>\n</html>");
}

// print $query;
/*   echo "<br>";
  print "<pre>";
  print_r($resultset);
  print "</pre>"; */
?>
<section class="content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 mx-auto mt-4">
        <div class="card">
          <div class="card-header">
            <h1>USUARIOS</h1>
          </div>
          <div class="card-body">
            <table id="tablausuarios" class="table table-secondary table-striped table-hover">
              <thead>
                <tr class="text-success">
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Tipo</th>
                  <th>Acciones <a href="panel.php?modulo=newuser"><i class="ti ti-plus"></i></a>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($resultset)) {
                  $id = $row['id']
                    ?>
                  <tr>
                    <td><?php print $row["nombre"] ?></td>
                    <td><?php print $row["email"] ?></td>
                    <td><?php print $row["tipo"] ?></td>
                    <td>
                      <a href="panel.php?modulo=edituser&id=<?php print $row["id"] ?>"><i
                          class="ti ti-edit ml-2 mr-2"></i></a>
                      <a href="panel.php?modulo=deluser&id=<?php print $row["id"] ?>"><i
                          class="ti ti-trash" style="color: #D32323;"></i></a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>