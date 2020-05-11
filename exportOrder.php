<?php
	exec("https://nnn-oms.herokuapp.com/mysheet/bin/Debug/mysheet.exe 2>&1", $output);
	print_r($output);
?>