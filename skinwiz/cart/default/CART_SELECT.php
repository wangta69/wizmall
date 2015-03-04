<?php
/* 

제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/

if($cfg["member"]){
	unset($Mpoint);
	$sqlstr = "select Point from wizMembers where ID = '".$cfg["member"]."'";
	$MPoint = $dbcon->get_one($sqlstr);
}
?>
<script>
function check_radio(){
var f = document.select_form;
var tmp;
//var length = f.check.length
	for(i=0; i< f.check.length; i++){ 
		if(f.check[i].checked) tmp = "truevalue";
		}
		
		if(tmp != "truevalue"){ 
		alert('결제방법을 선택해 주세요'); 
		f.check[0].focus(); 
		return false;
		}

}
</script>
<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active">주문서 작성</li>
</ul>

<img src="./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"];?>/images/title_orderinfo.gif" width="581" height="78"> <br />
<img src="./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"];?>/images/point_cart_01.gif" height="11">고객님께서 

                        선택하신 상품내역입니다.
<?php
// 장바구니 보기
include "./skinwiz/cart/".$cfg["skin"]["CartSkin"]."/CART_VIEW.php";
?>
<br />
<img src="./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"];?>/images/title_orderinfo01.gif" width="105">
<form action="./wizbag.php?query=step3" method="post" onSubmit="return check_radio()" name="select_form">
	<table >
		<tr>
			<td colspan="3"></td>
		</tr>
		<tr>
			<td><img src="./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"];?>/images/point_list_01.gif" width="21" height="9">결재방법</td>
			<td><img src="./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"];?>/images/img_a.gif"></td>
			<td><table >
					<!-- 무통장 입금 시작 ----------->
					<tr>
						<td><input name="check" type="radio" value="online"></td>
						<td>무통장 입금 </td>
					</tr>
					<!-- 무통장 입금 끝 -------------->
					<!-- 신용카드 시작 --------------->
					<?php 
					   if(!strcmp($cfg["pay"]["CARD_ENABLE"], "checked")):
					       if($cfg["pay"]["CARD_ENABLE_MONEY"] <= $TOTAL_MONEY) :?>
					<tr>
						<td><input name="check" type="radio" value="card"></td>
						<td>신용카드 </td>
					</tr>
					<?php else :?>
					<tr>
						<td><input name="check" type="radio" value="" onclick="javascript:window.alert('신용카드구매는 구매액이 <?ECHO number_format($cfg["pay"]["CARD_ENABLE_MONEY"]);?>원 이상만 가능합니다.'); this.checked = false; document.PaySelectForm.check[0].checked = true; document.PaySelectForm.check[0].focus()"></td>
						<td>신용카드 </td>
					</tr>
					<? endif; endif;?>
					<!-- 신용카드 끝 ----------------->
					<!-- 핸드폰 결재 시작 --------------->
					<?php 
					if(!strcmp($cfg["pay"]["PHONE_ENABLE"], "checked")):
					   if($PHONE_ENABLE_MONEY <= $TOTAL_MONEY) :?>
					<tr>
						<td><input name="check" type="radio" value="hand"></td>
						<td>핸드폰 결제 </td>
					</tr>
					<?php else :?>
					<tr>
						<td><input name="check" type="radio" value="" onclick="javascript:window.alert('핸드폰결제는 구매액이 <?ECHO number_format($PHONE_ENABLE_MONEY);?>원 이상만 가능합니다.'); this.checked = false; document.PaySelectForm.check[0].checked = true; document.PaySelectForm.check[0].focus()"></td>
						<td>핸드폰 결제 </td>
					</tr>
					<?php endif; endif;?>
					<!-- 핸드폰 결재 끝 ----------------->
					<!-- 실시간 계좌이체 시작 --------------->
					<?php if(!strcmp($cfg["pay"]["AUTOBANKING_ENABLE"], "checked")):?>
					<tr>
						<td><input name="check" type="radio" value="autobank"></td>
						<td>실시간 계좌 이체 </td>
					</tr>
					<?php endif;?>
					<!-- 실시간 계좌이체 끝 ----------------->
					<!-- 포인트 구매 시작 ------------>
					<?php
					 if(!strcmp($cfg["pay"]["POINT_ENABLE"], "checked")):
					   if($cfg["member"]) :
					                if($cfg["pay"]["POINT_ENABLE_MONEY"] <= $MPoint) :
					                       if($TOTAL_MONEY > $MPoint) :?>
					<tr>
						<td><input name="check" type="radio" value="" onclick="javascript:window.alert('고객님의 사용가능한 보유포인트가 제품구매액보다 적습니다.'); this.checked = false; document.PaySelectForm.check[0].checked = true; document.PaySelectForm.check[0].focus()";></td>
						<td> 포인트구매</td>
					</tr>
					<?php else:?>
					<tr>
						<td><input name="check" type="radio" value="point"></td>
						<td> 포인트구매</td>
					</tr>
					<?php endif; ?>
					<?php else:?>
					<tr>
						<td><input name="check" type="radio" value="" onclick="javascript:window.alert('포인트구매는 포인트가 <?ECHO number_format($cfg["pay"]["POINT_ENABLE_MONEY"]);?>포인트 이상만 가능합니다.'); this.checked = false; document.PaySelectForm.check[0].checked = true; document.PaySelectForm.check[0].focus();"></td>
						<td> 포인트구매</td>
					</tr>
					<?php endif; ?>
					<?php else:?>
					<tr>
						<td><input name="check" type="radio" value="" onclick="javascript:window.alert('비회원은 포인트 구매를 하실 수 없습니다.'); this.checked = false; document.PaySelectForm.check[0].checked = true; document.PaySelectForm.check[0].focus();"></td>
						<td> 포인트구매</td>
					</tr>
					<?php endif; endif;?>
					<!-- 포인트 구내 끝  ---------------->
					<!-- 다중구내 끝  ---------------->
					<?php if(!strcmp($COMPO_ENABLE, "checked")):?>
					<?php if($cfg["pay"]["POINT_ENABLE_MONEY"] > $MPoint && $TOTAL_MONEY < $cfg["pay"]["CARD_ENABLE_MONEY"]) :?>
					<tr>
						<td><input name="check" type="radio" value=""  onclick="javascript:window.alert('\n\n고객님의 사용가능 보유포인트가 포인트구매 최소액보다 적고 \n\n제품구매액이 신용카드구매 최소금액보다 적어 \n\n복합구매를 하실 수 없습니다.\n\n'); this.checked = false; document.PaySelectForm.check[0].checked = true; document.PaySelectForm.check[0].focus();"></td>
						<td> 다중구매 </td>
					</tr>
					<?php else:?>
					<tr>
						<td><input name="check" type="radio" value="all"></td>
						<td> 다중구매 </td>
					</tr>
					<?php endif; endif;?>
					<!-- 다중 구매 끝  --------------->
				</table></td>
		</tr>
	</table>
<div class="space15"></div>
	<div class="btn_box"><img src="./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"];?>/images/but_re.gif" width="77" onclick="javascript:history.go(-1);" style="cursor:pointer">
	<input name="image" type="image" src="./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"];?>/images/but_next.gif" width="68"></div>
</form>
