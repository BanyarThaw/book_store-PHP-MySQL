<?php
	include("admin/confs/config.php");
	function search($words) {
		global $conn;
		$result = mysqli_query($conn,"SELECT * FROM books WHERE title LIKE '%$words%' OR author LIKE '%$words%' OR summary LIKE '%$words%'");
		return $result;
	}
?>