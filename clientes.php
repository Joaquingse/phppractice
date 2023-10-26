<?php
//importamos los datos para conectar desde el fichero db_connect.php
include_once "db_connect.php";

//para pruebas en local
/* session_start();
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

$query = "SELECT id, nombre, apellido, email, clave, dni FROM clientes";

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
            <h1>CLIENTES</h1>
          </div>
          <div class="card-body">
            <table id="tablaclientes" class="table table-secondary table-striped table-hover">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Email</th>
                  <th>DNI</th>
                  <th>Acciones <a href="panel.php?modulo=newclient"><i class="ti ti-plus"></i></a>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($resultset)) {
                  ?>
                  <tr>
                    <td><?php print $row["nombre"] ?></td>
                    <td><?php print $row["apellido"] ?></td>
                    <td><?php print $row["email"] ?></td>
                    <td><?php print $row["dni"] ?></td>
                    <td>
                      <a href="panel.php?modulo=editclient&id=<?php print $row["id"] ?>">
                        <i class="ti ti-edit"></i></a>
                      <a href="panel.php?modulo=delclient&id=<?php print $row["id"] ?>"><i
                          class="ti ti-trash" style="color: #D32323;"></i></i></a>
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