<?php
  // $dbhost = "127.0.0.1";
  // $dbuser = "store_admin";
  // $dbpass = "password";
  // $dbname = "store";

  // $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
  // mysqli_select_db($conn, $dbname);

  $docker_container_name = "mysql-bookstore";
  $dbuser = "store_admin";
  $dbpass = "password";
  $dbname = "store";

  $conn = mysqli_connect($docker_container_name, $dbuser, $dbpass);
  mysqli_select_db($conn, $dbname);
?>
