<?php
/*
제작자 : 폰돌
URL : http://www.shop-wiz.com
email : master@shop-wiz.com
*** Updating List ***
*/

include_once ("../../lib/inc.depth2.php");




if(trim($id) == "root" || trim($id) == "admin"){
	$str = "root나 admin은 예약어로 사용하실 수 없습니다..\\n\\n";
	$common->js_alert($str);
}

$RegDate = time();


$ci	= $_POST["hidden_ci"];
$di	= $_POST["hidden_di"];


if(!$tel1) $tel1=$tel1_1."-".$tel1_2."-".$tel1_3;
if(!$tel2) $tel2=$tel2_1."-".$tel2_2."-".$tel2_3;
if(!$tel3) $tel3=$tel3_1."-".$tel3_2."-".$tel3_3;
if(!$fax) $fax=$fax1_1."-".$fax1_2."-".$fax1_3;
$zip1 = $zip1_1."-".$zip1_2;
$zip2 = $zip2_1."-".$zip2_2;

if(!$companynum) $companynum = $companynum1."-".$companynum2."-".$companynum3;
if(!$email) $email = $email_1."@".$email_2;
$birthdate = $birthyy."/".$birthmm."/".$birthdd;
$marrdate = $marryy."/".$marrmm."/".$marrdd;
if(!$mgrade) $mgrade=10;
$mgrantsta=$cfg["mem"]["EGrantSta"];  // 현재 승인상태를 확인(관리자모드의 기본 정보가 들어옮)

if(!$gender){//성별을 구한다.
	if($jumin2) $num = substr($jumin2, 0,1);
	else if($jumin) $num = substr($jumin, 7,1);
	$gender = ($num == "2" || $num == "4") ? "2":"1";
}

/**********************************************************************/

if ( !$id || !$passwd || !$name ) {
	$str = "\\n\\n비정상적인 방법으로 접근하였습니다.\\n\\n";
	$common->js_alert($str);
}

$id_exists = $dbcon->get_one( "select count(1) from wizMembers where mid='".$id."'"); 
if ($id_exists) {
	$str = "\\n\\n이미 등록된 아이디입니다.\\n\\n";
	$common->js_alert($str);
}

//$jumin_exists = $dbcon->get_one("select count(1) from wizMembers_ind where jumin1='$jumin1' AND jumin2='$jumin2'"); 
//$jumin_exists = $dbcon->get_one("select count(1) from wizMembers_ind where jumin1='".$common->mksqlpwd($jumin1, "memjumin")."' AND jumin2='".$common->mksqlpwd($jumin2, "memjumin")."'"); 
//if ($jumin_exists && trim($jumin1)) {//주민번호 입력이 없을경우 바로 
//	$str = "\\n\\n이미 등록된 주민등록번호입니다.\\n\\n관리자에게 문의하십시오\\n\\n";
//	$common->js_alert($str);
//}


//CI를 이용해서 가입한 경우
if($ci){
	$ci_exists	= $dbcon->get_one("select count(1) from wizMembers_ind where ci='".$ci."'"); 
	if ($ci_exists) {
		$str = "\\n\\n인증을 통해 이미 사이트에 가입되었습니다.\\n\\n";
		$common->js_alert($str);
	}
}

/*****************************************************************************
  추천인에게 포인트 적립해주기.
*****************************************************************************/
if ($recid && $cfg["mem"]["RPoint"]) {
	$reqer_exists = $dbcon->get_one("select count(1) from wizMembers where mid='".$recid."'"); 
	if ($reqer_exists) {
		$content = $name."(".$id.")회원의 추천보너스입니다.";
		$common->point_fnc($recid, $cfg["mem"]["RPoint"], 3);
	}
}
/**************************************************************************************************
  DB CONNECT -> INSERT INTO wizMembers ; DB연결후 회원데이터를 저장한다. 1차 기본 정보 입력
**************************************************************************************************/

