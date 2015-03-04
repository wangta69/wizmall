<div class="space5"></div>
<div id="main_top_banner">
<?php
$banner = $common->getbanner(3, 719);
echo $banner[0];
?>
</div>

<ul class="main_center_banner">
<?php
$banner = $common->getbanner(4, 220);
$cnt=0;
if($banner){
	foreach($banner as $key=>$value){
		if($cnt< 3){
			if($cnt == 0) $align = "align='left'";
			if($cnt == 1) $align = "align='center'";
			if($cnt == 2) $align = "align='right'";
            echo "<li>".$banner[$cnt]."</li>";
		}
	   $cnt++;
	}
}
?>
</ul>



<?php
$sqlstr = "select uid, op_name, op_main_image, op_main_cnt from wizpdoption where op_display = 'Y' order by op_main_order asc";
$qry	= $dbcon->_query($sqlstr);
while($dp = $dbcon->_fetch_array($qry)):
?>
<div class="main_product_title">
<a href="./test_index.php?shop=option&optionvalue=<?php echo $dp["uid"]?>"><img src="./config/pdoption/<?php echo $dp["op_main_image"]?>"></a>
</div>



<ul class="main_product_list">
<?php
$whereis = "Regoption like '%|".$dp["uid"]."|%'";
unset($cnt);	
$sqlstr = "select * from wizMall where ".$whereis." order by Date desc limit 0, ".$dp["op_main_cnt"];
$qry1 = $dbcon->_query($sqlstr);
while($list = $dbcon->_fetch_array($qry1)):
    $Picture = explode("|", $list["Picture"]);
    $VIEW_LINK = "'./test_index.php?shop=product_view&code=".$list["Category"]."&no=".$list["UID"]."'";
    if ($list["None"]) {
    $VIEW_LINK = "'#' onclick=\"javascript:alert('이 제품은 품절되었습니다..')\"";
    }
	$ProductImg = "./config/uploadfolder/productimg/".substr($list["Category"], -3)."/".$Picture[0];
?>
		<li><a href=<?php echo $VIEW_LINK?>><img src="<?php echo $ProductImg?>" width="132"  height="132" onerror=this.src='/images/common/noimg_100x100.gif'></a>
			<br />
			<span class="p_name"><?php echo $list["Name"]?></span>
			<br />
			<span class="p_price"><?php echo number_format($list["Price"])?></span>
						원 
		</li>
<?php
$cnt++;
// && $cnt != $Total
if(!($cnt%5)) echo "</ul><ul class='main_product_list'>";
endwhile;
$tmpcnt = $cnt%5;
if($tmpcnt){
	for($i=$tmpcnt; $i<5; $i++){
		echo "<li></li>";
	}
}
?>
</ul>
<div class="clear"></div>

<?php
endwhile;
?>