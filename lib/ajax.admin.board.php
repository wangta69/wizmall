<?php
include "./inc.depth1.php";
include "./class.board.php";
$board = new board();
$board->get_object($dbcon, $common);

//로그인 책크 부분 시작
$common -> pub_path = "../";
$cfg["member"] = $common -> getLogininfo();
//로그인 정보를 가져옮
if($cfg["member"]["mgrade"] != "admin"){
	$rtn =  array("result"=>"1", "msg"=>"접근이 금지된 페이지 입니다.");
	echo json_encode($rtn);
    exit;
}


if($smode == "mkcfg"){
	$STRING="<?
	\#\# config전체용이부분은 하드 코딩 으로 처리한다.
	\$cfg[\"wizboard\"][\"rccomPer\"]						=\"".$rccomper."\";
	?>"; 
	$fp = fopen("../config/wizboard/table/config.php", "w"); 
	$STRING=stripslashes($STRING);
	fwrite($fp, $STRING); 
	fclose($fp); 
}else if($smode == "prohibit_ip_list"){
	$STRING="<?
	\#\# config전체용이부분은 하드 코딩 으로 처리한다.
	\$cfg[\"wizboard\"][\"prohibit_ip\"]						=\"".$prohibit_ip."\";
	?>"; 
	$fp = fopen("../config/wizboard/table/prohibit_ip_list.php", "w"); 
	$file	= explode("\n", $prohibit_ip);
	fwrite($fp, "<?\n");
	foreach($file as $key => $val){
		$val	= trim($val);
		 
		if($val){
			fwrite($fp, "\$prohibit_ip[] = \"".$val."\";\n"); 
		}
	}
	fwrite($fp, "?>\n");
	
	fclose($fp);	
}else if($smode == "eachconfig"){//실시간으로 값을 받아 데이타 변경(추후 이부분으로 통일 예정)
	include "../config/wizboard/table/".$GID."/".$BID."/config.php";
	$cfg["wizboard"][$key]			= $value;
	
	extract($cfg["wizboard"]);
	include "../wizboard/configwrite.php";
}

if($query == "cat_in"){//카테고리 입력
	$sqlstr = "select max(ordernum) maxnum from wizTable_Category where bid='".$BID."' and gid = '".$GID."'";
	$maxnum = $dbcon->get_one($sqlstr);
	$maxnum = $maxnum ? $maxnum+1:1;
	
	$sqlstr = "insert into wizTable_Category (bid, gid, ordernum, catname) values ('".$BID."', '".$GID."', ".$maxnum.", '".$catname."')";

	$dbcon->_query($sqlstr);
}else if($query == "cat_del"){//카테고리 삭제
	$TableName = "wizTable_".$GID."_".$BID;
	//현재 카테고리의 카테고리 번호를 구해서 모두 0으로 치환한다.
	$sqlstr = "select ordernum from wizTable_Category where uid = ".$uid;
	$ordernum = $dbcon->get_one($sqlstr);
	
	$sqlstr = "update ".$TableName." set CATEGORY = '0' where CATEGORY = '".$ordernum."'";
	$dbcon->_query($sqlstr);
	
	$sqlstr = "delete from wizTable_Category where uid = ".$uid;
	$dbcon->_query($sqlstr);
}else if($query == "cat_move"){//카테고리 삭제
	$TableName = "wizTable_".$_POST["GID"]."_".$_POST["BID"];
	//현재 카테고리의 카테고리 번호를 구해서 모두 0으로 치환한다.
	$sqlstr = "select ordernum from wizTable_Category where uid = ".$uid;
	$current_cat = $dbcon->get_one($sqlstr);
	$sqlstr = "update ".$TableName." set CATEGORY = '".$_POST["tcat"]."' where CATEGORY = '".$current_cat."'";
	$dbcon->_query($sqlstr);
}