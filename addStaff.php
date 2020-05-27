<?php
session_start();
if(!isset($_SESSION['_id']) || $_SESSION['type']=='customer'||$_SESSION['type']=='partner')
		header('Location:./index.php');
?>
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
</head>

<body class="bg">
	<?php include './NavBar.php'; ?>

	<div class="page-container">
		<div class="row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="col-12 py-3">
				<div class="text-center">
					<h2>Staff Registration</h2>
				</div>
			</div>
		</div>
		<div class="row my-3 justify-content-center" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="col-auto py-3">
				<h4 class="text-center mb-4">Staff Information</h4>
				<center>
				<table cellpacing="5" cellpadding="5" class="m-0">
					<tr>
						<td>Full Name</td>
						<td><input id="name" name="name" type="text" class="form-control" /></td>
					</tr>
					<tr>
						<td>Phone</td>
						<td><input id="phone" name="phone" type="tel" class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input id="email" name="email" type="email" class="form-control" /></td>
					</tr>
				</table>
				</center>
				<input class="d-none" id="pwd" name="pwd" type="text" readonly />
				<div class="text-center py-3">
					<p class="text-danger font-weight-bold">*Password will be auto-generated and Send to the Email</p>
					<button class="button allBtn" id="btnRegister">Register</button>
				</div>
			</div>
		</div>
	</div>

	<?php include './Footer.php'; ?>
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/overhang.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="Table-Sortable/table-sortable.js"></script>
	<script>
		$(document).ready(function() {
			var pwd = randomString(8, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
			document.getElementById("pwd").value = pwd;

			function randomString(length, chars) {
				var result = '';
				for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
				return result;
			}
		});

		function ValidateEmail(mail) {
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			if (mail.match(mailformat)) {
				return true;
			}
		}

		$(document).on('click', '#btnRegister', function() {
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			if (document.getElementById("email").value.match(mailformat)) {
				$.ajax({
					url: './registerStaff.php',
					method: "POST",
					data: {
						action: "register",
						name: document.getElementById("name").value,
						phone: document.getElementById("phone").value,
						email: document.getElementById("email").value,
						password: document.getElementById("pwd").value,
					},
					success: function(response) {
						response = JSON.parse(response);
						$("body").overhang({
							type: response.type,
							message: response.msg
						});
					}
				});
			} else {
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
