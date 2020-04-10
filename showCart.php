<?php
	error_reporting(0);
	require 'Database.php';
	$db = new MongodbDatabase();
	$cart = [];
	if($_GET['cart'] === 'show'){
		$uid="001";
		foreach($db->fetchProduct() as $cl) {
			for($i = 0; $i < sizeof($cl['products']); $i++){
				foreach($db->loadCart($uid) as $citem){
					foreach($citem['carts'] as $key => $value)
						if($cl['products'][$i]['Product Code'] == $key){
							$cartItem = array(
								"id" => $cl['products'][$i]['Product Code'],
								"desp" => $cl['products'][$i]['Description'],
								"count" => '<input type = "text" value = "'.$value.'" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" size="5" maxlength="3">',
								"price" => (int)$cl['products'][$i]['MRP'] * $value,
								"remove" => '<button class="button allBtn item" id="btnDelete" value="'.$cl['products'][$i]['Product Code'].'">Remove <i class="far fa-times-circle"></i></button>'
							);
							array_push($cart, $cartItem);
						}	
					}				
				}
			}
			foreach($cart as &$key)
			{
				$key['price'] = '<span id="price">'."RM ".number_format($key['price'],2).'</span>';
			}
	}
	echo json_encode($cart);

?>