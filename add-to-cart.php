<?php
  session_start(); // start session
  $id = $_GET['id']; 
  $_SESSION['cart'][$id]++; // increase the id of item within cart(session)

  // get page number and cat id for go back button( to return previous page )
  if(isset($_GET['page']))
  {
    $page = $_GET['page'];
  }
  if(isset($_GET['cat']))
  {
    $cat = $_GET['cat'];
  }
  else {
    $page = 1;
    $cat = "all";
  }
  
  header("location: index.php?page=$page&&cat=$cat");
?>