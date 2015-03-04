<?php
/*
 * 
<html>
<head>
<title>관리자님을 환영합니다.[위즈보드 관리자모드]</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>">
<link rel="stylesheet" href="style.css" type="text/css">
<style type="text/css">
<!--

.style1 {font-family: "돋움", "굴림", "Verdana", "Arial"}
-->
</style>
<script language=javascript src="../js/button.js"></script>
<script language=javascript src="../js/SelectBox.js"></script>
</head>
<body>
<?
include "../config/db_info.php";
//./colum_mod.php?bid='+bid+'&uid='+uid+'&colum='+columname
$boardname="wizTable_${bid}";

if($query == "modify"){
	if($colum == "W_DATE"){
	$columvalue = mktime($w_hour, $w_minute, $w_second, $w_month, $w_day, $w_year);
	}
	$sqlstr = "update $boardname set $colum='$columvalue' where UID='$uid'";
	$dbcon->_query($sqlstr);
	echo "<script>opener.location.reload();self.close();</script>";
	exit;
}


$sqlstr = "select $colum from $boardname where UID='$uid'";
$dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array();
switch ($colum){
	case ("W_DATE"):

?>
<table cellspacing=0 bordercolordark=white width="100%" bgcolor=#c0c0c0 bordercolorlight=#dddddd border=1 class="s1">
<form name="modify_form" action="<?=$PHP_SELF?>" method="post">
<input type="hidden" name="query" value="modify">
<input type="hidden" name="bid" value="<?=$bid?>">
<input type="hidden" name="uid" value="<?=$uid?>">
<input type="hidden" name="colum" value="<?=$colum?>">
  <tr align="center" bgcolor="E0E4E8"> 
    <td width="0"> 
		<input name="w_year" type="text" size="4" maxlength="4" value="<? echo date("Y", $list[$colum])?>">년
		<input name="w_month" type="text" size="2" maxlength="2" value="<? echo date("m", $list[$colum])?>">월
		<input name="w_day" type="text" size="2" maxlength="2" value="<? echo date("d", $list[$colum])?>">일
		<input name="w_hour" type="text" size="2" maxlength="2" value="<? echo date("H", $list[$colum])?>">시
		<input name="w_minute" type="text" size="2" maxlength="2" value="<? echo date("i", $list[$colum])?>">분
		<input name="w_second" type="text" size="2" maxlength="2" value="<? echo date("s", $list[$colum])?>">초	  
	  </td>
  </tr>
  <tr bgcolor="#FFFFFF"onmouseover="style.background = '#E0E4E8'" onmouseout="style.background = '#FFFFFF'"> 
      <td height="30"align="center"><table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><script>nhnButton('수정','black9','javascript:submit();',4,0,'#565656','#FFFFFF','#C4C4C4','#ffffff','#ffffff','#ffffff')</script></td>
		  <td>&nbsp;</td>
		  <td><script>nhnButton('닫기','black9','javascript:self.close();',4,0,'#565656','#FFFFFF','#C4C4C4','#ffffff','#ffffff','#ffffff')</script></td>
        </tr>
      </table></td>

  </tr></form>
</table>
<?
	break;	
	default:
	break;
}
?>
</body>
</html>