<?
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
	  <div class="panel-heading">재고 관리</div>
	  <div class="panel-body">
		 재고를 추가로 입력할 경우 좌측 &quot;선택&quot; 책크박스를 선택하시고 우측 재고입력란에 입하략을 입력하시면됩니다.
	  </div>
	</div>
	
	<? include ("./product/product_searchbox.php"); ?>
	
	<form action='<?=$PHP_SELF?>' name='mall_list' onsubmit="return cmp('chinput')" method="post">
		<input type="hidden" name="csrf" value="<?=$common->getcsrfkey()?>">
		<input type="hidden" name="menushow" value='<?=$menushow?>'>
		<input type="hidden" name="theme"  value='<?=$theme?>'>
		<input type="hidden" name="p" value='<?=$cp?>'>
		<input type="hidden" name="action" value='chinput'>
		<input type="hidden" name="category" value='<?=$category?>'>
		<input type="hidden" name="orderby" value='<?=$orderby?>'>
		<input type="hidden" name="OptionList" value='<?=$OptionList?>'>
		<input type="hidden" name="keyword" value='<?=$keyword?>'>
		<table class="table table-hover table-striped">
			<col width="70" />
			<col width="*" />
			<col width="80" />
			<col width="80" />
			<col width="80" />		
			<col width="100" />		
			<thead>	
			<tr class="success">			
				<th>선택</th>
				<th>제품명</th>
				<th>모델명</th>
				<th>물품공급처</th>
				<th>브랜드</th>
				<th>현재제고</th>
				<th>입하량</th>
				<th>상세보기</th>
			</tr>
			</thead>
			<tbody>
<?php
//echo $whereis.$orderby.$START_NO.$ListNo;					
$sqlqry	= $dbcon->get_select('*','wizMall m',$whereis, $orderby, $START_NO, $ListNo);
while( $list = $dbcon->_fetch_array($sqlqry	)) :
        $list[Name] = stripslashes($list[Name]);
        $list[CompName] = stripslashes($list[CompName]);
        $list[Description1] = stripslashes($list[Description1]);
        $list[Description2] = stripslashes($list[Description2]);
        $list[Model] = stripslashes($list[Model]);
		$Picture = explode("|",$list[Picture]); 
		$big_cat = substr($list[Category], -3);
?>
			<tr>
				<td><input type="checkbox" value="<?=$list[UID]?>" name="multi[<?=$list[UID]?>]">
				</td>
				<td><ul>
					<li style="display:inline-block;"><a href='../wizmart.php?code=<?=$list[Category]?>&query=view&no=<?=$list[UID]?>' target=_blank><img src='../config/uploadfolder/productimg/<?=$big_cat?>/<?=$Picture[0]?>' height='50' width="50" ></a>
					</li>
					<li style="display:inline-block;word-break:break-all;"><?=$list[Name]?></li>
					</ul></td>
				<td>
					<?=$list[Model]?>
				</td>
<?php
$sqlsubstr = "select CompName from wizCom where CompID = '$list[GetComp]'";
$CompName = $dbcon->get_one($sqlsubstr);
if(!$CompName) $CompName = "공급처없슴";			
?>
				<td>
					<?=$CompName?>
				</td>
				<td>
					<?=$list[Brand]?>
				</td>
<?php
/* 현재까지의 총 입력량을 가져옮 */
$sqlsubstr = "select sum(Iinputqty) from wizInputer where Igoodscode= '$list[UID]'";
$inputqty = $dbcon->get_one($sqlsubstr);
/* 현재 재고량은 현재까지의 총 입력양  -  총 판매량 */
$stockpile = $inputqty - $list[Output];	
?>
				<td>
					<?=number_format($stockpile);?>
					개</td>
				<td>
					<input name="qty[<?=$list[UID]?>]" class="w30">
					개 </td>
				<td>
					<button type="button" class="btn btn-default btn-xs" Onclick="window.open('./product/product5_1.php?pid=<?=$list[UID]?>','InputerListWindow','width=248,height=280')">상세보기</button>
				</td>
			</tr>
<? endwhile; ?>
			</tbody>
		</table>

	<div class="row">
		<div class="col-lg-4 pagination">
			<button type="submit" class="btn btn-default btn-xs">입하량 추가하기</button>
		</div>
		<div class="col-lg-7">
<?php
$params = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL, "type"=>"bootstrappost"); 
echo $common->paging($params);
?>
		</div>
	</div>
	</form>
</div>
