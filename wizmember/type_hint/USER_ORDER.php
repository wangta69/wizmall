<?php
/*<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

 제작자 : 폰돌                     
 URL : http://www.webpiad.co.kr      
 Email : master@webpiad.co.kr       
 Copyright (C) 2003  webpiad.co.kr 
 2003.11.04 - query=nonmember_order부분 에러 수정
 2004.02.03 - 코딩변경
*/

?>
<?
include "./config/DeliveryStatus_info.php";
?>
<?
if (!$HTTP_COOKIE_VARS[MEMBER_ID] || !is_file("./wizmember_tmp/login_user/$HTTP_COOKIE_VARS[MEMBER_ID].cgi")) {
	ECHO "<script language=javascript>
	window.alert(' 먼저 로그인해 주세요');
	history.go(-1);
	</script>";
	exit;
}
?> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="40" valign="top"> 
      <table width="100%" height="18" border="0" cellpadding="0" cellspacing="0" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
        <tr bgcolor="#F6F6F6"> 
                <td width="15" height="22">&nbsp;</td>
                <td width="18" height="22" valign="middle"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/sn_arrow.gif" width="13" height="13"></td>
                
          <td height="22">Home &gt; <strong>주문조회</strong></td>
              </tr>
            </table> 
    </td>
  </tr><tr><td align="center">
<table width="95%" border="0" cellspacing="0" cellpadding="5" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
        <tr> 
          <td bgcolor="#EEEEEE">- 고객님께서 주문하신 내역입니다.</td>
        </tr>
      </table></td>
  </tr><tr>
    <td align="center"> 
      <table width="95%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                
          <td align="center">&nbsp; </td>
              </tr>
              <tr> 
                <td align="right">&nbsp;</td>
              </tr>
              <tr> 
                <td align="right"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="company">
              <tr> 
                      <td><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
                    <tr> 
                            <td><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_cart_01.gif" width="8" height="11"></td>
                            <td>회원가입후 현재까지 <strong><?ECHO" $HTTP_COOKIE_VARS[MEMBER_NAME]($HTTP_COOKIE_VARS[MEMBER_ID])";?></strong> 의 주문내역 
                              입니다. </td>
                          </tr>
                          <tr> 
                            <td><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_cart_01.gif" width="8" height="11"></td>
                            <td> 주문번호를 클릭하면 자세한 사항을 보실 수 있습니다.</td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr> 
                      <td><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
                    <tr> 
                <td height="3" colspan="7" bgcolor="#CCCCCC"></td>
              </tr>
              <tr> 
                <td width="46" height="27" bgcolor="#f3f3f3">&nbsp;</td>
                <td height="27" align="center" bgcolor="#F2F2F2"><font color="#000000">주문번호</font></td>
                      <td height="27" align="center" bgcolor="#F2F2F2"><font color="#000000">상품명</font></td>
				<td width="103" align="center" bgcolor="#F2F2F2"><font color="#000000">구매금액</font></td>
                <td width="77" align="center" bgcolor="#F2F2F2"><font color="#000000"> 
                  결제방식</font></td>
                <td width="77" align="center" bgcolor="#F2F2F2"><font color="#000000"> 
                  거래상태</font></td>
                <td width="109" align="center" bgcolor="#F2F2F2"><font color="#000000"> 
                  주문일시</font></td>
              </tr>
              <tr> 
                <td height="1" colspan="7" bgcolor="#cfcfcf"></td>
              </tr>
<?
$ListNo = "15";
$PageNo = "20";
if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $ListNo;
if (!$sort) {$sort = "UID";}
$WHEREIS = "WHERE Co_Memberid='$HTTP_COOKIE_VARS[MEMBER_ID]'";
$sqlstr = "SELECT count(*) FROM wizBuyers $WHEREIS";
$TOTAL = $dbcon->get_one($sqlstr);
//--페이지 나타내기--
$TP = ceil($TOTAL / $ListNo) ; /* 페이지 하단의 총 페이지수 */
$CB = ceil($cp / $PageNo);
$SP = ($CB - 1) * $PageNo + 1;
$EP = ($CB * $PageNo);
$TB = ceil($TP / $PageNo);

$LIST_QUERY = "SELECT * FROM wizBuyers $WHEREIS ORDER BY $sort DESC LIMIT $START_NO,$ListNo";
$TABLE_DATA = $dbcon->_query($LIST_QUERY, $DB_CONNECT);
$TOTAL_QUERY = $dbcon->_query( "SELECT SUM(Total_Money) FROM wizBuyers $WHEREIS", $DB_CONNECT );
$TOTAL_SMONEY = $dbcon->_fetch_array($TOTAL_QUERY);
$TOTAL_SMONEY = $TOTAL_SMONEY[0];
$NO = $TOTAL-($ListNo*($cp-1));
while( $list = $dbcon->_fetch_array( $TABLE_DATA ) ) :
	$Address = split(" ", $list[Address]);
	$Message = nl2br(stripslashes($list[Message]));
	$How_Bank = split("\|", $list[How_Bank]);
	$SUB_SMONEY = $SUB_SMONEY + $list[Total_Money];
	//------------------------------------------[결제방식]
	if ($list[How_Buy] == 'card') {$PayWay = "신용카드";}
	else if ($list[How_Buy] == 'point') {$PayWay = "포인트";}
	else if ($list[How_Buy] == 'all') {$PayWay = "다중결제";}
	else {$PayWay = "온라인";}
	//--------------------------------------------------
