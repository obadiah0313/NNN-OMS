<?php
	require './Database.php';
	$db = new MongodbDatabase();
	$order = [];
	foreach($db->fetchProduct() as $cl) {
		foreach($cl['products'] as $k=>$v){
			foreach($v as $ke=>$val){
				$aa = substr($val, -3);		
				if($aa === ".00"){
					$columnname = $ke;
				}
			}
			foreach($db->loadOrder() as $order){
				foreach($order['orders'] as $key => $value){
					if($k == $key){
						$temp = iterator_to_array($v);
						$temp = array_merge($temp, array("count" => '<div class="input-group"><input type="button" id="button-minus" value="-" class="button-minus button allBtn" data-field="quantity"><input type="number" id="'.$k.'" step="1" max="" value="'.$value.'" min="1" name="quantity" class="quantity-field"><input type="button" value="+" class="button-plus button allBtn" data-field="quantity"></div>', "remove" => '<button class="button allBtn item" id="btnRemove" value="'.$k.'">Remove <i class="far fa-times-circle"></i></button>'));
						array_push($order,$temp);
					}	
				}				
			}
		}
	}	
	echo json_encode($order);
?>