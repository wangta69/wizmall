<?php
/*
 powered by 폰돌
 Reference URL : http://www.shop-wiz.com
 Contact Email : master@shop-wiz.com
 Free Distributer :
 Copyright shop-wiz.com
 *** Updating List ***
 */

if ($mgrade == "")
    $mgrade = 10;

$selectYear = $selectYear ? $selectYear : date("Y");
$selectMonth = $selectMonth ? $selectMonth : date("m");
$selectDay = $selectDay ? $selectDay : date("d");
$unixtime = mktime(0, 0, 0, $selectMonth, $selectDay, $selectYear);
$thisyear = date("Y", $unixtime);
$thismonth = date("m", $unixtime);
$thisday = date("d", $unixtime);

#step 1 : 전체 데이터
$sqlstr = "SELECT COUNT(*) FROM " . $WIZTABLE["MEMBER"];
$totalmember = $dbcon -> get_one($sqlstr);

#step 2 : 검색

if (!$year)
    $year = date('Y');
if (!$month)
    $month = date('m');
if (!$day)
    $day = date('d');
if (!$mode)
    $mode = "month";
?>
<script  language="javascript" src="../js/jquery.plugins/jquery.wizchart-1.0.3.js"></script>
<script>
$(function(){
    $(".uniquebar").chart({ height:5,bgcolor:"blue"});
});

	function ModeChange(mode) {
		document.logform.mode.value = mode;
		document.logform.submit();
	}
