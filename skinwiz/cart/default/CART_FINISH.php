<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active">주문서 확인</li>
</ul>

<div>
<img src="skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]; ?>/images/cart_out_tit.gif" height="77">
<img src="skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]; ?>/images/cart_img.gif">
<img src="skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]; ?>/images/cart_out_tit02.gif" height="77">
<img src="skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]; ?>/images/cart_img.gif">
<img src="skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]; ?>/images/cart_on_tit03.gif" height="77">
<img src="skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]; ?>/images/cart_img.gif">
<img src="skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]; ?>/images/cart_out_tit04.gif" height="77">
</div>
<?php
// 장바구니 보기
include "./skinwiz/cart/".$cfg["skin"]["CartSkin"]."/CART_VIEW.php";

$sqlstr = "SELECT * FROM wizBuyers WHERE OrderID='".$OrderID."'";
$list = $dbcon->get_row($sqlstr);
$list["Message"] = nl2br($list["Message"]);
$PayMethod = $list["PayMethod"];
$AmountPoint = $list["AmountPoint"];
//print_r($list);
?>
<div class="space15"></div>
<img src="skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]; ?>/images/tit_01.gif">
<table class="table">
	<col width="130" />
	<col width="*" />
	<tbody>
		<tr>
			<th>주문번호</th>
			<td><span class="pink">
				<?php echo $OrderID?>
				</span>(배송
				조회시 필요 합니다) </td>
		</tr>
		<tr>
			<th>주문하시는분</th>
			<td><?php echo $list["SName"]?></td>
		</tr>
		<tr>
			<th>전화번호</th>
			<td><?php echo $list["STel1"]?></td>
		</tr>
		<tr>
			<th>휴대전화번호</th>
			<td><?php echo $list["STel2"]?></td>
		</tr>
		<tr>
			<th>이메일</th>
			<td><?php echo $list["SEmail"]?></td>
		</tr>
		<tr>
			<th>주소</th>
			<td>(<?php echo $list["SZip"]?>) <?php echo $list["SAddress1"]?> <?php echo $list["SAddress2"]?></td>
		</tr>
	</tbody>
</table>
<img src="skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]; ?>/images/tit_02.gif">
<table class="table">
	<col width="130" />
	<col width="*" />
	<tbody>
		<tr>
			<th>받는분</th>
			<td><?php echo $list["RName"];?></td>
		</tr>
		<tr>
			<th>전화번호</th>
			<td><?php echo $list["RTel1"];?></td>
		</tr>
		<tr>
			<th>휴대전화번호</th>
			<td><?php echo $list["RTel2"];?></td>
		</tr>
		<tr>
			<th>주소</th>
			<td>(<?php echo $list["RZip"]?>) <?php echo $list["RAddress1"]?> <?php echo $list["RAddress2"]?></td>
		</tr>
		<tr>
			<th>희망배송일</th>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<th>남기실말씀</th>
			<td><?php echo $list["Message"];?></td>
		</tr>
	</tbody>
</table>
<img src="skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]; ?>/images/tit_03.gif" width="114">
<table class="table">
	<col width="130" />
	<col width="*" />
	<tbody>
		<!--<tr>
          <th>할인금액</th>
          <td colspan="3">&nbsp;</td>
          </tr>-->
		<tr>
			<th>총결제 금액 </th>
			<td><?php echo number_format($list["TotalAmount"]);?> 원
			<?php
			if($list["ExpressDeliverFee"]) echo "(특송:".number_format($list["ExpressDeliverFee"])." 포함)";?></td>
		</tr>
		<?php if(!strcmp($cfg["pay"]["POINT_ENABLE"], "checked")):?>
		<!-- 포인트 결재 시작 -->
		<tr>
			<th>포인트사용금액</th>
			<td><?php echo number_format($AmountPoint)?>
				원</td>
		</tr>
		<!-- 포인트 결재 끝 -->
		<?php endif; ?>
		<tr>
			<th>최종결제 금액 </th>
			<td><?php echo number_format($list["TotalAmount"]-$AmountPoint);?> 원</td>
		</tr>
	</tbody>
</table>
<img src="skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]; ?>/images/tit_04.gif">
<table class="table">
	<col width="130" />
	<col width="*" />
	<tbody>
		<tr>
			<th>결제방식</th>
			<td class="pink"><?php echo $PaySortArr[$PayMethod];?>
				결제</td>
		</tr>
<?php
if($PayMethod == "online"){
?>
		<tr>
			<th>은행선택</th>
			<td><?php echo $list["BankInfo"]?></td>
		</tr>
		<tr>
			<th>입금자명</th>
			<td><?php echo $list[Inputer]?></td>
		</tr>
		<tr>
			<th>입금예정일</th>
			<td><?php if($list[PayDate] > (time()-60*60*24)) echo date("Y 년 m 월 d 일 H 시",$list[PayDate]); ?></td>
		</tr>
<?php
}
?>
	</tbody>
</table>
<div class="space15"></div>
<div class="btn_box"><img src="./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]; ?>/images/but_re.gif" width="77" onClick="javascript:location.href='<?php echo $PHP_SERF?>?query=step3&op=<?php echo $op?>';" style="cursor:pointer"> <img src="./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]; ?>/images/but_ok2.gif" width="68" onclick="javascript:location.replace('<?php echo $PHP_SERF?>?query=step5&OrderID=<?php echo $OrderID?>&userName=<?php echo $list[SName]?>&UserEmail=<?php echo $list[SEmail]?>&op=<?php echo $op?>')" style="cursor:pointer"></div>
