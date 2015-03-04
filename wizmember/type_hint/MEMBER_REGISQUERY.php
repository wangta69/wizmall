<?
/*
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
include "../../lib/cfg.common.php";
include ("../../config/db_info.php");
include ("../../config/cfg.core.php");
function LOCK($LOCK_FILE)
{
	while( is_file("../../wizmember_tmp/member/$LOCK_FILE") )
	{
		$z++;
		if ( $z <= 10 ) {
			sleep(1);
		}
		else {
echo "<SCRIPT LANGUAGE=javascript>";
echo "window.alert('\\n죄송합니다.\\n\\n현재 동시접속으로 인해 요청을 수행할 수 없습니다.\\n\\n잠시후에 다시 시도해 주십시오\\n');"; 
echo "history.go(-1);";
echo "</SCRIPT>";
		}
	}
	$fp = fopen("../../wizmember_tmp/member/$LOCK_FILE" , "w");
	fclose($fp);
}
function UNLOCK($LOCK_FILE)
{
	unlink ("../../wizmember_tmp/member/$LOCK_FILE");
}
function ERROR($msg)
{
echo "<script language=javascript>
window.alert('$msg');
history.go(-1);
</script>";
exit;
}

if(trim($ID) == "root" || trim($ID) == "admin"){
$msg = "root나 admin은 예약어로 사용하실 수 없습니다.";
window.alert('$msg');
}

$RegDate = time();
if($UserName) $Name = $UserName;
if(!$Tel1) $Tel1=$Tel1_1."-".$Tel1_2."-".$Tel1_3;
if(!$Tel2) $Tel2=$Tel2_1."-".$Tel2_2."-".$Tel2_3;
if(!$Tel3) $Tel3=$Tel3_1."-".$Tel3_2."-".$Tel3_3;
if(!$Fax) $Fax=$Fax1."-".$Fax2."-".$Fax3;
$Zip1 = ${Zip1_1}."-".${Zip1_2};
$Zip2 = ${Zip2_1}."-".${Zip2_2};
if($address) $Address1 = $address; // new version 에서는 $address나 $MoreAdd없이 다이렉트로 입력된다.
if($MoreAdd) $Address2 = $MoreAdd;
if(!$CompNum) $CompNum = $CompNum1."-".$CompNum2."-".$CompNum3;
if(!$Email) $Email = $Email1_1."@".$Email1_2;
$BirthDay = $BirthYY."/".$BirthMM."/".$BirthDD;
$MarrDate = $MarrYY."/".$MarrMM."/".$MarrDD;
if(!$Grade) $Grade=10;
$GrantSta=$cfg["mem"]["EGrantSta"];  // 현재 승인상태를 확인(관리자모드의 기본 정보가 들어옮)

/* wizCom 용으로 데이타 처리(현재 폼의 종류에 따른 변수를 통일하지 못하여 좀 주먹구구식임..*/
$CompPersonalID = $ID;
if(!$CompID) $CompID =  $ID;
$CompNum = $CompNum1."-".$CompNum2."-".$CompNum3;
if($CompTel1) $CompTel = $CompTel1."-".$CompTel2."-".$CompTel3;
else if(!$CompTel) $CompTel = $Tel1;
$CompZip1 = ${Zip3_1}."-".${Zip3_2};
if($CompFax1) $CompFax = $CompFax1."-".$CompFax2."-".$CompFax3;
if($CompZip1_1) $CompZip1 = $CompZip1_1."-".$CompZip1_2;
else if(!$CompZip1) $CompZip1 = $Zip1;
$CompAddress1 = $Address5;
$CompAddress2 = $Address6;
if(!$CompAddress1) $CompAddress1 = $Address1;
if(!$CompAddress2) $CompAddress1 = $Address2;
$CompFoundDay = $CompYY."/".$CompMM."/".$CompDD;
if(!$CompChaTel) $CompChaTel=$CompChaTel1_1."-".$CompChaTel1_2."-".$CompChaTel1_3;
if(!$CompFax) $CompFax=$CompFax1."-".$CompFax2."-".$CompFax3;
if(!$CompChaEmail) $CompChaEmail = $CompChaEmail1_1."@".$CompChaEmail1_2;
$CompChaBirthDay = $CompChaYY."/".$CompChaMM."/".$CompChaDD;
//echo "\$ID = $ID, \$PwD=$PWD, \$Name=$Name ";






