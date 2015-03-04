<?php
/*
 powered by 폰돌
 Reference URL : http://www.shop-wiz.com
 Contact Email : master@shop-wiz.com
 Free Distributer :
 Copyright shop-wiz.com
 *** Updating List ***
 */
include "../common/header_pop.php";
/* 엑셀로 출력하기 */
if ($DownForExel == "yes") {
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=${uid}.xls");
	header("Content-Description: PHP4 Generated Data");
}
?>
<html>
	<head>
		<title>위즈몰 관리자 모드 - [배송상세정보]</title>
		<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"] ?>">
	</head>
	<body>
		<table>
			<tr>
				<td><span>배송상세정보 </span></td>
			</tr>
			<tr>
				<td>
				<table>
					<tr>
						<th>주문상품&nbsp; </th>
						<th>가격</th>
						<th> 수량 </th>
						<th>합계/포인트 </th>
					</tr>
					<?php
$LIST_QUERY = "SELECT * FROM wizBuyers WHERE UID='$uid'";
//echo "\$LIST_QUERY = $LIST_QUERY <br />";
$List = $dbcon->get_row($LIST_QUERY);
$List["Message"] = nl2br(stripslashes($List["Message"]));
if (!$List["MemberID"]) {$List["MemberID"] = "비회원";}

for($i = 0; $i < sizeof($Cart_Data) && chop($Cart_Data[$i]); $i++) {
	$C_dat = explode("|", chop($Cart_Data[$i]));
	$VIEW_QUERY = "SELECT * FROM wizMall WHERE UID='$C_dat[0]'";
	$VIEW_DATA = $dbcon->_fetch_array($dbcon->_query($VIEW_QUERY));
	$List["UID"] = $VIEW_DATA["UID"];
	$VIEW_DATA["Name"] = stripslashes($VIEW_DATA["Name"]);
	$Price = number_format($C_dat[2]);
	$Point = number_format($VIEW_DATA["Point"] * $C_dat[1]);
	$Category = $VIEW_DATA["Category"];
	$SUM_MONEY = number_format($C_dat[2] * $C_dat[1]);
	$TOTAL_POINT = $TOTAL_POINT + ($VIEW_DATA["Point"] * $C_dat[1]);
?>
					<tr>
					<td><a  href='../wizmart.php?code=<?=$VIEW_DATA["Category"] ?>&query=view&no=<?=$List["UID"] ?>' target=_blank><U>
					<?=$VIEW_DATA["Name"] ?>
					<?if($VIEW_DATA["Model"]):
					?>
					(
					<?=$VIEW_DATA["Model"] ?>
					)
					<? endif; ?>
					</U></a><br />
					<?
					if ($C_dat[3]) {//옵션이 있어면
						if (eregi("=", $C_dat[3])) {// 옵션에 따른 가격이 있으면
							$SIZE_OPTION_SPL = explode("=", $C_dat[3]);
							ECHO "<FONT COLOR=#CE6500>$SIZE_OPTION_SPL[0] " . number_format($SIZE_OPTION_SPL[1] * $C_dat[1]) . " 추가 ";
							$CHECK1 = chop($SIZE_OPTION_SPL[1]);
							$SUM_MONEY = number_format((chop($SIZE_OPTION_SPL[1]) + $C_dat[2]) * $C_dat[1]);
							$TOTAL_MONEY = $TOTAL_MONEY + (chop($SIZE_OPTION_SPL[1]) + $C_dat[2]) * $C_dat[1];
						} else {// 옵션에 따른 가격이 없으면
							$TOTAL_MONEY = $TOTAL_MONEY + $C_dat[2] * $C_dat[1];
							ECHO "<FONT COLOR=#CE6500>${C_dat[3]} ";
						}
					} else {// ?퓽없으면
						$TOTAL_MONEY = $TOTAL_MONEY + $C_dat[2] * $C_dat[1];
					}

					if ($C_dat[4]) {
						ECHO " <FONT COLOR=#CE6500>$C_dat[4] ";
					}

					/* 기타옵션이 있을 경우 확 뿌려준다 */
					for ($j = 5; $j < sizeof($C_dat); $j++) {
						if ($C_dat[$j])
							echo " | <FONT COLOR=#CE6500>$C_dat[$j] ";
					}
					?>
					</td>
					<td><?=$Price ?>
					원</td>
					<td><?=$C_dat[1] ?>
					EA</td>
					<td><?=$SUM_MONEY ?>
					원/
					<?=$Point ?>
					포인트</td>
					</tr>
					<?
					}   // for
					$Tack_Money = $List["TotalAmount"] - $TOTAL_MONEY;
					?>
					<tr>
					<td colspan="5">주문상품 가격합계 :
					<?=number_format($List["TotalAmount"]) ?>
					원 (배송비
					<?=number_format($Tack_Money); ?>
					원 포함)- 지급포인트 :
					<?=number_format($TOTAL_POINT) ?>
					포인트</td>
					</tr>
				</table><table>
				<tr>
				<td colspan="4">[ 주문자 정보 ]</td>
				</tr>
				<tr>
				<th>입금인 </th>
				<td><a  href='mailto:$List[SEmail]'>
				<?=$List["Inputer"] ?>
				</a> (
				<?=$List["MemberID"] ?>
				)</td>
				<th>상호명</th>
				<td><?=$List["RCompany"] ?>
				</td>
				</tr>
				<tr>
				<th>E-mail</th>
				<td><a  href='mailto:<?=$List["SEmail"] ?>'>
				<?=$List["SEmail"] ?>
				</a> </td>
				<th>전화번호</th>
				<td><?=$List["STel1"] ?>
				</td>
				</tr>
				<tr>
				<th>휴대폰</th>
				<td><a  href='mailto:<?=$List["SEmail"] ?>'> </a>
				<?=$List["STel2"] ?>
				</td>
				<th>수령인</th>
				<td><?=$List["RName"] ?>
				</td>
				</tr>
				<tr>
				<th>우편번호</th>
				<td colspan="3"><?=$List["RZip"] ?>
				</td>
				</tr>
				<tr>
				<th>배송지주소</th>
				<td colspan="3"><?=$List["RAddress1"] ?>
				</td>
				</tr>
				<tr>
				<th>배송지전화 </th>
				<td><?=$List["RTel1"] ?>
				</td>
				<th>희망배송일</th>
				<td><?=$List["ExpectDate"] ?>
				</td>
				</tr>
				<tr>
				<th>배송안내글</th>
				<td colspan="3"><?=$List["Message"] ?>
				</td>
				</tr>
				</table>
				<table>
				<tr>
				<td colspan="4">[ 주문로그(LOG) ]</td>
				</tr>
				<tr>
				<th>주문번호 </th>
				<td><?=$List["OrderID"] ?>
				</td>
				<th>주문일자</th>
				<td><?=date("Y.m.d", $List["BuyDate"]) ?>
				</td>
				</tr>
				</table>
				<table>
				<tr>
				<th colspan="4">[ 택배사 및 송장번호]</th>
				</tr>
				<tr>
				<th>택배사</th>
				<td><?=$List["Deliverer"] ?>
				</td>
				<th>송장번호</th>
				<td><?=$List["InvoiceNo"] ?>
				</td>
				</tr>
				</table>
				<table>
				<tr>
				<th colspan="2">[ 결제방식 선택 ]</th>
				</tr>
				<?
