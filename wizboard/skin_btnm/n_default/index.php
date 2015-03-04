<?php
/*
제작자 : 폰돌
스킨 : wizboard list skin 
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
2004. 6. 26 - sorting 관련 SOrder 및 STitle 변수를 추가로 페이징 변수에 넣음
*/
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
$TransData = "BID=$BID&GID=$GID&adminmode=$adminmode&optionmode=$optionmode&SEARCHTITLE=$SEARCHTITLE&searchkeyword=".urlencode($searchkeyword)."&category=$category&STitle=$STitle&oderflag=$oderflag&search_term=$search_term";
if ( $board->page_var["cb"] > 1 ) {
$PREV_PAGE = $board->page_var["sp"] - 1;
$getdata = $common->getencode("cp=".$PREV_PAGE."&".$TransData);
echo " <a href='".$PHP_SELF."?getdata=".$getdata."'><img src='./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/pre.gif' border='0'></a> ";
} else {
echo " <img src='./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/pre.gif' border='0'> ";
 }

# 한페이지 이전
if ( $board->page_var["cp"] > 1 ) {
$PREV_PAGE = $board->page_var["cp"] - 1;
$getdata = $common->getencode("cp=".$PREV_PAGE."&".$TransData);
//echo " <a href='".$PHP_SELF."?getdata=".$getdata."'><img src='./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/pre1.gif' border='0'></a> ";
} else {
//echo " <img src='./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/pre1.gif' border='0'> ";
 }

/* LISTING NUMBER PART */
for ($i = $board->page_var["sp"]; $i <= $board->page_var["ep"] && $i <= $board->page_var["tp"] ; $i++) {
if($board->page_var["cp"] == $i){$NUMBER_SHAPE= "<B>".$i."</B>";}
else $NUMBER_SHAPE=${i};
$getdata = $common->getencode("cp=".$i."&".$TransData);
echo" <a href='".$PHP_SELF."?getdata=".$getdata."'>".$NUMBER_SHAPE."</a> ";
}
# 한페이지 다음
if ($board->page_var["cp"] < $board->page_var["tp"]) {
$NEXT_PAGE = $board->page_var["cp"] + 1;
$getdata = $common->getencode("cp=".$NEXT_PAGE."&".$TransData);
//ECHO " <a href='".$PHP_SELF."?getdata=".$getdata."'><img src='./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/next1.gif' border='0'></a> ";
} else {
//ECHO" <img src='./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/next1.gif' border='0' >";
}

/* NEXT or END PART */
if ($board->page_var["cb"] < $board->page_var["tb"]) {
$NEXT_PAGE = $board->page_var["ep"] + 1;
$getdata = $common->getencode("cp=".$NEXT_PAGE."&".$TransData);
echo " <a href='".$PHP_SELF."?getdata=".$getdata."'><img src='./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/next.gif' border='0'></a> ";
} else {
echo" <img src='./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/next.gif' border='0'> ";
}
