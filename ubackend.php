<?php
	//session_start();
	//error_reporting(0);
	require './Database.php';	
	$db = new MongodbDatabase();
	if($_GET['doc'] == 'stock')
	{
		if (isset($_POST['data'])) {	
			$header = [];
			foreach($_POST['data3'] as $h){ 
				array_push($header,$h);
			}
			$all = [];
			foreach($_POST['data'] as $p){
				$new=[];
				foreach($p as $k=>$v){
					$new[$k] = $v;
				}
				for($i = 0 ; $i < sizeof($header); $i++){
					if(!array_key_exists($header[$i], $p)){
						$new[$header[$i]] = '-';
					}
				}
				array_push($all, $new);
			}
			$filename = $_POST['data4'];
			$primary_key = $_POST['primarykey'];
			if ($db->checkExists() != null) {
				$db->replaceStock(date("Y-m-d"),$all,$header,$primary_key,$filename);
				echo json_encode(["stock" => "success"]);
			}
			else{
				$db->insertStock(date("Y-m-d"),$all,$header,$primary_key,$filename);
				echo json_encode(["stock" => "success"]);
			}
		}
	}
	if($_GET['doc'] == 'deletion')
	{	
		if ($db->checkExists() != null) {
			$db->replaceDeletion(date("Y-m-d"),$_POST['data2']);
			echo json_encode(["type" => "success", "msg" => "Replaced successfully!"]);
		}
		else {
			$db->insertDeletion(date("Y-m-d"),$_POST['data2']);
			echo json_encode(["type" => "success", "msg" => "Insert successfully!"]);
		}
		
	}
?>
