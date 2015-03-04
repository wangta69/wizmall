<table width="100%" height="359" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="68" valign="top"><table width="670" height="68" border="0" cellpadding="0" cellspacing="0" background="/images/main/bg_tit.gif">
        <tr> 
          <td width="258"><img src="/images/member/tit_login.gif"></td>
          <td width="412" align="right">home &gt; 로그인</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td valign="top" style="padding-left:30px; padding-right:30px"><table width="95%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td>※회원 분들은 아래 로그인을 해주시기 바랍니다.</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td><table width="93%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="117" rowspan="2"><img src="/images/member/img_login.gif" width="117" height="120"></td>
                <td width="13" rowspan="2">&nbsp;</td>
                <td width="421"><img src="/images/member/top_login.gif" width="111" height="36"></td>
              </tr>
              <tr> 
                <td height="85" align="center" bgcolor="#F6F6F6"><table width="90%" border="0" cellspacing="0" cellpadding="0">
        <FORM method=post action='./wizmember/LOG_CHECK.php'>	
          <input type=hidden name=file value='<?=$file?>'>
          <!-- 파일명 : 일반적으로 뒤의 확장자 생략 -->
          <input type=hidden name=goto value='<?=$goto?>'>
          <!-- major 쿼리값 : 예, BID, -->
          <input type=hidden name=goto1 value='<?=$goto1?>'>
          <!-- major 쿼리값 : 예, GID, -->
          <input type=hidden name=hiddenvalue1 value='<?=$hiddenvalue1?>'>
          <!-- 기타쿼리값 : 예, mode, query, -->
          <input type=hidden name=hiddenvalue2 value='<?=$hiddenvalue2?>'>
          <!-- 기타쿼리값 : 예, mode, query, -->
          <input type=hidden name="log_from" value='<?=$HTTP_REFERER;?>'>                    
					<tr> 
                      <td width="46" style="padding-right:2px; padding-top:2px"><img src="/images/member/id.gif" width="43" height="17"></td>
                      <td width="159" style="padding-right:2px;"><input name="wizmemberID" type="text" id="wizmemberID" size="25" tabindex="1"></td>
                        <td width="61" rowspan="3"><input type="image" src="/images/common/button/btn_login3.gif" width="53" height="39" border="0"></td>
                      <td width="117" rowspan="3"><input type="checkbox" name="checkbox" value="checkbox" style="border:0">
                        id저장</td>
                    </tr>
                    <tr> 
                      <td colspan="2"></td>
                    </tr>
                    <tr> 
                      <td><img src="/images/member/pw.gif" width="43" height="17"></td>
                      <td><input name="wizmemberPWD" type="password" id="wizmemberPWD" size="25" tabindex="2"></td>
                    </tr></form>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td height="22"><img src="/images/common/bullet/red_dot.gif" width="3" height="3" align="absmiddle"> 
            아이디가 기억나지 않는 분은 <strong><a href="#"><u onclick="window.open('wizmember/yokuyoku/pop_id.php','','width=375,height=235')">여기</u></a></strong>를 
            클릭 해주세요.</td>
        </tr>
        <tr> 
          <td height="22"><img src="/images/common/bullet/red_dot.gif" width="3" height="3" align="absmiddle"> 
            비밀번호가 기억나지 않는 분은 <strong><a href="#"><u onclick="window.open('wizmember/yokuyoku/pop_pw.php','','width=375,height=235')">여기</u></a></strong>를 
            클릭 해주세요.</td>
        </tr>
        <tr> 
          <td height="22"><img src="/images/common/bullet/red_dot.gif" width="3" height="3" align="absmiddle"> 
            회원이 아니신 분들은 <strong><a href="/wizmember.php?query=regis_step1"><u>회원가입</u></a></strong>을 
            해주세요.</td>
        </tr>
        <tr> 
          <td><br> <br> </td>
        </tr>
      </table></td>
  </tr>
</table>
