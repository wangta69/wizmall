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
if($mode==ok) {
$BOARD_NAME = "wizInquire";

/* 현재 삭제될 글의 상세정보를 가져온다 */

$sqlstr="SELECT * FROM $BOARD_NAME WHERE uid='$uid'";
$sqlqry=$dbcon->_query($sqlstr);
$LIST=$dbcon->_fetch_array();

/******** 업로딩된 파일 삭제 **************/

$attached=explode("|", $LIST[attached]);
for($i=0; $i<sizeof($attached); $i++){
if($attached[$i] && file_exists("../../config/uploadfolder/etc/$attached[$i]")) {
	unlink("../../config/uploadfolder/etc/$attached[$i]");
	}
}

/******* 테이블로 부터 정보 삭제 *********/
	$SQL_STR="DELETE FROM $BOARD_NAME WHERE uid='$uid'";
	$dbcon->_query($SQL_STR);

if(ereg("_",$theme)) $theme=substr($theme,0,-2);

	echo "<script>alert('삭제했습니다.');
		opener.location.replace('../main.php?menushow=$menushow&theme=$theme&iid=$iid&cp=$cp');
		self.close();
		</script>";

	exit();

}

include "../common/header_html.php";
?>
<body>
<div class="alert alert-danger">
	<p>삭제된 데이트는  복구되지 않습니다. </p>
      <p>삭제하시겠습니까?</p>
</div>
<center>
  <table>
    <form name="confirmForm" action=<?=$PHP_SELF?> method="post">
      <input type='hidden' name='mode' value='ok'>
      <input type='hidden' name='uid' value='<?=$uid?>'>
      <input type='hidden' name='cp' value='<?=$cp?>'>
      <input type='hidden' name='iid' value='<?=$iid?>'>
      <input type='hidden' name='theme' value='<?=$theme?>'>
	  <input type='hidden' name='menushow' value='<?=$menushow?>'>
      <tr> 
        <td colspan="2"> </td>
      </tr>
      <tr> 
        <td colspan="2"> <input type="submit" value="예"  name="Submit"> 
          <input type="button" value="아니요" onClick="window.close()"  name="button"> 
        </td>
      </tr>
    </form>
  </table>
</center>
</body>
</html>