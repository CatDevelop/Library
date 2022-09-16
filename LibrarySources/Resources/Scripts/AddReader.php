<?php
	include "LibrarySystemLib.php"; 

	$Surname = GetPost('Surname');
	$Name = GetPost('Name');
	$MiddleName = GetPost('MiddleName');
	$Class = GetPost('Class');
	$Book = GetPost('Book');
	$DateStart = GetPost('DateStart');
	$Duration = GetPost('Duration');

	$DateStart = explode('.', $DateStart);
	$DateStart = $DateStart[2].$DateStart[1].$DateStart[0];

	$A1 = $Link->query("SELECT `Status` FROM `LibraryBooks` WHERE `Inv`=".$Book);
	$A2 = $A1->fetch_array(MYSQLI_ASSOC);
	$A2['Status'] = mb_convert_encoding($A2['Status'], 'utf8', 'cp1251');
	$result=$A2['Status'];
	if($result == "1") 
	{
		echo "Данная книга уже выдана!";
		exit;
	}else{
		$A1 = $Link->query("UPDATE `LibraryBooks` SET `Status` = '1' WHERE `Inv` = ".$Book);
	}

	$A1 = $Link->query("INSERT INTO LibraryReaders (Surname, Name, MiddleName, Class, Book, DateStart, Duration) VALUES ('$Surname', '$Name', '$MiddleName', '$Class', '$Book', '$DateStart', '$Duration')"); 

	if($A1)
	{
		echo "Читатель был успешно добавлен!";
	}

	mysqli_close($Link);
?>
