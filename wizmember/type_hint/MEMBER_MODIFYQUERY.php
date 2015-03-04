<?
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
include "../../lib/cfg.common.php";
include ("../../config/db_info.php");
include "../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);
;

$sqlstr = "select count(UID) from wizMembers WHERE PWD='$PresentPWD' AND ID = '$HTTP_COOKIE_VARS[MEMBER_ID]'";
$result = $dbcon->get_one($sqlstr);
if(!$result){
echo"<script>window.alert('패스워드가 일치하지 않습니다.'); history.go(-1);</script>";
exit;
}

if($UserName) $Name = $UserName;
if(!$PWD) $PWD = $PresentPWD; 
$BirthDay = $BirthYY."/".$BirthMM."/".$BirthDD;
$MarrDate = $MarrYY."/".$MarrMM."/".$MarrDD;
if(!$Tel1) $Tel1=$Tel1_1."-".$Tel1_2."-".$Tel1_3;
if(!$Tel2) $Tel2=$Tel2_1."-".$Tel2_2."-".$Tel2_3;
if(!$Fax) $Fax=$Fax1."-".$Fax2."-".$Fax3;
$Zip1 = ${Zip1_1}."-".${Zip1_2};
if($address) $Address1 = $address; // new version 에서는 $address나 $MoreAdd없이 다이렉트로 입력된다.
if($MoreAdd) $Address2 = $MoreAdd;
if(!$CompNum) $CompNum = $CompNum1."-".$CompNum2."-".$CompNum3;
$Zip2 = $Zip2_1."-".$Zip2_2;
if(!$Email) $Email = $Email1_1."@".$Email1_2;



$QUERY1 = "UPDATE wizMembers SET 
PWD = '$PWD',
Sex = '$Sex',
BirthDay = '$BirthDay',
BirthType = '$BirthType',
Email = '$Email',
MailReceive = '$MailReceive',
Tel1 = '$Tel1',
Tel2 = '$Tel2',
Fax = '$Fax',
Zip1 = '$Zip1',
Address1 = '$Address1',
Address2 = '$Address2',
Job = '$Job',
Scholarship = '$Scholarship',
Company = '$Company',
CPName = '$CPName',
Zip2 = '$Zip2',
Address3 = '$Address3',
Address4 = '$Address4',
MarrStatus = '$MarrStatus',
MarrDate = '$MarrDate',
Url = '$Url'
WHERE ID='$HTTP_COOKIE_VARS[MEMBER_ID]'
";	
$dbcon->_query($QUERY1,$DB_CONNECT);


/* 기업회원에 관한 정보 변경 */
/* 기업회원으로 등록되어있는지 검사 */
$sqlcompstr = "select count(UID) from wizCom where CompID = '$HTTP_COOKIE_VARS[MEMBER_ID]'";
$result = $dbcon->get_one($sqlcompstr);
if($result){

$CompPersonalID = $ID;
if(!$CompID) $CompID =  $ID;
if(!$CompNum) $CompNum = $CompNum1."-".$CompNum2."-".$CompNum3;
$CompFoundDay = $CompYY."/".$CompMM."/".$CompDD;
if(!$CompChaTel) $CompChaTel=$CompChaTel1_1."-".$CompChaTel1_2."-".$CompChaTel1_3;
if(!$CompChaEmail) $CompChaEmail = $CompChaEmail1_1."@".$CompChaEmail1_2;
$CompChaBirthDay = $CompChaYY."/".$CompChaMM."/".$CompChaDD;
if($CompTel1) $CompTel = $CompTel1."-".$CompTel2."-".$CompTel3;
else if(!$CompTel) $CompTel = $Tel1;
if($CompFax1) $CompFax = $CompFax1."-".$CompFax2."-".$CompFax3;
if($CompZip1_1) $CompZip1 = $CompZip1_1."-".$CompZip1_2;
else if(!$CompZip1) $CompZip1 = $Zip1;
if(!$CompAddress1) $CompAddress1 = $Address1;
if(!$CompAddress2) $CompAddress1 = $Address2;


	$QUERY1 = "UPDATE wizCom SET 
	CompID = '$CompID',CompPass = '$CompPass',CompPersonalID = '$CompPersonalID',CompName = '$CompName',CompNum = '$CompNum',
	CompKind = '$CompKind',CompType = '$CompType',CompMain = '$CompMain',CompFoundDay = '$CompFoundDay',
	CompEmployeeNum = '$CompEmployeeNum',CompZip1 = '$CompZip1',CompAddress1 = '$CompAddress1',CompAddress2 = '$CompAddress2',
	CompTel = '$CompTel',CompFax = '$CompFax',
	CompPreName = '$CompPreName',CompPreNum1 = '$CompPreNum1',CompPreNum2 = '$CompPreNum2',CompPreTel = '$CompPreTel',CompUrl = '$CompUrl',
	CompEmail = '$CompEmail',
	CompChaName = '$CompChaName',CompChaTel = '$CompChaTel',CompChaEmail = '$CompChaEmail',
	CompChaDep = '$CompChaDep',CompChaLevel = '$CompChaLevel',CompChaBirthDay = '$CompChaBirthDay',CompChaBirthType = '$CompChaBirthType',
	CompChaBirthGender = '$CompChaBirthGender',CompContents = '$CompContents'
	WHERE CompID='$HTTP_COOKIE_VARS[MEMBER_ID]'
";

//echo "\$QUERY1 = $QUERY1 <br>";
//exit;	
$dbcon->_query($QUERY1,$DB_CONNECT);

}
?>

<HTML>
<script language=javascript>
window.alert('\n\n<?echo"$Name";?>님의 회원가입 정보가 변경되었습니다.\n\n');
</script>

<META http-equiv='refresh' content='0;url=../../wizmember.php?query=info'>
</HTML>

