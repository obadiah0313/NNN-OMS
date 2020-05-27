<?php
	require 'Database.php';	
	$db = new MongodbDatabase();
		if (isset($_POST['product']) && isset($_POST['header']) && isset($_POST['primarykey']) && isset($_POST['filename']))
		{
			if ($db->checkExists() != null) {
				$db->replaceStock(date("Y-m-d"),$_POST['product'],$_POST['header'],$_POST['primarykey'],$_POST['desp'],$_POST['filename']);
				echo json_encode(["type" => "success", "msg" => "Upload successfully!"]);
			}
			else{
				$db->insertStock(date("Y-m-d"),$_POST['product'],$_POST['header'],$_POST['primarykey'],$_POST['desp'],$_POST['filename']);
				echo json_encode(["type" => "success", "msg" => "Upload successfully!"]);
			}
		}
?>
