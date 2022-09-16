<?php
	include "LibrarySystemLib.php"; 
	
	$Filter = GetPost('Filter');
	$count = $Link->query("SELECT COUNT(*) FROM `LibraryReaders` ".$Filter);

	$count = mysqli_fetch_array($count);
	echo $count[0]."/*/";

	$A1 = $Link->query("SELECT * FROM `LibraryReaders` ".$Filter);
	while ($row = $A1->fetch_assoc())
	{
		$row['Surname'] = mb_convert_encoding($row['Surname'], 'utf8', 'cp1251');
		$row['Name'] = mb_convert_encoding($row['Name'], 'utf8', 'cp1251');
		$row['MiddleName'] = mb_convert_encoding($row['MiddleName'], 'utf8', 'cp1251');
		$row['Class'] = mb_convert_encoding($row['Class'], 'utf8', 'cp1251');
		$row['Book'] = mb_convert_encoding($row['Book'], 'utf8', 'cp1251');
		$row['DateStart'] = mb_convert_encoding($row['DateStart'], 'utf8', 'cp1251');
		
		echo $row['id']."/*/";
		echo $row['Surname']."/*/";
		echo $row['Name']."/*/";
		echo $row['MiddleName']."/*/";
		echo $row['Class']."/*/";

		$A2 = $Link->query("SELECT Author FROM `LibraryBooks` WHERE `Inv`=".$row['Book']);
		$A3 = $A2->fetch_array(MYSQLI_ASSOC);
		$A3['Author'] = mb_convert_encoding($A3['Author'], 'utf8', 'cp1251');
		$result=$A3['Author'];
		echo "(id: ".$row['Book'].") ".$result." - ";

		$A4 = $Link->query("SELECT Name FROM `LibraryBooks` WHERE `Inv`=".$row['Book']);
		$A5 = $A4->fetch_array(MYSQLI_ASSOC);
		$A5['Name'] = mb_convert_encoding($A5['Name'], 'utf8', 'cp1251');
		$result=$A5['Name'];
		echo $result."/*/";

		echo date("d.m.Y", strtotime($row['DateStart']))."/*/";
		echo $row['Duration']."/*/";

		$dateAt = strtotime('+'.$row['Duration'].' day', strtotime($row['DateStart']));
		$DateStop = date('d.m.Y', $dateAt);
		echo $DateStop."/*/";

		if(strtotime(date("d.m.Y")) > strtotime($DateStop))
		{
			echo "2"."/*/";
		}else{
			echo "3"."/*/"; 
		}
	}
	mysqli_close($Link);
?>
