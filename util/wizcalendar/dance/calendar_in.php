<?php
include "../../../lib/inc.depth3.php";

/* 특정달의 일수를 구하는 함수 */

function TotalDaysOfTheMonth($year, $month) {
	global $TheDays;
	$TheDays = 1;
	while (checkdate($month, $TheDays, $year)) {
		$TheDays++;
	}
	return $TheDays;
}

/* 특정 년 월을 구하는 함수 */
switch($mode){
	case "minus":$Month--;break;
	case "plus":$Month++;break;
	case "minusyear":$Month = $Month - 12;break;
	case "plusyear":$Month = $Month + 12;break;
	case "directMonth":
	case "view":
	case "write":
	break;
	default:unset($Month);break;	
}


$first_day = date('w', mktime(0, 0, 0, date("m") + $Month, 1, date("Y")));
$TheMonth = date('m', mktime(0, 0, 0, date("m") + $Month, 1, date("Y")));
$TheYear = date('Y', mktime(0, 0, 0, date("m") + $Month, 1, date("Y")));

TotalDaysOfTheMonth($TheYear, $TheMonth);

//일자별 색상 변경
function mkcode($day, $tag = null) {
	switch($tag) {
		case "today" :$link = "<span class='today'>" . $day . "</span>";break;
		case "event" :$link = "<span class='event'>" . $day . "</span>";break;
		case "sunday" :$link = "<span class='sunday'>" . $day . "</span>";break;
		case "saturday" :$link = "<span class='saturday'>" . $day . "</span>";break;
		default :$link = $day;break;
	}
	echo $link;
}

//금번달의 일정 리스트
function getTitle($fyear, $fmonth, $fday, $menushow) {
	$cc_Date = $fyear . "-" . $fmonth . "-" . $fday;
	$whereis = " where Schedule_Date = '" . $cc_Date . "'";
	if ($m_id != "")
		$whereis = $whereis . " and cc_m_id = '" . $m_id . "'";
	$sqlstr = "select ScheduleSubject, Schedule from wizDiary" . $whereis;
	$row = $dbcon -> get_rows($sqlstr);
}

function isData($fyear, $fmonth, $fday, $menushow) {
	$isData = false;
	$cc_Date = $fyear . "-" . $fmonth . "-" . $fday;
	$whereis = " where cc_sDate = '" . $cc_Date . "'";
	if ($m_id != "")
		$whereis = $whereis . " and cc_m_id = '" . $m_id . "'";
	$sqlstr = "select ScheduleSubject, Schedule from wizDiary" . $whereis;
	$row = $dbcon -> get_rows($sqlstr);
	if (!count($row)) {
		$isData = false;
	} else {
		$uid = $row[0]["ScheduleSubject"];
		$cc_Title = $row[0]["Schedule"];
		$isData = true;
	}
}

function getData($year, $month) {
	global $dbcon;
	$sqlstr = "select * from wizDiary where FROM_UNIXTIME(Schedule_Date, '%Y%m') = " . $year . $month;
	//echo $sqlstr;
	$rows = $dbcon -> get_rows($sqlstr);
	//print_r($rows);
	if (is_array($rows)) {
		foreach ($rows as $key => $val) {
			$day = (int)date("d", $rows[$key]["Schedule_Date"]);
			//	echo $day;
			$data[$day]["ScheduleSubject"] = $val["ScheduleSubject"];
			$data[$day]["Schedule"] = $val["Schedule"];
			$data[$day]["UID"] = $val["UID"];
		}
	}
	return $data;
}

$dataArr = getData($TheYear, $TheMonth);
//print_r($dataArr);
?>

<style type="text/css">
.style1 {	color: #FF0000;
	font-weight: bold;
}

	.today {font-weight:bold;}
	.event {font-weight:bold;color:#CC3399; cursor:pointer;}
	.sunday {color:#ff4500;}
	/*.saturday{font-weight:bold;color:#C6E746;}*/
	#cal_table tr{background-color:#FFF}
	#cal_table tr{height: 20px;}
	#cal_table td{width: 24px;}
</style>
<script>
	$(".btn_go_cal").aToolTip({
		//alert('');
		clickIt: false
	});
	
	//$(".btn_go_cal").click(function(){
	$(document).on("click", ".btn_go_cal",  function(){
		var uid		= $(this).attr("uid");
		var day		= $(this).attr("day");
		var url = "./view.php?date=<?php echo $TheYear; ?><?php echo $TheMonth; ?>"+day;
		$(this).popup({url:url});
	});
	
	
	$(document).on(".scheduleyear", "change", function(){
		var year	= $(this).val() - <?=date("Y")?>;
		var eMonth	= year*12 + parseInt($("#cMonth").val() - <?=date("m")?>);
		$("#eMonth").val(eMonth);
		$.post(calenar_url, $("#directMonth").serialize(), function(data){
			$("#calendarHTML").html(data);
		});
	});

</script>
<form id="directMonth">
	<input type="hidden" name="mode" value="directMonth">
	<input type="hidden" id="cMonth" value="<?php echo date('m', mktime(0, 0, 0, date("m") + $Month, date("d"), date("Y"))); ?>">
	<input type="hidden" name="Month" id="eMonth" value="">
</form>
<table width="250" height="118" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="89" height="26" align="center"> <?php echo date('Y년', mktime(0, 0, 0, date("m") + $Month, date("d"), date("Y"))); ?><span class="style1"><?php echo date('m', mktime(0, 0, 0, date("m") + $Month, date("d"), date("Y"))); ?></span>월 </td>
    <td width="156"><img src="/images/h_cal_t.gif" width="169" height="21"></td>
  </tr>
  <tr>
    <td align="center" valign="top"><img src="/images/h_cal_t2.gif" width="82" height="74" border="0"><br>
        <a href="/board/board4.php"><img src="/images/h_cal_b.gif" width="63" height="19" vspace="5" border="0"></a> <br>
    </td>
    <td align="center" valign="top"><table border="0" cellpadding="1" cellspacing="1" bgcolor="#efefef" id="cal_table">
<tr>
<?php

/* 요일과 날짜가 매치되지않으면 공백채우기 */

unset($count);
for($i = 0; $i < $first_day; $i++) {
echo " <td>&nbsp;</td>";
$count++;
}

for($j = 1; $j < $TheDays; $j++) {
//$d_data	= getData($year, $month);
$k	= sprintf("%02d", $j);
//echo $k;

		?>
		<td <?php
		if ($dataArr[$j]) { echo "uid='" . $dataArr[$j]["UID"] . "' title='" . $dataArr[$j]["ScheduleSubject"] . "' day='" . str_pad($j, 2, "0", STR_PAD_LEFT) . "' class='btn_go_cal'";
		}
		?>>
		<?php
		/* $ThedayThetime은 카렌다의 모든 시간들을 유닉스 시간으로 변경한다. */
		$ThedayThetime = mktime(date("H"), date("i"), date("s"), date("$TheMonth"), date("$j"), date("$TheYear"));
		if (date("Ymd") == $TheYear . $TheMonth . $k)
			mkcode($j, "today");
		else if ($dataArr[$j])
			mkcode($j, "event");
		elseif (!($count % 7))
			mkcode($j, "sunday");
		elseif (($count % 7)==6)
			mkcode($j, "saturday");
		else
			mkcode($j);
		//echo $TheYear.$TheMonth.$j;
		?>
		</td>
		<?php
		$count++;
		//요일을 계산하여 7이 되면 tr시켜줌

		if ($count == 7) {
			if ($j != $totaldays) { echo "<tr>";
			}
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
</table>
