<?php
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***

*/
$TableName = "wizSendmaillist  ";

/* 회원삭제하기 */
if ($query == 'qde') {
	while (list($key,$value) = each($deleteArr)) {
		$sqlstr = "DELETE FROM $TableName WHERE uid='$value'";
		$result = $dbcon->_query($sqlstr);
	}
}
/* 회원 삭제 하기 끝 */
if ($WHERE && $keyword) {
                $WHEREIS = "WHERE $WHERE LIKE '%$keyword%'";
}

if (!$SELECT_SORT) {$sort = "uid";}
else $sort = $SELECT_SORT;

if ($DataEnable) {
$FromDate = mktime(0,0,0,"$SMonth","$SDay","$SYear");
$ToDate =  mktime(0,0,0,"$FMonth","$FDay","$FYear");
if($WHEREIS) $WHEREIS = "$WHEREIS AND signdate >= '$FromDate' AND signdate <= '$ToDate'";
else $WHEREIS = "WHERE signdate >= '$FromDate' AND signdate <= '$ToDate'";
}


/* 페이징과 관련된 수식 구하기 */
$ListNo = "15";
$PageNo = "20";
if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $ListNo;
$TOTAL_STR = "SELECT count(*) FROM $TableName";
$REALTOTAL = $dbcon->get_one($TOTAL_STR);

$sqlstr = "SELECT count(*) FROM $TableName $WHEREIS";
$TOTAL = $dbcon->get_one($sqlstr);


$LIST_QUERY = "SELECT * FROM $TableName $WHEREIS ORDER BY $sort DESC LIMIT $START_NO,$ListNo";
$TABLE_DATA = $dbcon->_query($LIST_QUERY);
?>
<script>
$(function(){
	$("#btn_delete").click(function(){
		if($("input[class=chk_list]:checkbox:checked").length == 0){
            jAlert('하나 이상 선택해 주세요', '경고메시지');
        }else{
            jConfirm('삭제된 데이타는 복구되지 않습니다.\n삭제하시겠습니까?', '삭제확인 ', function(r) {
                if(r==true) {
                   $("#l_form").submit();
                }
            });
        }
	});
});

function gotoPage(cp){
	$("#cp").val(cp);
	$("#sform").submit();
}

</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">발송된 메일링 리스트</div>
	  <div class="panel-body">
		 현재까지 발송된 메일링 리스트 입니다.
	  </div>
	</div>
	
	<form action='<?=$PHP_SELF?>' name='l_form' id="l_form" method="post">
				<input type="hidden" name="theme"  value='<?=$theme?>'>
				<input type='hidden' name='menushow' value='<?=$menushow?>'>
				<input type="hidden" name="query" value='qde'>
				<input type="hidden" name="cp" value='<?=$cp?>'>
				<input type="hidden" name="WHERE" value='<?=$WHERE?>'>
				<input type="hidden" name="keyword" value='<?=$keyword?>'>
				<input type="hidden" name="SELECT_SORT" value='<?=$SELECT_SORT?>'>
				<input type="hidden" name="add" value='<?=$add?>'>
				<input type="hidden" name="Sex" value='<?=$Sex?>'>
				<input type="hidden" name="Dsort" value='<?=$Dsort?>'>
				<input type="hidden" name="SYear" value='<?=$SYear?>'>
				<input type="hidden" name="SMonth" value='<?=$SMonth?>'>
				<input type="hidden" name="SDay" value='<?=$SDay?>'>
				<table class="table table-hover table-striped">
					<col width="50" />
					<col width="*" />
					<col width="100" />
					<col width="100" />
					<col width="50" />
					<thead>
						<tr class="success">
							<th>번호</th>
							<th>메일제목</th>
							<th>발송대상</th>
							<th>날짜</th>
							<td><span id="btn_delete", class="button bull"><a>메일삭제</a></span> </td>
						</tr>
					</thead>
					<tbody>
						<?
$NO = $TOTAL-($ListNo*($cp-1));	
while( $list = $dbcon->_fetch_array( $TABLE_DATA ) ) :
        $list[Address1] = trim($list[Address1]);
        $ZONE = explode(" ", $list[Address1]);
		if(substr($list[Jumin2],0,1) == 1 || substr($list[Jumin2],0,1) == 2) $BirthCentury = 1900; else $BirthCentury = 2000;
		$age = date("Y") - (substr($list[Jumin1],0,2) + $BirthCentury);
       
