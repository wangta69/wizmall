<?
/*
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/

include "../lib/class.statistics.php";
$sta = new statistics();
$sta->get_object($dbcon, $common);


$listNo = "15";
$PageNo = "20";
if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $listNo;


/*





if (!$sorting) {$sorting = "hit";}
if ($sort) {
if(strlen($sort)==6) $cat_query = substr($sort,4);
		else $cat_query=$sort;
        if ($sort1) {$cat_query = substr($sort,2);}
        if ($sort2) {$cat_query = $sort2;}
        $WHERE = "WHERE Category LIKE '%$cat_query' AND hit > 0";} else {$WHERE = "WHERE hit > 0";
}


  ##페이징과 관련된 수식 구하기 
$listNo = "15";
$PageNo = "20";
if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $listNo;
$TOTAL_STR = "SELECT count(*) FROM wizMall $WHERE";
$TOTAL = $dbcon->get_one($TOTAL_STR);


## 현재 등록된 제품에 대한 총 판매액을 표시한다.
$LIST_QUERY = "SELECT * FROM wizMall $WHERE ORDER BY $sorting DESC LIMIT $START_NO,$listNo";
$TABLE_DATA = $dbcon->_query($LIST_QUERY);
//$TOTAL_DATA = $dbcon->_fetch_array($dbcon->_query("SELECT sum(Hit) as hit, sum(Output)as tqty, sum(Output*Price) as tmount, count(*) as count FROM wizMall", $DB_CONNECT));

## 판매된 제품을 기준으로 하여 판매량과 금액등을 가져온다. 
$sqlstr = "select sum(TotalAmount) from wizBuyers WHERE OrderStatus = 50";
$OutPutTotalPrice = $dbcon->get_one($sqlstr);

$sqlstr = "select c.pid from wizCart c left join wizBuyers b on c.oid = b.OrderID WHERE b.OrderStatus = 50";
$dbcon->_query($sqlstr) or dberror($sqlstr);
 while($Product = $dbcon->_fetch_array()):
  $OutPutProductSpec = explode("|",$Product[Co_Name]);
  //echo "\$OutPutProductSpec[1] = $OutPutProductSpec[1] <br />";
  $OutPutProductCount += $OutPutProductSpec[1];
 endwhile;

if ($TOTAL_DATA[hit]) {
$TOTAL_WIDTH = intval(($TOTAL_DATA[tqty]/$TOTAL_DATA[hit])*100);
}
else {
$TOTAL_WIDTH = 0;
$TOTAL_DATA[hit] = 0;
}
*/
?>
<script language="javascript">
<!--
function SortbyCat(cat){
	var f = document.SortForm;
	f.category.value = cat.value;
	f.submit();
}
//-->
</script>