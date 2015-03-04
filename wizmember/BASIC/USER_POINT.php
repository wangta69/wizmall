<?
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

<div class="navy">Home &gt; 적립금 보기</div>
<fieldset class="desc">
<legend>[안내]</legend>
<div class="notice">적립금 보기</div>
<div class="comment">
<? echo $mname."(".$mid.")";?>님의 포인트내역입니다.</div>
</fieldset>

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
		<?
/* 페이징과 관련된 수식 구하기 */
$WHERE = "WHERE id = '".$mid."'";
$sqlstr = "SELECT * FROM wizPoint $WHERE";
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
			<td><?=$BOARD_NO?>
			</td>
			<td><?
echo $point_str;
?>
			</td>
			<td><?=number_format(str_replace("-","",$list["point"]))?>
				<?
if (eregi("-", $list["point"])) {
ECHO "<OPTION style='color:red;'>감산(-)<OPTION>";
$ORDER_MSG = "<FONT COLOR=ORANGE>(거래취소)";
}
else {
ECHO "<OPTION style='color:blue;'>가산(+)<OPTION>";
$ORDER_MSG = "(거래완료)";
}
?>
			</td>
			<td><?=date("Y/m/d", $list["wdate"])?>
			</td>
		</tr>
		<?
$SUB_SMONEY += $list[point];
$BOARD_NO--;
endwhile;

$pointstr = "select sum(point) from wizPoint $WHERE";
$totalpoint = $dbcon->get_one($pointstr);
?>
	</tbody>
</table>
현재페이지 포인트 : <?ECHO number_format($SUB_SMONEY);?> 포인트 | 총 획득 포인트 : <?ECHO number_format($totalpoint);?> 포인트
<div class="paging_box">
	<?
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
$page_arg1 = $PHP_SELF."?query=point";
$page_arg2 = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL); 
$page_arg3 = array("pre"=>"./wizmember/".$cfg["skin"]["MemberSkin"]."/images/pre.gif","next"=>"./wizmember/".$cfg["skin"]["MemberSkin"]."/images/next.gif");
echo $common->paging($page_arg1,$page_arg2,$page_arg3);
?>
</div>
