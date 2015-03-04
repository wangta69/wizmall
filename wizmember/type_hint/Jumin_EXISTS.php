<?
function error1($msg) {
echo "<SCRIPT LNAGUAGE=JAVASCRIPT>
window.alert('$msg');
self.close();
</SCRIPT>";
exit;
}



if(!$jumin1 || !jumin2) {
	$msg = "주민번호를 입력해 주세요"; error1($msg);
}

include ("../../config/db_info.php");
include "../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);


$sqlstr = "SELECT UID FROM wizMembers WHERE Jumin1='$jumin1' and Jumin2='$jumin2'";

$DATA1 = $dbcon->_query($sqlstr);
if ( $dbcon->_fetch_array($DATA1) ) {
$msg = "${jumin1}-${jumin2} 는 이미 사용중인 주민번호입니다."; error1($msg);
}else echo "<script>window.alert('${jumin1}-${jumin2} 는 사용가능한 주민번호입니다.');self.close();</script>";
exit;
?>