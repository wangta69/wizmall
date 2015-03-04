<?php
include "./mallstatistic/common.php";

$total_date = $sta->get_total_sale_price();
?>
<script  language="javascript" src="../js/jquery.plugins/jquery.wizchart-1.0.3.js"></script>
<script>
$(function(){
    $(".uniquebar").chart({ height:5,bgcolor:"blue"});
});


function gotoPage(cp){
	$("#cp").val(cp);
	$("#sform").submit();
}
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">제품 조회/판매 통계</div>
	  <div class="panel-body">
		 제품 조회 통계는 카테고리별, 제품별 조회수를 표시하고 조회별 판매량을 표시합니다.<br />
				고객의 관심도(성향) 및 실지 구매로의 연결등을 분석함으로써 더욱 효과적인 판매전략을 구상하실 수 있습니다.<br />
				기본 리스트는 조회순으로 정렬되어있습니다.<br />
				카테고리별, 제품별 판매량이나 금액은 현재 몰에서 판매되지 않는(삭제된) 제품은 제외되고 배송비 및 카드수수료등의 
				변수등에 의해 실제 총판매량이나 총판매액과 다를 수가 있습니다.<br />
				입고량에 대한 판매비율에서 입고량을 100%로 보고 계산되어짐.
	  </div>
	</div>



				<form action='<?=$PHP_SELF?>' method="POST" name="SortForm" id="sform">
					<input type="hidden" name="menushow" value=<?=$menushow?>>
					<input type="hidden" name="theme"  value=<?=$theme?>>
					<input type="hidden" name="cp" id="cp" value='<?=$cp?>'>
					<input type="hidden" name="category" value="<?=$category?>">
					<input type="hidden" name="uid" value="">
<select style="width: 100px" onChange="SortbyCat(this)">
								<option value="">대분류</option>
								<option value="">-----------</option>
								<?
$mall->getSelectCategory(1, $category);
?>
							</select>
<select style="width: 100px"  onChange="SortbyCat(this)">
								<option value="">중분류</option>
								<option value="">-----------</option>
								<?
$mall->getSelectCategory(2, $category);
?>
							</select>
<select style="width: 100px"  onChange="SortbyCat(this)">
								<option value="">소분류</option>
								<option value="">-----------</option>
								<?
$mall->getSelectCategory(3, $category);
?>
							</select>
<? $admin->sel_pd_order($orderby);//정렬 ?>

				</form>

			<br />
			<table class="table table-hover table-striped">
				<col width="*" />
				<col width="*" />
				<col width="*" />
				<col width="*" />
				<thead>
					<tr class="success">
						<th> 총등록수</th>
						<th> 총조회수</th>
						<th> 총판매건수</th>
						<th> 총판매액</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?=number_format($total_date[count])?>
							EA</td>
						<td><?=number_format($total_date[hit])?>
							회</td>
						<td><?=number_format($total_date[tqty])?>
							EA</td>
						<td><?=number_format($total_date[tmount])?>
							원</td>
					</tr>
				</tbody>
			</table>
			<br />
			<table class="table table-hover table-striped">
				<col width="100" />
				<col width="100" />
				<col width="100" />
				<col width="*" />
				<thead>
					<tr class="success">
						<th> 매장 카테고리</th>
						<th> 조회수</th>
						<th> 판매수</th>
						<th> 판매량그래프(오차범위:1%이내)</th>
					</tr>
				</thead>
				<tbody>
					<?
$sqlstr="SELECT * FROM wizCategory WHERE length(cat_no)  = 3 ORDER BY cat_order ASC"; 
$sqlqry = $dbcon->_query($sqlstr);
while($list=$dbcon->_fetch_array($sqlqry)):
	$cat_no	= $list[cat_no];
	$substr = "SELECT sum(Hit) as hit, sum(Output) as tqty, sum(Output*Price) as tmount, count(*) as count FROM wizMall WHERE right(Category, 3) = '$cat_no'";
	$cat_list = $dbcon->get_row($substr);
	if ($total_date[tqty] && $cat_list[tqty]) {$cat_width = intval(($cat_list[tqty] / $total_date[tqty])*100);}
	else {$cat_width =0;}
	if ($cat_list[hit] && $cat_list[tqty]) {
	$cat_width1 = intval(($cat_list[tqty] / $cat_list[hit])*100);}
	else {$cat_width1 =0 ;}
