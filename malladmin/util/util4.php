<?php
#CREATE TABLE `wizbanner` (
#  `uid` int(11) NOT NULL auto_increment,
#  `flag1` varchar(10) NOT NULL default '',
#  `ordernum` int(5) NOT NULL default '0',
#  `url` varchar(50) NOT NULL default '',
#  `target` varchar(20) NOT NULL default 'root',
#  `attached` varchar(250) NOT NULL default '',
#  `wdate` int(13) NOT NULL default '0',
#  PRIMARY KEY  (`uid`)
#) type=MyISAM AUTO_INCREMENT=1 ;
$BOARD_NAME="wizbanner";
/******************************************************************************/

if ($query == 'qde') {   //삭제옵션시 실행
	while (list($key,$value) = each($_GET)) {
	    if(ereg("deleteItem", $key)) {
	            $VIEW_QUERY = "SELECT * FROM $BOARD_NAME WHERE uid='$value'";
	            $LIST = $dbcon->_fetch_array($dbcon->_query($VIEW_QUERY));
				$Loaded = explode("\|", $LIST["UPDIR1"]);
				for($i=0; $i<sizeof($Loaded); $i++){
	           	 if (is_file("../wizstock/$Loaded[$i]") && $Loaded[$i]) {
	              	      unlink("../wizstock/$Loaded[$i]");
				 }
	            }
	            $dbcon->_query("DELETE FROM $BOARD_NAME WHERE uid=$value");
	    }
	} 
} //삭제옵션 끝

//include "../wizboard/func/STR_CUTTING_FUNC.php";
$WHERE = "WHERE uid <> '0' and flag1 = '$flag1'";
/* 총 갯수 구하기 */
$TOTAL_STR = "SELECT count(uid) FROM $BOARD_NAME $WHERE";
$TOTAL = $dbcon->get_one($TOTAL_STR);
$LIST_NO=10; /* 페이지당 출력 리스트 수 */
$PageNo=10; /* 페이지 밑의 출력 수 */
if(empty($SUB_cp) || $SUB_cp <= 0) $SUB_cp = 1;
//--페이지 나타내기--
?>
<script>
function deletefnc(){
        var f = document.forms.BrdList;
        var i = 0;
        var chked = 0;
        for(i = 0; i < f.length; i++ ) {
                if(f[i].type == 'checkbox') {
                        if(f[i].checked) {
                                chked++;
                        }
                }
        }
        if( chked < 1 ) {
                alert('삭제하고자 하는 게시물을 하나 이상 선택해 주세요.');
                return false;
        }
        if (confirm('\n\n삭제하는 게시물은 복구가 불가능합니다!!! \n\n정말로 삭제하시겠습니까?\n\n')) return true;
        return false;
}
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">베너관리</div>
	  <div class="panel-body">
		 order가 작은 순서가 상위에 위치합니다.
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
						<p></p>
      <table class="table">
        <form action="<?php echo $PHP_SELF?>" name="BrdList" onsubmit='return deletefnc()'>
          <input type='hidden' name='menushow' value='<?php echo $menushow?>'>
          <input type="hidden" name="theme" value="<?php echo $theme;?>">
          <input type="hidden" name="cp" value="<?php echo $cp?>">
          <input type="hidden" name="SUB_cp" value="<?php echo $SUB_cp?>">
          <input type="hidden" name="query" value="qde">
		  <input type="hidden" name="flag1" value="<?php echo $flag1?>">
          <tr> 
            <th>삭제</th>
            <th>order</th>
            <th>url</th>
            <th>이미지</th>
            <th>수정</th>
          </tr>
<?php 
$START_NO = ($SUB_cp - 1) * $LIST_NO;
$BOARD_NO=$TOTAL-($LIST_NO*($SUB_cp-1));
$SELECT_STR="SELECT * FROM $BOARD_NAME $WHERE ORDER BY uid DESC LIMIT $START_NO, $LIST_NO";
$SELECT_QRY=$dbcon->_query($SELECT_STR);
while($LIST=@$dbcon->_fetch_array($SELECT_QRY)):
?>
          <tr> 
            <td><input type="checkbox" name="deleteItem_<?php echo $LIST[uid]?>" value="<?php echo $LIST[uid]?>">            </td>
            <td> 
              <?php echo $LIST[ordernum];?>            </td>
            <td> 
              <?php echo $LIST[url];?></td>
            <td> 
              <img src="../wizstock/<?php echo $LIST[attached]?>">            </td>
            <td><a href="<?php echo $PHP_SELF?>?menushow=<?php echo $menushow?>&theme=util/util4_write&flag1=<?php echo $flag1?>&mode=qup&uid=<?php echo $LIST[uid];?>"><img src="img/su.gif" width="53" /></a></td>
          </tr>
<?php
$BOARD_NO--;
endwhile;
?>
          <tr> 
            <td colspan="5"> <table>
                <tr> 
                  <td> <input type="image" style="cursor:pointer" src="img/del02.gif" width="53">                  </td>
                  <td><a href="<?php echo $PHP_SELF?>?menushow=<?php echo $menushow?>&theme=util/util4_write&flag1=<?php echo $flag1?>&mode=qin"><img src="img/dung.gif" width="55"></a></td>
                </tr>
              </table></td>
          </tr>
        </form>
      </table>

      <table>
        <tr> 
                                              
          <td>
<?php
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
$page_arg1 = $PHP_SELF."?menushow=$menushow&theme=$theme&flag1=$flag1&cp=$cp&stitle=$stitle&keyword=".urlencode($keyword);
$page_arg2 = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL); 
//$page_arg3 = array("pre"=>"./img/pre.gif","next"=>"./img/next.gif");
echo $common->paging($page_arg1,$page_arg2,$page_arg3);
?>

          </td>
                                            </tr>
                                          </table>
                </td>
              </tr>
            </table>