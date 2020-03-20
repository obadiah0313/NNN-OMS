<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Neko Neko Nyaa</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/nav.css">
</head>

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header border-bottom-0">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-title text-center">
					<h4>Login</h4>
				</div>
				<div class="d-flex flex-column text-center">
					<form>
						<div class="form-group">
							<input type="email" class="form-control" id="email1" placeholder="Your email address...">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" id="password1" placeholder="Your password...">
						</div>
						<button type="button" class="btn btn-info btn-block btn-round">Login</button>
					</form>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-center">
				<div class="signup-section">Not a member yet? <a href="#a" class="text-info"> Sign Up</a>.</div>
			</div>
		</div>

	</div>
</div>

<body>
	<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark" role="navigation">
		<div class="container">
			<a class="navbar-brand" href="#">Neko Neko Nyaa</a>
			<button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
				&#9776;
			</button>
			<div class="collapse navbar-collapse" id="exCollapsingNavbar">
				<ul class="nav navbar-nav">
					<li class="nav-item"><a href="#" class="nav-link">Catalogue</a></li>
					<li class="nav-item"><a href="#" class="nav-link">Order</a></li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Management
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="#">Customer</a>
							<a class="dropdown-item" href="#">Order</a>
						</div>
					</li>
				</ul>
				<button class="btn btn-success justify-content-between ml-auto" type="button" data-toggle="modal" data-target="#loginModal">Login</button>
			</div>
		</div>

	</nav>

</body>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script>
	$(document).ready(function() {
		//$('#loginModal').modal('show');
		$(function() {
			$('[data-toggle="tooltip"]').tooltip()
		})
	});

</script>

</html>
