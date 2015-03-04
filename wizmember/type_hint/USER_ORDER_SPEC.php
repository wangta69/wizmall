<?php
/*
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
 제작자 : 폰돌                     
 URL : http://www.shop-wiz.com      
 Email : master@shop-wiz.com       
 Copyright (C) 2003  shop-wiz.com 
 2003-10-11 query 통폐합으로 인한 일부 버그 수정
 2004-07-06 ORDER_CODE_VALUE에대한 버그 수정
*/
?>
<?
include "./config/DeliveryStatus_info.php"; //주문상태
include "./config/Deliverer_info.php";
?>
<?
if(!$ORDER_CODE_VALUE && (!$HTTP_COOKIE_VARS[MEMBER_ID] || !file_exists("../wizmember_tmp/login_user/$HTTP_COOKIE_VARS[MEMBER_ID].cgi"))){ /* 회원으로 로긴 했을 경우 */
	ECHO "<script language=javascript>
	window.alert(' 손님께서는 로그인되어있지 않습니다. ');
	self.close();
	</script>";
	exit;
}
 
if($uid){ 
	$sqlstr = "SELECT * FROM wizBuyers WHERE CODE_VALUE='$uid'";
	$dbcon->_query($sqlstr);
	$List = $dbcon->_fetch_array();
}else if($ORDER_CODE_VALUE){ 
	$sqlstr = "SELECT * FROM wizBuyers WHERE CODE_VALUE='$ORDER_CODE_VALUE'";
	$dbcon->_query($sqlstr);
	$List = $dbcon->_fetch_array();
}
/*회원으로 로긴 했을 경우 끝*/
if (!$List) {
	ECHO "<script language=javascript>
	window.alert('\\n\\n주문번호 : ${uid}$ORDER_CODE_VALUE 에 대한 데이터가 삭제되었습니다.    \\n\\n관리자에게 문의하십시오.\\n\\n');
	self.close();
	</script>";
	exit;
}
$List[Message] = nl2br(stripslashes($List[Message]));
$Co_Now = $List[Co_Now];
if (!$List[Co_Memberid]) {$List[Co_Memberid] = "비회원";}
$Deliverer=$List[Deliverer];
?> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><table width="100%" height="18" border="0" cellpadding="0" cellspacing="0" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
        <tr bgcolor="#F6F6F6"> 
          <td width="15" height="22">&nbsp;</td>
          <td width="18" height="22" valign="middle"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/sn_arrow.gif" width="13" height="13"></td>
          <td height="22">Home &gt; <strong>주문 조회</strong></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="40">&nbsp;</td>
  </tr>
  <tr> 
    <td align="center">
<table width="95%" border="0" cellspacing="0" cellpadding="5" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
        <tr> 
          <td bgcolor="#EEEEEE">- 고객님께서 주문하신 상품의 상세 내역입니다.</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td align="center">
<table width="95%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="right"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
              <tr> 
                <td><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_cart_01.gif" width="8" height="11">고객님께서 
                  선택하신 상품내역입니다.</td>
              </tr>
              <tr> 
                <td><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
                    <tr> 
                      <td height="3" colspan="4" bgcolor="#E08B18"></td>
                    </tr>
                    <tr align="center"> 
                      <td width="242" height="29" bgcolor="#FCF7F3">주문상품 </td>
                      <td width="99" height="29" bgcolor="#FCF7F3">가격</td>
                      <td width="72" height="29" bgcolor="#FCF7F3">수량</td>
                      <td width="151" height="29" bgcolor="#FCF7F3">합계<?if($HTTP_COOKIE_VARS[MEMBER_ID]) echo"/포인트";?> </td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="4" bgcolor="E37509"></td>
                    </tr>
