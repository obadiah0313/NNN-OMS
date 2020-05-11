<?php
	$output = array();
	exec('sudo ./mysheet/bin/Debug/mysheet.exe 2>&1', $output);
	var_dump($output);
?>