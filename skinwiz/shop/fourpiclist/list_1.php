<script>
function orderbyfnc(stritem,strorder){
	var f = document.OrderForm;
	f.orderby.value = stritem;
	f.submit();

}

function listAllfnc(v){
	f = document.OrderForm;
	if(v.checked){
		f.ShopListNo.value = "all";
		f.submit();
	}

}
</script>
<?php echo $mall->getNavy($code);//상단 navy 가져오기?>
<?php
include ("./skinwiz/shop/".$cfg["skin"]["ShopSkin"]."/list_category.php");
?>
<div class="space15"></div>
<?php
include ("./skinwiz/shop/".$cfg["skin"]["ShopSkin"]."/list_product.php");
?>