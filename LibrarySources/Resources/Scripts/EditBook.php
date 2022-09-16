<?php
	include "LibrarySystemLib.php"; 
	//mysqli_set_charset($Link, 'utf8');

	$id = GetPost('Id');
	$Column = GetPost('Column');
	$Value = GetPost('Value');
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

	$A1 = $Link->query("UPDATE `LibraryBooks` SET ".$Column." = '".$Value."' WHERE `id` = ".$id);
	echo "Параметр был успешно изменён!";
	mysqli_close($Link);
?>
