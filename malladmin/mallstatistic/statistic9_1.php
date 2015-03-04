<?
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/

$ThisYear = date("Y");
$ThisMonth = date("m");
$ThisDay = date("d");
?>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">판매처별 미수관리 - 상세 리스트 보기</div>
	  <div class="panel-body">
		 판매처의 미수관리를 적는 곳입니다. <br />
                  몰 시스템과 회원부분 외에는 연동되지 않습니다.
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
						<p></p>	
      <table class="table">
        <tr>
          <th>회원이름<br />
            (성별, 나이)</th>
          <th>아이디</th>
          <th>지역</th>
          <th>총판매금액</th>
          <th>총입급액</th>
          <th>미수액</th>
          <th>&nbsp;</th>
        </tr>
        <?
$sqlstr = "SELECT * FROM wizMembers where ID = '$mid'";
$sqlqry= $dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array( );
$list[Address1] = trim($list[Address1]);
$ZONE = explode(" ", $list[Address1]);
if(substr($list[Jumin2],0,1) == 1 || substr($list[Jumin2],0,1) == 2) $BirthCentury = 1900; else $BirthCentury = 2000;
$age = date("Y") - (substr($list[Jumin1],0,2) + $BirthCentury);
       
	   
$accountstr = "select sum(Ccreditprice) as credit, sum(Cincomprice) as incom, sum(Ccreditprice - Cincomprice) as rest from wizdailyaccount where CMID = '$list[ID]'";
$accountqry = $dbcon->_query($accountstr);
$accountlist = $dbcon->_fetch_array($accountqry);
?>
        <tr>
          <td><a href='#' onclick="javascript:window.open('./member1_1.php?id=<?=$list[ID]?>', 'regisform','width=650,height=650,statusbar=no,scrollbars=yes,toolbar=no')">
            <?=$list[Name]?>
            (
            <?=$list[Sex]?>
            ,
            <?=$age?>
            ) </a></td>
          <td><a href='#' onclick="javascript:window.open('./member1_1.php?id=<?=$list[ID]?>', 'regisform','width=650,height=600,statusbar=no,scrollbars=yes,toolbar=no')">
            <?=$list[ID]?>
            </a></td>
          <td>&nbsp;
            <?=$ZONE[0]?>
            </td>
          <td>&nbsp;
            <?=number_format($accountlist[credit])?>
            </td>
          <td>&nbsp;
            <?=number_format($accountlist[incom])?>
            </td>
          <td>&nbsp;
            <?=number_format($accountlist[rest])?>
            </td>
          <td><a href="#" Onclick="window.open('./statistic9_2.php?mid=<?=$mid?>','AccountWriteWindow','width=400,height=250')">입력</a></td>
        </tr>
      </table>
      <br />
      <table class="table">
        <tr>
          <td>&nbsp; </td>
          <td><?		  
if(!$SYear) $SYear = $ThisYear;
if(!$SMonth) $SMonth = $ThisMonth;
if(!$SDay) $SDay = 1;
if(!$EYear) $EYear = $ThisYear;
if(!$EMonth) $EMonth = $ThisMonth;
if(!$EDay) $EDay = $ThisDay;
?>
            <select name="SYear">
              <?
for($i = $ThisYear-3; $i < $ThisYear + 1; $i++){
if($i == $SYear) $selected = "selected";
else unset($selected);
echo "<option value='$i' $selected>$i</option> \n";
}
?>
            </select>
            년
            <select name="SMonth">
              <?
for($i = 1; $i < 13; $i++){
if($i == $SMonth) $selected = "selected";
else unset($selected);
echo "<option value='$i' $selected>$i</option> \n";
}
?>
            </select>
            월
            <select name="SDay">
              <?
for($i = 1; $i < 31; $i++){
if($i == $SDay) $selected = "selected";
else unset($selected);
echo "<option value='$i' $selected>$i</option> \n";
}
?>
            </select>
            일 ~
            <select name="EYear">
              <?
for($i = $ThisYear-3; $i < $ThisYear + 1; $i++){
if($i == $EYear) $selected = "selected";
else unset($selected);
echo "<option value='$i' $selected>$i</option> \n";
}
?>
            </select>
            년
            <select name="EMonth">
              <?
for($i = 1; $i < 13; $i++){
if($i == $EMonth) $selected = "selected";
else unset($selected);
echo "<option value='$i' $selected>$i</option> \n";
}
?>
            </select>
            월
            <select name="EDay">
              <?
for($i = 1; $i < 31; $i++){
if($i == $EDay) $selected = "selected";
else unset($selected);
echo "<option value='$i' $selected>$i</option> \n";
}
?>
            </select>
            일</td>
        </tr>
      </table>
      <table class="table">
        <tr>
          <th>일자</th>
          <th>내역</th>
          <th>매출액</th>
          <th>매입액</th>
        </tr>
        <?
$SUnixTime = mktime(0,0,0,$SMonth,$SDay,$SYear);
$EUnixTime = mktime(24,0,0,$EMonth,$EDay,$EYear);
$sqlstr = "select * from wizdailyaccount where CMID = '$mid' and Cdate <= '$EUnixTime' and Cdate >= '$SUnixTime' order by CID desc";
//echo "\$sqlstr = $sqlstr <br />";
$dbcon->_query($sqlstr);
while($list = $dbcon->_fetch_array()):
?>
        <tr>
          <td>&nbsp;
            <?=date("Y.m.d H:i", $list[Cdate]);?></td>
          <td>&nbsp;
            <?=$list[Ccredititem];?></td>
          <td>&nbsp;
            <?=number_format($list[Ccreditprice]);?></td>
          <td>&nbsp;
            <?=number_format($list[Cincomprice]);?></td>
        </tr>
        <?
endwhile;
?>
      </table>
      <br />
       </td>
  </tr>
</table>
