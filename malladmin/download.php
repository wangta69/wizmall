<?php
include "../lib/inc.depth1.php";
switch($type){
	case "inquire":
		$url = "../config/uploadfolder/etc/";
	break;
}
$common->filedownload($url, $filename);