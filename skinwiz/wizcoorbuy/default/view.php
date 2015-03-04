<?
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/

$view = $mall->getview($no);
$output   = $view["tmpOutput"] + $view["Output"]; // 재고량
$c_stock = $view["Stock"] - $output;
$sqlstr = "select * from wizcoorbuy where PID = '".$view["source_id"]."'";
$list = $dbcon->get_row($sqlstr);
$view["PriceQty"]	= $list["PriceQty"];
$view["SDate"]		= $list["SDate"];
$view["FDate"]		= $list["FDate"];

$Price1	= $view["Price1"];
$Price	= $view["Price"];

$co=$mall->get_co_con($view["PriceQty"]);

$c_price = $mall->get_co_price($co, $output, $view["Price"]);
$Height = 70;
?>

<script language="JavaScript">
<!--


function autoCheck(f){
	checkenable = new Array(); 
    if(f.checkenable){
   		var checkenablelen = f.checkenable.length
        for (i = 0; i < checkenablelen; i++){
            if(f.checkenable[i].value == ""){
            alert(f.checkenable[i].title);
            f.checkenable[i].focus();
            return false;
            }
        }
        if(!checkenablelen && f.checkenable.value == ""){
        alert(f.checkenable.title);
        f.checkenable.focus();
        return false;
        }
	return true;
    } 
}


function baropay(){
	var f=document.view_form;

	if(autoCheckForm(f)){
		f.sub_query.value = "baro";
		f.submit();
	}
}

function checkForm(){
	var f=document.view_form;
	if(autoCheckForm(f)) return true;
	else return false;
}

function checkthis(v){

	var i,currEl,splitvalue,commanewprice;
	var f = eval("document."+v.form.name);
	var currPrice = parseInt(f.GoodsPrice.value);
	var newprice = 0;
	
    for(i = 0; i < f.elements.length; i++){ 
		currEl = f.elements[i]; 
		if (currEl.getAttribute("oflag") != null) { 
			if(currEl.value){
				if(currEl.oflag == "1"){//가격추가
					splitvalue = currEl.value.split('|');
					newprice += parseInt(splitvalue[1]);
				}else if(currEl.oflag == "1"){//상품가격변경
					currPrice = parseInt(splitvalue[1]);
				}
			}
		}
	}
	
	newprice = currPrice + newprice; 
	commanewprice = SetComma1(newprice);	
	if (document.layers) { 
		document.layers.item_price.document.write(commanewprice); 
		document.layers.item_price.document.close(); 
	}else if (document.all) item_price.innerHTML = commanewprice;	
}


function getBigPicture(no){
	wizwindow('./skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/picview.php?no='+no, 'BICIMAGEWINDOW','width=750,height=592,statusbar=no,scrollbars=no,toolbar=no,resizable=no')
}





function num_plus(num){
	gnum = parseInt(num.BUYNUM.value);
	if( gnum < <?=$c_stock;?> ){
		num.BUYNUM.value = gnum + 1;
	}else {
		alert('여유수량을 초과할 수 없습니다.');
	}
	//cat_price(num.BUYNUM.value);
	return;
}

function num_minus(num){
	gnum = parseInt(num.BUYNUM.value);
	if( gnum > 1 ){
		num.BUYNUM.value = gnum - 1;
	}	
	//cat_price(num.BUYNUM.value);
	return;
}

function cat_price(qty){//제품수량에 따른 가격 적용
	var total = parseInt(qty)+<?=$view["Output"]?>;
	var rtn_price;
	switch(true){
<?
foreach($co as $key=> $value){	
		$str[$key] = "case(total >= ".$value["qty"]."):\n";
		$str[$key] .= "rtn_price = ".$value["price"].";\n";
		$str[$key] .= "break;\n";
}
krsort($str);
foreach($str as $value){
	echo $value;
}
?>			
		default:
			rtn_price = <?=$c_price?>;
		break;
	}
//alert(total);
	commanewprice = SetComma1(rtn_price);
	if (document.layers) { 
		document.layers.item_price.document.write(commanewprice); 
		document.layers.item_price.document.close(); 
	}else if (document.all) item_price.innerHTML = commanewprice;
}

function wishreally(){
if (confirm('\n\n정말로 본 제품을 위시리스트에 담으시겠습니까?\n\n')) return true;
return false;
}

