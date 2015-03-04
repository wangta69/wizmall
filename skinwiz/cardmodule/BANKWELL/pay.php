<?php
header("Content-Type: text/html; charset=euc-kr"); 
//이부분은 연동으로 인해 euc-kr로 코딩 되어야 함
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
	$show_goods_name .= "외 ".$showcount."종";
}

$sqlstr = "select b.* from wizBuyers b
left join wizMembers m on b.MemberID = m.mid 
left join wizMembers_ind i on b.MemberID = i.id
where b.OrderID = '".$_COOKIE["CART_CODE"]."'";
//echo "sqlstr = $sqlstr <br>";
$dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array();

$ShopCode		= $cfg["pay"]["CARD_ID"];/* 테스트 상점 아이디 : 2999199998 */
//$storeid  = "2999199998"; test only
$OrderNo		= $cod; /* 주문번호 */
$OrderName		= $common->conv_euckr($list["SName"]); /* 주문자명 */
$BrandName		= $common->conv_euckr($show_goods_name); /* 상품명 */
$Amount			= $list["AmountPg"]; /* 결제금액 */
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
	echo "<script>alert('결제금액이 빠졌습니다.');</script>";
	exit;
	*/
}else if(!$OrderName){
	$OrderName = "None";
	/*
	echo "<script>alert('결제자명이 금액이 빠졌습니다.');</script>";
	exit;
	*/
}else if(!$BrandName){
	$BrandName = "None";
	/*
	echo "<script>alert('상품명이 빠졌습니다.');</script>";
	exit;
	*/
}else if(!$OrderTelNo){
	$OrderTelNo = "None";
	/*
	echo "<script>alert('전화번호가 빠졌습니다.');</script>";
	exit;
	*/
}else if(!$Email){
	$Email = "master@shop-wiz.com";
	/*
	echo "<script>alert('이메일이 빠졌습니다.');</script>";
	exit;
	*/
}else if(!$OrderAddr){
	$OrderAddr = "None";
	/*
	echo "<script>alert('주소가 빠졌습니다.');</script>";
	exit;
	*/
}
?>
<!--#######################################################-->
<!--# 					test.html						  #-->
<!--#######################################################-->
<!--# 													  #-->
<!--# PG사로 보낼 데이터를 POST방식으로 넘겨준다.		  #-->
<!--#													  #-->
<!--# 넘겨주는 DATA는 PG사 기본데이터와 사용자가 정의해서 #-->
<!--# 넘겨줄수 있다.									  #-->
<!--#													  #-->
<!--# [ 뱅크웰에서 제공하는 기본 구성요소 ] 			  #-->
<!--#		                                              #-->      
<!--# 1. OrderNo    : 주문일자(YYYYMMDD)                  #-->
<!--# 2. Amount     : 주문번호에 해당하는 거래금액        #-->
<!--# 3. OrderName  : 주문자성명                          #-->
<!--# 4. OrderTelNo : 주문자 TelNo                        #-->
<!--# 5. BrandName  : 상품명                              #-->
<!--# 6. OrderAddr  : 배송지주소                          #-->
<!--# 7. UserID     : User ID                             #-->
<!--# 8. Reserved1  : Filler(공백)                        #-->
<!--# 9. Reserved2  : Filler(공백)                        #-->
<!--# 10.RecognPage : 정상처리후 Opener Page Refresh URL  #-->
<!--# 11.ErrorPage  : 에러처리후 Opener Page Refresh URL  #--> 
<!--#													  #-->
<!--#######################################################-->

<script language="javascript">
/////////////////////날짜계산루틴 (손대지 마세요...^^)/////////////////////////////////////
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

var orderdate   = String(nowyear) + String(nowmonth) + String(nowday); //주문일
var ordertimeis = String(nowhour) + String(nowmin) + String(nowsec);   //주문시간
var ordernum    = orderdate + "_" +ordertimeis+randnum;				   //주문번호	
//////////////////////////////////////////////////////////////////////////////////////////

function goScript() {
	var doc = document.form1;
	//doc.action="https://pay.bankwell.co.kr/cgi-bin/CreditCard_kkk/PGRE301.cgi"; //수정하지 마세요
	doc.action="https://pay.bankwell.co.kr/cgi-bin/CreditCard/PGRE301.cgi"; //수정하지 마세요
	doc.action="./popup_bluepay.php"; //수정하지 마세요
	doc.method="post";	
	wizwindow(form1.action, form1.target, "toolbar=no, directories=no,menubar=no,scrollbars=no,resizable=yes,status=yes,location=no,copyhistory=yes,width=446,height=530");

	// 오프너의 페이지를 결재중이라고 표시.	
	//location.href="<?=$cfg["admin"]["MART_BASEDIR"]?>/skinwiz/cardmodule/<?=$cfg["pay"]["CARD_PACK"]?>/loading/loading.html";
	location.href="<?=$cfg["admin"]["MART_BASEDIR"]?>/skinwiz/cardmodule/<?=$cfg["pay"]["CARD_PACK"]?>/loading/loading.html";

	//doc.action="https://pay.bankwell.co.kr/cgi-bin/CreditCard/PGRE301.cgi"; //수정하지 마세요
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
		alert('팝업창이 차단되어 있습니다.\n\n해제해 주세요');	
	}
}
</script>


