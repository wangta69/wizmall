<?php
/* 
제작자 : 폰돌
제작자 URL : http://www.shop-wiz.com
제작자 Email : master@shop-wiz.com
Free Distributer 

*** Updating List ***
 
change url : /?type=html&proc=kkk&skin=sdf
*/

if(!file_exists("./config/db_info.php")) header("location:./malladmin/install/install.php");


include "./lib/inc.depth0.php";

include "./config/common_array.php";
include "./util/wizcount/counterinsert.php";
if($common->securityguard($cfg["skin"]["LayoutSkin"])) $common->js_alert("");
if($common->securityguard($cfg["skin"]["MainSkin"])) $common->js_alert("");

if(file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_start.php")) include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_start.php");
include "./util/wizpopup/popinsert.php";
?>

<?php
if (file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_top.php")) include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_top.php");
?>
<!-- top menu end -->
<div class="container bs-docs-container">
	<div class="row">
		<div class="col-left">
		
<!-- left menu start -->
<?php
if ($cfg["skin"]["MenuSkin_Inc"] == 'checked') include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_left.php");
?>
<!-- left menu end -->
		</div><!-- col-lg-3 -->
		<div class="col-main">
<!-- main menu start -->

<?php
if ($cfg["skin"]["MainSkin_Inc"] == 'checked') {
include ("./skinwiz/index/".$cfg["skin"]["MainSkin"]."/index.php");
}
?>		
		</div><!-- col-lg-9 -->
	</div><!-- row -->
</div><!-- container bs-docs-container-->
<!-- main menu end -->
<!-- bottom menu start -->
<?php
if (file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_bottom.php")) include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_bottom.php");
?>
<!-- bottom menu end -->
<?php
include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_close.php");
$dbcon->_close();