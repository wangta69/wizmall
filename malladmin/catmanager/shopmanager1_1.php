<?php
include "../../lib/inc.depth2.php";
include "../../lib/class.admin.php";
$admin = new admin();
$admin->get_object($dbcon, $common, $mall);
include "../AUTH_CHECK.php";


header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if($DownForExel=="yes"){
$Thistime = date("Y-m-d");

header( "Content-type: application/vnd.ms-excel" ); 
header( "Content-Disposition: attachment; filename=${Thistime}.xls" ); 
header( "Content-Description: PHP4 Generated Data" ); 
}
?>
<head>
<meta http-equiv=Content-Type content="text/html; charset=ks_c_5601-1987">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 9">
</head>

<body>

  
	<table>
<?php
## wizCategory db
$sqlstr = "select cat_no, cat_name, cat_price from wizCategory order by cat_no asc";
$dbcon->_query($sqlstr);
while($list =$dbcon->_fetch_array()):
	$cat_no = $list["cat_no"];
	$big_cat = substr("000000".$cat_no, -3);
	$mid_cat = substr("000000".$cat_no, -6, 3);
	$small_cat = substr("000000".$cat_no, -9, 3);
	$cat_name = $list["cat_name"];
	$cat_price = $list["cat_price"];
	
	$catArr[$big_cat][$mid_cat][$small_cat]["cat_name"] = $common->conv_euckr($cat_name);
	$catArr[$big_cat][$mid_cat][$small_cat]["cat_price"] = $cat_price;
endwhile;
reset($catArr);

while(list($key, $value) = each($catArr)):

		echo "<tr>";
		echo "<td valign='top'>".$catArr[$key]["000"]["000"]["cat_name"]."(".$key.")</td>"; 
		echo "<td valign='top'><table>";
		while(list($key1, $value1) = each($catArr[$key])):
			if($key1 != "000"):
			echo "<tr><td valign='top'>";
			echo $catArr[$key][$key1]["000"]["cat_name"]."(".$key1.")</td><td>";
			while(list($key2, $value2) = each($catArr[$key][$key1])):
				if($key2 != "000"):
				echo $catArr[$key][$key1][$key2]["cat_name"]."(".$key2.")<br />";
				endif;
			endwhile;
			echo "</td></tr>";
			endif;
		endwhile;
		echo "</table></td></tr>";		
endwhile;
?>

	</table>
</body>

</html>