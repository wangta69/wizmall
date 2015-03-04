 <?
include "../../../config/db_info.php";
include "../../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);

$BOARD_NAME="wizTable_${BID}";

/* VIEW 내용을 DB에서 가져온다 */

$SELECT_STR="SELECT * FROM $BOARD_NAME where UID='$UID'";
$SELECT_QRY=$dbcon->_query($SELECT_STR);
$LIST=$dbcon->_fetch_array($SELECT_QRY);
$LIST[CONTENTS]=stripslashes($LIST[CONTENTS]);
$LIST[CONTENTS]=nl2br($LIST[CONTENTS]);
?>

<html>

<head>

<title>WizBoard Printing View</title>

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

                  <?=$LIST[SUBJECT];?></td>

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

                <td width="100%"> 

                  <p><?=$LIST[CONTENTS];?><br>

                  </p>

                </td>

              </tr>

              <tr bgcolor="f5f5f5" align="right"> 

                

    <td width="100%">&nbsp; </td>

              </tr>

              <tr> 

                <td bgcolor="BEBEBE" height="1" width="43%" align="center"></td>

              </tr>

            </table>