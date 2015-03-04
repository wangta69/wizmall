<?php
/*
 powered by 폰돌
 Reference URL : http://www.shop-wiz.com
 Contact Email : master@shop-wiz.com
 Free Distributer :

 Copyright shop-wiz.com
 *** Updating List ***
 */
?>

<table  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="8"></td>
    <td height="8"></td>
  </tr>
  <tr>
    <td></td>
    <td valign="top"><table>
        <tr>
          <td bgcolor="#FFFFFF"><b><font color="#FF6600">주문완료상품</font></b></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"><table cellspacing=0 cellpadding=0 width="100%" border=0 class="s1">
              <tr>
                <td width="70" align="center" valign="top"><font color=#ff6600>[note]</font></td>
                <td> 주문완료 상품의 매출통계를 보실 수 있습니다.<br />
                  아래 배송비는 순수상품가에서 주문금액을 뺀 경우 이므로 옵션별 사항에 따라 
                  금액의 변동이 있을 수 있습니다.</td>
              </tr>
            </table></td>
        </tr>
      </table>
      <br />
      <TABLE>
        <form action='<?=$PHP_SELF ?>' method=post>
	        <input type="hidden" name="csrf" value="<?=$common -> getcsrfkey() ?>">
	        <input type="hidden" name='menushow' value='<?=$menushow ?>'>
	        <input type="hidden" name="theme" value='<?=$theme ?>'>
          <TR>
            <TD bgColor=#ffffff width="100"><select name=WHERE>
                <option value=''>검색영역</option>
                <option value=''>----------</option>
                <option value='OrderID'<?
					if ($WHERE == 'OrderID') {ECHO " SELECTED";
					}
				?>>주문번호</option>
                <option value='SName'<?
					if ($WHERE == 'SName') {ECHO " SELECTED";
					}
				?>>주문자</option>
                <option value='RName'<?
					if ($WHERE == 'RName') {ECHO " SELECTED";
					}
				?>>입금자</option>
                <option value='RCompany'<?
					if ($WHERE == 'RCompany') {ECHO " SELECTED";
					}
				?>>상호명</option>
              </select>
            </TD>
            <TD bgColor=#ffffff width="80"><input size=10 name=keyword value='<?=$keyword ?>'>
            </TD>
            <TD bgColor=#ffffff width="270"><INPUT TYPE="image" src="img/se.gif" width="66" height="20">
              <input name="image" type="image" src="img/list.gif" width="66" height="20" onClick="location.replace('<?=$PHP_SELF ?>?menushow=<?=$menushow ?>&theme=<?=$theme ?>')"></TD>
            <TD bgColor=#ffffff width="134">&nbsp;
              <select style="WIDTH: 120px" 
                        onChange=this.form.submit() name=sorting>
                <option value=''>결제방식 구분</option>
                <option value=''>----------------</option>
                <option value='online'>온라인구매</option>
                <option value='card'<?
					if ($sorting == 'card') {ECHO " selected";
					}
				?>>신용카드결제</option>
                <option value='hand'<?
					if ($sorting == 'hand') {ECHO " selected";
					}
				?>>핸드폰결제</option>
                <option value='point'<?
					if ($sorting == 'point') {ECHO " selected";
					}
				?>>포인트결제</option>
                <option value='all'<?
					if ($sorting == 'all') {ECHO " selected";
					}
				?>>다중결제</option>
              </select>
            </TD>
            <TD bgColor=#ffffff width="166"><div align="right">
                <select 
                        style="WIDTH: 140px" onChange=this.form.submit() 
                        name=sort>
                  <option value='UID'>선택부분별 정렬</option>
                  <option value='UID'>-------------------</option>
                  <option value='TotalAmount'<?
					if ($sort == 'TotalAmount') {ECHO " SELECTED";
					}
				?>>구매금액순 
                  정렬</option>
                  <option value='RAddress1'<?
					if ($sort == 'RAddress1') {ECHO " SELECTED";
					}
				?>>구매지역 
                  구분</option>
                  <option value='PayMethod'<?
					if ($sort == 'PayMethod') {ECHO " SELECTED";
					}
				?>>결제방식 
                  구분</option>
                  <option value='MemberID'<?
					if ($sort == 'MemberID') {ECHO " SELECTED";
					}
				?>>(비)회원 
                  구분</option>
                </select>
              </div></TD>
          </TR>
        </FORM>
        </TBODY>
        
      </TABLE>
      <br />
      <table cellspacing=1 bordercolordark=white width="760" bgcolor=#c0c0c0 bordercolorlight=#dddddd border=0 class="s1" cellpadding="1">
        <tr align=center bgcolor=#B9C2CC>
          <td height="19" bgcolor="E0E4E8">&nbsp; </td>
          <td>주문번호</td>
          <td bgcolor="E0E4E8">결제금액</td>
          <td bgcolor="#B9C2CC">(배송비외)</td>
          <td bgcolor="E0E4E8">결제방식</td>
          <td bgcolor="#B9C2CC">주문자</td>
          <td bgcolor="E0E4E8">전화</td>
          <td bgcolor="#B9C2CC">상호</td>
          <td bgcolor="E0E4E8">주문일시</td>
        </tr>
        <?
