<!DOCTYPE HTML>
<html lang="en-US">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Detail</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Book Detail</h1>

<?php
  include("admin/confs/config.php");
  $id = $_GET['id'];
  $books = mysqli_query($conn, "SELECT * FROM books WHERE id = $id");
  $row = mysqli_fetch_assoc($books);

  //get page number and cat id for go back button(to return previous page)
  $page = $_GET['page'];
  $cat = $_GET['cat'];
?>

<div class="detail">
  <a href="index.php?page=<?php echo $page; ?>&&cat=<?php echo $cat; ?>" class="back">&laquo; Go Back</a>

  <div class="book_image_detail_parent">
    <img src="admin/covers/<?php echo $row['cover'] ?>" class="book_image_detail">
  </div>

  <h2><?php echo $row['title'] ?></h2>
  <i>by <?php echo $row['author'] ?></i>,
  <b>$<?php echo $row['price'] ?></b>

  <p><?php echo $row['summary'] ?></p>

  <a href="add-to-cart.php?id=<?php echo $row['id'] ?>&&page=<?php echo $page; ?>&&cat=<?php echo $cat; ?>" class="add-to-cart">
    Add to Cart
  </a>
</div>

<div class="footer">
  &copy; <?php echo date("Y") ?>. All right reserved.
</div>
</body>
</html>