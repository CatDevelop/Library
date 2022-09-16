<?php
	include "LibrarySystemLib.php"; 
	//mysqli_set_charset($Link, 'utf8');

	$ID = GetPost('ID');
	
	$A1 = $Link->query("Delete FROM `LibraryBooks` WHERE `id` = ".$ID);
	echo "Книга была успешно удалена!";
	mysqli_close($Link);
?>
