<?php
include "./inc.depth1.php";

if(!$cfg["member"]["mid"]){//아이디가 없을 경우
	echo "var result = 2\n";
}else{
	$sqlstr = "select count(1) from wizscrap where tb_name = '".$tb_name."' and pid = '".$pid."' and userid = '".$cfg["member"]["mid"]."'";
	$result = $dbcon->get_one($sqlstr);
	if($result){//이미 입력된 경우
		echo "var result = 1\n";
	}else{//성공했을 경우
		$ins["tb_name"]	= $tb_name;
		$ins["pid"]		= $pid;
		$ins["userid"]	= $cfg["member"]["mid"];
		$ins["wdate"]	= time();
		$dbcon->insertData("wizscrap", $ins);
		echo "var result = 0\n";
	}
}