<?
/* 
제작자 : 폰돌
*** Updating List ***
*/
?>
<SCRIPT LANGUAGE=javascript>

function commaSplit(srcNumber) { 
var txtNumber = '' + srcNumber; 

var rxSplit = new RegExp('([0-9])([0-9][0-9][0-9][,.])'); 
var arrNumber = txtNumber.split('.'); 
arrNumber[0] += '.'; 
do { 
arrNumber[0] = arrNumber[0].replace(rxSplit, '$1,$2'); 
} while (rxSplit.test(arrNumber[0])); 
if (arrNumber.length > 1) { 
return arrNumber.join(''); 
} 
else { 
return arrNumber[0].split('.')[0]; 
	  } 
} 


function filterNum(str) { 
re = /^\$|,/g; 
return str.replace(re, ""); 
} 


function product_select(num,money,product){
	var arrNumber = product.value.split('|');
	if (product.value) {
	num.value = 1;
	}
	else {
	num.value = 0;
	}

	money.value = commaSplit(num.value * arrNumber[0]);
	total = document.estim.TOTAL_MONEY;
	var f = document.forms.estim;
	var i = 0;
	var t_total = '';
	for(i = 0; i < f.length; i++ ) {
		if(f[i].type == 'text' && f[i].name != 'TOTAL_MONEY') {
			if(filterNum(f[i].value) > 1000) {
				if (t_total > 0) {
					t_total = parseInt(t_total);
				}
				t_total = t_total + parseInt(filterNum(f[i].value));
			}
		}
	}
	if (t_total) {
	total.value = commaSplit(t_total);
	}
	else {
	total.value = 0;
	}
	return;
}
function num_plus_e(product){
f = document.estim;
	gnum = parseInt(f.BUYNUM.value);
	if (product) {
	f.BUYNUM.value = gnum + 1;
	f.P_MONEY.value = commaSplit(parseInt(f.BUYNUM.value) * parseInt(f.Price.value));
	}
	else {
		alert('제품이 선택되지 않았습니다.');
	}
	return;
}

function num_minus_e(product){
f = document.estim;
	gnum = parseInt(f.BUYNUM.value);
	if( gnum > 1 && product){
		f.BUYNUM.value = gnum - 1;
		f.P_MONEY.value = commaSplit(parseInt(f.BUYNUM.value) * parseInt(f.Price.value));
	}
	else {
		alert('제품은 최소 1EA 이상 담으셔야 합니다.');
	}
	return;
}
function overclick(){
  	alert("\n\n정확한 계산을 위해 직접 입력은 허용되지 않습니다.\n\n");
}
function really(tm){
	if (tm.value < 1) {
		alert('선택된 제품이 없습니다.');
		return false;
	}
	if (confirm('\n\n온라인 견적을 이용해 주셔서 감사합니다.   \n\n고객님께서 선택하신 내용이 정확합니까?  \n\n')) return true;
	return false;
}
function view_page(product){
    //var product;
	if (product) {
	var go_url = "wizmart.php?query=view&no="+ product;
	window.open(go_url, 'estim_view','width=650,height=600,statusbar=no,scrollbars=yes,toolbar=no');
	}
	else {
	alert('\n\n제품을 선택해야 상세설명페이지를 보실 수 있습니다.\n\n');
	}
	return;
}
</script>

<!-- B2B start -->
      
<table>
  <tr> 
                            <td><table>
        <tr> 
                                  <td><img src="./skinwiz/estimate/<?=$EstimSkin?>/images/sheet_s_t2.gif" width="100" hspace="10"></td>
                                  
          <td>&nbsp;</td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr> 
                            
    <td><br />
                              <table WIDTH=95% CELLSPACING=2>
							  <form name="estim" action='<?ECHO "$PHP_SELF";?>' METHOD="POST">
							  <input type="hidden" name="code" value="<?=$code?>" ?>
                                  <tr BGCOLOR=#399F92> 
                                    
                                    
                        <td> 
                          <!------------------------------------------------------------------------->
                          <select name=big_cat style='width:100' onChange='this.form.submit()'>
                            <option value='' selected>--------</option>
<?
$SQL_STR = "SELECT cat_no, cat_name FROM wizCategory WHERE cat_no < 100 ORDER BY cat_no ASC";
$SQL_QRY = $dbcon->_query($SQL_STR);
$big_code =  "0000".substr($big_cat,4);
while($LIST=@$dbcon->_fetch_array($SQL_QRY)):
	if($big_code == $LIST[cat_no]) $selected = "selected";
	else unset($selected);
	ECHO "<OPTION VALUE='$LIST[cat_no]' $selected>$LIST[cat_name]</OPTION>\n";
endwhile;	
?>
                          </select>
                          <!------------------------------------------------------------------------->
                                    </td>
                                    
                        <td> 
                          <!------------------------------------------------------------------------->
                          <select name=mid_cat style='width:100' onChange='this.form.submit()'>
                            <option value='' selected >--------</option>
