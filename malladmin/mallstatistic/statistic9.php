<?php
/*
 powered by 폰돌
 Reference URL : http://www.shop-wiz.com
 Contact Email : master@shop-wiz.com
 Free Distributer :
 Copyright shop-wiz.com
 *** Updating List ***
 */
if ($action == 'send') {
    unset($ups);
    $ups["GrantSta"] = $value;
    $dbcon -> updateData("wizMembers", $ups, "ID='" . $id . "'");
}

/* 회원삭제하기 */
if ($action == 'qde') {
    for ($i = 0; $i < sizeof($_GET); $i++) {
    }
    while (list($key, $no) = each($_GET)) {
        if (ereg("multi", $key)) {
            $dbcon -> _query("DELETE FROM wizMembers WHERE UID='" . $no . "'");
        }
    }
}
/* 회원 삭제 하기 끝 */
if ($WHERE && $keyword) {
    $WHEREIS = "WHERE " . $WHERE . " LIKE '%" . $keyword . "%' AND mgrade = '5'";
}

if (!$SELECT_SORT) {$sort = "UID";
} else
    $sort = $SELECT_SORT;

if ($DataEnable) {
    $FromDate = mktime(0, 0, 0, $SMonth, $SDay, $SYear);
    $ToDate = mktime(0, 0, 0, $FMonth, $FDay, $FYear);
    if ($WHEREIS)
        $WHEREIS = $WHEREIS . " AND RegDate >= '" . $FromDate . "' AND RegDate <= '" . $ToDate . "'";
    else
        $WHEREIS = "WHERE RegDate >= '" . $FromDate . "' AND RegDate <= '" . $ToDate . "' AND mgrade = '5'";
}

if (!$WHEREIS)
    $WHEREIS = "WHERE mgrade = '5'";

/* 페이징과 관련된 수식 구하기 */
$listNo = "15";
$PageNo = "20";
if (empty($cp) || $cp <= 0)
    $cp = 1;
$START_NO = ($cp - 1) * $listNo;
$TOTAL_STR = "SELECT count(*) FROM wizMembers";
$REALTOTAL = $dbcon -> get_one($TOTAL_STR);
$sqlstr = "SELECT count(*) FROM wizMembers " . $WHEREIS;
$TOTAL = $dbcon -> get_one($sqlstr);

//--페이지링크를 작성하기--
$LIST_QUERY = "SELECT * FROM wizMembers " . $WHEREIS . " ORDER BY " . $sort . " DESC LIMIT " . $START_NO . "," . $listNo;
$TABLE_DATA = $dbcon -> _query($LIST_QUERY);
?>

<script>
	function gotoPage(cp) {
		$("#cp").val(cp);
		$("#sform").submit();
	}
</script>

<div class="table_outline">
<div class="panel panel-success">
<div class="panel-heading">판매처별 미수관리 - 전체 리스트 보기</div>
<div class="panel-body">
판매처의 미수관리를 적는 곳입니다. <br />
몰 시스템과 회원부분 외에는 연동되지 않습니다.
</div>
</div>

<form action='<?php echo $PHP_SELF?>' name='memberlist'>
<input type="hidden" name="theme"  value='<?php echo $theme?>'>
<input type='hidden' name='menushow' value='<?php echo $menushow?>'>
<input type="hidden" name="action" value='qde'>
<input type="hidden" name="cp" value='<?php echo $cp?>'>
<input type="hidden" name="WHERE" value='<?php echo $WHERE?>'>
<input type="hidden" name="keyword" value='<?php echo $keyword?>'>
<input type="hidden" name="SELECT_SORT" value='<?php echo $SELECT_SORT?>'>
<input type="hidden" name="add" value='<?php echo $add?>'>
<input type="hidden" name="Sex" value='<?php echo $Sex?>'>
<input type="hidden" name="Dsort" value='<?php echo $Dsort?>'>
<input type="hidden" name="SYear" value='<?php echo $SYear?>'>
<input type="hidden" name="SMonth" value='<?php echo $SMonth?>'>
<input type="hidden" name="SDay" value='<?php echo $SDay?>'>
<table class="table table-hover table-striped">
<col width="70" />
<col width="*" />
<col width="*" />
<col width="*" />
<col width="*" />
<col width="*" />
<col width="*" />
<col width="*" />
<thead>
<tr class="success">
<th>번호</th>
<th>회원이름<br />
(성별, 나이)</th>
<th>아이디</th>
<th>지역</th>
<th>총판매금액</th>
<th>총입급액</th>
<th>미수액</th>
<th>상세내역</th>
</tr>
</thead>
<tbody>
<?php
$NO = $TOTAL-($listNo*($cp-1));
$cnt=0;
while( $list = $dbcon->_fetch_array( $TABLE_DATA ) ) :
$list["Address1"] = trim($list["Address1"]);
$ZONE = explode(" ", $list["Address1"]);
if(substr($list["Jumin2"],0,1) == 1 || substr($list["Jumin2"],0,1) == 2) $BirthCentury = 1900; else $BirthCentury = 2000;
$age = date("Y") - (substr($list["Jumin1"],0,2) + $BirthCentury);

