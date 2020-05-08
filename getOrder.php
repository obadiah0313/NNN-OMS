<?php
	require './Database.php';
	$db = new MongodbDatabase();
	$orderList = [];
	foreach($db->loadOrder() as $order){
		$temp = array(
			'check' => '<input type="checkbox" value="'.$order['oid'].'" id="order">',
			'oid' => $order['oid'],
			'date' => $order['date'],
			'user' => $order['uid'],
			'status'=> $order['status'],
			'view' => '<button class="button allBtn item mb-1" id="btnView" value="'.$order['oid'].'">View <i class="fas fa-eye"></i></button>',
		);	
		array_push($orderList,$temp);	
	}	
	echo json_encode($orderList);
?>