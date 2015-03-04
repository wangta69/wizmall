<?
include "../lib/inc.depth1.php";
include("./admin_check.php");

if($mode==ok) {

	if($BID=="" || $GID=="") {
ECHO "<script>window.alert('잘못된 경로의 접근입니다.');	
	self.close();
	</script>";
	exit;
	
	}

$targetFolder = "../config/wizboard/table/${GID}/${BID}";
if(is_dir($targetFolder)){
	/******** 업로딩된 파일 삭제 updir 삭제 **************/
	$LOG_DIR = opendir($targetFolder."/updir");
	while($LOG_FILE = readdir($LOG_DIR)) {
		if($LOG_FILE !="." && $LOG_FILE !=".."){
			  @unlink($targetFolder."/updir/$LOG_FILE");
		} //if($LOG_FILE !="." && $LOG_FILE !="..") 닫음
	}
        closedir($LOG_DIR);
	$result = @rmdir($targetFolder."/updir");		
	if(!$result) echo "<script>window.alert('".$targetFolder."/updir 를 삭제하지 못했습니다. 수동으로 삭제해 주세요');</script>";
	
	/******** config 파일 삭제 및 table 디렉토리 삭제 **************/
	$LOG_DIR = opendir($targetFolder);
	while($LOG_FILE = readdir($LOG_DIR)) {
		if($LOG_FILE !="." && $LOG_FILE !=".."){
			  @unlink($targetFolder."/$LOG_FILE");
		} //if($LOG_FILE !="." && $LOG_FILE !="..") 닫음
	}
			closedir($LOG_DIR);
	$result = @rmdir("../config/wizboard/table/${GID}/${BID}");		
	if(!$result){
	echo "<script>window.alert('$targetFolder 를 삭제하지 못했습니다. 수동으로 삭제해 주세요');</script>";
	}	

}




/* reple 테이블 삭제 */
$sqlstr = "DROP TABLE wizTable_${GID}_${BID}_reply";
$result = $dbcon->_query($sqlstr, FALSE);

/* 테이블 삭제 */
$sqlstr = "DROP TABLE wizTable_${GID}_${BID}";
$result = $dbcon->_query($sqlstr, FALSE);

/* wizTable_Maind 으로 부터 관련 졍보 삭제 */

$sqlstr = "delete from wizTable_Main where BID='$BID' and GID='$GID'"; 
$dbcon->_query($sqlstr);

	echo "<script>//alert('테이블을 삭제했습니다.');
		opener.location.replace('./admin.php?GID=$GID&cp=$cp');
		self.close();
		</script>";
	exit();
}
?>