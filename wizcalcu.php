<?php
/* 
제작자 : 폰돌
제작자 URL : http://www.shop-wiz.com
제작자 Email : master@shop-wiz.com
Free Distributer 

*** Updating List ***
*/
include "./lib/inc.depth0.php";

if(!$_COOKIE["MEMBER_ID"]) {
echo "
<script>
window.alert('\\n\\n정회원만이 이용하실 수 있습니다. \\n\\n 회원가입후 이용해 주세요');
location.replace('./wizmember.php?query=login');
</script>";
exit;
}
$MicroTsmp = explode(" ",microtime());
$START_TIME = $MicroTsmp[0]+$MicroTsmp[1];

if($SAVE_VALUE == "INPUT"){// 장바구니담기
$no=$sort3;
        /*******************************************************************************
        CART파일의 생성시간을 구해서 2시간(mktime()기준 - 7200)이 경과된 경우 자동삭제..
        *******************************************************************************/
        $LOG_DIR = opendir("./config/wizmember_tmp/mall_buyers");
//        while($LOG_FILE = readdir($LOG_DIR) && $LOG_FILE !="." && $LOG_FILE !="..") {
while($LOG_FILE = readdir($LOG_DIR)) {
	if($LOG_FILE !="." && $LOG_FILE !=".."){
	    if(file_exists("./config/wizmember_tmp/mall_buyers/".$LOG_FILE) && mktime() - filemtime("./config/wizmember_tmp/mall_buyers/".$LOG_FILE) > 7200) {
                        unlink("./config/wizmember_tmp/mall_buyers/".$LOG_FILE);
        }
	} //if($LOG_FILE !="." && $LOG_FILE !="..") 닫음
}
        closedir($LOG_DIR);
        if (!$_COOKIE["CART_CODE_ESTIM"] || !file_exists("./config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE_ESTIM"])) {
                $CART_CODE_ESTIM = substr(str_replace(".", "", $START_TIME), 0, 13); // 장바구니고유코드
                setcookie("CART_CODE_ESTIM",$CART_CODE_ESTIM,0,"/");
                $fp = fopen("./config/wizmember_tmp/mall_buyers/".$CART_CODE_ESTIM, "w");
               fwrite($fp, $no."|".$BUYNUM."|".$Option1."|".$Option4."|\n");
                fclose($fp);
        }
        else {
                if (file_exists("./config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE_ESTIM"])){
                $Cart_Data = file("./config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE_ESTIM"]);
                $fp = fopen("./config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE_ESTIM"], "w");
                while ($Cart_Data_f = each($Cart_Data)) {
                $C_dat = explode("\|", chop($Cart_Data_f[1]));
                        if($C_dat[0]."-".$C_dat[2]."-".$C_dat[3] == $no."-".$Option1."-".$Option4) {
                                $BNUM = $BUYNUM + $C_dat[1];
                                fwrite($fp, $no."|".$BNUM."|".$Option1."|".$Option4."|\n");
                       }
                        else {
                                fwrite($fp, chop($Cart_Data_f[1])."\n");
                        }
                }
                fclose($fp);
                }
                if (!$BNUM) {
                $fp = fopen("./config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE_ESTIM"], "a");
                fwrite($fp, $no."|".$BUYNUM."|".$Option1."|".$Option4."|\n");
                fclose($fp);
                }
        }
        ECHO "<HTML><META http-equiv='refresh' content='0;url=wizcalcu.php'></HTML>";

        exit;

}



if ( $query == 'delete') { // 장바구니 택일삭제
        if (file_exists("./config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE_ESTIM"])){
        $Cart_Data = file("./config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE_ESTIM"]);
        $fp = fopen("./config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE_ESTIM"], "w");
        while ($Cart_Data_f = each($Cart_Data)) {
        $C_dat = explode("|", chop($Cart_Data_f[1]));
                if($C_dat[0]."-".$C_dat[2]."-".$C_dat[3] == $value) {
                        fwrite($fp, chop($Cart_Data_f[1])."\n");
                }
        }
        fclose($fp);
        }
        ECHO "<HTML><META http-equiv='refresh' content='0;url=wizcalcu.php'></HTML>";
        exit;
}

if ( $query == 'modify') { // 장바구니 택일수정
        if (file_exists("./config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE_ESTIM"])){
        $Cart_Data = file("./config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE_ESTIM"]);
        $fp = fopen("./config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE_ESTIM"], "w");
        while ($Cart_Data_f = each($Cart_Data)) {
        $C_dat = explode("|", chop($Cart_Data_f[1]));
                if($C_dat[0]."-".$C_dat[2]."-".$C_dat[3] == $value) {
                        fwrite($fp, $C_dat[0]."|".$BUYNUM."|".$C_dat[2]."|".$C_dat[3]."|\n");
                }
                else {
                        fwrite($fp, chop($Cart_Data_f[1])."\n");
                }
        }
        fclose($fp);
        }
        ECHO "<HTML><META http-equiv='refresh' content='0;url=wizcalcu.php'></HTML>";
        exit;
}
if ( $query == 'trash') { // 장바구니 비우기
        if (file_exists("./config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE_ESTIM"])){
        unlink("./config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE_ESTIM"]);
        setcookie("CART_CODE_ESTIM","",0,"/");
        }
        ECHO "<HTML><META http-equiv='refresh' content='0;url=wizcalcu.php'></HTML>";
        exit;

}


$EstimSkin = "default";
include ("./config/cfg.core.php");
include ("./config/db_info.php");
include "./lib/class.database.php";
$dbcon	= new database($cfg["sql"]);
if(file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_start.php")) include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_start.php");
if ($query == 'cart') {
include ("./skinwiz/estimate/".$EstimSkin."/cart_save.php");
}
?>
<!-- top menu start -->
<?php
if (file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_top.php")) include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_top.php");
?>
<script type="text/javascript" src="./js/jquery.min.js"></script>
<!-- top menu end -->
<!-- left menu start -->
<?php
if ($cfg["skin"]["MenuSkin_Inc"] == 'checked') include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_left.php");
?>
<!-- left menu end -->
<!-- main menu start -->

<div id="body">
<?php
if($query == "estim_view")include ("./skinwiz/estimate/".$EstimSkin."/estim_view.php");
else include ("./skinwiz/estimate/".$EstimSkin."/default.php");
?>
</div><!-- #body close-->
<!-- main menu end -->
<!-- bottom menu start -->
<?php
if (file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_bottom.php")) include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_bottom.php");
?>
<!-- bottom menu end -->
<?
include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_close.php");
$dbcon->_close();