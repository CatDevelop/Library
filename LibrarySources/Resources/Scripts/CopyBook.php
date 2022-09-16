<?php
	include "LibrarySystemLib.php"; 
	mysqli_set_charset($Link, 'utf8');

	$ID = GetPost('ID');

	$Inv = Select($Link, "Inv", "`LibraryBooks`", "`id`=".$ID);
	$Author = Select($Link, "Author", "`LibraryBooks`", "`id`=".$ID);
	$Name = Select($Link, "Name", "`LibraryBooks`", "`id`=".$ID);
	$Publisher = Select($Link, "Publisher", "`LibraryBooks`", "`id`=".$ID);
	$Year = Select($Link, "Year", "`LibraryBooks`", "`id`=".$ID);
	$KeyWords = Select($Link, "KeyWords", "`LibraryBooks`", "`id`=".$ID);
	$Cost = Select($Link, "Cost", "`LibraryBooks`", "`id`=".$ID);
	$ISBN = Select($Link, "ISBN", "`LibraryBooks`", "`id`=".$ID);

	$A1 = $Link->query("INSERT INTO LibraryBooks (Inv, Author, Name, Publisher, Year, KeyWords, Cost, ISBN) VALUES ('$Inv', '$Author', '$Name', '$Publisher', '$Year', '$KeyWords', '$Cost', '$ISBN')"); 

	if($A1)
	{
		echo "Книга была успешно скопирована!";
	}
	mysqli_close($Link);
?>
