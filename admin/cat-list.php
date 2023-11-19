<?php
	include("confs/auth.php");
	include("confs/config.php");
	$result = mysqli_query($conn, "SELECT * FROM categories");
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Category List</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Category List</h1>
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
		<li title="<?php echo $row['remark'] ?>">
			[ <a href="cat-del.php?id=<?php echo $row['id'] ?>"
					class="del" onClick="return confirm('Are you sure?')">del</a> ]
			[ <a href="cat-edit.php?id=<?php echo $row['id'] ?>">edit</a> ]
			<?php echo $row['name'] ?>
		</li>
	<?php endwhile; ?>
</ul>

<a href="cat-new.php" class="new">New Category</a>

<br style="clear:both">
</body>
</html>

