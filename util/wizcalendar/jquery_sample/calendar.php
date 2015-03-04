<?php
include_once "../../../lib/inc.depth3.php";
include_once "../../../lib/class.calendar.php";
$cal	= new calendar();
$cal->dbcon	= $dbcon;	

$cal->setMonth(array("mode"=>$_POST["mode"], "month"=>$_POST["month"]));//현재 년월일로 세팅
$cal->getsetDate();//현재 서런된 일/월/년 생성
//$cal->category = $category;
$cal->getData(); //등록된 데이타 불러오기
?>
<style>
	.today {font-weight:bold;}
	.event {font-weight:bold;color:#CC3399; cursor:pointer;}
	.sunday {font-weight:bold;color:#AE090F;}
	.saturday{font-weight:bold;color:#C6E746;}
	#cal_table tr{height: 50px;}
	#cal_table td{width: 50px;}
</style>
<script>

	$(".btn_go_cal").aToolTip({
		//alert('');
		clickIt: false
	});
	
	$(document).on("click", ".btn_go_cal",  function(){
		var uid		= $(this).attr("uid");
		var day		= $(this).attr("day");
		var url		= "";
		if(uid){
			url = "./view.php?uid="+uid;
		}else if(day){
			url = "./view.php?date=<?php echo date("Ym", $cal->setDate);?>"+day;
		}
		
		if(url)	$(this).popup({url:url});
	});
	
	
	$(document).on("change", ".scheduleyear", function(){
		var year	= $(this).val() - <?php echo date("Y")?>;
		var eMonth	= year*12 + parseInt(<?php echo date("m", $cal->setDate) - date("m")?>);
		$("#cal_month").val(eMonth);
		$("#cal_mode").val("directMonth");
		$.post(calenar_url, $("#cal_move").serialize(), function(data){
			$("#calendarHTML").html(data);
		});
	});

</script>


		<form id="cal_move">
			<input type="hidden" name="mode" id="cal_mode" value="">
			<input type="hidden" name="month" id="cal_month" value="">
			<input type="hidden" name="catetory" id="cal_month" value="<?php echo $category; ?>">
		</form>

		<div class="month-box" style="width:680px">

		<p class="arrow">
		<a href="javascript:gotoCalendar('minus', '<?php echo $cal->month;?>')">이전달</a>
		<span class="sch-month"> <?php echo date("m", $cal->setDate);?></span>
		<a href="javascript:gotoCalendar('plus', '<?php echo $cal->month;?>')">다음달</a>
		<select name="select" class="scheduleyear">
<?php
for ($i = 2010; $i < date("Y") + 2; $i++) {
	$selected = $i == date('Y', mktime(0, 0, 0, date("m") + $cal->month, date("d"), date("Y"))) ? " selected='selected'" : "";
	echo "<option value='" . $i . "'" . $selected . ">" . $i . "</option>\n";
}
?>
</select>
</p>
</div>

<table id="cal_table">
	<tr>
	<td class="sun">Sun</td>
	<td class="mon">Mon</td>
	<td class="tue">Tue</td>
	<td class="wed">Wed</td>
	<td class="thu">Thu</td>
	<td class="fri">Fri</td>
	<td class="sat">Sat</td>
	</tr>

	<tr>
<?php
/* 요일과 날짜가 매치되지않으면 공백채우기 */
unset($count);
for($i = 0; $i < date("w", $cal->setDate); $i++) {
	echo " <td>&nbsp;</td>";
	$count++;
}

for($j = 1; $j < $cal->getDays(); $j++) {
//$d_data	= getData($year, $month);
//$k	= sprintf("%02d", $j);
//echo $k;

?>
		<td <?php if ($cal->setData[$j]) { echo "title='" . $cal->setData[$j]["schedule_title"] . "' class='btn_go_cal'";}?>>
		<?php
		/* $ThedayThetime은 카렌다의 모든 시간들을 유닉스 시간으로 변경한다. */
		//$ThedayThetime = mktime(date("H"), date("i"), date("s"), date($cal->setDate["m"]), date($j), date($cal->setDate["Y"]));
		echo $cal->mkcode($j, $count);
		echo $cal->displaytitle($j);
		
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
		</table>

