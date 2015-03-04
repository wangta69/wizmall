<?
include "../../../lib/cfg.common.php";
include "../../../config/db_info.php";
include "../../../config/cfg.core.php";
include "../../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);
?><title>견적서 프린트</title>
<body>
<table">
    <tr> 
      <td> 견 
        적 서 (見 積 書)&nbsp; 
        &nbsp; </td>
    </tr>
    <tr> 
      <td><table>
          <tr> 
            <td> 
<?
$SQL_STR = "SELECT ID, Name, Email, Tel1, Tel2, Address1, Address2 FROM wizMembers WHERE ID = '$_COOKIE[MEMBER_ID]'";
$dbcon->_query($SQL_STR);
$CUSTOMER = $dbcon->_fetch_array();
?>
              <table>
                <tr> 
                  <td>수신( TO ) : 
                    <?=$CUSTOMER[Name]?>
                    <br />
                    TEL: 
                    <?if($CUSTOMER[Tel1]) ECHO"$CUSTOMER[Tel1]";
															else if($CUSTOMER[TEel2]) ECHO"$CUSTOMER[Tel2]";
															?>
                    <br /> 다음과 같이 추가 견적서를 
                    제출합니다. </td>
                </tr>
                <tr> 
                  <td>제품 납기 : <br />
                    Delivery Date 3주이내(21일)</td>
                </tr>
                <tr> 
                  <td>결재 조건 : 현금결재<br />
                    Payment Conditions </td>
                </tr>
              </table></td>
            <td> <table>
                <tr> 
                  <td>DATE : 
                    <?=date("Y-m-j")?>
                    ; <br />
                    NO : 
                    <?=$_COOKIE[CART_CODE_ESTIM]?>
                    <br /> 담당자 : 
                    <?=$cfg["admin"]["ADMIN_NAME"]?>
                    <br />
                    E-MAIL : 
                    <?=$cfg["admin"]["$ADMIN_EMAIL"]?>
                    <br />
                    TEL: 
                    <?=$cfg["admin"]["$ADMIN_TEL"]?>
                    <br />
                    FAX: 
                    <?=$cfg["admin"]["$CUSTOMER_FAX"]?>
                    <br /> 
                    <?=$cfg["admin"]["$COMPANY_ADD"]?>
                    <br />  
                    <?=$cfg["admin"]["COMPANY_NAME"]?>
                     <br /> </td>
                </tr>
              </table></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td> <table>
          <tr> 
            <td>&nbsp;&nbsp;▶ 견적명세 
            </td>
          </tr>
          <tr> 
            <td> <table>
                <tr class="white"> 
                  <td class="white">항목<br />
                    NO<br /> </td>
                  <td class="white">내 역 <br />
                    Product Description <br /> </td>
                  <td  class="white">단가<br />
                    Unit Price<br /> </td>
                  <td  class="white"> 수량 <br />
                    Q'TY <br /> </td>
                  <td  class="white"> 금액 <br />
                    Amount Price </td>
                </tr>
                <?
//$C_dat=물품아이디|구매수량|옵션|색상
unset($total_qty);
$NO=1;
if (file_exists("../../../wizmember_tmp/mall_buyers/$_COOKIE[CART_CODE_ESTIM].cgi")) {
        $Cart_Data = file("../../../wizmember_tmp/mall_buyers/$_COOKIE[CART_CODE_ESTIM].cgi");
        for($i = 0; $i < sizeof($Cart_Data) && chop($Cart_Data[$i]); $i++) {
        $C_dat = explode("|", chop($Cart_Data[$i]));
        $VIEW_QUERY = "SELECT * FROM wizMall WHERE UID='$C_dat[0]'";
		$dbcon->_query($VIEW_QUERY);
        $List = $_dbcon->_fetch_array();
		if (!strcmp($List[None],"checked")) {
		$VIEW_LINK = "'#' onclick=\"javascript:alert('제품이 품절되었습니다. 관리자에게 문의하세요.')\"";
		}
        $SUM_MONEY = number_format($List[Price] * $C_dat[1]);
if(!$C_dat[2]){            //옵션이 없으면
        $TOTAL_MONEY = $TOTAL_MONEY+($List[Price] * $C_dat[1]);
        }
?>
                <tr> 
                  <td> 
                    <?=$NO?>
                  </td>
                  <td><u> 
                    <?=$List[Name]?>
                    </u><br /> 
                    <?
                if ($C_dat[2]) {       //옵션이 있어면
                        if (eregi("=", $C_dat[2])) {
                                $SIZE_OPTION_SPL = explode("=", $C_dat[2]);
                                ECHO "<FONT COLOR=#CE6500>$SIZE_OPTION_SPL[0] ";
                                $CHECK = chop($SIZE_OPTION_SPL[1]);
                                $SUM_MONEY = number_format(chop($SIZE_OPTION_SPL[1])*$C_dat[1]);
                                $TOTAL_MONEY = $TOTAL_MONEY + (chop($SIZE_OPTION_SPL[1])*$C_dat[1]);
                        }
                        else {
                        $TOTAL_MONEY = $TOTAL_MONEY+($List[Price] * $C_dat[1]);
                        ECHO "<FONT COLOR=#CE6500>$C_dat[2] ";

                        }
                }


                if ($C_dat[3]) {
                        ECHO " <FONT COLOR=#CE6500>$C_dat[3]";
                }
?>
                  </td>
                  <td> 
                    <?=number_format($List[Price])?>
                    원</td>
                  <td> 
                    <?=$C_dat[1]?>
                  </td>
                  <td> 
                    <? $SubTotal=($List[Price] * $C_dat[1]); ECHO number_format($SubTotal); ?>
                  </td>
                </tr>
                <?
$NO++;
$total_qty =+ $C_dat[1]; 
        }   // for
}       // if
?>
                <tr> 
                  <td colspan="5">&nbsp; </td>
                </tr>
                <tr> 
                  <td colspan="5"> <table>
                      <tr> 
                        <td>본 
                          견적서의 단가는 동시 
                          일괄 구매시만 적용됩니다.</td>
                        <td>금액 
                          : <?ECHO number_format($TOTAL_MONEY);?> 원</td>
                      </tr><!--
                      <tr> 
                        <td height="31">Special 
                          Nego. Amount for 
                          <?=$CUSTOMER[Name]?>
                        </td>
                        <? 
/* Nego. 가격 설정 */
if($total_qty < 10 ) $negoper = 2;
elseif($total_qty < 30) $negoper = 3;
elseif($total_qty < 50) $negoper = 3.5;
elseif($total_qty < 100) $negoper = 4;
else $negoper = 4.5;
$NegoMoney = $TOTAL_MONEY*(1-$negoper/100);
?>
                        <td height="31">금액 
                          : <?ECHO number_format($NegoMoney);?> 
                          원</td>
                        <input type="hidden" name="TOTAL_MONEY" value="<?=$NegoMoney?>">
                      </tr> -->
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td><table>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
  </form>
</table>
<script language ="javascript">
window.print();
</script>