<?php
include "./inc.depth1.php";

include "./class.board.php";
$board = new board();
$board->get_object($dbcon, $common);

$tb_name = "wizTable_".$gid."_".$bid."_reply";
$sqlstr = "select count(*) from wizMembers_log where tb_name = '".$tb_name."' and pid = ".$uid." and userid = '".$cfg["member"]["mid"]."'";
$count = $dbcon->get_one($sqlstr);
	echo "var targetDiv = '".$flag.$uid."'\n";
if($count){
	echo "var result = false\n";
	echo "var msg = '이미 투표하였습니다.'\n";
}else{
	//uid='+uid+'&flag='+flag+'&gid=$GID&bid=$BID'
	$common->insertMeberLog($cfg["member"]["mid"], $uid, $tb_name);
    if($flag == "g"){
    	$sqlstr = "update $tb_name set RECCOUNT = RECCOUNT + 1 where UID = $uid";
        $dbcon->_query($sqlstr);
    }else if($flag == "b"){
    	$sqlstr = "update $tb_name set NONRECCOUNT = NONRECCOUNT + 1 where UID = $uid";
        $dbcon->_query($sqlstr);
    }
	
	echo "var result = true\n";
	
}