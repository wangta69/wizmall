<form name="OrderForm" method="post" action="<?php echo $PHP_SELF;?>">
	<input type="hidden" name="code" value="<?php echo $code;?>">
	<input type="hidden" name="keyword" value="<?php echo $keyword;?>">
	<input type="hidden" name="query" value="<?php echo $query;?>">
	<input type="hidden" name="optionvalue" value="<?php echo $optionvalue;?>">
	<input type="hidden" name="mode" value="<?php echo $mode?>">
	<input type="hidden" name="code" value="<?php echo $code;?>">
	<div class="agn_r">
		<?php echo $mall->sel_pd_order($stitle) ?>
		<input type="text" name="skey" />
		<span class="button bull"><a href="javascript:submit();">검색</a></span>
		<!-- 전체선택
<input name="ShopListNoAll" type="checkbox" value="1" onClick="listAllfnc(this);" <? echo $ShopListNo=="all"?"checked":"";?> >-->
		<?php echo $mall->sel_pd_listno($ShopListNo);?>
		<?php echo $mall->sel_pd_order($sel_orderby)?>
	</div>
</form>
<div class="space15"></div>
<ul class="sub_product_list">
<?php
$cnt=0;
$select = "m2.UID, m2.PID, m2.Category, m1.Picture, m1.None, m1.Regoption, m1.Model, m1.Name, m1.Price,m1.Price1,m1.Category as pcategory";
//$dbcon->debug = true;
$sqlqry = $dbcon->get_select($select,'wizMall m2 left join wizMall m1 on m2.PID = m1.UID',$whereis, $orderbystr, $START_NO, $ShopListNo);
while($list=$dbcon->_fetch_array($sqlqry)):
    $Picture = explode("|", $list[Picture]);
	$UID		= $list["UID"];
	$PID		= $list["PID"];
	$Category	= $list["Category"];
	$None		= $list["None"];
	$Regoption	= $list["Regoption"];
	$Model		= $list["Model"];
	$Name		= $list["Name"];
	$Price		= $list["Price"];
	$Price1		= $list["Price1"];
	$img_folder = substr($list["pcategory"], -3);
	$img_path	= "./config/uploadfolder/productimg/$img_folder/".$Picture[0];
    $View_Pic_Size = $common->TrimImageSize($img_path, 110);
	
?>
	<li><a href="<?php echo $mall->pdviewlink($UID,$Category,$None)?>"><img src="<?php echo $img_path?>" <?php echo $View_Pic_Size?>></a>
		<div class="desc_pd_list"> <span class="p_name">
			<?php echo $Name?>
			</span>
			<?php if($Model):?>
			<?php echo $mall->ShowOptionIcon($cfg["skin"]["ShopIconSkin"], $RegOptionArr, $Regoption);?>
			<br />
			<?php echo $Model?>
			<? endif; ?>
			<br />
			<?php if($Price1) echo "".number_format($Price1)."원<br />";?>
			<span class="p_price">
			<?php echo number_format($Price)?>
			</span> 원 </div>
	</li>
<?php
$cnt++;
// && $cnt != $Total
if(!($cnt%4)) echo "</ul><ul class='sub_product_list'>";
endwhile;
$tmpcnt = $cnt%4;
if($tmpcnt){
	for($i=$tmpcnt; $i<4; $i++){
		echo "<li></li>";
	}
}
?>
</ul>
<div class="paging_box">
<?php
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
$page_arg1 = $PHP_SELF."?code=$code&stitle=$stitle&skey=".urlencode($skey)."&sel_orderby=$sel_orderby";
if($query == "option") $page_arg1 .= "&query=option&optionvalue=$optionvalue";
$page_arg2 = array("listno"=>$ShopListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL);
$page_arg4[0] = "mall"; 
echo $common->paging($page_arg1,$page_arg2,$page_arg3, $page_arg4);
?>
</div>
