<?php
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/

include "../lib/inc.depth1.php";

$member->saveflag	= $saveflag;//아이디저장여부
//echo "AdminGrade:".$AdminGrade;
//echo "wizmemberID:".$wizmemberID;
//echo "wizmemberPWD:".$wizmemberPWD;
//exit;

if($AdminGrade == 1){ //ROOT 관리자 이면

	$sqlstr = "select login_fail_cnt from wizTable_Main where Grade = 'A'";
	$result	= $dbcon->get_one($sqlstr);
    
    if(!$member->loginattemptIp($_SERVER['REMOTE_ADDR'])){
           $common->js_alert("5회이상 실패하셨습니다. 1분후에 다시 시도해 주세요", "../");
     }
    
	if($result > $cfg["admin"]["LoginLimitCnt"] && $cfg["admin"]["LoginLimitCnt"] != 0){
		$common->js_alert("".$cfg["admin"]["LoginLimitCnt"]."회이상 로그인에 실패하였습니다.", "./default.php");
	}else{
		$member->membertype="admin";
		$rtn = $member->login_check($wizmemberID, $wizmemberPWD);//로그인처리
		if($rtn["result"] == "0"){
		    $member->setloginlog($wizmemberID, 0);//로그인 기록
            
			$sqlstr = "update wizTable_Main set login_fail_cnt = 0 where Grade = 'A'";
			$dbcon->_query($sqlstr);
			
			$str="\\n어서오십시오.\\n\\n Super관리자 권한으로 관리자 모드로 로그인 되셨습니다. \\n";
			$common->js_alert($str, "./default.php");
		}else{
		    $member->setloginlog($wizmemberID, 1);//로그인 기록
            
			$sqlstr = "update wizTable_Main set login_fail_cnt = login_fail_cnt + 1 where Grade = 'A'";
			$dbcon->_query($sqlstr);
            
			$common->js_alert($rtn["msg"], "./default.php");
		}
	}
}elseif($AdminGrade == 2){//일반관리자 이면
	$rtn = $member->login_check($wizmemberID, $wizmemberPWD);//로그인처리
	$str="\\n어서오십시오.\\n\\n 일반관리자 권한으로 관리자 모드로 로그인 되셨습니다. \\n";
	$common->js_alert($str, "./default.php");
}elseif($AdminGrade == 3){//일반 이면
	setcookie("MANAGER_ID", $ADMINID, 0, "/");
	setcookie("MANAGER_PASS", $ADMINPASS, 0, "/");
	setcookie("MANAGER_GRADE", $MemberGrade, 0, "/");
	header("Content-Type: text/html; charset=".$cfg["common"]["lan"]); 
	$str="\\n어서오십시오.\\n\\n 일반 권한으로 관리자 모드로 로그인 되셨습니다. \\n";
	$common->js_alert($str, "./default.php");	
}elseif($AdminGrade == 4){//인트라넷사용자
	$sqlstr = "select grade FROM wizIntraMember WHERE id='".$ADMINID."' and pass='".$ADMINPASS."'";
	$MemberGrade = $dbcon->get_one($sqlstr);
	if ( $MemberGrade) {
		setcookie("MANAGER_ID", $ADMINID, 0, "/");
		setcookie("MANAGER_PASS", $ADMINPASS, 0, "/");
		setcookie("MANAGER_GRADE", $MemberGrade, 0, "/");
		header("Content-Type: text/html; charset=".$cfg["common"]["lan"]); 
		$str="\\n어서오십시오.\\n\\n 인터라넷 사용자 모드로 로그인 되셨습니다. \\n";
		$common->js_alert($str, "./default.php");	
	}
}


$str="로그인에 실패하였습니다. \\n다시 시도해 주시기 바랍니다.\\n";
$common->js_alert($str, "./default.php");		
