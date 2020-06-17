<?php
session_start();
/* Database Connections */
$manager = new MongoDB\Driver\Manager('mongodb://admin:admin123@ds239009.mlab.com:39009/heroku_0g0g5g6c?replicaSet=rs-ds239009&retryWrites=false');

$email= $_POST["email"];
$password= md5($_POST["password"]);

$filter =['email' => $email, 'password' => $password];

$query = new MongoDB\Driver\Query($filter);
try {
    
    $result = $manager->executeQuery("heroku_0g0g5g6c.user",$query);
    $row = $result->toArray();
    $_id =$row[0]->_id;
    $fullname = $row [0]->fullname; 
    $email = $row[0]->email;
    $phone = $row[0]->phone;
    $password = $row[0]->password;
    $type = $row[0]->type;
	$status = $row[0]->status;
    
    $_SESSION['_id'] = $_id;
    $_SESSION['fullname'] = $fullname;
    $_SESSION['phone'] = $phone;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    $_SESSION['type'] = $type;
	$_SESSION['status'] = $status;
	if(isset($_SESSION['_id']) && $_SESSION['status'] == true)
    	header("Location:./index.php");
	else if(isset($_SESSION['_id']) && $_SESSION['status'] == false){
		session_destroy();
		header("Location:./Login.php?exist=true&status=false");
	}
	else{
		session_destroy();
		header("Location:./Login.php?exist=false");
	}
}
catch (MongoDB\Driver\Exception\Exception $e){
    die("Error Encountered:".$e);
	header("Location:./Login.php");
}
?>
