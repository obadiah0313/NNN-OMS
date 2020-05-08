<?php
$bulk = new MongoDB\Driver\BulkWrite;
$id = $_GET["id"];
try{
    $bulk->delete(['_id'=> new MongoDB\BSON\ObjectId($id)]);
    $manager= new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $result = $manager -> executeBulkWrite("heroku_0g0g5g6c.user",$bulk);
    header("Location:http://localhost/NNN-OMS-master/userlist.php");
} catch(MongoDB\Driver\Exception\Exception $e){
    die("Error Encountered:".$e);
}
?>