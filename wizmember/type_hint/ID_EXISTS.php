<?
include "../../lib/cfg.common.php";
include ("../../config/db_info.php");
include "../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);


$sqlstr = "SELECT UID FROM wizMembers WHERE ID='$id'";
$dbcon->_query($sqlstr);

if(!$id) {
	$message = "id를 입력해 주세요";
	$status = "false";
}
else if((strlen($id) > 12) || (strlen($id) < 4)) {
	$message = "아이디는 4~12자 사이의 영문숫자 혼합으로 구성되어야 합니다.";
	$status = "false";
}
else if ( $dbcon->_fetch_array($sqlqry) ) {
	$message = "<font color=red>$id</font> 는 이미 사용중인 아이디입니다.";
	$status = "false";
}
else {
	$message="<font color=red>$id</font>은(는) 사용가능한 ID입니다.";
	$status = "true";
}
mysql_close();
?>
<html><head><title>ID 체크</title>
<style type='text/css'>
<!--
body, table, tr, td{  font-family: '굴림', '돋움'; font-size: 9pt}
-->
</style>
<script language="javascript" src="../../js/button.js"></script>
<script language="JavaScript">
<!--
function setting(id) {
opener.document.FrmUserInfo.ID.value = id;
self.close();
}

function searching() {
var f = document.idexistform;
location.href="<?$PHP_SELF?>?id="+f.id.value;
}
-->
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="470" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td><img src="img_ID_EXISTS/top.gif" width="470" height="52"></td>
  </tr>
  <form name="idexistform">
  <input type=hidden name=action value=user_idcheck>
      <tr> 
      <td height="20"></td>
    </tr>
    <tr> 
      <td align="center">
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td> <font size=2 face=돋움><b>아이디</b></font> 
        <input type=text name=id value="<?=$id?>" size=15></td>
            <td>&nbsp;</td>
            <? if($status == "true") : ?><td><script>nhnButton('적용','black9','javascript:setting("<?=$id?>");',4,0,'#565656','#FFFFFF','#C4C4C4','#ffffff','#ffffff','#ffffff')</script></td>
            <? endif; ?><td>&nbsp;</td>
			<td><script>nhnButton('검색','black9','javascript:searching();',4,0,'#565656','#FFFFFF','#C4C4C4','#ffffff','#ffffff','#ffffff')</script></td>
            
          </tr>
        </table>
</td>
    </tr>
    <tr> 
      <td height="5"></td>
    </tr>
    <tr> 
      <td height="1" bgcolor="#999999"></td>
    </tr>
    <tr> 
      <td height="5"></td>
    </tr>
    <tr>
      <td align="center"> 
        <?=$message?>
      </td>
    </tr>
  </form>
</table>


</body></html>
<?
exit;

?>