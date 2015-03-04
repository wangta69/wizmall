<!--#######################################################-->
<!--# 					return_false.php				  #-->
<!--#######################################################-->
<!--# 													  #-->
<!--# 결재성공후 오프너에서 할작업을 여기서 하시면 됩니다.#-->
<!--#													  #-->
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
			<td align="center" colspan="2"><b>결제 실패</b></td>
		</tr>
		<tr bgcolor="ffffff">
			<td bgcolor="efefef">에러 코드</td>
			<td><?=$ReplyCode?></td>
		</tr>
		<tr bgcolor="ffffff">
			<td bgcolor="efefef">에러 메세지</td>
			<td><?=$ScrMessage?></td>
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