<?php
/*
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com

*/

include ("../lib/class.cart.php");
$cart = new cart;
$cart->get_object($dbcon,$common);
$CART_CODE = $_COOKIE["CART_CODE"];
?>
<script>
$(function(){
	//주문자 입력테이블 활성화
	$("#btn_input").click(function(){
		$(".ordermeminfo").show();
	});
});
function Order(){

	var f = document.Jumun;
	
}

function cmp(){
        var f = document.forms.mall_list;
        var i = 0;
        var chked = 0;
        for(i = 0; i < f.length; i++ ) {
                if(f[i].type == 'checkbox') {
                        if(f[i].checked) {
                                chked++;
                        }
                }
        }
        if( chked < 1 ) {
                alert('삭제하고자 하는 상품에 체크해주시기 바랍니다.');
                return false;
        }
        if (confirm('\n\n삭제하는 제품은 DB에서 삭제되어 복구가 불가능합니다.\n\n정말로 삭제하시겠습니까?\n\n')) return true;
        return false;
}


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
	total = document.Jumun.TOTAL_MONEY;
	var f = document.forms.Jumun;
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

function overclick(){
  	alert("\n\n정확한 계산을 위해 직접 입력은 허용되지 않습니다.\n\n");
}

function really(){
if (confirm('\n\n정말로 장바구니를 모두 비우시겠습니까?\n\n')) return true;
return false;
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

function is_number(){
         if ((event.keyCode<48)||(event.keyCode>57)){
                  alert("\n\n수량은 숫자만 입력하셔야 합니다.\n\n");
                  event.returnValue=false;
         }
}

function CheckForm(){
var f=document.Jumun;
	if(f.no.value == ''){
	alert ('상품명을 선택해 주세요');
	f.no.focus();
	return false;
	}else if(f.Price.value == '' || f.Price.value == 0){
	alert ('금액이 없어면 장바구니에 담기지 않습니다.');
	return false;
	}else{
	f.query.value = 'save';
	f.submit();	
	}
}


function NumberChk(f){     // 주민번호 valid check , 자동 다음 폼 이동
   num = f.value;
   numFlag = Number(num);
   if(!numFlag){
         alert('숫자를 넣어주세요');
         f.focus();
         return false;
   }
}

function AutoCal(f){
NumberChk(f);
var frm = document.Jumun;
frm.P_MONEY.value = frm.Price.value * frm.BUYNUM.value;
}




function num_cal(v, flag){
	var num = parseInt(v.value);
	if(flag == "plus"){
		v.value = num + 1;
	}else if(flag == "minus"){
		if(num > 1){
			v.value = num - 1;
		}
	}
	return;
}

function deleachItem(uid){
	location.href = "./order/order5_query.php?query=qde&cuid="+uid
}

function modQty(uid, v){
	location.href = "./order/order5_query.php?query=update_qty&cuid="+uid+"&BUYNUM="+v.value
}
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">주문서 입력</div>
	  <div class="panel-body">
		 오프라인의 고객 주문을 관리자 모드의 매출 통계와 연동시키고 싶을 경우 이곳에서 주문서를 수동으로 입력해 
                  주셔야 합니다.<br />
                  입력이 완료되후 고객이 장바구니를 이용해 주문한 것과 동일한 방법으로 주문처리를 해 주시면 됩니다.<br />
                  (예, 주문배송관리 -&gt; 주문확인 선택, 주문배송관리 -&gt; 주문배송완료선택)
	  </div>
	</div>
	
	<iframe frameborder="O" scrolling="no" name="testframe"  src="./order/order5_2.php" class="w100p"> </iframe>
	
	<form name='cart_list_form'action='./order/order5_query.php'>   
		<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
          <input type='hidden' name='menushow' value='<?=$menushow?>'>
          <input type="hidden" name="theme" value="<?=$theme?>"> 
				<table class="table table-hover table-striped">
					<col width="*" />
					<col width="80" />
					<col width="80" />
					<col width="80" />
					<col width="80" />
					<col width="80" />	
        <tr class="success">
          <th>주문상품</th>
          <th>가격</th>
          <th>수량</th>
          <th>소계</th>
          <th>수정</th>
          <th>삭제</th>
        </tr>
    
<?        
$cartstr = "select sum(c.qty) from wizMall m left join wizCart c on m.UID = c.pid where c.oid = '".$CART_CODE."'";
$TotalUnit = $dbcon->get_one($cartstr);;//총구매수량

$cartstr = "select m.Category, m.UID, m.None, m.Picture, m.Name, 
			c.uid as cuid, c.qty, c.price, c.tprice, c.point, c.optionflag
			from wizMall m 
			left join wizCart c on m.UID = c.pid 
			where c.oid = '".$CART_CODE."' 
			order by c.uid asc";
//echo "cartstr = $cartstr <br />";
$dbcon->_query($cartstr);
$i=0;
$TOTAL_MONEY = 0;
while($cartlist = $dbcon->_fetch_array()):	

    	$Picture	= explode("|", $cartlist["Picture"]);
		$UID		= $cartlist["UID"];
		$Category	= $cartlist["Category"];
		$None		= $cartlist["None"];
		$Name		= $cartlist["Name"];
		$cuid		= $cartlist["cuid"];
		$qty		= $cartlist["qty"];
		$price		= $cartlist["price"];
		$tprice		= $cartlist["tprice"];
		$point		= $cartlist["point"];
		$optionflag	= $cartlist["optionflag"];
		$TOTAL_MONEY += $tprice;
		$TOTAL_PRODUCT_MONEY += $tprice;
		
		
	//추가 - 제품이 구매된 모든 카테고리를 하나로 만든다. 캬테고리별 가격을 위해
	//2. 카테고리를 하나로 만든다.
	if(chop($TOTAL_CAT))$TOTAL_CAT .= "|"."$Category";
	else $TOTAL_CAT = $Category;	
?>

          <tr>
            <td><table>
                <tr>
                  <td><a  href="<?=$mall->pdviewlink($UID,$Category,$None)?>"><img src='../config/uploadfolder/productimg/<?=substr($Category, -3)?>/<?=$Picture[0]?>' height='50' ></a></td>
                  <td><a  href="<?=$mall->pdviewlink($UID,$Category,$None)?>"><U>
                    <?=$Name?>
                    </U></a>
                    <?
echo $cart->optoStr($optionflag);
?>                  </td>
                </tr>
              </table></td>
            <td><input type=text name='Price' maxlength=5 value='<?=number_format($price)?>' readonly>
              원</td>
            <td><table>
                <tr>
                  <td rowspan=2><input type=text name='BUYNUM_<?=$i?>' maxlength=5 value='<?=$qty?>' onkeypress="onlyNumber()">
                  </td>
                  <td><a  href="javascript:num_cal(document.cart_list_form.BUYNUM_<?=$i?>, 'plus')"><img src='img/num_plus.gif' width="15" height="13" ></a></td>
                  <td rowspan=2>&nbsp;&nbsp;EA</td>
                </tr>
                <tr>
                  <td><a  href="javascript:num_cal(document.cart_list_form.BUYNUM_<?=$i?>, 'minus')"><img src='img/num_minus.gif' width="15" height="12" ></a></td>
                </tr>
              </table></td>
            <td><FONT COLOR='#E37509'>
              <?=number_format($tprice);?>
               원</td>
            <td><a  href="javascript:modQty(<? echo $cuid;?>, document.cart_list_form.BUYNUM_<?=$i?>)"><img src='img/cart_modify.gif' width="19" height="17"></a>            </td>
            <td><a  href='javascript:deleachItem(<? echo $cuid;?>)'><img src='img/cart_delete.gif' width="19" height="17" ></a></td>
 <?
$i++;
endwhile;
?> 
      </table></form>
      
      
      
      
      	  <div class="btn_box agn_l">

          <!--주문자아이디
             <input name="order_id" type="text" onClick="window.open('./order/order5_1.php','UserSearchWindow','width=354,height=350')" value="<?=$order_id?>" readonly>
              <input type="button" name="Button" value="아이디 찾기" onClick="window.open('./order/order5_1.php','UserSearchWindow','width=354,height=350')" style="cursor:pointer">
            --><span id="btn_input" class="button bull"><a>주문자입력</a></span>

<script>
function CheckField(){
	var f=document.Jumun;
}

function OpenZipcode(flag){
	if(flag == "1"){//보내는분 주소찾기
		var zip1 = "SZip1";
		var zip2 = "SZip2";
		var firstaddress = "SAddress1";
		var secondaddress = "SAddress2";
	}else{//받는분 주소찾기
		var zip1 = "RZip1";
		var zip2 = "RZip2";
		var firstaddress = "RAddress1";
		var secondaddress = "RAddress2";	
	}
	window.open("../util/zipcode/zipcode.php?form=Jumun&zip1="+zip1+"&zip2="+zip2+"&firstaddress="+firstaddress+"&secondaddress="+secondaddress,"ZipWin","width=490,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no");	
}


function copyvalue(v){
	var f = document.Jumun;
	//alert(v.vlaue);
	if(f.copybtn[0].checked == true){
		f.RName.value = f.SName.value;
		f.RTel1_1.value = f.STel1_1.value;
		f.RTel1_2.value = f.STel1_2.value;
		f.RTel1_3.value = f.STel1_3.value;
		f.RTel2_1.value = f.STel2_1.value;
		f.RTel2_2.value = f.STel2_2.value;
		f.RTel2_3.value = f.STel2_3.value;
		f.RZip1.value = f.SZip1.value;
		f.RZip2.value = f.SZip2.value;
		f.RAddress1.value = f.SAddress1.value;
		f.RAddress2.value = f.SAddress2.value;	

		return;
	}else{
		f.RName.value = "";
		f.RTel1_1.value = "";
		f.RTel1_2.value = "";
		f.RTel1_3.value = "";
		f.RTel2_1.value = "";
		f.RTel2_2.value = "";
		f.RTel2_3.value = "";
		f.RZip1.value = "";
		f.RZip2.value = "";
		f.RAddress1.value = "";
		f.RAddress2.value = "";			
		return;
	}
}

</script>
      <form name="Jumun"  method="POST" action="./order/order5_query.php" onsubmit="return Order();">
        <input type="hidden" name="menushow" value="<?=$menushow?>">
        <input type="hidden" name="theme" value='<?=$theme?>'>
        <input type="hidden" name="query" value='order' />
        <table class="table_main ordermeminfo" style="display:none">
          <tr>
            <th>아이디</th>
            <td><input name="order_id" type="text" onClick="window.open('./order/order5_1.php','UserSearchWindow','width=354,height=350')" value="<?=$order_id?>" readonly>
              <input type="button" name="Button" value="아이디 찾기" onClick="window.open('./order/order5_1.php','UserSearchWindow','width=354,height=350')" style="cursor:pointer">
            (현재 회원이면 입력)            </td>
          </tr>         
          <tr>
            <th>이름</th>
            <td><input name="SName" type="text" id="SName" value="<?=$SName?>">            </td>
          </tr>
          <tr>
            <th>주소</th>
            <td><input name="SZip1" type="text" id="SZip1" value="<?=$SZip[0]?>" class="w30">
                    -
                    <input name="SZip2" type="text" id="SZip2" value="<?=$SZip[1]?>" class="w30">
                   <input type="button" name="button" id="button" value="주소찾기" onClick="javascript: OpenZipcode('1')"
style='CURSOR: pointer'><br />
                   <input name="SAddress2" type="text" value="<?=$SAddress2?>" class="w300" />
                   <input name="SAddress1" type="text" id="SAddress1" value="<?=$SAddress1?>" class="w300"><br /></td>
          </tr>
          <tr>
            <th>유선전화</th>
            <td><input name="STel1_1" type="text" id="STel1_1" value="<?=$STel1[0];?>" class="w30">
              -
              <input name="STel1_2" type="text" id="STel1_2" value="<?=$STel1[1];?>" class="w30">
              -
              <input name="STel1_3" type="text" id="STel1_3" value="<?=$STel1[2];?>" class="w30">            </td>
          </tr>
          <tr>
            <th>휴대전화</th>
            <td><input name="STel2_1" type="text" id="STel2_1" value="<?=$STel2[0];?>" class="w30">
              -
              <input name="STel2_2" type="text" id="STel2_2" value="<?=$STel2[1];?>" class="w30">
              -
              <input name="STel2_3" type="text" id="STel2_3" value="<?=$STel2[2];?>" class="w30">            </td>
          </tr>
          <tr>
            <th>E-mail</th>
            <td><input name="SEmail" type="text" id="SEmail" value="<?=$SEmail?>">            </td>
          </tr>
        </table>
        <table class="ordermeminfo" style="display:none">
          <tr>
            <td>배송지 정보가 주문자 정보와 동일 합니까?
              <input type="radio" name="copybtn" value="1" onClick="javascript:copyvalue(this)"; style="cursor:pointer">
              예
              <input type="radio" name="copybtn" value="0" onClick="javascript:copyvalue(this)"; style="cursor:pointer">
              아니오</td>
          </tr>
        </table>
        <table  class="table_main ordermeminfo" style="display:none">
          <tr>
            <th>이름</th>
            <td><input name="RName" type="text" id="RName" value="<?=$RName;?>">
            </td>
          </tr>
          <tr>
            <th>주소</th>
            <td><table>
                <tr>
                  <td><input name="RZip1" type="text" id="RZip1" value="<?=$RZip[0]?>" class="w30">
                    -
                    <input name="RZip2" type="text" id="RZip2" value="<?=$RZip[1]?>" class="w30">
                     <input type="button" name="button" id="button" value="주소찾기" onClick="javascript: OpenZipcode('21')"
style='CURSOR: pointer'></td>
                </tr>
                <tr>
                  <td><input name="RAddress1" type="text" id="RAddress1" value="<?=$RAddress1?>" class="w300">
                  </td>
                </tr>
                <tr>
                  <td><input name="RAddress2" type="text" id="RAddress2" value="<?=$RAddress2?>" class="w300">
                  </td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <th>유선전화</th>
            <td><input name="RTel1_1" type="text" id="RTel1_1" value="<?=$RTel1[0];?>" class="w30">
              -
              <input name="RTel1_2" type="text" id="RTel1_2" value="<?=$RTel1[1];?>" class="w30">
              -
              <input name="RTel1_3" type="text" id="RTel1_3" value="<?=$RTel1[2];?>" class="w30">
            </td>
          </tr>
          <tr>
            <th>휴대전화</th>
            <td><input name="RTel2_1" type="text" id="RTel2_1" value="<?=$RTel2[0];?>" class="w30">
              -
              <input name="RTel2_2" type="text" id="RTel2_2" value="<?=$RTel2[1];?>" class="w30">
              -
              <input name="RTel2_3" type="text" id="RTel2_3" value="<?=$RTel2[2];?>" class="w30">
            </td>
          </tr>
          <tr>
            <th>배송메세지</th>
            <td><table>
                <tr>
                  <td><textarea name="Message" cols="50" id="Message"><?=$Message?>
                </textarea></td>
                </tr>
                <tr>
                  <td>배송메세지란에는 배송시 참고할 사항이 있으면 적어주십시오.</td>
                </tr>
              </table></td>
          </tr>
        </table><table class="ordermeminfo" style="display:none">
          <tr>
            <td><input type="submit" name="Button2" value="상품주문"></td>
          </tr>
        </table>
      </form>
      
      
</div>
