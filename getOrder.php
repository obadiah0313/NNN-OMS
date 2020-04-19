<?php
	require './Database.php';
	$db = new MongodbDatabase();
	$orderList = [];
	foreach($db->loadOrder() as $order){
		$temp = array(
			'oid' => $order['oid'],
			'date' => $order['date'],
			'user' => $order['uid'],
			"remove" => '<button class="button allBtn item" id="btnRemove" value="'.$order['oid'].'">Remove <i class="far fa-times-circle"></i></button>'
		);	
		array_push($orderList,$temp);	
	}	
	echo json_encode($orderList);
?>