unset($ins);
$ins["mid"]    = $id;
$ins["mpasswd"]    = $common->mksqlpwd($passwd);
$ins["mname"]    = $name;
$ins["mregdate"]    = time();
$ins["mgrantsta"]    = $mgrantsta;
$ins["mtype"]    = $type;
$ins["mgrade"]    = $mgrade;
$ins["mailreceive"]    = $mailreceive;
$ins["msmsreceive"]    = $smsreceive;
$ins["mloginnum"]    = 0;
$ins["mlogindate"]    = time();
$ins["mloginip"]    = $_SERVER['REMOTE_ADDR'];

$dbcon->insertData("wizMembers", $ins);


unset($ins);
$ins["id"]    = $id;
$ins["nickname"]    = $nickname;
$ins["pwdhint"]    = $pwdhint;
$ins["pwdanswer"]    = $pwdanswer;
$ins["gender"]    = $gender;
$ins["ci"]    = $ci;
$ins["di"]    = $di;
$ins["birthdate"]    = $birthdate;
$ins["birthtype"]    = $birthtype;
$ins["marrdate"]    = $marrdate;
$ins["marrstatus"]    = $marrstatus;
$ins["email"]    = $email;
$ins["mailreceive"]    = $mailreceive;
$ins["job"]    = $job;
$ins["scholarship"]    = $scholarship;
$ins["company"]    = $company;
$ins["companynum"]    = $companynum;
$ins["telflag"]    = $telflag;
$ins["tel1"]    = $tel1;
$ins["tel2"]    = $tel2;
$ins["tel3"]    = $tel3;
$ins["fax"]    = $fax;
$ins["zip1"]    = $zip1;
$ins["addressflag"]    = $addressflag;
$ins["address1"]    = $address1;
$ins["address2"]    = $address2;
$ins["zip2"]    = $zip2;
$ins["address3"]    = $address3;
$ins["address4"]    = $address4;
$ins["url"]    = $url;
$ins["recid"]    = $recid;
$dbcon->insertData("wizMembers_ind", $ins);

## 메일 발송용 기본 정보를 배열에 입력
$infomail["id"]		= $id;
$infomail["passwd"]	= $passwd;
$infomail["name"]	= $name;
$infomail["email"]	= $email;

## 회원가입보너스 지급
if($cfg["mem"]["EPoint"])$common->point_fnc($id, $cfg["mem"]["EPoint"], 1);

/**************************************************************************************************
  DB CONNECT -> INSERT INTO wizMembersMore ; DB연결후 회원데이터를 저장한다. 2차 기본 정보 입력
**************************************************************************************************/
/* 파일 업로딩 시작 (사용자 이미지가 있는 경우)*/
unset($UPDIR);
$filepath = "../../config/wizmember_tmp/user_image/";
for($i=0; $i<sizeof($file); $i++){
	if($file[$i]!="none" && $file[$i]){
    	if (file_exists($filepath.$file_name[$i])) {
	    $file_name[$i] = date("is")."_".$file_name[$i];
		
    	}    
	    if(!copy($file[$i], $filepath.$file_name[$i])) {
			//$common->js_alert('파일업로드에 실패하였습니다.');
		}
	$UPDIR .=$file_name[$i]."|";
	}	
}
/* 파일 업로딩 끝 */

/******[위즈 인트라넷 사용자용 - 현재 사용하지 않음]*******************************************************************
if($WhereRegis == "Admin" || $file=="admin"){
	echo "/intra/main.php?menushow=menu6&THEME=member/member1";
	$common->js_location($goto, $flag=null);
}
***/

/*******************************************************************************
지금 부터 본격적인 회원로긴(쿠키값 설정 및 파일 생성)이 시작된다
*******************************************************************************/
if($cfg["mem"]["EGrantSta"] != "04"){//초기가입상태가 후 인정이 아니면
	$member->savepath	= "../../config/wizmember_tmp/login_user";//파일처리시 저장경로 설정
	$member->loginform	= "regis";
	$member->login_check($id, $passwd);//로그인처리
}

