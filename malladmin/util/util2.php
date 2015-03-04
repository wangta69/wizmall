<?php
include "../lib/class.calendar.php";
$cal	= new calendar();
$cal->dbcon	= $dbcon;
$cal->cfg	= $cfg;

if(!strcmp($query,"save")){
	$cal->save_schedule();
}else if(!strcmp($query,"delete")){
	$cal->delete_schedule();
}
$cal->setMonth(array("mode"=>$_GET["mode"], "month"=>$_GET["month"]));//현재 년월일로 세팅
$cal->getsetDate();//현재 서런된 일/월/년 생성
$cal->getData(); //등록된 데이타 불러오기
?>
<script type="text/javascript" src="../js/jquery.plugins/jquery.validator.js"></script>
<script>
$(function(){
	//일정 등록 / 수정
	var sel_day	= '<?php echo $sel_day;?>';
	//$("#btn_save").click(function(){
	$(document).on("click", "#btn_save", function(){
		if($('.diarysubForm').formvalidate()){
			$("#diaryForm_query").val("save");
			
			$("#id_ScheduleHour").val($("#sub_ScheduleHour").val());
			$("#id_ScheduleMinute").val($("#sub_ScheduleMinute").val());
			$("#id_ScheduleSecond").val($("#sub_ScheduleSecond").val());
			$("#id_schedule_title").val($("#sub_schedule_title").val());
			$("#id_schedule_comment").val($("#sub_schedule_comment").val());
			$(".diaryForm").submit();
		}
	});
	
	//일정 삭제
	//$("#btn_delete").click(function(){
	$(document).on("click", "#btn_delete", function(){
		if(confirm('삭제된 데이타는 복구되지 않습니다.\n삭제하시겠습니까?')){
			$("#diaryForm_query").val("delete");
			$(".diaryForm").submit();
		}
			
	});
	
	$(".btn_go_modify").click(function(){
		var uid	= $(this).attr("uid");
		$("#id_uid").val(uid);
		loadwriteForm(uid);
	});
	
	if(sel_day) loadwriteForm("");
	
});

function loadwriteForm(uid){
	if(typeof(uid) == "undefined") uid = "";
	$.post("./util/util2_diary_write.php", {uid:uid}, function(data){
		$("#diary_form_wirte").html(data);
	});
}
//스케쥴에서 클릭시 write 모드 디스플레이
function gotoWrite(d, uid){	
	var url = "<?php echo $PHP_SELF?>?month=<?php echo $cal->month;?>&mode=write&sel_day="+d;
	if(typeof(uid) != "undefined") url = url + "&uid="+uid;
	$("#sform").attr("action", url);
	$("#sform").submit();
}

//년/월 변경시
function gotoCalendar(mode){
	var url = "<?php echo $PHP_SELF?>?month=<?php echo $cal->month;?>&mode="+mode;
	$("#sform").attr("action", url);
	$("#sform").submit();
}
</script>
<form id="sform" method="post" action="">
	<input type='hidden' name='menushow' value='<?php echo $menushow?>'>
	<input type="hidden" name="theme" value="<?php echo $theme;?>">
</form>
<div class="table_outline">
	<div class="panel panel-success">
		<div class="panel-heading">일정관리</div>
		<div class="panel-body">
		원하시는 날짜를 클릭하신 후 메모를 넣어주세요
		</div>
	</div>

	<div class="text-center">
		<a href="javascript:gotoCalendar('minusyear')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-fast-backward"></span> </a>
		<a href="javascript:gotoCalendar('minus')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-step-backward"></span> </a>
		<h4 style="display: inline">
			<?php echo date("Y년 m월 M", $cal->setDate);?>
		</h4>
		<a href="javascript:gotoCalendar('plus')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-step-forward"></span></a>
		<a href="javascript:gotoCalendar('plusyear')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-fast-forward"></span> </a>
	</div>

	<table class="table">
		<col width="107px" />
		<col width="107px" />
		<col width="107px" />
		<col width="107px" />
		<col width="107px" />
		<col width="107px" />
		<col width="107px" />
		<tr>
			<th>Sun</th>
			<th>Mon</th>
			<th>Tue</th>
			<th>Wed</th>
			<th>Thu</th>
			<th>Fri</th>
			<th>Sat</th>
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
$k	= sprintf("%02d", $j);
//echo $k;

?>
				<td valign="top">
					
<?php
	echo '<a href="javascript:gotoWrite(\''.$j.'\')">'.$k.'</a>';
	echo $cal->displaytitle($j, "admin");
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


<?php
if($sel_day):
	$sql = "select * from wizDiary where DATE_FORMAT(FROM_UNIXTIME(schedule_date), '%Y%m%d') = '".date("Ym", $cal->setDate).sprintf("%02d", $sel_day)."' order by schedule_date asc";
	$list	= $dbcon->get_rows($sql);
?>
	<div class="agn_c" ><?php echo date("Y년 m월", $cal->setDate); ?> <?php echo $sel_day; ?>일 나의 스케쥴</div>
	<table class="table">
		<col width="150px" />
		<col width="*" />
		<col width="100px" />
		<tr>
			<th>시간</th>
			<th>일정</th>
			<th></th>
		</tr>
<?php
	if(is_array($list)) foreach($list as $key => $val){
?>
		<tr>
			<td>
				<?php echo date("Y.m.d H:i:s", $val["schedule_date"])?>
			</td>
			<td class="agn_l">
				<?php echo $val["schedule_title"]?$val["schedule_title"]:"no subject";?>
				
			</td>
			<td class="agn_l">
				<button type="button" class="btn btn-primary btn-xs btn_go_modify" uid="<?php echo $val["uid"];?>">수정</button>
			</td>
		</tr>
<?php
}else{
?>
		<tr>
			<td colspan="3">등록된 일정이 없습니다.</td>
		</tr>
<?php
}//if(is_array($list)) foreach($list as $key => $val){
?>
	</table>
	<form action="" class="diaryForm" method="post">
		<input type='hidden' name='menushow' value='<?php echo $menushow?>' />
		<input type="hidden" name="theme" value="<?php echo $theme;?>" />
		
		<input type="hidden" name="month" value="<?php echo $month;?>" />
		<input type="hidden" name="sel_year" value="<?php echo date("Y", $cal->setDate); ?>" />
		<input type="hidden" name="sel_month" value="<?php echo date("m", $cal->setDate); ?>" />
		<input type="hidden" name="sel_day" value="<?php echo $sel_day;?>" />
		<input type="hidden" name="mode" value="<?php echo $mode;?>" />
		<input type="hidden" name="query" id="diaryForm_query" value="" />
		<input type="hidden" name="uid" id="id_uid" value="<?php echo $uid?>" />
		
		<input type="hidden" name="ScheduleHour" id="id_ScheduleHour" />
		<input type="hidden" name="ScheduleMinute" id="id_ScheduleMinute" />
		<input type="hidden" name="ScheduleSecond" id="id_ScheduleSecond" />
		<input type="hidden" name="schedule_title" id="id_schedule_title" />
		<input type="hidden" name="schedule_comment" id="id_schedule_comment" />
	
	</form>
	<div id="diary_form_wirte"></div>

<?php
endif;//if($sel_day):
?>
</div>