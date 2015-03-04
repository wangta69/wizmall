<?
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 

*** Updating List ***
*/

include "../lib/class.board.php";
$board = new board();
$board->get_object($dbcon, $common);

$GID = "root";
if(!strcmp($create_table,"makeit")){
	/* New Table 생성 */	
	$SetupPath = "../config/wizboard";	
	$SourcePath = "../wizboard";	
	$board->createTable($m_bid, $GID, $TABLE_DES, $AdminName, $Pass, $group, $SetupPath, $SourcePath,$default_option);
}//if(!strcmp($create_table,"makeit"))에 대한 것을 닫음



?>
<script language="javascript" type="text/javascript">
<!--
$(function(){
	$(".btn_modify").click(function(){
		var bid	= $(this).attr("bid");
		var gid	= $(this).attr("gid");
		var url	= "../wizboard/admin1.php?BID="+bid+"&GID="+gid;
		window.open(url,'옵션보기','scrollbars=yes,resizable=yes,width=630,height=500');
	});
	
	$(".btn_change").click(function(){
		var bid			= $(this).attr("bid");
		var gid			= $(this).attr("gid");
		var boarddesc	= $(".boarddesc").eq($(".btn_change").index(this)).val()
		var pass		= $(".pass").eq($(".btn_change").index(this)).val()
		//alert(bid+','+gid+','+boarddesc+','+pass)
		$.post("./board/execute.php", {bid:bid, gid:gid, boarddesc:boarddesc, pass:pass, smode:"ch_pwd"}, function(data){
			jAlert('변경되었습니다');
		});
	});
});
function reSize() {
    try {
        var objBody = auto_iframe.document.body;
        var objFrame = document.all["auto_iframe"];
        ifrmHeight = objBody.scrollHeight + (objBody.offsetHeight - objBody.clientHeight);
        objFrame.style.height = ifrmHeight;
    }
        catch(e) {}
}

function init_iframe() {
    reSize();
    setTimeout('init_iframe()',1)
}

init_iframe();
//-->
</script>

<table class="table_outline">
	<tr>
		<td><fieldset class="desc">
			<legend>게시판관리</legend>
			<div class="notice">[note]</div>
			<div class="comment"> 게시판의 생성및 게시물삭제 비번, 기타 등 게시물에 대한 조치를 취하는 곳입니다.<br />
				일부 게시판은 관리자에서 제공되는 쓰기/보기폼이 다를 수 있으므로 이 경우는 웹페이지에서 직접 작성해 주시기 
				바랍니다.<br />
				보드의 삭제 및 그룹변경은 유의를 하셔야 하며 보드삭제는 <a href="../wizboard/index.php">이곳</a>을 
				클릭하신 후 진행하시면됩니다.<br />
			</div>
			</fieldset>
			<div class="space20"></div>
			<?
