<?php
  include("confs/auth.php");
  include("confs/config.php");

  $total = mysqli_query($conn, "SELECT id FROM books");
  $total = mysqli_num_rows($total);

  # Paging
  $limit = 3;
  $start = 0;
  if(isset($_GET['start'])) {
    $start = $_GET['start'];
  }

  $next = $start + $limit; 
  $prev = $start - $limit;

  $result = mysqli_query($conn, "SELECT books.*, categories.name FROM books LEFT JOIN categories ON 
            books.category_id = categories.id ORDER BY books.created_date DESC LIMIT $start, $limit");
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book List</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Book List</h1>
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
<ul class="list">
  <?php while($row = mysqli_fetch_assoc($result)): ?>
    <li>
      <?php
        if(!is_dir("covers/{$row['cover']}") and file_exists("covers/{$row['cover']}")) {
          $cover = $row['cover'];
          echo "<image src='covers/$cover' alt='' align='right' height='140' class='larger_screens_photo'>";
        }
        else {
          echo "<image src='covers/no-cover.gif' alt='' align='right' height='140' class='larger_screens_photo'>";
        }
      ?>
      <b><?php echo $row['title'] ?></b>
      <i>by <?php echo $row['author'] ?></i>
      <small>(in <?php echo $row['name'] ?>)</small>
      <span>$<?php echo $row['price'] ?></span>
      <div><?php echo $row['summary'] ?></div>

      <?php
        echo "<image src='covers/$cover' alt='' class='mobile_screens_photo' align='right' style='width:100%;';>";
      ?>

      [ <a href="book-del.php?id=<?php echo $row['id'] ?>"
      			class="del" onClick="return confirm('Are you sure?')">del</a> ]
      [ <a href="book-edit.php?id=<?php echo $row['id'] ?>">edit</a> ]
    </li>
  <?php endwhile; ?>
</ul>

<a href="book-new.php" class="new">New Book</a>

<div class="paging">
  <?php
    if($prev<0) {
      echo "<span>&laquo; Previous</a>";
    }else{
      echo "<a href='?start=$prev'>&laquo; Previous</a>";
    }
    if($next>=$total) {
      echo "<span>Next &raquo;</span>";
    }else{
      echo "<a href='?start=$next'>Next &raquo;</a>";
    }
  ?>
</div>
<br style="clear:both">

</body>
</html>