<form name="form1" target="popup">
<input type="hidden" name="order_name" value="<? echo $deliverName; ?>"><!-- 주문자명 -->
<input type="hidden" name="order_bname" value="<? echo $BrandName; ?>"><!-- 상품명 -->
<input type="hidden" name="order_amount" value="<? echo $Amount; ?>"><!-- 금액 -->
<input type="hidden" name="order_email" value="<? echo $Email; ?>"><!-- 주문자 Email -->
<input type="hidden" name="order_tel" value="<? echo $OrderTelNo; ?>"><!-- 주문자 전화 -->
<input type="hidden" name="order_hp" value="<? echo $order_hp; ?>"><!-- 주문자 핸드폰 -->
<input type="hidden" name="rev_name" value="<? echo $deliverName; ?>"><!-- 수취인 명 -->
<input type="hidden" name="rev_email" value="<? echo $rev_email; ?>"><!-- 수취인 Email -->
<input type="hidden" name="rev_tel" value="<? echo $OrderTelNo; ?>"><!-- 수취인 전화 -->
<input type="hidden" name="rev_hp" value="<? echo $rev_hp; ?>"><!-- 수취인 핸드폰 -->
<input type="hidden" name="zip1" value="<? echo $zip1; ?>"><!-- 배소지 zip1 -->
<input type="hidden" name="zip2" value="<? echo $zip2; ?>"><!-- 배소지 zip2 -->
<input type="hidden" name="addr" value="<? echo $OrderAddr; ?>"><!-- 배송지 주소 -->
<input type="hidden" name="order_no" value="<? echo $OrderNo; ?>">
<input type="hidden" name="message" value="<? echo $message; ?>"><!-- 메세지 -->
<input type="hidden" name="MsgTypeCode" value="<?=$MsgTypeCode?>"><!-- 11 : 신용카드 , 30: 휴대폰, 31:ARS, 32:폰빌, 33:계좌이체 -->




<!-- 아래는 결제를 위해서 필요한 input 태그입니다. 위에 데이터를 적절히 가져와 내용을 채워주세요 -->

<input type="hidden" name="ShopCode" value="<? echo $ShopCode; ?>"> 		<!-- 뱅크웰로 부터 받은 ShopCode를 입력하세요 -->
<input type="hidden" name="OrderDate"> 				<!-- 이곳의 value는 위의 자바스크립트에서 처리하니 손대지 마세요 그대로 사용하면됨 -->
<input type="hidden" name="OrderTime"> 				<!-- 이곳의 value는 위의 자바스크립트에서 처리하니 손대지 마세요 그대로 사용하면됨 -->
<input type="hidden" name="SequenceNo">				<!-- 이곳의 value는 위의 자바스크립트에서 처리하니 손대지 마세요 그대로 사용하면됨 -->
<input type="hidden" name="OrderNo">  				<!-- 이곳의 value는 위의 자바스크립트에서 처리하니 손대지 마세요 그대로 사용하면됨-->


<input type="hidden" name="Amount"     value="<? echo $Amount; ?>">												<!-- 금액(필수) -->
<input type="hidden" name="OrderName"  value="<? echo $OrderName; ?>">												<!-- 주문자명 -->
<input type="hidden" name="BrandName"  value="<? echo $BrandName; ?>">												<!-- 상품명(필수) -->
<input type="hidden" name="OrderTelNo" value="<? echo $OrderTelNo; ?>">												<!-- 주문자전화번호 -->
<input type="hidden" name="Email"      value="<? echo $Email; ?>">												<!-- 주문자이메일   -->
<input type="hidden" name="OrderAddr"  value="<? echo $OrderAddr; ?>">												<!-- 주문자주소 -->
<input type="hidden" name="RecognPage" value="<?=$cfg["admin"]["MART_BASEDIR"]?>/skinwiz/cardmodule/<?=$cfg["pay"]["CARD_PACK"]?>/result.php">  	<!-- 결제 성공후 이동될 페이지 정의(필수) -->
<input type="hidden" name="ErrorPage"  value="<?=$cfg["admin"]["MART_BASEDIR"]?>/skinwiz/cardmodule/<?=$cfg["pay"]["CARD_PACK"]?>/result.php"> 	<!-- 결제 실패후 이동될 페이지 정의(필수) -->
</form>
<script language="JavaScript">
<!--
f = document.form1;
goScript();
//-->
</script>