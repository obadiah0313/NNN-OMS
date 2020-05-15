<?php
	function execInBackground() {
		if (substr(php_uname(), 0, 7) == "Windows"){
			pclose(popen('start /B exportExcel\exportExcel.exe', 'r')); 
		}
		else {
			exec("sudo /exporExcel/exportExcel.exe > /dev/null &");  
		}
	}
	execInBackground();
?>