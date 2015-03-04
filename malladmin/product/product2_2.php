<?php
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/
include "../common/header_pop.php";


if (!strcmp($action,"write") && $common -> checsrfkey($csrf)) :
/* 상품입력 시작 */
$Iinputdate = time();
$sqlstr = "INSERT INTO wizInputer (Icomid, Igoodscode, Iinputqty,Iinputdate) VALUES('$Icomid', '$uid', '$Iinputqty', '$Iinputdate')";
$dbcon->_query($sqlstr);

$sqlstr = "select sum(Iinputqty) from wizInputer where Igoodscode = '$uid'";
$total_quantity = $dbcon->get_one($sqlstr);

$sqlstr = "update wizMall set Stock = Stock + $Iinputqty where UID = '$uid'";
$dbcon->_query($sqlstr);


/* 회원 기타 정보 변경 끝 */
echo "<script  language='javascript'>
window.alert('\\n\\n 상품이 입고 처리 되었습니다. \\n\\n');
location.replace('$PHP_SELF?uid=$uid&Icomid=$Icomid&Name=$Name&Output=$Output');
</script>";
exit;
endif;

/* wizInputer 에서 정보 가져 옮 */
$SqlStr = "select sum(Iinputqty) as tqty from wizInputer where Igoodscode = '$uid'";
$SqlQry = $dbcon->_query($SqlStr);
$List = $dbcon->_fetch_array();

include "../common/header_html.php";
?>
<body>
    <div>
		<form action='<?=$PHP_SELF;?>' method="post"> 
			<input type="hidden" name="csrf" value="<?=$common->getcsrfkey()?>">
			<input type="hidden" name="action" value="write">
			<input type="hidden" name="uid" value = "<?=$uid?>">
			<input type="hidden" name="Icomid" value="<?=$Icomid?>">
			<input type="hidden" name="Name" value="<?=$Name?>">
			<input type="hidden" name="Output" value="<?=$Output?>">
<!-- uid=<?=$uid?>&Name=<?=$Name?>&Output=<?=$Output?> -->
   <table>
      <td>
        <td colspan=2>&nbsp; 상품 
          입고 관리<br />
          (입고처 변경은 상품수정에서 바로 변경해 주세요)</td>
      </tr>
      <tr> 
        <th>* 상품명</th>
        <td> <input name="Name" type="text"  id="Name" value="<?=$Name?>" size="15" readonly></td>
      </tr>
      <tr> 
        <th>* 총입고량</th>
        <td> <input name="tqty" type="text" id="Name" value="<?=number_format($List[tqty]);?>" size="15" readonly></td>
      </tr>
      <tr> 
        <th>* 총판매량</th>
        <td> <input name="Output" type="text" id="Output" value="<?=$Output?>" size="15" readonly></td>
      </tr>
      <tr> 
        <th>* 현재재고량</th>
        <td> <input name="Name" type="text" id="Name" value="<?=($List[tqty] - $Output)?>" size="15" readonly></td>
      </tr>
      <tr> 
        <th>* 상품입고량</th>
        <td> <input name="Iinputqty" type="text" id="Name" value="" size="15"></td>
      </tr>
    </table>
    <br />
<table>
  <tr> 
        <td colspan="2" ><input type="image" src="../img/su.gif" > 
<!--          &nbsp; <img src="img/order_icon3.gif" width="66" onclick="window.print()" style="cursor:pointer"> -->
          &nbsp; <img src="../img/order_icon4.gif" width="66"  onclick='javascript:top.close();' style="cursor:pointer"> 
        </td>
  </tr>

</table> </form></div>
</body>
</html>