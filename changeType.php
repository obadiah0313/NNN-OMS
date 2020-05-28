<?php
session_start();
if(!isset($_SESSION['_id']) || ($_SESSION['type'] == "customer" || $_SESSION['partner']))
{
	header("Location:index.php");
}

	require './Database.php';
$bulk = new MongoDB\Driver\BulkWrite;


$_id = $_GET["oid"];
$fullname = $_GET["fullname"];
$phone = $_GET["phone"];
$email = $_GET["email"];
$password = $_GET["password"];
$type = $_GET["type"];
$status = $_GET["status"];

if ($type=="customer"){
    $type="partner";
}
else if($type == "partner"){
    $type="customer";
}

if ($status==1){
    $status=true;
}
else{
    $status=false;
}

    try{$bulk->update(['_id'=>new MongoDB\BSON\ObjectId($_id)],['fullname' => $fullname,'phone' => $phone, 'email' => $email, 'password' => $password, 'type' => $type, 'status' => $status]);


        //$manager = new MongoDB\Driver\Manager('mongodb://localhost:27017');
        $manager = new MongoDB\Driver\Manager('mongodb://admin:admin123@ds239009.mlab.com:39009/heroku_0g0g5g6c?replicaSet=rs-ds239009&retryWrites=false');
        //$result = $manager->executeBulkWrite('NNNdb.user',$bulk);
        $result = $manager->executeBulkWrite('heroku_0g0g5g6c.user',$bulk);
        
            if(isset($_SESSION['fullname'])){
                if($_SESSION['type']=="admin"){
                    header("Location:userlist.php");
                }
                else if ($_SESSION['type']=="staff"){
                    header("Location:userlistStaff.php");
                }
            }
        
                
       }
catch (MongoDB\Driver\Exception\Exception $e){
    die("Error Encountered".$e);
}
?>

