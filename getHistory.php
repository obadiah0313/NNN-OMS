<?php
	session_start();
	require 'Database.php';
	$db = new MongodbDatabase();
	echo json_encode($db->loadOrderHistory($_SESSION['_id']));
?>