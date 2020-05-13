<?php
	exec("/exportExcel/exportExcel.exe",$out,$return);
	if (!$return) {
    echo "Excel Created Successfully";
	} else {
		echo "Excel not created";
		var_dump($out);
		var_dump($retuen);
	}
?>