<?php
/*
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 

Copyright shop-wiz.com
*/
?>
<?
$BOARD_name="wizInquire";
//include "../wizboard/func/STR_CUTTING_FUNC.php";
/* 검색 키워드 및 WHERE 구하기 */
$WHERE="WHERE iid = '$iid'";
if($SEARCHTITLE && $searchkeyword){
$WHERE .= "AND $SEARCHTITLE LIKE '%$searchkeyword%'";
}
/* 총 갯수 구하기 */
$TOTAL_STR = "SELECT count(uid) FROM $BOARD_NAME $WHERE";
$TOTAL = $dbcon->get_one($TOTAL_STR);
$LIST_NO=10; /* 페이지당 출력 리스트 수 */
$PageNo=10; /* 페이지 밑의 출력 수 */
if(empty($cp) || $cp <= 0) $cp = 1;

?>
<script>
function DELETE_THIS(uid,cp,iid,theme,menushow){
window.open("./inquire/inquire_del.php?uid="+uid+"&cp="+cp+"&iid="+iid+"&theme="+theme+"&menushow="+menushow,"","scrollbars=no, toolbar=no, width=340, height=150, top=220, left=350")
}
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">문의사항</div>
	  <div class="panel-body">
		 A/S 문의를 보실 수 있습니다.
	  </div>
	</div>
</div>

<table>
  <tr>
    <td></td>
    <td>
						<p></p>	
      <table>
        <tr>
          <th>NO.</th>
          <th>이름(회사명)</th>
          <th>전화번호</th>
          <th>의뢰일</th>
          <th>삭제</th>
        </tr>
        <? 

$START_NO = ($cp - 1) * $LIST_NO;

$BOARD_NO=$TOTAL-($LIST_NO*($cp-1));

$SELECT_STR="SELECT * FROM $BOARD_NAME $WHERE ORDER BY uid DESC LIMIT $START_NO, $LIST_NO";

//ECHO "\$SELECT_STR = $SELECT_STR <br />";

$SELECT_QRY=$dbcon->_query($SELECT_STR);

while($LIST=@$dbcon->_fetch_array($SELECT_QRY)):

$LIST[SUBJECT]=stripslashes($LIST[SUBJECT]);

$LIST[W_DATE] = ereg_replace("\-",".",$LIST[W_DATE]);

/* REPLY에 이미지가 있을 경우 아래 방법을 사용합니다. */

$IMGNUM=strlen($LIST[THREAD])-1;

$SPACE="";

for($i=0; $i<$IMGNUM-1; $i++){

$SPACE .="&nbsp;&nbsp;";

}

?>
        <tr>
          <td><?=$BOARD_NO;?>
          </td>
          <td><a href="<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=inquire/inquire2_1&uid=<?=$LIST[uid];?>&cp=<?=$cp;?>&OPT=<?=$LIST[OPT];?>&iid=<?=$LIST[iid];?>">
            <?=$LIST[name];?>
            (
            <?=$LIST[compname];?>
            )</a> &nbsp; </td>
          <td><a href="<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=inquire/inquire2_1&uid=<?=$LIST[uid];?>&cp=<?=$cp;?>&OPT=<?=$LIST[OPT];?>&iid=<?=$LIST[iid];?>">
            <?=$LIST[tel]?>
            </a>&nbsp; </td>
          <td><?=date("Y.m.d",($LIST[wdate]));?>
          </td>
          <td><input type="button" value="삭제" onClick="javascript:DELETE_THIS('<?=$LIST[uid];?>','<?=$cp;?>','<?=$iid;?>','<?=$theme?>','<?=$menushow?>');" style="cursor:pointer";>
          </td>
        </tr>
        <?

$BOARD_NO--;

endwhile;

?>
      </table>
      <table>
        <tr>
          <td><?
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
$page_arg1 = $PHP_SELF."?iid=$iid&menushow=$menushow&theme=$theme&SEARCHTITLE=$SEARCHTITLE&searchkeyword=".urlencode($searchkeyword);
$page_arg2 = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL); 
//$page_arg3 = array("pre"=>"./img/pre.gif","next"=>"./img/next.gif");
echo $common->paging($page_arg1,$page_arg2,$page_arg3);
?> </td>
        </tr>
      </table></td>
  </tr>
</table>