//-->
</script>
<table>
  <tr> 
    <td><table>
        <tr> 
          <td>&nbsp;</td>
          <td><img src="./skinwiz/shop/<?=$cfg["skin"]["ShopSkin"]?>/images/sn_arrow.gif" width="13" height="13"></td>
          <td>Home > <a href="./wizcoorbuy.php">공동구매</a> 
            <?=$route?>
          </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td> <table>
        <form name='view_form' action='./wizbag.php' method="post" onsubmit='return checkForm();'>
          <input type="hidden" name="query" VALUE="cart_save">
          <input type="hidden" name="no" VALUE="<?=$no?>">
          <input type="hidden" name="source_id" VALUE="<?=$view["source_id"]?>">
          <input type="hidden" name="sub_query" VALUE= "">
          <tr>
            <td><a href="javascript:getBigPicture(<?=$view["source_id"]?>)"><img src="<?=$view["imgsrc"]?>" /></a></td>
            <td><table>
                <tr>
                  <td colspan="3"><?=$view[Name]?>
                    <? if($view[Model]) echo "(".$view[Model].")"; ?>
                    
                    <?=$mall->ShowOptionIcon($cfg["skin"]["ShopIconSkin"], $RegOptionArr, $view[Regoption]);?></td>
                </tr>
                <tr>
                  <td>&nbsp;즉시구매가</td>
                  <td>:</td>
                  <td><SPAN id="item_price">
                    <?=number_format($c_price)?>
                    </SPAN>원 
                    <input type='hidden' name='GoodsPrice' value='<? echo $c_price; ?>'></td>
                </tr>
                <tr>
                  <td background="skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/images/bg_w.gif" colspan="3"></td>
                </tr>
                <?if($view[Price1]):?>
                <tr>
                  <td>&nbsp; 시중가격</td>
                  <td>:</td>
                  <td>
                    <?=number_format($view[Price1])?>
                    원</td>
                </tr>
                <tr>
                  <td background="skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/images/bg_w.gif" colspan="3"></td>
                </tr>
                <?endif;?>
                <?if($view[Brand]):?>
                <tr>
                  <td> &nbsp; 브랜드</td>
                  <td>:</td>
                  <td><?=$view[Brand]?></td>
                </tr>
                <tr>
                  <td background="skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/images/bg_w.gif" colspan="3"></td>
                </tr>
                <? endif;?>
                <?if($view[Point]):?>
                <tr>
                  <td>&nbsp; 적립포인트</td>
                  <td>:</td>
                  <td><?=number_format($view[Point])?></td>
                </tr>
                <tr>
                  <td background="skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/images/bg_w.gif" colspan="3"></td>
                </tr>
                <? endif;?>
                <? //옵션설정값 디스플레이
$substr = "select * from wizMalloptioncfg where opid = '$no' order by oorder asc";
//echo $substr;
$qry	 = $dbcon->_query($substr);
while($sublist = $dbcon->_fetch_array($qry)):
	$oname	= $sublist["oname"];
	$oflag	= $sublist["oflag"];
	$ouid = $sublist["uid"];
	
	//옵션값갯수구하기
	$substr1 = "select count(1) from wizMalloption where ouid = '$ouid'";
	$valuecnt = $dbcon->get_one($substr1);
	if($valuecnt > 0 ){
?>
                <tr>
                  <td> &nbsp;
                    <?=$oname?>
                    </td>
                  <td>:</td>
                  <td><?
	if($valuecnt == "1"){//옵션등록갯수가 하나이면 일반 텍스트 디스플레이
		echo $oname;
	}else{//실렉트 박스 출력
		$checkstr = $oflag == "0"?" checkenable msg='".$oname."를 선택해 주세요'":"";
?>
                    <select name="optionfield[<?=$ouid?>]" class="formline" <?=$checkstr?> oflag="<?=$oflag;?>" onchange="checkthis(this)">
                      <OPTION VALUE=''>
                      <?=$oname?>
                      선택</OPTION>
                      <?
						$substr1 = "select uid, oname, oprice from wizMalloption where ouid = '$ouid' order by uid asc";
						$subqry1 = $dbcon->_query($substr1);
						$subcnt=0;
						while($sublist1 = $dbcon->get_rows()):
							$uid = $sublist1["uid"];
							$oname = $sublist1["oname"];
							$oprice = $sublist1["oprice"];
							if($oprice) $displayoprice = "(".$oprice.")";
							ECHO "<OPTION VALUE='".$uid."|".$oprice."'>".$oname.$displayoprice."</OPTION>\n";
						endwhile;
?>
                    </select>
                    <?
		}//if($valuecnt == "1"){}else{
?>
                  </td>
                </tr>
                <tr>
                  <td background="skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/images/bg_w.gif" colspan="3"></td>
                </tr>
                <? 

	}//if($valuecnt > 0 ){
