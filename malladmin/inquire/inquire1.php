<?php
/*
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*/

$board_name="wizInquire";
//include "../wizboard/func/STR_CUTTING_FUNC.php";
/* 검색 키워드 및 WHERE 구하기 */
$WHERE="WHERE iid = '$iid'";
if($SEARCHTITLE && $searchkeyword){
$WHERE .= "AND $SEARCHTITLE LIKE '%$searchkeyword%'";
}
/* 총 갯수 구하기 */
$TOTAL_STR = "SELECT count(uid) FROM $board_name $WHERE";
$TOTAL = $dbcon->get_one($TOTAL_STR);
$ListNo=10; /* 페이지당 출력 리스트 수 */
$PageNo=10; /* 페이지 밑의 출력 수 */
if(empty($cp) || $cp <= 0) $cp = 1;
?>
<script>
function DELETE_THIS(uid,cp,iid,theme,menushow){
	window.open("./inquire/inquire_del.php?uid="+uid+"&cp="+cp+"&iid="+iid+"&theme="+theme+"&menushow="+menushow,"","scrollbars=no, toolbar=no, width=340, height=150, top=220, left=350")
}

function gotoPage(cp){
	$("#cp").val(cp);
	$("#sform").submit();
}

function gotoView(uid){
	var url = "<?=$PHP_SELF;?>";
	$("#theme").val("inquire/inquire1_1");
	$("#uid").val(uid);
	$("#sform").attr("action", url);
	$("#sform").submit();
}
</script>

<form id="sform" method="get">
	<input type='hidden' name='menushow' value='<?=$menushow?>'>
	<input type="hidden" name="theme" id="theme"  value='<?=$theme?>'>
	<input type="hidden" name="cp" id="cp"  value='<? echo $cp?>' >
	<input type="hidden" name="uid" id="uid" value='<? echo $iid?>' >
	<input type="hidden" name="iid" value='<? echo $iid?>' >
</form>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">온라인 의뢰</div>
	  <div class="panel-body">온라인 의뢰를 보실 수 있습니다.
	  </div>
	</div>
	
	<table class="table table-hover table-striped">
	<col width="50" />
	<col width="*" />
	<col width="150" />
	<col width="100" />
	<col width="70" />
	<thead>
		<tr class="success">
			<th>NO.</th>
			<th>이름(회사명)</th>
			<th>전화번호</th>
			<th>의뢰일</th>
			<th>삭제</th>
		</tr>
<?php

$START_NO = ($cp - 1) * $ListNo;

$BOARD_NO=$TOTAL-($ListNo*($cp-1));

$SELECT_STR="SELECT * FROM $board_name $WHERE ORDER BY uid DESC LIMIT $START_NO, $ListNo";


$SELECT_QRY=$dbcon->_query($SELECT_STR);

while($LIST=@$dbcon->_fetch_array($SELECT_QRY)):
	$LIST["SUBJECT"]=stripslashes($LIST["SUBJECT"]);
	$LIST["W_DATE"] = str_replace("-",".",$LIST["W_DATE"]);
	/* REPLY에 이미지가 있을 경우 아래 방법을 사용합니다. */
	$IMGNUM=strlen($LIST[THREAD])-1;
	$SPACE="";
	for($i=0; $i<$IMGNUM-1; $i++){
	$SPACE .="&nbsp;&nbsp;";
	}

?>
		<tr>
			<td>
				<?=$BOARD_NO;?>
			</td>
			<td>
				<a href="javascript:gotoView(<?=$LIST["uid"];?>)">
				<?=$LIST["name"];?>
				(
				<?=$LIST["compname"];?>
				)</a>
			</td>
			<td><a href="javascript:gotoView(<?=$LIST["uid"];?>)">
				<?=$LIST["tel"]?>
				</a></td>
			<td>
				<?=date("Y.m.d",($LIST["wdate"]));?>
			</td>
			<td>
				<button type="button" onClick="javascript:DELETE_THIS('<?=$LIST["uid"];?>','<?=$cp;?>','<?=$iid;?>','<?=$theme?>','<?=$menushow?>');" class="btn btn-default btn-xs">삭제</button>
			</td>
		</tr>
<?php
$BOARD_NO--;
endwhile;
?>
	</table>
	<div class="text-center">
<?php
	$params = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL, "type"=>"bootstrappost"); 
	echo $common->paging($params);
?>
	</div>
	
</div>

