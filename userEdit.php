<?php
session_start();
	require 'Database.php';

$db = new MongodbDatabase();
$_id = $_SESSION['_id'];
$fullname = $_POST["fullname"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$password = $_SESSION['password'];
$type = $_SESSION['type'];

if($fullname && $phone && $email){
$db->updateUser($_id,$fullname, $phone, $email);

session_destroy();
session_start();

$_SESSION['_id'] = $_id;
$_SESSION['fullname'] = $fullname;
$_SESSION['phone'] = $phone;
$_SESSION['email'] = $email;
$_SESSION['password'] = $password;
$_SESSION['type'] = $type;
    

header("Location:Profile.php");
}
else{
$_SESSION['fullname'] = $fullname;
$_SESSION['phone'] = $phone;
$_SESSION['email'] = $email;
    $_SESSION['error'] = "Please fill in all areas.";
    header("Location:EditProfile.php");
}

?>
