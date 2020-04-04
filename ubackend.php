<?php
	//session_start();
	error_reporting(0);
	require './Database.php';	
	$db = new MongodbDatabase();
	if (isset($_POST['data'])) {	
		if ($db->checkExists() != null) {
			$db->replaceStock(date("Y-m-d"),$_POST['data']);
			//$_SESSION['upload'] = true;
//			echo "replaced";
			echo json_encode(["type" => "success", "msg" => "Replaced successfully!"]);
		}
		else{
			$db->insertStock(date("Y-m-d"),$_POST['data']);
			$db->insertDeletion(date("Y-m-d"),$_POST['data2']);
			//$_SESSION['upload'] = true;
//			echo "success";
			echo json_encode(["type" => "success", "msg" => "Insert successfully!"]);
		}
	}
?>