$accountstr = "select sum(Ccreditprice) as credit, sum(Cincomprice) as incom, sum(Ccreditprice - Cincomprice) as rest from wizdailyaccount where CMID = '".$list["ID"]."'";
$accountqry = $dbcon->_query($accountstr);
$accountlist = $dbcon->_fetch_array($accountqry);
?>
<tr>
<td><?php echo $NO
?>
</td>
<td><a href='#' onclick="javascript:window.open('./member1_1.php?id=<?php echo $list["ID"]?>', 'regisform','width=650,height=650,statusbar=no,scrollbars=yes,toolbar=no')">
<?php echo $list["Name"]
?>
(
<?php echo $list["Sex"]
?>
,
<?php echo $age
?>
) </a></td>
<td><a href="javascript:window.open('./member1_1.php?id=<?php echo $list["ID"]?>', 'regisform','width=650,height=600,statusbar=no,scrollbars=yes,toolbar=no')">
<?php echo $list["ID"]
?>
</a></td>
<td><?php echo $ZONE[0]
?>
</td>
<td><?php echo number_format($accountlist["credit"])
?>
</td>
<td><?php echo number_format($accountlist["incom"])
?>
</td>
<td><?php echo number_format($accountlist["rest"])
?>
</td>
<td><span class="button bull"><a href="<?php echo $PHP_SELF?>?menushow=<?php echo $menushow?>&theme=statistic9_1&mid=<?php echo $list["ID"]?>">보기</a></span></td>
</tr>
<?php
$NO--;
$cnt++;
endwhile;
if ($cnt == 0){
?>
<tr>
<td colspan="8">등록된 정보가 없습니다.</td>
</tr>
<?php
}
?>
</tbody>
</table>
</form>
<table>
<tr>
<td><form action='<?php echo $PHP_SELF?>' method="post" id="sform">
<input type='hidden' name='menushow' value='<?php echo $menushow?>'>
<input type="hidden" name="theme" value='<?php echo $theme?>'>
<input type="hidden" name="cp" id="cp" value='<?php echo $cp?>'>
<table>
<tr>
<td><div>
<?php
if (!$action) {
    $year = date("Y");
    $month = date("m");
    $day = date("j");
} else {
    $year = $SYear;
    $month = $SMonth;
    $day = $SDay;
}
?>
&nbsp;
<select name='SYear' size='1'>
<?php
for ($i = "2003"; $i <= 2009; $i++) {
    if ($year == $i) {
        echo "<option value='$i' selected>${i}년</option>\n";
    } else {
        echo "<option value='$i'>${i}년</option>\n";
    }
}
?>
</select>
<select name='SMonth' size='1'>
<?php
for ($i = "01"; $i <= 12; $i++) {
    if (strlen($i) == 1)
        $i = "0" . $i;
    if ($month == $i) {
        echo "<option value='$i' selected>${i}월</option>\n";
    } else {
        echo "<option value='$i'>${i}월</option>\n";
    }
}
?>
</select>
<select name='SDay' size='1'>
<?php
for ($i = "01"; $i <= 31; $i++) {
    if (strlen($i) == 1)
        $i = "0" . $i;
    if ($day == $i) {
        echo "<option value='$i' selected>${i}일</option>\n";
    } else {
        echo "<option value='$i'>${i}일</option>\n";
    }
}
?>
</select>
~
<?php
if (!$action) {
    $year = date("Y");
    $month = date("m");
    $day = date("j");
} else {
    $year = $FYear;
    $month = $FMonth;
    $day = $FDay;
}
?>
<select name='FYear' size='1'>
<?php
for ($i = "2003"; $i <= 2009; $i++) {
    if ($year == $i) {
        echo "<option value='$i' selected>${i}년</option>\n";
    } else {
        echo "<option value='$i'>${i}년</option>\n";
    }
}
?>
</select>
<select name='FMonth' size='1'>
<?php
for ($i = "01"; $i <= 12; $i++) {
    if (strlen($i) == 1)
        $i = "0" . $i;
    if ($month == $i) {
        echo "<option value='$i' selected>${i}월</option>\n";
    } else {
        echo "<option value='$i'>${i}월</option>\n";
    }
}
?>
</select>
<select name='FDay' size='1'>
<?php
for ($i = "01"; $i <= 31; $i++) {
    if (strlen($i) == 1)
        $i = "0" . $i;
    if ($day == $i) {
        echo "<option value='$i' selected>${i}일</option>\n";
    } else {
        echo "<option value='$i'>${i}일</option>\n";
    }
}
?>
</select>
<input type="checkbox" name="DataEnable" value="1"<?php
    if ($DataEnable)
        echo " checked";
