<?php
/* 

제작자 : 폰돌
스킨 : wizboard list skin 
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
$cfg["pay"]["DIFF_CARD_VALUE"] = $cfg["pay"]["DIFF_CARD_VALUE"] ? $cfg["pay"]["DIFF_CARD_VALUE"]:0;
?>
<!-- 장바구니 보기 -->
<script>
function num_cal(v, flag){
	var num = parseInt(v.value);
	if(flag == "plus"){
		v.value = num + 1;
	}else if(flag == "minus"){
		if(num > 1){
			v.value = num - 1;
		}
	}
	return;
}

function deleachItem(uid){
	location.href = "./wizbag.php?query=qde&cuid="+uid+"&op=<?php echo $op?>"
}

function modQty(uid, v){
	location.href = "./wizbag.php?query=qtyup&cuid="+uid+"&BUYNUM="+v.value+"&op=<?php echo $op?>"
}
</script>
<style>
.msgBox	{ padding-top:5px; padding-bottom:5px; border-bottom:1px solid #cccccc; background-color:#FCF7F3; }
</style>
<?php
if($carttype !="orderinfo" && ($query == "step3" || $query == "step4" || $RepayOrderID)){
## $RepayOrderID 는 배송상태에서 결제실패시 결제만 새로할 경우 넘어오는 아이디
if(!$OrderID && $CART_CODE) $OrderID = $CART_CODE;
?>

<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>상품명</th>
			<th>가격</th>
			<th>수량</th>
			<th>소계금액</th>
		</tr>
	</thead>
	<tbody>
<?php

$cartstr = "select sum(c.qty) from wizMall m left join wizCart c on m.UID = c.pid where c.oid = '".$OrderID."'";
$TotalUnit = $dbcon->get_one($cartstr);;//총구매수량

$cartstr = "select m.Category, m.UID, m.None, m.Picture, m.Name, 
			c.uid as cuid, c.qty, c.price, c.tprice, c.point, c.optionflag
			from wizMall m 
			left join wizCart c on m.UID = c.pid 
			where c.oid = '".$CART_CODE."' 
			order by c.uid asc";
//echo "sqlstr = $sqlstr <br />";
$cartqry = $dbcon->_query($cartstr);
$i=0;
$TOTAL_MONEY = 0;
while($cartlist = $dbcon->_fetch_array($cartqry)):
    	$Picture	= explode("|", $cartlist["Picture"]);
		$UID		= $cartlist["UID"];
		$Category	= $cartlist["Category"];
		$None		= $cartlist["None"];
		$Name		= $cartlist["Name"];
		$cuid		= $cartlist["cuid"];
		$qty		= $cartlist["qty"];
		$price		= $cartlist["price"];
		$tprice		= $cartlist["tprice"];
		$point		= $cartlist["point"];
		$optionflag	= $cartlist["optionflag"];
		$TOTAL_MONEY += $tprice;
		$TOTAL_PRODUCT_MONEY += $tprice;
		
		
	//추가 - 제품이 구매된 모든 카테고리를 하나로 만든다. 캬테고리별 가격을 위해
	//2. 카테고리를 하나로 만든다.
	if(chop($TOTAL_CAT))$TOTAL_CAT .= "|".$Category;
	else $TOTAL_CAT = $Category;		
?>
		<tr>
			<td><ul>
					<li style="display:inline-block;"><a href="<?php echo $pathadd?><?php echo $mall->pdviewlink($UID,$Category,$None)?>"><img src='<?php echo $pathadd?>config/uploadfolder/productimg/<?php echo substr($Category, -3)?>/<?php echo $Picture[0]?>' width='50' height='50'></a></li>
					<li style="display:inline-block;word-break:break-all;"> <a href="<?php echo $mall->pdviewlink($UID,$Category,$None)?>">
						<?php echo $Name?>
						</a> <? echo $cart->optoStr($optionflag); ?> </li>
				</ul></td>
			<td><?php echo number_format($price)?>
				원</td>
			<td><?php echo $qty?>
				ea</td>
			<td><?php echo number_format($tprice);?>
				원 </td>
		</tr>
<?php
$i++;
endwhile;
?>
	</tbody>
</table>
<?php
}else if($carttype =="orderinfo"){//주문배송조회/관리자모드에서
if(stripos($PHP_SELF, "order/order")){//관리자모드이면 strpos
	$pathadd = "../../";
}
?>
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>상품명</th>
			<th>가격</th>
			<th>수량</th>
			<th>소계금액</th>
		</tr>
	</thead>
<?php

$cartstr = "select sum(c.qty) from wizMall m left join wizCart c on m.UID = c.pid where c.oid = '".$CART_CODE."'";
$TotalUnit = $dbcon->get_one($cartstr);//총구매수량

$cartstr = "select m.Category, m.UID, m.None, m.Picture, m.Name, 
			c.uid as cuid, c.qty, c.price, c.tprice, c.point, c.optionflag
			from wizMall m 
			left join wizCart c on m.UID = c.pid 
			where c.oid = '".$CART_CODE."' 
			order by c.uid asc";
//echo "cartstr = $cartstr <br />";
$cartqry = $dbcon->_query($cartstr);
$i=0;
$TOTAL_MONEY = 0;
while($cartlist = $dbcon->_fetch_array($cartqry)):
    	$Picture	= explode("|", $cartlist["Picture"]);
		$UID		= $cartlist["UID"];
		$Category	= $cartlist["Category"];
		$None		= $cartlist["None"];
		$Name		= $cartlist["Name"];
		$cuid		= $cartlist["cuid"];
		$qty		= $cartlist["qty"];
		$price		= $cartlist["price"];
		$tprice		= $cartlist["tprice"];
		$point		= $cartlist["point"];
		$optionflag	= $cartlist["optionflag"];
		$TOTAL_MONEY += $tprice;
		$TOTAL_PRODUCT_MONEY += $tprice;
		
		
	//추가 - 제품이 구매된 모든 카테고리를 하나로 만든다. 캬테고리별 가격을 위해
	//2. 카테고리를 하나로 만든다.
	if(chop($TOTAL_CAT))$TOTAL_CAT .= "|".$Category;
	else $TOTAL_CAT = $Category;		
?>
	<tr>
		<td><ul>
				<li style="display:inline-block;"><a href="<?php echo $pathadd?><?php echo $mall->pdviewlink($UID,$Category,$None)?>"><img src='<?php echo $pathadd?>config/uploadfolder/productimg/<?php echo substr($Category, -3)?>/<?php echo $Picture[0]?>' width='50' height='50'></a></li>
				<li style="display:inline-block;word-break:break-all;"> <a href="<?php echo $mall->pdviewlink($UID,$Category,$None)?>">
					<?php echo $Name?>
					</a> <? echo $cart->optoStr($optionflag); ?> </li>
			</ul></td>
		<td><?php echo number_format($price)?>
			원</td>
		<td><?php echo $qty?>
			ea</td>
		<td><?php echo number_format($tprice);?>
			원<br />
		</td>
	</tr>
<?php
$i++;
endwhile;
?>
</table>
<?php
}else{
?>



<form name='cart_list_form' action='./wizbag.php'>
	<input type="hidden" name='query' VALUE='update_qty'>
	<input type="hidden" name='cuid' VALUE='<?php echo $cuid?>'>
	<input type="hidden" name='op' VALUE='<?php echo $op?>'>
	<table class="table table-striped table-hover">
		<col width="*" />
		<col width="80" />
		<col width="80" />
		<col width="80" />
		<col width="50" />
		<col width="50" />
		<thead>
			<tr>
				<th>상품명</th>
				<th>가격</th>
				<th>수량</th>
				<th>소계금액</th>
				<th>수정</th>
				<th>삭제</th>
			</tr>
		</thead>
		<tbody>
<?php
$cartstr = "select sum(c.qty) from wizMall m left join wizCart c on m.UID = c.pid where c.oid = '".$CART_CODE."'";
	$TotalUnit = $dbcon->get_one($cartstr);;//총구매수량

	$cartstr = "select m.Category, m.UID, m.None, m.Picture, m.Name, 
				c.uid as cuid, c.qty, c.price, c.tprice, c.point, c.optionflag
				from wizMall m 
				left join wizCart c on m.UID = c.pid 
				where c.oid = '".$CART_CODE."' 
				order by c.uid asc";
	//echo "sqlstr = $sqlstr <br />";
	$qry	= $dbcon->_query($cartstr);

$i=0;
$TOTAL_MONEY = 0;
while($cartlist = $dbcon->_fetch_array($qry)):
    	$Picture	= explode("|", $cartlist["Picture"]);
		$UID		= $cartlist["UID"];
		$Category	= $cartlist["Category"];
		$None		= $cartlist["None"];
		$Name		= $cartlist["Name"];
		$cuid		= $cartlist["cuid"];
		$qty		= $cartlist["qty"];
		$price		= $cartlist["price"];
		$tprice		= $cartlist["tprice"];
		$point		= $cartlist["point"];
		$optionflag	= $cartlist["optionflag"];
		$TOTAL_MONEY += $tprice;
		$TOTAL_PRODUCT_MONEY += $tprice;
		
		
	//추가 - 제품이 구매된 모든 카테고리를 하나로 만든다. 캬테고리별 가격을 위해
	//2. 카테고리를 하나로 만든다.
	if(chop($TOTAL_CAT))$TOTAL_CAT .= "|".$Category;
	else $TOTAL_CAT = $Category;		
?>
			<tr>
				<td><ul>
						<li style="display:inline-block;"><a href="<?php echo $mall->pdviewlink($UID,$Category,$None)?>"><img src='./config/uploadfolder/productimg/<?php echo substr($Category, -3)?>/<?php echo $Picture[0]?>' width='50' height='50'></a></li>
						<li style="display:inline-block;word-break:break-all;"> <a href="<?php echo $mall->pdviewlink($UID,$Category,$None)?>">
							<?php echo $Name?>
							</a> <? echo $cart->optoStr($optionflag); ?> </li>
					</ul></td>
				<td class="agn_r"><?php echo number_format($price)?>
					원</td>
				<td class="agn_c">
					<ul class="pd_cnt">
							<li><input type="text" name='BUYNUM_<?php echo $i?>' value='<?php echo $qty?>' onkeypress="onlyNumber()" class="w30"></li>
							<li style="padding:0px;"><ul style="padding-left:5px;">
								<li><a href="javascript:num_cal(document.cart_list_form.BUYNUM_<?php echo $i?>, 'plus')"><img src="./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]?>/images/num_plus.gif"></a></li>
								<li><a href="javascript:num_cal(document.cart_list_form.BUYNUM_<?php echo $i?>, 'minus')"><img src="./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]?>/images/num_minus.gif"></a></li>
							</ul></li>
						</ul>
					</td>
				<td class="agn_r"><?php echo number_format($tprice);?>
					원<br />
				</td>
				<td class="agn_c"><a href="javascript:modQty(<? echo $cuid;?>, document.cart_list_form.BUYNUM_<?php echo $i?>)"><img src='./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]?>/images/but_mo.gif' align="middle"></a> </td>
				<td class="agn_c"><a href='javascript:deleachItem(<? echo $cuid;?>)'><img src='./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]?>/images/but_cancle.gif' align="middle"></a></td>
			</tr>
<?php
$i++;
endwhile;
?>
		</tbody>
	</table>
</form>
<?php
}
?>
<br />
<div class="agn_c">
<?php
if ($TOTAL_MONEY) { // 장바구니가 담겼으면
$TOTAL_MONEY_TMP=$TOTAL_MONEY;

//<!--- [ 출력메시지를 표시합니다. ] ------------------------------------------------------------------------------------>//
//<!--- [ 출력메시지를 표시합니다. ] ------------------------------------------------------------------------------------>//
if($TOTAL_MONEY < $cfg["pay"]["TACKBAE_CUTLINE"] && $cfg["pay"]["TACKBAE_ALL"] == "ENABLE"){
	$MESSAGE_TACKBAE = "<div class='msgBox'>
	주문총액이 ".number_format($cfg["pay"]["TACKBAE_CUTLINE"])."원 이하일 경우에는 ".number_format($cfg["pay"]["TACKBAE_MONEY"])."원의 배송비가 합산되어집니다</div>";
}else if($cfg["pay"]["TACKBAE_ALL"] == "PER"){

	// 최초주문 배송비 만원 + 추가 수량당 2천원 추가 
	//$MESSAGE_TACKBAE = "<div class='msgBox'>갯수당 ".number_format($cfg["pay"]["TACKBAE_MONEY"])."원의 배송비가 합산되어집니다.</div>";
	$MESSAGE_TACKBAE = "<div class='msgBox'>최초주문 배송비 ".number_format($cfg["pay"]["TACKBAE_MONEY"])."원 + 추가 수량당 ".number_format($cfg["pay"]["ADD_TACKBAE_MONEY"])."의 배송비가 합산되어집니다.</div>";
	//echo $MESSAGE_TACKBAE;
}else if($cfg["pay"]["TACKBAE_ALL"] == "ALL"){
	$MESSAGE_TACKBAE = "<div class='msgBox'>".number_format($cfg["pay"]["TACKBAE_MONEY"])."원의 배송비가 합산되어집니다.</div>";
}else{
	$cfg["pay"]["TACKBAE_MONEY"] = 0;
}

if($cfg["pay"]["VAT_ENABLE"] == "checked")
	$MESSAGE_VAT = "<div class='msgBox'>
	VAT.(부가가치세) ".number_format($TOTAL_MONEY*$cfg["pay"]["VAT_MONEY"]/100)."가 합산되어집니다.
	</div>";

$MESSAGE_RATE1 = "<div class='msgBox'>
	현금결제(무통장입금)가  아닐경우 ".number_format($TOTAL_MONEY_TMP)."원의".$cfg["pay"]["CARDCHECK_RATE_VALUE1"]."%가 상품가격에 포함됩니다.
	</div>";
    
$MESSAGE_VALUE1 = "<div class='msgBox'>
	현금결제(무통장입금)가 아닐경우 ".number_format($cfg["pay"]["CARDCHECK_RATE_VALUE2"])."원의 금액이 상품가격에 포함됩니다.
	</div>";

$MESSAGE_DETAIL_RATE = "<div class='msgBox'>
	HP와 삼성제품만 구매시 카드결제일경우 경우 ".number_format($TOTAL_MONEY_TMP)."원의".$cfg["pay"]["DIFF_CARD_RATE"]."%가 상품가격에 포함됩니다.
	</div>";

$MESSAGE_DETAIL_VALUE = "<div class='msgBox'>
	HP와 삼성제품만 구매시 카드결제일경우 ".number_format($cfg["pay"]["DIFF_CARD_VALUE"])."원의 금액이 상품가격에 포함됩니다.
	</div>";
//<!--- [ 합산을 계산합니다 ] ------------------------------------------------------------------------------------>//

/* 배송비 이전에 만약 vat가 존재할 경우 이 부분을 먼저 계산한다. */
if($cfg["pay"]["VAT_ENABLE"] == "checked"){
$TOTAL_MONEY += $TOTAL_MONEY*$cfg["pay"]["VAT_MONEY"]/100;
echo $MESSAGE_VAT;
}


