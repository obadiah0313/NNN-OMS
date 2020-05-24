<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/overhang.min.css">
	<link rel="stylesheet" href="css/style.css">
	<title>Neko Neko Nyaa</title>
</head>

<body class="bg">
	<?php
		include "NavBar.php";
	?>
	<div class="page-container mt-3">
<?php

	//error_reporting(0);
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
// Load Composer's autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';


$fullname = $_POST['fullname'];
$phone= $_POST['phone'];
$email= $_POST['email'];
$password= md5($_POST['password']);

if(isset($_SESSION))
{session_destroy();}

$code=rand(1000,9999);
session_start();
$_SESSION['code'] = $code;

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
$mail->isSMTP();

try {
    //Server settings
    $mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'testingneko123@gmail.com'; 
	$mail->Password = 'testing123~'; 
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAutoTLS = false;
	$mail->Port = 587;// TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('testingneko123@gmail.com', 'Neko Neko Nyaa');
    $mail->addAddress($email);     // Add a recipient
    $mail->addReplyTo('testingneko123@gmail.com', 'Neko Neko Nyaa');

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Confirmation code';
    $mail->Body    = 'This is your code : <b>'.$code.'</b>';

    $mail->send();
    echo 'Confirmation code have been sent to ' .$email;
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

    echo"<form action='addUserConfirm.php?fullname=".$fullname."&phone=".$phone."&email=".$email."&password=".$password."' id='confirm' method='POST'>
    <p>Refresh the page to resend a new code.</p>
<label for='code'>Enter confirmation code:</label>
<input type='text' id='confirm' name='confirm' style='margin-right:10px;'>
<button form='confirm' value='submit'>confirm</button>
</form>";

?>
        </div>
<?php include './Footer.php'?>
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	</body></html>



