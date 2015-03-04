<?php
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/
if ($common -> checsrfkey($csrf)) {
	if ($action == 'qde') {
	        $dbcon->_query("DELETE FROM wizCom WHERE CompID='$mid'");  //wizCom 삭제
	
	      if($CompSort >= 50){		/* 만약 CompSort >= 50 (판매처) 일경우 wizMembers 에저장된 정보를 삭제 */
			$dbcon->_query("DELETE FROM wizMembers WHERE ID='$mid'");  //wizMembers 삭제
			$dbcon->_query("DELETE FROM wizMembersMore WHERE MID='$mid'");  //wizMembers 삭제
			}
	}
}
$ListNo = "15";
$PageNo = "20";
if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $ListNo;

if (!$sort) {$sort = "UID";}
if(!$WHERE) $WHERE = "WHERE CompSort < '50'";
/* 
기업회원 구분(wizCom.CompSort)은 크게 공급처( <50 ) 과 소매처(50 <=, <100) 로 분류된다. 
01 : 도매공급자, 02 : 소매공급자, 03 : 생산자), 50 : 쇼핑몰(온라인)기업고객고객, 51 : 도매판매처, 52, 소매판매처 .. 경우에따라 이곳은 자유롭게 프로그램가능)
*/
$TOTAL_STR = "SELECT count(*) FROM wizCom $WHERE";
$TOTAL = $dbcon->get_one($TOTAL_STR);


$LIST_QUERY = "SELECT * FROM wizCom $WHERE ORDER BY $sort DESC LIMIT $START_NO,$ListNo";
//echo "\$LIST_QUERY = $LIST_QUERY <br />";
$TABLE_DATA = $dbcon->_query($LIST_QUERY);
?>
<script language="javascript">
function really(){
	if (confirm('\n\n삭제된 데이터는 복구가 불가능합니다.\n\n정말로 삭제하시겠습니까?\n\n')) return true;
	return false;
}
function gotoPage(cp){
	$("#cp").val(cp);
	$("#sform").submit();
}
</script>
<form id="sform">
	<input type='hidden' name='menushow' value='<?php echo $menushow?>'>
	<input type="hidden" name="theme"  value='<?php echo $theme?>'>
	<input type="hidden" name="cp" id="cp"  value='<?php echo $cp?>' >
</form>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">거래처관리</div>
	  <div class="panel-body">
		 본쇼핑몰의 제품공급 거래처 리스트입니다. 제품공급 거래처를 등록하면 공급 거래처별로 매출통계기능이 지원됩니다.<br />
				[수정]을 클릭하시면 선택한 거래처에 대한 자세한 정보를 확인 및 수정을 하실 수 있습니다.<br />
				[삭제]는 거래처 삭제시 [등록]은 신규 거래처 등록시 사용하시면 됩니다.
	  </div>
	</div>
	<div class="text-right">
		<a href='<?php echo $PHP_SELF?>?menushow=<?php echo $menushow?>&theme=member/member5_1' class="btn btn-primary">등록하기</a>
	</div>
	<table class="table table-hover table-striped">
		<col width="*" />
		<col width="100" />
		<col width="100" />
		<col width="100" />
		<col width="100" />
		<col width="100" />
		<col width="100" />
		<thead>
			<tr class="success">
				<th>거래처명</th>
				<th>지역</th>
				<th>대표자</th>
				<th>담당자 (휴대폰)</th>
				<th>전화</th>
				<th>팩스</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
<?
while( $LIST = $dbcon->_fetch_array( $TABLE_DATA ) ) :
$AREA = explode(" ",$LIST["CompAddress1"]);
?>
			<tr>
				<td><?php echo $LIST["CompName"]?></td>
				<td><?php echo $AREA[0]?>
				</td>
				<td><?php echo $LIST["CompPreName"]?>
				</td>
				<td><?php echo $LIST["CompChaName"]?>
					(<?php echo $LIST["CompChaTel"]?>)
				</td>
				<td><?php echo $LIST["CompTel"]?>
				</td>
				<td><?php echo $LIST["CompFax"]?>
				</td>
				<td>
					<a href='<?php echo $PHP_SELF?>?menushow=<?php echo $menushow?>&theme=member/member5_1&uid=<?php echo $LIST["UID"]?>&mode=modify&cp=<?php echo $cp?>&csrf=<?php echo $common -> getcsrfkey() ?>' class="btn btn-default btn-xs">수정</a>
					<a href='<?php echo $PHP_SELF?>?menushow=<?php echo $menushow?>&theme=<?php echo $theme?>&action=qde&mid=<?php echo $LIST["CompID"]?>&cp=<?php echo $cp?>&CompSort=<?php echo $LIST["CompSort"]?>&csrf=<?php echo $common -> getcsrfkey() ?>'' onClick='return really()' class="btn btn-default btn-xs">삭제</a>
				</td>
			</tr>
					<?
endwhile;
?>
		</tbody>
	</table>
	<div class="text-center">
<?php
$params = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL, "type"=>"bootstrappost"); 
echo $common->paging($params);
?>
	</div>

	
	
</div>

