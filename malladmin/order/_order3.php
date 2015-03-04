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
    <td valign="top"><table cellspacing=0 bordercolordark=white width="760" bgcolor=#c0c0c0 bordercolorlight=#dddddd border=1 class="s1">
        <tr>
          <td bgcolor="#FFFFFF"><b><font color="#FF6600">반송상품</font></b></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"><table cellspacing=0 cellpadding=0 width="100%" border=0 class="s1">
              <tr>
                <td width="70" align="center" valign="top"><font color=#ff6600>[note]</font></td>
                <td> 반송상품을 보실 수 있습니다.</td>
              </tr>
            </table></td>
        </tr>
      </table>
      <br />
      <TABLE>
        <form action='<?=$PHP_SELF?>' method=post>
        	<input type="hidden" name="csrf" value="<?=$common->getcsrfkey()?>">
			<input type="hidden" name='menushow' value='<?=$menushow?>'>
			<input type="hidden" name=theme value='<?=$theme?>'>
          <TR>
            <TD bgColor=#ffffff width="106"><select name=WHERE>
                <option value=''>검색영역</option>
                <option value=''>----------</option>
                <option value='OrderID'<?if($WHERE=='OrderID'){ECHO" SELECTED";}?>>주문번호</option>
                <option value='SName'<?if($WHERE=='SName'){ECHO" SELECTED";}?>>주문자</option>
                <option value='RName'<?if($WHERE=='RName'){ECHO" SELECTED";}?>>입금자</option>
                <option value='RAddress1'<?if($WHERE=='RAddress1'){ECHO" SELECTED";}?>>주문지역</option>
              </select>
            </TD>
            <TD bgColor=#ffffff width="116">
              <input size=15 name=keyword>
              </TD>
            <TD bgColor=#ffffff width="164"><input type="image" src="img/se.gif" width="66" height="20">
              <input name="image" type="image" src="img/list.gif" width="66" height="20" onClick="location.replace('<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=<?=$theme?>')"></TD>
            <TD bgColor=#ffffff width="46">&nbsp;</TD>
            <TD bgColor=#ffffff width="148">&nbsp;
              <select style="WIDTH: 120px" 
                        onChange=this.form.submit() name=ing_sort>
                <option value='ziro'>결제방식 구분</option>
                <option value='ziro'>----------------</option>
                <option value='ziro'>온라인구매</option>
                <option value='card'<?if($ing_sort=='card'){ECHO" selected";}?>>신용카드결제</option>
                <option value='point'<?if($ing_sort=='point'){ECHO" selected";}?>>포인트결제</option>
                <option value='all'<?if($ing_sort=='all'){ECHO" selected";}?>>다중결제</option>
              </select>
            </TD>
            <TD bgColor=#ffffff width="168"><div align="right">
                <select 
                        style="WIDTH: 140px" onChange=this.form.submit() 
                        name=sort>
                  <option value='UID'>선택부분별 정렬</option>
                  <option value='UID'>-------------------</option>
                  <option value='TotalAmount'<?if($sort=='TotalAmount'){ECHO" SELECTED";}?>>구매금액순 
                  정렬</option>
                  <option value='RAddress1'<?if($sort=='RAddress1'){ECHO" SELECTED";}?>>구매지역 
                  구분</option>
                  <option value='PayMethod'<?if($sort=='PayMethod'){ECHO" SELECTED";}?>>결제방식 
                  구분</option>
                  <option value='MemberID'<?if($sort=='MemberID'){ECHO" SELECTED";}?>>(비)회원 
                  구분</option>
                </select>
              </div></TD>
          </TR>
        </form>
        </TBODY>
        
      </TABLE>
      <br />
      <table cellspacing=1 bordercolordark=white width="760" bgcolor=#c0c0c0 bordercolorlight=#dddddd 
border=0 class="s1" cellpadding="1">
        <tr align=center bgcolor=#B9C2CC>
          <td bgcolor="E0E4E8" width="20">&nbsp; </td>
          <td width="75">주문번호</td>
          <td bgcolor="E0E4E8" width="76">구매금액</td>
          <td width="94">결제방식</td>
          <td bgcolor="E0E4E8" width="84">거래상태</td>
          <td width="98">주문자</td>
          <td bgcolor="E0E4E8" width="102">전화</td>
          <td width="58">상호</td>
          <td bgcolor="E0E4E8" width="125">주문일시</td>
        </tr>
        <?
/* 페이징과 관련된 수식 구하기 */
$ListNo = "15";
$PageNo = "20";
if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $ListNo;


