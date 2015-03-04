<?
include "../../../lib/cfg.common.php";
include ("../../../config/db_info.php");
include ("../../../config/cfg.core.php");
include ("../../../config/common_array.php");
include "../../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);

include ("../../../lib/class.wizmall.php");
$mall = new mall;
$mall->get_object($dbcon);

$RegOptionRevArr = array_flip($RegOptionArr);
$tmpkey = $RegOptionRevArr["신규상품"];
$pos = $tmpkey*2 + 1;
$sqlstr = "select UID, Name, Price, Picture, Category, Model from wizMall where UID = PID and None <> 1 and SUBSTRING(Regoption,".$pos.",1)= '1'";
$qry = $dbcon->_query($sqlstr);
while($list = $dbcon->_fetch_array($qry)):
	$shopurl	= $cfg["admin"]["MART_BASEDIR"]."/";
	$cat		= $list["Category"];
	$uid		= $list["UID"];
	$pic		= explode("|", $list["Picture"]);
	$pgurl		= $shopurl."wizmart.php?query=view&code=".$cat."&no=".$uid;
	$igurl		= $mall->getpdimgpath($cat, $pic[0], $shopurl);
	$catarr		= $mall->getCategory($cat);
	echo "<<<begin>>>\n";
	echo "<<<mapid>>>".$list["UID"]."\n";
	echo "<<<pname>>>".$list["Name"]."\n";
	echo "<<<price>>>".$list["Price"]."\n";
	echo "<<<pgurl>>>".$pgurl."\n";
	echo "<<<igurl>>>".$igurl."\n";
	echo "<<<cate1>>>".$catarr[0]["cat_name"]."\n";
	echo "<<<cate2>>>".$catarr[1]["cat_name"]."\n";
	echo "<<<cate3>>>".$catarr[2]["cat_name"]."\n";
	echo "<<<cate4>>>\n";
	echo "<<<model>>>".$list["Model"]."\n";
	echo "<<<brand>>>\n";
	echo "<<<maker>>>\n";
	echo "<<<origi>>>\n";
	echo "<<<pdate>>>\n";
	echo "<<<deliv>>>0\n";
	echo "<<<event>>>\n";
	echo "<<<coupo>>>\n";
	echo "<<<pcard>>>\n";
	echo "<<<point>>>\n";
	echo "<<<modig>>>\n";
	echo "<<<ftend>>>\n";
endwhile;
?>