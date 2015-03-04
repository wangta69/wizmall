<?php
/* 
제작자 : 폰돌
제작자 URL : http://www.shop-wiz.com
제작자 Email : master@shop-wiz.com
Free Distributer 

*** Updating List ***
*/

include "./lib/inc.depth0.php";

include ("./lib/class.wizmall.php");
$mall = new mall;
$mall->get_object($dbcon,$common);
$mall->cfg = $cfg;

if($keyword){//키워드가 있을 경우 검색키워드 테이블에 입력한다.
	$sqlstr = "insert into wizsearchKeyword (keyword,wdate) values ('".$keyword."',".time().") ";
	$dbcon->_query($sqlstr);
}

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
if ( $query == "search" || $query == "natural") {
	include  ("./skinwiz/search/".$cfg["skin"]["SearchSkin"]."/result.php");
}else if( $query == "alpha"){
	include ("./skinwiz/search/".$cfg["skin"]["SearchSkin"]."/alpha.php");
}else {
	include ("./skinwiz/search/".$cfg["skin"]["SearchSkin"]."/search.php");
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

<?php
include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_close.php");
$dbcon->_close();
