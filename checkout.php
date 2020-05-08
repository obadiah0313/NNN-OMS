<?php
	//error_reporting(0);
	require './Database.php';	
	$db = new MongodbDatabase();
	if (isset($_POST['action'])) {
		if($db->checkCartExists($_POST['uid']) != null){
			$db->updateStatus($_POST['uid'], $_POST['remark']);
			echo json_encode(["type" => "success", "msg" => "Checkout Successfully"]);
		}
		else
			echo json_encode(["type" => "error", "msg" => "Checkout Unuccessfully"]);
	}
?>