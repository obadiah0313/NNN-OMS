<?php
	error_reporting(0);
	require 'Database.php';
	$db = new MongodbDatabase();
	if(isset($_POST['action'])){
		$result = array_count_values($_POST['item']);
		$uid = "001";
		$oid = "o-".$uid."-".$db->countOrder($uid);
		if($db->checkCartExists($oid) == null){
			$db->insertCart($oid, date("Y-m-d"), $result, $uid);
			var_dump("Insert");
		}
		else{
			$new=[];
			foreach($db->loadCart($uid) as $cart) {
				foreach(iterator_to_array($cart['carts']) as $k=>$v){
					$new[$k] = $v;
					var_dump($new);
				}
				break;
			}
			foreach ($result as $key => $value)
			{
				if (isset($new[$key])) $new[$key] += $value;
				else $new[$key] = $value;
			}
			var_dump($new);
			$db->updateCart($oid, $new);
			var_dump("Update");
		}
	}

?>
