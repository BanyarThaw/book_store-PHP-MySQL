<?php include("confs/auth.php") ?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order List</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Order List</h1>
<ul class="menu">
  <li class="menu_larger_screens"><a href="book-list.php">Manage Books</a></li>
  <li class="menu_larger_screens"><a href="cat-list.php">Manage Categories</a></li>
  <li class="menu_larger_screens"><a href="orders.php">Manage Orders</a></li>
  <li class="menu_larger_screens"><a href="logout.php">Logout</a></li>
  <li class="menu_mobile_screens">
    <a href="book-list.php" class="book_list_cat_icon"></a>
  </li>
  <li class="menu_mobile_screens">
    <a href="cat-list.php" class="cat_list_cat_icon"></a>
  </li>
  <li class="menu_mobile_screens">
    <a href="orders.php" class="orders_icon"></a>
  </li>
  <li class="menu_mobile_screens">
    <a href="logout.php" class="logout_icon"></a>
  </li>
</ul>

<?php
  include("confs/config.php");
  $orders = mysqli_query($conn, "SELECT * FROM orders");
?>
<ul class="orders">
  <?php while($order = mysqli_fetch_assoc($orders)): ?>
    <?php if($order['status']): ?>
      <li class="delivered">
    <?php else: ?>
      <li>
    <?php endif; ?>
      <div class="order">
        <b class="word_break"><?php echo $order['name'] ?></b>
        <i class="word_break"><?php echo $order['email'] ?></i>
        <span class="word_break"><?php echo $order['phone'] ?></span>
        <p class="word_break">
          <?php echo $order['address'] ?>
        </p>

        <?php if($order['status']): ?>
          * <a href="order-status.php?id=<?php echo $order['id'] ?>&status=0">Undo</a>
        <?php else: ?>
          * <a href="order-status.php?id=<?php echo $order['id'] ?>&status=1">Mark as Delivered</a>
        <?php endif; ?>
      </div>
      <div class="items">
        <h2> Item List </h2>
        <?php
          $order_id = $order['id'];
          $items = mysqli_query($conn, "SELECT order_items.*, books.title FROM order_items LEFT JOIN books ON order_items.book_id = books.id WHERE order_items.order_id = $order_id") or die(mysqli_error());
          while($item = mysqli_fetch_assoc($items)):
        ?>
        <b>
          <a href="../book-detail.php?id=<?php echo $item['book_id'] ?>" class="word_break">
            <?php echo $item['title'] ?>
          </a>
          (<?php echo $item['qty'] ?>)
        </b>
        <?php endwhile; ?>
      </div>
    </li>
  <?php endwhile; ?>
</ul>
</body>
</html>

