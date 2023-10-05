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
  $descripcion = sanitizar($con, $_POST['descripcion']);
  $precio = sanitizar($con, $_POST['precio']);
  $existencias = sanitizar($con, $_POST['existencias']);
  $imagen = $_POST['imagen'];
  if (mysqli_connect_errno()) {
    die("<p>Error de conexión Nº: " . mysqli_connect_errno() . " - " . mysqli_connect_error() . "</p>\n</body>\n</html>");
  }
  $query = "INSERT INTO productos ( nombre, descripcion, precio, existencias, imagen) VALUES ('$nombre','$descripcion', '$precio','$existencias','$imagen')";
  $resultset = mysqli_query($con, $query);

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
      $query2 = "SELECT id FROM productos WHERE nombre='$nombre'";
      $resultset2 = mysqli_query($con, $query2);
      $row = mysqli_fetch_assoc($resultset2);
      $id = $row['id'];
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
  print "<meta http-equiv='refresh' content='0; url=panel.php?modulo=productos' ";
}
?>
<section class="content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 mt-3">
        <div class="card">
          <div class="card-header">
            <h1>NUEVO PRODUCTO</h1>
          </div>
          <div class="card-body col-12">
            <form class="" action="" method="post" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="" class="form-label col-12">Nombre:
                  <input type="text" class="form-control" name="nombre"
                    placeholder="Nombre del producto">
                </label>
              </div>
              <div class="mb-3">
                <label for="" class="form-label col-12">Descripcion:
                  <input type="text" class="form-control" name="descripcion"
                    placeholder="Descripción del producto">
                </label>
              </div>

              <div class="d-flex justify-content-between col-12">
                <div class="mb-3">
                  <label class="form-label">Precio unitario:
                    <input type="number" class="form-control" name="precio"
                      placeholder="Introduzca el precio">
                  </label>
                </div>
                <div class="mb-3 col-7">
                  <label class="form-label"> Existencias:
                    <input type="number" class="form-control" name="existencias"
                      placeholder="Cantidad de producto">
                  </label>
                </div>
              </div>

              <div class="mb-3">
                <label for="" class="form-label col-12">Subir imagen:
                  <input type="file" class="form-control" name="imagen">
                </label>
              </div>
              <div class="d-grid gap-2 d-md-flex justify-content-between mr-2">
                <button type="submit" class="btn btn-primary" name="enviar_form"><i
                    class="fas fa-save mr-2"></i>Save</button>
                <a href="panel.php?modulo=productos" class="btn btn-danger" name="go_back"><i
                    class="fas fa-ban mr-2"></i>Cancelar</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>