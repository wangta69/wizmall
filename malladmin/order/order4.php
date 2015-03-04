<?php
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/

?>
<script>
	function gotoPage(cp){
		$("#cp").val(cp);
		$("#sform").submit();
	}
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">온라인 자동 견적</div>
	  <div class="panel-body">
		 온라인 자동견적을 보실 수 있으며 이 페이지는 쇼핑몰 제작시 제작진과 의논이 되어야 사용가능합니다.
	  </div>
	</div>
	
	<form action='<?=$PHP_SELF?>' method="post">
		<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
		<input type='hidden' name='menushow' value='<?=$menushow?>'>
		<input type="hidden" name="theme"  value='<?=$theme?>'>
		<input type="hidden" name="cp" id="cp"  value='<? echo $cp?>' >
		<table>
			<tr>
				<td><select name="WHERE">
						<option value=''>검색영역</option>
						<option value=''>----------</option>
						<option value='OrderID'<?if($WHERE=='OrderID'){echo " SELECTED";}?>>주문번호</option>
						<option value='SName'<?if($WHERE=='SName'){echo " SELECTED";}?>>주문자</option>
						<option value='RName'<?if($WHERE=='RName'){echo " SELECTED";}?>>입금자</option>
						<option value='RAddress1'<?if($WHERE=='RAddress1'){echo " SELECTED";}?>>주문지역</option>
					</select>
				</td>
				<td><input size=15 name="keyword">
				</td>
				<td>
					<button type="submit" class="btn btn-primary btn-xs">검색</button>
					<button type="button" class="btn btn-default btn-xs" onClick="location.replace('<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=<?=$theme?>')">리스트</button>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;
					<select style="width: 120px" 
                onChange=this.form.submit() name=ing_sort>
						<option value='ziro'>결제방식 구분</option>
						<option value='ziro'>----------------</option>
						<option value='ziro'>온라인구매</option>
						<option value='card'<?if($ing_sort=='card'){echo " selected";}?>>신용카드결제</option>
						<option value='point'<?if($ing_sort=='point'){echo " selected";}?>>포인트결제</option>
						<option value='all'<?if($ing_sort=='all'){echo " selected";}?>>다중결제</option>
					</select>
				</td>
				<td><select 
                style="width: 140px" onChange=this.form.submit() 
                name=sort>
						<option value='UID'>선택부분별 정렬</option>
						<option value='UID'>-------------------</option>
						<option value='TotalAmount'<?if($sort=='TotalAmount'){echo " SELECTED";}?>>구매금액순 정렬</option>
						<option value='RAddress1'<?if($sort=='RAddress1'){echo " SELECTED";}?>>구매지역 구분</option>
						<option value='PayMethod'<?if($sort=='PayMethod'){echo " SELECTED";}?>>결제방식 구분</option>
						<option value='MemberID'<?if($sort=='MemberID'){echo " SELECTED";}?>>(비)회원 구분</option>
					</select></td>
			</tr>
		</table>
	</form>
			<br />
	<table class="table table-hover table-striped">
			<col width="60" />
			<col width="*" />
			<col width="70" />
			<col width="100" />
			<col width="100" />
			<col width="80" />
			<col width="80" />
			<thead>
				<tr class="success">
					<th>&nbsp; </th>
					<th>견적번호</th>
					<th>견적금액</th>
					<th>견적인</th>
					<th>전화</th>
					<th>상호</th>
					<th>견적일시</th>
				</tr>
			</thead>
			<tbody>
<?php
/* 페이징과 관련된 수식 구하기 */
$ListNo = "15";
$PageNo = "20";
if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $ListNo;
$whereis = "where 1 ";

if ($action == 'detail_search') {
        $SDay_minus = $SDay - 1;
        if ($SDay_minus < 10) {
        $SDay_minus = "0".$SDay_minus;
        }
        if ($How_Bu == 'tall'){$How_Query = "";}else{$How_Query = "AND PayMethod='$PayMethod'";}
        $whereis .= " and BuyDate >= '$SYear.$SMonth.$SDay_minus 23:59' AND BuyDate <= '$FYear.$FMonth.$FDay 23:59' $How_Query";
        $sort = $Dsort;
}
else {
        $How_Bu = "tall";
        if (!$sort) {$sort = "UID";}
        if ($WHERE && $keyword) {$whereis .= " and $WHERE LIKE '%$keyword%'";}
        if ($ing_sort) {
                if ($ing_sort == 'ziro') {$ing_sort1 = "";}
                else {$ing_sort1 = $ing_sort;}
        }
}

$sqlstr = "SELECT count(*) FROM wizEstim $whereis";
$TOTAL = $dbcon->get_one($sqlstr);

//--페이지링크를 작성하기--
$LIST_QUERY = "SELECT * FROM wizEstim $whereis ORDER BY $sort DESC LIMIT $START_NO,$ListNo";
$TABLE_DATA = $dbcon->_query($LIST_QUERY, $DB_CONNECT) or dberror($LIST_QUERY);

$TOTAL_QUERY = $dbcon->_query( "SELECT SUM(Total_Money) FROM wizEstim");
$TOTAL_SMONEY = $dbcon->_fetch_array($TOTAL_QUERY);
$TOTAL_SMONEY = $TOTAL_SMONEY[0];

$NO = $TOTAL-($ListNo*($cp-1));
while( $list = $dbcon->_fetch_array( $TABLE_DATA ) ) :
        $RAddress1 = explode(" ", $list[RAddress1]);
		$BankInfo = explode("|", $list[BankInfo]);
        $SUB_SMONEY = $SUB_SMONEY + $list[TotalAmount];
        //------------------------------------------[결제방식]
        if ($list[PayMethod] == 'card') {$PayWay = "신용카드";}
        else if ($list[PayMethod] == 'point') {$PayWay = "포인트";}
        else if ($list[PayMethod] == 'all') {$PayWay = "다중결제";}
        else {$PayWay = "온라인";}
        //--------------------------------------------------
        if (!$list[MemberID]) {$list[MemberID] = "비회원";}
?>
				<tr>
					<td><?=$NO?>
						&nbsp; </td>
					<td><a  href='#' onClick="javascript:window.open('./order1_1.php?uid=<?=$list[UID]?>', 'cartform','width=670,height=600,statusbar=no,scrollbars=yes,toolbar=no')">
						<?=$list[OrderID]?>
						</a></td>
					<td><?=number_format($list[TotalAmount])?>
						원</td>
					<td><a  href='#' onclick="javascript:window.open('./member1_1.php?id=<?=$list[MemberID]?>', 'regisform','width=650,height=600,statusbar=no,scrollbars=yes,toolbar=no')">
						<?=$list[SName]?>
						(
						<?=$list[MemberID]?>
						)</a></td>
					<td><?=$list[STel1]?>
					</td>
					<td><?=$list[RCompany]?>
					</td>
					<td><?=date("Y.m.d H:i",$list[BuyDate])?>
					</td>
				</tr>
<?php
$NO --;
endwhile;
?>
				<tr>
					<td colspan=9>현재페이지 합계금액 :
						<?=number_format($SUB_SMONEY)?>
						원 | 반품 총액 :
						<?=number_format($TOTAL_SMONEY)?>
						원</td>
				</tr>
			</tbody>
		</table>
	<div class="text-center">
<?php
$params = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL, "type"=>"bootstrappost"); 
echo $common->paging($params);
?>
	</div>
			
</div>