/* 페이징과 관련된 수식 구하기 */
$ListNo = "15";
$PageNo = "20";
if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $ListNo;
$Sdate = mktime(0,0,0,$SMonth, $SDay, $SYear);
$Fdate = mktime(0,0,0,$FMonth, $FDay+1, $FYear);

if ($action == 'detail_search') {
        $SDay_minus = $SDay - 1;
        if ($SDay_minus < 10) {
        $SDay_minus = "0".$SDay_minus;
        }
        if ($BuyMethod == 'all'){$How_Query = "";}else{$How_Query = "AND PayMethod='$BuyMethod'";}
        $WHEREIS = "WHERE BuyDate >= '$Sdate' AND BuyDate <= '$Fdate' AND OrderStatus=50 $How_Query";
        $sort = $Dsort;
}
else {
        $BuyMethod = "all";
        if (!$sort) {$sort = "UID";}
        if ($WHERE && $keyword) {$WHEREIS = "WHERE $WHERE LIKE '%$keyword%' AND OrderStatus=50";}
        else {$WHEREIS = "WHERE OrderStatus=50";}
        if ($sorting) {
                $WHEREIS = "WHERE OrderStatus=50 AND PayMethod='$sorting'";
        }
}

$sqlstr = "SELECT count(*) FROM wizBuyers $WHEREIS";
$TOTAL = $dbcon->get_one($sqlstr);

//--페이지링크를 작성하기--
$LIST_QUERY = "SELECT * FROM wizBuyers $WHEREIS ORDER BY $sort DESC LIMIT $START_NO,$ListNo";
//echo "\$LIST_QUERY = $LIST_QUERY <br />";
$TABLE_DATA = $dbcon->_query($LIST_QUERY);

$TOTAL_QUERY = $dbcon->_query( "SELECT SUM(TotalAmount) FROM wizBuyers WHERE OrderStatus=50");
$TOTAL_SMONEY = $dbcon->_fetch_array($TOTAL_QUERY);
$TOTAL_SMONEY = $TOTAL_SMONEY[0];

$NO = $TOTAL-($ListNo*($cp-1));
while( $list = $dbcon->_fetch_array( $TABLE_DATA ) ) :
        $RAddress1 = explode(" ", $list["RAddress1"]);
		$BankInfo = explode("|", $list["BankInfo"]);
        $SUB_SMONEY = $SUB_SMONEY + $list["TotalAmount"];
		$OrderStatus = $list["OrderStatus"];
		$PayMethod = $list["PayMethod"];
		$PayWay = ($PayMethod)?$PaySortArr[$PayMethod]:"온라인결제";
        //--------------------------------------------------
        if (!$list["MemberID"]) {$list["MemberID"] = "비회원";}

/*
reset($DeliveryStatusArr);
while(list($key, $value) = each($DeliveryStatusArr)):
	if($sorting == $key) $selected = "selected";
	else unset($selected);
	echo "<option value='A' $selected>$value</option>\n";
endwhile;
*/
$tmp_color = array("10"=>"blue","20"=>"green","30"=>"orange","40"=>"brown","50"=>"red"); 
$DeveryStatus = "<font color='".$tmp_color[$OrderStatus]."'>".$DeliveryStatusArr[$OrderStatus]."</font>";
if($PayWay == "카드" && $OrderStatus == "10") $DeveryStatus = "<font color='red'>결제실패</font>";

