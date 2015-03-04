<?php
/*
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*/
include "../common/header_pop.php";

include ("../../lib/class.cart.php");
$cart = new cart;
$cart->get_object($dbcon,$common);

$theme = "order/order5";

if($query == "save"){// 장바구니담기
	$CART_CODE = $cart->mkcartcode();##장바구니 코드가 없을 경우 - 장바구니 코드 생성
	$cart->wizCartExe($CART_CODE,$no,$BUYNUM,$optionfield);
	ECHO "<script >top.location.reload();location.replace('./order5_2.php');</script>";
	exit;
}else if ( $query == 'qde') { // 장바구니 택일삭제
	$sqlstr = "delete from wizCart where uid = $cuid";
	$dbcon->_query($sqlstr);
	ECHO "<html><META http-equiv='refresh' content='0;url=../main.php?menushow=$menushow&theme=$theme&order_id=$order_id'></html>";
	exit;
}else if ( $query == 'update_qty') { // 장바구니 택일수정
	$cart->changeCartqty($cuid, $BUYNUM);
        ECHO "<html><META http-equiv='refresh' content='0;url=../main.php?menushow=$menushow&theme=$theme&order_id=$order_id'></html>";
        exit;
}
if ( $query == 'trash') { // 장바구니 비우기
	$sqlstr = "delete from wizCart where oid = '".$CART_CODE."'";
	$dbcon->_query($sqlstr);
	setcookie("CART_CODE","",0,"/");
	ECHO "<html><META http-equiv='refresh' content='0;url=../main.php?menushow=$menushow&theme=$theme&order_id=$order_id'></html>";
	exit;

}
if($query == "order"){  //주문함

	$OrderID = $CART_CODE; // 장바구니고유코드
	$MemberID = $order_id;
	$Message = addslashes($Message);
	$RAddress1 = addslashes($RAddress1);
	$RAddress2 = addslashes($RAddress2);
	$STel1 = $STel1_1."-".$STel1_2."-".$STel1_3;
	$STel2 = $STel2_1."-".$STel2_2."-".$STel2_3;
	$SZip = $SZip1."-".$SZip2;
	$RTel1 = $RTel1_1."-".$RTel1_2."-".$RTel1_3;
	$RTel2 = $RTel2_1."-".$RTel2_2."-".$RTel2_3;
	$RZip = $RZip1."-".$RZip2;
	
	$PayDate = mktime($OHour,0,0,$OMonth,$ODay,$OYear);
	$BuyDate = time();

	
	$QUERY1 = "INSERT INTO wizBuyers (
	SName,RCompany,SEmail,STel1,STel2,SZip,SAddress1,SAddress2,RName,RTel1,RTel2,RZip,
	RAddress1,RAddress2,ExpectDate,Message,PayMethod,BankInfo,Inputer,AmountPoint,AmountOline,
	AmountPg,TotalAmount,OrderID,OrderStatus,MemberID,PayDate,BuyDate)
	VALUES(
	'$SName','$RCompany','$SEmail','$STel1','$STel2','$SZip','$SAddress1','$SAddress2','$RName','$RTel1','$RTel2','$RZip',
	'$RAddress1','$RAddress2','$Year.$Month.$Day','$Message','$paytype','$BankInfo','$Inputer','$pointamount','$olineamount',
	'$pgamount','$TOTAL_MONEY','$OrderID','10','$MemberID','$PayDate','$BuyDate')";


//echo $QUERY1."<br />";
	$QUERY1_RESULT = $dbcon->_query($QUERY1);
	$sqlstr = "update wizCart set ostatus = '10' where  oid = '$OrderID'";
	$dbcon->_query($sqlstr);
	setcookie("CART_CODE", "", 0, "/"); //현재 장바구니를 비운다.
	
	
echo "<script >window.alert('성공적으로 주문되었습니다.');location.replace('../main.php?menushow=$menushow&theme=$theme&order_id=$order_id');</script>";	
	
}
/* 아무런 옵션 값이 없을 경우 */
echo "<script >location.replace('order5_2.php?menushow=$menushow&theme=$theme&big_cat=$big_cat&mid_cat=$mid_cat&small_cat=$small_cat&no=$no&order_id=$order_id');</script>";

?>