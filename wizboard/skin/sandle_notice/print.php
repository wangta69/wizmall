<?
/* 
제작자 : 폰돌
스킨 : wizboard list skin 
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/

include "../../../lib/cfg.common.php";
include "../../../config/db_info.php";

include "../../../lib/class.database.php";
$dbcon		= new database($cfg["sql"]);

include "../../../lib/class.common.php";
$common = new common();

//일단 보안 관계상 막아두고 나중에 한번더 봐 두자
if(strlen($BOARD_NAME) > 30){
	echo "잘못된 접근입니다.";
	exit;
}

$BOARD_NAME="wizTable_${GID}_${BID}";

/* VIEW 내용을 DB에서 가져온다 */

$sqlstr="SELECT * FROM $BOARD_NAME where UID='$UID'";
$dbcon->_query($sqlstr);
$list=$dbcon->_fetch_array();
		$SPARE1 = split("\|", $list["SPARE1"]);
		$TxtType = $SPARE1[0];
			
		$CONTENTS = stripslashes($list["CONTENTS"]);
		$CONTENTS = $common->gettrimstr($CONTENTS, $TxtType);
?>
<html>
<head>
<title><?=$list["SUBJECT"];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>">
<style type="text/css">

<!--

td {  font-size: 9pt; color: #666666; line-height: 18px}

-->

</style>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="window.print();">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr> 
    <td bgcolor="BEBEBE" height="3" width="43%"></td>
  </tr>
  <tr bgcolor="EFEFEF"> 
    <td width="100%" height="27"><img src="img/bullets3.gif" width="7" height="7" hspace="3"> 
      <?=$list[SUBJECT];?>
    </td>
  </tr>
  <tr> 
    <td bgcolor="BEBEBE" height="1" width="100%" align="center"></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td width="100%" align="right">&nbsp;</td>
  </tr>
  <tr> 
    <td bgcolor="BEBEBE" height="1" width="100%" align="center"></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td width="100%"> <p>
        <?=$list[CONTENTS];?>
        <br>
      </p></td>
  </tr>
  <tr bgcolor="f5f5f5" align="right"> 
    <td width="100%">&nbsp; </td>
  </tr>
  <tr> 
    <td bgcolor="BEBEBE" height="1" width="43%" align="center"></td>
  </tr>
</table>
</body>
</html>
