<?php

	include "../../../../lib/cfg.common.php";
	include	("../../../../config/cfg.core.php");
	include "../../../../lib/class.common.php";
	
	$common = new common();
	$htmleditimgfolder=session_id();
	$common->upload_path = "../../../../config/tmp_upload/".$htmleditimgfolder;


// default redirection
$url = $_REQUEST["callback"].'?callback_func='.$_REQUEST["callback_func"];
$bSuccessUpload = is_uploaded_file($_FILES['Filedata']['tmp_name']);

// SUCCESSFUL
if(bSuccessUpload) {
	
	$tmp_name = $_FILES['Filedata']['tmp_name'];
	$name = $_FILES['Filedata']['name'];

	

	$uploadDir = $common->upload_path;
	if(!is_dir($uploadDir)){
		mkdir($uploadDir, 0777);
	}
	
	$newPath = $uploadDir."/".$name;

	
	$result = move_uploaded_file($tmp_name, $newPath);
	
	$url .= "&bNewLine=true";
	$url .= "&sFileName=".urlencode(urlencode($name));
	$url .= "&sFileURL=../../../../config/tmp_upload/".$htmleditimgfolder."/".urlencode(urlencode($name));
	
	
}
// FAILED
else {
	$url .= '&errstr=error';
}
header('Location: '. $url);
?>