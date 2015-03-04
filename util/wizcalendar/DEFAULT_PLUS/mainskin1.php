<?
include "../../../lib/inc.depth3.php";

/* 특정달의 일수를 구하는 함수 */

function TotalDaysOfTheMonth($year,$month) {

global $TheDays;

	$TheDays = 1;

	while(checkdate($month,$TheDays,$year)) {

		$TheDays++;

	}

	return $TheDays;

}



/* 특정 년 월을 구하는 함수 */

if(!strcmp($mode,"minus")){

$Month--;
}
elseif(!strcmp($mode,"plus")){
$Month++;
}
elseif(!strcmp($mode,"minusyear")){
$Month=$Month-12;
}
elseif(!strcmp($mode,"plusyear")){
$Month=$Month+12;
}
elseif(!strcmp($mode,"view")){

}
elseif(!strcmp($mode,"write")){

}
else unset($Month);

$first_day = date('w', mktime(0,0,0,date("m")+$Month,1,date("Y")));

$TheMonth = date('m', mktime(0,0,0,date("m")+$Month,1,date("Y")));

$TheYear = date('Y', mktime(0,0,0,date("m")+$Month,1,date("Y")));

TotalDaysOfTheMonth($TheYear, $TheMonth);

?>
<table width="178" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td><img src="images/left_menu01.gif" width="178" height="38"></td>
                    </tr>
                    <tr> 
                      <td background="images/left_back01.gif"><table width="164" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td height="33" background="images/left01_top.gif"><div align="center"><span style="font-size:12px; color:#07475E;"><?=date('Y', mktime(0,0,0,date("m")+$Month,date("d"),date("Y")));?>년 
                                <?=date('m', mktime(0,0,0,date("m")+$Month,date("d"),date("Y")));?>월 </span><span style="font-size:11px; color:#666666;"><?=date('F', mktime(0,0,0,date("m")+$Month,date("d"),date("Y")));?></span></div></td>
                          </tr>
                          <tr> 
                            <td><table width="164" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td width="1px" bgcolor="#dddddd"></td>
                                  <td valign="top"> <table width="162" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td height="18"> <div align="center"><span style="font-size: 11px; color: #666666;">일</span></div></td>
                      <td><div align="center"><span style="font-size: 11px; color: #666666;">월</span></div></td>
                      <td><div align="center"><span style="font-size: 11px; color: #666666;">화</span></div></td>
                      <td><div align="center"><span style="font-size: 11px; color: #666666;">수</span></div></td>
                      <td><div align="center"><span style="font-size: 11px; color: #666666;">목</span></div></td>
                      <td><div align="center"><span style="font-size: 11px; color: #666666;">금</span></div></td>
                      <td><div align="center"><span style="font-size: 11px; color: #666666;">토</span></div></td>
                    </tr>
                    <tr> 
                      <td height="1px" colspan="7" bgcolor="#dddddd"></td>
                    </tr>
                    <?
$bgreverse = "#F2F2F2";
?>
                    <tr bgcolor="<?=$bgreverse?>">
                      <?		  

/* 요일과 날짜가 매치되지않으면 공백채우기 */

unset($count);	
for($i = 0; $i < $first_day; $i++) {
echo " <td>&nbsp;</td>";
$count++;
}

for($j = 1; $j < $TheDays; $j++) {
?>
                      <form>
<?
/* $ThedayThetime은 카렌다의 모든 시간들을 유닉스 시간으로 변경한다. */
$ThedayThetime = mktime(date("H"),date("i"),date("s"),date("$TheMonth"),date("$j"),date("$TheYear"));
?>					  
<?
if ( date("Ymd") == $TheYear.$TheMonth.$j )
$Bgimg = " background=\"images/left01_03.gif\"";
else $Bgimg = "";

?>					  
                        <td height="17"<?=$Bgimg?>>
                          <a href="javascript:void(location.replace('./?mode=view&ThedayThetime_value=<?=$ThedayThetime?>'))"> 
<?
/* $ThedayThetime은 카렌다의 모든 시간들을 유닉스 시간으로 변경한다. */
$ThedayThetime = mktime(date("H"),date("i"),date("s"),date("$TheMonth"),date("$j"),date("$TheYear"));
 if ( date("Ymd") == $TheYear.$TheMonth.$j ) {  // 오늘 날짜랑 같으면 ff0000색으로 표시 

  echo "<font style='color:#FFFFFF; text-decoration:none;'><b>$j</b><font>"; 

}elseif(!($count%7)){
echo "<font style='color:#FF0000; text-decoration:none;'>$j<font>"; 
}else { echo "<font style='color:#000000; text-decoration:none;'>$j<font>"; } 
?>
                          </a> <input type="hidden" name="ThedayThetime" value="<?=$ThedayThetime?>"> 
                        </td>
                      </form>
                      <?
$count++; //요일을 계산하여 7이 되면 tr시켜줌

		if($count == 7) {
if($bgreverse == "#FFFFFF") $bgreverse = "#F2F2F2";
else $bgreverse = "#FFFFFF";

			echo " </tr><tr><td height=\"1px\" colspan=\"7\" background=\"images/line_width01.gif\"></td></tr> ";

			if($j != $totaldays) { echo "<tr bgcolor='$bgreverse'>"; }

			unset($count);

		}

	}



// 달력뒤에 자리가 나오면 공백으로 채줘주기	

	while($count > 0 && $count < 7) {

		echo "<td bgcolor=#ffffff>&nbsp;</td>";

		$count++;

	}



?>
                    </tr>
                  </table></td>
                                  <td width="1px" bgcolor="#dddddd"></td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr> 
                            <td><img src="images/left01_01.gif" width="164" height="35"></td>
                          </tr>
                          <tr> 
                            <td valign="top"> <table width="164" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td width="1px" bgcolor="#dddddd"></td>
                                  <td width="10" valign="top">&nbsp;</td>
                                  <td valign="top">
<?
$FirstTheDay = mktime(0,0,0,date("m"),date("d"),date("Y"));
$LastTheDay = mktime(0,0,0,date("m"),date("d")+1,date("Y"));

$sqlstr = "select * from wizDiary where Schedule_Date < '$LastTheDay' AND Schedule_Date > '$FirstTheDay' order by Schedule_Date ASC";
$qry	= $dbcon->_query($sqlstr);
while($list=$dbcon->_fetch_array($qry)):
?>								  
								  <span style="font-size:11px; color:#666666;"><?=date("H:i", $list[Schedule_Date])?> <?=$list[Schedule]?></span><br> 
<?
endwhile;
?>								  
</td>
                                  <td width="1px" bgcolor="#dddddd"></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr> 
                      <td><img src="images/left_bottom01.gif" width="178" height="14"></td>
                    </tr>
                  </table>