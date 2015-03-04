<?php
include "./inc.depth1.php";
include "../config/cfg.core.php";

//include ("./class.member.php");
//$member = new member();
//$member->get_object($dbcon,$common);
if($smode == "login_check"){
	$member->loginpoint = $cfg["mem"]["LPoint"];//로그인 포인트 지급
	$member->saveflag	= $saveflag;//아이디저장여부
	$member->ajax = true; //ajax로 처리 될경우 alert대신 리턴 메시지 처리
	$result = $member->login_check($wizmemberID, $wizmemberPWD);//로그인처리
	
	//print_r($result);
	if($result[0] != 0){

	}else{
		## 정상 수행시 avatar 관련 초기화 시킨다.
		/*
		include "./class.avatar.php";
		$avatar = new avatar();
		$avatar->get_object($dbcon,$common);
		$avatar->WIZTABLE = $WIZTABLE;
		$avatar->InitAvatar($member->meminfo);//아바타 초기화($member->meminfo : 상기 $member->login_check 중 start_login 에 이 변수가 발생
		*/
	}
	echo json_encode($result);
	exit;
}else if($smode == "id_check"){
	$id = $_POST["id"];
	$sqlstr = "select count(1) from wizMembers where mid = '".$id."'";
    $cnt = $dbcon->get_one($sqlstr);
	if($cnt){
		echo "0";
	}else{
		echo "1";
	}
	exit;
}else if($smode == "id_search"){
	
//smode:"id_search",username:name,userjumin:jumin
	$sqlstr = "select i.email, m.mname, m.mid, m.mpasswd, m.mgrantsta, m.mregdate from wizMembers m left join wizMembers_ind i on m.mid=i.id where m.mname='".$username."' AND i.jumin=PASSWORD('".$userjumin."')";
	//echo $sqlstr;
	$dbcon->_query($sqlstr );
	$result = $dbcon->_fetch_array(); 
	if ( !$result ) {
		$result_code = "0001";//일치정보없음
	}else if($result["mgrantsta"] == "00"){
		$result_code = "0002";//탈퇴회원
	}else{
		$result_code = "0000";
		extract($result);
	}
	
	echo $result_code."|".$mname."|".$mid."|".$mpasswd."|".$email."|".$mregdate."|".$mgrantsta;
}else if($smode == "pass_search"){
	
//smode:"pass_search",username:name.value,userjumin:jumin.value,userid:id.value
	$sqlstr = "select i.email, m.mname, m.mid, m.mpasswd, m.mgrantsta, m.mregdate from wizMembers m left join wizMembers_ind i on m.mid=i.id where m.mname='".$username."' AND i.jumin=PASSWORD('".$userjumin."')";
	//echo $sqlstr;
	$dbcon->_query($sqlstr );
	$result = $dbcon->_fetch_array(); 
	if ( !$result ) {
		$result_code = "0001";//일치정보없음
	}else if($result["mgrantsta"] == "00"){
		$result_code = "0002";//탈퇴회원
	}else if($result["mid"] != $userid){
		$result_code = "0003";//아이디 불일치		
	}else{
		$result_code = "0000";
		extract($result);
	}
	
	echo $result_code."|".$mname."|".$mid."|".$mpasswd."|".$email."|".$mregdate."|".$mgrantsta;
}else if($smode == "infopass"){
	$sqlstr = "select count(uid)  from wizMembers where mid='".$userid."' AND mpasswd=PASSWORD('".$userpass."')";
	//echo $sqlstr;
	$result = $dbcon->get_one($sqlstr);;
	if ( !$result) {
		$result_code = "0001";//일치정보없음
	}else{
		$result_code = "0000";
		$_SESSION["infopass"] = $userpass;//다음단 시작과 동시에 삭제한다.
	}
	
	echo $result_code;
}else if($smode == "outpass"){
	$sqlstr = "select count(uid)  from wizMembers where mid='".$userid."' AND mpasswd=PASSWORD('".$userpass."')";
	//echo $sqlstr;
	$result = $dbcon->get_one($sqlstr);;
	if ( !$result) {
		$result_code = "0001";//일치정보없음
	}else{
		$result_code = "0000";
		$_SESSION["infopass"] = $userpass;//다음단 시작과 동시에 삭제한다.
	}
	
	echo $result_code;
}