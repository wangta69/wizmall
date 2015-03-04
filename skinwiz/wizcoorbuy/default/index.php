<?
/* 
제작자 : 폰돌
스킨 : wizboard list skin 
URL : http://www.webpiad.co.kr
Email : master@webpiad.co.kr
*** Updating List ***
*/

$ListNo = $cfg["skin"]["SubListNo"] = 10;


//if (is_file("./skinwiz/wizcoorbuy/config/wizcoorbuytop.php")) :
//        include ("./skinwiz/wizcoorbuy/config/wizcoorbuytop.php");
//endif;
?>
<!--// 최상위이후의 카테고리 상단 메뉴 display 끝//-->
<SCRIPT LANGUAGE=javascript>
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
		alert('장바구니에 담을 제품을 선택해 주세요.');
	return false; 
	}
}
</script>
<SCRIPT LANGUAGE=javascript>
function num_plus(num){
	gnum = parseInt(num.value);
	num.value = gnum + 1;
	return;
}
function num_minus(num){
	gnum = parseInt(num.value);
	if( gnum > 1 ){
		num.value = gnum - 1;
	}	
	return;
}
function is_number(){
 	if ((event.keyCode<48)||(event.keyCode>57)){
  		alert("\n\n수량은 숫자만 입력하셔야 합니다.\n\n");
  		event.returnValue=false;
 	}
}

function gotoview(uid,cat){
	location.href = "<?=$PHP_SELF;?>?query=co_view&no="+uid+"&code="+cat;

}
</script>
<div class="navy">Home &gt; 공동구매</div>
<div class="space15"></div>
<ul>
                <?

if(!$cp) $cp = 1;
if(!$sel_orderby) $sel_orderby= "m1.UID@desc";
$tmp = explode("@", $sel_orderby);
$orderbystr = "order by ".$tmp[0]." ".$tmp[1];
$whereis = "where 1 and m1.opflag = 'c'";//공동구매인것
$TOTAL_STR = "SELECT count(1) FROM wizMall m1 $whereis";
$TOTAL = $dbcon->get_one($TOTAL_STR);	
$START_NO = ($cp - 1) * $ShopListNo;
$BOARD_NO=$TOTAL-($ShopListNo*($cp-1));
$cnt=0;
$select = "m2.UID, m2.PID, m2.Category, m1.Picture, m1.None, m1.Regoption, m1.Model, m1.Name, m1.Price,m1.Price1,m1.tmpOutput,m1.Output,m1.Stock, m1.Category as pcategory";
$select .= ",m1.tmpOutput,m1.Output,c.PriceQty, c.SDate, c.FDate"; 
$sqlqry = $dbcon->get_select($select,'wizMall m1 left join wizMall m2 on m1.PID = m2.UID left join wizcoorbuy c on c.PID = m1.PID',$whereis, $orderbystr, $START_NO, $ShopListNo);
while($list=$dbcon->_fetch_array($sqlqry)):
    $Picture = explode("|", $list[Picture]);
	$UID		= $list["UID"];
	$PID		= $list["PID"];
	$Category	= $list["Category"];
	$None		= $list["None"];
	$Regoption	= $list["Regoption"];
	$Model		= $list["Model"];
	$Name		= $list["Name"];
	$Price		= $list["Price"];
	$Price1		= $list["Price1"];
	
	$img_folder = substr($list["pcategory"], -3);
    $View_Pic_Size = $common->TrimImageSize("./config/uploadfolder/productimg/$img_folder/$Picture[0]", 110);

	## 공동구매 관련 변수
	$PriceQty	= $list["PriceQty"];
	$SDate		= $list["SDate"];
	$FDate		= $list["FDate"];
	$output     = $list["tmpOutput"] + $list["Output"]; // 재고량
?>
                <li><table>
                          <tr>
                            <td colspan='2'></td>
                          </tr>
                          <tr>
                            <td><a href="javascript:gotoview(<?=$UID?>,'<?=$Category?>')"><img src="./config/uploadfolder/productimg/<?=$img_folder?>/<?=$Picture[0]?>" width="100" height="100"></a><br /><a href="wizmart.php?query=view&code=<?=Category?>&no=<?=$UID?>">
                                    <?=Name?>
                                    </a></td>
                            <td>
<?
$co=$mall->get_co_con($PriceQty);
$c_price = $mall->get_co_price($co, $output, $Price);
$Height = 70;
?>
<ul class="default_ul">
<li><table>
  <tr>
    <td>정상<br />
      가격</td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><img src="<?=$coor_path?>/images/bar1.gif" height=<?=$Height?> width="14"> <br /><?=number_format($Price1)?></td>
  </tr>
  <tr>
    <td></td>
  </tr>
</table></li>
<li><table>
  <tr>
    <td>공구<br />
      가격</td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><img src="<?=$coor_path?>/images/bar1.gif" height=<? $NewHeight = $Height*$Price/$Price1; echo $NewHeight;?> width="14"> <br />
    <? $mall->insert_tag($c_price, $Price) ?></td>
  </tr>
  <tr>
    <td></td>
  </tr>
</table></li>
<?
foreach($co as $key=> $value){
$g_height = $Height*$value["price"]/$Price1;
?>
    <li><table>
  <tr>
    <td><?=$value["qty"]?>개<br />
     이상</td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><img src="<?=$coor_path?>/images/bar1.gif" height="<?=$g_height;?>" width="14"> <br />

    <? $mall->insert_tag($c_price, $value["price"]) ?></td>
  </tr>
  <tr>
    <td></td>
  </tr>
</table></li>
<?
}
?>
</ul>
                              <br />
신청수량 :
                                    <?=number_format($output)?>
                                    개</td>
                          </tr>
                          <tr>
                            <td colspan='2'> 기간 :
                              <?=date("Y.m.d",$SDate)?>
                              ~
                              <?=date("Y.m.d",$FDate)?>
                            </td>
                          </tr>
                        </table></li>
                <?
$cnt++;
// && $cnt != $Total
if(!($cnt%2)) ECHO"</tr><tr align='center'><td height='1' colspan='2'></td></tr><tr align='center'>";
endwhile;
$tmpcnt = $cnt%2;
if($tmpcnt){
	for($i=$tmpcnt; $i<2; $i++){
		echo "<td valign='top'></td>";
	}
}
?>

</ul>
			<div class="paging_box">
			<?
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
$page_arg1 = $PHP_SELF."?code=$code&lv=$lv&sort=$sort&sef=$sef&keyword=".urlencode($keyword)."&scat=$scat";
$page_arg2 = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL); 
//$page_arg3 = array("pre"=>"./img/pre.gif","next"=>"./img/next.gif");
echo $common->paging($page_arg1,$page_arg2,$page_arg3);
?>
</div>
<?
if (is_file("./skinwiz/wizcoorbuy/config/wizcoorbuybottom.php")) {
        include ("./skinwiz/wizcoorbuy/config/wizcoorbuybottom.php");
}
?>