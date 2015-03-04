<?php
/*

 제작자 : 폰돌                     
 URL : http://www.shop-wiz.com    
 Email : master@shop-wiz.com       
 Copyright (C) 2003  shop-wiz.com 
*/
if(!$cfg["member"]){
	$common->js_alert("로그인후 이용해주시기 바랍니다.","wizmember.php?query=login");
}
if($cfg["member"]["mgrade"] == "admin"){//관리자 단에서 넘어올경우 몇몇 변수값을 변경한다.
	$cfg["member"]["mid"] = $mid;
}


?>
<script language="javascript">
<!--
	function gotoOrderInfo(oid){
		location.href = "<?=$PHP_SELF?>?query=order_spec&OrderID="+oid; 
	}
	
	function Repay(oid){
		location.href = "wizbag.php?query=step3&RepayOrderID="+oid; 
	}
	
	function getDeliveryStatus(targeturl, arg, argvalue, method){//리스트에서 주문조회용
		var url = "./skinwiz/common/delivery.php?targeturl="+targeturl+"&arg="+arg+"&argvalue="+argvalue+"&method="+method;
		wizwindow(url,'DeliveryCheckWindow','');
		//사용법 <a href="getDeliveryStatus('<?=$d_inquire_url?>','<?=$d_code?>', '<?=$InvoiceNo?>', '<?=$d_method?>')">배송조회</a>
	}
//-->
</script>

<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active">주문 조회</li>
</ul>

<div class="panel">
	주문 조회
  
	<div class="panel-footer">고객님께서 주문하신 내역입니다.<br />
회원가입후 현재까지 <?php echo $cfg["member"]["mname"]."(".$cfg["member"]["mid"].")";?> 의 주문내역 
			입니다.<br />
주문번호를 클릭하면 자세한 사항을 보실 수 있습니다. <br />
	</div>
</div>

<table class="table table-striped table-hover">
		<col width="50" title="" />
		<col width="80" title="주문번호" />
		<col width="*" title="상품명" />
		<col width="70" title="구매금액" />
		<col width="70" title="결제방식" />
		<col width="70" title="거래상태" />
		<col width="100" title="주문일시" />
		<col width="70" title="상세내역" />
		<col width="50" title="재결제" />
		<thead>
	<tr>
		<th class="text-center">&nbsp;</th>
		<th class="text-center">주문번호</th>
		<th class="text-center">상품명</th>
		<th class="text-center">구매금액</th>
		<th class="text-center"> 결제방식</th>
		<th class="text-center"> 거래상태</th>
		<th class="text-center">주문일시</th>
		<th class="text-center">상세내역</th>
		<th class="text-center">재결재</th>
	</tr>
	</thead>
	<tbody>
	<?
$ListNo = "15";
$PageNo = "20";
if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $ListNo;

$whereis = "WHERE b.MemberID='".$cfg["member"]["mid"]."'";
$sqlstr = "SELECT count(1) FROM wizBuyers b $whereis";
$TOTAL=$dbcon->get_one($sqlstr);
$TOTAL_SMONEY = $dbcon->get_one( "SELECT SUM(TotalAmount) FROM wizBuyers b $whereis");


$NO = $TOTAL-($ListNo*($cp-1));
$orderby = "b.UID DESC";
$sqlqry = $dbcon->get_select('b.*, d.d_name, d.d_code, d.d_url, d.d_inquire_url, d.d_method','wizBuyers b left join wizdeliver d on b.Deliverer = d.uid',$whereis, $orderby, $START_NO, $ListNo);
while( $list = $dbcon->_fetch_array($sqlqry)) :
	$SUB_SMONEY		= $SUB_SMONEY + $list["TotalAmount"];
	$PayMethod		= $list["PayMethod"];
	$OrderStatus	= $list["OrderStatus"];
	$BuyDate		= $list["BuyDate"];
	$OrderID		= $list["OrderID"];
	$InvoiceNo		= $list["InvoiceNo"];
	
	$d_name			= $list["d_name"];
	$d_code			= $list["d_code"];
	$d_url			= $list["d_url"];
	$d_inquire_url	= $list["d_inquire_url"];
	$d_method		= $list["d_method"];
	
?>
	<tr>
		<td><?=$NO?>
		</td>
		<td><a href="javascript:gotoOrderInfo('<?=$OrderID?>')">
			<?=$OrderID?>
			</a></td>
		<td><?
				  
$substr = "select m.*, c.uid as cuid, c.*  from wizMall m left join wizCart c on m.UID = c.pid where c.oid = '".$OrderID."' order by c.uid asc";
$subqry = $dbcon->_query($substr);
$i=0;
$SUM_MONEY = 0;
$TOTAL_MONEY = 0;
$subcnt=0;

while($sublist = $dbcon->_fetch_array($subqry)):
	$Picture = explode("|", $sublist[Picture]);
	if($subcnt==0){
		if($sublist[Model]) echo "(".$sublist[Model].")";
		echo $sublist[Name];
	}
	$subcnt++;
endwhile;

if($subcnt > 1) echo " 외 ".($subcnt-1)."건";

?></td>
		<td class="agn_r"><?=number_format($list[TotalAmount])?>
			원</td>
		<td class="agn_c"><?=$PaySortArr[$PayMethod]?></td>
		<td class="agn_c"><?=$DeliveryStatusArr[$OrderStatus];?></td>
		<td class="agn_c"><?=date("Y.m.d",$BuyDate)?></td>
		<td class="agn_c"><input type="button" name="button" id="button" value="상세내역" style="cursor:pointer" onclick="gotoOrderInfo('<?=$OrderID?>')"></td>
		<td class="agn_c"><input type="button" name="button2" id="button2" value="결제" style="cursor:pointer" onclick="Repay('<?=$OrderID?>')">
		</td>
	</tr>
	<?
$NO--;
endwhile;
?>
</tbody>
</table>
<div>현재페이지 합계금액 : <font color="E37509">
	<?=number_format($SUB_SMONEY)?>
	원| 총 주문금액 : <font color="703EAE">
	<?=number_format($TOTAL_SMONEY);?>
	원 </div>
<div class="paging_box">
	<?
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
$page_arg1 = $PHP_SELF."?query=order";
$page_arg2 = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL); 
//$page_arg3 = array("pre"=>"./img/pre.gif","next"=>"./img/next.gif");
echo $common->paging($page_arg1,$page_arg2,$page_arg3);
?>
</div>
