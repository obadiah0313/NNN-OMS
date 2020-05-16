<?php
	function execInBackground() {
		if (substr(php_uname(), 0, 7) == "Windows"){
			pclose(popen('start /B exportOrder\exportExcel.exe', 'r')); 
		}
		else {
			exec("/exporOrder/linux-x64/exportExcel.dll > /dev/null &");  
		}
	}
	execInBackground();
?>