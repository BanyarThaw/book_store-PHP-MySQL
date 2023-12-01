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
  
  # Count total characters in title
  function charCount($words) {
    if (strlen($words) > 40) {
      $sub_words = substr("$words",0,10);
      $sub_words = $sub_words."..........";
      return $sub_words;
    }
    else {
      return $words;
    }
  }

  $per_page_record = 6;  // Number of entries to show in a page. 

  // Look for a GET variable page if not found default is 1.        
  if (isset($_GET["page"])) {    
    $page  = $_GET["page"];    
  }    
  else {    
    $page=1;    
  }

  $start_from = ($page-1) * $per_page_record;  // calculate start_from (read detail in the SKETCH_php_pagination_2)

  # Browse by Category
  # If $_GET['cat'] is set and it's value is all
  if (isset($_GET['cat']) && $_GET['cat'] == 'all') {
    $cat = $_GET['cat'];
    $query = "SELECT * FROM books ORDER BY books.created_date DESC LIMIT $start_from, $per_page_record";     
    $books = mysqli_query ($conn, $query);
  }

  # If $_GET['cat'] is set and it has specific category id
  else if(isset($_GET['cat'])) {
    $cat = $_GET['cat'];
	  $cat_id = $_GET['cat'];
	  $books = mysqli_query($conn, "SELECT * FROM books WHERE category_id = $cat_id ORDER BY books.created_date DESC LIMIT $start_from, $per_page_record");
  } 
  
  # Otherwise select all
  else { 
    $cat = "all";
    $query = "SELECT * FROM books ORDER BY books.created_date DESC LIMIT $start_from, $per_page_record";     
    $books = mysqli_query ($conn, $query);
  }
  
  # Search Result
  if(isset($_GET['q'])) {
  	$books = search($_GET['q']);
  }

  $cats = mysqli_query($conn, "SELECT * FROM categories"); // show categories in side bar
?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Store Update</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/pagination.css">
</head>
<body>
  <h1 id="title">Book Store</h1>

  <div class="info">
    <a href="view-cart.php?page=<?php echo $page; ?>&&cat=<?php echo $cat; ?>">
      (<?php echo $cart ?>) books in your cart
    </a>
  </div>

  <div class="sidebar">
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

  <div class="main">
    <div class="menu">
      <a href="menu.php"><button class="menu_icon"></button></a>
    </div>
    <ul class="books">
      <?php while($row = mysqli_fetch_assoc($books)): ?>
      <li>
        <?php
          if(!is_dir("admin/cover/{$row['cover']}") and file_exists("admin/covers/{$row['cover']}")) {
            $cover =$row['cover'];
            echo "<image src='admin/covers/$cover' alt='' class='book_image'>";
          }
          else {
            echo "<image src='admin/covers/no-cover.gif' alt='' height='150' class='book_image'>";
          }
        ?>
        <b>
          <a href="book-detail.php?id=<?php echo $row['id']; ?>&&page=<?php echo $page; ?>&&cat=<?php echo $cat; ?>">
            <?php echo charCount($row['title']) ?>
          </a>
        </b>

        <i>$<?php echo $row['price'] ?></i>

        <a href="add-to-cart.php?id=<?php echo $row['id'] ?>&&page=<?php echo $page; ?>&&cat=<?php echo $cat; ?>" class="add-to-cart">
          Add to Cart
        </a>
      </li>
      <?php endwhile; ?>
    </ul>

    <center>
      <?php 
          # Don't show pagination link in search result
          if(!isset($_GET['q'])) { 
            # If $_GET['cat'] is set and it's value is all
            if(isset($_GET['cat']) && $_GET['cat'] == 'all') {
              $query = "SELECT COUNT(*) FROM books";
              $cat = $_GET['cat'];
            }

            # If $_GET['cat'] is set and it has specific category id
            else if(isset($_GET['cat'])) {
              $query = "SELECT COUNT(*) FROM books WHERE category_id = $cat_id";
              $cat = $_GET['cat'];
            }

            # Otherwise select all
            else {
              $query = "SELECT COUNT(*) FROM books"; 
              $cat = "all";
            }
            
            $rs_result = mysqli_query($conn, $query);     
            $row = mysqli_fetch_row($rs_result);     
            $total_records = $row[0];     
            echo "</br>";     

            // Number of pages required.
            $total_pages = ceil($total_records / $per_page_record);     
            $pagLink = "";       
      ?>
        <!-- Pagination for larger screens -->
        <div class="larger_screens">
          <div class="pagination">    
            <?php  
                if($page>=2){   
                  echo "<a href='index.php?page=".($page-1)."&&cat=".$cat."'>  Prev </a>";   
                }       
                          
                for ($i=1; $i<=$total_pages; $i++) {   
                  if ($i == $page) {   
                      $pagLink .= "<a class = 'active' href='index.php?page="  
                                                        .$i."&&cat=".$cat."'>".$i." </a>";   
                  }               
                  else  {   
                      $pagLink .= "<a href='index.php?page=".$i."&&cat=".$cat."'>   
                                                        ".$i." </a>";     
                  }   
                };     
                echo $pagLink;   
          
                if($page<$total_pages) {   
                  echo "<a href='index.php?page=".($page+1)."&&cat=".$cat."'>  Next </a>";   
                }   
            ?>    
          </div>
        </div>

        <!-- Pagination for mobile screens -->
        <div class="mobile_screens">
          <div class="pagination">
            <?php
                if($page>=2){   
                echo "<a href='index.php?page=".($page-1)."&&cat=".$cat."'>  Prev </a>";   
              }

              if($page<$total_pages) {   
                echo "<a href='index.php?page=".($page+1)."&&cat=".$cat."'>  Next </a>";   
              }
            ?>
          </div>
        </div>
      <?php
        }
      ?>
    </center>
    <br>
    <br>
  </div>

  <div class="footer">
    &copy; <?php echo date("Y") ?>. All right reserved.
  </div>
</body>
</html>

