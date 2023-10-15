<?php
  session_start();
  include("admin/confs/config.php");
  include("search.lib.php");

  # Show how many items in the cart
  $cart = 0;
  if(isset($_SESSION['cart'])) {
    foreach($_SESSION['cart'] as $qty) {
      $cart += $qty;
    }
  }
  
  # Browse by Category
  # If $_GET['cat'] is set and it has specific category id
  if(isset($_GET['cat'])) {
	$cat_id = $_GET['cat'];
	$books = mysqli_query($conn, "SELECT * FROM books WHERE category_id = $cat_id");

  # Otherwise select all
  } else {
    $books = mysqli_query($conn, "SELECT * FROM books");
  }
  
  # Search Result
  if(isset($_GET['q'])) {
  	$books = search($_GET['q']);
  }

  $cats = mysqli_query($conn, "SELECT * FROM categories"); // get all categories
?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Store</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1 id="title">Book Store</h1>

  <div class="info">
    <a href="view-cart.php">
      (<?php echo $cart ?>) books in your cart
    </a>
  </div>

  <div class="menu_sidebar">
    <ul class="cats">
      <form action="index.php" method="get" class="search">
      	<input type="text" name="q" placeholder="Search by title">
      	<input type="submit" value=" ">
      </form>
      <li>
        <b><a href="index.php">All Books</a></b>
      </li>
      <?php while($row = mysqli_fetch_assoc($cats)): ?>
      <li>
        <a href="index.php?cat=<?php echo $row['id'] ?>">
          <?php echo $row['name'] ?>
        </a>
      </li>
      <?php endwhile; ?>
    </ul>
  </div>
  <div class="footer">
    &copy; <?php echo date("Y") ?>. All right reserved.
  </div>
</body>
</html>

