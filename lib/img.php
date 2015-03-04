<?php
include_once "../lib/inc.depth1.php";

$imgname	= $_GET["imgname"];
$folder		= $_GET["folder"];
$flag		= $_GET["flag"];


function getimg($imgname, $folder, $flag="wizmall"){

	$pattern = array("..../", ".../", "%2F", "..\"", "..%5C", "../", "./");
		foreach($pattern as $val){
			$is	= strpos($imgname, $val);
			if($is){
				echo "�߸�� ��η� �����Ͽ����ϴ�.(1)";
				exit;
			}
		}


	$path = "../config/uploadfolder/productimg/".$folder."/".$imgname;
	if( file_exists($path) == FALSE ) exit ;
	$fsize = filesize($path) ;
	$o_file = base64_decode($imgname);
	$ext = substr(strrchr($o_file, "."), 1);
	//header("Content-Type: image/".$ext) ;
	//header("Content-Length: $fsize") ;
	$fd = fopen($path, "rb") ;
	print fread ($fd, $fsize ) ;
	fclose ($fd) ;
	exit ;
}

getimg($imgname, $folder, $flag);