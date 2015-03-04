<?
include "../common/header_pop.php";

if(!strcmp($smode,"ch_pwd")){## 테이블설명 및 패스워드 변경
	$sqlstr = "UPDATE wizTable_Main SET BoardDes ='$boarddesc', Pass='$pass' WHERE BID ='$bid' and GID='$gid'";
	$dbcon->_query($sqlstr); 
	exit;	
}
?>