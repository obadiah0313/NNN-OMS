<?php
session_start();
	require 'Database.php';

$db = new MongodbDatabase();
$_id = $_SESSION['_id'];
$fullname = $_SESSION["fullname"];
$phone = $_SESSION["phone"];
$email = $_SESSION["email"];
$password = $_SESSION["password"];
$opassword = $_POST['oldpassword'];
$npassword = $_POST['newpassword'];
$rpassword = $_POST['retypenewpassword'];
$type = $_SESSION['type'];

$opasswordlength= strlen($opassword);
$npasswordlength= strlen($npassword);
$rpasswordlength= strlen($rpassword);


if(($opasswordlength > 7) && ($npasswordlength > 7) && ($rpasswordlength > 7)){
if(md5($opassword)==$password){
    if($rpassword==$npassword){
        if($npassword!=$opassword){

$db->updatePass($_id,md5($npassword));

session_destroy();
session_start();

$_SESSION['_id'] = $_id;
$_SESSION['fullname'] = $fullname;
$_SESSION['phone'] = $phone;
$_SESSION['email'] = $email;
$_SESSION['password'] = md5($npassword);
$_SESSION['type'] = $type;
    

header("Location:Profile.php");
}
else{
    $_SESSION['error'] = "New password is the same as old password.";
    header("Location:Password.php");
}}
else{
    $_SESSION['error'] = "New password confirmation do not match.";
    header("Location:Password.php");
}}
else{
    $_SESSION['error'] = "Current password incorrect.";
    header("Location:Password.php");
}}
else{
    $_SESSION['error'] = "Passwords cannot be less than 8 characters";
    header("Location:Password.php");
}
?>