// 택배 MONEY 합산
/* 택배옵션 : ENABLE : 가격당 택배비, DISABLE : 무시, ALL : 구매량, 금액관계없이 택배비 적용, PER : 갯수당 적용 */
//if($TOTAL_MONEY >= $cfg["pay"]["TACKBAE_CUTLINE"]) $cfg["pay"]["TACKBAE_MONEY"] = 0;

if($TOTAL_MONEY < $cfg["pay"]["TACKBAE_CUTLINE"] && $cfg["pay"]["TACKBAE_ALL"] == "ENABLE"){
$TOTAL_MONEY = $TOTAL_MONEY + $cfg["pay"]["TACKBAE_MONEY"];
echo $MESSAGE_TACKBAE;
}



if($cfg["pay"]["TACKBAE_ALL"] == "ALL" ){
	$TOTAL_MONEY = $TOTAL_MONEY + $cfg["pay"]["TACKBAE_MONEY"];
	echo $MESSAGE_TACKBAE;
}else if($cfg["pay"]["TACKBAE_ALL"] == "PER" ){
	$TOTAL_MONEY = $TOTAL_MONEY + $cfg["pay"]["TACKBAE_MONEY"] + $cfg["pay"]["ADD_TACKBAE_MONEY"]*($TotalUnit-1);
	echo $MESSAGE_TACKBAE;
}

