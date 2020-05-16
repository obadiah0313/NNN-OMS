<?php	
	session_start();
	//error_reporting(0);
	require './Database.php';	
	$db = new MongodbDatabase();
	if (isset($_POST['action'])) {
		if($db->checkCartExists($_SESSION['_id']) != null){
			$db->updateStatus($_SESSION['_id'], $_POST['remark']);
			echo json_encode(["type" => "success", "msg" => "Checkout Successfully"]);
		}
		else
			echo json_encode(["type" => "error", "msg" => "Checkout Unuccessfully"]);
	}
?>