<?
if($sort){
    $big_code = substr($big_cat,4);
	$mid_code = "00".$big_code;
	$SQL_STR1 = "SELECT cat_no, cat_name FROM wizCategory WHERE cat_no < 10000 AND cat_no >= 100 AND cat_no LIKE '%$big_code' ORDER BY cat_no ASC";
	$SQL_QRY1 = $dbcon->_query($SQL_STR1);
		while($LIST1=@$dbcon->_fetch_array($SQL_QRY1)): 
			if($mid_code == $LIST1[cat_no]) $selected = "selected";
			else unset($selected);
			ECHO "<OPTION VALUE='$LIST1[cat_no]' $selected>$LIST1[cat_name]</OPTION>\n";
		endwhile;
}
?>
                          </select>
                          <!------------------------------------------------------------------------->
                                    </td>
                        <td> 
                          <!------------------------------------------------------------------------->
                          <select name=small_cat style='width:100' onChange='this.form.submit()'>
                            <option value='' selected >--------</option>
<?
if($sort){
    $mid_code = substr($mid_cat,2);
	$small_code = "00".$mid_code;
	$SQL_STR2 = "SELECT cat_no, cat_name FROM wizCategory WHERE cat_no >= 10000 AND cat_no LIKE '%$mid_code' ORDER BY cat_no ASC";
	$SQL_QRY2 = $dbcon->_query($SQL_STR2);
		while($LIST2=@$dbcon->_fetch_array($SQL_QRY1)): 
			if($small_code == $LIST1[cat_no]) $selected = "selected";
			else unset($selected);
			ECHO "<OPTION VALUE='$LIST2[cat_no]' $selected>$LIST2[cat_name]</OPTION>\n";
		endwhile;
}
?>
                          </select>
                          <!------------------------------------------------------------------------->
                                    </td>									
                                    
                        <td> 
                          <select name=sort3 style='width:150' onChange='this.form.submit()'>
                            <option value=''>------------------</option>
<?
if($small_cat){
 $sqlstr = "select UID, Name, Model, Price, Price1 from wizMall where Category = '$small_cat' order by uid desc";
}else if($mid_cat){
 $mid_code = substr($mid_cat,2);
 $sqlstr = "select UID, Name, Model, Price, Price1 from wizMall where Category like '%$mid_code' and Category < '10000' order by uid desc";							
}else if($big_cat){
 $big_code = substr($big_cat, 4);
 $sqlstr = "SELECT UID, Name, Model, Price FROM wizMall WHERE Category LIKE '%$big_code' order by uid desc";
}
	$dbcon->_query($sqlstr);
		while($LIST3=@$dbcon->_fetch_array($sqlqry)): 
			if($sort3 == $LIST3[UID]) ECHO "<OPTION VALUE='$LIST3[UID]' selected>$LIST3[Model]($LIST3[Name])</OPTION>\n";
			else ECHO "<OPTION VALUE='$LIST3[UID]'>$LIST3[Model]($LIST3[Name])</OPTION>\n";
		endwhile;
?>
                          </select>
                        </td>
                                    
                        <td> 
                          <input type="button" value='보기' onClick="view_page(<?=$sort3?>)" name="BUTTON">
                        </td>
                                    <td> <table>
                                        <tr> 
                                          <td rowspan=2>
                                <input type="text" name='BUYNUM' style='text-align:center;' maxlength=5 readonly value='1' onClick='javascript:overclick()'> 
                                          </td>
                                          
                              <td><a href='javascript:num_plus_e(<?=$sort3?>);'><img src='./skinwiz/estimate/<?=$EstimSkin?>/images/num_plus.gif'></a></td>
                                          <td rowspan=2></td>
                                        </tr>
                                        <tr> 
                                          
                              <td><a href='javascript:num_minus_e(<?=$sort3?>);'><img src='./skinwiz/estimate/<?=$EstimSkin?>/images/num_minus.gif'></a></td>
                                        </tr>
                                      </table></td>
                                    <td> <?
if($sort3){
$SQL_SEL_STR = "SELECT Price FROM wizMall WHERE UID='$sort3'";
$SQL_SEL_QRY = $dbcon->_query($SQL_SEL_STR);
$SQL_RESULT = $dbcon->_fetch_array($SQL_SEL_QRY);
if($SQL_RESULT[Price]) $MONEY_VALUE=$SQL_RESULT[Price];
else $MONEY_VALUE=$SQL_RESULT[Price];
}
?>
<input type="hidden" name=Price value='<?=$MONEY_VALUE?>'>
                          <input type="text" name='P_MONEY' size=8 style='font-weight:bold;color:blue;text-align:right' readonly value='<?=number_format($MONEY_VALUE)?>' onClick='javascript:overclick()'>
                        </td>
                                    
                        <td> 
                          <input type="submit" name="SAVE_VALUE" value="INPUT">
                        </td>
                                  </tr>
                                </form>
                              </table> 
    </td>
                          </tr>
                          <tr> 
                            <td>&nbsp;</td>
                          </tr>
                          <tr> 
                            
    <td> 
      <!-- cart view start -->
      <? include "./skinwiz/estimate/$EstimSkin/estim_cart_view.php";?>
      <!-- cart view end -->
    </td>
                          </tr>
                          <tr> 
                            <td>&nbsp;</td>
                          </tr>
                        </table>