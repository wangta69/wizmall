<?php
include "../common/header_pop.php";
if($uid){
$sql = "select * from wizDiary where uid = ".$uid;
$list = $dbcon->get_row($sql);
}
?>     
	<form action="" class="diarysubForm">	
		<table class="table">
			<col width="120px" />
			<col width="*" />
			<tr>
				<th>일정시간</th>
				<td>
					<select name="ScheduleHour" id="sub_ScheduleHour" class="form-control w100 inline">
<?php
$sel_hour	= date("H",$list["schedule_date"]);
$sel_minute	= date("i",$list["schedule_date"]);
$sel_second	= date("s",$list["schedule_date"]);

for($i=1; $i<25; $i++){
	$selected  = $i == $sel_hour ?" selected":"";
	echo "<option value='".$i."'".$selected.">".$i."시</option>\n";
}
?>
					</select>
					<select name="ScheduleMinute" id="sub_ScheduleMinute" class="form-control w100 inline">
<?php
for($i=0; $i<60; $i++){
	$selected  = $i == $sel_minute ?" selected":"";
	echo "<option value='".$i."'".$selected.">".$i."분</option>\n";
}
?>
					</select>
					<select name="ScheduleSecond" id="sub_ScheduleSecond" class="form-control w100 inline">
<?php
for($i=0; $i<60; $i++){
	$selected  = $i == $sel_second ?" selected":"";
	echo "<option value='".$i."'".$selected.">".$i."초</option>\n";
}
?>
					</select>
				</td>
			</tr>
			<tr>
				<th>일정제목</th>
				<td>
					<input type="text" name="schedule_title" id="sub_schedule_title" value="<?php echo $list["schedule_title"]?>"  class="form-control required" msg="제목을 넣어 주세요">
				</td>
			</tr>
			<tr>
				<th>일정내용</th>
				<td>
					<textarea name="schedule_comment" id="sub_schedule_comment" rows="4" class="form-control required" msg="내용을 넣어주세요"><?php echo $list["schedule_comment"]?></textarea>
				</td>
			</tr>
		</table>     
	
		<div class="agn_c">
			<?php if($uid):?>
			<a id="btn_save" class="btn btn-default">수정</a>
			<a id="btn_delete" class="btn btn-default">삭제</a>
			<?php else: ?>
			<a id="btn_save" class="btn btn-default">등록</a>
			<?php endif;?>
		</div>
	</form>