$subsqlstr = "select sum(BuyPrice*BuyGoodsQty) as SumPrice from wizBuyersMore where BuyCode = '$list[OrderID]'";
$BuyPrice = $dbcon->get_one($subsqlstr);
$DeliveryFee = $list["TotalAmount"] - $BuyPrice;
?>
        <tr align=center bgcolor=#B9C2CC>
          <td height="19" bgcolor="#f3f3f3">
            <?=$NO ?>
          </td>
          <td bgcolor="white"><a href='#' onClick="javascript:window.open('./order/order1_1.php?uid=<?=$list[UID] ?>', 'cartform','width=620,height=600,statusbar=no,scrollbars=yes,toolbar=no')"> 
            <?=$list["OrderID"] ?>
            </a></td>
          <td bgcolor="white">
            <?=number_format($list["TotalAmount"]) ?>
            원 </td>
          <td bgcolor="white">
            <?=number_format($DeliveryFee) ?>
            원</td>
          <td bgcolor="white"><font color=green>
            <?
			if (!strcmp($list["PayMethod"], "card") || !strcmp($list["PayMethod"], "all"))
				echo "<a href='" . $PgCorpArr[$cfg["pay"]["CARD_PACK"]] . "' target='_blank'><font color='GREEN'>$PayWay</font></a>";
			else
				echo "$PayWay";
		?>
            </font></td>
          <td bgcolor="white">
            <?=$list["SName"] ?>
            (
            <?=$list["MemberID"] ?>
            )</td>
          <td bgcolor="white">
            <?=$list["STel1"] ?>
            </td>
          <td bgcolor="white">
            <?=$list["RCompany"] ?>
            </td>
          <td bgcolor="white"><? echo date("Y.m.d H:i", $list["BuyDate"]); ?></td>
        </tr>
        <?
		$NO--;
		endwhile;
	?>
        <form action='<?=$PHP_SELF ?>' method="post">
        	<input type="hidden" name="csrf" value="<?=$common -> getcsrfkey() ?>">
        	<input type='hidden' name='menushow' value='<?=$menushow ?>'>
            <input type=HIDDEN name=theme value='order2'>
            <input type=HIDDEN name=action value='detail_search'>
          <tr bgcolor=white height=25>
            <td colspan="8" bgcolor=#f3f3f3 height="15">
              <?

			if (!$action) {
				$year = date("Y");
				$month = date("m");
				$day = date("j");
			} else {
				$year = $SYear;
				$month = $SMonth;
				$day = $SDay;
			}
			ECHO "&nbsp;<select name='SYear' size='1'>";
			for ($i = "2005"; $i <= 2009; $i++) {
				if ($year == $i) {
					echo "<option value='$i' selected>${i}년</option>\n";
				} else {
					echo "<option value='$i'>${i}년</option>\n";
				}
			}

			echo "</select>
<select name='SMonth' size='1'>";
			for ($i = "01"; $i <= 12; $i++) {
				if ($month == $i) {
					echo "<option value='$i' selected>${i}월</option>\n";
				} else {
					echo "<option value='$i'>${i}월</option>\n";
				}
			}

			echo "
</select>
<select name='SDay' size='1'>";
			for ($i = "01"; $i <= 31; $i++) {
				if ($day == $i) {
					echo "<option value='$i' selected>${i}일</option>\n";
				} else {
					echo "<option value='$i'>${i}일</option>\n";
				}
			}
			echo "</select>";
		?>
              부터
              <?
			if (!$action) {
				$year = date("Y");
				$month = date("m");
				$day = date("j");
			} else {
				$year = $FYear;
				$month = $FMonth;
				$day = $FDay;
			}
			ECHO "<select name='FYear' size='1'>";
			for ($i = "2005"; $i <= 2009; $i++) {
				if ($year == $i) {
					echo "<option value='$i' selected>${i}년</option>\n";
				} else {
					echo "<option value='$i'>${i}년</option>\n";
				}
			}

			echo "</select>
