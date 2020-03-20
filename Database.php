<?php
	require 'vendor/autoload.php';

  	$client = new MongoDB\Client();
	$db = $client->NNNdb;
	$collection = $db->selectCollection('stock');
?>
