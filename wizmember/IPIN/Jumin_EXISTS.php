<?php
/**
 * 주민번호 폐지로 인해 더이상 사용하지 않을 예정

include "../../lib/cfg.common.php";
include "../../lib/cfg.core.php";
include ("../../config/db_info.php");

include "../../lib/class.database.php";
$dbcon		= new database($cfg["sql"]);

include "../../lib/class.common.php";
$common = new common();
//$common->db_connect($dbcon);

$sqlstr = "SELECT UID FROM wizMembers WHERE Jumin1='$jumin1' and Jumin2='$jumin2'";
$result = $dbcon->get_one($sqlstr);
if ( $result ) {
	$msg = "${jumin1}-${jumin2} 는 이미 사용중인 주민번호입니다.";
	$common->js_windowclose($msg);
}else{ 
	$msg = "${jumin1}-${jumin2} 는 사용가능한 주민번호입니다.";
	$common->js_windowclose($msg);
}
 */