<?php
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***

*/

if ($action == 'deleteComment' && $common -> checsrfkey($csrf)) {
	$sqlstr = "delete FROM wizEvalu where UID='$UID'";
	$dbcon->_query($sqlstr);
}
?>
<script>
function confirm_del(uid){
	if(confirm('정말로 삭제하시겠습니까?')){
		location.href = '<?=$PHP_SELF?>?theme=<?=$theme?>&menushow=<?=$menushow?>&action=deleteComment&UID='+uid;
	}else return false;
}

function gotoPage(cp){
	$("#cp").val(cp);
	$("#sform").submit();
}
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">상품평관리</div>
	  <div class="panel-body">
		 제품당 달려있는 상품평을 일목요연하게 관리할 수 있습니다.
	  </div>
	</div>
	
	<form id="sform">
		<input type="hidden" name="csrf" value="<?=$common->getcsrfkey()?>">
		<input type="hidden" name="menushow" value=<? echo $menushow?> />
		<input type="hidden" name="theme"  value=<? echo $theme?> />
		<input type="hidden" name="cp" id="cp"  value=<? echo $cp?> />
	</form>
	<form  action='<?=$PHP_SELF?>' method='post' name="write" enctype='multipart/form-data' onsubmit='return checkForm();'>
		<input type="hidden" name="csrf" value="<?=$common->getcsrfkey()?>">
		<input type="hidden" name='action' value='writedata' />
		<input type="hidden" name="menushow" value=<? echo $menushow?> />
		<input type="hidden" name="theme"  value=<? echo $theme?> />
		<table class="table table-hover table-striped">
			<col width="150" />
			<col width="*" />
			<col width="100" />
			<thead>
				<tr class="success">
					<th>상품</th>
					<th>제목</th>
					<th>삭제</th>
				</tr>
			</thead>
			<tbody>
<?php
/* 검색 키워드 및 WHERE 구하기 */
$BOARD_NAME = "wizEvalu";
$ListNo = 10;
$PageNo = 10;
$WHERE  = "WHERE GID <> ''";
if($category) $WHERE = "$WHERE and BID = '$category'";
if($stitle && $keyword) $WHERE = "$WHERE and $stitle LIKE '%$keyword%'";

/* 총 갯수 구하기 */
$TOTAL_STR = "SELECT count(UID) FROM $BOARD_NAME $WHERE";
$TOTAL = $dbcon->get_one($TOTAL_STR);

if(empty($cp) || $cp <= 0) $cp = 1;

$START_NO = ($cp - 1) * $ListNo;
						
$sqlstr="SELECT e.UID, e.GID, e.Name, e.Subject, e.Contents, m.Picture, m.Name, m.Category FROM $BOARD_NAME e 
		left join wizMall m on e.GID = m.UID ORDER BY e.Wdate DESC LIMIT $START_NO, $ListNo";
$dbcon->_query($sqlstr);
$cnt = 0;
while($list = $dbcon->_fetch_array()):
	$GoodsName	=$list["Name"];
	$Picture	= explode("|", $list["Picture"]);
	$big_cat	= substr($list["Category"], -3);
	$cnt++;
?>
						<tr>
							<td><img src='../config/uploadfolder/productimg/<?=$big_cat?>/<?=$Picture[0]?>' height='50' /><br />
								<?=$GoodsName?>
							</td>
							<td style="word-break:break-all;"><? if($list[Subject]) echo $list[Subject]."<br />";?>
								<? if($list[Contents]) echo $list[Contents]."<br />";?>
								&nbsp; </td>
							<td><span class="button bull"><a href="javascript:confirm_del('<?=$list[UID]?>')">삭제</a></span></td>
						</tr>
<?php
endwhile;
if(!$cnt){
?>
						<tr>
							<td colspan="3" class="text-center">등록된 상품평이 없습니다.</td>
						</tr>
<?php
}
?>
					</tbody>
				</table>
			</form>
	<div class="text-center">
<?php
$params = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL, "type"=>"bootstrappost"); 
echo $common->paging($params);
?>
	</div>	
</div>
