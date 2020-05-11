<?php
    error_reporting(0);
	require 'Database.php';	
	$db = new MongodbDatabase();
	if (isset($_POST['data'])) {	
		/*$header = [];
		foreach( as $h){ 
			array_push($header,$h);
        }*/
        /*$deletion = [];
        foreach( as $d){ 
			array_push($deletion,$d);
        }*/
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
            'deletion' => $_POST['data2'],
        );
		echo json_encode($uploadData);
	}
?>