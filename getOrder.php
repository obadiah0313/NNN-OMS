<?php
	session_start();
	require './Database.php';
	$db = new MongodbDatabase();
	$orderList = [];
	foreach($db->loadOrder() as $order){
		$temp = array(
			'check' => '<input class="common_selector" type="checkbox" value="'.(string)$order['_id'].'" id="order">',
			'oid' => (string)$order['_id'],
			'date' => $order['date'],
			'user' => $db->getUserName((string)$order['uid']),
			'cart' => $order['carts'],
			'status'=> $order['status'],
			'view' => '<button class="button allBtn item mb-1" id="btnView" value="'.(string)$order['_id'].'">View <i class="fas fa-eye"></i></button>',
		);	
		array_push($orderList,$temp);	
	}	
	echo json_encode($orderList);
?>