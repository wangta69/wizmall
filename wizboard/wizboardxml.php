<?
include "../lib/cfg.common.php";

include ("../config/db_info.php");
include "../config/cfg.core.php";

include "../lib/class.database.php";
$dbcon		= new database($cfg["sql"]);

include "../lib/class.common.php";
$common = new common();
$cfg["member"] = $common->getLogininfo();//로그인 정보를 가져옮
$common->db_connect($dbcon);

include "../lib/class.board.php";
$board = new board();
$board->db_connect($dbcon);
$board->common($common);

include "../lib/class.xml.php";
$xml = new xmlcreate();

$board->boardname = "wizTable_root_board01";
$board->whereis = "";
$board->orderby = "";
$board->page_var["cp"] = 1;
$board->listcnt = 10;

$result = $board->getboardlist();
$cnt=0;
while($list = $dbcon->_fetch_array($result)):
	//$list = $dbcon->_fetch_assoc($result);
	$list = $board->listtrim($list);##현재의 리스트를 기준으로 필요한 필드를 처리한다.
	##listtrim은 기본적인 리스트 처리이고 별도로 할경우 상기 listtrim을 빼고 바로 작업하거나 별도의 함수를 생성하여 처리한다.
	$list["print_subject"] = $UID==$list["UID"]? "<font color='#FF0000'>".$list["print_subject"]."</font>":$list["print_subject"];
	$getdata="BID=".$BID."&GID=".$GID."&adminmode=".$adminmode."&optionmode=".$optionmode."&category=".$category."&mode=view&UID=".$list["UID"];
	$getdata.="&search_term=".$search_term."&SEARCHTITLE=".$SEARCHTITLE."&searchkeyword=".urlencode($searchkeyword);
	$getdata = $common->getencode($getdata);
	
	$item = array("name"=> $list["NAME"],
			"subject"=> $list["print_subject"],
			"wdate"=> date("Y.m.d", $list["W_DATE"])
			);
	$xml->addItem($item);
	
$cnt++;
endwhile;

$xml->outputXml();//xml 파일로 출력한다.
?>