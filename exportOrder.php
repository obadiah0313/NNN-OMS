<?php
	function _exec($cmd)
	{
	   $WshShell = new COM("WScript.Shell");
	   $oExec = $WshShell->Run($cmd, 0,false);
	   echo $cmd;
	   return $oExec == 0 ? true : false;
	}
	exec("/mysheet/bin/Debug/mysheet.exe");
	//print_r($output);
?>