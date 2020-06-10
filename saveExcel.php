<?php
error_reporting(0);
require './vendor/autoload.php';
$s3 = new Aws\S3\S3Client([
	'version' => 'latest',
    'region'   => 'ap-southeast-1',
]);
$bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var in found in env!');
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
	
	$upload = $s3->upload($bucket, $_FILES['file']['name'], fopen($_FILES['file']['tmp_name'], 'rb'), 'public-read-write');
	
	if(move_uploaded_file($_FILES["file"]["tmp_name"], $path))
		echo json_encode(["filename" => htmlspecialchars($upload->get('ObjectURL'))]);
}
?>