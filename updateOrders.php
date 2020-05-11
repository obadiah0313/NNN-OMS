<?php
	require './Database.php';
	$db = new MongodbDatabase();

	if(isset($_POST['action'])) 
	{
		switch($_POST['action'])
		{
			case "complete":
				foreach($_POST['orders'] as $o)
					$db->updateOrder($o, "completed");
				break;
			case "process":
				foreach($_POST['orders'] as $o)
					$db->updateOrder($o, "processing");
				break;
			case "remove":
				foreach($_POST['orders'] as $o)
					$db->removeOrder($o);
				break;
		}
	}
?>