$Co_Now = $list[Co_Now];
?>			  
              <tr> 
                <td width="46" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"><?=$NO?></font></td>
                      <td height="27" align="center"><strong><a href="<?=$PHP_SELF?>?query=non_member_order&ORDER_CODE_VALUE=<?=$list[CODE_VALUE]?>"> 
                        <?=$list[CODE_VALUE]?>
                        </a></strong></td>
                      <td height="27" align="center"><?
$Cart_Data = split("\n", $list[Co_Name]);
for($i = 0; $i < sizeof($Cart_Data) && chop($Cart_Data[$i]); $i++) {
$C_dat = split("\|", chop($Cart_Data[$i]));
$VIEW_QUERY = "SELECT * FROM wizMall WHERE UID='$C_dat[0]'";

$dbcon->_query($VIEW_QUERY);
$VIEW_DATA = $dbcon->_fetch_array();
$List[UID] = $VIEW_DATA[UID];
$VIEW_DATA[Name] = stripslashes($VIEW_DATA[Name]);
$Price = number_format($C_dat[2]);
$Point = number_format($VIEW_DATA[Point] * $C_dat[1]);
$Category = $VIEW_DATA[Category];
$SUM_MONEY = number_format($C_dat[2] * $C_dat[1]);
$TOTAL_POINT = $TOTAL_POINT + ($VIEW_DATA[Point] * $C_dat[1]);
?>					  
					  <A HREF='../wizmart.php?code=<?=$VIEW_DATA[Category]?>&query=view&no=<?=$List[UID]?>' target=_blank><FONT COLOR=BLUE><U> 
      <?=$VIEW_DATA[Name]?>
      <?if($VIEW_DATA[Model]):?>
      ( 
      <?=$VIEW_DATA[Model]?>
      )
      <? endif;?>
      </U></FONT></A><BR> 
      <?
                if         ($C_dat[4]) {
                        ECHO " <FONT COLOR=#CE6500>$C_dat[4] </FONT>";
                }

/* 기타옵션이 있을 경우 확 뿌려준다 */
for($j=5; $j < sizeof($C_dat); $j++){
if($C_dat[$j]) echo  " | <FONT COLOR=#CE6500>$C_dat[$j] </FONT>";
}
}//for($i = 0; $i < sizeof($Cart_Data) && chop($Cart_Data[$i]
?></td>
                <td width="103" align="center"><?=number_format($list[Total_Money])?> 원</td>
                <td width="77" align="center"><?=$PayWay?></td>
                <td width="77" align="center"><?=$DeliveryStatusArr[$Co_Now];?></td>
                <td width="109" align="center"><?=date("Y.m.d",$list[Buy_Date])?></td>
              </tr>
              <tr> 
                <td height="1" colspan="7" bgcolor="#cfcfcf"></td>
              </tr>
<?
$NO--;
endwhile;
?>			  
              <tr align="center"> 
                <td height="27" colspan="7" bgcolor="#f3f3f3">현재페이지 합계금액 : <strong><font color="E37509"><?=number_format($SUB_SMONEY)?>
                  원</font></strong>| 총 주문금액 : <strong><font color="703EAE"><?=number_format($TOTAL_SMONEY);?>
                  원 </font></strong></td>
              </tr>
              <tr> 
                <td height="1" colspan="7" bgcolor="#cfcfcf"></td>
              </tr>
              <tr align="center"> 
                <td height="27" colspan="7"> 
<?
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
$PostValue = "query=order";	  
if ( $CB > 1 ) {
$PREV_PAGE = $SP - 1;
echo "<a href='$PHP_SELF?cp=$PREV_PAGE&$PostValue'><img src='./wizmember/".$cfg["skin"]["MemberSkin"]."/images/prev2.gif' hspace='5' border='0'></a>";
} else {
echo "<img src='./wizmember/".$cfg["skin"]["MemberSkin"]."/images/prev2.gif' hspace='5' border='0'>";
 }
/* LISTING NUMBER PART */
for ($i = $SP; $i <= $EP && $i <= $TP ; $i++) {
if($cp == $i){$NUMBER_SHAPE= "<font color = 'gray'><B>${i}</B></font>";}
else $NUMBER_SHAPE="<font color = 'gray'>".${i}."</font>";
ECHO"&nbsp;<A HREF='$PHP_SELF?cp=$i&$PostValue'>$NUMBER_SHAPE</a>";
}
/* NEXT or END PART */
if ($CB < $TB) {
$NEXT_PAGE = $EP + 1;
ECHO "&nbsp;<a href='$PHP_SELF?cp=$NEXT_PAGE&$PostValue'><img src='./wizmember/".$cfg["skin"]["MemberSkin"]."/images/next2.gif' hspace='5' border='0'></a>";
} else {
ECHO"&nbsp;<img src='./wizmember/".$cfg["skin"]["MemberSkin"]."/images/next2.gif' hspace='5' border='0'>";
}
?>
                </td>
              </tr>
              <tr> 
                <td height="1" colspan="7" bgcolor="#cfcfcf"></td>
              </tr>
            </table></td>
                    </tr>
                  </table></td>
              </tr>
              <tr> 
                <td align="right">&nbsp;</td>
              </tr>
            </table>
    </td>
  </tr>
</table>
