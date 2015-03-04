<?php
/*
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***

*/
include "./mallstatistic/common.php";
$FromDate = mktime(0,0,0,$SMonth,$SDay, $SYear);
$ToDate = mktime(23,59,0,$FMonth,$FDay, $FYear);
?>

<script  language="javascript" src="../js/jquery.plugins/jquery.wizchart-1.0.3.js"></script>
<script>
$(function(){
    $(".uniquebar").chart({ height:5,bgcolor:"blue"});
});
</script>


<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">구매지역 분석 통계</div>
	</div>


			<form action='<?=$PHP_SELF?>' name=view_form method="post">
				<input type='hidden' name='menushow' value='<?=$menushow?>'>
				<input type="hidden" name="theme" value='<?=$theme?>'>
				<input type="hidden" name="action" value='term_search'>
				<select name=add>
					<option value=''>주문지역</option>
					<option value=''>---------</option>
					<option value="서울"<?if($add=='서울'){echo " selected";}?>>서울</option>
					<option value="부산"<?if($add=='부산'){echo " selected";}?>>부산</option>
					<option value="대구"<?if($add=='대구'){echo " selected";}?>>대구</option>
					<option value="인천"<?if($add=='인천'){echo " selected";}?>>인천</option>
					<option value="광주"<?if($add=='광주'){echo " selected";}?>>광주</option>
					<option value="대전"<?if($add=='대전'){echo " selected";}?>>대전</option>
					<option value="울산"<?if($add=='울산'){echo " selected";}?>>울산</option>
					<option value="경기"<?if($add=='경기'){echo " selected";}?>>경기</option>
					<option value="강원"<?if($add=='강원'){echo " selected";}?>>강원</option>
					<option value="충북"<?if($add=='충북'){echo " selected";}?>>충북</option>
					<option value="충남"<?if($add=='충남'){echo " selected";}?>>충남</option>
					<option value="경북"<?if($add=='경북'){echo " selected";}?>>경북</option>
					<option value="경남"<?if($add=='경남'){echo " selected";}?>>경남</option>
					<option value="전북"<?if($add=='전북'){echo " selected";}?>>전북</option>
					<option value="전남"<?if($add=='전남'){echo " selected";}?>>전남</option>
					<option value="제주"<?if($add=='제주'){echo " selected";}?>>제주</option>
				</select>
				<select name=mem>
					<option value=''>주문자구분</option>
					<option value=''>---------</option>
					<option value="member"<?if($mem=='member'){echo " selected";}?>>회원</option>
					<option value="nonmember"<?if($mem=='nonmember'){echo " selected";}?>>비회원</option>
				</select>
				<button type="submit" class="btn btn-default btn-xs">검색</button>
			</form>
			<br />
			<?
//------------------------- 전체
$list = $sta->get_pay_method1(null,$action, $add, $mem, $FromDate, $ToDate);
$total_price = $list[0] ? $list[0]:0.1;
$total_qty = $list[1]?$list[1]:0.1;
//------------------------- 전체
?>
			<table class="table table-hover table-striped">
				<col width="70" />
				<col width="70" />
				<col width="70" />
				<col width="70" />
				<col width="*" />
				<thead>
					<tr class="success">
						<th>결제지역</th>
						<th>매출건수</th>
						<th>매출비율</th>
						<th>매출액</th>
						<th>그래프(오차범위:1%이내)</th>
					</tr>
				</thead>
				<tbody>
					<?
$ADD_ARRAY = array("서울","부산","대구","인천","광주","대전","울산","경기","강원","충북","충남","경북","경남","전북","전남","제주");
for ($i = 0; $i < sizeof($ADD_ARRAY); $i++) {
	$list = $sta->get_pay_method1($key, $action, $ADD_ARRAY[$i], $mem, $FromDate, $ToDate);
	$out_price = $list[0];
	$out_qty = $list[1];
	$percen = intval(($out_qty / $total_qty) * 100);
	$grp_width = $percen * 2;
?>
					<tr>
						<td><?=$ADD_ARRAY[$i]?>
						</td>
						<td><?ECHO number_format($ADD_DATA_NUM1);?>건</td>
						<td><?ECHO $ADD_PER1;?>%</td>
						<td><?ECHO number_format($ADD_SMONEY1);?>원</td>
						<td> <div ratio="<?php echo $ADD_PER1;?>" class="uniquebar" alt='Unique : <?=$data["unique_counter"]?>'></div>
							<?=$ADD_PER1?>
							%</td>
					</tr>
					<?
}
?>
				</tbody>
			</table>
			<br />
			<table class="table">
				<form action='<?=$PHP_SELF?>' method="post">
					<input type='hidden' name='menushow' value='<?=$menushow?>'>
					<input type="hidden" name="theme" value='<?=$theme?>'>
					<input type="hidden" name="action" value='detail_search'>
					<tr >
						<td colspan="7"><?
							//echo "adfasdf";
if ($SMonth&&$SDay&&$SYear) $tdate = mktime(0,0,0,$SMonth,$SDay, $SYear);
else $tdate = $WizApplicationStartDate;
$common->startyear = date("Y", $WizApplicationStartDate);
$common->getSelectDate($tdate);
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
if ($FYear&&$FMonth&&$FDay) $tdate = mktime(0,0,0,$FMonth,$FDay, $FYear);
else $tdate = time();
$common->getSelectDate($tdate);

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
							<button type="submit" class="btn btn-primary">검색</button>
							<table>
								<tr>
									<td><?
for ($i = "01"; $i < 13; $i++){
        if ($i != $SMonth) {
        ECHO "[<a href='$PHP_SELF?menushow=$menushow&theme=$theme&action=detail_search&SYear=".date("Y")."&SMonth=$i&SDay=01&FYear=".date("Y")."&FMonth=$i&FDay=31'><font color=#333333>$i</a>] ";
        }
        else {
        ECHO "[$i] ";
        }
}
?>
										월</td>
								</tr>
							</table></td>
						<td colspan="2">매출 건수 :
							<?=number_format($total_qty);?>
							건<br />
							매출 총액 :
							<?=number_format($total_price);?>
							원</td>
					</tr>
				</form>
			</table></div>