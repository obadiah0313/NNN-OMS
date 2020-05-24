<?php
require 'Database.php';
$db = new MongodbDatabase();
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
if(isset($_POST['action'])){
foreach($_POST['orders'] as $o)
{
	foreach($db->loadConfirmedOrder($o) as $detail)
	$count = 0;
	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'testingneko123@gmail.com'; 
	$mail->Password = 'testing123~'; 
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAutoTLS = false;
	$mail->Port = 587;

	$mail->setFrom('testingneko123@gmail.com', 'Neko Neko Nyaa');
	$mail->addReplyTo('testingneko123@gmail.com', 'Neko Neko Nyaa');
	$mail->addAddress($db->getUserEmail((string)$detail['uid']), $db->getUserName((string)$detail['uid'])); 

	$mail->Subject = 'Order Has Been Delivered to Store';

	$mail->isHTML(true);

	$mailContent = '<html>
	<h1 style="text-align:center; margin-top:2px; margin-bottom:2px;">Your Order ' .(string)$o('_id').' Received</h1> 
		<p style="text-align:center">Please come Pay and Pick Up for your order.</p>
		<p style="text-align:center">Thanks and Welcome to Order again.</p>
	</html>';
	$mail->Body = $mailContent;

	if($mail->send()){
		echo 'Message has been sent';
	}else{
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	}
}
}
