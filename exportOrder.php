<?php
	exec('mysheet.exe 2>&1', $output);
	print_r($output);
?>