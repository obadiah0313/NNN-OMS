<?php
	//error_reporting(0);
	require 'Database.php';
	$db = new MongodbDatabase();
	if(isset($_POST['action'])) {
		if(!isset($_POST['cCatheader'])) $cch = [];
		else $cch = $_POST['cCatheader'];
		if(!isset($_POST['cCatfilter'])) $ccf = [];
		else $ccf = $_POST['cCatfilter'];
		if(!isset($_POST['pCatheader'])) $pch = [];
		else $pch = $_POST['pCatheader'];
		if(!isset($_POST['pCatfilter'])) $pcf = [];
		else $pcf = $_POST['pCatfilter'];
		if(!isset($_POST['cartHeader'])) $ch = [];
		else $ch = $_POST['cartHeader'];
		if($db->findSetting() === 0){
			$db->insertSetting($cch,$ccf,$pch, $pcf, $ch);
			var_dump("insert");
		}
		else {
			$db->updateSetting($cch,$ccf,$pch, $pcf, $ch);
			var_dump("update");
		}
		
	}
?>