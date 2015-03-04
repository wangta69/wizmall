<?
/*
제작자 : 폰돌
스킨 : wizboard list skin 
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
?>
<table width="155" height="30" border="0" cellpadding="0" cellspacing="0">
                                      <tr> 
                                        <td align="center">
<?
 $TransData = "BID=$BID&GID=$GID&adminmode=$adminmode&optionmode=$optionmode&SEARCHTITLE=$SEARCHTITLE&searchkeyword=".urlencode($searchkeyword)."&category=$category&STitle=$STitle&oderflag=$oderflag&search_term=$search_term";
if ( $board->page_var["cb"] > 1 ) {
$PREV_PAGE = $board->page_var["sp"] - 1;
$getdata = $common->getencode("cp=".$PREV_PAGE."&".$TransData);
echo " <a href='".$PHP_SELF."?getdata=".$getdata."'><img src='./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/pre.gif' border='0'></a> ";
} else {
echo " <img src='./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/pre.gif' border='0'> ";
 }
 ?></td>
                                        <td align="center">
<?
for ($i = $board->page_var["sp"]; $i <= $board->page_var["ep"] && $i <= $board->page_var["tp"] ; $i++) {
	if($board->page_var["cp"] == $i){$NUMBER_SHAPE= "<B>${i}</B>";}
	else $NUMBER_SHAPE=${i};
	$getdata = $common->getencode("cp=".$i."&".$TransData);
	ECHO"&nbsp;<a href='".$PHP_SELF."?getdata=".$getdata."'>$NUMBER_SHAPE</a>";
}
?></td>
                                        <td align="center">
										
<?

if ($board->page_var["cb"] < $board->page_var["tb"]) {
$NEXT_PAGE = $board->page_var["ep"] + 1;
$getdata = $common->getencode("cp=".$NEXT_PAGE."&".$TransData);
ECHO " <a href='".$PHP_SELF."?getdata=".$getdata."'><img src='./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/next.gif' border='0'></a> ";
} else {
ECHO" <img src='./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/next.gif' border='0'> ";
}
?>										
										</td>
                                      </tr>
                                    </table>
  