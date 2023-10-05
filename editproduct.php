<?php
include_once "db_connect.php";
session_start();
session_regenerate_id();
if (!isset($_SESSION['username'])) {
  header('Location: index.php');
  exit();
}
//funcion para sacar por consola mensages


ini_set("display_errors", 0);
ini_set("display_startup_errors", 0);

//anula los reportes de error de mysql
//mysqli_report(MYSQLI_REPORT_OFF);

$con = mysqli_connect($db_host, $db_user, $db_pass, $db_database);
$id = $_REQUEST["id"];
if (mysqli_connect_errno()) {
  die("<p>Error de conexión Nº: " . mysqli_connect_errno() . " - " . mysqli_connect_error() . "</p>\n</body>\n</html>");
}
if ($con->connect_errno) {
  die("<p>Error de conexión Nº: $con->connect_errno - $con->connect_error</p>\n</body>\n</html>");
}

$query = "SELECT * FROM productos WHERE id= $id";
$resultset = mysqli_query($con, $query);
console_log($resultset);
if ($con->errno) {
  die("<p>Error en la consulta:$con->error </p>\n</body>\n</html>");
}

if (isset($_POST['edit_product'])) {
  $nombre = sanitizar($con, $_POST['nombre']);
  $descripcion = sanitizar($con, $_POST['descripcion']);
  $precio = sanitizar($con, $_POST['precio']);
  $existencias = sanitizar($con, $_POST['existencias']);
  //$imagen = sanitizar($con, $_POST['imagen']);
  $con = mysqli_connect($db_host, $db_user, $db_pass, $db_database);
  $query = "UPDATE productos 
        SET nombre='$nombre', descripcion='$descripcion', precio='$precio', existencias='$existencias', imagen='$imagen' 
        WHERE id=$id";
  if (mysqli_connect_errno()) {
    die("<p>Error de conexión Nº: " . mysqli_connect_errno() . " - " . mysqli_connect_error() . "</p>\n</body>\n</html>");
  }
  $resultset = mysqli_query($con, $query);
  if ($con->errno) {
    die("<p>Error en la consulta:$con->error </p>\n</body>\n</html>");
  }
  print "<meta http-equiv='refresh' content='0; url=panel.php?modulo=productos' ";
  $_SESSION['message'] = "Producto actualizado";
  $_SESSION['message_type'] = "success";
}
//subir archivo de imagen
$archivo = $_FILES['imagen']['name'];
if (isset($archivo) && $archivo != "") {
  $tipo = $_FILES['imagen']['type'];
  $tamano = $_FILES['imagen']['size'];
  $temp = $_FILES['imagen']['tmp_name'];
  //$dir_destino = 'img/';
  //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
  if (!(strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png") || strpos($tipo, "webp")) && $tamano > 2000000) {
    echo '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
       - Se permiten archivos .gif, .jpg, .png, .webp y de 200 kb como máximo.</b></div>';
  } else {
    //Si la imagen es correcta en tamaño y tipo
    //encriptamos con md5() la función microtime() para crear nuevo nombre
    $longitudPass = 10;
    /* creamos el nuevo nombre, substr me creara un substring 
    de md5(microtime()) con los 10 primeros caracteres, así evitamos
    nombres duplicados */
    $newNameFoto = substr(md5(microtime()), 1, $longitudPass);
    /*divido el nombre del archivo en dos partes desde el "."
     me devuelve un array con el nombre y la extensión*/
    $explode = explode(".", $archivo);
    //con array_pop() selecciono el último elemento del array
    $extension_foto = array_pop($explode);
    //asigno el nuevo nombre para el archivo
    $archivo = $newNameFoto . "." . $extension_foto;
    //$ruta = $dir_destino . $archivo;
    //intentamos subirla al server
    if (move_uploaded_file($temp, 'img/' . $archivo)) {
      //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
      chmod('img/' . $archivo, 0777);
      //Mostramos el mensaje de que se ha subido con éxito
      echo '<p><b>Se ha subido correctamente la imagen.</b></p>';
      echo '<p><img src="img/' . $archivo . '"></p>';
      // insertamos una linea en la tabla foto
      $imagen = "$archivo";
      //print "<p>$imagen</p>";
      //print "<p>idproducto:<br>$id</p>";
      $query3 = "INSERT INTO fotos (idproducto,nombre) values ('$id', '$archivo')";
      //print "<p>$query3</p>";
      $resultset3 = mysqli_query($con, $query3);
      console_log($query3);
    }
    if ($resultset3) {
      echo '<div><b>Se ha insertado correctamente la imagen.</b></div>';
      $query4 = "UPDATE productos SET imagen = '$archivo' WHERE id='$id'";

      $resultset4 = mysqli_query($con, $query4);
      console_log($query4);
    } else {
      echo '<div><b>Ocurrió algún error al insertat el registro del fichero. No pudo guardarse.</b></div>';
    }
  }
}
if ($con->errno) {
  echo "<p>Error en la consulta:$con->error </p>\n</body>\n</html>";
  die("<p>Error en la consulta:$con->error </p>\n</body>\n</html>");
}


?>

<section class="content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-md-8 mx-auto mt-4">
        <div class="card col-12">
          <div class="card-header">
            <h1>EDITAR PRODUCTO</h1>
          </div>
          <div class="card-body col-12">
            <form method="post" action="" enctype="multipart/form-data">
              <?php
              if ($row = mysqli_fetch_assoc($resultset)) {
                ?>

                <div class="mb-3">
                  <label class="form-label col-12">Nombre:
                    <input type="text" class="form-control" name="nombre"
                      value="<?php print $row["nombre"] ?>">
                  </label>
                </div>
                <div class="mb-3">
                  <label class="form-label col-12">Descripcion:
                    <input type="text" class="form-control" name="descripcion"
                      value="<?php print $row["descripcion"] ?>">
                  </label>
                </div>
                <div class="mb-3">
                  <label class="form-label col-12">Precio:
                    <input type="number" class="form-control" name="precio"
                      value="<?php print $row["precio"] ?>">
                  </label>
                </div>
                <div class="mb-3 col-6">
                  <label class="form-label">Existencias:
                    <input type="number" class="form-control" name="existencias"
                      value="<?php print $row["existencias"] ?>">
                  </label>
                </div>
                <div class="mb-3">
                  <label class="form-label col-12">Imagen:
                    <input type="text" class="form-control" name="imagen"
                      value="<?php print $row["imagen"] ?>">
                  </label>
                </div>
                <div class="mb-3">
                  <label for="" class="form-label col-12">Subir Imagen:
                    <input type="file" class="form-control" name="imagen"
                      placeholder="Agregar imágenes.">
                  </label>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-between mb-3">
                  <button type="submit" class="btn btn-primary" name="edit_product"><i
                      class="fas fa-save mr-2"></i>Save</button>
                  <a href="panel.php?modulo=productos" class="btn btn-danger" name="go_back"><i
                      class="fas fa-ban mr-2"></i>Cancelar</a>
                </div>

              <?php } else {
                print "<h1>Producto no encontrado</h1>";
              } ?>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>