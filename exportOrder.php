<?php
	exec("mysheet/bin/Debug/mysheet.exe",$out,$return);
	if (!$return) {
    echo "Excel Created Successfully";
	} else {
		echo "Excel not created";
	}
?>