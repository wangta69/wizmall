<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">

<html>
  <head>
    <title>주문페이지양식</title>

    <script language="javascript" type="text/javascript" src="https://api.bluepay.co.kr/ajax/common/OpenPayAPI.js"></script>

  </head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
  
  <script>
function startPayment() {
var _form = document.PGIOForm;
  doTransaction(document.PGIOForm);
}



function getPGIOresult() {

var replycode = getPGIOElement('replycode');
var replyMsg = getPGIOElement('replyMsg');

if (replycode == '0000') {
     // 거래성공 경우
displayStatus(getPGIOElement('ResultScreen'));

     document.PGIOForm.action = 'http://buyrf.co.kr/skinwiz/cardmodule/BANKWELL/return_new.php';
     document.PGIOForm.submit();
   } else {
     // 거래실패 경우
alert("결제가 실패하였습니다. 사유:"+replyMsg);
self.close();

	}
}
</script>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<body onload="startPayment();" >

   <form name="PGIOForm">
  <input name="mid" value="hsj7255" type="hidden">
  <?if($MsgTypeCode=="11"){?>
  <input name="paymethod" value="card"  type="hidden">
  <?}else{?>
  <input name="paymethod" value="card"  type="hidden">
  <?}?>
  <input name="paymethod" value="card"  type="hidden">
  <input name="goodname" value="<?=$BrandName?>"  type="hidden">
  <input name="unitprice"  value="<?=$Amount?>"  type="hidden">
  <input name="receipttoname" value="<?=$OrderName?>"  type=hidden>

  <input name="ShopCode" value="<?=$ShopCode?>"  type="hidden">
  <input name="OrderDate" value="<?=$OrderDate?>"  type="hidden">
  <input name="OrderTime" value="<?=$OrderTime?>"  type="hidden">
  <input name="SequenceNo" value="<?=$SequenceNo?>"  type="hidden">
  <input name="OrderNo" value="<?=$OrderNo?>"  type="hidden">
  <input name="MsgTypeCode" value="<?=$MsgTypeCode?>"  type="hidden">
  <input name="ReplyCode" value="0000"  type="hidden">
<input type="hidden" name="TRADE_CODE" value="<?=$_POST[TRADE_CODE];?>">


  <input name="cardquota" value=""  type="hidden">
  <input name="cardexpiremonth"  type="hidden">
  <input name="cardexpireyear"  type="hidden">
  <input name="cardsecretnumber" type="hidden">
  <input name="cardownernumber"  type="hidden">
 <input name="bankexpyear" value="2008"type="hidden">
<input name="bankexpmonth" value="10" type="hidden">
<input name="bankexpday" value="23" type="hidden">
 <input name="cardtype"  type="hidden">
  <input name="cardnumber"  type="hidden">
  <input name="cardauthcode"  type="hidden">
  <input name="socialnumber"  type="hidden">
  <input name="carrier" value=""  type="hidden">
  <input name="receipttotel"    value="<?=$rg_ext2  ?>" type="hidden">
  <input name="socialnumber"  type="hidden">
  <input name="rg_doc_num"   value="<?=$rg_doc_num?>" type="hidden">
  <input name="receipttoname"   value="<?=$rg_name?>" type="hidden">
  <input name="replycode" value=""  type="hidden"/>
  <input name="replyMsg" value=""  type="hidden"/>
  </form>
<div id="PGIOscreen" style="width:100%"></div>
</body>
</html>