<?
$Cart_Data = split("\n", $List[Co_Name]);
for($i = 0; $i < sizeof($Cart_Data) && chop($Cart_Data[$i]); $i++) {
$C_dat = split("\|", chop($Cart_Data[$i]));
$VIEW_QUERY = "SELECT * FROM wizMall WHERE UID='$C_dat[0]'";
$dbcon->_query($VIEW_QUERY);
$VIEW_DATA = $dbcon->_fetch_array();
$UID = $VIEW_DATA[UID];
$VIEW_DATA[Name] = stripslashes($VIEW_DATA[Name]);
$CHECK = number_format($VIEW_DATA[Price]);
$POINT = number_format($VIEW_DATA[Point] * $C_dat[1]);
$CATEGORY = $VIEW_DATA[Category];
$GET_COMP = $VIEW_DATA[GetComp];
$SUM_MONEY = number_format($VIEW_DATA[Price] * $C_dat[1]);
$TOTAL_MONEY = $TOTAL_MONEY + ($VIEW_DATA[Price] * $C_dat[1]);
$TOTAL_POINT = $TOTAL_POINT + ($VIEW_DATA[Point] * $C_dat[1]);
?>
                    <tr align="center"> 
                      <td height="30"><A HREF='./wizmart.php?code=<?=$VIEW_DATA[Category]?>&query=view&no=<?=$VIEW_DATA[UID]?>' target="_blank"><?=$VIEW_DATA[Name]?></a><BR> 
                        <?
		if 	($C_dat[2]) {
			if (eregi("=", $C_dat[2])) {
				$SIZE_OPTION_SPL = split("=", $C_dat[2]);
				ECHO "<FONT COLOR=#CE6500>$SIZE_OPTION_SPL[0]<FONT COLOR=RED>(".number_format(chop($SIZE_OPTION_SPL[1]))."원추가)</FONT></FONT> ";
				$CHECK = number_format(str_replace(",","", $CHECK) + chop($SIZE_OPTION_SPL[1]));
				$SUM_MONEY = number_format(str_replace(",","", $SUM_MONEY) + (chop($SIZE_OPTION_SPL[1])*$C_dat[1]));
				$TOTAL_MONEY = $TOTAL_MONEY + (chop($SIZE_OPTION_SPL[1])*$C_dat[1]);
			}
			else {
			ECHO "<FONT COLOR=#CE6500>$C_dat[2]</FONT> ";
			}
		}
		if 	($C_dat[3]) {
			ECHO " <FONT COLOR=#CE6500>$C_dat[3]</FONT>";
		}
?>
                      </td>
                      <td width="99" height="30"><font color="#4A74A6"><?=number_format($VIEW_DATA[Price])?>원</font> 
                      </td>
                      <td width="72" height="30"><INPUT TYPE=TEXT SIZE=4 NAME='BUYNUM' MAXLENGTH=5 VALUE='<?=$C_dat[1]?>'>
                        EA</td>
                      <td width="151" height="30"><strong><font color="E37509"><?=$SUM_MONEY?>원</font></strong><br> 
                        <FONT COLOR=GREEN><?if($HTTP_COOKIE_VARS[MEMBER_ID]) echo"$POINT 포인트";?></FONT> </td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="4" bgcolor="#CCCCCC"></td>
                    </tr>
<?
}   // for
$Tack_Money = $List[Total_Money] - $TOTAL_MONEY;
?>
                    <tr align="center"> 
                      <td height="30" colspan="4" bgcolor="#CCCCCC">주문상품 가격합계 
                        : <strong><font color="#000000"><?ECHO number_format($List[Total_Money]);?>원</font></strong> 
                        (배송비 <?ECHO number_format($Tack_Money);?>원 포함)<?if($HTTP_COOKIE_VARS[MEMBER_ID]) echo" - 지급포인트 
                        : <strong>".number_format($TOTAL_POINT)."포인트";?></strong></td>
                    </tr>
                  </table></td>
              </tr>
              <tr> 
                <td><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/title_orderinfo02.gif" width="114" height="35"></td>
              </tr>
              <tr> 
                <td><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
                    <tr bgcolor="#CCCCCC"> 
                      <td height="3" colspan="3"></td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>입금인</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"><?ECHO "<A HREF='mailto:$List[Sender_Email]'>$List[Sender_Name]</A> ($Co_Memberid)";?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" bgcolor="#cfcfcf"></td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>E-mail</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"><?ECHO "<A HREF='mailto:$List[Sender_Email]'>$List[Sender_Email]</A>";?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" bgcolor="#cfcfcf"></td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>전화번호</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"><?ECHO"$List[Sender_Tel]";?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" bgcolor="#cfcfcf"></td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>휴대전화번호</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"><?ECHO"$List[Sender_Pcs]";?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" bgcolor="#cfcfcf"></td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>수령인</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"><?ECHO"$List[Re_Name]";?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" bgcolor="#cfcfcf"></td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>배송지주소</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27">(<?ECHO"$List[Zip]";?>) <?ECHO"$List[Address]";?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" bgcolor="#cfcfcf"></td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>배송지전화</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"><?ECHO"$List[Re_Tel]";?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" bgcolor="#cfcfcf"></td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>희망배송일</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"><?ECHO "$List[Re_Date]";?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" bgcolor="#cfcfcf"></td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>배송안내글</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"><FONT COLOR=BROWN><?ECHO "$List[Message]";?></FONT></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" bgcolor="#cfcfcf"></td>
                    </tr>
                  </table></td>
              </tr>
              <tr> 
                <td><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/title_ing.gif" width="83" height="35"></td>
              </tr>
              <tr> 
                <td><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
                    <tr> 
                      <td height="3" colspan="3" bgcolor="#CCCCCC"></td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>주문번호</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"><font color="#FF6600"><strong><?ECHO "$List[CODE_VALUE]";?></strong></font></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" bgcolor="#cfcfcf"></td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>주문일자</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"><?=date("Y.m.d",$List[Buy_Date])?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" bgcolor="#cfcfcf"></td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>거래상태</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"> 
