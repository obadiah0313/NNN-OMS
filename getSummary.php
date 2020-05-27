<?php
require './Database.php';
$db = new MongodbDatabase();
if(isset($_POST['action'])){
	$sum = [];
	echo json_encode($db->loadSummary($_POST['start'],$_POST['end']));
}
?>