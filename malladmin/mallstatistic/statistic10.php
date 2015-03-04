<?
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/
if(!$year) $year = date("Y");
if(!$month) $month = date("m");
if(!$day) $day = date("d");
$startday = mktime(0,0,0,$month,$day,$year);
$endday = mktime(0,0,0,$month,$day+1,$year);
?>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">일일 판매 분석</div>
	</div>

			<form action='<?=$PHP_SELF?>' method="post">
				<input type='hidden' name='menushow' value='<?=$menushow?>'>
				<input type="hidden"  name="theme"  value='<?=$theme?>' >
				<table>
					<tr>
						<td colspan="4"><?
							//echo "adfasdf";
if ($day&&$month&&$year) $tdate = mktime(0,0,0,$month,$day,$year);
else $tdate = $WizApplicationStartDate;
$common->startyear = date("Y", $WizApplicationStartDate);
$common->getSelectDate($tdate);
?>
							Year 
							:
							<select name="year">
								<?=$common->rtn_year ?>
							</select>
							&nbsp;&nbsp; Month :
							<select name="month">
								<?=$common->rtn_month ?>
							</select>
							&nbsp; Day :
							<select name="day">
								<?=$common->rtn_day ?>
							</select>
							<button type="submit" class="btn btn-primary">검색</button></td>
						<td><div>
								<!-- <select style="width: 140px" onChange=this.form.submit() name=where>
                  <option>전체회원</option>
                  <option value="general">일반회원</option>
                  <option value="company">기업회원</option>
                </select> -->
							</div></td>
					</tr>
				</table>
			</form>
			<br />
			* 주의 : 카드결제 성공시 "입금확인됨" 단계, 실패시는 
			"결제실패"단계. 카드결제시는 카드사 관리자 모드에서 한 번더 확인 바람 <br />
			<table class="table table-hover table-striped">
				<col width="60" />
				<col width="*" />
				<col width="*" />
				<col width="*" />
				<col width="*" />
				<thead>
					<tr class="success">
						<th>&nbsp; </th>
						<th>주문번호</th>
						<th>구매금액</th>
						<th>주문자</th>
						<th>주문일시</th>
					</tr>
				</thead>
				<tbody>
					<?
$orderby = "UID@desc";

$SUB_SMONEY = 0;
$whereis = "WHERE  BuyDate between $startday and $endday"; 
$dbcon->get_select('UID, TotalAmount,OrderID, MemberID, BuyDate','wizBuyers b ',$whereis, $orderby);	
$cnt=0;
while( $list = $dbcon->_fetch_array( ) ) :
	$UID			= $list["UID"];
	$TotalAmount	= $list["TotalAmount"];
	$OrderID		= $list["OrderID"];
	$MemberID		= $list["MemberID"];
	$BuyDate		= $list["BuyDate"];
?>
					<tr>
						<td width=30><?=$NO?>
						</td>
						<td><font color="black"><a href="javascript:openorderwindow('<?=$UID?>')">
							<?=$OrderID?>
							</a></td>
						<td><?=number_format($TotalAmount);?>
							원</td>
						<td><a href="javascript:getuserInfo('<?=$MemberID?>');">
							<?=$MemberID?>
							</a></td>
						<td><? echo date("Y.m.d H:i",$BuyDate);?> </td>
					</tr>
					<?
$SUB_SMONEY += $TotalAmount;
endwhile;
?>
				</tbody>
				<tr>
					<td colspan=5>현재페이지 합계금액 :
						<?=number_format($SUB_SMONEY);?>
						원</td>
				</tr>
			</table>
			<br />
			<table>
				<tr>
					<td></td>
				</tr>
			</table></div>