//------------------------------------------[결제방식]
if ($List["PayMethod"] == 'card') {
				?>
				<tr>
				<th>결제방식</th>
				<td>신용카드 결제</td>
				</tr>
				<?
				}
				else if ($List["PayMethod"] == 'point') {
				?>
				<tr>
				<th>결제방식</th>
				<td>포인트 결제</td>
				</tr>
				<?
				}
				else if ($List["PayMethod"] == 'hand') {
				?>
				<tr>
				<th>결제방식</th>
				<td>핸드폰 결제</td>
				</tr>
				<?
				}
				else if ($List["PayMethod"] == 'all') {
				?>
				<tr>
				<th>결제방식</th>
				<td>다중결제(온라인+신용카드+포인트)</td>
				</tr>
				<tr>
				<th>온라인입금</th>
				<td><?=number_format($List["AmountOline"]); ?>
				원</td>
				</tr>
				<tr>
				<th>입금계좌</th>
				<td><?=$List["BankInfo"] ?>
				&nbsp;</td>
				</tr>
				<tr>
				<th>입금예정일</th>
				<td><? echo date("Y 년 m 월 d 일 H 시", $List["PayDate"]); ?>&
				nbsp;</td>
				</tr>
				<tr>
				<th>신용카드</th>
				<td><?=number_format($List["AmountPg"]); ?>
				원</td>
				</tr>
				<tr>
				<th>포인트</th>
				<td><?=number_format($List["AmountPoint"]); ?>
				포인트</td>
				</tr>
				<?
				}
				else {  //온라인 입금일 경우
				?>
				<tr>
				<th>결제방식</th>
				<td>온라인입금</td>
				</tr>
				<tr>
				<th>입금계좌</th>
				<td><?=$List["BankInfo"] ?>
				&nbsp;</td>
				</tr>
				<tr>
				<th>입금예정일</th>
				<td><?
					if ($List["PayDate"] >= mktime(0, 0, 0, 0, 0, 2000))
						echo date("Y 년 m 월 d 일 H 시", $List["PayDate"]);
				?>
				&nbsp;</td>
				</tr>
				<?
				}
				//--------------------------------------------------
				?>
				</table></td>
			</tr>
		</table>
	</body>
</html>
