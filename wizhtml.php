<?php
/* 
제작자 : 폰돌
제작자 URL : http://www.shop-wiz.com
제작자 Email : master@shop-wiz.com
Free Distributer 

*** Updating List ***
*/
include "./lib/inc.depth0.php";

if($common->securityguard($cfg["skin"]["LayoutSkin"])) $common->js_alert("잘못된 경로 사용");
if($common->securityguard($html)) $common->js_alert("잘못된 경로 사용");

if(file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_start.php")) include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_start.php");
?>
<!-- top menu start -->
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
if (file_exists("./html/".$html.".php")) include ("./html/".$html.".php");
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