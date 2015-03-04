<?
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 

Copyright shop-wiz.com
*** Updating List ***

*/

$TableName = "wiznewsletterregister";

if($query=="qde"){
	$sqlstr = "delete from $TableName where uid = '$uid'";
	$result = $dbcon->_query($sqlstr);
}

$where =  "where 1 ";
$orderby =  "order by uid asc";

/* 페이징과 관련된 수식 구하기 */
$ListNo = "15";
$PageNo = "20";
if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $ListNo;
$TOTAL_STR = "SELECT count(*) FROM $TableName";
$REALTOTAL = $dbcon->get_one($TOTAL_STR);

$sqlstr = "SELECT count(*) FROM $TableName $where";
$TOTAL = $dbcon->get_one($sqlstr);


$LIST_QUERY = "SELECT * FROM $TableName $where $orderby LIMIT $START_NO,$ListNo";
$TABLE_DATA = $dbcon->_query($LIST_QUERY);
?>
<script  language=JavaScript>
<!--
function delconfirm(uid){
	if(confirm('정말로 삭제하시겠습니까?')){
		location.href="<?=$PHP_SELF;?>?theme=<?=$theme;?>&menushow=<?=$menushow;?>&query=qde&uid="+uid;
	}
}
function regwindow(uid){
	window.open('./mailer4_write.php?uid='+uid,'RegWindow','width=400,height=424,top:100,left=100');

}
//-->
</script>
<style type="text/css">
<!--
.style1 {
	color: #000000
}
-->
</style>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">메일발송하기</div>
	  <div class="panel-body">
		 신청된 메일링 리스트입니다.
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
						<p></p>	
      <table>
        <tr>
          <td>&nbsp;</td>
          <td><table>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><span class="button bull"><a href='javascript:regwindow("");'>등록</a></span></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <table class="table">
        <form action='<?=$PHP_SELF?>' name='memberlist' onSubmit="return really()">
          <input type="hidden" name="theme"  value='<?=$theme?>'>
          <input type='hidden' name='menushow' value='<?=$menushow?>'>
          <input type="hidden" name="action" value='qde'>
          <tr>
            <th>&nbsp;</th>
            <th>신청자</th>
            <th>학교/회사</th>
            <th>부서</th>
            <th>연락처</th>
            <th>이메일</th>
            <th>수정</th>
            <th>삭제</th>
          </tr>
          <?
$NO = $TOTAL-($ListNo*($cp-1));	
while( $list = $dbcon->_fetch_array( $TABLE_DATA ) ) :
      
?>
          <tr>
            <td><input type="checkbox" name='deleteArr[<?=$i?>]' value='<?=$list[uid]?>'></td>
            <td>
              <?=$list["username"]?>
              </td>
            <td>
              <?=$list["usercom"]?>
              </td>
            <td>
              <?=$list["userdep"]?>
              </td>
            <td>
              <?=$list["usertel"]?>
              &nbsp;</td>
            <td>
              <?=$list["useremail"]?>
              &nbsp; </td>
            <td><span class="button bull"><a href='javascript:regwindow("<?=$list["uid"];?>");'>수정</a></span></td>
            <td><span class="button bull"><a href='javascript:delconfirm("<?=$list["uid"];?>");'>삭제</a></span></td>
          </tr>
          <?
$NO--; 
endwhile;
?>
        </form>
        <tr>
          <td colspan=8>&nbsp;</td>
        </tr>
      </table>
      <br />
      <table>
        <tr>
          <td><?
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
$page_arg1 = $PHP_SELF."?WHERE=$WHERE&menushow=$menushow&theme=$theme&keyword=".urlencode($keyword)."&SELECT_SORT=$SELECT_SORT&SYear=$SYear&SMonth=$SMonth&SDay=$SDay&FYear=$FYear&FMonth=$FMonth&FDay=$FDay&DataEnable=$DataEnable";
$page_arg2 = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL); 
$page_arg3 = array("pre"=>"./img/pre.gif","next"=>"./img/next.gif");
echo $common->paging($page_arg1,$page_arg2,$page_arg3);
?></td>
        </tr>
      </table>
      <br />
       </td>
  </tr>
</table>
