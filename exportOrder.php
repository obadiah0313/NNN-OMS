<?php
	$output = array();
	exec("https://nnn-oms.herokuapp.com/mysheet/bin/Debug/mysheet.exe 2>&1", $output);
	var_dump($output);
?>