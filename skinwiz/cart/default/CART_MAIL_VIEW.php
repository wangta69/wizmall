<?php
$ORDERLIST = "
<table border='0' cellspacing='0' cellpadding='0'>
  <tr> 
    <td> <table align='center' style='font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%'>
        <tr bgcolor='#E08B18'3> 
          <td height='3' colspan='4'></td>
        </tr>
        <tr> 
          <td height='29' bgcolor='#FCF7F3'>상품명</td>
          <td height='29' bgcolor='#FCF7F3'>가격</td>
          <td height='29' bgcolor='#FCF7F3'>수량</td>
          <td height='29' BGCOLOR='#FCF7F3'>소계금액</td>
        </tr>";

//$C_dat=물품아이디|구매수량|옵션|색상

if (file_exists("./wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE"].".cgi")) {
        $Cart_Data = file("./wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE"].".cgi");
        for($i = 0; $i < sizeof($Cart_Data) && chop($Cart_Data[$i]); $i++) {
        $C_dat = explode("|", chop($Cart_Data[$i]));
		$Total_QTY += $C_dat[1];
        $VIEW_QUERY = "SELECT * FROM wizMall WHERE UID=".$C_dat[0];
        $LIST = $dbcon->_fetch_array($dbcon->_query($VIEW_QUERY));
    	$Picture = explode("|", $LIST["Picture"]);
		$VIEW_LINK = "'./wizmart.php?query=view&code=".$LIST["Category"]."&no=".$LIST["UID"]."'";
		if (!strcmp($LIST["None"],"checked")) {
		$VIEW_LINK = "'#' onclick=\"javascript:alert('제품이 품절되었습니다. 관리자에게 문의하세요.')\"";
		}
        $SUM_MONEY = number_format($LIST["Price"] * $C_dat[1]);
if(!$C_dat[2]){            //옵션이 없으면
        $TOTAL_MONEY = $TOTAL_MONEY+($LIST["Price"] * $C_dat[1]);
        }
		
//추가 - 제품이 구매된 모든 카테고리를 하나로 만든다. 캬테고리별 가격을 위해
//2. 카테고리를 하나로 만든다.
if(chop($TOTAL_CAT))$TOTAL_CAT .= "|".$LIST["Category"];
else $TOTAL_CAT = $LIST["Category"];		
$ORDERLIST .= "
          <tr> 
            <td> <table>
                <tr> 
                  <td><img src='".$cfg["admin"]["MART_BASEDIR"]."/wizstock/".$Picture[0]."' WIDTH='50' HEIGHT='50'></td><td><U>".stripslashes($LIST["Name"])."</U><br /> ";

                if         ($C_dat[2]) {       //옵션이 있어면
                        if (eregi("=", $C_dat[2])) {  // 옵션에 따른 가격이 있으면
                                $SIZE_OPTION_SPL = explode("=", $C_dat[2]);
                               $ORDERLIST .= "<FONT COLOR=#CE6500>".$SIZE_OPTION_SPL[0]." ".number_format($SIZE_OPTION_SPL[1]*$C_dat[1])." 추가 ";
                                $CHECK1 = chop($SIZE_OPTION_SPL[1]);
                                $SUM_MONEY = number_format((chop($SIZE_OPTION_SPL[1])+$LIST["Price"])*$C_dat[1]);
                                $TOTAL_MONEY = $TOTAL_MONEY + (chop($SIZE_OPTION_SPL[1])+$LIST["Price"])*$C_dat[1];
                        }
                        else {  // 옵션에 따른 가격이 없으면
                        $TOTAL_MONEY = $TOTAL_MONEY+$LIST["Price"]*$C_dat[1];
                        $ORDERLIST .= "<font COLOR=#CE6500>".$C_dat[2]."</font>";
                        }
                }

                if         ($C_dat[3]) {
                        echo " <font COLOR=#CE6500>".$C_dat[3]."</font>";
                }
$ORDERLIST .= "
                  </td>
                </tr>
              </table></td>
            <td> 
              ".number_format($LIST["Price"])."
              원</td>
            <td> ".$C_dat[1]."</td>
            <td>".$SUM_MONEY." 원<br /> 
            </td>
          </tr>
          <tr> 
            <td colspan=4> </td>
          </tr>
          <tr> 
            <td colspan=4 background='./skinwiz/cart/".$cfg["skin"]["CartSkin"]."/image/cart_line.gif'> 
            </td>
          </tr>
        </form>";

        }   // for
}       // if
$ORDERLIST .= "
      </table>
      <br />"; 

