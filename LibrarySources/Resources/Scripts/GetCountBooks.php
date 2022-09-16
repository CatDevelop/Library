<?php
	include "LibrarySystemLib.php"; 
	mysqli_set_charset($Link, 'utf8');

	$Filter = GetPost('Filter');

	$count = $Link->query("SELECT COUNT(1) FROM `LibraryBooks`");
	$count = mysqli_fetch_array($count);
	echo $count[0];

	mysqli_close($Link);
?>
