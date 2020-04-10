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
						"id" => $cl['products'][$i]['Product Code'],
						"release" => date("Y-m-d",($cl['products'][$i]['Release Date (Last 3 Months)']- (25567 + 2))*86400),
						"country" => $cl['products'][$i]['Country of Origin'],
						"qtyPack" => $cl['products'][$i]['Qty in Pack'],
						"system" => $cl['products'][$i]['System'],
						"race" => $cl['products'][$i]['Race'],
						"type" => $cl['products'][$i]['Product Type'],
						"module" => $cl['products'][$i]['Module'],
						"desp" => '<span>'.$cl['products'][$i]['Description'].'</span>',
						"mrp" => $cl['products'][$i]['MRP'],
						"qty" => '<button class="button allBtn item" id="btnAdd" value="'.$cl['products'][$i]['Product Code'].'">Add to Cart <i class="fas fa-cart-plus"></i></button>'
					);
					if($datas["release"] == "1899-12-30")
							$datas["release"] = "Unknown";
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
					if(isset($_POST["module"]))
 					{
						$count++;
						foreach($_POST["module"] as $mod){
							if($cl['products'][$i]['Module'] == $mod){
								$flag ++;
							}
						}
					}
					/*if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
					{
						$count ++;
						if($cl['products'][$i]['MRP'] >= $_POST["minimum_price"] && $cl['products'][$i]['MRP'] <= $_POST["maximum_price"] )
							$flag ++;
					}*/
					if(isset($_POST["system"]))
 					{
						$count++;
						foreach($_POST["system"] as $sys){
							if($cl['products'][$i]['System'] == $sys){
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
							"id" => $cl['products'][$i]['Product Code'],
							"release" => date("Y-m-d",($cl['products'][$i]['Release Date (Last 3 Months)']- (25567 + 2))*86400),
							"country" => $cl['products'][$i]['Country of Origin'],
							"qtyPack" => $cl['products'][$i]['Qty in Pack'],
							"system" => $cl['products'][$i]['System'],
							"race" => $cl['products'][$i]['Race'],
							"type" => $cl['products'][$i]['Product Type'],
							"module" => $cl['products'][$i]['Module'],
							"desp" => $cl['products'][$i]['Description'],
							"mrp" => $cl['products'][$i]['MRP'],
							"qty" => '<button class="button allBtn item" id="btnAdd" value="'.$cl['products'][$i]['Product Code'].'">Add to Cart <i class="fas fa-cart-plus"></i></button>'
						);
						if($datas["release"] == "1899-12-30")
							$datas["release"] = "Unknown";
						array_push($data, $datas);						
					}
					
				}
			}	
			if(isset($_POST["price"]))
			{
				$columns = array_column($data,'mrp');
				foreach($_POST["price"] as $sort){
					if($sort == "asc")
						array_multisort($columns, SORT_ASC, $data);
					else
						array_multisort($columns, SORT_DESC, $data);
				}
			}
		}
	}
	foreach($data as &$key)
	{
		$key['mrp'] = "RM ".number_format($key['mrp'],2);
	}
	echo json_encode($data);
?>
