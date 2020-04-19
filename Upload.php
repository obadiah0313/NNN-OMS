<?php
    //error_reporting(0);
	require './Database.php';	
	$db = new MongodbDatabase();
	if (isset($_POST['data'])) {	
		$header = [];
		foreach($_POST['data3'] as $h){ 
			array_push($header,$h);
        }
        $deletion = [];
        foreach($_POST['data2'] as $d){ 
			array_push($deletion,$d);
        }
		$all = [];
		foreach($_POST['data'] as $p){
			$new=[];
			foreach($p as $k=>$v){
				$new[$k] = $v;
			}
			for($i = 0 ; $i < sizeof($header); $i++){
				if(!array_key_exists($header[$i], $p)){
					$new[$header[$i]] = '-';
				}
			}
			array_push($all, $new);
		}
        $uploadData = array(
            'header' => $header,
            'product' => $all,
            'deletion' => $deletion
        );
		echo json_encode($uploadData);
		
	}
?>