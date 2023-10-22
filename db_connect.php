<?php

//session_start();

$db_host = "containers-us-west-95.railway.app";
$db_user = "root";
$db_pass = "E3CHgrNdT6CNjW2HCdZC";
$db_database = "railway";
$db_port = 7466;

$con = mysqli_init();
mysqli_ssl_set($con,NULL,NULL,"./ssl/cert/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($con, $db_host, $db_user, $db_pass, $db_database, 7466, MYSQLI_CLIENT_SSL);

$uName = "";
$uId = "";


function console_log($output, $with_script_tags = true)
{
  $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
  if ($with_script_tags) {
    $js_code = '<script>' . $js_code . '</script>';
  }
  echo $js_code;
}

function sanitizar($conn, $datos)
{
  $res = mysqli_real_escape_string($conn, htmlspecialchars(trim(strip_tags($datos ?? ""))));
  return $res;
}
