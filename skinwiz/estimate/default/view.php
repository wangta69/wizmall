<html>
<head>
<title>실시간 온라인 견적</title>
<style>
<!--
A:link {text-decoration:none; color:BLACK;}
A:active {text-decoration:none; color:RED;}
A:visited {text-decoration:none; color:BLACK;}
A:hover {  text-decoration:none; color:RED;}
p,br,body,td {color:BLACK; font-size:9pt;font-family:굴림; line-height:140%;}
-->
</style>
</head>

<body>

<?
include ("../../config/db_info.php");
include ("../../config/cfg.core.php");
include "../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);


$sqlstr = "SELECT * FROM wizMall WHERE UID='$no'";
$dbcon->_query($sqlstr);
$VIEW_DATA = $dbcon->_fetch_array();

$UID = $VIEW_DATA[UID];
$PID = $VIEW_DATA[PID];
$NAME = stripslashes($VIEW_DATA[NAME]);
$COMPNAME = stripslashes($VIEW_DATA[COMPNAME]);
$CHECK = number_format($VIEW_DATA[CHECK]);
//$SAIL = number_format($VIEW_DATA[SAIL]);
$SIZE = $VIEW_DATA[SIZE];
$COLOR = $VIEW_DATA[COLOR];
$SMALLPIC = $VIEW_DATA[SMALLPIC];
$BIGPIC = $VIEW_DATA[BIGPIC];
$MOVIE = $VIEW_DATA[MOVIE];
$POINT = number_format($VIEW_DATA[POINT]);
$OPTI = $VIEW_DATA[OPTI];
$NONE = $VIEW_DATA[NONE];
$GET = $VIEW_DATA[GET];
$PUT = $VIEW_DATA[PUT];
$DATE = $VIEW_DATA[DATE];
//$SHORTCON = stripslashes($VIEW_DATA[SHORTCON]);
$LONGCON = stripslashes($VIEW_DATA[LONGCON]);
$CATEGORY = $VIEW_DATA[CATEGORY];
$MODEL = stripslashes($VIEW_DATA[MODEL]);
if (!$VIEW_DATA[LHTML]) {
$LONGCON = nl2br($LONGCON);
}
$HIT = $VIEW_DATA[HIT] + 1;

if (($GET && $GET <= $PUT) || $NONE == 'checked' ) {
	ECHO "<Script language=javascript>
	window.alert('\\n\\n품절된 제품입니다.. 관리자에게 문의하십시오.\\n\\n');
	history.go(-1);
	</script>";
	exit;
}

// 조회수를 증가시킨다.
$sqlstr = "UPDATE wizMall SET HIT = '$HIT' WHERE UID='$no'";
$dbcon->_query($sqlstr);

if (file_exists("../../upload/$BIGPIC") && $BIGPIC) {
	$Vpic_size = GetImageSize("../../upload/$BIGPIC");
	$VPIC_FILE = "../../upload/$BIGPIC";
}
?>


<div>
<table>
<tr>
<td colspan=2 background='../../../mall_image/list_line.gif'> </td>
</tr>
<tr>
<td colspan=20> </td>
</tr>
</table>


<table>
<tr>
<td>
<a href='#' onclick="javascript:window.open('./picview.php?file=<?ECHO"$VPIC_FILE";?>&subject=<?ECHO"$NAME";?>', 'kimsmall','width=<?ECHO"$Vpic_size[0]";?>,height=<?ECHO"$Vpic_size[1]";?>,statusbar=no,scrollbars=no,toolbar=no,resizable=no')"><img src='../../upload/<?ECHO"$SMALLPIC";?>'></a>
<p>

<a href='#' onclick="javascript:window.open('./picview.php?file=<?ECHO"$VPIC_FILE";?>&subject=<?ECHO"$NAME";?>', 'kimsmall','width=<?ECHO"$Vpic_size[0]";?>,height=<?ECHO"$Vpic_size[1]";?>,statusbar=no,scrollbars=no,toolbar=no,resizable=no')"><img src='../../../mall_image/co_zoom.gif'></a>
<?
if ($MOVIE) {
	ECHO "<a href='../../upload/$MOVIE'><img src='../../../mall_image/co_movie.gif'></a>";
}
?>

</td>
<td background='../../../mall_image/vline1.gif'><img src='../../../mall_image/blank.gif'></td>
<td><img src='../../../mall_image/blank.gif'></td>
<td>

<table>
<tr>
<td colspan=2><?ECHO"$NAME $MODEL";?></td>
</tr>

<tr>
<td colspan=2>판매가격 : <?ECHO"$CHECK";?>원</td>
</tr>
<tr>
<td colspan=2 background='../../../mall_image/list_line.gif'> </td>
</tr>
<tr>
<td colspan=2> </td>
</tr>

<tr>
<td>제조사</td><td>: <?ECHO"$COMPNAME";?></td>
</tr>
<tr>
<td>적립금</td><td>: <?ECHO"$POINT";?>포인트</td>
</tr>

<?if ($SIZE) :?>
<?$SIZE_DATA = explode("\n", $SIZE);?>
<tr>
<td>옵션</td><td>: <SELECT name=SIZE>
<?
if (eregi("=", $SIZE)) {

	ECHO "<OPTION VALUE=''>기본옵션 적용</OPTION>
	<OPTION VALUE=''>--------------</OPTION>";

	for($i = 0; $i < sizeof($SIZE_DATA) && chop($SIZE_DATA[$i]); $i++) {
		$SIZE_DATA_SPL = explode("=", chop($SIZE_DATA[$i]));
		ECHO "<OPTION VALUE='".chop($SIZE_DATA[$i])."'>".$SIZE_DATA_SPL[0]." (".number_format($SIZE_DATA_SPL[1])."원추가)</OPTION>";
	}
}
else {
	for($i = 0; $i < sizeof($SIZE_DATA) && chop($SIZE_DATA[$i]); $i++) {
		ECHO "<OPTION VALUE='".chop($SIZE_DATA[$i])."'>".chop($SIZE_DATA[$i])."</OPTION>";
	}
}
?>
</SELECT>
</td>
</tr>
<?endif;?>

<?if ($COLOR) :?>
<?$COLOR_DATA = explode("\n", $COLOR);?>
<tr>
<td>색상</td><td>: <SELECT name=COLOR>
<?
for($i = 0; $i < sizeof($COLOR_DATA) && chop($COLOR_DATA[$i]); $i++) {
	ECHO "<OPTION VALUE='".chop($COLOR_DATA[$i])."'>".chop($COLOR_DATA[$i])."</OPTION>";
}
?>
</SELECT>
</td>
</tr>
<?endif;?>

<tr>
<td colspan=2> </td>
</tr>
<tr>
<td colspan=2 background='../../../mall_image/list_line.gif'> </td>
</tr>
<tr>
<td colspan=25> </td>
</tr>
<tr>
<td colspan=2><br /><br /><FORM><input type="button" VALUE=' Close This Window ' onclick='javascript:self.close();'> </form> </td>
</tr>
</table>


</td>
</tr>
</table>


<p>


<table>
<tr>
<td colspan=2>
&nbsp;상품 상세설명
</td>
</tr>

<tr>
<td colspan=2 background='../../../mall_image/list_line.gif'> </td>
</tr>
<tr>
<td colspan=20> </td>
</tr>
</table>

<table>
<tr>
<td>
<p>
<?ECHO "$LONGCON";?>
<p>
</td>
</tr>
</table>

</DIV>







</body>
</html>
