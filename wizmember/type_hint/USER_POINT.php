<?
/* 
제작자 : 폰돌
제작자 URL : http://www.shop-wiz.com
제작자 Email : master@shop-wiz.com
Free Distributer 
*** Updating List ***
*/
if (!$cfg["member"]) $common->js_alert("손님께서는 로그인되어있지 않습니다.");
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" height="18" border="0" cellpasdding="0" cellspacing="0" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
        <tr bgcolor="#F6F6F6">
          <td width="15" height="22">&nbsp;</td>
          <td width="18" height="22" valign="middle"><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/sn_arrow.gif" width="13" height="13"></td>
          <td height="22">Home &gt; <strong>적립금 보기</strong></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center"><br>
    </td>
  </tr>
  <tr>
    <td><TABLE WIDTH='95%' CELLSPACING=0 CELLPADDING=0 BORDER=0 style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
        <TR>
          <TD HEIGHT='71' ALIGN=RIGHT valign="bottom"><B><? ECHO " $_COOKIE[MEMBER_NAME]($_COOKIE[MEMBER_ID])";?></B>님의 
            포인트내역입니다.</TD>
        </TR>
      </TABLE></td>
  </tr>
  <tr>
    <td align="center"><table width="95%" border="0" cellpadding="0" cellspacing="0" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
        <tr align=center bgcolor="#F5F5F5">
          <td width="30" height="25">번호</td>
          <td>적립내역</td>
          <td>지급량</td>
          <td width="90">지급일</td>
        </tr>
        <?
/* 페이징과 관련된 수식 구하기 */
$ListNo = "15";
$PageNo = "20";
if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $ListNo;
$sqlstr = "SELECT t1.Point, t2.Pointinfo FROM wizMembers t1, wizMembersMore t2 WHERE t2.MID='$_COOKIE[MEMBER_ID]' and t1.ID = t2.MID";
$dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array();
$MSG = stripslashes($list[Pointinfo]);
$SplitPoint = split("\n", $MSG);
krsort($SplitPoint);
reset($SplitPoint);
$TOTAL = sizeof($SplitPoint)-1;
$totalpoint = $list[Point];

//--페이지링크를 작성하기--
$NO=$TOTAL-($ListNo*($cp-1));
//echo "TOTAL = $TOTAL , ListNo = $ListNo , cp = $cp ";
for( $i = $START_NO; $i < $ListNo + $START_NO; $i++) {
	$listno = $NO +1;
	if($SplitPoint[$i]){
	$VAL = split("\|", $SplitPoint[$i]);	
	if(!$VAL[0])$VAL[0] = 0;
?>
        <TR ALIGN=CENTER HEIGHT=25>
          <TD WIDTH=30 height="25"><B>
            <?=$listno?>
            </B></TD>
          <TD height="25" bgcolor="WHITE"><FONT COLOR=BROWN>&nbsp;
            <?
if (eregi("주문번호:", $VAL[2])) {
	$VAL_SPL = split(":", $VAL[2]);
	if (eregi("포인트", $VAL[2])) {
	$VAL2_SPL = split(" ", $VAL_SPL[1]);
ECHO "&nbsp;주문번호 <A HREF='#' onclick=\"javascript:window.open('./wizmember/".$cfg["skin"]["MemberSkin"]."/PurchaseHisory.php?ORDER_CODE_VALUE=".chop($VAL2_SPL[0])."', 'cartform','width=670,height=700,statusbar=no,scrollbars=yes,toolbar=no')\"><B>".chop($VAL2_SPL[0])."</B></A> ".chop($VAL2_SPL[1]);
	}
	else {
ECHO "&nbsp;주문번호 <A HREF='#' onclick=\"javascript:window.open('./wizmember/".$cfg["skin"]["MemberSkin"]."/PurchaseHisory.php?ORDER_CODE_VALUE=".chop($VAL_SPL[1])."', 'cartform','width=670,height=700,statusbar=no,scrollbars=yes,toolbar=no')\"><B>".chop($VAL_SPL[1])."</B></A> $ORDER_MSG ";
	}
}
else {
ECHO "&nbsp;$VAL[2]";
}
?>
            </FONT></TD>
          <TD height="25" bgcolor="WHITE"><FONT COLOR=RED><b> </b></FONT>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><font color=BROWN>&nbsp; </font><font color=RED><b>
                  <?=number_format(str_replace("-","",$VAL[0]))?>
                  </b></font><font color=BROWN>&nbsp; </font></td>
                <td><?
if (eregi("-", $VAL[0])) {
ECHO "<OPTION style='color:red;'>감산(-)<OPTION>";
$ORDER_MSG = "<FONT COLOR=ORANGE>(거래취소)</FONT>";
}
else {
ECHO "<OPTION style='color:blue;'>가산(+)<OPTION>";
$ORDER_MSG = "(거래완료)";
}
?>
                </td>
              </tr>
            </table>
            <FONT COLOR=RED><b> </b></FONT></TD>
          <TD width="90" ALIGN=center><font color=BROWN>
            <?=date("Y/m/d", $VAL[1])?>
            </font><font color=RED><b> </b></font></TD>
        </TR>
        <?
$NO--;
	$SUB_SMONEY = $SUB_SMONEY + $VAL[0];

	}
}
?>
        <TR ALIGN=CENTER HEIGHT=40>
          <TD height="40" colspan=5 bgcolor="WHITE"><B>현재페이지 포인트 : <FONT COLOR=BLUE><?ECHO number_format($SUB_SMONEY);?></FONT> 포인트 | 총 획득 포인트 : <FONT COLOR=RED><?ECHO number_format($totalpoint);?></FONT> 포인트</B> </TD>
        </TR>
      </TABLE>
      <table width="95%" border="0" cellpadding="0" cellspacing="0">
        <TR>
          <TD WIDTH=50></TD>
          <TD ALIGN=CENTER><?
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
$page_arg1 = $PHP_SELF."?query=point";
$page_arg2 = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL); 
$page_arg3 = array("pre"=>"./wizmember/".$cfg["skin"]["MemberSkin"]."/images/pre.gif","next"=>"./wizmember/".$cfg["skin"]["MemberSkin"]."/images/next.gif");
echo $common->paging($page_arg1,$page_arg2,$page_arg3);
?>
          </TD>
          <TD WIDTH=50 align=right></TD>
        </TR>
      </TABLE></td>
  </tr>
</table>
