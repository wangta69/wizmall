<?php
header("Content-Type: text/html; charset=euc-kr"); 
//�̺κ��� �������� ���� euc-kr�� �ڵ� �Ǿ�� ��
include "../../../config/db_info.php";
include "../../../config/cfg.core.php";
include "../../../lib/class.database.php";
include "../../../lib/class.common.php";

$dbcon	= new database($cfg["sql"]);
$common = new common();
$common->cfg=$cfg;
//$oid	= $_GET["OrderID"];



$sqlstr = "select m.Name from wizCart c 
left join wizMall m on c.pid = m.UID 
where c.oid = ".$_COOKIE["CART_CODE"];

$sqlqry = $dbcon->_query($sqlstr);

$cnt=0;
while($list = $dbcon->_fetch_array($sqlqry)):
	$goods_name[$cnt] = $common->conv_euckr($list["Name"]);
	$cnt++;
endwhile;
//echo $sqlstr;
$show_goods_name = $goods_name[0];
if (count($goods_name) > 1){
	$showcount = count($goods_name) - 1;
	$show_goods_name .= "�� ".$showcount."��";
}

$sqlstr = "select b.* from wizBuyers b
left join wizMembers m on b.MemberID = m.mid 
left join wizMembers_ind i on b.MemberID = i.id
where b.OrderID = '".$_COOKIE["CART_CODE"]."'";
//echo "sqlstr = $sqlstr <br>";
$dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array();

$ShopCode		= $cfg["pay"]["CARD_ID"];/* �׽�Ʈ ���� ���̵� : 2999199998 */
//$storeid  = "2999199998"; test only
$OrderNo		= $cod; /* �ֹ���ȣ */
$OrderName		= $common->conv_euckr($list["SName"]); /* �ֹ��ڸ� */
$BrandName		= $common->conv_euckr($show_goods_name); /* ��ǰ�� */
$Amount			= $list["AmountPg"]; /* �����ݾ� */
$OrderTelNo		= $list["STel1"];
$rev_hp			= $list["STel2"];
$Email			= $list["SEmail"];
$deliverName	= $common->conv_euckr($list["RName"]);
$zip			= explode("-", $list["RZip"]);
$zip1			= $zip[0];
$zip2			= $zip[1];
$OrderAddr		= $common->conv_euckr($list["RAddress1"])." ".$common->conv_euckr($list["RAddress2"]);
//$OrderAddr		= $common->conv_euckr("(".$list["RZip"].") ".$list["RAddress1"]." ".$list["RAddress2"]);


switch($check){
	case "card":
		$MsgTypeCode = "11";
	break;
	case "hand":
		$MsgTypeCode = "30";
	break;	
	default:
		$MsgTypeCode = "11";
	break;
}

if(!$Amount){
	/*
	echo "<script>alert('�����ݾ��� �������ϴ�.');</script>";
	exit;
	*/
}else if(!$OrderName){
	$OrderName = "None";
	/*
	echo "<script>alert('�����ڸ��� �ݾ��� �������ϴ�.');</script>";
	exit;
	*/
}else if(!$BrandName){
	$BrandName = "None";
	/*
	echo "<script>alert('��ǰ���� �������ϴ�.');</script>";
	exit;
	*/
}else if(!$OrderTelNo){
	$OrderTelNo = "None";
	/*
	echo "<script>alert('��ȭ��ȣ�� �������ϴ�.');</script>";
	exit;
	*/
}else if(!$Email){
	$Email = "master@shop-wiz.com";
	/*
	echo "<script>alert('�̸����� �������ϴ�.');</script>";
	exit;
	*/
}else if(!$OrderAddr){
	$OrderAddr = "None";
	/*
	echo "<script>alert('�ּҰ� �������ϴ�.');</script>";
	exit;
	*/
}
?>
<!--#######################################################-->
<!--# 					test.html						  #-->
<!--#######################################################-->
<!--# 													  #-->
<!--# PG��� ���� �����͸� POST������� �Ѱ��ش�.		  #-->
<!--#													  #-->
<!--# �Ѱ��ִ� DATA�� PG�� �⺻�����Ϳ� ����ڰ� �����ؼ� #-->
<!--# �Ѱ��ټ� �ִ�.									  #-->
<!--#													  #-->
<!--# [ ��ũ������ �����ϴ� �⺻ ������� ] 			  #-->
<!--#		                                              #-->      
<!--# 1. OrderNo    : �ֹ�����(YYYYMMDD)                  #-->
<!--# 2. Amount     : �ֹ���ȣ�� �ش��ϴ� �ŷ��ݾ�        #-->
<!--# 3. OrderName  : �ֹ��ڼ���                          #-->
<!--# 4. OrderTelNo : �ֹ��� TelNo                        #-->
<!--# 5. BrandName  : ��ǰ��                              #-->
<!--# 6. OrderAddr  : ������ּ�                          #-->
<!--# 7. UserID     : User ID                             #-->
<!--# 8. Reserved1  : Filler(����)                        #-->
<!--# 9. Reserved2  : Filler(����)                        #-->
<!--# 10.RecognPage : ����ó���� Opener Page Refresh URL  #-->
<!--# 11.ErrorPage  : ����ó���� Opener Page Refresh URL  #--> 
<!--#													  #-->
<!--#######################################################-->

