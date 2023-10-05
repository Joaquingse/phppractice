<?php
include_once "db_connect.php";
session_start();
if (isset($_POST['login_form'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  //$conexion = mysqli_connect($db_host, $db_user, $db_pass, $db_database);
  $conexion = $con;
  $query = "SELECT * FROM usuarios WHERE email = '$email' AND clave = md5('$password') ";
  $resultset = mysqli_query($conexion, $query);
  $cliente = mysqli_fetch_assoc($resultset);
  if (!$cliente) {
    $error_message = "Usuario no encontrado";
  } else {
    $_SESSION['username'] = $cliente['nombre'];
    $_SESSION['surname'] = $cliente['apellido'];
    $_SESSION['id'] = $cliente['id'];
    header("Location: panel.php");
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>AdminLTE 3 | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" />
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css" />
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css" />
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css" />
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css" />
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="">
  <!-- componente visual para el loging -->
  <section class="content">
    <div class="container-fluid">
      <div class="row pt-5">
        <div class="col-12 col-md-4 position-absolute top-50 start-50 translate-middle">
          <div class="card col-12 mb-3">
            <div class="car-header ml-4 mt-3">
              <p>Identifícate para iniciar la sesión</p>
            </div>
            <div class="card-body col-12 mx-auto">
              <?php if (isset($error_message)) { ?>
                <div class="alert alert-danger" role="alert">
                  Usuario no registrado.
                </div>
              <?php } ?>
              <form method="post">
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label col-12">
                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Email"></label>
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label col-12"><input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password"></label>
                </div>
                <div class="col-12 mb-3 d-grid gap-2 ">
                  <button type="submit" class="btn btn-success btn-sm" name="login_form">Iniciar
                    sesión</button>
                </div>
                <div class="col-12">
                  <p class="link"><a href="#">Darse de alta como nuevo usuario</a></p>
                  <p class="link"><a href="#">Conectarse como administrador</a></p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="position-absolute bottom-0 start-50 translate-middle text-muted">
    <div class="col-12  mx-auto">
      <strong>Copyright &copy; 2014-2021
        <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
      All rights reserved.

      <i class="ti ti-device-audio-tape" style="color: blue;"></i>
      <b>Version</b> 3.2.0
    </div>
  </footer>


  <!-- jQuery & datatables -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge("uibutton", $.ui.button);
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <!-- <script src="dist/js/demo.js"></script> -->
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <style>

  </style>
</body>

</html>