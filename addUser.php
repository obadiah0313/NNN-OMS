<?php
	error_reporting(0);
	require 'Database.php';


$db = new MongodbDatabase();
$fullname = $_POST['fullname'];
$phone= $_POST['phone'];
$email= $_POST['email'];
$password= md5($_POST['password']);

       
$db->insertUser($fullname, $phone, $email, $password,"staff");
header("Location:Login.php");
?>