?>>
Enable </div>
<br />
<select name=WHERE>
<option value=''>검색영역</option>
<option value=''>----------</option>
<option value='ID'<?
    if ($WHERE == 'ID') {echo " selected";
    }
?>>아이디</option>
<option value='Name'<?php
    if ($WHERE == 'Name') {echo " selected";
    }
?>>이
름</option>
<option value='Address1'<?php
    if ($WHERE == 'Address1') {echo " selected";
    }
?>>주거지역</option>
<option value='Sex'<?php
    if ($WHERE == 'Sex') {echo " selected";
    }
?>>성
별</option>
<option value='Email'<?php
    if ($WHERE == 'Email') {echo " selected";
    }
?>>이메일</option>
<option value='Jumin1'<?php
    if ($WHERE == 'Jumin1') {echo " selected";
    }
?>>주민번호(6)</option>
<option value='Jumin2'<?php
    if ($WHERE == 'Jumin2') {echo " selected";
    }
?>>주민번호(7)</option>
</select>
<input size=10
name="keyword">
<button type="submit" class="btn btn-primary">검색</button>
<select style="width: 140px"
onChange=this.form.submit() name='SELECT_SORT'>
<option value=''>선택부분별 정렬</option>
<option value=''>-------------------</option>
<option value='RegDate'<?php
    if ($SELECT_SORT == 'RegDate') {echo " selected";
    }
?>>등록날짜순
정렬</option>
<option value='ID'<?php
    if ($SELECT_SORT == 'ID') {echo " selected";
    }
?>>아이디순
정렬</option>
<option value='Name'<?php
    if ($SELECT_SORT == 'Name') {echo " selected";
    }
?>>이름순
정렬</option>
<option value='Point'<?php
    if ($SELECT_SORT == 'Point') {echo " selected";
    }
?>>포인트순
정렬</option>
<option value='Grade'<?php
    if ($$SELECT_SORT == 'Grade') {echo " selected";
    }
?>>등급순
정렬</option>
<option value='LoginNum'<?php
    if ($SELECT_SORT == 'LoginNum') {echo " selected";
    }
?>>접속순
정렬</option>
<option value='Jumin1'<?php
    if ($SELECT_SORT == 'Jumin1') {echo " selected";
    }
?>>나이구분
정렬</option>
<option value='Address1'<?php
    if ($SELECT_SORT == 'Address1') {echo " selected";
    }
?>>지역구분
정렬</option>
<option value='Sex'<?php
    if ($SELECT_SORT == 'Sex') {echo " selected";
    }
?>>성별구분
정렬</option>
</select></td>
</tr>
<tr>
<td></td>
</tr>
</table>
</form></td>
<td></td>
<td>검색된
회원수 :
<?php echo number_format($TOTAL) ?>
명<br />
총 회원가입수 :
<?php echo number_format($REALTOTAL)
?>
명</td>
</tr>
</table>
<div class="text-center">
<?php
$params = array("listno" => $ListNo, "pageno" => $PageNo, "cp" => $cp, "total" => $TOTAL, "type" => "bootstrappost");
echo $common -> paging($params);
?>
</div>
</div>