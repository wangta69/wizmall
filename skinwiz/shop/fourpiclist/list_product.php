<script>
function gotoPage(cp){
	$("#cp").val(cp);
	$("#sform").submit();
}
</script>
<form name="OrderForm" method="post" action="<?php echo $PHP_SELF;?>" id="sform" class="form-inline" role="form">
	<input type="hidden" name="code" value="<?php echo $code;?>">
	<input type="hidden" name="keyword" value="<?php echo $keyword;?>">
	<input type="hidden" name="query" value="<?php echo $query;?>">
	<input type="hidden" name="optionvalue" value="<?php echo $optionvalue;?>">
	<input type="hidden" name="mode" value="<?php echo $mode?>">
	<input type="hidden" name="cp" id="cp" value="<?php echo $cp;?>">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-2"> 
					<?php echo $mall->sel_pd_stitle($stitle) ?>
				</div>
				<div class="col-lg-2"> 
					<input type="text" name="skey" class="form-control" />
				</div> <!-- col-lg-12 text-center -->
				<div class="col-lg-2"> 
					<button type="submit" class="btn btn-default">검색</button>
				</div> 
				<div class="col-lg-3"> 
					<?php echo $mall->sel_pd_listno($ShopListNo);?>
				</div> 
				<div class="col-lg-3"> 
					<?php echo $mall->sel_pd_order($sel_orderby)?>
				</div> 
			</div><!-- row -->
		</div>
	</div>


</form>
<div class="space15"></div>

<div class="row">
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
	<div class="col-lg-3">
		<a href="<?php echo $mall->pdviewlink($UID,$Category,$None)?>" class="thumbnail">
			<img src="<?php echo $img_path?>" alt="">
		</a>
		<div class="caption">
			<h4><?php echo $Name?> <?php echo $mall->ShowOptionIcon($cfg["skin"]["ShopIconSkin"], $Regoption);?></h4>
			<?php if($Model) echo "<p>".$Model."</p>" ?>
			<?php if($Price1) echo "<p>".number_format($Price1)."원</p>" ?>		
			<span class="p_price">
			<?php echo "<p><span class=\p_price\">".number_format($Price)."</span>원</p>"?>
		</div>
	</div>
<?php
$cnt++;
// && $cnt != $Total
if(!($cnt%4)) echo "</div><div class=\"row\">";
endwhile;
$tmpcnt = $cnt%4;
if($tmpcnt){
	for($i=$tmpcnt; $i<4; $i++){
		//echo "<li></li>";
	}
}
?>
</div>


<div class="paging_box">
<?php

$params = array("listno"=>$ShopListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL, "type"=>"bootstrappost"); 
echo $common->paging($params);
?>
</div>
