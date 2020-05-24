<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/overhang.min.css">
	<link rel="stylesheet" href="css/style.css">
	<title>Neko Neko Nyaa</title>
</head>

<body class="bg">
	<?php
		include "NavBar.php";
	?>
	<div class="page-container mt-3">
<?php
require './Database.php';
$db = new MongodbDatabase();
$fullname = $_GET["fullname"];
$phone = $_GET["phone"];
$email = $_GET["email"];
$password = $_GET["password"];

    if (isset($_POST['confirm'])){
        if ($_POST['confirm'] == $_SESSION['code']){
        $db->insertUser($fullname, $phone, $email, $password, "customer", true);
            session_destroy();
            header("Location:./index.php");
        }
        else{
            echo 'Wrong code. Navigate back to refill your credentials.';
        }
    }
?>
        </div>
<?php include './Footer.php'?>
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	</body></html>