?>
					<tr>
						<td>&nbsp;
							<?=$list[cat_name]?>
							
							<a href='<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=<?=$theme;?>&category=<?=$list[cat_no]?>&orderby=<?=$orderby?>&cp=<?=$cp;?>' class="btn btn-default btn-xs">more</a></td>
						<td><?=number_format($cat_list[hit])?>
							회</td>
						<td><?=number_format($cat_list[tqty])?>
							EA</td>
						<td>
						   <div ratio="<?php echo $cat_width;?>" class="uniquebar" alt='Unique : <?=$data["unique_counter"]?>'></div>
						    </td>
					</tr>
					<?
endwhile;
?>
				</tbody>
			</table>
			<br />
			현재 카테고리 : <span class="button bull"><a href='<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=<?=$theme?>'>총 매장</a></span>
						<?=$sta->get_cat_line($category,$menushow, $theme, $orderby, $cp);?>
			<table class="table table-hover table-striped">
				<col width="100" />
				<col width="100" />
				<col width="100" />
				<col width="100" />
				<col width="*" />
				<col width="100" />
				<thead>
					<tr class="success">
						<th>제품명/제조사</th>
						<th>가격/포인트</th>
						<th>조회량</th>
						<th>판매량</th>
						<th>입고량에따른 판매율</th>
						<th>제품별통계</th>
					</tr>
				</thead>
				<tbody>
					<?
$whereis = "where 1 and PID=UID";
$orderby = "hit@desc";
if ($category) $whereis .= " and Category like '%$category'";
 

$TOTAL_STR = "SELECT count(*) FROM wizMall $whereis";
$TOTAL = $dbcon->get_one($TOTAL_STR);

	  
$NO = $TOTAL-($listNo*($cp-1));

	
$cnt=0;
$qry = $dbcon->get_select('UID, Name, Model, Picture,Category, Price, Point, Hit, Output','wizMall',$whereis, $orderby, $START_NO, $ListNo);
while( $list = $dbcon->_fetch_array($qry) ) :
	$UID		= $list["UID"];
	$Name		= stripslashes($list[Name]);
	$Model		= stripslashes($list[Model]);
	$Picture	= explode("|",$list[Picture]); 
	$Category	= $list[Category]; 
	$Price		= $list[Price];
	$Point		= $list[Point];
	$Hit		= $list[Hit];
	$Output		= $list[Output];

	$input		= $sta->get_pd_in($UID);##입고량 가져오기
	if(!$input)  $input  = 0.1;
	$out_per	= (int)(($Output/$input)*100);
	$out_graph	= $out_per > 100 ? 100 : $out_per;
	//echo $Output.",".$input;
	//$out_graph	= $Output%$input;
?>
					<tr>
						<td><ul>
								<li style="display:inline-block;"><a href="../wizmart.php?code=<?=$Category?>&query=view&no=<?=$UID?>" target=_blank><img src="<?=$common->getpdimgpath($Category, $Picture[0], "../")?>" height='50' ></a> </li>
								<li style="display:inline-block;word-break:break-all;">
									<?=$Name?>
								</li>
							</ul></td>
						<td><?=$Price?>
							원<br />
							<?=$Point?>
							포인트 </td>
						<td><?=$Hit?>
							회</td>
						<td><?=$Output?>
							EA</td>
						<td><div ratio="<?php echo $out_graph;?>" class="uniquebar" alt='Unique : <?=$data["unique_counter"]?>'></div> 판매비율(
							<?=number_format($out_per);?>
							%) <br />
							(입고:
							<?=number_format($input)?>
							, 판매량 :
							<?=number_format($Output)?>
							) </td>
						<td><span class="button bull"><a href="<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=mallstatistic/statistic2_2&gid=<?=$UID?>">보기</a></span></td>
					</tr>
					<?endwhile;?>
				</tbody>
			</table>
	<div class="text-center">
<?php
$params = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL, "type"=>"bootstrappost"); 
echo $common->paging($params);
?>
	</div>
</div>