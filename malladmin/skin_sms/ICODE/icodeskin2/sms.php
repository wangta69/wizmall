<html>
<head>
<LINK REL=stylesheet TYPE="text/css" HREF="css/css1.css">
<script language="javascript" src="js/msg.js"></script>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!-- Action 안에 사용하시는 모듈의 파일명을 적어주세요 -->
<!-- Action 안에 사용하시는 모듈의 파일명을 적어주세요 -->
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><table width="178" height="437" border="0" cellpadding="0" cellspacing="0">
<form name=MsgForm method=post action='../smsindex.php'  onSubmit="return varcheck()">
<input type="hidden" name="addcall" value="0114769593">
 <!--  <input type="hidden" name="addcall" value="0185622641">-->
 
 <input name="SendFlag" type="hidden" value="0"><!-- 0 : 즉시전송 , 1: 예약전송 --> 
	<tr> 
						<td height="72" valign="top"><img src="./sms_images/top.gif" width="178" height="76"></td>
	</tr> 	
	<tr> 
		<td height="72" valign="top"><img src="./sms_images/1.gif" width="178" height="72"></td>
	</tr>
	<tr> 
		<td height="91" align="center" background="./sms_images/bg1.gif"><table width="105" height="91" border="0" cellpadding="0" cellspacing="0">
				<tr> 
					<td><textarea name="MSG_TXT" onChange="ChkLen()" onKeyUp="ChkLen()" style="background-color:#B3F1FF;border-color:#000000; border:solid 0; height: 90px; width: 100px; FONT-SIZE: 9pt; overflow:hidden" rows=6 cols=22></textarea></td>
				</tr>
			</table></td>
	</tr>
	<tr> 
		<td height="8"><img src="./sms_images/2.gif" width="178" height="8"></td>
	</tr>
	<tr> 
		<td height="55" valign="top"><table width="100%" height="10" border="0" cellpadding="0" cellspacing="0" background="./sms_images/bg3.gif">
				<tr> 
					<td width="20">&nbsp;</td>
					<td width="139" align="center" bgcolor="9BE5FF"><table width="80%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center" style="font-size:12px"><input type="text" name="MSG_TXT_CNT" size="2" style="background-color:#B3F1FF; border-color:#000000; border:solid 0; height: 14px; width: 18px; FONT-SIZE: 9pt;" maxlength="2" value="0" readonly> / 70 Byte</td>
							</tr>
						</table> </td>
					<td width="19" align="right">&nbsp;</td>
				</tr>
			</table> <img src="./sms_images/3.gif" width="178" height="36"></td>
	</tr>
	<tr> 
		<td height="64" background="./sms_images/bg2.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="center"><input name="callback" type="text" size="22"></td>
				</tr>
				<tr>
					<td height="19" valign="bottom"><img src="sms_images/4.gif" width="178" height="17"></td>
				</tr>
				<tr>
					<td align="center"><input name="sendername" type="text" size="22"></td>
				</tr>
				<tr>
					<td><img src="./sms_images/5.gif" width="178" height="13"></td>
				</tr>
			</table></td>
	</tr>
	<tr>
		<td height="98"><img src="./sms_images/6.gif" width="178" height="98" border="0" usemap="#Map2"></td>
	</tr>
	<tr>
		<td height="49"><img src="./sms_images/7.gif" width="178" height="49" border="0" usemap="#Map"></td>
	</tr></form>
</table>
      
    </td>
  </tr>
</table>
<map name="Map">
    <area shape="rect" coords="11,4,86,36" href="javascript:document.MsgForm.submit()">
	<area shape="rect" coords="90,5,164,35" href="javascript:self.close()">
</map>
<map name="Map2">
    <area shape="rect" coords="17,1,33,17" href="Javascript:add('■')">
	<area shape="rect" coords="17,19,34,35" href="Javascript:add('●')">
	<area shape="rect" coords="15,36,34,51" href="Javascript:add('☎')">
	<area shape="rect" coords="17,52,34,68" href="Javascript:add('☞')">
	<area shape="rect" coords="16,69,35,85" href="Javascript:add('™')">
	<area shape="rect" coords="35,69,53,85" href="Javascript:add('℡')">
	<area shape="rect" coords="35,52,51,69" href="Javascript:add('☜')">
	<area shape="rect" coords="35,35,52,51" href="Javascript:add('☏')">
	<area shape="rect" coords="33,17,51,35" href="Javascript:add('○')">
	<area shape="rect" coords="34,-1,52,17" href="Javascript:add('□')">
	<area shape="rect" coords="53,1,71,16" href="Javascript:add('▣')">
	<area shape="rect" coords="52,17,70,34" href="Javascript:add('▲')">
	<area shape="rect" coords="52,33,70,51" href="Javascript:add('♠')">
	<area shape="rect" coords="52,51,70,69" href="Javascript:add('▒')">
	<area shape="rect" coords="53,69,70,85" href="Javascript:add('∑')">
	<area shape="rect" coords="70,68,87,85" href="Javascript:add('∏')">
	<area shape="rect" coords="70,51,88,69" href="Javascript:add('⊙')">
	<area shape="rect" coords="71,35,88,52" href="Javascript:add('♤')">
	<area shape="rect" coords="70,17,88,34" href="Javascript:add('▼')">
	<area shape="rect" coords="71,1,88,17" href="Javascript:add('◈')">
	<area shape="rect" coords="88,-1,106,17" href="Javascript:add('◆')">
	<area shape="rect" coords="87,16,106,34" href="Javascript:add('▶')">
	<area shape="rect" coords="87,35,106,51" href="Javascript:add('♣')">
	<area shape="rect" coords="87,50,107,68" href="Javascript:add('㈜')">
	<area shape="rect" coords="87,68,106,85" href="Javascript:add('♬')">
	<area shape="rect" coords="107,68,125,85" href="Javascript:add('♪')">
	<area shape="rect" coords="107,51,124,68" href="Javascript:add('№')">
	<area shape="rect" coords="107,34,124,51" href="Javascript:add('♧')">
	<area shape="rect" coords="106,18,124,36" href="Javascript:add('▷')">
	<area shape="rect" coords="106,0,124,16" href="Javascript:add('◇')">
	<area shape="rect" coords="125,0,142,17" href="Javascript:add('♥')">
	<area shape="rect" coords="125,17,143,33" href="Javascript:add('◀')">
	<area shape="rect" coords="124,33,142,51" href="Javascript:add('★')">
	<area shape="rect" coords="124,50,143,69" href="Javascript:add('㉿')">
	<area shape="rect" coords="124,70,142,84" href="Javascript:add('♩')">
	<area shape="rect" coords="142,67,160,86" href="Javascript:add('♭')">
	<area shape="rect" coords="142,52,160,68" href="Javascript:add('♨')">
	<area shape="rect" coords="141,34,160,51" href="Javascript:add('☆')">
	<area shape="rect" coords="144,17,161,34" href="Javascript:add('◁')">
	<area shape="rect" coords="142,2,161,16" href="Javascript:add('♡')">
</map>
</body>

</html>
