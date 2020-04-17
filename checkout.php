<?php
	//error_reporting(0);
	require './Database.php';	
	$db = new MongodbDatabase();
	if (isset($_POST['action'])) {
		if($db->checkCartExists($_POST['oid']) != null){
			$db->updateStatus($_POST['oid'], $_POST['remark']);
			echo json_encode(["type" => "success", "msg" => "Checkout Successfully"]);
		}
		else
			echo json_encode(["type" => "error", "msg" => "Checkout Unuccessfully"]);
	}
?>