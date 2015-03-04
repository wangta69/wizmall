<?php
/*
 powered by 폰돌
 Reference URL : http://www.shop-wiz.com
 Contact Email : master@shop-wiz.com
 Free Distributer :
 Copyright shop-wiz.com
 *** Updating List ***

 */
include "./member/common.php";

if ($grade == "5")
	$title = "기업회원정보";
else if ($grade == "10")
	$title = "일반회원정보";
else if ($grantsta == "00")
	$title = "탈퇴회원정보";
else
	$title = "전체회원정보";
/* 회원 삭제 하기 끝 */
$whereis = " WHERE 1";
if ($grade)
	$whereis .= " and m.mgrade = '".$grade."'";
if ($grantsta == "00")
	$whereis .= " and m.mgrantsta = '".$grantsta."'";

if ($stitle && $keyword) {
	$whereis .= " and ".$stitle." LIKE '%".$keyword."%'";
}

if (!$sel_orderby) {$orderby = "m.uid@desc";
} else
	$orderby = $sel_orderby;

if ($DataEnable) {
	$FromDate = mktime(0, 0, 0, $SMonth, $SDay, $SYear);
	$ToDate = mktime(0, 0, 0, $FMonth, $FDay, $FYear);
	$whereis .= " AND m.mregdate  >= '".$FromDate."' AND m.mregdate <= '".$ToDate."'";
}

$TOTAL_STR = "SELECT count(m.uid) FROM wizMembers m left join wizMembers_ind i on m.mid = i.id";
$REALTOTAL = $dbcon -> get_one($TOTAL_STR);

$sqlstr = "SELECT count(m.uid) FROM wizMembers m left join wizMembers_ind i on m.mid = i.id ".$whereis;
$TOTAL = $dbcon -> get_one($sqlstr);
//--페이지 나타내기--
//--페이지링크를 작성하기--
?>
<script>
$(function(){
	$(".btn_delete").click(function(data){
		$("#qry").val("qde");
		$("#listForm").submit();
		
	});	
});

function really(){
	var f = document.forms.listForm;
	var i = 0;
	var chked = 0;
	for(i = 0; i < f.length; i++ ) {
			if(f[i].type == 'checkbox') {
					if(f[i].checked) {
							chked++;
					}
			}
	}
	if( chked < 1 ) {
			alert('삭제하고자 하는 회원을 체크해주세요.');
			return false;
	}
	if (confirm('\n정말로 삭제하시겠습니까? 삭제는 복구가 불가능합니다.   \n')) return true;
	return false;
}

function changegrant(sta, id){
	var str = "";
	if(sta == "03"){//승인상태
		str = "보류상태로 변경하시겠습니까?";
	}else if(sta == "00"){//탈퇴상태
		str = "보류상태로 변경하시겠습니까?";
	}else{//보류상태 : 04
		str = "승인상태로 변경하시겠습니까?";
	}
	
	if(confirm(str)){
		location.href = "<?php echo $PHP_SELF?>?menushow=<?php echo $menushow?>&theme=<?php echo $theme?>&grade=<?php echo $grade?>&grantsta="+sta+"&qry=qup&id="+id+"&cp=<?php echo $cp?>&csrf=<?php echo $common->getcsrfkey()?>";
    }else{
	   return false;
	}
}

function submitListcnt(v){
	var f = document.searchForm;
	f.ListNo.value = v.value;
	f.submit();
}

function gotoHistory(id){
	var url = "./member/front_member.php?query=order&mid="+id;
	wizwindow(url,'buyhistory','width=670,height=700,statusbar=no,scrollbars=yes,toolbar=no');
}

function gotoPage(cp){
	$("#cp").val(cp);
	$("#sform").submit();
}
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading"><?php echo $title?></div>
	  <div class="panel-body">
		 <?php echo $title?> 리스트 입니다.
	  </div>
	</div>
	
	
	<form name="ListnoForm" action="<?php echo $PHP_SELF?>">
