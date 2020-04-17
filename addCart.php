<?php
	error_reporting(0);
	require 'Database.php';
	$db = new MongodbDatabase();

		if($_POST['action'] == 'add_cart'){
			$result = array_count_values($_POST['item']);
			$uid = "001";
			$oid = "o-".$uid."-".$db->countOrder($uid);
			if($db->checkCartExists($oid) == null){
				$db->insertCart($oid, date("Y-m-d"), $result, $uid);
			}
			else{
				$new=[];
				foreach($db->loadCart($uid) as $cart) {
					foreach(iterator_to_array($cart['carts']) as $k=>$v){
						$new[$k] = $v;
					}
					break;
				}
				foreach ($result as $key => $value)
				{
					if (isset($new[$key])) $new[$key] += $value;
					else $new[$key] = $value;
				}
				$db->updateCart($oid, $new);
			}
			$count = 0;
			foreach($db->loadCart($uid) as $cart) {
				foreach(iterator_to_array($cart['carts']) as $k=>$v){
					$count += $v;
				}
				break;
			}
			echo json_encode(["type" => "success", "msg" => "You have ".$count." item(s) in cart"]);
		}

?>
