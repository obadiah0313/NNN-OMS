<?php
require './Database.php';
$db = new MongodbDatabase();
if(isset($_POST['action'])){
	$sum = [];
	/*foreach($db->loadSummary($_POST['start'],$_POST['end']) as $summary){
		
	}*/
	var_dump($db->loadSummary($_POST['start'],$_POST['end']));
}
?>