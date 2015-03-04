<?php
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
 * DEPERECATE
*** Updating List ***


include "../lib/cfg.common.php";
include "../config/db_info.php";
//$BOARD_NAME="wizTable_${AdminBID}";

include "../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);

include "../lib/class.common.php";
$common = new common();
$common->db_connect($dbcon);

include "../lib/class.board.php";
$board = new board();
$board->get_object($dbcon, $common);


$config_include_path = "../config/wizboard/table/$GID/$BID";
include $config_include_path."/config.php";#보드관련 세부 config 관련 정보
$board->cfg = $cfg;//환경설정 파일들을 입력한다.


if($mode==ok) {
	if($UID=='') $common->js_windowclose("잘못된 경로의 접근입니다.");
	$board->delete_content($UID, $BID, $GID);
	$goto = "$Goto?AdminBID=$AdminBID&cp=$cp&$menu=show&theme=boardadmin";
	$common->js_windowclose("게시물을 삭제했습니다.", $goto);
}
$str	= "정말로 삭제하시겠습니까?";
$goto	= $PHP_SELF."?UID=".$UID."&cp=".$cp."&SUB_cp=".$SUB_cp."&AdminBID=".$AdminBID."&ListCount=".$ListCount."mode=ok&Goto=".$Goto."&menu=".$menu."&theme=".$theme."&CP=".$CP;
$act	= "self.close();";
$common->js_confirm($str, $goto, $act="history.go(-1);");
*/