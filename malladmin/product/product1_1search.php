<?php
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/
include "../../lib/class.wizmall.php";
$mall = new mall();
$mall->db_connect($dbcon);

include "../common/header_pop.php";

## 전페이지 일반 변수 설정
$ListNo = "15";
$PageNo = "20";
if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $ListNo;

include ("./common.php");
include "../common/header_html.php";
?>

<script>
function input_value(){
	var f=document.mall_list;
	if(f.mode.value == "new"){
		var tarf = opener.writeForm.Option5;
	}else if(f.mode.value == "modify"){
		var tarf = opener.goods_modify.Option5;	
	}
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
			alert('비교상품을 선택해 주세요');
			return false;
	}else{
	var newval = tarf.value;
	var strlen = newval.length;
	var is_split = newval.indexOf("|",[strlen-1]);
	//alert(strlen);
	//alert(newval.indexOf("|",[strlen-1]));
	if(strlen > 0 && is_split < 0){
	newval +="|";
	}
	
		for(i = 0; i < f.length; i++ ) {
				if(f[i].type == 'checkbox') {
						if(f[i].checked) {
								newval += eval(f[i].value);
								newval +="|";
						}
				}
		}
		tarf.value = newval
		document.mall_list.reset();	
	}
}

function gotopage(page){
	var f = document.mall_list;
	f.cp.value = page;
	f.submit();

}

function checkField(){
	var f = document.mall_list;
	var chked = 0;
	for(i = 0; i < f.length; i++ ) {
			if(f[i].type == 'checkbox') {
					if(f[i].checked) {
							chked++;
					}
			}
	}
	if( chked < 1 ) {
			alert('비교상품을 선택해 주세요');
			return false;
	}else{
	f.action.value = "searchpdin";
	f.submit();
	}
}
//-->
</script>
</head>

<body>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-body">
		 제품을 선택후 확인 버튼을 눌러주세요
	  </div>
	</div>
</div>

<table>
  <tr> 
    <td>
<div class="space20"></div> <? 
	  $dp_mode = "pop";
	  include ("./product_searchbox.php"); 
	  ?>
      <br /> 
      <table class="table">
        <form action='<?=$PHP_SELF?>' name='mall_list'>
			<input type="hidden" name="csrf" value="<?=$common->getcsrfkey()?>">
			<input type="hidden" name="action" value='save'>
			<input type="hidden" name=mode value='<?=$mode?>'>
			<input type="hidden" name="cp" value=""> 	
			<input type="hidden" name="category" value='category'>
			<input type="hidden" name="orderby" value='orderby'>
			<input type="hidden" name="OptionList" value='OptionList'>
			<input type="hidden" name="keyword" value='keyword'>         
<?
if(is_array($SelectedLink)){
	foreach ($SelectedLink as $key => $value){
	echo "<input type='hidden' name='SelectedLink[".$key."]' value='$value'>\n";
	}
}
?>			  
          <tr> 
            <th>선택</th>
            <th>제품명</th>
            <th>모델명</th>
            <th>브랜드</th>
          </tr>
          <?
$dbcon->get_select('*','wizMall m',$whereis, $orderby, $START_NO, $ListNo);
while( $list = $dbcon->_fetch_array()) :
		$UID = $list["UID"];
        $list["Name"] = stripslashes($list["Name"]);
        $list["CompName"] = stripslashes($list["CompName"]);
        $list["Description1"] = stripslashes($list["Description1"]);
        $list["Description2"] = stripslashes($list["Description2"]);
        $list["Model"] = stripslashes($list["Model"]);
		$Picture = explode("|",$list["Picture"]); 

?>
          <tr> 
            <td> <input type="checkbox" value='<?=$list[Name]?>'
                        name="SelectedLink[<?=$UID?>]" <? echo $SelectedLink[$UID]?"checked":"";?>> </td>
            <td><table>
                <tr> 
                  <td> 
                    <?=$list["Name"]?>
                    </td>
                </tr>
              </table></td>
            <td>&nbsp; 
              <?=$list["Model"]?>
            </td>
            <td>&nbsp; 
              <?=$list["Brand"]?>
            </td>
          </tr>
          <?endwhile;?>
          <tr> 
            <td colspan=4> <table 
                       >
                <tr> 
                  <td width=203> <input type="button" name="Button" value="비교상품담기" onClick="checkField()" style="cursor:pointer">
                    <input type="button" name="Button" value="닫기" onClick="window.close()" style="cursor:pointer"></td>
                  <td width="389" > 
                      
			  
					  <?
/* 페이지 번호 리스트 부분 */
if ( $CB > 1 ) {
$PREV_PAGE = $SP - 1;
echo "<a href=\"javascript:gotopage('$PREV_PAGE')\"><img src='../img/pre.gif' hspace='5'></a>";
} else {
echo "<img src='../img/pre.gif' hspace='5'>";
 }
/* LISTING NUMBER PART */
for ($i = $SP; $i <= $EP && $i <= $TP ; $i++) {
if($cp == $i){$NUMBER_SHAPE= "<font color = 'gray'>${i}";}
else $NUMBER_SHAPE="<font color = 'gray'>".${i}."";
ECHO"&nbsp;<a href=\"javascript:gotopage('$i')\">$NUMBER_SHAPE</a>";
}
/* NEXT or END PART */
if ($CB < $TB) {
$NEXT_PAGE = $EP + 1;
ECHO "&nbsp;<a href=\"javascript:gotopage('$NEXT_PAGE')\"><img src='../img/next.gif' hspace='5'></a>";
} else {
ECHO"&nbsp;<img src='../img/next.gif' hspace='5'>";
}
?></td>
                </tr>
              </table></td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
</body>
</html>			