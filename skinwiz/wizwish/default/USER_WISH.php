<?
if (!$cfg["member"]) $common->js_alert("로그인 후 이용해 주세요.","./wizmember.php?query=login&file=wizhtml&goto=wish");
$mid = $cfg["member"]["mid"];
?>
<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active">WISH LIST</li>
</ul>

<?
if (file_exists("./config/wizmember_tmp/wiz_wish/".$mid)){
	$WISH_ARRAY = file("./config/wizmember_tmp/wiz_wish/".$mid);
	while (list($key,$value) = each($WISH_ARRAY)) :
			$value_arr = explode("|", $value);
			$sqlstr = "SELECT * FROM wizMall WHERE UID='$value_arr[0]'";
			$dbcon->_query($sqlstr);
			$list = $dbcon->_fetch_array();
			$Picture = explode("|", $list["Picture"])
?>
<table class="table table-striped table-hover">
			<col width="120px" />
			<col width="*" />
	<tr>
		<td>
			<a href='#' onclick="javascript:window.open('./skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/picview.php?no=<?=$list["UID"]?>', 'BICIMAGEWINDOW','width=750,height=592,statusbar=no,scrollbars=no,toolbar=no,resizable=no')">
				<img src='./wizstock/<?=$Picture[0]?>'></br>
				<button type="button" class="btn btn-default btn-xs">확대보기</a></button>
			</a>
		</td>
		<td>
			<?=$list["Name"]?>
			<?if($list["Model"]):?>
			(
			<?=$list["Model"]?>
			)
			<?endif;?>
			<table class="table_main w100p">
			<col width="120px" />
			<col width="*" />
				<tr>
					<th>가격</th>
					<td><?=number_format($list["Price"])?>
						원</td>
				</tr>
				<? if($list["Price1"]):?>
				<tr>
					<th>시중가격</th>
					<td><?=number_format($list["Price1"])?>
						원 </td>
				</tr>
				<? endif;?>
				<?if($list["Brand"]):?>
				<tr>
					<th>제조사</th>
					<td><?=$list["Brand"]?>					</td>
				</tr>
				<? endif;?>
				<?if($list["Point"]):?>
				<tr>
					<th>적립포인트</th>
					<td><?=number_format($list["Point"])?>					</td>
				</tr>
				<? endif;?>
				<?if ($list["Size"]) :?>
				<?$Option4 = explode("\n", $list["Option4"]);?>
				<tr>
					<th>규격(크기)</th>
					<td><?=$list["Size"]?>					</td>
				</tr>
				<? endif;?>
				<?if ($list["Option2"]) :?>
				<?$Option4 = explode("\n", $list["Option4"]);?>
				<tr>
					<th>용량</th>
					<td><?=$list["Option2"]?>					</td>
				</tr>
				<? endif;?>
			</table>
			<div class="btn_box">
				<a href='./wizbag.php?query=cart_save&no=<?=$list["UID"]?>&BUYNUM=1&GoodsPrice=<? echo $list["Price"]; ?>' class="btn btn-default btn-xs">장바구니에 담기</a> 
				<a href='./skinwiz/wizwish/index.php?action=wish_remove&uid=<?=$value_arr[0]?>' class="btn btn-default btn-xs">삭제</a>
			</div>
		</td>
	</tr>
</table>
<?
	endwhile;
}	
if (!$WISH_ARRAY) :
?>
WISH LIST 에 담긴 제품이 없습니다.
<?
endif;
?>