/**********************************************************************/
if ( !$ID || !$PWD || !$Name ) {
	$Str = "\\n\\n비정상적인 방법으로 접근하였습니다.\\n\\n"; WindowAlert($Str);
}
if($Grade=="10"){ /* 일반회원일경우 */
/* 일반회원에 한하여 주민등록번호 책크 */
$id_exists = $dbcon->_fetch_array($dbcon->_query( "select * from wizMembers where ID='$ID'", $DB_CONNECT )); 
$num_exists = $dbcon->_fetch_array($dbcon->_query( "select * from wizMembers where Jumin1='$Jumin1' AND Jumin2='$Jumin2'", $DB_CONNECT )); 
if ($id_exists) {
	$Str = "\\n\\n이미 등록된 아이디입니다.\\n\\n"; WindowAlert($Str);
}
if ($num_exists && $Jumin1) {
	$Str = "\\n\\n이미 등록된 주민등록번호입니다.\\n\\n관리자에게 문의하십시오\\n\\n"; WindowAlert($Str);
}
}
/*****************************************************************************
  추천인에게 포인트 적립해주기.
*****************************************************************************/
if ($RecID) {
$sqlstr = "select Point,Pointinfo from wizMembers where ID='$RecID'";
$dbcon->_query($sqlstr , $DB_CONNECT) or die("$sqlstr");
$reqer_exists = $dbcon->_fetch_array(); 
	if ($reqer_exists) {
		$UpdatePoint = $reqer_exists[Point] + $cfg["mem"]["RPoint"];
		$UpdatePointinfo = $cfg["mem"]["RPoint"]."|".time()."|$Name($ID)회원의 추천보너스입니다.|\n";
		$UPDATE_STR = "UPDATE wizMembers SET Point='$UpdatePoint', Pointinfo='$reqer_exists[Pointinfo]UpdatePointinfo' WHERE ID='$RecID'";
		$dbcon->_query("$UPDATE_STR", $DB_CONNECT) or die("$UPDATE_STR");
		$UPDATE_STR = "UPDATE wizMembersMore SET Pointinfo='$reqer_exists[Pointinfo]UpdatePointinfo' WHERE MID='$RecID'";
		$dbcon->_query("$UPDATE_STR", $DB_CONNECT) or die("$UPDATE_STR");		
	}
}
/**************************************************************************************************
  DB CONNECT -> INSERT INTO wizMembers ; DB연결후 회원데이터를 저장한다. 1차 기본 정보 입력
**************************************************************************************************/
$Point = $cfg["mem"]["EPoint"];
if($cfg["mem"]["EPoint"]) $Pointinfo = $cfg["mem"]["EPoint"]."|".time()."|고객님의 회원가입 축하보너스입니다.|\n";
$QUERY1 = "INSERT INTO wizMembers (
ID,PWD,Name,NickName,PWDHint,PWDAnswer,Sex,Jumin1,Jumin2,BirthDay,BirthType,Email,MailReceive,Tel1,Tel2,Fax,Zip1,Address1,Address2,AddressPoint1,Job,Scholarship,Company,Compnum,CPName,Zip2,
Address3,Address4,AddressPoint2,MarrStatus,MarrDate,RegDate,Url,RecID,GrantSta,Point,Pointinfo,Grade,WriteNum,OptionNum,LoginNum
)
VALUES(
'$ID','$PWD','$Name','$NickName','$PWDHint','$PWDAnswer','$Sex','$Jumin1','$Jumin2','$BirthDay','$BirthType','$Email','$MailReceive','$Tel1','$Tel2','$Fax','$Zip1','$Address1','$Address2','$AddressPoint1','$Job','$Scholarship','$Company','$Compnum','$CPName','$Zip2','$Address3','$Address4','$AddressPoint2','$MarrStatus','$MarrDate','$RegDate','$Url','$RecID','$GrantSta','$Point','$Pointinfo','$Grade','0','0','0'
)";	
$QUERY1_RESULT = $dbcon->_query($QUERY1,$DB_CONNECT) or die("$QUERY1");

