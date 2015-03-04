<?php
/* 
제작자 : 폰돌
제작자 URL : http://www.shop-wiz.com
제작자 Email : master@shop-wiz.com
Free Distributer 

*** Updating List ***

change url type: /?type=html&proc=kkk&skin=sdf
*/

if(!file_exists("./config/db_info.php")) header("location:./malladmin/install/install.php");

include "./lib/func.php";
include "./lib/inc.depth0.php";
include ("./lib/class.wizmall.php");
include ("./lib/inc.wizmart.php");
$mall = new mall;
$mall->get_object($dbcon,$common);
$mall->cfg = $cfg;


include "./config/common_array.php";
include "./util/wizcount/counterinsert.php";
if($common->securityguard($cfg["skin"]["LayoutSkin"])) $common->js_alert("");
if($common->securityguard($cfg["skin"]["MainSkin"])) $common->js_alert("");


//$navy_params	= array("shop"=>$_GET["shop"]);
$navy_params	= array("type"=>$_GET["type"], "proc"=>$_GET["proc"], "skin"=>$_GET["skin"]);

//if(file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_start.php")) include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_start.php");
//include "./util/wizpopup/popinsert.php";

echo get_header();

echo get_content();
//if ($cfg["skin"]["MainSkin_Inc"] == 'checked') {
//include ("./skinwiz/index/".$cfg["skin"]["MainSkin"]."/index.php");
//}

echo get_footer();
$dbcon->_close();