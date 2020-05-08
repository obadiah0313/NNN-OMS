<?php
	error_reporting(0);
	require 'Database.php';
	$db = new MongodbDatabase();

		if($_POST['action'] == 'add_cart'){
			$result = $_POST['item'];
			$uid = "001";
			if($db->checkCartExists($uid) == null){
				$item = array($result => 1);
				$db->insertCart($item, $uid);
			}
			else{
				$new=[];
				foreach($db->loadCart($uid) as $cart) {
					foreach(iterator_to_array($cart['carts']) as $k=>$v){
						$new[$k] = $v;
					}
					break;
				}
				if (isset($new[$result])) $new[$result] ++;
				else $new[$result] = 1;
				$db->updateCart($uid, $new);
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
