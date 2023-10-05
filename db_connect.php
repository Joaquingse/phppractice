<?php

//session_start();

$db_host = "joaquingse-server.mysql.database.azure.com";
$db_user = "joaquin";
$db_pass = "Curso_PHP1";
$db_database = "joaquingse";
$db_port = "3306";
$db_auth = "./ssl/DigiCertGlobalRootCA.crt.pem";

$con = mysqli_init();
mysqli_ssl_set($con,NULL,NULL, $db_auth, NULL, NULL);
mysqli_real_connect($con, $db_host, $db_user, $db_pass, $db_database, 3306, MYSQLI_CLIENT_SSL);

function console_log($output, $with_script_tags = true)
{
  $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
  if ($with_script_tags) {
    $js_code = '<script>' . $js_code . '</script>';
  }
  echo $js_code;
}

function sanitizar($con, $datos)
{
  $res = mysqli_real_escape_string($con, htmlspecialchars(trim(strip_tags($datos ?? ""))));
  return $res;
}
