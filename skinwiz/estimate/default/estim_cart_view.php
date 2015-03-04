<?
/* 
제작자 : 폰돌
*** Updating List ***
*/
?>
<!-- cart view start -->
<!-- 장바구니 보기 -->

<SCRIPT LANGUAGE=javascript>
function num_plus(num){
        gnum = parseInt(num.BUYNUM.value);
        num.BUYNUM.value = gnum + 1;
        return;
}
function num_minus(num){

        gnum = parseInt(num.BUYNUM.value);
        if( gnum > 1 ){
                num.BUYNUM.value = gnum - 1;
        }
        return;
}
function really(){
if (confirm('\n\n정말로 장바구니를 모두 비우시겠습니까?\n\n')) return true;
return false;
}
function is_number(){
         if ((event.keyCode<48)||(event.keyCode>57)){
                  alert("\n\n수량은 숫자만 입력하셔야 합니다.\n\n");
                  event.returnValue=false;
         }
}
</script>
<table>
                                <tr> 
                                  
    <td> 
      <table cellspacing=2>
        <tr> 
          <td>주문상품</td>
          <td>가격</td>
          <td>수량</td>
          <td>소계</td>
          <td>수정</td>
          <td>삭제</td>
        </tr>
<?
//$C_dat=물품아이디|구매수량|옵션|색상
$filepath = "./config/wizmember_tmp/mall_buyers/$_COOKIE[CART_CODE_ESTIM].php";
if (file_exists($filepath)) {
        $Cart_Data = file($filepath);
        for($i = 0; $i < sizeof($Cart_Data) && chop($Cart_Data[$i]); $i++) {
        $C_dat = explode("|", chop($Cart_Data[$i]));
        $VIEW_QUERY = "SELECT * FROM wizMall WHERE UID='$C_dat[0]'";
        $LIST = $dbcon->_fetch_array($dbcon->_query($VIEW_QUERY));
    	$Picture = explode("|", $LIST[Picture]);
		$VIEW_LINK = "'./wizmart.php?query=view&code=$LIST[Category]&no=$LIST[UID]'";
		if (!strcmp($LIST[None],"checked")) {
		$VIEW_LINK = "'#' onclick=\"javascript:alert('제품이 품절되었습니다. 관리자에게 문의하세요.')\"";
		}
        $SUM_MONEY = number_format($LIST[Price] * $C_dat[1]);
if(!$C_dat[2]){            //옵션이 없으면
        $TOTAL_MONEY = $TOTAL_MONEY+($LIST[Price] * $C_dat[1]);
        }
		
//추가 - 제품이 구매된 모든 카테고리를 하나로 만든다. 캬테고리별 가격을 위해
//2. 카테고리를 하나로 만든다.
if(chop($TOTAL_CAT))$TOTAL_CAT .= "|"."$LIST[Category]";
else $TOTAL_CAT = $LIST[Category];		
?>
        <form name='view_form<?ECHO$i;?>'action='./wizcalcu.php'>
          <tr> 
            <td> 
              <table>
                <input type="hidden" name='query' VALUE='modify'>
                <input type="hidden" name='value' VALUE='<?ECHO"$LIST[UID]-$C_dat[2]-$C_dat[3]";?>'>
                <tr> 
                  <td><a href='./wizmart.php?code=<?=$LIST[Category]?>&query=view&no=<?=$LIST[UID]?>'><img src='./wizstock/<?=$Picture[0]?>' WIDTH='50' HEIGHT='50'></a></td>
                  <td><a href='./wizmart.php?code=<?=$LIST[Category]?>&query=view&no=<?=$LIST[UID]?>'><U> 
                    <?=$LIST[Name]?>
                    </U></a><br /> 
                    <?
                if         ($C_dat[2]) {       //옵션이 있어면
                        if (eregi("=", $C_dat[2])) {  // 옵션에 따른 가격이 있으면
                                $SIZE_OPTION_SPL = explode("=", $C_dat[2]);
                                ECHO "<FONT COLOR=#CE6500>$SIZE_OPTION_SPL[0] ".number_format($SIZE_OPTION_SPL[1]*$C_dat[1])." 추가 ";
                                $CHECK1 = chop($SIZE_OPTION_SPL[1]);
                                $SUM_MONEY = number_format((chop($SIZE_OPTION_SPL[1])+$LIST[Price])*$C_dat[1]);
                                $TOTAL_MONEY = $TOTAL_MONEY + (chop($SIZE_OPTION_SPL[1])+$LIST[Price])*$C_dat[1];
                        }

                        else {  // 옵션에 따른 가격이 없으면
                        $TOTAL_MONEY = $TOTAL_MONEY+$LIST[Price]*$C_dat[1];
                        ECHO "<FONT COLOR=#CE6500>${C_dat[2]} ";
                        }
                }
                if         ($C_dat[3]) {
                        ECHO " <FONT COLOR=#CE6500>$C_dat[3] ";
                }
?>
                  </td>
                </tr>
              </table></td>
            <td> 
              <?=number_format($LIST[Price])?>
              원</td>
            <td> 
              <table>
                <tr> 
                  <td rowspan=2> 
                    <input type="text" size=4 name='BUYNUM' maxlength=5 value='<?ECHO"$C_dat[1]";?>' onKeyPress="is_number()">
                  </td>
                  <td><a href='javascript:num_plus(document.view_form<?ECHO$i;?>);'><img src='./skinwiz/estimate/<?=$EstimSkin?>/images/num_plus.gif'></a></td>
                  <td rowspan=2>&nbsp;&nbsp;EA</td>
                </tr>
                <tr> 
                  <td><a href='javascript:num_minus(document.view_form<?ECHO$i;?>);'><img src='./skinwiz/estimate/<?=$EstimSkin?>/images/num_minus.gif'></a></td>
                </tr>
              </table>
            </td>
            <td> <?ECHO"$SUM_MONEY";?> 
              원</td>
            <td> 
              <input type=IMAGE src='./skinwiz/estimate/<?=$EstimSkin?>/images/cart_modify.gif' name="IMAGE">
            </td>
            <td><a href='./wizcalcu.php?query=delete&value=<?ECHO"$C_dat[0]-$C_dat[2]-$C_dat[3]";?>'><img src='./skinwiz/estimate/<?=$EstimSkin?>/images/cart_delete.gif'></a></td>
          </tr>
          <tr> 
            <td colspan=6 background='./mall_skin/login/<?ECHO"$LOGIN_SKIN";?>/image/cart_line.gif'> 
            </td>
          </tr>
        </form>
        <?
        }   // for
}       // if
?>
      </table>
    
