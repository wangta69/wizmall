<?php
/*
 제작자 : 폰돌                     
 URL : http://www.shop-wiz.com      
 Email : master@shop-wiz.com       
 Copyright (C) 2003  shop-wiz.com 
****** Updating List ***********************
 2004 - 04 - 17 : hidden 값으로 category추가 
*/
?>
<html>
<script language=javascript>
function loginForm() {
        var chec=document.ADMIN_LOG;
        if ( !chec.MEMBERPASS.value.length ) {
        alert('\n패스워드를 입력해 주십시오. \n');
        return false;
        }
}
</script>
<body onload="javascript:document.ADMIN_LOG.MEMBERPASS.focus()";>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="522" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>

    <td>
      <table width="523" border="0" cellspacing="0" cellpadding="0">
	    <FORM ACTION='./wizboard/admin_log_check.php' METHOD='POST' NAME='ADMIN_LOG' onsubmit='return loginForm();'>
		<input type="hidden" name="BID" value="<?=$BID?>">
		<input type="hidden" name="GID" value="<?=$GID?>">
		<input type="hidden" name="Mode" value="MemberLogin">
		<input type="hidden" name="category" value="<?=$category?>">
		<input type="hidden" name="UID" value="<?=$UID?>">
		<input type="hidden" name="mode" value="<?=$mode?>">
		<input type="hidden" name="adminmode" value="<?=$adminmode?>">
		<input type="hidden" name="nmode" value="<?=$nmode?>">
		<input type="hidden" name="cp" value="<?=$cp?>">
		
          <tr> 

            <td width="192"><img src="./wizboard/images/admin_log_p.gif" width="192" height="172"></td>

          <td width="310" align="center" background="./wizboard/images/admin_log_bg1.gif"><table width="270" border="0" cellspacing="0" cellpadding="0">

              <tr>

                  <td><img src="./wizboard/images/admin_t.gif" width="140" height="18" hspace="10"></td>

              </tr>

              <tr>

                <td><table width="290" border="0" cellspacing="10" cellpadding="0">

                    <tr>

                        <td width="180" align="center" bgcolor="EFEBEF">

                        패스워드: 

                        <input name='MEMBERPASS' type='password' align="ABSMIDDLE" size=15 style='width:115px;color:#243224;font-weight:bold;'> 

                      </td>

                      <td width="52">
                          <input type='image' src="./wizboard/images/admin_login.gif" width="54" height="49">
                        </td>

                    </tr>

                  </table></td>

              </tr>

            </table></td>

            <td width="21"><img src="./wizboard/images/admin_log_bg2.gif" width="20" height="172"></td>

        </tr></FORM>

      </table></td>

  </tr>

</table><br>

<table align="center" cellpadding="0" cellspacing="0" width="530">

  <tr> 

          <td width="1102"> <p>* &nbsp;이곳은 게시판 관리자 영역입니다.<br>
              * &nbsp;게시판 관리자외에 접근할 수 없도록 비밀번호관리를 잘 하여주시기 바랍니다.<br>
              * &nbsp; <a href="http://www.shop-wiz.com" target="_blank"><font color="#006600">powered 
              by 숍위즈</font></a></p></td>

  </tr>

</table></td>
  </tr>
</table>
</body>
</html>
