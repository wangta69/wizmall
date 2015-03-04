<?php
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/

switch($OrderStatus){
	case "50":
		$title = "주문완료상품";
	break;
	case "60":
		$title = "반송상품";
	break;
	default:
		$title = "주문 및 배송상품";
	break;
}

$whereis = "where 1";
if(!$orderstatus) $whereis .= " AND OrderStatus < 50 ";
else $whereis .= " AND OrderStatus = ".$orderstatus." ";
if ($stitle && $keyword) {$whereis .= " and $stitle LIKE '%$keyword%'";}
if (!$sel_orderby) $sel_orderby = "UID@desc";
//if ($orderstatus) $whereis .= " and OrderStatus=$orderstatus";
$orderby = $common->getorderby($sel_orderby);

## 날짜 검색부분 활성화
if ($SMonth&&$SDay&&$SYear)$stdate = mktime(0,0,0,$SMonth,$SDay, $SYear);
else $stdate = $WizApplicationStartDate;

if ($FYear&&$FMonth&&$FDay) $ftdate = mktime(0,0,0,$FMonth,$FDay, $FYear);
else $ftdate = time();

if($DataEnable) $whereis .= " and BuyDate between $stdate AND $ftdate ";

$sqlstr = "SELECT count(*) FROM wizBuyers b ".$whereis;
$TOTAL = $common->gettotal($sqlstr);

$TOTAL_SMONEY = $dbcon->get_one( "SELECT SUM(TotalAmount) FROM wizBuyers b $whereis ");
$NO = $TOTAL-($ListNo*($cp-1));
?>
<script>
	$(function(){
		$(".btnExcel").click(function(){

		});
	});
	
	function gotoPage(cp){
		$("#cp").val(cp);
		$("#sform").submit();
	}
	
	function gototermSearch(flag){
		var f = document.SerchForm;
		f.SYear.value	="<?=date("Y")?>";
		f.SMonth.value	="<?=date("m")?>";
		f.SDay.value	="<?=date("d")?>";
		f.FYear.value	="<?=date("Y")?>";
		f.FMonth.value	="<?=date("m")?>";
		f.FDay.value	="<?=date("d")?>";
		switch(flag){
			case "year":
				f.SMonth.value	="01";
				f.SDay.value	="01";
			break;
			case "month":
				f.SDay.value	="01";
			break;
			case "day":
			break;
		}
		f.DataEnable.checked = true;
		f.submit();		
	}
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading"><?=$title?></div>
	  <div class="panel-body">
		 주문번호를 클릭시 현재 주문상품 및 배송지에 대한 자세한 내용을 보실 수 있으며 더불어 현재 거래상태를 
				변경하실 수 있습니다.<br />
				거래상태를 변경하시면 고객이 주문번호 혹은 로그인만으로도 주문상태를 확인할 수있습니다.<br />
				주문자를 클릭하시면 주문자의 상세정보를 보실 수 있습니다.<br />
				* 주의: 카드결제 성공시 거래상태가 "입금확인됨" 단계, 
				실패시는 "결제실패"로 표시되지만 인터페이스상의 문제로 반드시 
				카드결제시는 카드사 관리자 모드에서 반드시 한 번더 확인 바랍니다. 
	  </div>
	</div>
	<form action='<?=$PHP_SELF?>' method="post" name="SerchForm" id="sform">
		<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
		<input type="hidden" name="menushow" value='<? echo $menushow?>'>
		<input type="hidden" name="theme" value='<? echo $theme?>' >
		<input type="hidden" name="theme" value='<? echo $theme?>' >
		<input type="hidden" name="cp" id="cp" value='<? echo $cp?>' >
		<table class="table">
		
			<tr>
				<td><?=$admin->sel_order_stitle($stitle);?></td>
				<td><input size="10" name="keyword" value='<?=$keyword?>'></td>
				<td>
					<button type="submit" class="btn btn-primary btn-xs">검색</button>
					<button type="button" class="btn btn-default btn-xs" onClick="location.replace('<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=<?=$theme?>')">리스트</button>
				</td>
				<td><?=$admin->sel_order_status($DeliveryStatusArr, $orderstatus) ?>
				</td>
				<td><?=$admin->sel_order_order($sel_orderby);?></td>
			</tr>
			<tr>
				<td colspan="5"><table>
						<tr>
							<td><?
$common->startyear = date("Y", $WizApplicationStartDate);
$common->getSelectDate($stdate);
?>
								&nbsp;
								<select name='SYear' size='1'>
									<?=$common->rtn_year ?>
								</select>
								<select name='SMonth' size='1'>
									<?=$common->rtn_month ?>
								</select>
								<select name='SDay' size='1'>
									<?=$common->rtn_day ?>
								</select>
								~
								<?
