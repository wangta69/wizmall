<?php
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
/* 결제방법당 각각의 필드에 정보를 입력한다.*/

$mid = $cfg["member"]["mid"];

$total_check = str_replace("," , "" , $total_check);
if ($paytype == 'online' || !$paytype){
	$olineamount = $total_check;
}else if ($paytype == 'all') {
	if ($olineamount) $olineamount = str_replace("," , "" , $olineamount);
	if ($pointamount) $pointamount = str_replace("," , "" , $pointamount);
	if ($pgamount) $pgamount = str_replace("," , "" , $pgamount);
	if ($olineamount + $pointamount + $pgamount != $total_check) {
		echo "
		<script>
		window.alert('\n\n다중구매로 선택하셨으나, 합산금액이 일치하지 않습니다.    \n다시한번 확인하여 주세요..\n\n온라인입금 : ".number_format($olineamount)."원\n신용카드결제 : ".number_format($pgamount)."원\n포인트사용 : ".number_format($pointamount)."원\n-----------------------------------\n다중구매합계 : ".number_format($olineamount + $pointamount + $pgamount)."원\n실제품구매액 : ".number_format($total_check)."원\n\n');
		history.go(-1);
		</script>
		";
		exit;
	}
}else{#기타 결제는 PG사창에서 처리하므로 일괄적으로 넣는다.
	$pgamount = $total_check;
}

//현재 동일 데이타가 있는지 책크
$sqlstr = "select count(UID) from wizBuyers where OrderID = '".$CART_CODE."'";
$result = $dbcon->get_one($sqlstr);

$OrderID	= $CART_CODE; // 장바구니고유코드
$MemberID	= $mid;
$Message	= addslashes($Message);
$RAddress1	= addslashes($RAddress1);
$RAddress2	= addslashes($RAddress2);
$STel1		= $STel1_1."-".$STel1_2."-".$STel1_3;
$STel2		= $STel2_1."-".$STel2_2."-".$STel2_3;
$SZip		= $SZip1."-".$SZip2;
$SEmail		= $SEmail_1."@".$$SEmail_2;	
$RTel1		= $RTel1_1."-".$RTel1_2."-".$RTel1_3;
$RTel2		= $RTel2_1."-".$RTel2_2."-".$RTel2_3;
$RZip		= $RZip1."-".$RZip2;

$PayDate = mktime($OHour,0,0,$OMonth,$ODay,$OYear);
$BuyDate = time();
//ExpressDeliverFee='$ExpressDeliverFee'
if(!$result){  /*OrderID값이 없으면 처음 입력되는 것이고 OrderID값이 있으면 수정모드이다 */
	
	unset($ins);
    $ins["SName"]    = $SName;
    //$ins["RCompany"]    = $RCompany;
    $ins["SEmail"]    = $SEmail;
    $ins["STel1"]    = $STel1;
    $ins["STel2"]    = $STel2;
    $ins["SZip"]    = $SZip;
    $ins["SAddress1"]    = $SAddress1;
    $ins["SAddress2"]    = $SAddress2;
    $ins["RName"]    = $RName;
    $ins["RTel1"]    = $RTel1;
    $ins["RTel2"]    = $RTel2;
    $ins["RZip"]    = $RZip;
    $ins["RAddress1"]    = $RAddress1;
    $ins["RAddress2"]    = $RAddress2;
    $ins["ExpectDate"]    = $Year.$Month.$Day;
    $ins["Message"]    = $Message;
    $ins["PayMethod"]    = $paytype;
    $ins["BankInfo"]    = $BankInfo;
    $ins["Inputer"]    = $Inputer;
    $ins["AmountPoint"]    = $pointamount;
    $ins["AmountOline"]    = $olineamount;
    $ins["AmountPg"]    = $pgamount;
    $ins["TotalAmount"]    = $total_check;
    $ins["OrderID"]    = $OrderID;
    $ins["OrderStatus"]    = 10;
    $ins["MemberID"]    = $MemberID;
    $ins["PayDate"]    = $PayDate;
    $ins["BuyDate"]    = $BuyDate;
    //구매 고객정보 입력
    $dbcon->insertData("wizBuyers", $ins);
    
    unset($ups);
    $ups["ostatus"]    = 10;
    //상품 배송상태 변경
    $dbcon->updateData("wizCart", $ups, "oid = '".$OrderID."'");

}else{
    
    unset($ups);
    $ups["SName"]    = $SName;
    //$ups["RCompany"]    = $RCompany;
    $ups["SEmail"]    = $SEmail;
    $ups["STel1"]    = $STel1;
    $ups["STel2"]    = $STel2;
    $ups["SZip"]    = $SZip;
    $ups["SAddress1"]    = $SAddress1;
    $ups["SAddress2"]    = $SAddress2;
    $ups["RName"]    = $RName;
    $ups["RTel1"]    = $RTel1;
    $ups["RTel2"]    = $RTel2;
    $ups["RZip"]    = $RZip;
    $ups["RAddress1"]    = $RAddress1;
    $ups["RAddress2"]    = $RAddress2;
    $ups["ExpectDate"]    = $Year.$Month.$Day;
    $ups["Message"]    = $Message;
    $ups["PayMethod"]    = $paytype;
    $ups["BankInfo"]    = $BankInfo;
    $ups["Inputer"]    = $Inputer;
    $ups["AmountPoint"]    = $pointamount;
    $ups["AmountOline"]    = $olineamount;
    $ups["AmountPg"]    = $pgamount;
    $ups["TotalAmount"]    = $total_check;
    $ups["OrderID"]    = $OrderID;
    $ups["OrderStatus"]    = 10;
    $ups["MemberID"]    = $MemberID;
    $ups["PayDate"]    = $PayDate;
    $ups["BuyDate"]    = $BuyDate;
    $dbcon->updateData("wizBuyers", $ups, "OrderID='".$OrderID."'" );
}
?>
<iframe frameborder="O" scrolling="no" id="PayIFrame"  src="./blank.php" width="500"  style="display:none"> </iframe>
<?php
$goods_name = strip_tags($goods_name);
/******* 결제페이지이동 *****************************************************************/
if ($paytype == 'online' || !$paytype): 
    echo "<script>location.href='".$PHP_SELF."?query=step4&paytype=".$paytype."&OrderID=".$OrderID."&op=".$op."';</script>";
    exit;
else :
    echo "<script>PayIFrame.location=\"./skinwiz/cardmodule/".$cfg["pay"]["CARD_PACK"]."/pay.php?OrderID=".$OrderID."&paytype=".$paytype."&op=".$op."\";</script>";
endif;
?>
<div class="navy">Home &gt; 결제진행중</div>	
<img src="./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"];?>/images/pay_img.gif" width="591" height="311" usemap="#PayProcessing" />
<map name="PayProcessing">
              <area shape="rect" coords="127,212,242,235" href="javascript:location.reload();">
              <area shape="rect" coords="254,212,414,235" href="/wizbag.php?query=step3">
</map>