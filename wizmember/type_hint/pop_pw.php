<?
include "../../config/db_info.php";
include "../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);

include "../../config/yokuconfig.php";
include "../../wizboard/func/yokufnc.php";

if ($_COOKIE[MEMBER_ID]) {
    alert("이미 로그인중이므로 정보수정에서 변경하십시오."); 
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>++ 비밀번호 찾기 ++</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" type="text/css" href="/common/css/css.css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="375" height="235" border="0" cellpadding="0" cellspacing="0">
 <form name=mbpasswdforget method=post action='pop_pw2.php' autocomplete=on>
  <tr> 
    <td height="4" colspan="4" bgcolor="#111111"></td>
  </tr>
  <tr> 
    <td width="24">&nbsp;</td>
    <td height="60"><img src="/images/member/pop_pw.gif"></td>
    <td align="right"><img src="/images/member/pop_logo.gif" width="79" height="60"></td>
    <td width="24">&nbsp;</td>
  </tr>
  <tr> 
    <td rowspan="3">&nbsp;</td>
    <td height="103" colspan="2" bgcolor="#f6f6f6"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr align="center"> 
          <td height="30" colspan="2">※ 회원아이디를 입력해 주십시오.</td>
        </tr>
        <tr> 
          <td width="30%" align="right" style="padding-left:15px"><img src="/images/member/id.gif" width="43" height="17" hspace="2"></td>
          <td width="70%"><input name="pass_mb_id" type="text" id="pass_mb_id" size="27"></td>
        </tr>
      </table></td>
    <td rowspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td height="20" colspan="2" valign="top">&nbsp;</td>
  </tr>
  <tr>
      <td height="46" colspan="2" align="center" valign="top"> <input type="image" src="/images/common/button/btn_next.gif" width="70" height="19" border="0"></td>
  </tr></form>
</table>
</body>
</html>
