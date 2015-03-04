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
include "../../config/common_array.php";


if ($common -> checsrfkey($csrf)) {
	if ($query == 'qin'){
		$common->point_fnc($id, $point, 41, $content);
		$common->js_location($PHP_SELF."?id=".$id);
	}else if ($query == 'qde'){
		$common->mode = "delete";
		$common->point_fnc($id, $point, 41, null, 0, $uid);
		$common->js_location($PHP_SELF."?id=".$id."&cp=".$cp);
	}

}

$title = "마일리지 정보";
include "../common/header_html.php";
?>
<body>
<script >
function frm_val(f){
	if(f.content.value==''){
		alert('내용이 입력되지 않았습니다.');
		f.content.focus();
		return false;
	}
	var Digit = '1234567890'
	if(f.point.value==''){
		alert('지급 금액을 입력하세요');
		return false;
	}
	else{
		var len =f.point.value.length;
		var ret;
		ret =false;
		for(var i=0;i<len;i++){
			var ch = f.point.value.substring(i,i+1);
			for (var k=0;k<=Digit.length;k++){
				if(Digit.substring(k,k+1) == ch)
				{
					ret = true;
					break;
				}
			}
			if (!ret){
			//alert('숫자만 입력가능합니다.');
			//f.point.focus();
			//return false;
			}
			ret = false;
		}
	}
}

function really(){
	if (confirm('정말로 삭제하시겠습니까?')) return true;
	return false;
}

function really() {
        if (confirm('\n\n삭제된 데이터는 복구가 불가능합니다.  \n\n정말로 삭제하시겠습니까?  \n\n')) return true;
        return false;
}
</script>
<?php echo $QryPoint[Name];?> 회원님의 적립금현황
      <hr color="gray">
      <form action='<?php echo $PHP_SELF?>' method="post" name=form1 onsubmit='return frm_val(this)'>
      	<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
        <input type="hidden" name="id" value='<?php echo $id?>'>
        <input type="hidden" name="query" value='qin'>
        내용 :
              <input type=text name=content size=60 maxlength=60>
              <br />
              금액 :
              <input type='text' name='point'  size=12  maxlength=10>
              <input type='submit' value='확 인'>
              (-포인트일경우 -2000원과 같이 입력해주세요) 
      </form>
      
        <table class="table">
          <tr>
            <th>번호</th>
            <th>적립내역</th>
            <th>가감 적립금 </th>
            <th>날짜</th>
            <th>삭제</th>
          </tr>
          <?php
/* 페이징과 관련된 수식 구하기 */
$whereis = "WHERE id = '$id'";
$sqlstr = "SELECT * FROM wizPoint $whereis";
$orderby = "order by wdate DESC ";
$dbcon->_query($sqlstr);
$TOTAL = $dbcon->_num_rows();

$pointstr = "select sum(point) from wizPoint $whereis";
$totalpoint = $dbcon->get_one($pointstr);

$ListNo = "15";
$PageNo = "20";

if(empty($cp) || $cp <= 0) $cp = 1;

$START_NO = ($cp - 1) * $ListNo;
$BOARD_NO=$TOTAL-($ListNo*($cp-1));

$SUB_SMONEY = 0;
$cnt=0;
$dbcon->get_select('*','wizPoint',$whereis, $orderby, $START_NO, $ListNo);	
while( $list = $dbcon->_fetch_array( ) ) :
$ptype = $list["ptype"];
?>
          <tr>
            <td>
                <?php echo $BOARD_NO?>                </td>
            <td>
<?php
echo $pointinfo[$ptype];
if($list["contents"]) echo "(".$list["contents"].")";
?></td>
            <td>
<font color="BROWN"><?php echo number_format(str_replace("-","",$list["point"]))?>
                      </font>
                      <select>
                      <?php
if (strpos("-", $list["point"]) == false) {
    $how = 2;
    echo "<option style='color:blue;'>가산(+)<OPTION>";
    $ORDER_MSG = "(거래완료)";
}else {
    echo "<option style='color:red;'>감산(-)<OPTION>";
    $how = 1;
    $ORDER_MSG = "<FONT COLOR=ORANGE>(거래취소)";
}
?> </select> </td>
            <td>
                <?php echo date("Y/m/d", $list["wdate"])?></td>
            <td><a href='<?php echo $PHP_SELF?>?query=qde&id=<?php echo $id?>&point=<?php echo $list["point"]?>&uid=<?php echo $list["uid"]?>&cp=<?php echo $cp?>&csrf=<?php echo $common->getcsrfkey()?>' onclick='return really();'>[삭제]</a></td>
          </tr>
          <?php
$SUB_SMONEY += $list[point];
$BOARD_NO--;
$cnt++;
endwhile;
//echo "totalpoint = $totalpoint <br />";
?>
<?php
if(!$cnt){
?>
          <tr>
            <td colspan="5">등록된 포인트가 없습니다.<a href='<?php echo $PHP_SELF?>?query=qde&id=<?php echo $id?>&point=<?php echo $list["point"]?>&uid=<?php echo $list["uid"]?>&cp=<?php echo $cp?>&csrf=<?php echo $common->getcsrfkey()?>' onclick='return really();'></a></td>
          </tr>
<?php
}
?>
        </table>
        <table>
          <tr>
            <td>현재페이지 포인트 : <?php echo number_format($SUB_SMONEY);?> 포인트 | 총 확보포인트 : <?php echo number_format($totalpoint);?> 포인트</td>
          </tr>
          <tr>
            <td height="34">
    <div class="text-center">
<?php
$params = array("listno" => $ListNo, "pageno" => $PageNo, "cp" => $cp, "total" => $TOTAL, "type" => "bootstrappost");
echo $common -> paging($params);
?>
    </div>
            </td>
          </tr>
        </table>
      </td>
  </tr>
</table>
</body>
</html>
