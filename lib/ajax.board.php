<?php
include "./inc.depth1.php";
include "./class.board.php";

$board = new board();

$board->get_object($dbcon, $common);

$board->cfg			= $cfg;//환경설정 파일들을 입력한다.

$board->gid			= $_POST["GID"];
$board->bid			= $_POST["BID"];
$board->uid			= $_POST["UID"];
$board->depth		= "..";
$board->processmode	= "ajax";
$board->boardname	= "wizTable_".$_POST["GID"]."_".$_POST["BID"];
$smode				= $_POST["smode"];

//print_r($_FILES);
//print_r($_POST);
//echo "<script>alert('",$_POST["UID"] , "')</script>";
//exit;
switch($smode){
	case "getreple"://리플 수정시 현재 정보를 다시 보여줌
		$tb_name="wizTable_".$gid."_".$bid."_reply";
	    $sqlstr = "select SUBJECT, CONTENTS from ".$tb_name." where UID = ".$uid;
	    $list = $dbcon->get_row($sqlstr);
		//echo stripslashes($list["SUBJECT"])."|".stripslashes($list["CONTENTS"]);
		echo json_encode($list);
		exit;
	break;
	case "insertreple"://리플입력시
		if($_POST["RUID"]){//수정
			$board->updatereple($_POST);
		}else{//입력
		
			$board->insertreple($_POST);
		}
	break;
	case "delete_reple":
	//		$gid			= $_POST["GID"];
	//	$bid			= $_POST["BID"];
	//	$comment_uid	= $_POST["CUID"];
		$board->deletecomment();
	break;
		
}