<?php
include_once "db_connect.php";
session_start();
session_regenerate_id();

if (isset($_SESSION['id'])) {
  session_destroy();
  header('Location: index.php');
}

?>