//카드결제시 결제 비용(% or value)을 계산
if(!strcmp($cfg["pay"]["CARDCHECK_ENABLE"],"NOTSAME") && !strcmp($cfg["pay"]["CARDCHECK_RATE"],"CARDCHECK_PER") ){
$TOTAL_MONEY_TMP=$TOTAL_MONEY_TMP*(1 +  $cfg["pay"]["CARDCHECK_RATE_VALUE1"]/100) + $cfg["pay"]["TACKBAE_MONEY"];
echo $MESSAGE_RATE1;
       if(!(strcmp($query,"step3") && strcmp($query,"step4")) && strcmp($check,"online")){
		   $TOTAL_MONEY = $TOTAL_MONEY_TMP;
	   }
}

if(!strcmp($cfg["pay"]["CARDCHECK_ENABLE"],"NOTSAME") && !strcmp($cfg["pay"]["CARDCHECK_RATE"],"CARDCHECK_VALUE") ){
$TOTAL_MONEY_TMP=$TOTAL_MONEY_TMP + $cfg["pay"]["CARDCHECK_RATE_VALUE2"] + $cfg["pay"]["TACKBAE_MONEY"];
echo $MESSAGE_VALUE1;
       if(!(strcmp($query,"step3") && strcmp($query,"step4")) && strcmp($check,"online")){
		   $TOTAL_MONEY = $TOTAL_MONEY_TMP;
	   }
}

