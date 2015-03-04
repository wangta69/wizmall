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

echo '<ul class="pagination">';
if ( $board->page_var["cb"] > 1 ) {
	$PREV_PAGE = $board->page_var["sp"] - 1;
	$getdata = $common->getencode("cp=".$PREV_PAGE."&".$TransData);
	echo '<li><a href="'.$PHP_SELF.'?getdata='.$getdata.'">&laquo;</a></li>';
} else {
	echo '<li class="disabled"><a href="#">&laquo;</a></li>';
}


/* LISTING NUMBER PART */
for ($i = $board->page_var["sp"]; $i <= $board->page_var["ep"] && $i <= $board->page_var["tp"] ; $i++) {
	$activeclass = $board->page_var["cp"] == $i ?' class="active"':'';
	
	$getdata = $common->getencode("cp=".$i."&".$TransData);
	echo "<li".$activeclass."><a href='".$PHP_SELF."?getdata=".$getdata."'>".$i."</a></li>";
}

/* NEXT or END PART */
if ($board->page_var["cb"] < $board->page_var["tb"]) {
	$NEXT_PAGE = $board->page_var["ep"] + 1;
	$getdata = $common->getencode("cp=".$NEXT_PAGE."&".$TransData);
	echo "<li><a href='".$PHP_SELF."?getdata=".$getdata."'>&raquo;</a></li>";
} else {
	echo '<li class="disabled"><a href="#">&raquo;</a></li>';
}
echo "</ul>";
