<?php
include ("../../../lib/cfg.common.php");
include ("../../../config/db_info.php");

include "../../../lib/class.database.php";
$dbcon = new database($cfg["sql"]);

include "../../../lib/class.common.php";
$common = new common();
/*
$sido = array("db_zip_seoul"=>"서울특별시", "db_zip_busan"=>"부산광역시", "db_zip_daegu"=>"대구광역시"
, "db_zip_incheon"=>"인천광역시", "db_zip_gwangju"=>"광주광역시", "db_zip_daejeon"=>"대전광역시"
, "db_zip_ulsan"=>"울산광역시", "db_zip_sejong"=>"세종특별자치시", "db_zip_gangwon"=>"강원도"
, "db_zip_gyeonggi"=>"경기도", "db_zip_gyeongsang_s"=>"경상남도", "db_zip_gyeongsang_n"=>"경상북도"
, "db_zip_jeolla_s"=>"전라남도", "db_zip_jeolla_n"=>"전라북도", "db_zip_jeju"=>"제주특별자치도"
, "db_zip_chungcheong_s"=>"충청남도", "db_zip_chungcheong_n"=>"충청북도");

*/

$sel_db = $_POST["sido"];
$sql = "select distinct(sigungu) from ".$sel_db." order by sigungu asc";
//echo $sql;
$rows = $dbcon->get_rows($sql);
echo json_encode($rows);
