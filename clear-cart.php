<?php
  session_start();
  unset($_SESSION['cart']); // clear cart

  //get page number and cat id for go back button(to return previous page)
  $page = $_GET['page'];
  $cat = $_GET['cat'];

  header("location: index.php?page=$page&&cat=$cat");
?>