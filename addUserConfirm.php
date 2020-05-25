<?php
	require './Database.php';
	$db = new MongodbDatabase();
	$fullname = $_POST["fullname"];
	$phone = $_POST["phone"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$db->insertUser($fullname, $phone, $email, $password, "customer", true);
	echo json_encode(["type" => "success", "msg" => "Account Registered and Activated. Perform Login now."]);
?>
            