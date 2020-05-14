<?php
	require './Database.php';	
	$db = new MongodbDatabase();
	if($_GET['doc'] == 'stock')
	{
		if (isset($_POST['product']) && isset($_POST['header']) && isset($_POST['primarykey']) && isset($_POST['filename']))
		{
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
