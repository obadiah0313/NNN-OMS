<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Neko Neko Nyaa</title>
	<link rel="icon" href="img/neko.png">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/login.css">
	<link rel="stylesheet" href="css/overhang.min.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
</head>
<body class="bg">
	<?php include './NavBar.php'; ?>
	<div class="page-container">
		<div class="row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="text-center col-12 py-3">
				<h2>Reset Password</h2>
			</div>
		</div>
		<div class="row my-3 py-3 justify-content-center" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="col-3">
				<h5 class="text-center">Enter your <b>Registered Email</b></h5>
				<input id="email" name="email" type="email" class="form-control mb-3" />
				<div class="text-center py-3">
					<button class="button allBtn" id="btnVerify">Verify</button>
				</div>				
			</div> 
		</div>
	</div>
	<?php include './Footer.php'; ?>
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/overhang.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script>
		$(document).on('click', '#btnVerify', function() {
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			if (document.getElementById("email").value.match(mailformat)) {
				$.ajax({
					url: './resetPwd.php',
					method: "POST",
					data: {
						action: "reset",
						email: document.getElementById("email").value
					},
					success: function(response) {
						response = JSON.parse(response);
						$("body").overhang({
							type: response.type,
							message: response.msg,
							callback:function(){
								window.location.href='./Login.php';
							}
						});
					}
				});
			}
			else {
				$("body").overhang({
					type: "error",
					message: "Wrong Email Format..."
				});
				document.getElementById("email").focus();
			}
		});
	</script>
</body>
</html>