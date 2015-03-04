<?php
if ($action == 'detail_search') {
    $FromDate = mktime(0, 0, 0, $SMonth, $SDay, $SYear);
    $ToDate = mktime(0, 0, 0, $FMonth, $FDay, $FYear);
    if ($WHEREIS)
        $WHEREIS = "$WHEREIS AND m.mregdate >= '$FromDate' AND m.mregdate <= '$ToDate'";
    else
        $WHEREIS = "WHERE m.mregdate >= '$FromDate' AND m.mregdate <= '$ToDate'";
}
if (!$WHEREIS)
    $WHEREIS = "WHERE UID";
//------------------------- 전체
$TOTAL_DATA_NUM = $dbcon -> get_one("SELECT count(*) FROM wizMembers m $WHEREIS");
$TOTAL_DATA_NUM1 = $dbcon -> get_one("SELECT count(*) FROM wizMembers m");
//------------------------- 전체
?>

<script language="javascript" src="../js/jquery.plugins/jquery.wizchart-1.0.3.js"></script>
<script>
$(function(){
    $(".uniquebar").chart({ height:5,bgcolor:"blue"});
});

	function show() {
        window.location.href = "<? echo $PHP_SELF; ?>?menushow=<?php echo $menushow ?>&theme=statistic4&action=term_search&howpay=&mem=member";
	}
	function show1() {
	   window.location.href = "<?php echo $PHP_SELF; ?>?menushow=<?php echo $menushow ?>&theme=statistic6&action=term_search&add=&mem=member";
	}
</script>

<div class="table_outline">
	<div class="panel panel-success">
		<div class="panel-heading">
			지역별 회원현황
		</div>
		<div class="panel-body">
			등록 지역별 회원 현황을 파악하실 수 있습니다.
		</div>
	</div>


		<table class="table">
			<col width="80" />
			<col width="80" />
			<col width="80" />
			<col width="80" />
			<col width="*" />
			<thead>
				<tr class="altern">
					<th rowspan=2>지역</th>
					<th colspan=2>성별</th>
					<th rowspan=2>합계</th>
					<th rowspan=2>그래프</th>
				</tr>
				<tr>
					<th>남성</th>
					<th>여성</th>
				</tr>
			</thead>
			<tbody>
<?php
$ADD_ARRAY = array("서울","부산","대구","인천","광주","대전","울산","경기","강원","충북","충남","경북","경남","전북","전남","제주");
for ($i = 0; $i < sizeof($ADD_ARRAY); $i++) {
//echo " $WHEREIS <br />";
$sqlstr = "SELECT count(*) FROM wizMembers m left join wizMembers_ind i on m.mid = i.id $WHEREIS AND left(i.jumin2, 1) = '1' AND substring(i.address1, 1, 2) = '$ADD_ARRAY[$i]'";
$manCnt = $dbcon->get_one($sqlstr); //남자

$sqlstr = "SELECT count(*) FROM wizMembers m left join wizMembers_ind i on m.mid = i.id $WHEREIS AND left(i.jumin2, 1) = '2' AND substring(i.address1, 1, 2) = '$ADD_ARRAY[$i]'";
$womanCnt = $dbcon->get_one($sqlstr); //여자

$sqlstr = "SELECT count(*) FROM wizMembers m left join wizMembers_ind i on m.mid = i.id $WHEREIS AND substring(i.address1, 1, 2) = '$ADD_ARRAY[$i]'";
$totalCnt = $dbcon->get_one($sqlstr); //토탈(남자/여자를 합하는 방법도 있지만 이럴경우 정확한 통계(성별누락에 따른)가 안나올수도 있다)

if ($TOTAL_DATA_NUM){
$ADD_PER = intval(($totalCnt/$TOTAL_DATA_NUM)*100);
}
else {
$ADD_PER = 0;
}

if ($manCnt[0]+$womanCnt[0]){
$ADD_PER1 = intval(($manCnt[0]/$totalCnt)*100);
$ADD_PER2 = intval(($womanCnt[0]/$totalCnt)*100);
}
else {
$ADD_PER1 = 0;
$ADD_PER2 = 0;
}
				?>
				<tr>
					<th><a href='main.php?menushow=<?php echo $menushow ?>&theme=member1&WHERE=Address1&keyword=<?ECHO $ADD_ARRAY[$i]; ?>&sort=UID'> <?php echo $ADD_ARRAY[$i] ?> </a></th>
					<td><?php echo number_format($manCnt[0]) ?>
					명</td>
					<td><?php echo number_format($womanCnt[0]); ?>
					명</td>
					<td><?php echo number_format($totalCnt); ?>
					명</td>
					<td> <div  ratio="<?php echo $ADD_PER ?>" class="uniquebar"></div>
					    <?php echo $ADD_PER; ?>
					%</td>
				</tr>
				<?
				}
				?>
			</tbody>
		</table>
		<br />
            <form name="memberlist" action="/malladmin/main.php">
                <input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
                <input type="hidden" value="member1" name="theme" >
                <input type='hidden' name='menushow' value='<?php echo $menushow ?>'>
                <input type="hidden" value="qde" name="action">
                <input type="hidden" name="WHERE">
                <input type="hidden" name="keyword">
                <input type="hidden" name="SELECT_SORT">
                <input type="hidden" name="add">
                <input type="hidden" name="Sex">
                <input type="hidden" name="Dsort">
                <input type="hidden" name="SYear">
                <input type="hidden" name="SMonth">
                <input type="hidden" name="SDay">
            </form>
		
		<table >
                    <tr>
                        <td>&nbsp;</td>
                        <td rowspan="3">&nbsp;</td>
                        <td rowspan="3"></td>
                        <td rowspan="3">
                        <div>
                            <span>검색된 회원수
                                :
                                <?php echo number_format($TOTAL_DATA_NUM) ?>
                                명
                                <br />
                                총 회원가입수 :
                                <?php echo number_format($TOTAL_DATA_NUM1) ?>
                                명</span>
                        </div></td>
                    </tr>

                </table>
		<form action='<?php echo $PHP_SELF ?>' method="post">
                                <input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
                                <input type='hidden' name='menushow' value='<?php echo $menushow ?>'>
                                <input type="hidden" name="theme" value='<?php echo $theme ?>'>
                                <input type="hidden" name="action" value='detail_search'>
		<table>
                            
                                <tr>
                                    <td colspan="3">
                                    <div>
                                        <?php
                                        $appstartyear = date("Y", $WizApplicationStartDate);
                                        $appstartmonth = date("m", $WizApplicationStartDate);
                                        $appstartday = date("j", $WizApplicationStartDate);
                                        $thisyear = date("Y");
                                        if (!$action) {
                                            $year = $appstartyear;
                                            $month = $appstartmonth;
                                            $day = $appstartday;
                                        } else {

                                            $year = $SYear;

                                            $month = $SMonth;

                                            $day = $SDay;

                                        }

                                        ECHO "&nbsp;<select name='SYear' size='1'>";

                                        for ($i = $appstartyear; $i <= $thisyear + 1; $i++) {
                                            if ($year == $i) {
                                                echo "<option value='$i' selected>${i}년</option>\n";
                                            } else {
                                                echo "<option value='$i'>${i}년</option>\n";
                                            }
                                        }

                                        echo "</select>

