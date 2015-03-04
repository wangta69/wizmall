<?
include "../../../lib/cfg.common.php";
include ("../../../config/db_info.php");
include ("../../../config/cfg.core.php");
include "../../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);

include ("../../../lib/class.wizmall.php");
$mall = new mall;
$mall->get_object($dbcon);


$sqlstr = "select UID, Name, Price from wizMall where UID = PID and None <> 1";
$dbcon->_query($sqlstr);
while($list = $dbcon->_fetch_array()):
	echo "<<<begin>>>\n";
	echo "<<<mapid>>>".$list["UID"]."\n";
	echo "<<<pname>>>".$list["Name"]."\n";
	echo "<<<price>>>".$list["Price"]."\n";
	echo "<<<ftend>>>\n";
endwhile;
?>