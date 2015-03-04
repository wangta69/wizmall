<script>

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
function is_number(){
 	if ((event.keyCode<48)||(event.keyCode>57)){
  		alert("\n\n수량은 숫자만 입력하셔야 합니다.\n\n");
  		event.returnValue=false;
 	}
}
function wishconfirm(){
    if (confirm('\n\n정말로 본 제품을 위시리스트에 담으시겠습니까?\n\n')) return true;
    return false;
}
function baropay(f,val){
    f.sub_query.value = val;
    f.submit();
}

</script> 
<table>
  <tr> 
    <td colspan="3"></td>
  </tr>
  <tr> 
    <td colspan="3"> <table>
        <tr> 
          <td></td>
          <td background=images/bg_sub01.gif  colspan="3" width=849></td>
        </tr>
        <tr> 
          <td></td>
          <td> <table width="849">
              <tr> 
<?php
if (file_exists("./wizmember_tmp/goods_compare/".$_COOKIE["MEMBER_COMPARE"].".cgi")):
	$WISH_ARRAY = file("./wizmember_tmp/goods_compare/".$_COOKIE["MEMBER_COMPARE"].".cgi");
	$NO=0;
	while (list($key,$value) = each($WISH_ARRAY)) :
			$value_arr = explode("|", $value);
			$sqlstr = "SELECT * FROM wizMall WHERE UID=".$value_arr[0];
			$dbcon->_query($sqlstr);
			$list = $dbcon->_fetch_array();
			$Picture = explode("|", $list["Picture"]);
			if(!strcmp($LIST["None"],"checked")) $orderenable ="주문불가";
			else $orderenable ="주문가능";
?>
                <td><table >
                    <tr> 
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr> 
                      <td> <table>
                          <tr> 
                            <td>&nbsp;</td>
                            <td><a href='#' onclick="javascript:window.open('./skinwiz/viewer/<?php echo $cfg["skin"]["ViewerSkin"]?>/picview.php?no=<?php echo $list["UID"]?>', 'BICIMAGEWINDOW','width=750,height=592,statusbar=no,scrollbars=no,toolbar=no,resizable=no')"><img 
                        src="./config/uploadfolder/productimg/<?php echo $big_code?>/<?php echo $Picture[0]?>" width=20000></a></td>
                          </tr>
                          <tr> 
                            <td>&nbsp;</td>
                            <td><a href='#' onclick="javascript:window.open('./skinwiz/viewer/<?php echo $cfg["skin"]["ViewerSkin"]?>/picview.php?no=<?php echo $list["UID"]?>', 'BICIMAGEWINDOW','width=750,height=592,statusbar=no,scrollbars=no,toolbar=no,resizable=no')"><img src=/images/btn_zoom.gif></a></td>
                          </tr>
                          <tr> 
                            <td>&nbsp;</td>
                            <td><table>
                                <tr> 
                                  <td> </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                      <td> <table>
                          <form name='view_form_<?php echo $value_arr[0]?>' action='./wizbag.php' metbod="post">
                            <input type="hidden" name='query' VALUE='cart_save'>
                            <input type="hidden" name='no' VALUE='<?php echo $value_arr[0]?>'>
                            <input type="hidden" name='sub_query' VALUE= ''>
                            <tr> 
                              <td>&nbsp;</td>
                              <td> 
                                <?php echo $list["Name"]?>
                                </td>
                              <td width="2">&nbsp;</td>
                            </tr>
                            <tr> 
                              <td colspan="3" ></td>
                            </tr>
                            <tr> 
                              <td>&nbsp;</td>
                              <td>- 가격 : 
                                <?php echo number_format($list["Price"])?>
                                원   <input type='hidden' name='GoodsPrice' value='<?php echo $list["Price"]?>'></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr> 
                              <td colspan="3" background=images/dot_04.gif></td>
                            </tr>
                            <tr> 
                              <td>&nbsp;</td>
                              <td>- 마일리지 : 
                                <?php echo number_format($list["Point"])?>
                                pts<br /> </td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr> 
                              <td colspan="3" background=images/dot_04.gif></td>
                            </tr>
                            <tr> 
                              <td>&nbsp;</td>
                              <td>- 원산지 / 제조사 : 
                                <?php echo $list["Brand"]?>
                              </td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr> 
                              <td colspan="3" background=images/dot_04.gif></td>
                            </tr>
                            <tr> 
                              <td>&nbsp;</td>
                              <td>- 상품코드 : 
                                <?php echo $list["Model"]?>
                                <br /> </td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr> 
                              <td colspan="3" background=images/dot_04.gif></td>
                            </tr>
                            <tr> 
                              <td>&nbsp;</td>
                              <td>- 색상 및 종류 : </td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr> 
                              <td colspan="3" background=images/dot_04.gif></td>
                            </tr>
                            <tr> 
                              <td>&nbsp;</td>
                              <td> <table>
                                  <tr> 
                                    <td> <table>
                                        <tr> 
                                          <td rowspan=2>- 구매수량 : </td>
                                          <td rowspan=2> <input type="text" name="BUYNUM" maxlength=5 value="1" onKeyPress="is_number()"> 
                                          </td>
                                          <td><a href="javascript:num_plus(document.view_form_<?php echo $value_arr[0]?>);"><img src="./skinwiz/viewer/<?php echo $cfg["skin"]["ViewerSkin"]?>/images/num_plus.gif"></a></td>
                                          <td rowspan=2>&nbsp;&nbsp;EA</td>
                                        </tr>
                                        <tr> 
                                          <td><a href="javascript:num_minus(document.view_form_<?php echo $value_arr[0]?>);"><img src="./skinwiz/viewer/<?php echo $cfg["skin"]["ViewerSkin"]?>/images/num_minus.gif"></a></td>
                                        </tr>
                                      </table></td>
                                    <td>&nbsp;</td>
                                  </tr>
                                </table></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr> 
                              <td colspan="3"></td>
                            </tr>
                               <td></td>
                              <td> <input type="image" src=/images/btn_cart.gif align="middle">
                                <a href='./wizmart.php?query=compare_del&uid=<?php echo $value_arr[0]?>'><img src=/images/btn_delete02.gif></a>
                              </td>
                              <td></td>
                            </tr>
                          </form>
                        </table></td>
                    </tr>
                  </table></td>
<?php
$NO++;
// && $NO != $Total
if(!($NO%2)) echo"</tr>
              <tr> 
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>			  
              <tr background=images/bg_prodetail.gif> 
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr> ";
else echo "<td></td>";			  
endwhile;
else :
?>
                <td>제품 비교품목이 없습니다.</td>
<?php
endif;
?>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td></td>
  </tr>
</table>