<script language="javascript">
/////////////////////��¥����ƾ (�մ��� ������...^^)/////////////////////////////////////
var now = new Date();
var nowyear  = now.getFullYear();
var nowmonth = now.getMonth() + 1;
var nowday   = now.getDate();
var nowhour  = now.getHours();
var nowmin   = now.getMinutes();
var nowsec   = now.getSeconds();
var randnum  = Math.floor(Math.random()*10);

if (("" + nowmonth).length == 1) { nowmonth = "0" + nowmonth; }
if (("" + nowday).length   == 1) { nowday   = "0" + nowday;   }
if (("" + nowhour).length  == 1) { nowhour  = "0" + nowhour;  }
if (("" + nowmin).length   == 1) { nowmin   = "0" + nowmin;   }
if (("" + nowsec).length   == 1) { nowsec   = "0" + nowsec;   }

var orderdate   = String(nowyear) + String(nowmonth) + String(nowday); //�ֹ���
var ordertimeis = String(nowhour) + String(nowmin) + String(nowsec);   //�ֹ��ð�
var ordernum    = orderdate + "_" +ordertimeis+randnum;				   //�ֹ���ȣ	
//////////////////////////////////////////////////////////////////////////////////////////

function goScript() {
	var doc = document.form1;
	//doc.action="https://pay.bankwell.co.kr/cgi-bin/CreditCard_kkk/PGRE301.cgi"; //�������� ������
	doc.action="https://pay.bankwell.co.kr/cgi-bin/CreditCard/PGRE301.cgi"; //�������� ������
	doc.action="./popup_bluepay.php"; //�������� ������
	doc.method="post";	
	wizwindow(form1.action, form1.target, "toolbar=no, directories=no,menubar=no,scrollbars=no,resizable=yes,status=yes,location=no,copyhistory=yes,width=446,height=530");

	// �������� �������� �������̶�� ǥ��.	
	//location.href="<?=$cfg["admin"]["MART_BASEDIR"]?>/skinwiz/cardmodule/<?=$cfg["pay"]["CARD_PACK"]?>/loading/loading.html";
	location.href="<?=$cfg["admin"]["MART_BASEDIR"]?>/skinwiz/cardmodule/<?=$cfg["pay"]["CARD_PACK"]?>/loading/loading.html";

	//doc.action="https://pay.bankwell.co.kr/cgi-bin/CreditCard/PGRE301.cgi"; //�������� ������
	doc.OrderDate.value  = orderdate;
	doc.OrderTime.value  = ordertimeis;
	doc.SequenceNo.value = ordertimeis;
	doc.OrderNo.value    = ordernum;
	doc.submit();
}


function wizwindow(url,name,flag){
	var newwin = window.open(url,name,flag);
	if(newwin){
		newwin.focus();
	}else{
		alert('�˾�â�� ���ܵǾ� �ֽ��ϴ�.\n\n������ �ּ���');	
	}
}
</script>