총회원수 : <?php echo number_format($REALTOTAL) ?>/  검색된 회원수: <?php echo number_format($TOTAL) ?>
		<select name="ListNo" onChange="submitListcnt(this)">
			<option>리스트갯수</option>
			<option value="15">15</option>
			<option value="20">20</option>
			<option value="30">30</option>
			<option value="50">50</option>
			<option value="100">100</option>
		</select>
	<a href='./member/member1_exel.php?DownForExel=yes&grade=<?php echo $grade; ?>&grantsta=<?php echo $grantsta; ?>&ListNo=<?php echo $ListNo?>&PageNo=<?php echo $PageNo?>&cp=<?php echo $cp?>'"; class="btn btn-default btn-xs">액셀출력</a>
	</form>
	
	
	<form action='<?php echo $PHP_SELF?>?<?php echo $common->addgetfield("theme,menushow", $_GET)?>' name='listForm' id="listForm" method="post">
				
				<input type="hidden" name="csrf" value="<?php echo $common->getcsrfkey()?>">
				<? $common -> addhiddenfield("grade,grantsta,stitle,keyword,sel_orderby,add,gender,Dsort,SYear,SMonth,SDay", $_POST); ?>
				<input type="hidden" name="qry" id="qry" value=''>
				<input type="hidden" name="cp" value='<?php echo $cp?>'>
				<table class="table table-hover table-striped">
					<col width="50" /><!-- 번호 -->
					<col width="*" /><!-- 회원이름 -->
					<col width="70" /><!-- 아이디 -->
					<col width="50" /><!-- 지역 -->
					<col width="70" /><!-- 등급 -->
					<col width="70" /><!-- 포인트 -->
					<col width="70" /><!-- 구매내역 -->
					<col width="90" /><!-- 가입일 -->
					<col width="70" /><!-- 로긴수 -->
					<col width="50" /><!-- 승인 -->
					<col width="70" /><!--  -->
					<thead>
						<tr>
							<th>번호</th>
							<th>회원이름<br />
								(성별, 나이)</th>
							<th>아이디</th>
							<th>지역</th>
							<th>등급</th>
							<th>포인트</th>
							<th>구매내역</th>
							<th>가입일</th>
							<th>로긴수</th>
							<th>승인</th>
							<th> <span class="button bull btn_delete"><a>삭제</a></span></th>
						</tr>
					</thead>
					<tbody>
<?php
$NO = $TOTAL-($ListNo*($cp-1));
$qry = $dbcon->get_select('m.uid, m.mid, m.mgrantsta, m.mname, m.mloginnum, m.mregdate, m.mexp, m.mgrade, i.gender, i.address1','wizMembers m left join wizMembers_ind i on m.mid  =  i.id',$whereis, $orderby, $START_NO, $ListNo);	
$cnt=0;
while( $list = $dbcon->_fetch_array($qry)) :
        $area = explode(" ", trim($list["address1"]));
		if(substr($list["jumin2"],0,1) == 1 || substr($list["jumin2"],0,1) == 2) $BirthCentury = 1900; else $BirthCentury = 2000;
		$age = date("Y") - (substr($list["jumin1"],0,2) + $BirthCentury);
		$list["gender"]	= $common->gendertoString($list["gender"], $list);
		
		$mgrade = $list["mgrade"];
		$mgradestr = $gradetostr_info[$mgrade]?$gradetostr_info[$mgrade]:$mgrade;
		switch($list["mgrantsta"]){
			case "03":
				$str_mgrantsta ="승인";
			break;
			case "00":
				$str_mgrantsta ="탈퇴";
			break;
			default:
				$str_mgrantsta ="보류";
			break;
			
		}
