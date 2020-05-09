<?php
if($_FILES["file"]["name"] != '')
{
	//$test = explode(".", $_FILES["file"]["name"]);
	//$ext = end($test);
	//$name = "ProductList_".date("Ymd").".".$ext;
	$location = './Product_List/'.$_FILES["file"]["name"];
	move_uploaded_file($_FILES["file"]["tmp_name"], $location);
	echo json_encode(["filename" => $location]);
}
?>