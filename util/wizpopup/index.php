<?php
/*
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/

include "../../lib/cfg.common.php";
include "../../config/db_info.php";
include "../../config/cfg.core.php";

include "../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);







$sqlstr = "select * from wizpopup where uid=".$uid;
$dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array();
//$pskinname = "default_layer";//레이어 팝업 사용시 
if(!$list["pskinname"]) $pskinname = "default";
else $pskinname = $list["pskinname"];
$pattached = explode("|", $list["pattached"]);
$imgpath0 = trim($pattached[0])?"../../config/wizpopup/".$pattached[0]:"";




include "./".$pskinname."/index.php";
