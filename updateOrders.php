<?php
	require './Database.php';
	$db = new MongodbDatabase();

	if(isset($_POST['action'])) 
	{
		switch($_POST['action'])
		{
			case "complete":
				foreach($_POST['orders'] as $o)
					$db->updateOrder($o,"ordered", "completed");
				break;
			case "confirm":
				foreach($_POST['orders'] as $o)
					$db->updateOrder($o,"pending", "confirmed");
				break;
			case "remove":
				foreach($_POST['orders'] as $o)
					$db->removeOrder($o);
				break;
			case "received":
				foreach($_POST['orders'] as $o)
					$db->updateOrder($o,"shipping", "received");
				break;
		}
	}
?>