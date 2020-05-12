<?php
error_reporting(0);
if(!empty($_FILES["file"]["name"]))
{   
	$dir = "Product_List";
	$path = $dir.'/'.$_FILES["file"]["name"];
	if(!file_exists($path)) {
		chmod($path, 0755);
		unlink($path);
	}
	if(move_uploaded_file($_FILES["file"]["tmp_name"], $path))
		echo json_encode(["filename" => $_FILES["file"]["name"]]);
}
?>