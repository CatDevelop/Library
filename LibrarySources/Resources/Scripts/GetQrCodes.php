<?php
	include "LibrarySystemLib.php"; 
	include "PHPqrcode/qrlib.php";
	mysqli_set_charset($Link, 'utf8');

	$Values = GetPost('Values');
	//echo $Values;

	//if(isset($_GET['Values'])) { $Values = $_GET['Values']; }
	//$Values = mb_convert_encoding($Values, 'windows-1251', mb_detect_encoding($Values));
	//$Values = trim($Values);
	//$Values = stripslashes($Values);
	$Values = explode('/*/', $Values);

	if(file_exists('QrCodes.zip')) { unlink('QrCodes.zip'); }

	$Zip = new ZipArchive();
    $Zip->open('QrCodes.zip', ZipArchive::CREATE);

	for ($i = 1; $i <= $Values[0]; $i++) {
    	$A1 = $Link->query("SELECT * FROM `LibraryBooks` WHERE `id`=".$Values[$i]);
    	$row = $A1->fetch_assoc();

    	$QrCodeText = "ID: ".$row['id'].";\nИнв. номер: ".$row['Inv'].";\nАвтор: ".$row['Author'].";\nНазвание: ".$row['Name'].".";
		QRcode::png($QrCodeText, "QrCodes/QrCodeText.png", "Q", 2, 2);


		// КАРТИНКА
		$dest = imagecreatefrompng('PHPqrcode/QrCodeTemplate.png');
		$src = imagecreatefrompng('QrCodes/QrCodeText.png');

		imagealphablending($dest, false);
		imagealphablending($src, false);
		imagesavealpha($dest, true);
		imagesavealpha($src, true);

		$Size = getimagesize('QrCodes/QrCodeText.png');
		$Width = $Size[0];
		$Height = $Size[1];

		imagecopymerge($dest, $src, 32, 64, (-1)*((150-$Width)/2), (-1)*((150-$Height)/2), 150, 150, 100);


		// ТЕКСТ
		$TextSize = imagettfbbox(14, 0, "PHPqrcode/QrCodeFont.ttf", $row['Inv']);
		imagettftext($dest, 14, 0, (214-$TextSize[2])/2, 234, imagecolorallocate($dest, 0, 0, 0), "PHPqrcode/QrCodeFont.ttf", $row['Inv']); // Функция нанесения текста
		


		// СОХРАНЕНИЕ КАРТИНКИ
		imagepng($dest, 'QrCodes/QRCode - '.$row['Inv'].'.png');
		imagedestroy($dest);

		$Zip->addFile('QrCodes/QRCode - '.$row['Inv'].'.png', 'QRCode - '.$row['Inv'].'.png');

		unlink('QrCodes/QrCodeText.png');
    }

	$Zip->close();

	if (file_exists('QrCodes/')) {
	    foreach (glob('QrCodes/*') as $file) {
	        unlink($file);
	    }
	}

	echo "Qr-коды успешно созданы!";

	mysqli_close($Link);
?>
