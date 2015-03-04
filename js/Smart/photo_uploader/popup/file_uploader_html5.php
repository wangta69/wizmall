<?php

	include "../../../../lib/cfg.common.php";
	include	("../../../../config/cfg.core.php");
	include "../../../../lib/class.common.php";
	$common = new common();
	

	$htmleditimgfolder=session_id();
	
	$common->upload_path = "../../../../config/tmp_upload/".$htmleditimgfolder;
	//$common->mkfolder($common->upload_path);
 	$sFileInfo = '';
	$headers = array();
	 
	foreach($_SERVER as $k => $v) {
		if(substr($k, 0, 9) == "HTTP_FILE") {
			$k = substr(strtolower($k), 5);
			$headers[$k] = $v;
		} 
	}
	
	$file = new stdClass;
	$file->name = rawurldecode($headers['file_name']);
	$file->size = $headers['file_size'];
	$file->content = file_get_contents("php://input");

	//$uploadDir = $common->upload_path;
	$uploadDir = $common->upload_path;
	if(!is_dir($uploadDir)){
		mkdir($uploadDir, 0777);
	}
	
	$newPath = $uploadDir."/".iconv("utf-8", "cp949", $file->name);
	
	if(file_put_contents($newPath, $file->content)) {
		$sFileInfo .= "&bNewLine=true";
		$sFileInfo .= "&sFileName=".$file->name;
		$sFileInfo .= "&sFileURL=../../../../config/tmp_upload/".$htmleditimgfolder."/".$file->name;
	}

	echo $sFileInfo;
 ?>