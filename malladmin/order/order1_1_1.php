<?php
/*
 powered by 폰돌
 Reference URL : http://www.shop-wiz.com
 Contact Email : master@shop-wiz.com
 Free Distributer :
 - http://www.shop-wiz.com
 Copyright shop-wiz.com
 *** Updating List ***
 */
include "../common/header_pop.php";

include ("../../config/common_array.php");

if ($query == 'qup' && $common -> checsrfkey($csrf)) {// 배송상태 변경
	$sqlstr = "update wizBuyers set RZip='$RZip', RAddress1='$RAddress1', RAddress2='$RAddress2' WHERE UID='$uid'";
	$result = $dbcon -> _query($sqlstr);

	echo "<script >opener.location.reload();self.close();</script>";
}

$LIST_QUERY = "select RZip, RAddress1, RAddress2, MemberID FROM wizBuyers WHERE UID='$uid'";
$List = $dbcon -> _fetch_array($dbcon -> _query($LIST_QUERY));
$List[Message] = nl2br(stripslashes($List[Message]));
$SAddress1 = $List[SAddress1];
if (!$List[MemberID]) {$List[MemberID] = "비회원";
}

include "../common/header_html.php";
?>
<body>
	<table>
		<tr>
			<td><span>배송상세정보 </span></td>
		</tr>
		<tr>
			<td>
			<table>
				<form name="orderForm" method="post" action="<?=$PHP_SELF; ?>">
					<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
					<input type="hidden" name="query" value="qup">
					<input type="hidden" name="uid" value="<?=$uid; ?>">
					<tr>
						<td colspan="4">[ 주문자 정보 ]</td>
					</tr>
					<tr>
						<th>우편번호</th>
						<td colspan="3">
						<input name="RZip" type="text"  value="<?=$List[RZip] ?>" size="8">
						</td>
					</tr>
					<tr>
						<th>배송지주소</th>
						<td colspan="3">
						<input name="RAddress1" type="text" id="RAddress1" value="<?=$List[RAddress1] ?>" style="width:99%">
						</td>
					</tr>
					<tr>
						<th>배송지상세주소</th>
						<td colspan="3">
						<input name="RAddress2" type="text" id="RAddress2" value="<?=$List[RAddress2] ?>" style="width:99%">
						</td>
					</tr>
				</form>
			</table>
			<table>
				<tr>
					<td colspan="2">
					<table>
						<tr>
							<!-- "\n\n거래가 완료된 상태에서 삭제가 불가능합니다. \n\n거래상태를 주문접수됨으로 변경후  \n\n삭제 처리하십시오.\n\n" -->
							<!-- "\n\n거래가 완료된 상태에서 반품처리할 경우 \n\n거래상태를 주문접수됨으로 변경후  \n\n처리하십시오.\n\n" -->

							<td><span class="button bull"><a href="javascript:document.orderForm.submit()">변경</a></span></td>
							<td>&nbsp;</td>
							<td><span class="button bull"><a href="javascript:self.close()">창닫기</a></span></td>

						</tr>
					</table></td>
				</tr>
			</table></td>
		</tr>
	</table>
</body>
</html>