<?=$DeliveryStatusArr[$Co_Now];?>
                      </td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" bgcolor="#cfcfcf"></td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>택배사</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"> 
<a href="<?=$DelivererArr[$Deliverer]?>" target="_blank">					  
<?=$Deliverer?></a>
                      </td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" bgcolor="#cfcfcf"></td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>송장번호</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"> 
<?=$List[InvoiceNo]?>
                      </td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" bgcolor="#cfcfcf"></td>
                    </tr>										
                  </table></td>
              </tr>
              <tr> 
                <td><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/title_payment01.gif" width="104" height="35"><br> 
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
                    <tr> 
                      <td height="3" colspan="3" bgcolor="#CCCCCC"></td>
                    </tr>
                    <?
//------------------------------------------[결제방식]
if ($List[How_Buy] == 'card') {
?>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>결제방식</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"><strong>신용카드 결재</strong></td>
                    </tr>
                    <?
}
else if ($List[How_Buy] == 'point') {
?>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>결제방식</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"><strong>포인트구매</strong></td>
                    </tr>
                    <?
}
else if ($List[How_Buy] == 'all') {
?>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>결제방식</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"><strong>다중구매(온라인 + 신용카드 + 포인트)</strong></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" bgcolor="#cfcfcf"></td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>온라인입금</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"><B><?ECHO number_format($List[Ziro_Money]);?>원</B></td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>입금계좌</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"> 
                        <?=$List[How_Bank]?>
                      </td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>신용카드</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"><B><?ECHO number_format($List[Card_Money]);?>원</B></td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>포인트</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"><B><?ECHO number_format($List[Point_Money]);?>원</B></td>
                    </tr>
                    <?
}
else {
?>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>결제방식</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"><strong>온라인 입금</strong></td>
                    </tr>
                    <tr> 
                      <td width="142" height="27" bgcolor="#f3f3f3"><font color="#144179"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/point_list_01.gif" width="21" height="9"></font>임금계좌</td>
                      <td width="12" height="27"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_a.gif" width="12" height="27"></td>
                      <td height="27"> 
                        <?=$List[How_Bank]?>
                      </td>
                    </tr>
                    <?
}
//--------------------------------------------------
?>
                    <tr> 
                      <td height="1" colspan="3" bgcolor="#cfcfcf"></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td align="center"> 
            <table width="564" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td height="36" align="center" valign="bottom"><table width="200" height="42" border="0" cellpadding="0" cellspacing="0">
                    <tr align="center"> 
                      <!-- <td><A HREF='#' onclick='jvascript:self.close()'><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_close.gif" width="88" height="28" border="0"></a></td> -->
                      <td><A HREF='#' onclick='jvascript:self.print()'><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_print.gif" width="88" height="28" border="0"></a></td>
                    </tr>
                  </table>
                  <br> </td>
              </tr>
            </table></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>
<br>
