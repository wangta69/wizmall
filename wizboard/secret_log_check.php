<?php
/*
 제작자 : 폰돌                     
 URL : http://www.shop-wiz.com      
 Email : master@shop-wiz.com       
 Copyright (C) 2003  shop-wiz.com 
*/


include "../lib/inc.depth1.php";

include_once "../lib/class.board.php";
$board		= new board();
$board->cfg = $cfg;
$member->get_object($dbcon, $common);



if(!$SameDB){
	$BOARD_NAME="wizTable_${GID}_${BID}";
	$UpdirPath = $BID;
}else{
	$BOARD_NAME="wizTable_${SameDB}";
	$UpdirPath = $SameDB;
}

/****[확장DB사용시] *******/
if($ExtendDB)
$BOARD_NAME="$ExtendDB";

if(!strcmp($Mode, "MemberLogin")): /* Board Member로 로그인시 */
	$sqlstr = "SELECT Pass FROM wizTable_Main WHERE BID ='$BID' and GID='$GID'";
	$BoardAdminPass = $dbcon->get_one($sqlstr);
	
	$sqlstr = "SELECT Pass FROM wizTable_Main WHERE Grade='A'";
	$RootAdminPass = $dbcon->get_one($sqlstr);
	
	/* 일반 게시물 등록자의 정보를 가져온다. */
	$SqlStr = "select UID, PASSWD, THREAD, FID, ID from $BOARD_NAME where UID = $UID";
	$sqlqry = $dbcon->_query($SqlStr);
	$list = $dbcon->_fetch_array();
	
	if($mode != "modlogin"){//비밀글 로그인일경우	
		if(strcmp($list[THREAD],"A")){
			$SqlStr = "select FID, PASSWD, ID from $BOARD_NAME where FID = $list[FID] and THREAD = 'A'";
			$sqlqry = $dbcon->_query($SqlStr);
			$list = $dbcon->_fetch_array();
		}

		$url="../wizboard.php?BID=$BID&GID=$GID&mode=$nmode&adminmode=$adminmode&optionmode=$optionmode&UID=$UID&cp=$cp&category=$category";
	

		if($board->is_admin("../") || $MEMBERPASS == $RootAdminPass || $MEMBERPASS == $BoardAdminPass || $MEMBERPASS == $list["PASSWD"] ||  ($cfg["member"]["mid"]  && $cfg["member"]["mid"] == $list["ID"])){
			$COOKIE_VALUE = $list["FID"]."_".$BID."_".$GID;
			setcookie("SECRET", $COOKIE_VALUE, 0, "/");
			header("location:$url");
			exit;
		}else{//로그인 실패일경우
			echo "<script>alert('로그인에 실패하였습니다.\\n\\n패스워드를 책크해주세요');</script>";
			echo "<script>location.href='${url}';</script>";
			exit;
		}
	}else{//modify로그인일경우
		$url="../wizboard.php?BID=$BID&GID=$GID&mode=$nmode&adminmode=$adminmode&optionmode=$optionmode&UID=$UID&cp=$cp&category=$category";
	//echo $board->is_admin("../");
	//exit;
		if($board->is_admin("../") || $MEMBERPASS == $RootAdminPass || $MEMBERPASS == $BoardAdminPass || $MEMBERPASS == $list[PASSWD] || $cfg["member"]["mid"] == $list["ID"]){
			$COOKIE_VALUE = $UID."_".$BID."_".$GID;
			setcookie("MODIFY", "$COOKIE_VALUE", 0, "/");
			header("location:$url");
			exit;
		}else{//로그인 실패일경우
			echo "<script>alert('로그인에 실패하였습니다.\\n\\n패스워드를 책크해주세요');</script>";
			echo "<script>location.href='${url}';</script>";
			exit;
		}
	}
endif;//if(!strcmp($Mode, "MemberLogin")): /* Board Member로 로그인시 */			
?>