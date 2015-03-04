<?php
include "../lib/inc.depth1.php";

$smode	= $_POST["smode"];

switch($smode){
	case "change_des":/*  테이블설명 및 패스워드 변경 */
		$boarddes	= $_POST["boarddes"];
		$adminname	= $_POST["adminname"];
		$pass		= $_POST["pass"];
		$uid		= $_POST["uid"];
		$sql = "UPDATE wizTable_Main SET BoardDes ='".$boarddes."', AdminName='".$adminname."', Pass='".$pass."' WHERE UID =".$uid;
		$dbcon->_query($sql);	
	break;
}