if ($TOTAL_MONEY) { // 장바구니가 담겼으면
$TOTAL_MONEY_TMP=$TOTAL_MONEY;

//<!--- [ 출력메시지를 표시합니다. ] ------------------------------------------------------------------------------------>//
if($TOTAL_MONEY < $cfg["pay"]["TACKBAE_CUTLINE"] && $TACKBAE_ALL == "ENABLE")
$MESSAGE_TACKBAE = "<table border='0' cellspacing='0' cellpadding='8'><tr><td width='2%' height='3' bgcolor='#E08B18'></td><td width='98%' bgcolor='#E08B18'></td></tr><tr><td bgcolor='#FCF7F3'>&nbsp;</td><td bgcolor='#FCF7F3'>
주문총액이 ".number_format($cfg["pay"]["TACKBAE_CUTLINE"])."원 이하일 경우에는 ".number_format($cfg["pay"]["TACKBAE_MONEY"])."원의 배송비가 합산되어집니다.<br />
</td></tr></table><br />";

if($TACKBAE_ALL == "PER")
$MESSAGE_TACKBAE = "<table border='0' cellspacing='0' cellpadding='8'><tr><td width='2%' height='3' bgcolor='#E08B18'></td><td width='98%' bgcolor='#E08B18'></td></tr><tr><td bgcolor='#FCF7F3'>&nbsp;</td><td bgcolor='#FCF7F3'>
박스당 ".number_format($cfg["pay"]["TACKBAE_MONEY"])."원의 배송비가 합산되어집니다.<br />
</td></tr></table><br />";

if($TACKBAE_ALL == "ALL")
$MESSAGE_TACKBAE = "<table border='0' cellspacing='0' cellpadding='8'><tr><td width='2%' height='3' bgcolor='#E08B18'></td><td width='98%' bgcolor='#E08B18'></td></tr><tr><td bgcolor='#FCF7F3'>&nbsp;</td><td bgcolor='#FCF7F3'>
".number_format($cfg["pay"]["TACKBAE_MONEY"])."원의 배송비가 합산되어집니다.<br />
</td></tr></table><br />";

if($cfg["pay"]["VAT_ENABLE"] == "checked")
$MESSAGE_VAT = "<table border='0' cellspacing='0' cellpadding='8'><tr><td width='2%' height='3' bgcolor='#E08B18'></td><td width='98%' bgcolor='#E08B18'></td></tr><tr><td bgcolor='#FCF7F3'>&nbsp;</td><td bgcolor='#FCF7F3'>
VAT.(부가가치세) ".number_format($TOTAL_MONEY*$cfg["pay"]["VAT_MONEY"]/100)."가 합산되어집니다.<br />
</td></tr></table><br />";

$MESSAGE_RATE1 = "<table border='0' cellspacing='0' cellpadding='8'><tr><td width='2%' height='3' bgcolor='#E08B18'></td><td width='98%' bgcolor='#E08B18'></td></tr><tr><td bgcolor='#FCF7F3'>&nbsp;</td><td bgcolor='#FCF7F3'>
현금결재(무통장입금)가  아닐경우 ".number_format($TOTAL_MONEY_TMP)."원의".$cfg["pay"]["CARDCHECK_RATE_VALUE1"]."%가 상품가격에 포함됩니다. <br />
</td></tr></table><br />";

$MESSAGE_VALUE1 = "<table border='0' cellspacing='0' cellpadding='8'><tr><td width='2%' height='3' bgcolor='#E08B18'></td><td width='98%' bgcolor='#E08B18'></td></tr><tr><td bgcolor='#FCF7F3'>&nbsp;</td><td bgcolor='#FCF7F3'>
현금결재(무통장입금)가 아닐경우 ".number_format($cfg["pay"]["CARDCHECK_RATE_VALUE2"])."원의 금액이 상품가격에 포함됩니다.<br />
</td></tr></table><br />";

$MESSAGE_DETAIL_RATE = "<table border='0' cellspacing='0' cellpadding='8'><tr><td width='2%' height='3' bgcolor='#E08B18'></td><td width='98%' bgcolor='#E08B18'></td></tr><tr><td bgcolor='#FCF7F3'>&nbsp;</td><td bgcolor='#FCF7F3'>
HP와 삼성제품만 구매시 카드결재일경우 경우 ".number_format($TOTAL_MONEY_TMP)."원의".$cfg["pay"]["DIFF_CARD_RATE"]."%가 상품가격에 포함됩니다.<br />
</td></tr></table><br />";

$MESSAGE_DETAIL_VALUE = "<table border='0' cellspacing='0' cellpadding='8'><tr><td width='2%' height='3' bgcolor='#E08B18'></td><td width='98%' bgcolor='#E08B18'></td></tr><tr><td bgcolor='#FCF7F3'>&nbsp;</td><td bgcolor='#FCF7F3'>
HP와 삼성제품만 구매시 카드결재일경우 ".number_format($cfg["pay"]["DIFF_CARD_VALUE"])."원의 금액이 상품가격에 포함됩니다.<br />
</td></tr></table><br />";

//<!--- [ 합산을 계산합니다 ] ------------------------------------------------------------------------------------>//

/* 배송비 이전에 만약 vat가 존재할 경우 이 부분을 먼저 계산한다. */
if($cfg["pay"]["VAT_ENABLE"] == "checked"){
$TOTAL_MONEY += $TOTAL_MONEY*$cfg["pay"]["VAT_MONEY"]/100;
echo $MESSAGE_VAT;
}


// 택배 MONEY 합산
/* 택배옵션 : ENABLE : 가격당 택배비, DISABLE : 무시, ALL : 구매량, 금액관계없이 택배비 적용, PER : 갯수당 적용 */
//if($TOTAL_MONEY >= $cfg["pay"]["TACKBAE_CUTLINE"]) $cfg["pay"]["TACKBAE_MONEY"] = 0;

if($TOTAL_MONEY < $cfg["pay"]["TACKBAE_CUTLINE"] && $TACKBAE_ALL == "ENABLE"){
$TOTAL_MONEY = $TOTAL_MONEY + $cfg["pay"]["TACKBAE_MONEY"];
echo $MESSAGE_TACKBAE;
}

if($TACKBAE_ALL == "ALL" ){
$TOTAL_MONEY = $TOTAL_MONEY + $cfg["pay"]["TACKBAE_MONEY"];
echo $MESSAGE_TACKBAE1;
}

//카드결제시 결제 비용(% or value)을 계산
if(!strcmp($cfg["pay"]["CARDCHECK_ENABLE"],"NOTSAME") && !strcmp($cfg["pay"]["CARDCHECK_RATE"],"CARDCHECK_PER") ){
$TOTAL_MONEY_TMP=$TOTAL_MONEY_TMP*(1 +  $cfg["pay"]["CARDCHECK_RATE_VALUE1"]/100) + $cfg["pay"]["TACKBAE_MONEY"];
echo $MESSAGE_RATE1;
       if(!(strcmp($query,"step3") && strcmp($query,"step4")) && strcmp($check,"online")){
		   $TOTAL_MONEY = $TOTAL_MONEY_TMP;
	   }
}

if(!strcmp($cfg["pay"]["CARDCHECK_ENABLE"],"NOTSAME") && !strcmp($cfg["pay"]["CARDCHECK_RATE"],"CARDCHECK_VALUE") ){
$TOTAL_MONEY_TMP=$TOTAL_MONEY_TMP + $cfg["pay"]["CARDCHECK_RATE_VALUE2"] + $cfg["pay"]["TACKBAE_MONEY"];
echo $MESSAGE_VALUE1;
       if(!(strcmp($query,"step3") && strcmp($query,"step4")) && strcmp($check,"online")){
		   $TOTAL_MONEY = $TOTAL_MONEY_TMP;
	   }
}

//디렉토리별로 가격을 정할때 사용한다.
$TOTAL_MONEY_SUB_DIFF="";
if(!strcmp($cfg["pay"]["CARDCHECK_ENABLE"],"DIRNOTSAME")){

//카드결제시 결제 비용을 디렉토리별로 계산
//추가 - 제품이 구매된 모든 카테고리를 하나로 만든다.
//2. 카테고리를 하나로 만든다.

$TOTAL_CAT_SPLIT=explode("|",$TOTAL_CAT);
$TOTAL_MONEY_SUB_DIFF = 0;
for($i=0; $i < sizeof($TOTAL_CAT_SPLIT) && chop($TOTAL_CAT_SPLIT); $i++){
$BigCat=substr($TOTAL_CAT_SPLIT[$i], 4,2);
$sqlstr = "select cat_no, cat_name, cat_price from wizCategory where cat_no < 100 and cat_price = 'checked' order by cat_no asc";
$dbcon->_query($sqlstr);
   while($list = $dbcon->_fetch_array()):
   		if($list["cat_no"]){
           $BigCatlist = substr($list["cat_no"], 4, 2);
		   if(!strcmp($BigCat,$BigCatlist)) $TOTAL_MONEY_SUB_DIFF ++;
		}
      endwhile;
}

/** 카테고리 비교 끝 ***********************************************************/


if(!$RESULT_SUB_DIFF){
//카드결제시 결제 비용(% or value)을 계산
/******************************************************************************************************************/
if(!strcmp($cfg["pay"]["DIRNOTSAME_METHOD"],"CARDCHECK_RATE") ){
$TOTAL_MONEY_TMP=$TOTAL_MONEY_TMP*(1 +  $cfg["pay"]["DIFF_CARD_RATE"]/100) + $cfg["pay"]["TACKBAE_MONEY"];
echo $MESSAGE_DETAIL_RATE;
       if(!(strcmp($query,"step3") && strcmp($query,"step4")) && strcmp($check,"online")){
		   $TOTAL_MONEY = $TOTAL_MONEY_TMP;
	   }
}

if(!strcmp($cfg["pay"]["DIRNOTSAME_METHOD"],"CARDCHECK_VALUE") ){
$TOTAL_MONEY_TMP=$TOTAL_MONEY_TMP + $cfg["pay"]["DIFF_CARD_VALUE"] + $cfg["pay"]["TACKBAE_MONEY"];
echo $MESSAGE_DETAIL_VALUE;
       if(!(strcmp($query,"step3") && strcmp($query,"step4")) && strcmp($check,"online")){
		   $TOTAL_MONEY = $TOTAL_MONEY_TMP;
	   }
}
/******************************************************************************************************************/
}
}
$ORDERLIST .="
      <table align='center'>
        <tr> 
          <td background='./skinwiz/cart/".$cfg["skin"]["CartSkin"]."/image/cart_line.gif'> 
          </td>
        </tr>
        <tr> 
          <td class='castb'> <table border='0' cellpadding='0' cellspacing='5' bgcolor='#F3F3F3' style='font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%'>
              <tr> 
                <td width='60%'>&nbsp;</td>
                <td width='40%' align='center'>주문상품 총액:".number_format($TOTAL_MONEY)."
                  원</td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td background='./skinwiz/cart/".$cfg["skin"]["CartSkin"]."/image/cart_line.gif'> 
          </td>
        </tr>
      </table>";

} else { // 장바구니가 비었으면
$ORDERLIST .="
      <table align='center' bgcolor='#F3F3F3' style='font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%'>
        <tr> 
          <td1 class='castb'>현재 장바구니에 담긴 
            상품이 없습니다.</td>
        </tr>
      </table>";
}
$ORDERLIST .="
      <br /> 
      <!-- 장바구니 보기 끝 -->
    </td>
  </tr>
</table>";