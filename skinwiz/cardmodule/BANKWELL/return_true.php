<!--#######################################################-->
<!--# 					return_true.php					  #-->
<!--#######################################################-->
<!--# 													  #-->
<!--# 결재성공후 오프너에서 할작업을 여기서 하시면 됩니다.#-->
<!--#													  #-->
<!--# return.php에서 받은 값은 여기서 모두 받을수 있음	  #-->
<!--#													  #-->
<!--#													  #-->
<!--#######################################################-->

<body leftmargin="10" topmargin="10">
<head><title>결제성공 !!!</title></head>
<table border="0" cellpadding="0" cellspacing="0" width="500" bgcolor="ababab">
<tr>
	<td>
		<table border="0" cellpadding="5" cellspacing="1" width="100%">
		<tr bgcolor="#FFCC4A">
			<td align="center" colspan="2"><b>결제하신 내역입니다.</b></td>
		</tr>
		<tr bgcolor="ffffff">
			<td width="160" align="center" bgcolor="efefef">주문자명</td>
			<td><?=$order_name?></td>
		</tr>
		<tr bgcolor="ffffff">
			<td width="160" align="center" bgcolor="efefef">상 품 명</td>
			<td><?=$order_bname?></td>
		</tr>
		<tr bgcolor="ffffff">
			<td width="160" align="center" bgcolor="efefef">금 액</td>
			<td><?=$order_amount?>원</td>
		</tr>
		<tr bgcolor="ffffff">
			<td width="160" align="center" bgcolor="efefef">주문자Email</td>
			<td><?=$order_email?></td>
		</tr>
		<tr bgcolor="ffffff">
			<td width="160" align="center" bgcolor="efefef">주문자전화</td>
			<td><?=$order_tel?></td>
		</tr>
		<tr bgcolor="ffffff">
			<td width="160" align="center" bgcolor="efefef">주문자핸드폰</td>
			<td><?=$order_hp?></td>
		</tr>
		<tr bgcolor="ffffff">
			<td width="160" align="center" bgcolor="efefef">수취인명</td>
			<td><?=$rev_name?></td>
		</tr>
		<tr bgcolor="ffffff">
			<td width="160" align="center" bgcolor="efefef">수취인Email</td>
			<td><?=$rev_email?></td>
		</tr>
		<tr bgcolor="ffffff">
			<td width="160" align="center" bgcolor="efefef">수취인전화</td>
			<td><?=$rev_tel?></td>
		</tr>
		<tr bgcolor="ffffff">
			<td width="160" align="center" bgcolor="efefef">수취인핸드폰</td>
			<td><?=$rev_hp?></td>
		</tr>
		<tr bgcolor="ffffff">
			<td width="160" align="center" bgcolor="efefef">배송지주소</td>
			<td><?=$zip1 . "-" . $zip2 . "  " . $addr?></td>
		</tr>
		<tr bgcolor="ffffff">
			<td width="160" align="center" bgcolor="efefef">메세지</td>
			<td><?=$message?></td>
		</tr>
		<tr bgcolor="ffffff">
			<td width="160" align="center" bgcolor="efefef">결제유형</td>
			<td><b><?=$MsgTypeCode?></b> (11:신용카드 30:핸드폰 31:ARS 32:폰빌 33:계좌이체)</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td height="30" align="center" bgcolor="ffffff">
		<a href="/">확인</a>
	</td>
</tr>
</table>
</body>
