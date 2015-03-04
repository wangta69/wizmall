<?php
/*
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 

Copyright shop-wiz.com
*** Updating List ***
*/
$whereis = " WHERE m.UID <> '' and m.UID = m.PID and m.None = 0 ";
include ("./product/common.php");
?>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">제품 가격 일괄 수정</div>
	  <div class="panel-body">
		 가격 변경을 하시려는 상품의 좌측 첵크박스를 선택하시고 
				우측의 가격 및 포인트를 조정하세요. <br />
				가격 입력을 하실때 콤마 [ , ]를 절대 사용하지 마시기 바랍니다.
	  </div>
	</div>
	<? include ("./product/product_searchbox.php"); ?>
	<form action='<?=$PHP_SELF?>' name='mall_list' onsubmit="return cmp('chprice')">
		<input type="hidden" name="csrf" value="<?=$common->getcsrfkey()?>">
		<input type="hidden" name="menushow" value='<?=$menushow?>'>
		<input type="hidden" name="theme"  value='<?=$theme?>'>
		<input type="hidden" name="p" value='<?=$cp?>'>
		<input type="hidden" name="action" value='qup'>
		<input type="hidden" name="category" value='category'>
		<input type="hidden" name="orderby" value='orderby'>
		<input type="hidden" name="OptionList" value='OptionList'>
		<input type="hidden" name="keyword" value='keyword'>
		<table class="table table-hover  table-striped ">
			<col width="58" />
			<col width="*" />
			<col width="85" />
			<col width="87" />
			<col width="200" />
			<thead>
				<tr class="success">
					<th>선택</th>
					<th>제품명</th>
					<th>모델명</th>
					<th>브랜드</th>
					<th>가격/포인트</th>
				</tr>
			</thead>
			<tbody>
<?php
$dbcon->get_select('*','wizMall m',$whereis, $orderby, $START_NO, $ListNo);
while( $list = $dbcon->_fetch_array()) :
        $list[Name] = stripslashes($list["Name"]);
        $list[CompName] = stripslashes($list["CompName"]);
        $list[Description1] = stripslashes($list["Description1"]);
        $list[Description2] = stripslashes($list["Description2"]);
        $list[Model] = stripslashes($list["Model"]);
		$Picture = explode("|",$list["Picture"]); 
		$big_cat = substr($list["Category"], -3);
?>
			<tr>
				<td><input type="checkbox" value='<?=$list[UID]?>' name="multi<?=$list[UID]?>">
				</td>
				<td><ul>
						<li style="display:inline-block;"><a href='../wizmart.php?code=<?=$list[Category]?>&query=view&no=<?=$list[UID]?>' target=_blank><img src='../config/uploadfolder/productimg/<?=$big_cat?>/<?=$Picture[0]?>' height='50' width="50" ></a> </li>
						<li style="display:inline-block;word-break:break-all;">
							<?=$list[Name]?>
						</li>
					</ul></td>
				<td>&nbsp;
					<?=$list[Model]?>
				</td>
				<td>&nbsp;
					<?=$list[Brand]?>
				</td>
				<td><input size=10 value="<?=$list[Price]?>" name="price[<?=$list[UID]?>]" />
					원
					<input size=5 value="<?=$list[Point]?>" name="point[<?=$list[UID]?>]">
					포인트</td>
			</tr>
			<? endwhile; ?>
		</tbody>
	</table>
	</form>
	
	<div class="row">
		<div class="col-lg-4 pagination">
			<button type="submit" class="btn btn-default btn-xs">상품가격 일괄변경</button>
		</div>
		<div class="col-lg-7">
<?php
$params = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL, "type"=>"bootstrappost"); 
echo $common->paging($params);
?>
		</div>
	</div>

		
</div>
