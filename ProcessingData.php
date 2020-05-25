<?php
	session_start();
	error_reporting(0);
	require 'Database.php';
	$db = new MongodbDatabase();
	if($_SESSION['type'] == 'customer' || !isset($_SESSION['type'])){
		foreach($db->getSetting() as $stt){
			$cCatHeader = iterator_to_array($stt['cCat_Header']);
			$cCatFilter = iterator_to_array($stt['cCat_Filter']);
		}
	}
	else {
		foreach($db->getSetting() as $stt){
			$cCatHeader = iterator_to_array($stt['pCat_Header']);
			$cCatFilter = iterator_to_array($stt['pCat_Filter']);
		}
	}
	$pk = $db->getPrimaryKey();
	$data = [];
	
	if ($_GET['init'] == 'true') {
		if ($_GET['stock'] === "yes") {
			foreach($db->fetchProduct() as $cl) {
				foreach($cl['products'] as $k=>$v)
				{
					$temp = iterator_to_array($v);
					$temp = array_merge($temp, array('btnAdd' => '<div class="text-center"><button class="button allBtn mb-1" id="btnDetails" value="'.$v[$pk].'">Details <i class="fas fa-info-circle"></i></button> <button class="button allBtn item" id="btnAdd" value="'.$v[$pk].'">Add to Cart <i class="fas fa-cart-plus"></i></button></div>', 'id' => '<span style="display:none">'.$v[$pk].'</span>'));
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
						$temp = array_merge($temp, array('btnAdd' => '<button class="button allBtn item" id="btnAdd" value="'.$v[$pk].'">Add to Cart <i class="fas fa-cart-plus"></i></button>', 'id' => '<span style="display:none">'.$v[$pk].'</span>'));
						array_push($data,$temp);						
					}
					
				}
			}	
			if(isset($_POST["price"]))
			{
				foreach($data as $d){
					foreach($d as $k=>$v){
						$aa = substr($v, -3);
						if($aa === ".00") {
							$columnname = $k;
							break;
						}						
					}
					if($columnname!= null) break;
				}
				if($_POST["price"][0] == "asc")
					usort($data, function($a,$b) use ($columnname){return strnatcmp(str_replace(',','',$a[$columnname]), str_replace(',','',$b[$columnname]));});
				else
					usort($data, function($a,$b) use ($columnname){return strnatcmp(str_replace(',','',$b[$columnname]), str_replace(',','',$a[$columnname]));});
				
			}
		}
	}
	echo json_encode($data);
?>
