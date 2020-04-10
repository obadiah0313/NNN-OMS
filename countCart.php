<?php
	error_reporting(0);
	require './Database.php';
	$db = new MongodbDatabase();
	if(isset($_POST["action"])){
		$uid = "001";
		$count = 0;
		foreach($db->loadCart($uid) as $cart) {
			foreach(iterator_to_array($cart['carts']) as $k=>$v){
				$count += $v;
			}
			break;
		}
		echo json_encode(["type" => "success", "msg" => "You have ".$count." item(s) in cart"]);
		
	}
?>
