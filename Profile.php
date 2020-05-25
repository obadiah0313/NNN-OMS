<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Neko Neko Nyaa</title>
		<link rel="icon" href="img/neko.png">
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg">
	<?php include './NavBar.php'; ?>
	<div class="page-container">
        <div class="row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
            <div class="col-12 py-3">
				<div class="text-center">
					<h2>My Profile</h2>
				</div>
			</div>
        </div>
        <div class = "row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
            <div class="col-12 py-3">
                <div class = "container-fluid">
                    <h5>Full name</h5> 
                        <a><?php if (isset($_SESSION['fullname'])){
                                    echo $_SESSION['fullname'];}
                                 else {
                                     echo 'Guest';} ?></a>
                    <br><br>
                    <h5>Mobile</h5> 
                        <a><?php if (isset($_SESSION['phone'])){
                                    echo $_SESSION['phone'];}
                                 else {echo '-';} ?></a>
                    <br><br>
                    <h5>Email Address</h5> 
                        <a><?php if (isset($_SESSION['email'])){
                                    echo $_SESSION['email'];}
                                 else {echo '-';} ?></a>
                    <br><br>
                    <div class="row my-3">
                        <div class= "col-md-6"><button onclick="document.location.href = './EditProfile.php';" class=" button btn-block allBtn">Edit Profile</button></div>
                        <div class= "col-md-6"><button onclick="document.location.href = './Password.php';" class=" button btn-block allBtn">Change Password</button></div>
                    </div>
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