if($AdminBID)
{
 //include ("./boardlist.php");
?>
			<iframe src="../wizboard.php?adminmode=true&BID=<?=$AdminBID?>&GID=<? echo $AdminGID; ?>" height="800" frameborder="0" framespacing="0" name="auto_iframe" id="auto_iframe" scrolling="no" class="w100p"></iframe>
			<div class="space20"></div>
			<?
}else{
?>
			<!-- board List End -->
			<form  action="<?=$PHP_SELF?>" method="post">
				<input type='hidden' name='menushow' value='<?=$menushow?>'>
				<input type="hidden" name="theme" value="<?=$theme?>">
				<input type="hidden" name="GID" value="<? echo $GID; ?>">
				<input type="hidden" name="create_table" value="makeit">
				<table class="table">
					<tr >
						<th>테이블이름</th>
						<td><input name="m_bid"></td>
						<th>테이블설명</th>
						<td><input name="TABLE_DES"></td>
						<th>패스워드</th>
						<td><input name="Pass" type="password" size=15 maxlength=15></td>
						<td><input type="image" src="img/sang.gif"></td>
					</tr>
				</table>
			</form>
			<br />
			<form action="<?=$PHP_SELF?>" name="ListCountForm" method="post">
				<input type="hidden" name="GID" value="<? echo $GID; ?>">
				<input type='hidden' name='menushow' value='<?=$menushow?>'>
				<input type="hidden" name="theme" value="<?=$theme?>">
				<table>
					<tr>
						<td>리스트수:
							<select name="ListCount" onChange="submit()">
								<option value="10" <? if($ListCount == 10) echo "selected";?>>10</option>
								<option value="15" <? if($ListCount == 15) echo "selected";?>>15</option>
								<option value="20" <? if($ListCount == 20) echo "selected";?>>20</option>
								<option value="30" <? if($ListCount == 30) echo "selected";?>>30</option>
								<option value="50" <? if($ListCount == 50) echo "selected";?>>50</option>
								<option value="100" <? if($ListCount == 100) echo "selected";?>>100</option>
							</select>
							<select name="SEARCHTITLE">
								<option value="BoardDes" <? if($SEARCHTITLE =="BoardDesd") echo "selected";?>>테이블설명</option>
								<option value="BID" <? if($SEARCHTITLE =="BID") echo "selected";?>>테이블명</option>
							</select>
							<input type="text" name="searchkeyword" value="<?=$searchkeyword?>">
							<input type="submit" name="Submit3" value="검색">
							<input type="button" name="Submit4" value="전체" onclick="javascript:location.href=('<?=$PHP_SELF?>?theme=<?=$theme?>&menushow=<?=$menushow?>');"></td>
					</tr>
				</table>
			</form>
			<form>
				<input type="hidden" name="BID" value="<?=$BOARD_LIST["BID"]?>">
				<input type="hidden" name="GID" value="<?=$GID?>">
				<input type="hidden" name="MODE" value="ChangeIt">
				<input type='hidden' name='menushow' value='<?=$menushow?>'>
				<input type="hidden" name="theme" value="<?=$theme?>">
				<input type="hidden" name="Grp" value="<?=$Grp?>">
				<input type="hidden" name="cp" value="<?=$cp?>">
				<input type="hidden" name="ListCount" value="<?=$ListCount?>">
				<input type="hidden" name="SEARCHTITLE" value="<?=$SEARCHTITLE?>">
				<input type="hidden" name="searchkeyword" value="<?=$searchkeyword?>">
				<table class="table_main list">
					<col width="100" />
					<col width="100" />
					<col width="100" />
					<col width="*" />
					<col width="60" />
					<col width="60" />
					<col width="60" />
					<thead>
						<tr class="altern">
							<th>테이블명</th>
							<th>테이블설명</th>
							<th>패스워드</th>
							<th>경로</th>
							<th>패스워드변경 </th>
							<th>상세옵션수정 </th>
							<th>게시물관리</th>
							<th>보기</th>
						</tr>
					</thead>
					<tbody>
						<?
if($Grp) $WHERE = "WHERE Grade != 'A' AND Grp='$Grp'";
else $WHERE = "WHERE Grade != 'A' ";
if($SEARCHTITLE && $searchkeyword) $WHERE .= "and $SEARCHTITLE like '%$searchkeyword%'";

$TargetBoard = "wizTable_Main";
/* 총 갯수 구하기 */
$TOTAL_STR = "SELECT count(UID) FROM $TargetBoard $WHERE";
$TOTAL = $dbcon->get_one($TOTAL_STR);

if(!isset($ListCount) || !$ListCount) $ListCount = 10;
$LIST_NO=$ListCount; /* 페이지당 출력 리스트 수 */
$PageNo=10; /* 페이지 밑의 출력 수 */
if(empty($cp) || $cp <= 0) $cp = 1;

$START_NO = ($cp - 1) * $LIST_NO;
$BOARD_NO=$TOTAL-($LIST_NO*($cp-1));
$SELECT_STR="SELECT * FROM $TargetBoard $WHERE ORDER BY BID ASC LIMIT $START_NO, $LIST_NO";
$dbcon->_query($SELECT_STR);
while($BOARD_LIST=$dbcon->_fetch_array()):
?>
						<tr>
							<td><?=$BOARD_LIST[BID]?></td>
							<td><input name="boarddesc" class="boarddesc" value="<?=$BOARD_LIST["BoardDes"]?>" ></td>
							<td><input name="pass" class="pass" value="<?=$BOARD_LIST["Pass"]?>"></td>
							<td><? echo "wizboard.php?BID=".$BOARD_LIST[BID]."&GID=".$BOARD_LIST[GID]; ?> </td>
							<td><span class="btn_change button bull" bid="<?=$BOARD_LIST[BID]?>" gid="<?=$BOARD_LIST["GID"]?>"><a>변경</a></span></td>
							<td><span class="btn_modify button bull" bid="<?=$BOARD_LIST[BID]?>" gid="<?=$BOARD_LIST["GID"]?>"><a>수정</a></span></td>
							<td><span class="button bull"><a href="<?=${PHP_SELF}?>?AdminBID=<?=$BOARD_LIST[BID]?>&AdminGID=<? echo $GID?>&menushow=<?=$menushow?>&theme=<?=$theme?>&cp=<?=$cp?>&ListCount=<?=$ListCount?>&SEARCHTITLE=<?=$SEARCHTITLE?>&searchkeyword=<?=$searchkeyword?>">관리</a></span></td>
							<td><span class="button bull"><a href="../wizboard.php?BID=<?=$BOARD_LIST[BID]?>&GID=<?=$BOARD_LIST["GID"]?>" target="_blank">보기</a></td>
						</tr>
						<?
endwhile;
?>
					</tbody>
				</table>
			</form>
			<br />
			<div class="paging_box">
				<?
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
$page_arg1 = $PHP_SELF."?menushow=$menushow&theme=$theme&Grp=$Grp&SEARCHTITLE=$SEARCHTITLE&searchkeyword=".urlencode($searchkeyword)."&ListCount=$ListCount";
$page_arg2 = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL); 
//$page_arg3 = array("pre"=>"./img/pre.gif","next"=>"./img/next.gif");
echo $common->paging($page_arg1,$page_arg2,$page_arg3);
?>
			</div>
			<br />
			<?
      }
	  ?></td>
	</tr>
</table>
