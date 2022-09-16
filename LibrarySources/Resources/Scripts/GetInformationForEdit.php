<?php
	include "LibrarySystemLib.php"; 
	mysqli_set_charset($Link, 'utf8');

	$id = GetPost('Id');
	$Column = GetPost('Column');
	
	if($Column == 0)
	{
		$Column = "Inv";
	}
	if($Column == 1)
	{
		$Column = "Author";
	}
	if($Column == 2)
	{
		$Column = "Name";
	}
	if($Column == 3)
	{
		$Column = "Publisher";
	}
	if($Column == 4)
	{
		$Column = "Year";
	}
	if($Column == 5)
	{
		$Column = "KeyWords";
	}
	if($Column == 6)
	{
		$Column = "Cost";
	}
	if($Column == 7)
	{
		$Column = "ISBN";
	}

	$result = Select($Link, $Column, "`LibraryBooks`", "`id`=".$id);
	echo "(id: ".$id.") ".$result;


	mysqli_close($Link);
?>
