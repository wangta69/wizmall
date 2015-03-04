<?
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/
include "../common/header_pop.php";
include "../common/header_html.php";
$TABLE_NAME = "wizInputer";
$WHERE = "WHERE Igoodscode = '$pid'";


/* 총 갯수 구하기 */
$ListNo = 10;
$PageNo = 10;
$TOTAL_STR = "SELECT count(IID) FROM $TABLE_NAME $WHERE";
$TOTAL = $dbcon->get_one($TOTAL_STR);

if(empty($cp) || $cp <= 0) $cp = 1;

?>
<script>
function gotoPage(cp){
	$("#cp").val(cp);
	$("#sform").submit();
}
</script>
</head>
<body>
	<form id="sform">
		<input type="hidden" name="csrf" value="<?=$common->getcsrfkey()?>">
		<input type='hidden' name='pid' value='<?=$pid?>'>
		<input type="hidden" name="cp" id="cp"  value='<? echo $cp?>' >
	</form>

    	재품 입고 리스트 <button type="button" class="btn btn-default btn-xs" onClick='javascript:top.close();'>닫기</button>
 <table class="table">
    <tr class="active"> 
      <th>No.</th>
      <th> &nbsp; 입고일자</th>
      <th>입고수량</th>
    </tr>
<?php 
$START_NO = ($cp - 1) * $ListNo;
$BOARD_NO=$TOTAL-($ListNo*($cp-1));
$sql="SELECT * FROM $TABLE_NAME $WHERE ORDER BY IID desc LIMIT $START_NO, $ListNo";
$qry = $dbcon->_query($sql);
$cnt=0;
while($LIST=$dbcon->_fetch_array($qry)):
?>
    <tr> 
      <td> 
        <?=$BOARD_NO;?>
      </td>
      <td><?=date("Y.m.d",$LIST[Iinputdate])?> </td>
      <td><?=$LIST[Iinputqty]?></td>
    </tr>
<?php
	$BOARD_NO--;
	$cnt++;
endwhile;
if(!$cnt):/* 게시물이 존재하지 않을 경우 */
?>
    <tr> 
      <td>&nbsp;</td>
      <td colspan="2">입고가 없습니다.</td>
    </tr>
<?php
endif;
?>
  </table>
<p class="text-center">
<?php
	$params = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL, "type"=>"bootstrappost"); 
	echo $common->paging($params);
?>
</p>
</body>
</html>