<?
include "../../config/db_info.php";
include "../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);

include "../../config/yokuconfig.php";
include "../../wizboard/func/yokufnc.php";


if ($_COOKIE[MEMBER_ID]) {
    alert_msg("이미 로그인중이므로 정보수정에서 변경하십시오."); 
}

$sqlstr = " select Name, ID from wizMembers where Name = '$mb_name' and (jumin = PASSWORD('$mb_jumin1$mb_jumin2') or (Jumin1='$mb_jumin1' and Jumin2='$mb_jumin2'))";
$dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array();

if (!$list[ID]) {
  $result_msg = "<b>죄송합니다.</b><br>회원님의 정보를 찾을수 없습니다.<br>입력사항을 정확히 입력하신후 다시한번 시도해 주세요.";
} else 
  $result_msg = "요청하신 "."$list[Name]"."님의 요꾸요꾸 아이디는<br><font color=#FF6600><b>"."$list[ID]"." </b></font>로 확인되었습니다";
  

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" type="text/css" href="/common/css/css.css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="375" height="235" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="4" colspan="4" bgcolor="#111111"></td>
  </tr>
  <tr> 
    <td width="24">&nbsp;</td>
    <td height="60"><img src="/images/member/pop_id.gif"></td>
    <td align="right"><img src="/images/member/pop_logo.gif" width="79" height="60"></td>
    <td width="24">&nbsp;</td>
  </tr>
  <tr> 
    <td rowspan="3">&nbsp;</td>
    <td height="103" colspan="2" bgcolor="#f6f6f6"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="32%" align="center"><?=$result_msg?> </td>
        </tr>
      </table></td>
    <td rowspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td height="20" colspan="2" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td height="46" colspan="2" align="center" valign="top"><a href="pop_id.php"><img src="/images/common/button/btn_pre.gif" width="70" height="19" border="0"></a> 
      <a href="#" onclick="window.close()"><img src="/images/common/button/btn_close.gif" width="70" height="19" border="0"></a></td>
  </tr>
</table>
</body>
</html>
