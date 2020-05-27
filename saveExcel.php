<?php
error_reporting(0);
if(!empty($_FILES["file"]["name"]))
{   
	$dir = "Product_List";
	if(strpos($_FILES["file"]["name"], '%20')  !== false)
		$path = $dir.'/'.str_replace('%20', ' ', $_FILES["file"]["name"]);
	else $path = $dir.'/'.$_FILES["file"]["name"];
	if(!file_exists($path)) {
		chmod($path, 0755);
		unlink($path);
	}
	if(move_uploaded_file($_FILES["file"]["tmp_name"], $path))
		echo json_encode(["filename" => $_FILES["file"]["name"]]);
}
?>