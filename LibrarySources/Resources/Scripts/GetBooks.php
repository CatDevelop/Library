<?php
	include "LibrarySystemLib.php"; 
	
	$Filter = GetPost('Filter');
	$count = $Link->query("SELECT COUNT(*) FROM `LibraryBooks` ".$Filter);

	$count = mysqli_fetch_array($count);
	echo $count[0]."/*/";

	$A1 = $Link->query("SELECT * FROM `LibraryBooks` ".$Filter);
	while ($row = $A1->fetch_assoc())
	{
		$row['Author'] = mb_convert_encoding($row['Author'], 'utf8', 'cp1251');
		$row['Name'] = mb_convert_encoding($row['Name'], 'utf8', 'cp1251');
		$row['Publisher'] = mb_convert_encoding($row['Publisher'], 'utf8', 'cp1251');
		$row['KeyWords'] = mb_convert_encoding($row['KeyWords'], 'utf8', 'cp1251');
		$row['ISBN'] = mb_convert_encoding($row['ISBN'], 'utf8', 'cp1251');
		
		echo $row['id']."/*/";
		echo $row['Inv']."/*/";
		echo $row['Author']."/*/";
		echo $row['Name']."/*/";
		echo $row['Publisher']."/*/";
		echo $row['Year']."/*/";
		echo $row['KeyWords']."/*/";
		echo $row['Cost']."/*/";
		echo $row['ISBN']."/*/";
		echo $row['Status']."/*/";
	}
	mysqli_close($Link);
?>
