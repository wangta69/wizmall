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
	  <div class="panel-heading">제품수정</div>
	  <div class="panel-body">
		 제품을 수정 삭제 하실 수 있습니다.<br />
				수정방법은 수정을 원하시는 제품을 선택 후 우측 
				&quot;Modify&quot;아이콘을 클릭하시면 수정 페이지로 화면이 전환됩니다.<br />
				삭제방법은 
				삭제를 원하시는 제품의 좌측 실렉트박스를 책크 후 하단 상품삭제하기를 클릭하시면 상품이 삭제됩니다.
	  </div>
	</div>

	<? include ("./product/product_searchbox.php"); ?>
	<form action='' id='mall_list' method="post">
		<input type="hidden" name="csrf" value="<?=$common->getcsrfkey()?>">
		<input type="hidden" name="action" value='qde'>
		<table class="table table-hover table-striped">
			<col width="60" />
			<col width="*" />
			<col width="70" />
			<col width="100" />
			<col width="100" />
			<col width="80" />
			<thead>
				<tr class="success">
					<th>선택</th>
					<th>제품명</th>
					<th>모델명</th>
					<th>브랜드</th>
					<th>가격/포인트</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
<?php
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
							<td><input type="checkbox" value="<?=$list["UID"]?>" name="multi[<?=$list["UID"]?>]" class="chk_list">
							</td>
							<td><ul>
									<li style="display:inline-block;"><a href='../wizmart.php?code=<?=$list["Category"]?>&query=view&no=<?=$list["UID"]?>' target=_blank><img src='../config/uploadfolder/productimg/<?=$big_cat?>/<?=$Picture[0]?>' height='50' width="50" ></a> </li>
									<li style="display:inline-block;word-break:break-all;">
										<?=$list["Name"]?>
									</li>
								</ul></td>
							<td><?=$list["Model"]?>
							</td>
							<td><?=$list["Brand"]?>
							</td>
							<td><?=number_format($list["Price"])?>
								원<br />
								<?=number_format($list["Point"])?>
								포인트 </td>
							<td><div ><a href="javascript:gotoWrite('<?=$list["UID"]?>')" class="btn btn-default btn-xs">상세보기</a></div></td>
						</tr>
						<?endwhile;?>
					</tbody>
				</table>
			</form>
			
	<div class="row">
		<div class="col-lg-4 pagination">
			<button type="button" class="btn btn-default btn-xs btn_product_sel"  flag="del">삭제</button>
		</div>
		<div class="col-lg-7">
<?php
$params = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL, "type"=>"bootstrappost"); 
echo $common->paging($params);
?>
		</div>
	</div>
	
	
</div>