?>
						<tr>
							<td><a href="javascript:memberSearch('<?php echo $list["mid"]?>')"><span class="glyphicon glyphicon-envelope"></span></a>
								<?php echo $NO?>
							</td>
							<td><a href="javascript:getuserInfo('<?php echo $list["mid"]?>');">
								<?php echo $list["mname"]?>
								<?php
								if ($list["gender"] || $list["jumin2"])
									echo "<br />(" . $list["gender"];
								if ($list["jumin2"])
									echo "," . $age;
								if ($list["gender"] || $list["jumin2"])
									echo ")";
			  ?>
								</a></td>
							<td><a href="javascript:getuserInfo('<?php echo $list["mid"]?>');">
								<?php echo $list["mid"]?>
								</a></td>
							<td>&nbsp;
								<?php echo $area[0]?>
							</td>
							<td>&nbsp;<a href="javascript:getuserInfo('<?php echo $list["mid"]?>');">
								<?php echo $mgradestr?>
								</a></td>
							<td>&nbsp;<a href="javascript:getuserInfo('<?php echo $list["mid"]?>');"><FONT COLOR=ORANGE>
								<?php echo number_format($list["mpoint"]) ?>
								</a></td>
							<td><span class="button bull"><a href="javascript:gotoHistory('<?php echo $list["mid"]?>')">보기</a></span></td>
							<td>&nbsp;
								<?php echo date("Y.m.d", $list["mregdate"]) ?>
							</td>
							<td><?php echo number_format($list["mloginnum"]) ?>
							</td>
							<td>
								<a href="javascript:changegrant('<?php echo $list["mgrantsta"]?>', '<?php echo $list["mid"]?>');" class="btn btn-info btn-xs"><?php echo $str_mgrantsta?></a></td>
							<td><input type="checkbox" name='DeleteMember[<?php echo $list["uid"]?>]' value='<?php echo $list["uid"]?>'>
							</td>
						</tr>
<?php
$NO--;
$cnt++;
endwhile;

if(!$cnt){
?>
						<tr>
							<td colspan="11">등록된
								<?php echo $title?>
								가 없습니다.</td>
						</tr>
<?php
}
?>
				</table>
			</form>
			
			
			

	<form action='<?php echo $PHP_SELF?>?<?php echo $common->addgetfield("theme,menushow", $_GET)?>' method="post" name="searchForm" id="sform">
			<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
			<input type="hidden" name="grade" value='<?php echo $grade?>'>
			<input type="hidden" name="grantsta" value='<?php echo $grantsta?>'>
			<input type="hidden" name="ListNo" value='<?php echo $ListNo?>'>
			<input type="hidden" name="cp" id="cp" value='<?php echo $cp?>'>
			<? $common -> addhiddenfield("grade,grantsta,ListNo", $_POST); ?>
			

<?php
//echo "adfasdf";
if ($SMonth && $SDay && $SYear)
	$tdate = mktime(0, 0, 0, $SMonth, $SDay, $SYear);
else
	$tdate = $WizApplicationStartDate;
$common -> startyear = date("Y", $WizApplicationStartDate);
$common -> getSelectDate($tdate);
?>
			&nbsp;
			<select name='SYear' size='1'>
				<?php echo $common->rtn_year ?>
			</select>
			<select name='SMonth' size='1'>
				<?php echo $common->rtn_month ?>
			</select>
			<select name='SDay' size='1'>
				<?php echo $common->rtn_day ?>
			</select>
			~
			<?php
			if ($FYear && $FMonth && $FDay)
				$tdate = mktime(0, 0, 0, $FMonth, $FDay, $FYear);
			else
				$tdate = time();
			$common -> getSelectDate($tdate);
		?>
			<select name='FYear' size='1'>
				<?php echo $common->rtn_year ?>
			</select>
			<select name='FMonth' size='1'>
				<?php echo $common->rtn_month ?>
			</select>
			<select name='FDay' size='1'>
				<?php echo $common->rtn_day ?>
			</select>
			<input type="checkbox" name="DataEnable" value="1"<?php
			if ($DataEnable)
				echo " checked";
			?>>
			Enable   &nbsp;&nbsp;&nbsp;
			<?php echo $admin->sel_mem_stitle($stitle)?>
			<input name="keyword" value="<?php echo $keyword?>" size=10 />
			<button type="submit" class="btn btn-default">검색</button>

		<?php echo $admin->sel_mem_order($sel_orderby)?>

</form>

	<div class="text-center">
<?php
$params = array("listno" => $ListNo, "pageno" => $PageNo, "cp" => $cp, "total" => $TOTAL, "type" => "bootstrappost");
echo $common -> paging($params);
?>
	</div>
</div>