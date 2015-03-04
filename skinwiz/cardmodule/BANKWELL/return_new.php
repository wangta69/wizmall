<?
//  ###################################################################################
// 
//    return.php
// 
//    Copyright (c) 2005  BANKWELL Co. LTD.
//    All rights reserved.
// 
//    PG사에서 승인 결과를 받아 DB에 수정하는 모듈
// 
//  ###################################################################################
// 
//  [ return.php를 호출할때 인자로 넘어오는 구성요소 ]
// 
//   1. ShopCode     : 해당 쇼핑몰 번호(PG사에서 부여받은 코드)
//   2. ReplyCode    : 응답코드로 '0000'이면 정상 그외는 에러처리한다.
//   3. ScrMessage   : 응답메시지
//   4. OrderDate    : 거래요청일자(YYYYMMDD)
//   5. OrderTime    : 거래요청시간(HHMMSS)
//   6. SequenceNo   : 거래요청번호
//   7. OrderNo      : 주문번호
//   8. Installment  : 할부개월
//   9. AcquireCode  : 매입사코드
//  10. AcquireName  : 매입사이름
//  11. ApprovalNo   : 승인번호
//  12. ApprovalTime : 승인일시(YYYYMMDDHHMM000)
//  13. CardIssuer   : 카드발급사이름
//  14. tran_date    : PG사의 거래일자(YYYYMMDD)
//  15. tran_seq     : PG사의 거래번호
//  16. Reserved1    : FILLER
//  17. Reserved1    : FILLER
//  18. 그외 아래의 주석처럼 사용자가 정의한 인자를 받을수 있다.
//  ###################################################################################

// test.html 에서 사용자가 넘긴값받기.
// 주문자명 	: $order_name
// 상품명 		: $order_bname
// 금액 		: $order_amount
// 주문자Email 	: $order_email
// 주문자전화 	: $order_tel
// 주문자핸드폰 : $order_hp
// 수취인명 	: $rev_name
// 수취인Email 	: $rev_email
// 수취인전화 	: $rev_tel
// 수취인핸드폰 : $rev_hp
// 배송지주소 	: $zip1 . "-" . $zip2 . "  " . $addr
// 메세지 		: $message
// 결제유형		: $MsgTypeCode

// return.php페이지에 1차적 에러여부는 웹브라우저상에 
// http://가맹점도메인/modules/return.php를 호출 했을때 화면에 0000이뜨면 1차적으로는 정상임.
// 이곳의 주석은 수정이 끝난후 모두 지우셔도 됩니다.
	include "../../../lib/cfg.common.php";
	include "../../../config/db_info.php";
	include "../../../lib/class.database.php";
	$dbcon	= new database($cfg["sql"]);
	include "../../../lib/class.cart.php";
	$cart	= new cart();
	$cart->dbcon = $dbcon;
	
	if ($ReplyCode == "0000"){ //결제 성공시 처리 작업
		$cart->payresult($OrderNo);
		// 이곳에 데이터 베이스 작업을 하시면 됩니다.	
	}
	
	// 위의 작업이 끝난후 별로도 페이지 넘기는 작업을 하실필요가 없습니다.(메뉴얼참조)
	
	// 아래 print구문은 손대지 마세요 !!!
	print $ReplyCode;
?>





<script language="javascript">
	function ok() 
	{
opener.location.replace('/');
			self.close();
	}
	</script>

<body leftmargin="10" topmargin="10">
<head><title>결제성공 !!!</title></head>
<TABLE WIDTH=100% BORDER=0 CELLPADDING=0 CELLSPACING=0>
	<TR>
		<TD  style='padding:30 0 0 25' >
			<table border="0" cellpadding="0" cellspacing="0" width="500" bgcolor="ababab" >
			<tr>
				<td>
					<table border="0" cellpadding="5" cellspacing="1" width="100%">
					<tr bgcolor="#FFCC4A">
						<td align="center" colspan="2"><b>결제하신 내역입니다.</b></td>
					</tr>
					<tr bgcolor="ffffff">
						<td width="160" align="center" bgcolor="efefef">주문자명</td>
						<td><?=$receipttoname?></td>
					</tr>
					<tr bgcolor="ffffff">
						<td width="160" align="center" bgcolor="efefef">상 품 명</td>
						<td><?=$goodname?></td>
					</tr>
					<tr bgcolor="ffffff">
						<td width="160" align="center" bgcolor="efefef">금 액</td>
						<td><?=$unitprice?>원</td>
					</tr>
					<tr bgcolor="ffffff">
						<td width="160" align="center" bgcolor="efefef">주문번호</td>
						<td><?=$OrderNo?></td>
					</tr>


<?if($paymethod=="7"){?>

					<tr bgcolor="ffffff">
						<td width="160" align="center" bgcolor="efefef">가상계좌번호</td>
						<td>국민은행:<?=$bankaccount?></td>
					</tr>
					<tr bgcolor="ffffff">
						<td width="160" align="center" bgcolor="efefef">입금가능일자</td>
						<td><?=$bankexpyear?>년<?=$bankexpmonth?>월<?=$bankexpday?>일</td>
					</tr>
					<tr bgcolor="ffffff">
						<td colspan=2 align="center" bgcolor="efefef">입금이 확인되시면 배송됩니다
					</tr>

<?}else{?>
					<tr bgcolor="ffffff">
						<td width="160" align="center" bgcolor="efefef">카드승인번호</td>
						<td><?=$cardauthcode?></td>
					</tr>
					<tr bgcolor="ffffff">
						<td colspan=2 align="center" bgcolor="efefef">결제가 완료되었습니다
					</tr>

<?}?>
					</table>
				</td>
			</tr>
	<tr>
		<td height="30" align="center" bgcolor="ffffff">
			<span onClick="javascript:ok();" style="cursor:hand;">확인</span>
		</td>
	</tr>
	</table>
	</body>	