endwhile;//while($sublist = $dbcon->_fetch_array($subqry)):
?>
                <tr>
                  <td background="skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/images/bg_w.gif" colspan="3"></td>
                </tr>
                <tr>
                  <td> &nbsp; 주문수량</td>
                  <td>:</td>
                  <td><table>
                      <tr>
                        <td><table >
                            <tr>
                              <td rowspan=2><input type="text" name="BUYNUM" maxlength=5 value="1" onKeyPress="is_number()">
                              </td>
                              <td><a href="javascript:num_plus(document.view_form);"><img src="./skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/images/num_plus.gif"></a></td>
                              <td rowspan=2>&nbsp;&nbsp;EA</td>
                            </tr>
                            <tr>
                              <td><a href="javascript:num_minus(document.view_form);"><img src="./skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/images/num_minus.gif"></a></td>
                            </tr>
                          </table></td>
                        <td width="117">&nbsp;</td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td colspan="3"></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><a href="javascript:getBigPicture(<?=$view["source_id"]?>)"><img src="./skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/images/but_zoom.gif" width="83"></a></td>
            <td>
                              <table>
  <tr>
    <td><table>
  <tr>
    <td>정상<br />
      가격</td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><img src="<?=$coor_path?>/images/bar1.gif"4 height=<?=$Height?>> <br /><?=number_format($Price1)?></td>
  </tr>
  <tr>
    <td></td>
  </tr>
</table></td>
    <td></td>
    <td><table>
  <tr>
    <td>공구<br />
      가격</td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><img src="<?=$coor_path?>/images/bar1.gif"4 height=<? $NewHeight = $Height*$Price/$Price1; echo $NewHeight;?>> <br />
    <? $mall->insert_tag($c_price, $Price) ?></td>
  </tr>
  <tr>
    <td></td>
  </tr>
</table></td>
<?
foreach($co as $key=> $value){
$g_height = $Height*$value["price"]/$Price1;
?>
    <td></td>
    <td><table>
  <tr>
    <td><?=$value["qty"]?>개<br />
     이상</td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><img src="<?=$coor_path?>/images/bar1.gif"4 height="<?=$g_height;?>"> <br />

    <? $mall->insert_tag($c_price, $value["price"]) ?></td>
  </tr>
  <tr>
    <td></td>
  </tr>
</table></td>
<?
}
?>

  </tr>
</table><br /> 
<?
if($view[None] == "checked" || $view[FDate] < mktime(0,0,0,date("m"),date("d"), date("Y")) || $c_stock  < 1) :

?>
              <a href="javascript:window.alert(' 본 제품의 공동구매가 완료되었습니다. ');"> 
              <img src="./skinwiz/wizcoorbuy/<?=$cfg["skin"]["CoorBuySkin"]?>/images/but_jbgn.gif" width="117"> 
              </a> 
              <?else:?>
              <input name="IMAGE" type=IMAGE src="./skinwiz/wizcoorbuy/<?=$cfg["skin"]["CoorBuySkin"]?>/images/but_jbgn.gif" width="117">
              <?endif;?>
              <a href="javascript:history.go(-1)"><img src='./skinwiz/wizcoorbuy/<?=$cfg["skin"]["CoorBuySkin"]?>/images/but_liest.gif'></a></td>
          </tr>
        </form>
    </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><table>
        <tr bgcolor="#EBEBEB"> 
          <td bgcolor="#EBEBEB">&nbsp; →&nbsp; 상품상세정보</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td  colspan="2"></td>
        </tr>
        <tr> 
          <td colspan="2"></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>
