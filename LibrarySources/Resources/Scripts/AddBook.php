<?php
	include "LibrarySystemLib.php"; 

	$Inv = GetPost('Inv');
	$Author = GetPost('Author');
	$Name = GetPost('Name');
	$Publisher = GetPost('Publisher');
	$Year = GetPost('Year');
	$KeyWords = GetPost('KeyWords');
	$Cost = GetPost('Cost');
	$ISBN = GetPost('ISBN');

	$A1 = $Link->query("INSERT INTO LibraryBooks (Inv, Author, Name, Publisher, Year, KeyWords, Cost, ISBN) VALUES ('$Inv', '$Author', '$Name', '$Publisher', '$Year', '$KeyWords', '$Cost', '$ISBN')"); 

	if($A1)
	{
		echo "Книга была успешно добавлена!";
	}

	mysqli_close($Link);
?>
