<?php
	error_reporting(0);
	require 'Database.php';
	$db = new MongodbDatabase();
	$data = [];
	if ($_GET['stock'] === "yes") {
		foreach($db->fetchProduct() as $cl) {
			for($i = 0; $i < sizeof($cl['products']); $i++){
				$datas = array(
					"code" => $cl['products'][$i]['Product Code'],
					"desp" => $cl['products'][$i]['Description'],
					"mrp" => "RM ".number_format($cl['products'][$i]['MRP'],2),
					"sys" => $cl['products'][$i]['System'],
					"race" => $cl['products'][$i]['Race'],
					"type" => $cl['products'][$i]['Product Type'],
					"country" => $cl['products'][$i]['Country of Origin'],
					"qtyOrder" => '<input type="number" min="1" max="3" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" />  <button class"btn btn-link"><image src="cart.png"></button>'
				);
				array_push($data, $datas);
			}
		}	
	} else if ($_GET['stock'] === "no") {
		foreach($db->fetchDeletion() as $cl) {
			for($i = 0; $i < sizeof($cl['deletions']); $i++){
				$datas = array(
					"code" => $cl['deletions'][$i]['Code'],
					"shortcode" => $cl['deletions'][$i]['Short Sales Code'],
					"desp" => $cl['deletions'][$i]['__EMPTY'],
					"datechange" => date("Y-m-d",($cl['deletions'][$i]['Date of Change']- (25567 + 2))*86400),
					"comment" => $cl['deletions'][$i]['Comment (correct at time of removal)'],
				);
				array_push($data, $datas);
			}
		}	
	}
echo json_encode($data);
?>