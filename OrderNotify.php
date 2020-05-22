<?php
	if(isset($_POST['action'])){
		foreach($_POST['orders'] as $o){
			echo $o;
		}
	}
?>