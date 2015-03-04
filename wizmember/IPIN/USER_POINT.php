<?php
/*
제작자 : 폰돌
제작자 URL : http://www.shop-wiz.com
제작자 Email : master@shop-wiz.com
Free Distributer 

*** Updating List ***
*/

if(!$cfg["member"]) $common->js_alert("로그인후 이용해주시기 바랍니다.","wizmember.php?query=login");

$mid	= $cfg["member"]["mid"];
$mname	= $cfg["member"]["mname"];
?>
<script>
function gotoPage(cp){
	$("#cp").val(cp);
	$("#sform").submit();
}
</script>
<form id="sform">
	<input type="hidden" name="cp" id="cp" value="<?php echo $cp?>" />	
	<input type="hidden" name="query" value="<?php echo $query?>" />
</form>
<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active">적립금 보기</li>
</ul>

<div class="panel">
	적립금 보기
  
	<div class="panel-footer">
<? echo $mname."(".$mid.")";?>님의 적립금내역입니다.
	</div>
</div>

<table class="table_main w100p">
	<thead>
		<tr>
			<th>번호</th>
			<th>적립내역</th>
			<th>지급량</th>
			<th>지급일</th>
		</tr>
	</thead>
	<tbody>
<?php
/* 페이징과 관련된 수식 구하기 */
$WHERE = "WHERE id = '".$mid."'";
$sqlstr = "SELECT * FROM wizPoint ".$WHERE;
$dbcon->_query($sqlstr);
$TOTAL = $dbcon->_num_rows();

$ListNo = "15";
$PageNo = "20";

if(empty($cp) || $cp <= 0) $cp = 1;
//--페이지 나타내기--

$START_NO = ($cp - 1) * $ListNo;
$BOARD_NO=$TOTAL-($ListNo*($cp-1));

$SUB_SMONEY = 0;
$orderby = "order by wdate DESC";
$dbcon->get_select('*','wizPoint',$WHERE, $orderby, $START_NO, $ListNo);
while( $list = $dbcon->_fetch_array()) :
$str		= $list["contents"];
$point_str	= $common->point_dsc($str);
?>
		<tr>
			<td><?php echo $BOARD_NO?>
			</td>
			<td><?php
echo $point_str;
?>
			</td>
			<td><?php echo number_format(str_replace("-","",$list["point"]))?>
<?php
$pos = strpos($list["point"], "-");
if ($pos!== false) {
	echo "<option style='color:red;'>감산(-)<option>";
	$ORDER_MSG = "<font color=orange>(거래취소)";
}
else {
	echo "<option style='color:blue;'>가산(+)<option>";
	$ORDER_MSG = "(거래완료)";
}
?>
			</td>
			<td><?php echo date("Y/m/d", $list["wdate"])?>
			</td>
		</tr>
<?php
$SUB_SMONEY += $list["point"];
$BOARD_NO--;
endwhile;

$pointstr = "select sum(point) from wizPoint ".$WHERE;
$totalpoint = $dbcon->get_one($pointstr);
?>
	</tbody>
</table>
현재페이지 포인트 : <?php echo number_format($SUB_SMONEY);?> 포인트 | 총 획득 포인트 : <?php echo number_format($totalpoint);?> 포인트
<div class="paging_box">
<?php

$params = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL, "type"=>"bootstrappost"); 
echo $common->paging($params);
?>
</div>
