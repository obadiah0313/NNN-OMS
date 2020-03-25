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
	<div class="container page-container">
		<h3 class="text-center">Registration</h3>
		<form class="needs-validation" novalidate>
			<div class="mb-3">
				<label for="fullName">Full name</label>
				<input type="text" class="form-control" id="firstName" placeholder="" value="" required>
				<div class="invalid-feedback">
					Valid first name is required.
				</div>
			</div>

			<div class="mb-3">
				<label for="username">Username</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">@</span>
					</div>
					<input type="text" class="form-control" id="username" placeholder="Username" required>
					<div class="invalid-feedback" style="width: 100%;">
						Your username is required.
					</div>
				</div>
			</div>

			<div class="mb-3">
				<label for="email">Email</label>
				<input type="email" class="form-control" id="email" placeholder="you@example.com" required>
				<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
				<div class="invalid-feedback">
					Please enter a valid email address.
				</div>
			</div>

			<div class="mb-3">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="pwd" required>
				<small id="passwordHelpInline" class="text-muted">
					Must be 8-20 characters long.
				</small>
				<div class="invalid-feedback">
					Please enter a valid password.
				</div>
			</div>

			<div class="mb-3">
				<label for="cpassword">Confirm Password</label>
				<input type="password" class="form-control" id="cpwd" required>
				<small id="passwordHelpInline2" class="text-muted">
					Must be matched with the previous entry.
				</small>
				<div class="invalid-feedback">
					Please enter a valid password.
				</div>
			</div>

			<hr class="mb-4">
			<button class="btn btn-primary btn-lg btn-block" type="submit">Sign Up</button>
		</form>
	</div>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script>
		// Example starter JavaScript for disabling form submissions if there are invalid fields
		(function() {
			'use strict';

			window.addEventListener('load', function() {
				// Fetch all the forms we want to apply custom Bootstrap validation styles to
				var forms = document.getElementsByClassName('needs-validation');

				// Loop over them and prevent submission
				var validation = Array.prototype.filter.call(forms, function(form) {
					form.addEventListener('submit', function(event) {
						if (form.checkValidity() === false) {
							event.preventDefault();
							event.stopPropagation();
						}
						form.classList.add('was-validated');
					}, false);
				});
			}, false);
		})();

	</script>
</body>

</html>
