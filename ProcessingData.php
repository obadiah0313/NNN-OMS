<?php
	error_reporting(0);
	require 'Database.php';
	$db = new MongodbDatabase();
	$data = [];
	if ($_GET['init'] == 'true') {
		if ($_GET['stock'] === "yes") {
			foreach($db->fetchProduct() as $cl) {
				for($i = 0; $i < sizeof($cl['products']); $i++){
					$datas = array(
						"desp" => $cl['products'][$i]['Description'],
						"mrp" => "RM ".number_format($cl['products'][$i]['MRP'],2),
						/*"qtyOrder" => '<input type="number" min="1" max="3" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" />  <button class"btn btn-link"><image src="cart.png"></button>'*/
					);
					array_push($data, $datas);
				}
			}	
		} else if ($_GET['stock'] === "no") {
			foreach($db->fetchDeletion() as $cl) {
				for($i = 0; $i < sizeof($cl['deletions']); $i++){
					$datas = array(
						"desp" => $cl['deletions'][$i]['__EMPTY'],
						"datechange" => date("Y-m-d",($cl['deletions'][$i]['Date of Change']- (25567 + 2))*86400),
						"comment" => $cl['deletions'][$i]['Comment (correct at time of removal)'],
					);
					array_push($data, $datas);
				}
			}	
		}
	} else if ($_GET['init'] == 'false') {
		if(isset($_POST["action"])){
			foreach($db->fetchProduct() as $cl) {
				for($i = 0; $i < sizeof($cl['products']); $i++){
					$flag = 0;
					$count = 0;
					if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
					{
						$count ++;
						if($cl['products'][$i]['MRP'] < $_POST["minimum_price"] || $cl['products'][$i]['MRP'] > $_POST["maximum_price"] )
							$flag ++;
					}
					if(isset($_POST["system"]))
 					{
						$count++;
						foreach($_POST["system"] as $sys){
							if($cl['products'][$i]['System'] == $sys){
								//var_dump($cl['products'][$i]['System']);
								$flag ++;
							}
						}
					}
					
					if(isset($_POST["type"]))
 					{
						$count++;
						foreach($_POST["type"] as $type){
							if($cl['products'][$i]['Product Type'] == $type){
								$flag ++;
							}
						}
					}
					
					if(isset($_POST["country"]))
 					{
						$count++;
						foreach($_POST["country"] as $cty){
							if($cl['products'][$i]['Country of Origin'] == $cty){
								$flag ++;
							}
						}
					}
					if($flag == $count){ 
						$datas = array(
						"desp" => $cl['products'][$i]['Description'],
						"mrp" => "RM ".number_format($cl['products'][$i]['MRP'],2)
						);
						array_push($data, $datas);
					}
				}
			}	
			
		}
	}
	echo json_encode($data);
?>
