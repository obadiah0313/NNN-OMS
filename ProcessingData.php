<?php
	//error_reporting(0);
	require 'Database.php';
	$db = new MongodbDatabase();
	foreach($db->getSetting() as $stt){
		$cCatHeader = iterator_to_array($stt['cCat_Header']);
		$cCatFilter = iterator_to_array($stt['cCat_Filter']);
	}
	$data = [];
	
	if ($_GET['init'] == 'true') {
		if ($_GET['stock'] === "yes") {
			foreach($db->fetchProduct() as $cl) {
				foreach($cl['products'] as $k=>$v)
				{
					$temp = iterator_to_array($v);
					$temp = array_merge($temp, array('btnAdd' => '<button class="button allBtn item" id="btnAdd" value="'.$k.'">Add to Cart <i class="fas fa-cart-plus"></i></button>', 'id' => '<span style="display:none">'.$k.'</span>'));
					$data[$k] = $temp;
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
				foreach($cl['products'] as $k=>$v){
					$count = 0;
					foreach($cCatFilter as $ccf){		
						if(isset($_POST[substr(str_replace([' ','(',')'], '',$ccf), 0 ,13)]))
						{
							$count++;
							foreach($_POST[substr(str_replace([' ','(',')'], '',$ccf), 0 ,13)] as $filter){
								if($v[$ccf] == $filter){
									$count--;
								}
							}
						}
					}
					if($count == 0){ 
						$temp = iterator_to_array($v);
						$temp = array_merge($temp, array('btnAdd' => '<button class="button allBtn item" id="btnAdd" value="'.$k.'">Add to Cart <i class="fas fa-cart-plus"></i></button>', 'id' => '<span style="display:none">'.$k.'</span>'));
						array_push($data,$temp);						
					}
					
				}
			}	
			if(isset($_POST["price"]))
			{
				foreach($data as $d){
					foreach($d as $k=>$v){
						$aa = substr($v, -3);
						if($aa === ".00")
							$columnname = $k;
					}
					break;
				}
				if($_POST["price"][0] == "asc")
					usort($data, function($a,$b){return strnatcmp(str_replace(',','',$a['MRP']), str_replace(',','',$b['MRP']));});
				else
					usort($data, function($a,$b){return strnatcmp(str_replace(',','',$b['MRP']), str_replace(',','',$a['MRP']));});
				
			}
		}
	}
	echo json_encode($data);
?>
