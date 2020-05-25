<?php
	session_start();
	require 'Database.php';
	$db = new MongodbDatabase();
	if($db->loadOrderHistory($_SESSION['_id']) != null)
	echo json_encode($db->loadOrderHistory($_SESSION['_id']));
?>