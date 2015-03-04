<HTML>
<HEAD>
<TITLE>웹디스크(Web Disk) 테스트</TITLE>
</HEAD>

<link rel=stylesheet href='sv2.css'>

<meta http-equiv="Content-Type" content="text/html;charset=euc-kr">
<META HTTP-EQUIV="Expires" CONTENT="Mon, 06 Jan 1990 00:00:01 GMT">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Pragma" content="no-cache">

<BODY>

<table width=600 height=500 cellspacing=0 cellpadding=0 border=0>
<tr>
	<td>
	</td>
</tr>
<tr>
	<td bgcolor=#D6D3CE height=30>
		<table width=100% height=100% cellspacing=0 cellpadding=1 border=1>
		<tr>
			<td width=48% height=30 align=center>
				&nbsp;<img src='img/mypc.bmp' border=0 align=absmiddle><font face=Tahoma>&nbsp;&nbsp;<b>My Computer</b>
			</td>
			<td align=center>
				&nbsp;<img src='img/webd.bmp' border=0 align=absmiddle><font face=Tahoma>&nbsp;&nbsp;<b>User WebDisk</b>
			</td>

		</tr>
		</table>
		

	</td>
</tr>
<tr>
	<td height=1 bgcolor=#000000>
	</td>
</tr>
<tr>
	<td height=500 width=600 bgcolor=#EEEEEE>

		<table width=100% height=100% cellspacing=1 cellpadding=0 border=1>
		<tr>
			<td bgcolor=#eeeeee>

		
				<OBJECT width=800 height=500 ID="CSFManager" CLASSID="CLSID:D4A249DE-A617-11D5-A113-0060082725C0" CODEBASE="fileman.cab#Version=1,1,1,1">

<!--
	테스트할 서버의 IP를 기재
-->
					<PARAM NAME='Host' Value='<?=$_SERVER[HTTP_HOST]?>'>

<!--
	테스트할 서버의 Port를 기재
	80 Port일 경우 주석처리...
-->
					<PARAM NAME='Port' Value='<?=$SERVER_PORT?>'>



<?

// uid로 회원의 id가 전달되어져 오면 루트디렉토리에 대한 접근은 안되고
// 루트디렉토리 + 회원ID명으로 생성된 디렉토리에 대한 접근만 가능....
if($uid!=""){
?>
					<PARAM NAME='UID' Value='<?echo $uid;?>'>
<?
}
?>

<!--
	파일메니져 컨트롤의 제어를 전담하는 스크립트 파일의 경로를 적는 부분입니다.
	아래와 같다면...
	
	<?=str_replace("/","",dirname($_SERVER[PHP_SELF]))?>/fmanager.php 로 접근한다는 내용입니다.
-->				
					<PARAM NAME='PostAcceptor' Value='<?=str_replace("/","",dirname($_SERVER[PHP_SELF]))?>/fmanager.php'>
					
					
				</OBJECT>
			</td>
		</tr>
		</table>

	</td>
</tr>
</table>

</BODY>

</HTML>
