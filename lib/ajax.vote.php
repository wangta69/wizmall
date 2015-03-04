<?php
include "./inc.depth1.php";

include "./class.board.php";
$board = new board();
$board->get_object($dbcon, $common);

$config_include_path = "../config/wizboard/table/".$gid."/".$bid;
include $config_include_path."/config.php";#보드관련 세부 config 관련 정보
include "../config/wizboard/table/config.php";#보드관련 전체 config 관련 정보
$board->cfg = $cfg;//환경설정 파일들을 입력한다.

## 추천수 올리기addreccount($uid, $bid, $gid, $flag);
$result = $board->addreccount($uid, $bid, $gid, $flag);
    
if($cfg["member"]["mid"]){
    ## 포인트가 업되었을 경우 다시 현재 로그인 정보를 변경한다.
    $member->savepath="../config/wizmember_tmp/login_user";
    $member->renewLogininfo($cfg["member"]["mid"], $cfg["member"]["mpasswd"]);
}    
echo "var targetDiv = '".$flag."_vote'\n";
# false
if($result){
    echo "var result = true\n";
}else{#true;
    echo "var result = false\n";
}
echo "var msg = '".$board->str."'\n";