<form name="form1" target="popup">
<input type="hidden" name="order_name" value="<? echo $deliverName; ?>"><!-- �ֹ��ڸ� -->
<input type="hidden" name="order_bname" value="<? echo $BrandName; ?>"><!-- ��ǰ�� -->
<input type="hidden" name="order_amount" value="<? echo $Amount; ?>"><!-- �ݾ� -->
<input type="hidden" name="order_email" value="<? echo $Email; ?>"><!-- �ֹ��� Email -->
<input type="hidden" name="order_tel" value="<? echo $OrderTelNo; ?>"><!-- �ֹ��� ��ȭ -->
<input type="hidden" name="order_hp" value="<? echo $order_hp; ?>"><!-- �ֹ��� �ڵ��� -->
<input type="hidden" name="rev_name" value="<? echo $deliverName; ?>"><!-- ������ �� -->
<input type="hidden" name="rev_email" value="<? echo $rev_email; ?>"><!-- ������ Email -->
<input type="hidden" name="rev_tel" value="<? echo $OrderTelNo; ?>"><!-- ������ ��ȭ -->
<input type="hidden" name="rev_hp" value="<? echo $rev_hp; ?>"><!-- ������ �ڵ��� -->
<input type="hidden" name="zip1" value="<? echo $zip1; ?>"><!-- ����� zip1 -->
<input type="hidden" name="zip2" value="<? echo $zip2; ?>"><!-- ����� zip2 -->
<input type="hidden" name="addr" value="<? echo $OrderAddr; ?>"><!-- ����� �ּ� -->
<input type="hidden" name="order_no" value="<? echo $OrderNo; ?>">
<input type="hidden" name="message" value="<? echo $message; ?>"><!-- �޼��� -->
<input type="hidden" name="MsgTypeCode" value="<?=$MsgTypeCode?>"><!-- 11 : �ſ�ī�� , 30: �޴���, 31:ARS, 32:����, 33:������ü -->




<!-- �Ʒ��� ������ ���ؼ� �ʿ��� input �±��Դϴ�. ���� �����͸� ������ ������ ������ ä���ּ��� -->

<input type="hidden" name="ShopCode" value="<? echo $ShopCode; ?>"> 		<!-- ��ũ���� ���� ���� ShopCode�� �Է��ϼ��� -->
<input type="hidden" name="OrderDate"> 				<!-- �̰��� value�� ���� �ڹٽ�ũ��Ʈ���� ó���ϴ� �մ��� ������ �״�� ����ϸ�� -->
<input type="hidden" name="OrderTime"> 				<!-- �̰��� value�� ���� �ڹٽ�ũ��Ʈ���� ó���ϴ� �մ��� ������ �״�� ����ϸ�� -->
<input type="hidden" name="SequenceNo">				<!-- �̰��� value�� ���� �ڹٽ�ũ��Ʈ���� ó���ϴ� �մ��� ������ �״�� ����ϸ�� -->
<input type="hidden" name="OrderNo">  				<!-- �̰��� value�� ���� �ڹٽ�ũ��Ʈ���� ó���ϴ� �մ��� ������ �״�� ����ϸ��-->


<input type="hidden" name="Amount"     value="<? echo $Amount; ?>">												<!-- �ݾ�(�ʼ�) -->
<input type="hidden" name="OrderName"  value="<? echo $OrderName; ?>">												<!-- �ֹ��ڸ� -->
<input type="hidden" name="BrandName"  value="<? echo $BrandName; ?>">												<!-- ��ǰ��(�ʼ�) -->
<input type="hidden" name="OrderTelNo" value="<? echo $OrderTelNo; ?>">												<!-- �ֹ�����ȭ��ȣ -->
<input type="hidden" name="Email"      value="<? echo $Email; ?>">												<!-- �ֹ����̸���   -->
<input type="hidden" name="OrderAddr"  value="<? echo $OrderAddr; ?>">												<!-- �ֹ����ּ� -->
<input type="hidden" name="RecognPage" value="<?=$cfg["admin"]["MART_BASEDIR"]?>/skinwiz/cardmodule/<?=$cfg["pay"]["CARD_PACK"]?>/result.php">  	<!-- ���� ������ �̵��� ������ ����(�ʼ�) -->
<input type="hidden" name="ErrorPage"  value="<?=$cfg["admin"]["MART_BASEDIR"]?>/skinwiz/cardmodule/<?=$cfg["pay"]["CARD_PACK"]?>/result.php"> 	<!-- ���� ������ �̵��� ������ ����(�ʼ�) -->
</form>
<script language="JavaScript">
<!--
f = document.form1;
goScript();
//-->
</script>