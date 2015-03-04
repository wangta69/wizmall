<?php
//사용하지 않음
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***


if($REPLE_MODE == "WRITE"){
	if(!$ID) $ID=$_COOKIE["MEMBER_ID"];
	if(!$NAME) $NAME=$_COOKIE[MEMBER_NAME];
	$W_DATE=time();
	$CONTENTS = addslashes($CONTENTS);
	$CONTENTS = eregi_replace("<", "&lt;", $CONTENTS);
	$CONTENTS = eregi_replace(">", "&gt;", $CONTENTS);
	$CONTENTS = eregi_replace("\"", "&quot;", $CONTENTS);
	$CONTENTS = eregi_replace("\|", "&#124;", $CONTENTS);
	if(!$FLAG) $FLAG = 1;
	$sqlstr = "INSERT INTO ${BOARD_NAME}_reply (FLAG, MID, ID, NAME, PASSWD, EMAIL,SUBJECT,CONTENTS,COUNT,W_DATE) 
	VALUES('$FLAG','$UID','$ID','$NAME','$PASSWD','$EMAIL','$SUBJECT','$CONTENTS','$COUNT','$W_DATE')"; 
	$dbcon->_query($sqlstr);
	$goto = "./wizboard.php?BID=$BID&GID=$GID&mode=view&adminmode=$adminmode&UID=$UID&category=$category&cp=$cp&BOARD_NO=$BOARD_NO";
	$common->js_alert("자료가 성공적으로 등록되었습니다", $goto);
}else if($REPLE_MODE == "update"){

//0. 관리자인지 비교
//1. 현재아이디와 등록자 아이디 비교
//2. 현재패스워드와 등록시 패스워드 비교
	if($_COOKIE["BOARD_PASS"] || $_COOKIE["ROOT_PASS"]){
		$status = "1";
	}else{
		if(!$ID) $ID=$_COOKIE["MEMBER_ID"];
		$sqlstr = "SELECT ID, PASSWD FROM ${BOARD_NAME}_reply WHERE UID='$RUID'";
		$dbcon->_query($sqlstr);
		$list = $dbcon->_fetch_array();
		if($list["ID"] == $ID){
			$status = "1";
		}else if($list["PASSWD"] == $PASSWD){
			$status = "1";
		}
	}
	echo "status = $status <br>";
//exit;	
	if($status <> "1"){
		echo "<script>alert('본인이 작성한 글이 아니거나 \\n수정할 권한이 없습니다.');</scrpt>";
	}else{
		if(!$ID) $ID=$cfg["member"];
		if(!$NAME) $NAME=$_COOKIE[MEMBER_NAME];
		$W_DATE=time();
		$CONTENTS = addslashes($CONTENTS);
		$CONTENTS = eregi_replace("<", "&lt;", $CONTENTS);
		$CONTENTS = eregi_replace(">", "&gt;", $CONTENTS);
		$CONTENTS = eregi_replace("\"", "&quot;", $CONTENTS);
		$CONTENTS = eregi_replace("\|", "&#124;", $CONTENTS);
		$sqlstr = "update ${BOARD_NAME}_reply set EMAIL='$EMAIL',SUBJECT='$SUBJECT',CONTENTS='$CONTENTS' WHERE UID='$RUID'";
		$RESULT=$dbcon->_query($sqlstr);
		$goto = "./wizboard.php?BID=$BID&GID=$GID&mode=view&adminmode=$adminmode&UID=$UID&category=$category&cp=$cp&BOARD_NO=$BOARD_NO";
		$common->js_alert("자료가 성공적으로 수정되었습니다", $goto);
	}
}