/* 메일 발송 */
if($cfg["mem"]["SendMail"] == "yes"){// include("./MEMBER_REGIS_MAIL.php");

	if(is_file("../../config/regismail_info.php")){
		$DATA1 = file("../../config/regismail_info.php");
		while($dat1 = each($DATA1)) {
			$dat1[1] = nl2br(htmlspecialchars($dat1[1]));
			$content .= $dat1[1];
		}
	}

	$mailformfile = file("../../skinwiz/mailform/default/MEMBER_REGIS_MAIL.php");
	$mailform = "";
	for($i=0;$i<=sizeof($mailformfile); $i++){
		$mailform .= $mailformfile[$i];
		
	}
	$mailform  = chform($mailform);


	if ( $email) {
		include_once "../../lib/class.mail.php";//메일관련 클라스 인클루드
		$mail		= new classMail();

		$mail->From ($cfg["admin"]["ADMIN_EMAIL"], $common->conv_euckr($cfg["admin"]["ADMIN_TITLE"]));
		$mail->To ($email);
		$mail->Organization ($common->conv_euckr($cfg["admin"]["ADMIN_TITLE"]));
		$mail->Subject ($common->conv_euckr("개인정보 안내입니다. - ".$cfg["admin"]["ADMIN_TITLE"]));
		$mail->Body ($common->conv_euckr($mailform));
		$mail->Priority (3);
		//$mail->debug	= true;
		$ret = $mail->Send();

		//exit;
	}
}	

	
	function chform($str){
		global $cfg, $name, $id, $passwd, $content;
		$str = str_replace("{url}", $cfg["admin"]["MART_BASEDIR"]."/skinwiz/mailform/default", $str);
		$str = str_replace("{homeurl}", $cfg["admin"]["MART_BASEDIR"], $str);
		$str = str_replace("{username}", $name, $str);
		$str = str_replace("{userid}", $id, $str);
		$str = str_replace("{userpwd}", $passwd, $str);
		$str = str_replace("{content}", $content, $str);
		$str = str_replace("{admin.title}", $cfg["admin"]["ADMIN_TITLE"], $str);
		$str = str_replace("{admin.name}", $cfg["admin"]["ADMIN_NAME"], $str);
		$str = str_replace("{admin.companynum}", $cfg["admin"]["COMPANY_NUM"], $str);
		$str = str_replace("{admin.companyaddress}", $cfg["admin"]["COMPANY_ADD"], $str);
		$str = str_replace("{admin.companyname}", $cfg["admin"]["COMPANY_NAME"], $str);
		$str = str_replace("{admin.companyceo}", $cfg["admin"]["PRESIDENT"], $str);
		$str = str_replace("{admin.companytel}", $cfg["admin"]["CUSTOMER_TEL"], $str);
		$str = str_replace("{admin.companyfax}", $cfg["admin"]["CUSTOMER_FAX"], $str);
		return $str;	
	}
	

	$str = "\\n가입이 정상적으로 이루어졌습니다. \\n회원으로 가입해 주신 ".$name."님께 진심으로 감사드립니다.";
	$common->js_alert($str, "alert");

	if($ispopup == "yes"){// 팝업창에서 값이 넘어 온 경우
		$common->js_windowclose();
	}else if ($goto=="MEMBER_REGIST_DONE") { // 회원가입완료페이지로 
		$goto = "../../wizmember.php?query=regis_done";
		$common->js_location($goto);
	}else if ($goto=="REGIST_PAYMEMBER") { // 유료회원가입페이지
		$goto = "../../wizmember.php?query=regis_paymember";
		$common->js_location($goto);
	}else { // 장바구니 - 현재방식
		$goto = "../../";
		$common->js_location($goto);
	}