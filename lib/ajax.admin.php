<?php
/*include "./cfg.common.php";
include "../config/cfg.core.php";
include "./class.common.php";
$common = new common();
$common->db_connect($dbcon);
$common->pub_path = "../";
$cfg["member"] = $common->getLogininfo();//로그인 정보를 가져옮


*/
include "../lib/inc.depth1.php";
include "./class.admin.php";
$admin = new admin();
$admin->get_object($dbcon, $common);

if(!$admin->accessGrade($cfg["member"]["mgrade"])) exit;

$smode		= $_POST["smode"];
$type		= $_POST["type"];
$userid		= $_POST["userid"];
$point		= $_POST["point"];
$content	= $_POST["content"];
$csrf		= $_POST["csrf"];

if($smode == "in_point" && $common->checsrfkey($csrf)){//포인트 입력 ajax 처리
	if($type == "exp"){
		$common->point_fnc($userid, $point, 41, $content, 6);
	}else if($type == "point"){
		$common->point_fnc($userid, $point, 41, $content);
	}
	echo json_encode(array($type, $point));
	//echo $type."|".$point;
	//exit;
}else if($smode == "chflag"){//베너관리에서 디스플레이 여부 설정
	$sqlstr = "update wizbanner set showflag = (showflag +1) mod 2 where uid = ".$uid;
	$dbcon->_query($sqlstr);
	
	$sqlstr = "select showflag from wizbanner where uid = ".$uid;
	$result = $dbcon->get_one($sqlstr);
	echo $result;
}else if($smode == "chflag1"){//메인설정 > 컨텐츠설정 > 추천게임에서 처리
	$sqlstr = "update wizsearchKeyword set showflag = (showflag +1) mod 2 where uid = ".$uid;
	$dbcon->_query($sqlstr);
	
	$sqlstr = "select showflag from wizsearchKeyword where uid = ".$uid;
	$result = $dbcon->get_one($sqlstr);
	echo $result;
}else if($smode == "wizmain"){//메인설정 > 컨텐츠설정 > 메인관리의 각다들 처리
	$sqlstr = "update wizmain set showflag = (showflag +1) mod 2 where uid = ".$uid;
	$dbcon->_query($sqlstr);
	
	$sqlstr = "select showflag from wizmain where uid = ".$uid;
	$result = $dbcon->get_one($sqlstr);
	echo $result;
}