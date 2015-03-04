<?
include "../../config/db_info.php";
include "../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);

include "../../config/yokuconfig.php";
include "../../wizboard/func/yokufnc.php";

function alert_msg($msg)
  {
    echo "<script language='javascript'>alert('$msg'); close();</script>";
    exit;
  }

if ($_COOKIE[MEMBER_ID]) {
    alert_msg("이미 로그인중이므로 정보수정에서 변경하십시오."); 
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>++ 아이디 찾기 ++</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" type="text/css" href="/common/css/css.css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="375" height="235" border="0" cellpadding="0" cellspacing="0">
<form name=mbidforget method=post action='pop_id2.php' autocomplete=on>
  <tr> 
    <td height="4" colspan="4" bgcolor="#111111"></td>
  </tr>
  <tr> 
    <td width="24">&nbsp;</td>
    <td width="207" height="60"><img src="/images/member/pop_id.gif"></td>
    <td width="120" align="right"><img src="/images/member/pop_logo.gif" width="79" height="60"></td>
    <td width="24">&nbsp;</td>
  </tr>
  <tr> 
    <td rowspan="3">&nbsp;</td>
    <td height="103" colspan="2" bgcolor="#f6f6f6"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="32%" style="padding-left:15px">이름</td>
          <td width="64%"><input name="mb_name" type="text" id="mb_name" size="27"></td>
          <td width="4%">&nbsp;</td>
        </tr>
        <tr> 
          <td style="padding-left:15px">주민등록번호</td>
          <td> <input name="mb_jumin1" type="text" id="mb_jumin1" size="10" maxlength="6">
            - 
            <input name="mb_jumin2" type="password" id="mb_jumin2" size="13" maxlength="7"> 
          </td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
    <td rowspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td height="20" colspan="2" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="48" colspan="2" align="center" valign="top"><input type="image" src="/images/common/button/btn_next.gif" width="70" height="19" border="0"></td>
  </tr></form>
</table>
</body>
</html>
