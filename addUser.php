<?php 
	error_reporting(0);
	session_start();
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	require 'vendor/autoload.php';
	require 'Database.php';
	$db = new MongodbDatabase();


	$fullname = $_POST['fullname'];
	$phone= $_POST['phone'];
	$email= $_POST['email'];
	$password= md5($_POST['password']);
	
	
	if($db->checkUserExist($email) != null)
	{
		header("Location:./Login.php?exist=true");
	}
	else
	{
		if(isset($_SESSION['code']))
		{
			unset($_SESSION['code']);
		}
		$code=rand(1000,9999);
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
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/overhang.min.css">
		<link rel="stylesheet" href="css/style.css">
		<title>Neko Neko Nyaa</title>
		<link rel="icon" href="img/neko.png">
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
				<div class="col-12">
					<h5 class="text-center">Confirmation code have been sent to <strong><i><?php echo $email; ?></i></strong>.</h5>

					<p class="text-center">Please verify and enter the confirmation code at the given field to activate your account.</p>
					<br>
					<div class="text-center">
							<a href="javascript:window.location.reload(true)">Click to RESEND a new code if not receiving.</a>
							<br>
							<label for='code'>Enter confirmation code:</label>
							<input type='text' id='confirm' name='confirm' style='margin-right:10px;'>
							<button id="btnConfirm" class='button allBtn' form='confirm'>Confirm</button>
					</div>
				</div>

			</div>
		</div>
		<?php include './Footer.php'?>
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="js/overhang.min.js"></script>
		<script src="js/popper.min.js"></script>
		<script src="js/bootstrap.bundle.min.js"></script>
		<script type="text/javascript">
			$(document).on('click', '#btnConfirm', function() {
			var code = <?php echo $_SESSION['code']; ?>;
			if (code == document.getElementById('confirm').value){
				$("body").overhang({
					type: "success",
					message: "Confirmation Code Matched"
				});
				$.ajax({
					url: "./addUserConfirm.php",
					method: "POST",
					data: {
						action: "addUser",
						email: "<?php echo $email;?>",
						fullname: "<?php echo $fullname;?>",
						password: "<?php echo $password;?>",
						phone: "<?php echo $phone;?>"
					},
					success:function(data){
						data = JSON.parse(data);
						$("body").overhang({
							type: data.type,
							message: data.msg,
							callback: function() {
								window.location.replace("./Login.php");
							}
						});
					}
				});
			}
			else{
				$("body").overhang({
					type: "error",
					message: "Wrong Confirmation Code, Please check again..."
				});
			}
		});
		</script>
	</body>

	</html>	
<?php }
?>