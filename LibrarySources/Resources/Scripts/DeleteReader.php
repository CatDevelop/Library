<?php
	include "LibrarySystemLib.php"; 
	//mysqli_set_charset($Link, 'utf8');

	$ID = GetPost('ID');

	$Book = Select($Link, 'Book', "`LibraryReaders`", "`id`= ".$ID);

	$A2 = $Link->query("UPDATE `LibraryBooks` SET `Status` = '0' WHERE `Inv` = ".$Book);
	$A1 = $Link->query("Delete FROM `LibraryReaders` WHERE `id` = ".$ID);
	echo $Book;

	echo "Книга была успешно возвращена!";
	mysqli_close($Link);
?>
