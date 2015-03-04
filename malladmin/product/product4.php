<?
/*
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 

Copyright shop-wiz.com
*** Updating List ***
*/
$whereis = " WHERE m.UID <> '' and m.UID = m.PID and m.None = 1 ";
include ("./product/common.php");
?>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">품절상품관리</div>
	  <div class="panel-body">
		 품절 상품을 디스플레이 합니다. <br />
				재 판매가능하게 하려면 수정을 누르시고 품절란을 수정해 주시기 바랍니다.
	  </div>
	</div>
	<? include ("./product/product_searchbox.php"); ?>
	<form action='' id='mall_list' method="post">
		<input type="hidden" name="csrf" value="<?=$common->getcsrfkey()?>">
		<input type="hidden" name="action" value='qde'>
		<table class="table table-hover table-striped">
			<col width="70" />
			<col width="*" />
			<col width="80" />
			<col width="80" />
			<col width="80" />		
			<col width="100" />		
			<thead>	
			<tr class="success">
				<th> 선택</th>
				<th> 제품명/제조사</th>
				<th> 공급처</th>
				<th> 입고량</th>
				<th> 판매량</th>
				<th> 가격/포인트</th>
				<th> </th>
			</tr>
			</thead>
			<tbody>
<?php
//echo $whereis.$orderby.$START_NO.$ListNo;	
$dbcon->get_select('*','wizMall m',$whereis, $orderby, $START_NO, $ListNo);
while( $list = $dbcon->_fetch_array()) :
        $list["Name"] = stripslashes($list["Name"]);
        $list["CompName"] = stripslashes($list["CompName"]);
        $list["Description1"] = stripslashes($list["Description1"]);
        $list["Description2"] = stripslashes($list["Description2"]);
        $list["Model"] = stripslashes($list["Model"]);
		$Picture = explode("|",$list["Picture"]); 
		$big_cat = substr($list["Category"], -3);
?>
					<tr>
						<td><input type="checkbox" value='<?=$list["UID"]?>' name="multi[<?=$list["UID"]?>]" class="chk_list">
						</td>
						<td><ul>
							<li style="display:inline-block;"><a href='../wizmart.php?code=<?=$list[Category]?>&query=view&no=<?=$list[UID]?>' target=_blank><img src='../config/uploadfolder/productimg/<?=$big_cat?>/<?=$Picture[0]?>' height='50' width="50" ></a>
							</li>
							<li style="display:inline-block;word-break:break-all;"><?=$list[Name]?></li>
							</ul></td>
						<td><?=$list[CompName]?>
						</td>
						<td><?=$list[Input]?>
						</td>
						<td><?=$list[Output]?>
						</td>
						<td><?=number_format($list[Price])?>
							원<br />
							<?=number_format($list[Point])?>
							포인트</td>
						<td><a href="javascript:gotoWrite('<?=$list[UID]?>')"><img src='./img/mo.gif' ></a></td>
					</tr>
					<? endwhile; ?>
					</tbody>
				</table>
			</form>
	<div class="row">
		<div class="col-lg-4 pagination"><span class="btn_product_sel button bull" flag="del"><a>삭제</a></span></div>
		<div class="col-lg-7">
<?php
$params = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL, "type"=>"bootstrappost"); 
echo $common->paging($params);
?>
		</div>
	</div>


			
	
</div>
