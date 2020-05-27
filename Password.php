<?php
session_start();
if(!isset($_SESSION['_id']))
		header('Location:./index.php');
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
</head>

<body class="bg">
	<?php include './NavBar.php'; ?>
	<div class="page-container">
		<div class="row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
            <div class="col-12 py-3">
				<div class="text-center">
					<h2>Change Password</h2>
				</div>
			</div>
        </div>
        <div class = "row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
            <div class="col-12 py-3">
            	<div class = "container-fluid">
                	<form action="passwordEdit.php" method="post" name="formpassword" id="formpassword"> 
                        <div class="form-group">
								<label for="exampleInputEmail1">Current Password</label>
								<input type="password" name="oldpassword" class="form-control" id="oldpassword" aria-describedby="emailHelp" placeholder="Enter Old Password">
                            </div>
                       <div class="form-group">
								<label for="exampleInputEmail1"> New Password</label>
								<input type="password" name="newpassword" id="newpassword" class="form-control" aria-describedby="emailHelp" placeholder="Enter New Password">
							</div>
                       <div class="form-group">
								<label for="exampleInputEmail1">Retype Password</label>
								<input type="password" name="retypenewpassword" id="retypenewpassword" class="form-control" aria-describedby="emailHelp" placeholder="Retype New Password">
                            </div>
                        <div class="row my-3">
                             <div class= "col-md-12"><p class="text-danger"><?php if (isset($_SESSION['error'])){
                                    echo $_SESSION['error'];
                                    $_SESSION['error'] = " "; ;}
                                    else {echo ' ';} ?><p></div>
                        </div>
                        <div class="row my-3">
                             <div class= "col-md-6"><button type="button" onclick="document.location.href = './Profile.php';"  class=" button allBtn btn-block">Cancel</button></div>
                            <div class= "col-md-6"><button type="submit" form="formpassword" class="button allBtn btn-block">Save Changes</button></div>
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
