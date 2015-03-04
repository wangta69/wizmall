<?
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/

include "../common/header_pop.php";

include "../../lib/class.wizmall.php";
$mall = new mall();
$mall->db_connect($dbcon);
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>">
<link rel="stylesheet" href="../common/admin.css" type="text/css">
<script language="javascript">
<!-- 
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
	f.action = 'order5_query.php';
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

function SortbyCat(cat){
	var f = document.Jumun;
	f.category.value = cat.value;
	f.submit();
}

function num_plus_e(num){
var frm = document.Jumun;
	gnum = parseInt(num.value);
	num.value = gnum + 1;
	frm.P_MONEY.value = frm.Price.value * num.value;
	return;
}
function num_minus_e(num){
var frm = document.Jumun;
	gnum = parseInt(num.value);
if( gnum > 1 ){
	num.value = gnum - 1;
	}
	frm.P_MONEY.value = frm.Price.value * num.value;	
	return;
}
//-->
</script>
</head>
<body>
<form name="Jumun" action='<?=$PHP_SELF?>' method="POST">
	<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
	<input type="hidden" name="query" value="">
	<input type="hidden" name="category" value="<?=$category?>">
	<table>
		<tr>
			<td><select style="width: 100px" onChange="SortbyCat(this)">
					<option value="">대분류</option>
					<option value="">-----------</option>
					<?
$mall->getSelectCategory(1, $category);
?>
				</select>
				<select style="width: 100px"  onChange="SortbyCat(this)">
					<option value="">중분류</option>
					<option value="">-----------</option>
					<?
$mall->getSelectCategory(2, $category);
?>
				</select>
				<select style="width: 100px"  onChange="SortbyCat(this)">
					<option value="">소분류</option>
					<option value="">-----------</option>
					<?
$mall->getSelectCategory(3, $category);
?>
				</select>
				<select name=no style='width:150' onChange='this.form.submit()'>
					<option value=''>제품명</option>
					<?
if($category):
	$sqlstr = "SELECT UID, Name, Model, Price FROM wizMall WHERE Category LIKE '%".$category."' order by uid desc";
	$dbcon->_query($sqlstr);
	while($list=$dbcon->_fetch_array()): 
		$selected = $no == $list["UID"] ? " selected":"";
		echo "<option value='".$list["UID"]."'$selected>".$list["Model"]."(".$list["Name"].")</option>\n";
	endwhile;
endif;
?>
				</select>
			</td>
			<td><table>
					<tr>
						<td rowspan=2><input type=text size=3 name='BUYNUM' style='text-align:center;' maxlength=5 readonly value='1' onClick='javascript:overclick()'>
						</td>
						<td><a href='javascript:num_plus_e(document.Jumun.BUYNUM);'><img src='../img/num_plus.gif' width="15" height="13" ></a></td>
						<td rowspan=2></td>
					</tr>
					<tr>
						<td><a href='javascript:num_minus_e(document.Jumun.BUYNUM);'><img src='../img/num_minus.gif' width="15" height="12" ></a></td>
					</tr>
				</table></td>
			<td><?
if($no){
	$sqlstr = "SELECT Price FROM wizMall WHERE UID='$no'";
	$MONEY_VALUE = $dbcon->get_one($sqlstr);
}
?>
				단가
				<input type="text" name='Price' size='5' value='<?=$MONEY_VALUE?>'  onKeyup="AutoCal(document.Jumun.Price)";>
			</td>
			<td><input type=text name='P_MONEY' size=5 style='font-weight:bold;color:blue;text-align:right' readonly value='<?=number_format($MONEY_VALUE)?>' onClick='javascript:overclick()' ></td>
			<td><input type="button" value="입력" onClick="CheckForm()" style="cursor:pointer">
			</td>
		</tr>
	</table>
</form>
</body>
</html>
