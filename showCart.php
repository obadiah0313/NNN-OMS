<?php
	error_reporting(0);
	require 'Database.php';
	$db = new MongodbDatabase();
	$pk = $db->getPrimaryKey();
	$cart = [];
	if($_GET['update'] === 'remove'){ 
		if(isset($_POST['action'])){
			$result = $_POST['item'];
			$uid = "001";
			$oid = "o-".$uid."-".$db->countOrder($uid);
			$new=[];
			foreach($db->loadCart($uid) as $cart) {
				foreach(iterator_to_array($cart['carts']) as $k=>$v){
					if($k != $result)
						$new[$k] = $v;
				}
				break;
			}
			$db->updateCart($oid, $new);
		}
	}
	else if($_GET['update'] === 'decrease'){ 
		if(isset($_POST['action'])){ var_dump($_POST['id']);
			$id = $_POST['id'];
			$uid = "001";
			$oid = "o-".$uid."-".$db->countOrder($uid);
			$new=[];
			foreach($db->loadCart($uid) as $cart) {
				foreach(iterator_to_array($cart['carts']) as $k=>$v){
					if($k == $id)
						$new[$k] = $_POST['count'];
					else
						$new[$k] = $v;
				}
				break;
			}
			$db->updateCart($oid, $new);
		}
	}
	
	else if($_GET['update'] === 'increase'){ 
		if(isset($_POST['action'])){
			$id = $_POST['id'];
			$uid = "001";
			$oid = "o-".$uid."-".$db->countOrder($uid);
			$new=[];
			foreach($db->loadCart($uid) as $cart) {
				foreach(iterator_to_array($cart['carts']) as $k=>$v){
					if($k == $id)
						$new[$k] = $v+1;
					else
						$new[$k] = $v;
				}
				break;
			}
			$db->updateCart($oid, $new);
		}
	}
		$uid="001";
		foreach($db->fetchProduct() as $cl) {
			foreach($cl['products'] as $k=>$v){
				foreach($v as $ke=>$val){
					$aa = substr($val, -3);
					
					if($aa === ".00"){
						$columnname = $ke;
						break;
					}
				}
				foreach($db->loadCart($uid) as $citem){
					foreach($citem['carts'] as $key => $value){
						if($v[$pk] == $key){
							
							$temp = iterator_to_array($v);
							$temp = array_merge($temp, array("count" => '<div class="input-group"><input type="button" id="button-minus" value="-" class="button-minus button allBtn" data-field="quantity"><input type="number" id="'.$v[$pk].'" step="1" max="" value="'.$value.'" min="1" name="quantity" class="quantity-field"><input type="button" value="+" class="button-plus button allBtn" data-field="quantity"></div>', "price" => (int)substr($v[$columnname],4, -3) * $value, "remove" => '<button class="button allBtn item" id="btnRemove" value="'.$v[$pk].'">Remove <i class="far fa-times-circle"></i></button>'));
							array_push($cart,$temp);
						}	
					}				
				}
			}
			foreach($cart as &$key)
			{
				$key['price'] = '<span id="price">'."MYR ".number_format($key['price'],2).'</span>';
			}
		}	
	echo json_encode($cart);

?>