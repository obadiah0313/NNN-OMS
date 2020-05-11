<?php
    error_reporting(0);
	require 'Database.php';	
	$db = new MongodbDatabase();
	if (isset($_POST['data'])) {
		$all = [];
		foreach($_POST['data'] as $p){
			$new=[];
			foreach($p as $k=>$v){
				$new[$k] = $v;
			}
			for($i = 0 ; $i < sizeof($_POST['data3']); $i++){
				if(!array_key_exists($_POST['data3'][$i], $p)){
					$new[$_POST['data3'][$i]] = '-';
				}
			}
			array_push($all, $new);
		}
        $uploadData = array(
            'header' => $_POST['data3'],
            'product' => $all,
        );
		echo json_encode($uploadData);
	}
?>