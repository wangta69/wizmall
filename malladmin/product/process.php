<?php
include "../common/header_pop.php";

include "../../lib/class.wizmall.php";
$mall = new mall();
$mall->get_object($dbcon,$common);

if($action == 'qde' && $common -> checsrfkey($csrf)) {   //삭제옵션시 실행
	$multi = $_POST["multi"];
	foreach($multi as $key=>$value) $mall->deleteProduct($key);
}