<?php
	require './Database.php';	
	$db = new MongodbDatabase();
	if($_GET['doc'] == 'stock')
	{
		if (isset($_POST['product'])) {
			$all = [];
			foreach($_POST['product'] as $p){
				$new=[];
				foreach($p as $k=>$v){
					$new[$k] = $v;
				}
				for($i = 0 ; $i < sizeof($_POST['header']); $i++){
					if(!array_key_exists($_POST['header'][$i], $p)){
						$new[$_POST['header'][$i]] = '-';
					}
				}
				array_push($all, $new);
			}
			if ($db->checkExists() != null) {
				$db->replaceStock(date("Y-m-d"),$all,$_POST['header'],$_POST['primarykey'],$_POST['filename']);
				echo json_encode(["stock" => "replace"]);
			}
			else{
				$db->insertStock(date("Y-m-d"),$all,$_POST['header'],$_POST['primarykey'],$_POST['filename']);
				echo json_encode(["stock" => "insert"]);
			}
		}
	}
	if($_GET['doc'] == 'deletion')
	{	
		if($_POST['process'] == "replace"){
			$db->replaceDeletion(date("Y-m-d"),$_POST['deletion']);
			echo json_encode(["type" => "success", "msg" => "Replaced successfully!"]);
		}
		else {
			$db->insertDeletion(date("Y-m-d"),$_POST['deletion']);
			echo json_encode(["type" => "success", "msg" => "Insert successfully!"]);
		}
		
	}
?>
