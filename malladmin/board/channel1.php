<?
if($query == "qde"){
//$result = rmdir("../config/wizboard/channel/$folder");
// 아래는 좀 위험한 방법이지만.. 쩝..
$path = "../config/wizboard/channel/$folder";
//echo "\$path = $path <br />";
//$cmd = "rm -rf $path";
//echo exec('rm -rf $path');
	$LOG_DIR = opendir("../config/wizboard/channel/$folder");
	while($LOG_FILE = readdir($LOG_DIR)) {
		if($LOG_FILE !="." && $LOG_FILE !=".."){
			  unlink("../config/wizboard/channel/$folder/$LOG_FILE");
		} //if($LOG_FILE !="." && $LOG_FILE !="..") 닫음
	}
			closedir($LOG_DIR);
	$result = rmdir("../config/wizboard/channel/$folder");		
	if(!$result){
	echo "<script>window.alert('../config/wizboard/channel/$folder 를 삭제하지 못했습니다. 수동으로 삭제해 주세요');</script>";
	}
}
?>
<script language="JavaScript">
<!--
$(function(){
	$(".btn_delete").click(function(){
		var folder = $(this).attr("folder");
		if(istrue = confirm('정말로 삭제하시겠습니까? \n\n 삭제된 데이타는 복구되지 않습니다.')){
		location.href='<?=$PHP_SELF?>?theme=<?=$theme?>&menushow=<?=$menushow?>&folder='+folder+'&query=qde';	
		}else return false;
	});
})
//-->
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">채널통계</div>
	  <div class="panel-body">
		 웹페이지별 방문통계를 나타냅니다.<br />
				보드쪽은 자동 계산 가능하며 일반페이지에 넣어실 경우<br />
				include &quot;./wizboard/func/MakeChannel.php&quot;;<br />
				MakeChannel(&quot;문서명&quot;);을 넣어주세요.(문서명은 BID와 중복되지 
				않는 영숫자로 만들어주세요)
	  </div>
	</div>
</div>
<table class="table_outline">
	<tr>
		<td>
			<div class="space20"></div>
			<table class="table_main list">
					<col width="100" />
					<col width="100" />
					<col width="100" />
					<col width="*" />
					<col width="100" />
					<col width="100" />
					<col width="100" />	
					<thead>		
				<tr class="altern">
					<th>필드</th>
					<th>시작일</th>
					<th>투데이</th>
					<th>최대값</th>
					<th>평균값</th>
					<th>누적(결과)값</th>
					<th>삭제</th>
				</tr>
				</thead>
				<tbody>
				<?
$today = mktime(0,0,0,date("m"), date("d"), date("Y"));
if(!isset($Theday)) $Theday = $today;
$open_dir = opendir("../config/wizboard/channel");
  while($opendir = readdir($open_dir)) :
     if(($opendir != ".") && ($opendir != "..")):
	 
	 $currentFile = "../config/wizboard/channel/${opendir}/totalcount.php";
	// echo "\$currentFile = $currentFile <br />";
	 if(file_exists($currentFile)):
	 $fileLines = file($currentFile);
	 $fileArr = explode("|",$fileLines[0]); //fileArr[0] = 토탈카운트 : fileArr[1] = 시작일
	 $during_day = round(($today - $fileArr[1])/(60*60*24)+1);
	 $average =  round($fileArr[0] / $during_day);
	 endif;
	 
	 $currentFile = "../config/wizboard/channel/${opendir}/$Theday.php"; //금일 방분자들의 시간들이  들어가 있다.
	 if(file_exists($currentFile)):
	 $TodayTotal = sizeof(file($currentFile));
	 endif;
/* 최대값 구하기 */
	 $currentFile = "../config/wizboard/channel/${opendir}/maxcount.php";
	 if(file_exists($currentFile)):
	 $fileLines = file($currentFile);
	 $fileArr2 = explode("|",$fileLines[0]); //fileArr[0] = 최대치 일 카운트 : fileArr[1] =  최대치 일
	 endif;
/* wizTable_Main에서 현재 opendir(BID] 과 BoardDes를 비교하여 이름으로 치환 */
	$dirstr = "select BoardDes from wizTable_Main where GID = SUBSTRING_INDEX('$opendir','_',1) and BID = SUBSTRING_INDEX('$opendir','_',-1)";
	$BoardDes = $dbcon->get_one($dirstr);
	if(!$BoardDes) $BoardDes = $opendir;
?>
					<tr>
						<td><?=$BoardDes?>
						</td>
						<td><?if($fileArr[1]) echo date("Y-m-d",$fileArr[1]); else echo "시작전";?>
						</td>
						<td><?=number_format($TodayTotal);?>
						</td>
						<td><?=number_format($fileArr2[0])?>
							(
							<?if($fileArr2[1]) echo date("Y-m-d",$fileArr2[1]); else echo "0";?>
							)</td>
						<td><?=number_format($average);?>
						</td>
						<td><?=number_format($fileArr[0])?>
						</td>
						<td><span class="btn_delete button bull" folder="<?=$opendir?>"><a>삭제</a></span></td>
					</tr>
				<?
unset($fileArr);
unset($fileArr1);
unset($fileArr2);
unset($TodayTotal);
unset($average);

	endif;
  endwhile;
closedir($open_dir);
?>
</tbody>
			</table></td>
	</tr>
</table>
