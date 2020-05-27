<?php 
	require 'Database.php';
	$db= new MongodbDatabase();
	echo $db->checkUserExist("obadiah@gmail.com");
?>