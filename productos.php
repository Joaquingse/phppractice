<?php
//importamos los datos para conectar desde el fichero db_connect.php
include_once "db_connect.php";
session_start();
session_regenerate_id();
if (!isset($_SESSION['username'])) {
  header('Location: index.php');
  exit();
}
//impide mostrar los errores del sistema
ini_set("display_errors", 0);
ini_set("display_startup_errors", 0);

//anula los reportes de error de mysql
//mysqli_report(MYSQLI_REPORT_OFF);

//creamos el objeto para la conexión
$conexion = mysqli_connect($db_host, $db_user, $db_pass, $db_database);

//creamos un if para los errores de conexión
//Personalizamos el mensaje de error
if (mysqli_connect_errno()) {
  //die mata el proceso y muestra el error que queremos nosotros 
  die("<p>Error de conexión Nº: " . mysqli_connect_errno() . " - " . mysqli_connect_error() . "</p>\n</body>\n</html>");
}
/*   if ($conexion->connect_errno) {
    die("<p>Error de conexión Nº: $conexion->connect_errno - $conexion->connect_error</p>\n</body>\n</html>");
  } */

$query = "SELECT id, nombre, descripcion, precio, existencias, imagen FROM productos";
$resultset = mysqli_query($conexion, $query);
if ($conexion->errno) {
  echo "<p>Error en la consulta:$conexion->error </p>\n</body>\n</html>";
  die("<p>Error en la consulta:$conexion->error </p>\n</body>\n</html>");
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
            <h1>PRODUCTOS</h1>
          </div>
          <div class="card-body">
            <table id="tablaproductos" class="table table-secondary table-striped table-hover">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Descripcion</th>
                  <th>Precio</th>
                  <th>Existencias</th>
                  <th>Valor</th>
                  <th>Imagen</th>
                  <th>Acciones <a href="panel.php?modulo=newproduct"><i class="ti ti-plus"></i></a>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($resultset)) {
                  ?>
                  <tr class="hidden"></tr>
                  <td><?php print $row["nombre"] ?></td>
                  <td><?php print $row["descripcion"] ?></td>
                  <td><?php print $row["precio"] ?></td>
                  <td><?php print $row["existencias"] ?></td>
                  <td><?php print $row["precio"] * $row["existencias"]?></td>
                  <td><img src="./img/<?php print $row["imagen"]; ?>" alt="imagen del producto"
                      width="100px"></td>
                  <td>
                    <a href="panel.php?modulo=editproduct&id=<?php print $row["id"] ?>"><i
                        class="ti ti-edit"></i></a>
                    <a href="panel.php?modulo=delproduct&id=<?php print $row["id"] ?>"><i
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