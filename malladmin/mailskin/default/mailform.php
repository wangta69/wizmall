<?
include "../../../lib/cfg.common.php";
include "../../../config/cfg.core.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>">
</head>

<body leftmargin="0" topmargin="0">
<table width="574" height="440" border="0" cellpadding="0" cellspacing="0" background="{MART_BASEDIR}/mail/img/mail_bg.gif">
  <tr>
    <td align="center" valign="top"><table width="80%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="100">&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr height="1" > 
                <td height="1" align="center" bgcolor="#CCCCCC"></td>
              </tr>
              <tr> 
                <td height="20" align="center">&nbsp;</td>
              </tr>
              <tr> 
                <td align="center">{CONTENTS}</td>
              </tr>
              <tr> 
                <td height="20" align="center">&nbsp;</td>
              </tr>
              <tr height="1" > 
                <td height="1" align="center" bgcolor="#CCCCCC"></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
