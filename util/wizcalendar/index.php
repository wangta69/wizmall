<?
include ("../../lib/cfg.common.php");
include ("../../config/db_info.php");

include "../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);

include "../../lib/class.common.php";
$common = new common();
?>
<html>
<head>
<title>wizCalendar ver.1.2</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>" />
<style type="text/css">
<!--
a:link {  font-family: "굴림", "굴림체"; font-size: 9pt; color: 5D5D5D; text-decoration: none}
a:visited {  font-family: "굴림", "굴림체"; font-size: 9pt; color: #666666; text-decoration: none}
a:active {  font-family: "굴림", "굴림체"; font-size: 9pt; color: #E50101; text-decoration: underline}
a:hover {  font-family: "굴림", "굴림체"; font-size: 9pt; color: E50101; text-decoration: underline}
.txt {  font-family: "굴림", "굴림체"; font-size: 9pt; color: #333333; line-height: 15pt}
BODY, TEXTAREA,TABLE, TR, TD, INPUT{font-size:12px; font-family:굴림;}
a:link,a:visited,a:hover {color: #ffffff; text-decoration: none}
a.com:link,a.com:visited {color: #000000; text-decoration: none}
a.pro:hover {  color: #869603; text-decoration: underline}
a.inq:hover {  color: #489CE7; text-decoration: underline}
a.bro:hover {  color: #21B686; text-decoration: underline}
a.site:hover {  color: #CC3333; text-decoration: underline}
-->
</style>
<style type="text/css">
<!--
a.com:hover { color: #000000} -->
</style>
</head>
<body>

<?

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
}else if(!strcmp($mode,"plus")){
$Month++;
}else if(!strcmp($mode,"minusyear")){
$Month=$Month-12;
}else if(!strcmp($mode,"plusyear")){
$Month=$Month+12;
}else if(!strcmp($mode,"view")){
}else if(!strcmp($mode,"write")){
}else unset($Month);

$first_day = date('w', mktime(0,0,0,date("m")+$Month,1,date("Y")));
$TheMonth = date('m', mktime(0,0,0,date("m")+$Month,1,date("Y")));
$TheYear = date('Y', mktime(0,0,0,date("m")+$Month,1,date("Y")));
TotalDaysOfTheMonth($TheYear, $TheMonth);

if(!$ThedayThetime_value && !$Month) $ThedayThetime_value = time();
else if(!$ThedayThetime_value) $ThedayThetime_value = mktime(0,0,0,date("m")+$Month,date("d"),date("Y"));
?>
<?
echo date("Y.m.d H:i:s", $ThedayThetime_value);
?>
<table border="0" cellpadding="0" cellspacing=0 bordercolorlight=#CEE1FF  bordercolordark=#E1FFFD  align="center" width="344">
  <tr> 
          <td height="25" colspan=7 align="center" bgcolor="#CC3333"><font color="#FFFFFF"><a href="javascript:void(location.replace('<?=$PHP_SELF?>?mode=minusyear&Month=<?=$Month?>'))">◁◁</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(location.replace('<?=$PHP_SELF?>?mode=minus&Month=<?=$Month?>'))">◁</a>&nbsp; 
            <?=date('Y', mktime(0,0,0,date("m")+$Month,date("d"),date("Y")));?>
            년 
            <?=date('m', mktime(0,0,0,date("m")+$Month,date("d"),date("Y")));?>
            월 
            <?=date('M', mktime(0,0,0,date("m")+$Month,date("d"),date("Y")));?>
            &nbsp; <a href="javascript:void(location.replace('<?=$PHP_SELF?>?mode=plus&Month=<?=$Month?>'))">▷</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(location.replace('<?=$PHP_SELF?>?mode=plusyear&Month=<?=$Month?>'))">▷▷</a></font></td>
        </tr>
        <tr bgcolor=#FFFFFF> 
          <td height="26" colspan="7" align="center">&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25" colspan="7" align="right"><a href="javascript:void(location.replace('<?=$PHP_SELF?>'))" class="com">Go 
            Today</a></td>
        </tr><tr><td>
<!-- 날짜 테이블 시작 -->				
        <table border="0" cellpadding="0" cellspacing=1 bordercolorlight=#CEE1FF  bordercolordark=#E1FFFD  align="center"  bgcolor=#CCCCCC width="100%"><tr> 
          <td width="48" height="25" align="center" bgcolor="#F2F2F2"><font color="#FF0000">Sun</font></td>
          <td width="48" align="center" bgcolor="#F2F2F2">Mon</td>
          <td width="48" align="center" bgcolor="#F2F2F2">Tue</td>
          <td width="48" align="center" bgcolor="#F2F2F2">Wed</td>
          <td width="48" align="center" bgcolor="#F2F2F2">Thu</td>
          <td width="48" align="center" bgcolor="#F2F2F2">Fri</td>
          <td width="48" align="center" bgcolor="#F2F2F2">Sat</td>
        </tr>
        <tr> 
<?		  
/* 요일과 날짜가 매치되지않으면 공백채우기 */
unset($count);	
for($i = 0; $i < $first_day; $i++) {
echo " <td bgcolor=#FFFFFF>&nbsp;</td>";
$count++;
}

for($j = 1; $j < $TheDays; $j++) {
$k = substr("0".$j, -2);
$ThedayThetime = mktime(date("H"),date("i"),date("s"),date("$TheMonth"),date("$j"),date("$TheYear"));
?>
<td height="40" valign="top" bgcolor=#FFFFFF style=padding-top:2pt;padding-left:2pt;>
<a href="javascript:void(location.replace('<?=$PHP_SELF?>?Month=<?=$Month?>&ThedayThetime_value=<?=$ThedayThetime?>'))">
<?
/* $ThedayThetime은 카렌다의 모든 시간들을 유닉스 시간으로 변경한다. */
if ( date("Ymd") == $TheYear.$TheMonth.$k ) {  // 오늘 날짜랑 같으면 ff0000색으로 표시 
 echo "<font style='color:#0000FF; text-decoration:none;'><b>$j</b><font>"; 
}elseif(!($count%7)){//일요일은 붉은색으로 표시
echo "<font style='color:#FF0000; text-decoration:none;'>$j<font>"; 
}else { echo "<font style='color:#000000; text-decoration:none;'>$j<font>"; } 
?>
</a>
</td>
<?
$count++; //요일을 계산하여 7이 되면 tr시켜줌
		if($count == 7) {
			echo " </tr> ";
			if($j != $totaldays) { echo "<tr>"; }
			unset($count);
		}
	}

// 달력뒤에 자리가 나오면 공백으로 채줘주기	
	while($count > 0 && $count < 7) {
		echo "<td bgcolor=#ffffff>&nbsp;</td>";
		$count++;
	}
?>

        </tr></table>
<!-- 날짜 테이블 끝 -->
</td></tr></table>

</body>

</html>