//디렉토리별로 가격을 정할때 사용한다.
$TOTAL_MONEY_SUB_DIFF="";
if(!strcmp($cfg["pay"]["CARDCHECK_ENABLE"],"DIRNOTSAME")){

//카드결제시 결제 비용을 디렉토리별로 계산
//추가 - 제품이 구매된 모든 카테고리를 하나로 만든다.
//2. 카테고리를 하나로 만든다.

$TOTAL_CAT_SPLIT=explod("|",$TOTAL_CAT);
$TOTAL_MONEY_SUB_DIFF = 0;
for($i=0; $i < sizeof($TOTAL_CAT_SPLIT) && chop($TOTAL_CAT_SPLIT); $i++){
$sqlstr = "select cat_no, cat_name, cat_price from wizCategory where cat_price = 'checked' order by cat_no asc";
$dbcon->_query($sqlstr);
   while($cartlist = $dbcon->_fetch_array()):
   		if($cartlist[cat_no]){
		   if(!strcmp($TOTAL_CAT_SPLIT[$i],$cartlist[cat_no])) $TOTAL_MONEY_SUB_DIFF ++;
		}
      endwhile;
}
/** 카테고리 비교 끝 ***********************************************************/


if($TOTAL_MONEY_SUB_DIFF == sizeof($TOTAL_CAT_SPLIT)){
//카드결제시 결제 비용(% or value)을 계산
/******************************************************************************************************************/
if(!strcmp($cfg["pay"]["DIRNOTSAME_METHOD"],"CARDCHECK_RATE") ){
$TOTAL_MONEY_TMP=$TOTAL_MONEY_TMP*(1 +  $cfg["pay"]["DIFF_CARD_RATE"]/100) + $cfg["pay"]["TACKBAE_MONEY"];
echo $MESSAGE_DETAIL_RATE;
       if(!(strcmp($query,"step3") && strcmp($query,"step4")) && strcmp($check,"online")){
		   $TOTAL_MONEY = $TOTAL_MONEY_TMP;
	   }
}

if(!strcmp($cfg["pay"]["DIRNOTSAME_METHOD"],"CARDCHECK_VALUE") ){
$TOTAL_MONEY_TMP=$TOTAL_MONEY_TMP + $cfg["pay"]["DIFF_CARD_VALUE"] + $cfg["pay"]["TACKBAE_MONEY"];
echo $MESSAGE_DETAIL_VALUE;
       if(!(strcmp($query,"step3") && strcmp($query,"step4")) && strcmp($check,"online")){
		   $TOTAL_MONEY = $TOTAL_MONEY_TMP;
	   }
}
/******************************************************************************************************************/
}
}
?>
<span class="orange">주문상품 총액:</span> <?php echo number_format($TOTAL_MONEY);?> 원
<?php
} else { // 장바구니가 비었으면
?>
현재 장바구니에 담긴 상품이 없습니다.
<?php
}
?>
</div>
<!-- 장바구니 보기 끝 -->
