<?php
	include "LibrarySystemLib.php"; 
	require_once 'PHPExcel.php';
	if(file_exists('Отчёт.xlsx')) { unlink('Отчёт.xlsx'); }

	// ---------------EXCEL---------------
	$Excel = new PHPExcel();
	$validLocale = PHPExcel_Settings::setLocale('ru');
	$Excel->setActiveSheetIndex(0);
	$Sheet = $Excel->getActiveSheet();

	$Sheet->getPageSetup()
       ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$Sheet->getPageSetup()
	       ->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

   $Excel->getProperties()
	    ->setCreator("CatDev's Studios")
	    ->setLastModifiedBy("CatDev")
	    ->setTitle("Отчёт из электронного каталога МАОУ 'Академический лицей'")
	    ->setSubject("Отчёт таблицы книг")
	    ->setDescription("Отчёт из электронного каталога МАОУ 'Академический лицей'");

	// Поля документа
	$Sheet->getPageMargins()->setTop(0.75);
	$Sheet->getPageMargins()->setRight(0.24);
	$Sheet->getPageMargins()->setLeft(0.24);
	$Sheet->getPageMargins()->setBottom(0.75);
	// Название листа
	$Sheet->setTitle('Отчёт');
	// Шапка и футер (при печати)
	$Sheet->getHeaderFooter()
	       ->setOddHeader('Отчёт из электронного каталога МАОУ "Академический лицей"');
	$Sheet->getHeaderFooter()
	       ->setOddFooter('&L&B'.(new DateTime())->add(new DateInterval('PT2H'))->format("d.m.y H:i").'&R');
	// Настройки шрифта
	$Excel->getDefaultStyle()->getFont()->setName('Times New Roman');
	$Excel->getDefaultStyle()->getFont()->setSize(12);
	
	$Sheet->getColumnDimension('A')->setWidth(12.14);
	$Sheet->getColumnDimension('B')->setWidth(10.14);
	$Sheet->getColumnDimension('C')->setWidth(9.43);
	$Sheet->getColumnDimension('D')->setWidth(15.57);
	$Sheet->getColumnDimension('E')->setWidth(38.5);
	$Sheet->getColumnDimension('F')->setWidth(8.71);
	$Sheet->getColumnDimension('G')->setWidth(14);
	$Sheet->getColumnDimension('H')->setWidth(14.43);
	$Sheet->getColumnDimension('I')->setWidth(12);

	$Sheet->getRowDimension('1')->setRowHeight(47.25);

	$Sheet->setCellValue('A1','Дата получения книги');
	$Sheet->setCellValue('B1','Инвента-рный номер');
	$Sheet->setCellValue('C1','Отметка о проверке');
	$Sheet->setCellValue('D1','Автор');
	$Sheet->setCellValue('E1','Название');
	$Sheet->setCellValue('F1','Год издания');
	$Sheet->setCellValue('G1','Цена');
	$Sheet->setCellValue('H1','Номер записи в КСУ');
	$Sheet->setCellValue('I1','Номер и дата акта выбытия');

	$Filter = GetPost('Filter');
	$count = $Link->query("SELECT COUNT(1) FROM `LibraryBooks` ".$Filter);
	$count = mysqli_fetch_array($count);

	$A1 = $Link->query("SELECT * FROM `LibraryBooks` ".$Filter);
	$i = 0;
	while ($row = $A1->fetch_assoc())
	{
		$Sheet->getRowDimension(2+$i)->setRowHeight(28.5);
		$row['Author'] = mb_convert_encoding($row['Author'], 'utf8', 'cp1251');
		$row['Name'] = mb_convert_encoding($row['Name'], 'utf8', 'cp1251');
		
		$Sheet->setCellValue('B'.(string)(2+$i), $row['Inv']);
		$Sheet->setCellValue('D'.(string)(2+$i), $row['Author']);
		$Sheet->setCellValue('E'.(string)(2+$i), $row['Name']);
		$Sheet->setCellValue('F'.(string)(2+$i), $row['Year']);
		$Sheet->setCellValue('G'.(string)(2+$i), $row['Cost']);
		$Sheet->setCellValue('J'.(string)(2+$i), $row['ID']);
		$i++;
	}

	$Sheet->getStyle('A1:I'.(string)(1+$i))
		->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$Sheet->getStyle('A1:I'.(string)(2+$i))
		->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	$Sheet->getStyle('A1:I'.(string)(1+$i))
		->getAlignment()->setWrapText(true);

	//
	$Sheet->mergeCells('A'.(string)(2+$i).':F'.(string)(2+$i));
	$Sheet->getStyle('A'.(string)(2+$i).':F'.(string)(2+$i))
		->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$Sheet->setCellValue('A'.(string)(2+$i), "Итог:");
	$Sheet->setCellValue('G'.(string)(2+$i), "=SUM(G2:G".(string)(1+$i).")");

	$Sheet->getStyle('G2:G'.(string)(2+$i))
		->getNumberFormat()->setFormatCode('_-* # ##0.00 ₽_-;-* # ##0.00 ₽_-;_-* "-"?? ₽_-;_-@_-');


	$border = array(
		'borders'=>array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'))));

 	$Sheet->getStyle('A1:I'.(string)(2+$i))->applyFromArray($border);
 	$Sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);
	$Sheet->getPageSetup()->setPrintArea('A1:I'.(string)(2+$i));
	$objWriter = PHPExcel_IOFactory::createWriter($Excel, 'Excel2007');
	$objWriter->save('Отчёт.xlsx');
	if($objWriter){
		echo "Готово";
	}
	mysqli_close($Link);
?>
			