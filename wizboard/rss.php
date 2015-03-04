<?php
include "../lib/inc.depth1.php";

include "../lib/class.board.php";
$board = new board();
$board->get_object($dbcon, $common);

include "../lib/class.xml.php";
$xml_c = new xmlcreate();

if(!$listcnt) $listcnt = 10;

$tablename = "wizTable_".$gid."_".$bid;
$sqlstr = "select UID, SUBJECT, CONTENTS, W_DATE from $tablename where THREAD='A' order by UID asc limit 0, $listcnt";
$sqlqry = $dbcon->_query($sqlstr);
while($list = $dbcon->_fetch_array($sqlqry)):
	$title = iconv("EUC-KR", "UTF-8", $list["SUBJECT"]);
	$uid = $list["UID"];
	$link = "http://".$_SERVER['HTTP_HOST']."/wizboard.php?BID=".$bid."&GID=".$gid."&UID=".$uid."&mode=view";
	$guid = "http://".$_SERVER['HTTP_HOST']."/wizboard.php?BID=".$bid."&GID=".$gid."&UID=".$uid."&mode=view";
	$description = iconv("EUC-KR", "UTF-8", $common->strCutting(str_replace("\n", "",$list["CONTENTS"]), 50));
	$pubDate = date("Y-m-d", $list["W_DATE"]);
	//$item = array("item"=>array("title"=> "<![CDATA[".$title."]]>","link"=> $link,"guid"=> $guid,"description"=> "<![CDATA[".$description."]]>","pubDate"=> $pubDate));
	$item = array("item"=>array("title"=> $title,"link"=> $link,"guid"=> $guid,"description"=> $description,"pubDate"=> $pubDate));
	$xml_c->addItem($item);
endwhile;


$xml_c->printheadenable = true;//title등을 넣을 경우 (rss용)
$xml_c->title = $_SERVER['HTTP_HOST'];
$xml_c->link = "http://".$_SERVER['HTTP_HOST'];
$xml_c->description = "free solution";
$xml_c->language = "ko";
$xml_c->copyright = "Copyright(c) Shop-wiz.com. All Rights Reserved.";

$xml_c->outputXml();//xml 파일로 출력한다.