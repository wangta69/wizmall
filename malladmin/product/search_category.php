<?php
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/
include "../common/header_pop.php";
include "../../lib/class.xml.php";
$xml_c = new xmlcreate();


if($step == "1"){//2차 분류 가져오기
	$sqlstr = "SELECT cat_no, cat_name FROM wizCategory WHERE LENGTH(cat_no) = 6 AND RIGHT(cat_no, 3) = '".$value."' and cat_flag = 'wizmall' ORDER BY cat_order ASC";
}elseif($step == "2"){//3차분류 가져오기
	$sqlstr = "SELECT cat_no, cat_name FROM wizCategory WHERE LENGTH(cat_no) = 9 AND RIGHT(cat_no, 6) = '".$value."' and cat_flag = 'wizmall' ORDER BY cat_order ASC";
}
	$dbcon->_query($sqlstr);
	while($list = $dbcon->_fetch_array()):
		$cat_no = $list["cat_no"];
		$cat_name = htmlentities($list["cat_name"]);
		$item = array("item"=>array("cat_no"=> $cat_no,"cat_name"=> $cat_name));
		$xml_c->addItem($item);
	endwhile;

$xml_c->outputXml();//xml 파일로 출력한다.