<select name='FMonth' size='1'>";
			for ($i = "01"; $i <= 12; $i++) {
				if ($month == $i) {
					echo "<option value='$i' selected>${i}월</option>\n";
				} else {
					echo "<option value='$i'>${i}월</option>\n";
				}
			}

			echo "
</select>
<select name='FDay' size='1'>";
			for ($i = "01"; $i <= 31; $i++) {
				if ($day == $i) {
					echo "<option value='$i' selected>${i}일</option>\n";
				} else {
					echo "<option value='$i'>${i}일</option>\n";
				}
			}
			echo "</select>";
		?>
              까지 <br />
              <table width="484" border="0" class="s1">
                <tr>
                  <td width="158"><select style="WIDTH: 150px" name=Dsort>
                      <option 
                          value=UID selected>기간별 정렬선택</option>
                      <option 
                          value=UID>-------------------</option>
                      <option 
                          value=TotalAmount>구매금액순 정렬</option>
                      <option 
                          value=SAddress1>구매지역 구분</option>
                      <option 
                          value=PayMethod>결제방식 구분</option>
                      <option 
                          value=MemberID>(비)회원 구분</option>
                    </select>
                  </td>
                  <td><input type="image" src="img/se.gif" width="66" height="20">
                  </td>
                  <td width="60">[<a href='<?=$PHP_SELF ?>?menushow=<?=$menushow ?>&theme=order2&action=detail_search&SYear=<?=date("Y") ?>&SMonth=01&SDay=01&FYear=<?=date("Y") ?>&FMonth=12&FDay=31&Dsort=UID&BuyMethod=all'> <font color='#0000FF'>
                    <?=date("Y") ?>
                    년</font></a>]</td>
                  <td width="60">[<a href='<?=$PHP_SELF ?>?menushow=<?=$menushow ?>&theme=order2&action=detail_search&SYear=<?=date("Y") ?>&SMonth=<?=date("m") ?>&SDay=01&FYear=<?=date("Y") ?>&FMonth=<?=date("m") ?>&FDay=31&Dsort=UID&BuyMethod=all'> <font color='#0000FF'>
                    <?=date("m") ?>
                    월</font></a>]</td>
                  <td width="60">[<a href='<?=$PHP_SELF ?>?menushow=<?=$menushow ?>&theme=order2&action=detail_search&SYear=<?=date("Y") ?>&SMonth=<?=date("m") ?>&SDay=<?=date("d") ?>&FYear=<?=date("Y") ?>&FMonth=<?=date("m") ?>&FDay=<?=date("d") ?>&Dsort=UID&BuyMethod=all'> <font color='#0000FF'>
                    <?=date("d") ?>
                    일</font>] </a></td>
                </tr>
              </table></td>
            <td height="15" colspan="2">현재페이지 합계금액 :
              <?=number_format($SUB_SMONEY); ?>
              원<br />
              매출 총액 :
              <?=number_format($TOTAL_SMONEY); ?>
              원 </td>
          </tr>
        </form>
        <tr bgcolor=white height=40>
          <td colspan=10><b></b></td>
        </tr>
        </tbody>
        
      </table>
      <br />
      <table width="760" border="0" cellspacing="0" cellpadding="0" class="s1">
        <tr>
          <td align="center"><?
		/* 페이지 번호 리스트 부분 */
		/* PREVIOUS or First 부분 */
		$page_arg1 = $PHP_SELF . "menushow=$menushow&theme=order2&WHERE=$WHERE&keyword=" . urlencode($keyword) . "&SELECT_SORT=$SELECT_SORT&SYear=$SYear&SMonth=$SMonth&SDay=$SDay&FYear=$FYear&FMonth=$FMonth&FDay=$FDay&DataEnable=$DataEnable";
		$page_arg2 = array("listno" => $ListNo, "pageno" => $PageNo, "cp" => $cp, "total" => $TOTAL);
		//$page_arg3 = array("pre"=>"./img/pre.gif","next"=>"./img/next.gif");
		echo $common -> paging($page_arg1, $page_arg2, $page_arg3);
	?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
