<?php
session_start();
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

$email= $_POST["email"];
$password= md5($_POST["password"]);

$filter =['email' => $email, 'password' => $password];

$query = new MongoDB\Driver\Query($filter);
try {
    
    $result = $manager->executeQuery("NNNdb.user",$query);
    $row = $result->toArray();
    $_id =$row[0]->_id;
    $fullname = $row [0]->fullname; 
    $email = $row[0]->email;
    $phone = $row[0]->phone;
    $password = $row[0]->password;
    $type = $row[0]->type;
    
    $_SESSION['_id'] = $_id;
    $_SESSION['fullname'] = $fullname;
    $_SESSION['phone'] = $phone;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    $_SESSION['type'] = $type;
    
     header("Location:./index.php");
      
}
catch (MongoDB\Driver\Exception\Exception $e){
    die("Error Encountered:".$e);
}
?>
