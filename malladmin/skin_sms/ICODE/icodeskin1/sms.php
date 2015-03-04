<html>
<head>
<LINK REL=stylesheet TYPE="text/css" HREF="css/css1.css">
<script language="javascript" src="js/msg.js"></script>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!-- Action 안에 사용하시는 모듈의 파일명을 적어주세요 -->
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><table width="154" height="396" border="0" cellpadding="0" cellspacing="0">
<form name=MsgForm method=post action='../smsindex.php'  onSubmit="return varcheck()">
<input type="hidden" name="addcall" value="0114769593">
 <!--  <input type="hidden" name="addcall" value="0185622641">-->
 
 <input name="SendFlag" type="hidden" value="0"><!-- 0 : 즉시전송 , 1: 예약전송 --> <tr>
    <td width="154" height="396" align="center"> 
					  <table width="148" border="0" cellspacing="0" cellpadding="0" height="110">
						<tr>
							<td><img src="sms_images/sms_top.gif"></td>
						</tr>

						<tr> 
						  <td background="sms_images/sms_back.gif" width="149" height="147" valign="bottom" align="center"> 
							<!-- 액정화면 -->
							<table width="100" border="0" cellspacing="0" cellpadding="0" class="td1">
							  <tr> 
								<td> 
								  <textarea name="MSG_TXT" onChange="ChkLen()" onKeyUp="ChkLen()" style="border-color:#000000; border:solid 0; height: 90px; background-color: #9bd9ff; width: 100px; FONT-SIZE: 9pt; overflow:hidden" rows=6 cols=22></textarea>
								</td>
							  </tr>
							  <tr> 
								<td align="right" height=40> 
								  <input type="text" name="MSG_TXT_CNT" size="2" style="border-color:#000000; border:solid 0; height: 14px; width: 18px; background-color: #9bd9ff; FONT-SIZE: 9pt;" maxlength="2" value="0" readonly>
                          /70 byte&nbsp;&nbsp;</td>
							  </tr>
							</table>
							<!-- 액정화면 -->
						  </td>
						</tr>
					  </table>
                        
						  <table border="0" cellspacing="0" cellpadding="2">
							<tr>
						    <td align="center">
                              <table width="150" border="0" cellspacing="0" cellpadding="0" class="td1">
                                <tr> 
                                  
                <td align=center>발신번호: 
                  <input type="text" name="callback" size="14" maxlength="14" STYLE='border-color:#000000; FONT-SIZE: 9pt; border:solid 1; width:75px; height:18px;' value="">
                  <br />
                  발신자명: 
                  <input type="text" name="sendername" size="3" maxlength="3" STYLE='border-color:#000000; FONT-SIZE: 9pt; border:solid 1; width:75px; height:18px;' value="">
                                  </td>
                                </tr>
                                <tr> 
                                  <td colspan="2"> 
                                    </td>
                                </tr>
                              </table>
							  
							</td>
						  </tr>
						  <tr> 
                            <td align="center" valign="top">
                              <table width="82" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td width="18"><a href="Javascript:add('■')"><img src="sms_images/c.gif" width="19" height="19" border=0></a></td>
                                  <td width="18"><a href="Javascript:add('□')"><img src="sms_images/c1.gif" width="18" height="19" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('▣')"><img src="sms_images/c2.gif" width="18" height="19" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('◈')"><img src="sms_images/c3.gif" width="18" height="19" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('◆')"><img src="sms_images/c4.gif" width="18" height="19" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('◇')"><img src="sms_images/c5.gif" width="18" height="19" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('♥')"><img src="sms_images/c6.gif" width="18" height="19" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('♡')"><img src="sms_images/c7.gif" width="19" height="19" border="0"></a></td>
                                </tr>
                                <tr> 
                                  <td width="18"><a href="Javascript:add('●')"><img src="sms_images/c8.gif" width="19" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('○')"><img src="sms_images/c9.gif" width="18" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('▲')"><img src="sms_images/c10.gif" width="18" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('▼')"><img src="sms_images/c11.gif" width="18" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('▶')"><img src="sms_images/c12.gif" width="18" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('▷')"><img src="sms_images/c13.gif" width="18" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('◀')"><img src="sms_images/c14.gif" width="18" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('◁')"><img src="sms_images/c15.gif" width="19" height="17" border="0"></a></td>
                                </tr>
                                <tr> 
                                  <td width="18"><a href="Javascript:add('☎')"><img src="sms_images/c16.gif" width="19" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('☏')"><img src="sms_images/c17.gif" width="18" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('♠')"><img src="sms_images/c18.gif" width="18" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('♤')"><img src="sms_images/c19.gif" width="18" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('♣')"><img src="sms_images/c20.gif" width="18" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('♧')"><img src="sms_images/c21.gif" width="18" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('★')"><img src="sms_images/c22.gif" width="18" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('☆')"><img src="sms_images/c23.gif" width="19" height="17" border="0"></a></td>
                                </tr>
                                <tr> 
                                  <td width="18"><a href="Javascript:add('☞')"><img src="sms_images/c24.gif" width="19" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('☜')"><img src="sms_images/c25.gif" width="18" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('▒')"><img src="sms_images/c26.gif" width="18" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('⊙')"><img src="sms_images/c27.gif" width="18" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('㈜')"><img src="sms_images/c28.gif" width="18" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('№')"><img src="sms_images/c29.gif" width="18" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('㉿')"><img src="sms_images/c30.gif" width="18" height="17" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('♨')"><img src="sms_images/c31.gif" width="19" height="17" border="0"></a></td>
                                </tr>
                                <tr> 
                                  <td width="18"><a href="Javascript:add('™')"><img src="sms_images/c32.gif" width="19" height="18" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('℡')"><img src="sms_images/c33.gif" width="18" height="18" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('∑')"><img src="sms_images/c34.gif" width="18" height="18" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('∏')"><img src="sms_images/c35.gif" width="18" height="18" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('♬')"><img src="sms_images/c36.gif" width="18" height="18" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('♪')"><img src="sms_images/c37.gif" width="18" height="18" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('♩')"><img src="sms_images/c38.gif" width="18" height="18" border="0"></a></td>
                                  <td width="18"><a href="Javascript:add('♭')"><img src="sms_images/c39.gif" width="19" height="18" border="0"></a></td>
                                </tr>
                              </table>
                              <!-- 특수문자 -->
                            </td>
                          </tr>
						  <tr> 
							<td align=center><input type=image src="sms_images/bt_send.gif" width="70" height="19" border="0"></td>
						  </tr>
                        </table></td>
  </tr></form> 
</table>

</td>
  </tr>
</table>


</body>
</html>
