<?php
if(!$id) {
	$msg = "id를 입력해 주세요";
	$common->js_alert($msg);
}

if((strlen($id) > 12) || (strlen($id) < 4)) {

	$msg = "아이디는 4~12자 사이의 영문숫자 혼합으로 구성되어야 합니다.";
	$common->js_alert($msg);
}

$uid = $dbcon->get_one("SELECT UID FROM wizMems WHERE ID='".$id."'");

if ( $uid ) {
	$msg = "\\n\\n추천하시는분의 아이디 ".$id." 는 존재하며  \\n\\n추천받으신 ".$id." 회원님에게는 소정의 포인트를   \\n\\n지급하여드립니다.\\n\\n";
	$common->js_alert($msg);
}else{
	$msg = "\\n\\n존재하지 않는 아이디입니다.\\n\\n";
	$common->js_alert($msg);
}