</script>
<div class="table_outline">
	<div class="panel panel-success">
		<div class="panel-heading">
			회원가입통계
		</div>
		<div class="panel-body">
			회원가입통계입니다.
		</div>
	</div>

	총 가입자수 : <?php echo (int)$totalmember ?>
	<form name='logform' action='<?php echo $PHP_SELF ?>' method='get'>
		<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
		<input type="hidden" name='mode' value='<?php echo $mode; ?>'>
		<input type="hidden" name='menushow' value='<?php echo $menushow; ?>'>
		<input type="hidden" name='theme' value='<?php echo $theme; ?>'>
		<table class="table">
			<tr>
				<td>
				<tr bgcolor='#F2F2F2'>
					<td>&nbsp;
					<select name="mgrade">
						<?php
                        foreach ($AdminGradeArr as $key => $value) {
                            $selected = $mgrade == $key ? "selected" : "";
                            echo "<option value='$key' $selected>$value</option>\n";
                        }
						?>
					</select>
					<select name="selectYear">
						<?php
                        for ($i = 2006; $i <= $thisyear; $i++) {
                            $selected = $i == $selectYear ? "selected" : "";
                            echo "<option value='$i' $selected>$i</option>\n";
                        }
						?>
					</select>
					<select name="selectMonth">
						<?php
                        for ($i = 1; $i <= 12; $i++) {
                            $selected = $i == $selectMonth ? "selected" : "";
                            echo "<option value='" . sprintf("%02d", $i) . "' $selected>" . sprintf("%02d", $i) . "</option>\n";
                        }
						?>
					</select>
					<select name="selectDay">
						<?php
                        for ($i = 1; $i <= 31; $i++) {
                            $selected = $i == $selectDay ? "selected" : "";
                            echo "<option value='" . sprintf("%02d", $i) . "' $selected>" . sprintf("%02d", $i) . "</option>\n";
                        }
						?>
					</select>
					<input type="submit" name="Submit" value="확인">
					<input name="button" type=button style='width:40;<?php
                        if ($mode == "month")
                            echo "background:#0B9BFF;color:#FFFFFF;'";
                    ?>' onClick="ModeChange('month')" value='월별'>
					<input type=button value='일별' style='width:40;<?php
                        if ($mode == "day")
                            echo "background:#0B9BFF;color:#FFFFFF;'";
                    ?>' onClick="ModeChange('day')">
					<input type=button value='시간' style='width:40;<?php
                        if ($mode == "hour")
                            echo "background:#0B9BFF;color:#FFFFFF;'";
                    ?>' onClick="ModeChange('hour')">
					<input type=button value='요일' style='width:40;<?php
                        if ($mode == "weekday")
                            echo "background:#0B9BFF;color:#FFFFFF;'";
                    ?>' onClick="ModeChange('weekday')">
					</td>
				</tr>
		</table>
	</form>

	<table class="table">
	    <col width="50px" />
	    <col width="*" />
		<?php

		$total_count=0;
		switch ($mode)
		{
		case "month" :
		$end = 12;
		$ment = '월';
		for($i=0; $i<=$end; $i++){
		$startdate = mktime(0,0,0,$i,1, $thisyear);
		$enddate = mktime(0,0,-1,$i+1,1, $thisyear);
		$sqlstr = "SELECT count(*) FROM ".$WIZTABLE["MEMBER"]."  WHERE mgrade='$mgrade' and mregdate between $startdate and $enddate";
		$regcnt[$i] = $dbcon->get_one($sqlstr);
		$total_count += $regcnt[$i];
		}
		break;
		case "day" :
		$end = 31;
		$ment = "일";
		for($i=0; $i<=$end; $i++){
		$startdate = mktime(0,0,0,$thismonth,$i, $thisyear);
		$enddate = mktime(0,0,-1,$thismonth,$i+1, $thisyear);
		$sqlstr = "SELECT count(*) FROM ".$WIZTABLE["MEMBER"]."  WHERE mgrade='$mgrade' and mregdate between $startdate and $enddate";
		$regcnt[$i] = $dbcon->get_one($sqlstr);
		$total_count += $regcnt[$i];
		}
		break;
		case "hour" :
		$end = 23;
		$ment = "시";
		for($i=0; $i<=$end; $i++){
		$startdate = mktime($i,0,0,$thismonth,$thisday, $thisyear);
		$enddate = mktime($i+1,0,-1,$thismonth,$thisday, $thisyear);
		$sqlstr = "SELECT count(*) FROM ".$WIZTABLE["MEMBER"]." WHERE mgrade='$mgrade' and mregdate between $startdate and $enddate";
		$regcnt[$i] = $dbcon->get_one($sqlstr);
		$total_count += $regcnt[$i];
		}
		break;
		case "weekday" :
		$end = 7;
		$ment = "시";
		$w = date(w, mktime(0,0,0,$thismonth, $thisday, $thisyear));
		$thisday = $thisday-$w;
		for($i=0; $i<=$end; $i++){
		$startdate = mktime(0,0,0,$thismonth,$thisday+$i, $thisyear);
		$enddate = mktime(0,0,-1,$thismonth,$thisday+$i+1, $thisyear);
		$sqlstr = "SELECT count(*) FROM ".$WIZTABLE["MEMBER"]." WHERE mgrade='$mgrade' and mregdate between $startdate and $enddate";
		$regcnt[$i] = $dbcon->get_one($sqlstr);
		$total_count += $regcnt[$i];
		}
		break;
		}

		function t_week($cnt)
		{
		global $mode;
		global $ment;
		if($mode != "weekday") return $cnt.$ment;

		switch($cnt)
		{
		case 1: return "일";
		case 2: return "월";
		case 3: return "화";
		case 4: return "수";
		case 5: return "목";
		case 6: return "금";
		case 7: return "토";
		}
		}

		if(!$total_count) $total_count = 1;
		for($i=1; $i <= $end ; $i++){
		$per = round(100*$regcnt[$i]/$total_count);
		$re_per = 65*$per/10;
		?>
		<tr>
			<td>
			<a onClick="MonthChange('01')"> <?php echo t_week($i) ?> </a></td>
			<td>
			    <div  ratio="<?php echo $per ?>" class="uniquebar"></div>
			    <?php echo (int)$regcnt[$i] ?>
			&nbsp;&nbsp; (
			<?php echo $per ?>
			%) </td>
		</tr>
		<?} ?>
	</table></td>
	</tr>
	</table>
</div>