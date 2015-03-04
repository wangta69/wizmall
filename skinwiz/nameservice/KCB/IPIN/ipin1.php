<!DOCTYPE html>
<html lang="kr">
<head>
<meta charset="utf-8">

<script language="JavaScript">
//<!--
	function jsSubmit(){	
		var popupWindow = window.open("", "kcbPop", "left=200, top=100, status=0, width=450, height=550");
		var form1 = document.form1;
		form1.target = "kcbPop";
		form1.submit();

		popupWindow.focus()	;
	}
//-->
</script>
</head>
<!-- http://mall.shop-wiz.com/skinwiz/nameservice/KCB/IPIN/ipin1.php -->
<body>
	<form name="form1" action="ipin2.php" method="post">
		<table>
			<tr>
				<td colspan="2"><strong></strong></td>
			</tr>
			<tr>
				<td colspan="2" align="center">	<input type="button" value="보내기" onClick="jsSubmit();"></td>
			</tr>
		</table>
	</form>
	<form name="kcbOutForm" method="post"><!--   accept-charset="EUC-KR" -->
		<input type="hidden" name="encPsnlInfo" />
		<input type="hidden" name="virtualno" />
		<input type="hidden" name="dupinfo" />
		<input type="hidden" name="realname" />
		<input type="hidden" name="cprequestnumber" />
		<input type="hidden" name="age" />
		<input type="hidden" name="sex" />
		<input type="hidden" name="nationalinfo" />
		<input type="hidden" name="birthdate" />
		<input type="hidden" name="coinfo1" />
		<input type="hidden" name="coinfo2" />
		<input type="hidden" name="ciupdate" />
		<input type="hidden" name="cpcode" />
		<input type="hidden" name="authinfo" />
	</form>
</body>
</html>