?>
						<tr>
							<td>&nbsp;
								<?=$NO?>
							</td>
							<td>&nbsp;<a href='<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=mail/mailer3_1&uid=<?=$list[uid]?>'>
								<?=$list[subject]?>
								</a></td>
							<td><?if($list[soption]) echo "$list[soption]"; else echo "전체";?>
							</td>
							<td>&nbsp;
								<?=date("Y.m.d",$list["sdate"])?>
							</td>
							<td><input type="checkbox" name='deleteArr[<?=$list["uid"]?>]' value='<?=$list["uid"]?>' class="chk_list">
							</td>
						</tr>
						<?
$NO--; 
endwhile;
?>
					</tbody>
				</table>
			</form>
			<br />
			<table class="table">
				<tr>
					<td>
						<form action='<?=$PHP_SELF?>' method="post" id="sform">
							<input type='hidden' name='menushow' value='<?=$menushow?>'>
							<input type="hidden" name="theme" value='<?=$theme?>'>
							<input type="hidden" name="cp" id="cp" value='<?=$cp?>'>
							<table>
								<tr>
									<td><?
if (!$query) {
$year = date("Y");
$month = date("m");
$day = date("j");
}
else {
$year = $SYear;
$month = $SMonth;
$day = $SDay;
}
?>
										&nbsp;
										<select name='SYear' size='1'>
											<?
for($i="2003";$i<=2009;$i++) {
if($year == $i) {
echo "<option value='$i' selected>${i}년</option>\n";
}
else {
echo "<option value='$i'>${i}년</option>\n";
}
}
?>
										</select>
										<select name='SMonth' size='1'>
											<?
for($i="01";$i<=12;$i++) {
if(strlen($i)==1) $i="0".$i;
if($month == $i) {
echo "<option value='$i' selected>${i}월</option>\n";
}
else {
echo "<option value='$i'>${i}월</option>\n";
}
}
?>
										</select>
										<select name='SDay' size='1'>
											<?
for($i="01";$i<=31;$i++) {
if(strlen($i)==1) $i="0".$i;
if($day == $i) {
echo "<option value='$i' selected>${i}일</option>\n";
}
else {
echo "<option value='$i'>${i}일</option>\n";
}
}
?>
										</select>
										~
										<?
if (!$query) {
$year = date("Y");
$month = date("m");
$day = date("j");
}
else {
$year = $FYear;
$month = $FMonth;
$day = $FDay;
}
?>
										<select name='FYear' size='1'>
											<?
for($i="2003";$i<=2009;$i++) {
if($year == $i) {
echo "<option value='$i' selected>${i}년</option>\n";
}
else {
echo "<option value='$i'>${i}년</option>\n";
}
}
?>
										</select>
										<select name='FMonth' size='1'>
											<?
for($i="01";$i<=12;$i++) {
if(strlen($i)==1) $i="0".$i;
if($month == $i) {
echo "<option value='$i' selected>${i}월</option>\n";
}
else {
echo "<option value='$i'>${i}월</option>\n";
}
}
?>
										</select>
										<select name='FDay' size='1'>
											<?
for($i="01";$i<=31;$i++) {
if(strlen($i)==1) $i="0".$i;
if($day == $i) {
echo "<option value='$i' selected>${i}일</option>\n";
}
else {
echo "<option value='$i'>${i}일</option>\n";
}
}
?>
										</select>
										<input type="checkbox" name="DataEnable" value="1"<? if($DataEnable) echo " checked";?>>
										Enable </td>
								</tr>
								<tr>
									<td><select name="WHERE">
											<option value=''>검색영역</option>
											<option value=''>----------</option>
											<option value='subject'<?if($WHERE=='subject'){ECHO" SELECTED";}?>>제목</option>
											<option value='tomember'<?if($WHERE=='tomember'){ECHO" SELECTED";}?>>받는사람이메일</option>
											<option value='body_txt'<?if($WHERE=='body_txt'){ECHO" SELECTED";}?>>내용</option>
										</select>
										<input size="10" name="keyword">
										<button type="submit" class="btn btn-default btn-xs">검색</button>
									</td>
								</tr>
							</table>
						</form></td>
					<td>&nbsp;</td>
					<td>검색된 
						발송메일수 :
						<?=number_format($TOTAL)?>
						건 <br />
						총 발송메일수 :
						<?=number_format($REALTOTAL)?>
						건 </td>
				</tr>
			</table>
			
	<div class="text-center">
<?php
$params = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL, "type"=>"bootstrappost"); 
echo $common->paging($params);
?>
	</div>
</div>
