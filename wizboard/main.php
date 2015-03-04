<?php
include "../lib/cfg.common.php";
if (!$_COOKIE["BOARD_PASS"] && !$_COOKIE["ROOT_PASS"]) :
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>관리자님 환영합니다. [위즈보드 관리자 페이지]</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>">
<link rel="stylesheet" type="text/css" href="../css/base.css" /> 
<link rel="stylesheet" href="../css/admin.board.css" type="text/css">

<script type="text/javascript" src="../js/jquery.min.js"></script>
</head>
<script>

function loginForm() {
    var chec=document.ADMIN_LOG;
    if ( !chec.ADMINID.value.length ) {
        alert('\n아이디를 입력해 주십시오. \n');
        return false;
	}else if ( !chec.ADMINPASS.value.length ) {
        alert('\n패스워드를 입력해 주십시오. \n');
        return false;
    }
}
</script> 
<body onLoad="document.forms[0].ADMINID.focus();">
<script language="JavaScript" src="http://www.shop-wiz.com/register_check.js"></script>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><table width="522" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <table width="523" border="0" cellspacing="0" cellpadding="0">
	    <FORM ACTION='./admin_log_check.php' METHOD='POST' NAME='ADMIN_LOG' onsubmit='return loginForm();'>
          <tr> 
            <td width="192"><img src="images/admin_log_p.gif" width="192" height="172"></td>
          <td width="310" align="center" background="images/admin_log_bg1.gif"><table width="270" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td><img src="images/admin_t.gif" width="140" height="18" hspace="10"></td>
              </tr>
              <tr>
                <td><table width="290" border="0" cellpadding="0" cellspacing="10" class="text-admin">
                    <tr>
                      <td width="180" align="center" bgcolor="EFEBEF">아이디 &nbsp;&nbsp;: 
                        <input type=TEXT name=ADMINID align=ABSMIDDLE size=15 style='width:115px;color:#243224;font-weight:bold;' tabindex=1> 
                        <br>
                        패스워드: 
                        <input name='ADMINPASS' type='password' align=ABSMIDDLE size=15 style='width:115px;color:#243224;font-weight:bold;' tabindex=2> 
                      </td>
                      <td width="52">
                          <input type='image' src="images/admin_login.gif" width="54" height="49" tabindex=3>
                        </td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
            <td width="21"><img src="images/admin_log_bg2.gif" width="20" height="172"></td>
        </tr></FORM>
      </table></td>
  </tr>
</table><br>
<table width="530" align="center" cellpadding="0" cellspacing="0" class="text-admin">
  <tr> 
    <td width="1102"> 
      <p>* &nbsp;이곳은 게시판 관리자 영역입니다.<br>
        * &nbsp;관리자외에 접근할 수 없도록 비밀번호관리를 잘 하여주시기 바랍니다.<br>
		* &nbsp; <a href="http://www.shop-wiz.com" target="_blank"><font color="#006600">powered 
              by 숍위즈</font></a></p></td>
  </tr>
</table>&nbsp;</td>
  </tr>
</table>

</body>
</html>
<?
else :
echo "<script>window.location.href='admin.php'; </script>" ;
endif;
?>