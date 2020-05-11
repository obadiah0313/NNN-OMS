<?php
 	echo exec('ls -al -la');
	$output = array();
	exec('./mysheet/bin/Debug/mysheet.exe 2>&1', $output);
	var_dump($output);
?>