<?php
if(!empty($_FILES["file"]["name"]))
{   
	$location = '/Product_List/'.$_FILES["file"]["name"];
	/*if(!file_exists($location)) {
		chmod($location, 0755);
		unlink($location);
	}*/
	move_uploaded_file($_FILES["file"]["tmp_name"], $location);
	echo json_encode(["filename" => $location]);
}
else json_encode(["filename" => "Nothing"]);
?>