<?php 
	error_reporting(0);
	session_start();
?>
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
		<div class="row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
            <div class="col-12 py-3">
				<div class="text-center">
					<h2>Email Confirmation</h2>
				</div>
			</div>
        </div>
        <div class="row py-4" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';


$fullname = $_POST['fullname'];
$phone= $_POST['phone'];
$email= $_POST['email'];
$password= md5($_POST['password']);

if(isset($_SESSION))
{
	session_destroy();}

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
		echo 'Confirmation code have been sent to ' .$email.'. Please verify and enter the confirmation code at the given field.';
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

    echo"<center><form action='addUserConfirm.php?fullname=".$fullname."&phone=".$phone."&email=".$email."&password=".$password."' id='confirm' method='POST'>
    <p>Refresh the page to RESEND a new code if not receiving.</p>
<label for='code'>Enter confirmation code:</label>
<input type='text' id='confirm' name='confirm' style='margin-right:10px;'>
<button class='button allBtn' form='confirm' value='submit'>confirm</button>
</form></center>";

?>
        </div>
	</div>
<?php include './Footer.php'?>
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	</body></html>



