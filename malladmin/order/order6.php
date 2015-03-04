<?php
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/

if($d_mode == "d_delete" && $common -> checsrfkey($csrf)){
	foreach($multi as $key=>$value){
		//echo $key;
		$sqlstr = "delete from wizBillcheck where uid = '$key'";
		$dbcon->_query($sqlstr);	
	}
}
?>
<script>
	function openorderwindow(uid){	
		wizwindow('./order/order1_1.php?uid='+uid, 'cartform','width=620,height=700,statusbar=no,scrollbars=yes,toolbar=no')
	}
	
	function openmemwindow(id){	
		wizwindow('./member/member1_1.php?id='+id, 'regisform','width=650,height=600,statusbar=no,scrollbars=yes,toolbar=no')
	}
	
	function showBillcheck(uid){
		wizwindow('./order/order6_1.php?uid='+uid, 'billform','width=650,height=200,statusbar=no,scrollbars=yes,toolbar=no')
	}
	
	function checkForm(f){
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
			alert('삭제하고자 하는 상품에 체크해주시기 바랍니다.');
			return false;
		}
		if (confirm('\n\n삭제하는 제품은 DB에서 삭제되어 복구가 불가능합니다.\n\n정말로 삭제하시겠습니까?\n\n')) return true;
		return false;
	}
	
	function gotoPage(cp){
		$("#cp").val(cp);
		$("#sform").submit();
	}
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">세금계산서/현금영수증 발행</div>
	  <div class="panel-body">
		 아래는 현금영수증 혹은 세금계산서 발행요청/결과 리스트 입니다
	  </div>
	</div>
	
	<form action='<?=$PHP_SELF?>' method="post" id="sform">
		<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
		<input type='hidden' name='menushow' value='<? echo $menushow?>'>
		<input type="hidden" name="theme"  value='<? echo $theme?>' >
		<input type="hidden" name="cp" id="cp"  value='<? echo $cp?>' >
		<table>
			<tbody>
				<tr>
					<td><select name="stitle">
							<option value="" selected>검색영역</option>
							<option value="">----------</option>
							<option value='b.oid'<? if($stitle=='b.oid'){ echo " selected";}?>>주문번호</option>
							<option value='b.cname'<? if($stitle=='b.cname'){ echo " selected";}?>>신청자명</option>
						</select>
					</td>
					<td><input size=10 name="skey" value='<?=$skey?>'></td>
					<td>
						<button type="submit" class="btn btn-primary btn-xs">검색</button>
						<button type="button" class="btn btn-default btn-xs" onClick="location.replace('<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=order1')">리스트</button>
					</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</tbody>
		</table>
	</form>
			
<?
/* 페이징과 관련된 수식 구하기 */
$ListNo = "15";
$PageNo = "20";
if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $ListNo;
$whereis = " WHERE 1";
if ($stitle && $skey) {$whereis .= " and $stitle LIKE '%$skey%'";}

if($orderby_select == "") $orderby_select = "b.uid"; 
switch($orderby_select){
	case "b.uid":
		$orderby = "ORDER BY $orderby_select DESC";
	break;
	default:
		$orderby = "ORDER BY $orderby_select DESC";
	break;
}


$sqlstr = "SELECT count(1) FROM wizBillcheck b $whereis";
$TOTAL = $dbcon->get_one($sqlstr);

$LIST_QUERY = "SELECT b.*, bu.uid as buuid, bu.AmountOline, bu.PayMethod, bu.OrderStatus  FROM wizBillcheck b
				left join wizBuyers bu on b.oid = bu.OrderID 
 $whereis $orderby LIMIT $START_NO,$ListNo";
$TABLE_DATA = $dbcon->_query($LIST_QUERY);

$TOTAL_QUERY = $dbcon->_query( "SELECT SUM(TotalAmount) FROM wizBuyers WHERE  OrderStatus < 50 ");
$TOTAL_SMONEY = $dbcon->_fetch_array($TOTAL_QUERY);
$TOTAL_SMONEY = $TOTAL_SMONEY[0];

$NO = $TOTAL-($ListNo*($cp-1));
?>
			<form action='<?=$PHP_SELF?>' name='receiptList' onsubmit='return checkForm(this)'>
				<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
				<input type="hidden" name="menushow" value='<?=$menushow?>'>
				<input type="hidden" name="theme" value='<?=$theme?>'>
				<input type="hidden" name="cp" value='<?=$cp?>'>
				<input type="hidden" name="d_mode" value='d_delete'>
				<table class="table table-hover table-striped">
					<col width="40" />
					<col width="*" />
					<col width="80" />
					<col width="80" />
					<col width="80" />
					<col width="80" />	
					<col width="80" />
					<col width="80" />
					<col width="80" />
					<col width="70" />			
					<thead>
						<tr class="success">
							<th>&nbsp; </th>
							<th>주문번호</th>
							<th>발행금액</th>
							<th>결제방법</th>
							<th>주문상태</th>
							<th>신청자명<br />
								/회사명</th>
							<th>발행방식</th>
							<th>발행상태</th>
							<th>요청일시</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
<?php
$cnt=0;		
while( $list = $dbcon->_fetch_array( $TABLE_DATA ) ) :
		$uid			= $list["uid"];
		$oid			= $list["oid"]; 
		$buuid			= $list["buuid"];
		$AmountOline	= $list["AmountOline"];
		$cname			= $list["cname"];
		$mid			= $list["mid"];
		$ptype			= $list["ptype"];
		switch($ptype){
			case "1":$ptypestr="세금계산서";break;
			case "2":$ptypestr="현금영수증";break;
		}
		$presult			= $list["presult"];
		switch($presult){
			case "1":$presultstr="신청";break;
			case "2":$presultstr="완료";break;
			case "3":$presultstr="취소";break;
		}
		$rdate			= $list["rdate"];
		$PayMethod 		= $list["PayMethod"];
		$PayWay = trim($PayMethod)?$PaySortArr[$PayMethod]:"온라인";
		$OrderStatus	= $list["OrderStatus"];
		
		//상품정보가져오기
		
?>
						<tr>
							<td width=30><input type="checkbox" value="<?=$uid?>" name="multi[<?=$uid?>]"></td>
							<td><a  href="javascript:openorderwindow(<?=$buuid?>)">
								<?=$oid?>
								</a></td>
							<td><?=number_format($AmountOline);?></td>
							<td><?=$PayWay?></td>
							<td><?=$DeliveryStatusArr[$OrderStatus];?></td>
							<td><a  href="javascript:openmemwindow('<?=$mid?>')">
								<?=$cname?>
								</a> </td>
							<td><?=$ptypestr?>
							</td>
							<td>&nbsp;
								<?=$presultstr?></td>
							<td><?=date("Y.m.d", $rdate)?></td>
							<td><input type="button" name="button" id="button" value="보기" style="cursor:pointer" onclick="showBillcheck('<?=$uid?>');">
							</td>
						</tr>
						<?php
$NO--; 
$cnt++;
endwhile;
?>
						<?php
if(!$cnt){
?>
						<tr>
							<td colspan="10">요청된 정보가 없습니다.</td>
						</tr>
						<?
}
?>
					</tbody>

				</table>
				<div>
					<button type="submit" class="btn btn-default btn-xs">삭제</button>
				</div>
			</form>
	<div class="text-center">
<?php
$params = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL, "type"=>"bootstrappost"); 
echo $common->paging($params);
?>
	</div>		
</div>
