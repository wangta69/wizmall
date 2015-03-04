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

if($step == "2"){
	$sqlstr = "SELECT cat_no, cat_name FROM wizCategory WHERE LENGTH(cat_no) = 6 AND RIGHT(cat_no, 3) = '".$trigger."' and cat_flag = 'wizmall' ORDER BY cat_order ASC";
	$str = "중분류";
	$target = $target ? $target:"Category2";
	
}elseif($step == "3"){
	$sqlstr = "SELECT cat_no, cat_name FROM wizCategory WHERE LENGTH(cat_no) = 9 AND RIGHT(cat_no, 6) = '".$trigger."' and cat_flag = 'wizmall' ORDER BY cat_order ASC";
	$str = "소분류";
	$target = $target ? $target:"Category3";
}

$dbcon->_query($sqlstr);
$length = $dbcon->_num_rows()+1;

header("Content-Type: application/x-javascript");
echo "document.forms['$form'].elements['$target'].length = $length; \n";
	echo "document.forms['$form'].elements['$target'].options[0].text = '$str'; \n";
	echo "document.forms['$form'].elements['$target'].options[0].value = ''; \n";
$i=1;	
while($list = $dbcon->_fetch_array()):
	echo "document.forms['$form'].elements['$target'].options[$i].text = '$list[cat_name]'; \n";
	echo "document.forms['$form'].elements['$target'].options[$i].value = '$list[cat_no]'; \n";
$i++;
endwhile;
echo "document.forms['$form'].elements['$target'].options[0].selected = true; \n";

function resetField($form, $claretarget, $targetstr){
	echo "document.forms['$form'].elements['$claretarget'].length = 1; \n";
	echo "document.forms['$form'].elements['$claretarget'].options[0].text = '$targetstr'; \n";
	echo "document.forms['$form'].elements['$claretarget'].options[0].value = ''; \n";
}

if($step == "2"){
	resetField($form, $claretarget="Category3", $targetstr="소분류");
}