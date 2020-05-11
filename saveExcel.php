<?php
if(!empty($_FILES["file"]["name"]))
{   
	$location = 'Product_List'.$_FILES["file"]["name"];
	echo $_FILES["file"]["tmp_name"];
	//move_uploaded_file($_FILES["file"]["tmp_name"], $location);
	echo json_encode(["filename" => $location]);
}
?>