$common->getSelectDate($ftdate);
?>
								<select name='FYear' size='1'>
									<?=$common->rtn_year ?>
								</select>
								<select name='FMonth' size='1'>
									<?=$common->rtn_month ?>
								</select>
								<select name='FDay' size='1'>
									<?=$common->rtn_day ?>
								</select>
								<input type="checkbox" name="DataEnable" value="1"<? if($DataEnable) echo " checked";?> />
								Enable </td>
							<td><a  href="javascript:gototermSearch('year')">[
								<?=date("Y")?>
								년]</a></td>
							<td><a  href="javascript:gototermSearch('month')">[
								<?=date("m")?>
								월]</a></td>
							<td><a  href="javascript:gototermSearch('day')">[
								<?=date("d")?>
								일]</a></td>
						</tr>
					</table></td>
			</tr>
		</table>
	</form>
			* 주의 : 카드결제 성공시 "입금확인됨" 단계, 실패시는 
			"결제실패"단계. 카드결제시는 카드사 관리자 모드에서 한 번더 확인 바람 <br />
			<div>
					<span class="button bull btnExcel"><a href="./order/order1_4.php?DownForExel=yes&ListNo=<?=$ListNo?>&PageNo=<?=$PageNo?>&cp=<?=$cp?>">엑셀출력</a></span>
					</div>
		
			<table class="table table-hover table-striped">
				<col width="50" /><!--  -->
				<col width="90" /><!-- 주문번호 -->
				<col width="70" /><!-- 구매금액 -->
				<col width="70" /><!-- 결제방식 -->
				<col width="70" /><!-- 거래상태 -->
				<col width="*" /><!-- 주문자 -->
				<col width="100" /><!-- 전화 -->
				<col width="80" /><!-- 상호 -->
				<col width="100" /><!-- 주문일시 -->
				<thead>
					<tr class="success">
						<th class="agn_c">&nbsp; </th>
						<th class="agn_c">주문번호</th>
						<th class="agn_c">구매금액</th>
						<th class="agn_c">결제방식</th>
						<th class="agn_c">거래상태</th>
						<th class="agn_c">주문자</th>
						<th class="agn_c">전화</th>
						<th class="agn_c">상호</th>
						<th class="agn_c">주문일시</th>
					</tr>
				</thead>
				<tbody>
<?php
$dbcon->get_select('*','wizBuyers b',$whereis, $orderby, $START_NO, $ListNo);
while( $list = $dbcon->_fetch_array()) :
        $RAddress1 = explode(" ", $list[RAddress1]);
		$BankInfo = explode("|", $list[BankInfo]);
        $SUB_SMONEY = $SUB_SMONEY + $list[TotalAmount];
		$OrderStatus = $list[OrderStatus];
		$PayMethod = $list[PayMethod];
		$PayWay = trim($PayMethod)?$PaySortArr[$PayMethod]:"온라인";
        //--------------------------------------------------
        if (!$list[MemberID]) {$list[MemberID] = "비회원";}

$tmp_color = array("A"=>"blue","B"=>"green","C"=>"orange","D"=>"brown","E"=>"red"); 
$DeveryStatus = "<font color='".$tmp_color[$OrderStatus]."'>".$DeliveryStatusArr[$OrderStatus]."";
if(($PayWay == "신용카드" || $PayWay == "핸드폰" || $PayWay == "자동이체") && $OrderStatus == 10) $DeveryStatus = "결제실패";
?>
					<tr>
						<td><?=$NO?></td>
						<td><a  href="javascript:openorderwindow(<?=$list[UID]?>)">
							<?=$list[OrderID]?>
							</a></td>
						<td><?=number_format($list[TotalAmount]);?>
							원</td>
						<td>
<?php 
if(!strcmp($list[PayMethod],"card") || !strcmp($list[PayMethod],"all")) echo "<a  href='".$PgCorpArr[$cfg["pay"]["CARD_PACK"]]."' target='_blank'><font color='GREEN'>$PayWay</a>";
else echo "$PayWay";
?>
							</a> </td>
						<td><?=$DeveryStatus?>
						</td>
						<td><a  href="javascript:getuserInfo('<?=$list[MemberID]?>')">
							<?=$list[SName]?>
							(
							<?=$list[MemberID]?>
							)</a> </td>
						<td><?=$list[STel1]?></td>
						<td><?=$list[RCompany]?>
						</td>
						<td><? echo date("Y.m.d H:i",$list[BuyDate]);?></td>
					</tr>
<?php
$NO--; 
endwhile;
?>
				</tbody>
				<tr>
					<td colspan=9>현재페이지 합계금액 :
						<?=number_format($SUB_SMONEY);?>
						원 | 
						주문대기 총금액 :
						<?=number_format($TOTAL_SMONEY);?>
						원</td>
				</tr>
			</table>
	
	<div class="text-center">
<?php
$params = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL, "type"=>"bootstrappost"); 
echo $common->paging($params);
?>
	</div>
</div>