/**************************************************************************************************
  DB CONNECT -> INSERT INTO wizMembersMore ; DB연결후 회원데이터를 저장한다. 2차 기본 정보 입력
**************************************************************************************************/
/* 파일 업로딩 시작 */
unset($UPDIR);
for($i=0; $i<sizeof($file); $i++){
	if($file[$i]!="none" && $file[$i]){
    	if (file_exists("../../wizmember_tmp/user_image/$file_name[$i]")) {
	    $file_name[$i] = date("is")."_$file_name[$i]";
		
    	}    
	    if(!copy($file[$i], "../../wizmember_tmp/user_image/$file_name[$i]")) {
    	echo "파일 업로드에 실패 하였습니다.";
	    exit;}
	$UPDIR .=$file_name[$i]."|";
	}	
}
/* 파일 업로딩 끝 */
$MID = $ID;
$sqlstr = "INSERT INTO wizMembersMore (
MID,Pointinfo,MHobby,MDesc,MIntroduce,MGreeting,MType,MSN,Religion,Height,Figure,Face,SkinColor,Blood,MCharacter,Smoking,UPDIR,Spare1,Spare2,Spare3
)
VALUES(
'$MID','$Pointinfo','$MHobby','$MDesc','$MIntroduce','$MGreeting','$MType','$MSN','$Religion','$Height','$Figure','$Face','$SkinColor','$Blood','$MCharacter','$Smoking','$UPDIR','$Spare1','$Spare2','$Spare3'
)";	

$result = $dbcon->_query($sqlstr,$DB_CONNECT);

/**************************************************************************************************
  DB CONNECT -> INSERT INTO wizCom ; DB연결후 회원데이터를 저장한다. 3차 회사 정보 입력
**************************************************************************************************/
if($Grade == 5){
/* 
기업회원 구분(wizCom.CompSort)은 크게 공급처( <50 ) 과 소매처(50 <=, <100) 로 분류된다. 
01 : 도매공급자, 02 : 소매공급자, 03 : 생산자), 50 : 쇼핑몰(온라인)기업고객고객, 51 : 도매판매처, 52, 소매판매처 .. 경우에따라 이곳은 자유롭게 프로그램가능)
*/
$CompSort =  "50";
$QUERY1 = "INSERT INTO wizCom (
CompSort,CompID,CompPass,CompPersonalID,CompName,CompNum,CompKind,CompType,CompMain,CompFoundDay,CompEmployeeNum,CompZip1,CompAddress1,CompAddress2,CompTel,CompFax,CompPreName,CompPreNum1,CompPreNum2,CompPreTel,CompUrl,CompEmail,CompChaName,CompChaTel,CompChaEmail,CompChaDep,CompChaLevel,CompChaBirthDay,CompChaBirthType,CompChaBirthGender,CompContents
)
VALUES(
'$CompSort','$CompID','$CompPass','$CompPersonalID','$CompName','$CompNum','$CompKind','$CompType','$CompMain','$CompFoundDay','$CompEmployeeNum','$CompZip1','$CompAddress1','$CompAddress2','$CompTel','$CompFax','$CompPreName','$CompPreNum1','$CompPreNum2','$CompPreTel','$CompUrl','$CompEmail','$CompChaName','$CompChaTel','$CompChaEmail','$CompChaDep','$CompChaLevel','$CompChaBirthDay','$CompChaBirthType','$CompChaBirthGender','$CompContents'
)";

