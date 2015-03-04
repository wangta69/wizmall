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
  
$sqlstr = " select ID, PWDAnswer, Email from wizMembers where ID = '$_POST[pass_mb_id]' ";
$dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array();
if (!$list[ID]) {
    alert("존재하지 않는 회원아이디 입니다.");
} else if ($mb_passwd_a != $list[PWDAnswer]) {
    alert_msg("비밀번호 분실시 질문에 대한 답변이 틀립니다.");
}# else if (is_admin($mb[mb_id])) {
#    alert("접근이 불가능한 아이디입니다.");
#}

$change_passwd = substr(md5(get_microtime()), 0, 5);
$sql = " update wizMembers
            set PWD = password('$change_passwd')
          where ID = '$list[ID]' ";
sql_query_error($sql);

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
          <td width="45%" align="center">변경된 비밀번호는 <font color="#FF6600"><strong><?=$change_passwd?></strong></font> 
            입니다. <br>
            회원 로그인 후 반드시 <strong>변경</strong>해 주십시오. </td>
        </tr>
      </table></td>
    <td rowspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td height="20" colspan="2" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td height="46" colspan="2" align="center" valign="top"><a href="#" onclick="window.close()"><img src="/images/common/button/btn_close.gif" width="70" height="19" border="0"></a></td>
  </tr>
</table>
</body>
</html>
