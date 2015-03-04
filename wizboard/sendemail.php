<?
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
05-07-16 - GID(group id)추가
*/
?>
<?
사용하지 않음
/*
include "../config/db_info.php";

if($GID) $TargetTable = "wizTable_${GID}_${BID}";
else $TargetTable = "wizTable_${BID}";
//echo $TargetTable;
$sqlstr = "select NAME, EMAIL from $TargetTable where UID = '$UID' limit 1";
$dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array();

/* $WizMailSkin : 폼메일 스킨, $userEmail : 이메일 , $userName : 유저명을 util/wizmail/wizmail.php로 전달
$WizMailSkin = "BASICKO";
$userEmail = $list["EMAIL"];
$userName = $list["NAME"];
?>
<script language="JavaScript">
<!--
file_url = "../util/wizmail/wizmail.php?WizMailSkin=<?=$WizMailSkin?>&userEmail=<?=$userEmail?>&userName=<?=$userName?>";
location.href=file_url;
//-->
</script>