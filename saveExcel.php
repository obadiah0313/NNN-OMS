<?php
if($_FILES["file"]["name"] != '')
{
	$test = explode(".", $_FILES["file"]["name"]);
	$ext = end($test);
	$name = "ProductList_".date("Ymd").".".$ext;
	$location = './Product_List/'.$name;
	move_uploaded_file($_FILES["file"]["tmp_name"], $location);
}
?>