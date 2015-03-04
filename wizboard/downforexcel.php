<?php
if ($DownForExel == "yes") {
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=wizboard.xls");
	header("Content-Description: PHP4 Generated Data");
}

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include "../lib/inc.depth1.php";

//로그인 책크 부분 시작
$common -> pub_path = "../";
$cfg["member"] = $common -> getLogininfo();
//로그인 정보를 가져옮
include ("./admin_check.php");
// 로그인 책크 부분 끝

include "../lib/class.board.php";
$board = new board();
$board -> get_object($dbcon, $common);
?>
<table>
	<col width="150px" />
	<col width="150px" />
	<col width="150px" />
	<col width="150px" />
	<col width="150px" />
	<tr>
		<td>테이블명</td>
		<td>테이블설명</td>
		<td>패스워드</td>
		<td>소속그룹</td>
		<td>적용스킨</td>
	</tr>
<?php
if($Grp) $WHERE = "WHERE Grade != 'A' AND Grp='$Grp'";
else $WHERE = "WHERE Grade != 'A' ";
if($SEARCHTITLE && $searchkeyword) $WHERE .= "and $SEARCHTITLE like '%$searchkeyword%'";
$TargetBoard = "wizTable_Main";

$SELECT_STR="SELECT * FROM $TargetBoard $WHERE ORDER BY BID ASC";
$SELECT_QRY=mysql_query($SELECT_STR);
while($BOARD_LIST=@mysql_fetch_array($SELECT_QRY)):
include "../config/wizboard/table/$BOARD_LIST[GID]/$BOARD_LIST[BID]/config.php";
$groupstr = "select GrpName from wizTable_Grp where GrpCode = '$BOARD_LIST[Grp]'";
$groupqry = mysql_query($groupstr);
$GrpName = @mysql_result($groupqry, 0, 0);
?>
	<tr>
		<td><?php echo $BOARD_LIST["BID"]; ?></td>
		<td><?php echo $common -> conv_euckr($BOARD_LIST["BoardDes"]); ?></td>
		<td><?php echo $BOARD_LIST["Pass"]; ?></td>
		<td><?php echo $GrpName; ?></td>
		<td><?php echo $cfg["wizboard"]["BOARD_SKIN_TYPE"]; ?></td>
	</tr>
<?php
	endwhile;
?>
</table>
