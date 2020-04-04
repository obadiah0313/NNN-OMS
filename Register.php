<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Neko Neko Nyaa - Registration</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/register.css">
</head>

<body>
	<?php include './NavBar.php'?>
	<div class="container mt-2">
		<h3 class="text-center">Registration</h3>
		<form class="needs-validation" id="registerForm" novalidate>
			<div class="mb-3 form-group">
				<label for="fullName">Full name</label>
				<input type="text" class="form-control" id="firstName" required>
				<div class="valid-feedback">Valid</div>
				<div class="invalid-feedback">
					Valid first name is required.
				</div>
			</div>

			<div class="mb-3 form-group">
				<label for="phone">Phone</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">+6</span>
					</div>
					<input type="text" class="form-control" id="phone" placeholder="0123456789" required onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
					<div class="valid-feedback">Valid</div>
					<div class="invalid-feedback">
						Your phone number is required.
					</div>
				</div>
			</div>

			<div class="mb-3 form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control" id="email" placeholder="you@example.com" required>
				<div class="invalid-feedback">
					Please enter a valid email address.
				</div>
			</div>

			<div class="mb-3 form-group">
				<label for="pwd">Password&nbsp;</label><small id="passwordHelpInline" class="text-muted">Must be 8-20 characters long.</small>
				<input type="password" class="form-control pwds" id="pwdId" pattern="^[A-Za-z0-9]{8,20}$" required>
				<input type="checkbox" onclick="showPwd()">Show Password
			</div>

			<div class="mb-3 form-group">
				<label for="cpwd">Confirm Password&nbsp;</label><small id="passwordHelpInline2" class="text-muted">Must be matched with the previous entry.</small>
				<input type="password" class="form-control pwds" id="cPwdId" pattern="^[A-Za-z0-9]{8,20}$" required>
				<input type="checkbox" onclick="showcPwd()">Show Password
				<div id="cPwdValid" class="valid-feedback">Matched</div>
				<div id="cPwdInvalid" class="invalid-feedback">Please enter a valid password.</div>
			</div>

			<hr class="mb-4">
			<small class="form-text text-muted"><strong class="text-danger"> * </strong>We'll never share your personal information with anyone else.</small>
			<div class="form-group">
				<button class="btn btn-primary btn-lg btn-block submit-button" type="submit" id="submitBtn" disabled>Sign Up</button>
			</div>
		</form>
	</div>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#pwdId, #cPwdId').on('keyup', function() {
				if ($('#pwdId').val() != '' && $('#cPwdId').val() != '' && $('#pwdId').val() == $('#cPwdId').val()) {
					$("#submitBtn").attr("disabled", false);
					$('#cPwdValid').show();
					$('#cPwdInvalid').hide();
					$('#cPwdValid').html('Matched').css('color', 'green');
					$('.pwds').removeClass('is-invalid')
				} else {
					$("#submitBtn").attr("disabled", true);
					$('#cPwdValid').hide();
					$('#cPwdInvalid').show();
					$('#cPwdInvalid').html('Not Matching').css('color', 'red');
					$('.pwds').addClass('is-invalid')
				}

			});

			let form1 = document.getElementById('registerForm');
			form1.addEventListener('submit', function(event) {
				if (form1.checkValidity() === false) {
					event.preventDefault();
					event.stopPropagation();
				}
				form1.classList.add('was-validated');
			}, false);

			form1.querySelectorAll('.form-control').forEach(input => {
				input.addEventListener(('input'), () => {
					if (input.checkValidity()) {
						input.classList.remove('is-invalid');
						input.classList.add('is-valid');
					} else {
						input.classList.remove('is-valid');
						input.classList.add('is-invalid');
					}
					var is_valid = $('.form-control').length === $('.form-control.is-valid').length;
					$("#btnRegister").attr("disabled", !is_valid);
				});
			});
		});
		
		function showPwd() {
				var x = document.getElementById("pwdId");
				if (x.type === "password") {
					x.type = "text";
				} else {
					x.type = "password";
				}
			}
			
			function showcPwd() {
				var y = document.getElementById("cPwdId");
				if (y.type === "password") {
					y.type = "text";
				} else {
					y.type = "password";
				}
			}

	</script>
</body>

</html>
