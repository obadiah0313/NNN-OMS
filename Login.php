<?php
	error_reporting(0);
	?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Neko Neko Nyaa</title>
		<link rel="icon" href="img/neko.png">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/login.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/overhang.min.css">
</head>

<body class="bg">
	<?php include './NavBar.php'; ?>
	<?php if (isset($_SESSION['fullname'])){
     header("Location:./index.php");}?>
	<div class="container loginform">
		<div class="row">
			<div class="col-md-5 mx-auto">
				<div id="first">
					<div class="myform form ">
						<div class="logo mb-3">
							<div class="col-md-12 text-center">
								<h1>Login</h1>
							</div>
						</div>
						<form action="checkLogin.php" id="form1" method="post" name="login">
							<div class="form-group">
								<label for="exampleInputEmail1">Email address</label>
								<input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Password</label>
								<input type="password" name="password" id="password" class="form-control" aria-describedby="emailHelp" placeholder="Enter Password">
							</div>
							<div class="form-group">
								<p class="text-center">By signing up you accept our <a href="#">Terms Of Use</a></p>
							</div>
							<div class="col-md-12 text-center ">
								<button type="submit" id="form1" class=" button btn-block allBtn btn-outline-warning tx-tfm">Login</button>
							</div>
							<div class="col-md-12 ">
								<div class="login-or">
									<hr class="hr-or">
									<span class="span-or">or</span>
								</div>
							</div>
							<div class="form-group">
								<p class="text-center">Don't have account? <a href="#" id="signup">Sign up here</a></p>
							</div>
						</form>

					</div>
				</div>
				<div id="second">
					<div class="myform form ">
						<div class="logo mb-3">
							<div class="col-md-12 text-center">
								<h1>Signup</h1>
							</div>
						</div>
						<form action="addUser.php" method="post" name="registration" id="form2">
							<div class="form-group">
								<label for="exampleInputEmail1">Full Name</label>
								<input type="text" name="fullname" class="form-control" id="fullname" aria-describedby="emailHelp" placeholder="Enter Full Name">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Phone</label>
								<input type="tel" name="phone" class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter Phone" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Email address</label>
								<input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Password</label>
								<input type="password" name="password" id="password" class="form-control" aria-describedby="emailHelp" placeholder="Enter Password">
							</div>
							<div class="col-md-12 text-center mb-3">
								<button type="submit" form="form2" value="Submit" class="button allBtn btn-block btn-outline-warning tx-tfm">Get Started For Free</button>
							</div>
							<div class="col-md-12 ">
								<div class="form-group">
									<p class="text-center"><a href="#" id="signin">Already have an account?</a></p>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include './Footer.php'; ?>
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/overhang.min.js"></script>
	<script src="js/jquery.validate.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/login.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var exist = <?php echo $_GET['exist']; ?>;
			if(exist == true){
				$("body").overhang({
					type: "error",
					message: "Account Exists......"
				});
			}
			else if(exist == false) {
				$("body").overhang({
					type: "error",
					message: "No Account Registered Yet, Please Sign Up First."
				});
			}
		});
	</script>
</body>

</html>