if ($action == 'detail_search') {
        $SDay_minus = $SDay - 1;
        if ($SDay_minus < 10) {
        $SDay_minus = "0".$SDay_minus;
        }
        if ($How_Bu == 'tall'){$How_Query = "";}else{$How_Query = "AND PayMethod='$PayMethod'";}
        $WHEREIS = "WHERE BuyDate >= '$SYear.$SMonth.$SDay_minus 23:59' AND BuyDate <= '$FYear.$FMonth.$FDay 23:59' AND OrderStatus='60' $How_Query";
        $sort = $Dsort;
}
else {
        $How_Bu = "tall";
        if (!$sort) {$sort = "UID";}
        if ($WHERE && $keyword) {$WHEREIS = "WHERE $WHERE LIKE '%$keyword%' AND OrderStatus='60'";}
        else {$WHEREIS = "WHERE OrderStatus='60'";}
        if ($ing_sort) {
                if ($ing_sort == 'ziro') {$ing_sort1 = "";}
                else {$ing_sort1 = $ing_sort;}
                $WHEREIS = "WHERE OrderStatus='60'";
        }
}

$sqlstr = "SELECT count(*) FROM wizBuyers $WHEREIS";
$TOTAL = $dbcon->get_one($sqlstr);

$LIST_QUERY = "SELECT * FROM wizBuyers $WHEREIS ORDER BY $sort DESC LIMIT $START_NO,$ListNo";
$TABLE_DATA = $dbcon->_query($LIST_QUERY);

$TOTAL_QUERY = $dbcon->_query( "SELECT SUM(TotalAmount) FROM wizBuyers WHERE OrderStatus='60'");
$TOTAL_SMONEY = $dbcon->_fetch_array($TOTAL_QUERY);
$TOTAL_SMONEY = $TOTAL_SMONEY[0];

$NO = $TOTAL-($ListNo*($cp-1));
while( $list = $dbcon->_fetch_array( $TABLE_DATA ) ) :
        $RAddress1 = explode(" ", $list["RAddress1"]);
		$BankInfo = explode("|", $list["BankInfo"]);
        $SUB_SMONEY = $SUB_SMONEY + $list["TotalAmount"];
        //------------------------------------------[결제방식]
        if ($list["PayMethod"] == 'card') {$PayWay = "신용카드";}
        else if ($list["PayMethod"] == 'point') {$PayWay = "포인트";}
        else if ($list["PayMethod"] == 'all') {$PayWay = "다중결제";}
        else {$PayWay = "온라인";}
        //--------------------------------------------------
        if (!$list["MemberID"]) {$list["MemberID"] = "비회원";}
?>
        <tr align="center"  bgcolor=white height=25>
          <td width="20" height="15" bgcolor=#f3f3f3><?=$NO?>
          </td>
          <td width="75" height="15" bgcolor=#f3f3f3><a href='#' onClick="javascript:window.open('./order1_1.php?uid=<?=$list[UID]?>', 'cartform','width=620,height=600,statusbar=no,scrollbars=yes,toolbar=no')"> <font color='black'>
            <?=$list["OrderID"]?>
            </font></a></td>
          <td width="76" height="15" bgcolor=#f3f3f3><font color=red><b>
            <?=number_format($list["TotalAmount"])?>
            </b>원</font></td>
          <td width="94" height="15" bgcolor=#f3f3f3>
            <?=$PayWay?>
            </td>
          <td width="84" height="15" bgcolor=#f3f3f3><font color=#ff0000>반품처리</font></td>
          <td width="98" height="15" bgcolor=#f3f3f3><A HREF='#' onclick="javascript:window.open('./member1_1.php?id=<?=$list[MemberID]?>', 'regisform','width=650,height=600,statusbar=no,scrollbars=yes,toolbar=no')"><font color='black'>
            <?=$list["SName"]?>
            (
            <?=$list["MemberID"]?>
            )</font></A></td>
          <td width="102" height="15" bgcolor=#f3f3f3>
            <?=$list["STel1"]?>
            </td>
          <td width="58" height="15">
            <?=$list["RCompany"]?>
            </td>
          <td width="125" height="15"><font color=brown>
            <?=date("Y.m.d H:i",$list["BuyDate"])?>
            </font></td>
        </tr>
        <?
$NO --;
endwhile;
?>
        <tr bgcolor=white height=40>
          <td colspan=9><b>현재페이지 합계금액 : <font color=blue>
            <?=number_format($SUB_SMONEY)?>
            원</font> | 반품 총액 : <font color=RED>
            <?=number_format($TOTAL_SMONEY)?>
            원</font></b></td>
        </tr>
      </table>
      <br />
      <table cellspacing=0 cellpadding=0 width="760" 
border=0 class="s1">
        <tr>
          <td align=center><?
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
$page_arg1 = $PHP_SELF."?menushow=$menushow&theme=order3&WHERE=$WHERE&keyword=".urlencode($keyword)."&SELECT_SORT=$SELECT_SORT&SYear=$SYear&SMonth=$SMonth&SDay=$SDay&FYear=$FYear&FMonth=$FMonth&FDay=$FDay&DataEnable=$DataEnable";
$page_arg2 = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL); 
//$page_arg3 = array("pre"=>"./img/pre.gif","next"=>"./img/next.gif");
echo $common->paging($page_arg1,$page_arg2,$page_arg3);
?></td>
        </tr>
      </table>
      <br />
      <b></b> </td>
  </tr>
</table>