<select name='SMonth' size='1'>";

                                        for ($i = "01"; $i <= 12; $i++) {

                                            if (strlen($i) == 1)
                                                $i = "0" . $i;

                                            if ($month == $i) {

                                                echo "<option value='$i' selected>${i}월</option>\n";

                                            } else {

                                                echo "<option value='$i'>${i}월</option>\n";

                                            }

                                        }

                                        echo "

</select>

<select name='SDay' size='1'>";

                                        for ($i = "01"; $i <= 31; $i++) {

                                            if (strlen($i) == 1)
                                                $i = "0" . $i;

                                            if ($day == $i) {

                                                echo "<option value='$i' selected>${i}일</option>\n";

                                            } else {

                                                echo "<option value='$i'>${i}일</option>\n";

                                            }

                                        }

                                        echo "</select>";
                                        ?>
                                        ~
                                        <?

                                        if (!$action) {

                                            $year = date("Y");

                                            $month = date("m");

                                            $day = date("j");

                                        } else {

                                            $year = $FYear;

                                            $month = $FMonth;

                                            $day = $FDay;

                                        }

                                        ECHO "<select name='FYear' size='1'>";

                                        for ($i = "2003"; $i <= 2009; $i++) {

                                            if ($year == $i) {

                                                echo "<option value='$i' selected>${i}년</option>\n";

                                            } else {

                                                echo "<option value='$i'>${i}년</option>\n";

                                            }

                                        }

                                        echo "</select>

<select name='FMonth' size='1'>";

                                        for ($i = "01"; $i <= 12; $i++) {

                                            if (strlen($i) == 1)
                                                $i = "0" . $i;

                                            if ($month == $i) {

                                                echo "<option value='$i' selected>${i}월</option>\n";

                                            } else {

                                                echo "<option value='$i'>${i}월</option>\n";

                                            }

                                        }

                                        echo "

</select>

<select name='FDay' size='1'>";

                                        for ($i = "01"; $i <= 31; $i++) {

                                            if (strlen($i) == 1)
                                                $i = "0" . $i;

                                            if ($day == $i) {

                                                echo "<option value='$i' selected>${i}일</option>\n";

                                            } else {

                                                echo "<option value='$i'>${i}일</option>\n";

                                            }

                                        }

                                        echo "</select>";
                                        ?>
                                    </div></td>
                                    <td>
                                    <button type="submit" class="btn btn-primary">검색</button>
                                    </td>
                                </tr>
                            
                        </table></form>
                        
                        
		
		</div>