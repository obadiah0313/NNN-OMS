<?php
	$output = array();
	exec("cd /mysheet/bin/Debug/ ls -al 2>&1", $output);
	var_dump($output);
?>