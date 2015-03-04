<?php
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
include_once ("../../lib/inc.depth2.php");

$mid = $cfg["member"]["mid"];
$mname = $cfg["member"]["mname"];

if($smode == "chpwd"){//비밀번호만변경
	$sqlstr = "select count(*) from wizMembers WHERE mpasswd='".$common->mksqlpwd($ppasswd)."' AND mid = '".$mid."'";

	$result = $dbcon->get_one($sqlstr);
	if(!$result){
		$common->js_alert("패스워드가 일치하지 않습니다.");
	}else{
		$sqlstr = "UPDATE wizMembers SET 
		mpasswd = '".$common->mksqlpwd($passwd)."'
		WHERE mid='".$mid."'
		";	
		$dbcon->_query($sqlstr);
		$str = "\\n\\n".$mname."님의 비밀번호가 변경되었습니다.\\n\\n";
		$goto = $common->pub_path."wizmember.php?query=chpass";
		$common->js_alert($str, $goto);
	}
}else{
	$sqlstr = "select count(*) from wizMembers WHERE mpasswd='".$common->mksqlpwd($ppasswd)."' AND mid = '".$mid."'";
	$result = $dbcon->get_one($sqlstr);
	if(!$result){
		$common->js_alert("패스워드가 일치하지 않습니다.");
	}

	if(!$tel1) $tel1				= $tel1_1."-".$tel1_2."-".$tel1_3;
	if(!$tel2) $tel2				= $tel2_1."-".$tel2_2."-".$tel2_3;
	if(!$tel3) $tel3				= $tel3_1."-".$tel3_2."-".$tel3_3;
	if(!$fax) $fax					= $fax1_1."-".$fax1_2."-".$fax1_3;
	$zip1							= $zip1_1."-".$zip1_2;
	$zip2							= $zip2_1."-".$zip2_2;
	if(!$gender&&$jumin2) $gender	= $member->getGender($jumin2);
	if(!$companynum) $companynum	= $companynum1."-".$companynum2."-".$companynum3;
	if(!$email) $email				= $email_1."@".$email_2;
	$birthdate						= $birthyy."/".$birthmm."/".$birthdd;
	$marrdate						= $marryy."/".$marrmm."/".$marrdd;
	$passwd							= trim($passwd) ? trim($passwd):$ppasswd;



	$ins["mpasswd"]					= $common->mksqlpwd($passwd);
	$ins["mname"]					= $name;
	$ins["mailreceive"]				= $mailreceive;
	$dbcon->updateData("wizMembers", $ins, "mid='".$mid."'");

	unset($ins);
	$ins["nickname"]				= $_POST["nickname"];
//	$ins["pwdhint"]					= $pwdhint;
//	$ins["pwdanswer"]				= $pwdanswer;
	$ins["gender"]					= $gender;
//	$ins["jumin1"]					= $jumin1;
//	$ins["jumin2"]					= $jumin2;
	$ins["birthdate"]				= $birthdate;
	$ins["birthtype"]				= $birthtype;
	$ins["marrdate"]				= $marrdate;
	$ins["marrstatus"]				= $marrstatus;
	$ins["email"]					= $email;
	$ins["mailreceive"]				= $mailreceive;
	$ins["job"]						= $job;
	$ins["scholarship"]				= $scholarship;
	$ins["company"]					= $company;
	$ins["companynum"]				= $companynum;
	$ins["telflag"]					= $telflag;
	$ins["tel1"]					= $tel1;
	$ins["tel2"]					= $tel2;
	$ins["tel3"]					= $tel3;
	$ins["fax"]						= $fax;
	$ins["addressflag"]				= $addressflag;
	$ins["zip1"]					= $zip1;
	$ins["address1"]				= $address1;
	$ins["address2"]				= $address2;
	$ins["zip2"]					= $zip2;
	$ins["address3"]				= $address3;
	$ins["address4"]				= $address4;
	$ins["url"]						= $url;

	$dbcon->updateData("wizMembers_ind", $ins, "id='".$mid."'");

	$str = "\\n\\n".$name."님의 회원가입 정보가 변경되었습니다.\\n\\n";
	$goto = $common->pub_path."wizmember.php?query=info";
	$common->js_alert($str, $goto);
}