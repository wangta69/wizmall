<?
include "../../../lib/inc.depth3.php";
include "../../../lib/class.calendar.php";
$month	= $_GET["month"];
$mode	= $_GET["mode"];

$cal		= new calendar();
$cal->dbcon	= $dbcon;
//$month		= $cal->get_targetmonth($mode, $month);//기준 날짜로 부터 month  구하기
$workdate	= $cal->get_workcalendar($mode, $month);//작업일자(년/월)포함 데이타 구하기

$schedule	= $cal->get_schedule($workdate["time"]);
//print_r($schedule);
//Array ( [12] => Array ( [subject] => Array ( [0] => [1] => 59-4회 실행위원회 ) [schedule] => Array ( [0] => 59-4회 실행위원회 장소: 총회회의실 [1] => 59-4회 실행위원회 일시:2010년 12월 20일 시간:13:00 장소: 총회 회의실 ) ) )
//print_r($schedule);
//echo "mode:".$mode;


//echo date("Y.m.d", $workdate);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>
<? include("../../../inc/title.html");?>
</title>
<script type="text/javascript" src="../../../lib/swf.js"></script>
<script type="text/javascript" src="../../../lib/tap.js"></script>
<Script language="Javascript" src="/popup/script01.js"></Script>
<Script language="Javascript" src="/popup/script02.js"></Script>
<script language="javascript" src="/js/jquery.min.js"></script>
<link href="../../../lib/default.css" rel="stylesheet" type="text/css">
<script language="javascript">
<!--
$(function(){
	$(".btn_arrow_left").click(function(){
		location.replace('<?=$PHP_SELF?>?mode=minus&month=<?=$workdate["month"]?>');
	});
	
	$(".btn_arrow_right").click(function(){
		location.replace('<?=$PHP_SELF?>?mode=plus&month=<?=$workdate["month"]?>');
	});	
	
	$(".event").click(function(){
		var date = $(this).parent().attr("date");
		window.open("./view.php?date="+date, "calWindow", "width=300 height=200");
		//top.location.href="./view.php?date="+date;
	});
	
});
//-->
</script>
</head>
<body>
<!-- class="event" class="today" -->
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="220" class="box4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="109"><img src="../../../img/schedule.gif" width="109" height="16"></td>
          <td align="center"><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="14" align="center"><a class="btn_arrow_left hand" style="cursor:pointer"><img src="/img/arrow_left.gif" width="9" height="9"></a></td>
                <td class="day"><?=date("Y년 m월", $workdate["time"])?></td>
                <td width="14" align="center"><a class="btn_arrow_right" style="cursor:pointer"><img src="/img/arrow_right.gif" width="9" height="9"></a></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td valign="top" class="box6"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="1" cellpadding="0" id="calendar">
              <tr>
                <td><img src="/img/sun.gif" width="28" height="21"></td>
                <td><img src="/img/mon.gif" width="28" height="21"></td>
                <td><img src="/img/tue.gif" width="28" height="21"></td>
                <td><img src="/img/wed.gif" width="28" height="21"></td>
                <td><img src="/img/thu.gif" width="28" height="21"></td>
                <td><img src="/img/fri.gif" width="28" height="21"></td>
                <td><img src="/img/sat.gif" width="28" height="21"></td>
              </tr>
              <tr>
<?		  

$first_day = date('w', $workdate["time"]);

/* 요일과 날짜가 매치되지않으면 공백채우기 */
unset($count);	
for($i = 0; $i < $first_day; $i++) {
	echo " <td>&nbsp;</td>";
	$count++;
}

$total_days = date('t', $workdate["time"]);
$thisyear	= $workdate["year"];

$thismonth	= $workdate["month"];
$thisyear	= date('Y', $workdate["time"]);
$thismonth	= date('m', $workdate["time"]);
//print_r($schedule[12]);

for($j = 1; $j < $total_days; $j++) {
	//오늘 날짜이면
	$class	= "";
	$class	= date("Ymd") == $thisyear.$thismonth.sprintf("%02d", $j) ? " class='today'":"";
	//echo $thisyear.$thismonth.$j;
	$today	= $thisyear.$thismonth.$j;
	$class	= $schedule[$today]? " class='event'":$class;
?>	
              
                <td date="<?=$today?>"><a<?=$class?>><?=$j?></a></td>
<?
	$count++; //요일을 계산하여 7이 되면 tr시켜줌
	
	if($count == 7) {
		if($bgreverse == "#FFFFFF") $bgreverse = "#F2F2F2";
		else $bgreverse = "#FFFFFF";
		echo " </tr> ";
		
		if($j != $totaldays) { echo "<tr bgcolor='$bgreverse'>"; }
		unset($count);
	}
}
	
	
	
	// 달력뒤에 자리가 나오면 공백으로 채줘주기	
	while($count > 0 && $count < 7) {
		echo "<td>&nbsp;</td>";
		$count++;
	}
?>                
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td class="now" width="50">Today</td>
                <td class="now_text">
				<?
					if($schedule[date("Ymd")]){
						echo '<a href="#">'.$schedule[date("Ymd")]["subject"][0].'</a>';
					}else{
						echo '<a href="#">오늘은 행사가 없습니다.</a>';
					}
				?>
				
				</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
