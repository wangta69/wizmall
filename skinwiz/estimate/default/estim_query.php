<?php
include "../../../lib/inc.depth3.php";


if ($cfg["member"]) {
	$dbcon->_query("SELECT * FROM wizMembers WHERE ID='".$_COOKIE["MEMBER_ID"]."'");
	$list = $dbcon->_fetch_array();
}
$Re_Date = time();

if (is_file("../../../mall_buyers/".$_COOKIE["CART_CODE_ESTIM"].".php")) {
        $Co_Name_Array = file("../../../mall_buyers/".$_COOKIE["CART_CODE_ESTIM"].".php");
        for ($i = 0; $i < sizeof($Co_Name_Array); $i++) {
                $Co_Name = "$Co_Name".chop($Co_Name_Array[$i])."\n";
        }
}

if (is_file("../../../member/login_user/$_COOKIE[CART_CODE_ESTIM].php") && $_COOKIE["CART_CODE_ESTIM"]) {
        $Co_Memberid = $_COOKIE["CART_CODE_ESTIM"];
}


	$Buy_Date = date("Y.m.d H:i");
	
	$ins["Sender_Name"]	= $list["Name"];
	$ins["Sender_Email"]	= $list["Email"];
	$ins["Sender_Tel"]	= $list["Tel1"];
	$ins["Sender_Pcs"]	= $list["Tel2"];
	$ins["Re_Name"]	= $userName1;
	$ins["Re_Tel"]	= $UserTel3;
	$ins["Zip"]	= $list["Zip1"];
	$ins["Address"]	= $list["Address1"]." ".$list["Address2"];
	$ins["Re_Date"]	= $Re_Date;
	$ins["Message"]	= $COMMENT;
	$ins["How_Buy"]	= $check;
	$ins["How_Bank"]	= $BANK;
	$ins["Point_Money"]	= $point_check;
	$ins["Ziro_Money"]	= $ziro_check;
	$ins["Card_Money"]	= $card_check;
	$ins["Total_money"]	= $TOTAL_MONEY;
	//$ins["Co_Del"]	= '';
	$ins["CODE_VALUE"]	= $_COOKIE[CART_CODE_ESTIM];
	$ins["Co_Now"]	= "A";
	$ins["Co_Memberid"]	= $Co_Memberid;
	$ins["Co_Name"]	= $Co_Name;
	$ins["Buy_Date"]	= $Buy_Date;

	$dbcon->insertData("wizEstim", $ins);
?>
<html>
<script>
window.alert('성공적으로 접수되었습니다');
</script>
<meta http-equiv="refresh" content ="0;url=../../../wizcalcu.php?query=trash">
</html>