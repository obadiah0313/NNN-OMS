<?php
	require 'Database.php';
	require 'vendor/autoload.php';
	use PHPMailer\PHPMailer\PHPMailer;
	$db = new MongodbDatabase();
	if(isset($_POST['action'])){
		if($_POST['name']!= null && $_POST['email'] != null && $_POST['phone'] != null && $_POST['password'] != null){
			if($db->checkUserExist($_POST['email']) != null){
				echo json_encode(['type' => 'warning', 'msg' => "Account already exists..."]);
			}
			else{
				$db->insertUser($_POST['name'],$_POST['phone'],$_POST['email'],md5($_POST['password']),"staff",true);
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
				$mail->addAddress($_POST['email'], $_POST['name']); 

				$mail->Subject = 'Staff Account Created';

				$mail->isHTML(true);

				$mailContent = '<html>
				<h1 style="text-align:center; margin-top:2px; margin-bottom:2px;">Staff Account Created Successfully</h1>
				<p style="text-align:center">Your auto-generated PASSWORD is <u><strong>'.$_POST['password'].'</strong></u>.</p> 
				<p style="text-align:center;color:red">***PLEASE CHANGE YOUR PASSWORD ONCE YOU LOGIN INTO THE SYSTEM***</p>
				</html>';
				$mail->Body = $mailContent;

				if($mail->send()){
					echo json_encode(['type' => 'success', 'msg' => "Account created successfully!"]);
				}				
			}
		}
	}
?>