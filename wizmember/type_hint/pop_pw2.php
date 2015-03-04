<?
include "../../config/db_info.php";
include "../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);

include "../../config/yokuconfig.php";
include "../../wizboard/func/yokufnc.php";

$sqlstr = " select ID, PWDHint from wizMembers where ID = '$_POST[pass_mb_id]' ";
$dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array();
if (!$list[mb_id]) {
    alert("존재하지 않는 회원아이디 입니다.");
}
# else if (is_admin($list[mb_id])) {
#    alert("접근이 불가능한 아이디입니다.");
#}

$mb_id = $list[mb_id];
$mb_passwd_q = $list[mb_passwd_q];
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
<form name=mbpasswdforget2 method=post action='pop_pw3.php' autocomplete=off>
<input type=hidden name=pass_mb_id value='<?=$pass_mb_id?>'>
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
        <tr> 
          <td width="45%" align="center">비밀번호 분실시 질문 : </td>
          <td width="55%"><strong>[<?=$mb_passwd_q?>]</strong></td>
        </tr>
        <tr> 
          <td align="center">비밀번호 분실시 답변 :</td>
          <td><input name="mb_passwd_a" type="text" id="mb_passwd_a"></td>
        </tr>
      </table></td>
    <td rowspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td height="20" colspan="2" valign="top">&nbsp;</td>
  </tr>
  <tr> 
      <td height="46" colspan="2" align="center" valign="top"><input type="image" src="/images/common/button/btn_next.gif" width="70" height="19" border="0"> 
      </td>
  </tr></form>
</table>
</body>
</html>