<?
if ($TOTAL_MONEY) { // 장바구니가 담겼으면

$TOTAL_MONEY_TMP=$TOTAL_MONEY;

//<!--- [ 출력메시지를 표시합니다. ] ------------------------------------------------------------------------------------>//
if($TOTAL_MONEY < $cfg["pay"]["TACKBAE_CUTLINE"])

$MESSAGE_TACKBAE = "<table><tr><td></td><td>주문총액이 ".number_format($cfg["pay"]["TACKBAE_CUTLINE"])."원 이하일 경우에는 ".number_format($cfg["pay"]["TACKBAE_MONEY"])."원의 
배송비가 합산되어집니다.</td></tr> </table>";

$MESSAGE_RATE1 = "<table> <tr><td></td><td>현금결재(무통장입금)가  아닐경우 ".number_format($TOTAL_MONEY_TMP)."원의".$cfg["pay"]["CARDCHECK_RATE_VALUE1"]."%가 
상품가격에 포함됩니다. </td></tr> </table>";

$MESSAGE_VALUE1 = "<table> <tr><td></td><td>현금결재(무통장입금)가 아닐경우 ".number_format($cfg["pay"]["CARDCHECK_RATE_VALUE2"])."원의 금액이 상품가격에 포함됩니다. </td></tr> </table>";


//<!--- [ 합산을 계산합니다 ] ------------------------------------------------------------------------------------>//


if($TOTAL_MONEY >= $cfg["pay"]["TACKBAE_CUTLINE"]) $cfg["pay"]["TACKBAE_MONEY"] = 0;

if($TOTAL_MONEY < $cfg["pay"]["TACKBAE_CUTLINE"]){
$TOTAL_MONEY = $TOTAL_MONEY + $cfg["pay"]["TACKBAE_MONEY"];
ECHO $MESSAGE_TACKBAE;
}

if(!strcmp($cfg["pay"]["CARDCHECK_ENABLE"],"NOTSAME") && !strcmp($cfg["pay"]["CARDCHECK_RATE"],"CARDCHECK_PER") ){
$TOTAL_MONEY_TMP=$TOTAL_MONEY_TMP*(1 +  $cfg["pay"]["CARDCHECK_RATE_VALUE1"]/100) + $cfg["pay"]["TACKBAE_MONEY"];
ECHO $MESSAGE_RATE1;
       if(!(strcmp($query,"step3") && strcmp($query,"step4")) && strcmp($check,"online")){
		   $TOTAL_MONEY = $TOTAL_MONEY_TMP;
	   }
}

if(!strcmp($cfg["pay"]["CARDCHECK_ENABLE"],"NOTSAME") && !strcmp($cfg["pay"]["CARDCHECK_RATE"],"CARDCHECK_VALUE") ){
$TOTAL_MONEY_TMP=$TOTAL_MONEY_TMP + $cfg["pay"]["CARDCHECK_RATE_VALUE2"] + $cfg["pay"]["TACKBAE_MONEY"];
ECHO $MESSAGE_VALUE1;
       if(!(strcmp($query,"step3") && strcmp($query,"step4")) && strcmp($check,"online")){
		   $TOTAL_MONEY = $TOTAL_MONEY_TMP;
	   }

}

?>


      <table CELLSPACING=2>
        <tr> <td background='./mall_skin/login/<?ECHO"$LOGIN_SKIN";?>/image/cart_line.gif'> 
</td></tr> <tr> 
    <td BGCOLOR=#A9D5CF> 견적상품 가격합계 :  
      <?ECHO number_format($TOTAL_MONEY);?>
      원 </td>
  </tr> <tr> <td background='./mall_skin/login/<?ECHO"$LOGIN_SKIN";?>/image/cart_line.gif'> 
</td></tr> </table>

<?
} else { // 견적서가 비었으면
?>

      <table CELLSPACING=2>
        <tr> 
    <td BGCOLOR=#A9D5CF>현재 견적서 물품 리스트 내용이 없습니다. 
    </td>
  </tr> </table><?
}
?></td>
                                </tr>
                                <tr> 
                                  <td class="title"><img src="../images/blank.gif"> 
                                    <table>
                                      <tr> 
                                        
          <td width="50%"><a href="./wizcalcu.php?query=trash"><img src="./skinwiz/estimate/<?=$EstimSkin?>/images/bu_g_re.gif" width="94"></a></td>
                                        <td width="50%"><a href='./wizcalcu.php?query=estim_view'><img src="./skinwiz/estimate/<?=$EstimSkin?>/images/bu_g_acc.gif" width="94"></a></td>
                                      </tr>
                                    </table></td>
                                </tr>
                                <tr> 
                                  <td>&nbsp;</td>
                                </tr>
                              </table>