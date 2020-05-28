<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
require './Database.php';
$db= new MongodbDatabase();
if(isset($_POST['action'])) {
	if($db->checkUserExist($_POST['email']) == null){
		echo json_encode(['type'=>'error', 'msg'=>"No account existed..."]);
	}
	else
	{
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$tempPwd = substr(str_shuffle($str_result), 0, 8);
		$id = $db->checkUserExist($_POST['email']);
		$name = $db->getUserName((string)$id);
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
		$mail->addAddress($_POST['email'], $name); 

		$mail->Subject = 'Resetting Password';

		$mail->isHTML(true);

		$mailContent = '<html>
						<h1 style="text-align:center; margin-top:2px; margin-bottom:2px;">Your Password has been Reset</h1>
						<p style="text-align:center">Login in the website with auto-generated PASSWORD is <u><strong>'.$tempPwd.'</strong></u>.</p>
						<br>
						<p style="text-align:center;color:red">***PLEASE CHANGE YOUR PASSWORD ONCE YOU LOGIN INTO THE SYSTEM***</p>
						</html>';
		$mail->Body = $mailContent;

		if($mail->send()){
			$db->updatePass($id, md5($tempPwd));
			echo json_encode(['type' => 'success', 'msg' => "Please check your Email."]);
		}	
	}
}
?>