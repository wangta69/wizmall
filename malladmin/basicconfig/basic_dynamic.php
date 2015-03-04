<?
include ("../../lib/cfg.common.php");
include "../../config/db_info.php";


include ("../../lib/class.database.php");
$dbcon		= new database($cfg["sql"]);

include "../../lib/class.common.php";
$common = new common();
$common->db_connect($dbcon);
$common->pub_path = "../../";
$cfg["member"] = $common->getLogininfo();//로그인 정보를 가져옮


include "../../lib/class.wizmall.php";
$mall = new mall();
$mall->db_connect($dbcon);

include "../../lib/class.admin.php";
$admin = new admin();
$admin->get_object($dbcon, $common, $mall);

include "../AUTH_CHECK.php";

if($flag == "1"){//제품당 카테고리 초기화
	$result	= $mall->resetPdCnt();
	$rtn["result"]	= "0";
	echo json_encode($rtn);
}
?>