$QUERY1_RESULT = $dbcon->_query($QUERY1,$DB_CONNECT) or die("$QUERY1");
}
/*******************************************************************************
지금 부터 본격적인 회원로긴(쿠키값 설정 및 파일 생성)이 시작된다
*******************************************************************************/
if($GrantSta == "01" || $GrantSta == "03"):
$MEMBER_EXISTS = $dbcon->_query("SELECT ID,PWD,Name,Email,Url,Jumin1,Grade
FROM wizMembers 
WHERE ID='$ID'
AND PWD='$PWD'");
$LIST = $dbcon->_fetch_array($MEMBER_EXISTS);
if ( !$LIST ) {
	$msg = "아이디와 패스워드가 일치하지 않습니다."; error($msg);
}
$CurrentID = $LIST[ID];     // 아이디
$CurrentPW = $LIST[PWD];     // 패스워드
$CurrentNAME = $LIST[Name]; // 이름
$CurrentEMAIL = $LIST[Email]; // 이멜
$CurrentURL = $LIST[Url];     // 홈
$CurrentGrade = $LIST[Grade];     // 등급
endif;
/*******************************************************************************
회원로그파일의 생성시간을 구해서 2시간(mktime()기준 - 7200)이 경과된 경우 자동삭제..
*******************************************************************************/
$LOG_DIR = opendir("../../wizmember_tmp/login_user");
while($LOG_FILE = readdir($LOG_DIR)) {
	if(is_file("../../wizmember_tmp/login_user/$LOG_FILE") && mktime() - filemtime("../../wizmember_tmp/login_user/$LOG_FILE") > 7200) {
		unlink("../../wizmember_tmp/login_user/$LOG_FILE");
	}
}
closedir($LOG_DIR);
$LLIST = $dbcon->_fetch_array($dbcon->_query("SELECT LoginNum FROM wizMembers WHERE ID='$CurrentID'",$DB_CONNECT));
$UPDATE_LOGIN_NUM = $LLIST[LoginNum] + 1;	
$dbcon->_query("UPDATE wizMembers SET LoginNum='$UPDATE_LOGIN_NUM' WHERE ID='$CurrentID'",$DB_CONNECT);
setcookie("MEMBER_NAME", "$CurrentNAME", 0, "/");
setcookie("MEMBER_PWD", "$CurrentPW", 0, "/");
setcookie("MEMBER_ID", "$CurrentID", 0, "/");
setcookie("MEMBER_EMAIL", "$CurrentEMAIL", 0, "/");
setcookie("MEMBER_URL", "$CurrentURL", 0, "/");
setcookie("MEMBER_Grade", "$CurrentGrade", 0, "/");
$fp = fopen("../../wizmember_tmp/login_user/$CurrentID.cgi", "w");
$LoginTime = time(); 
fwrite($fp, "$CurrentID|$CurrentNAME|$Log_Time|$CurrentEMAIL|$CurrentURL|");
fclose($fp);
/* 이곳의 $QUERY1_RESULT는 아래 이메일을 보내는 곳에 참조되므로 변수를 변화하지 않도록 한다.*/
/****************************************************************************/
if(strcmp($cfg["mem"]["SendMail"],"no")) include("./MEMBER_REGIS_MAIL.php");
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script language=javascript>
window.alert('\n가입이 정상적으로 이루어졌습니다. \n회원으로 가입해 주신 <?=$Name?>님께 진심으로 감사드립니다.');
</script>
<?
if($ispopup == "yes"){// 팝업창에서 값이 넘어 온 경우
echo "<script>window.close();</script>";
exit;
}

if ($file=="admin") { // 관리자 모드에서 값이 넘어 온 경우
echo "<script>history.go(-1)</script>";
exit;
}else if ($goto=="MEMBER_REGIST_DONE") { // 회원가입완료페이지로 
echo "<META http-equiv='refresh' content='0;url=../../wizmember.php?query=regis_done'>";
exit;
}else { // 장바구니 - 현재방식
echo "<META http-equiv='refresh' content='0;url=../../'>";
exit;
}

?>
</HTML>
</head>
</html>
