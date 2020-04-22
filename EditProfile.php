<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Neko Neko Nyaa</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/login.css">
</head>

<body class="bg">
	<?php include './NavBar.php'; ?>
	<div class="page-container">
		<div class="row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
            <div class="col-12 py-3">
				<div class="text-center">
					<h2>Edit Profile</h2>
				</div>
			</div>
        </div>
        <div class = "row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
            <div class="col-12 py-3">
                <div class = "container-fluid">
          			<form action="#" name="registration">
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
						<div class="row my-5">
                            <div class= "col-md-6"><button style="float: right;" onclick="document.location.href = 'Profile.php';"  class=" button btn-block allBtn">Cancel</button></div>
                            <div class= "col-md-6"><button type="submit" class="button allBtn btn-block">Save Changes</button></div>
                        </div>
					</form>
				</div>
            </div>
		</div>
	</div>
	
	<?php include './Footer.php'; ?>
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.validate.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/login.js"></script>
</body>

</html>
