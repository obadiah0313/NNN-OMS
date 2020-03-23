<?php
	error_reporting(0);
	require 'Database.php';
	$db = new MongodbDatabase();
	$data = [];
	foreach($db->fetchData() as $cl) {
		for($i = 0; $i <sizeof($cl['products']); $i++){
			$datas = array(
				"code" => $cl['products'][$i]['Product Code'],
				"desp" => $cl['products'][$i]['Description'],
				"mrp" => $cl['products'][$i]['MRP'],
				"sys" => $cl['products'][$i]['System'],
				"race" => $cl['products'][$i]['Race'],
				"type" => $cl['products'][$i]['Product Type'],
				"country" => $cl['products'][$i]['Country of Origin'],
				"button" => '<button>'.$i.'</button>'
			);
			array_push($data, $datas);
		}
	}
	//var_dump($data);
	echo json_encode($data);
?>