<table>
        <tr>
          <td colspan="2"><br />
            <table>
              <tr>
                <td><font color ="#000000">
                  <?=$view["Description1"]?>
                  
                  <p>&nbsp;</p></td>
              </tr>
            </table>
            <br />
          </td>
        </tr>
        <tr>
          <td background="skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/images/bg_w.gif" colspan="2"></td>
        </tr>
      </table>
    </td>
  </tr>
  <? if($cfg["skin"]["GoodsDisplayEstim"] == "checked"):?>
  <!-- 상품 평가 시작 -->
  <tr>
    <td><br />
      <table>
        <tr>
          <td width="468"><img src="./skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/images/title_view.gif" width="424"></td>
          <td width="92"><img src="./skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/images/but_ww2.gif" width="69" height="19" onClick="wizwindow('./skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/estimatepopup.php?query=<?=$query?>&code=<?=$code?>&no=<?=$no?>&GID=<?=$view["source_id"]?>','','width=554,height=450')" style="cursor:pointer"></td>
        </tr>
        <tr>
          <td  colspan="2"></td>
        </tr>
        <tr>
          <td colspan="2"></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><br />
      <script language="JavaScript">
<!--
function check_reple_Form(){
	var f=document.estimat;
	if(f.Name.value == ''){
		alert('성함을 입력해주세요');
		f.Name.focus();
		return false;
	} else if(f.Contents.value == ''){
		alert('상품사용후기를 입력해주세요');
		f.Contents.focus();
		return false;
	}
}

function reple_delete(uid){
var f=document.estimat;
	f.repleqry.value = "insert";
	f.mode.value = "";
	f.repleuid.value = uid;
	f.submit();

}
//-->
</script>
      <form name="estimat" action="<?=$PHP_SELF?>" onsubmit='return check_reple_Form();'>
        <input type="hidden" name="query" value="<?=$query?>">
        <input type="hidden" name="code" value="<?=$code?>">
        <input type="hidden" name="no" value="<?=$view["source_id"]?>">
        <input type="hidden" name="repleqry" value="insert">
        <input type="hidden" name="Name" value="<?=$_COOKIE[MEMBER_NAME]?>">
        <input type="hidden" name="repleuid" value="">
        <!--<? if($cfg["member"]):?>
                                <input name="image2" type="image" src="img/main/btn_sub.gif" width="51" height="21"> 
                                <? else: ?>
                                <a href="javascript:window.alert('로그인후 사용가능합니다.')"><img src="img/main/btn_sub.gif" width="51" height="21"></a> 
                                <? endif;?>-->
      </form>
      <?
    
$sqlstr = "select * from wizEvalu where GID = '".$view["source_id"]."' ORDER BY Wdate desc";
$dbcon->_query($sqlstr);
while($list = $dbcon->_fetch_array()):
$list[Contents] = nl2br($list[Contents]);
$list[Contents] = stripslashes($list[Contents]);
$list[Subject] = stripslashes($list[Subject]);
?>
      <table>
        <tr>
          <td>글쓴이</td>
          <td><?=$list[Name]?>
            <? if($cfg["member"] == $list[ID]):?>
            &nbsp;&nbsp;&nbsp;<a href="javascript:reple_delete('<?=$list[UID]?>');" >x</a>
            <?endif;?></td>
          <td>고객선호도 </td>
          <td><img src="./skinwiz/viewer/<?=$cfg["skin"]["ViewerSkin"]?>/images/star<?=$list[Grade]?>.gif"></td>
        </tr>
        <tr>
          <td colspan="4"><?=$list[Subject]?></td>
        </tr>
        <tr>
          <td colspan="4" style="word-break:break-all;"><?=$list[Contents]?>
          </td>
        </tr>
      </table>
      <?
endwhile;
?>
      <br />
      <table>
        <tr>
          <td>≡ </td>
          <td>상품평은 개인의 체험을 바탕으로 한 주관적인 의견으로 사실과 다르거나,보는 사람에 따라 
            차이가 있을 수 있습니다.</td>
        </tr>
      </table></td>
  </tr>
  <!-- 상품 평가 끝 -->
  <?endif;?> 
  <tr> 
    <td> 

    </td>
  </tr>
  <tr>
    <td>
    </td>
  </tr>
</table>
</td>
</tr> </table>