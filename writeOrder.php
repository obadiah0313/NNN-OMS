<?php
	require './Database.php';
	require 'vendor/autoload.php';

	$db = new MongodbDatabase();
	$product =[];
	
	foreach ($db->getProduct() as $p){
		$item = [];
		foreach($db->getHeaders() as $h){
			foreach($p as $k=>$v){
				if($h == $k){
					$item[$h] = $v;
					break;
				}
			}
		}
		array_push($product, $item);	
	}
	

	$alphas = range('A','Z');
	$count = sizeof($db->getHeaders());
	$barcode = 0;
	$qty = 0;
	foreach ($db->getHeaders() as $k=>$v){
		if($v == "Barcode"){
			$barcode = $k;
		}
		if(strpos($v, "Quantity") !== false)
			$qty = $k;
	}

	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->setActiveSheetIndex(0);
	$sheet->setTitle("GBD_Asia");
	$sheet->fromArray($db->getHeaders(), NULL,'A1');
	$sheet->fromArray($product, NULL,'A2');
	$sheet->getRowDimension('1')->setRowHeight(30);
	
	$styleHeader = [
		'font' => [
			'bold' => true,
		],
	];
	$styleCell = [
		'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
		],
		'borders' => [
			'allBorders' => [
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			],
		]
	];
	$spreadsheet->getActiveSheet()->getStyle($alphas[0].'1:'.$alphas[$count-1].'1')->applyFromArray($styleHeader);
	$spreadsheet->getActiveSheet()->getStyle(
		$spreadsheet->getActiveSheet()->calculateWorksheetDimension()
	)->applyFromArray($styleCell);
	$spreadsheet->getActiveSheet()->getStyle($alphas[$barcode].'2:'.$alphas[$barcode].sizeof($product))
		->getNumberFormat()
		->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
	$spreadsheet->getActiveSheet()->getStyle($alphas[$qty].'2:'.$alphas[$qty].sizeof($product))
		->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()->setARGB('FFFF85');
	$spreadsheet->getActiveSheet()->freezePane('A2');


	for($i = 0 ; $i < $count; $i++)
	{
		$sheet->getColumnDimension($alphas[$i])->setAutoSize(true);
	}
		
	header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Order'.date("Ymd").'.xlsx"');
    header('Cache-Control: max-age=0');

	$writer = new Xlsx($spreadsheet);
	$writer->save('./Product_List/Order'.date("Ymd").'.xlsx');
	echo json_encode(["result" => "done"]);
?>