<?php
error_reporting(0);
if(!empty($_FILES["file"]["name"]))
{   
	$dir = "Product_List";
	$filename = $_FILES["file"]["name"];
	if(strpos($filename, '%20')  !== false)
		$filename = str_replace('%20', ' ', $filename);
	$path = $dir.'/'.$filename;
	if(!file_exists($path)) {
		chmod($path, 0755);
		unlink($path);
	}
	if(move_uploaded_file($_FILES["file"]["tmp_name"], $path))
		echo json_encode(["filename" => $filename]);
}
?>