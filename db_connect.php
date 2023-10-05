<?php

//session_start();

$db_host = "localhost";
$db_user = "joaquin";
$db_pass = "4tl3t1c0";
$db_database = "joaquingse";
$db_port = "3306";

function console_log($output, $with_script_tags = true)
{
  $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
  if ($with_script_tags) {
    $js_code = '<script>' . $js_code . '</script>';
  }
  echo $js_code;
}

function sanitizar($conexion, $datos)
{
  $res = mysqli_real_escape_string($conexion, htmlspecialchars(trim(strip_tags($datos ?? ""))));
  return $res;
}



?>