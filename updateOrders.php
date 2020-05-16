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
			case "confirm":
				foreach($_POST['orders'] as $o)
					$db->updateOrder($o, "confirmed");
				break;
			case "remove":
				foreach($_POST['orders'] as $o)
					$db->removeOrder($o);
				break;
		}
	}
?>