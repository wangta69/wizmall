<?php
/* 
제작자 : 폰돌
스킨 : wizboard list skin 
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/

include "../../../lib/inc.depth3.php";
include_once "../../../lib/class.image.php";
$Image		= new Image();
$common->get_object($dbcon, $Image);
include_once "../../../lib/class.board.php";
$board = new board();
$board->get_object($dbcon, $common);

$board->cfg = $cfg;//환경설정 파일들을 입력한다.
$GID	= $_POST["GID"];
$BID	= $_POST["BID"];
$UID	= $_POST["UID"];
?>
<script>
$(document).ready(function(){
	$(".single").colorbox({photo:true, maxWidth:"700px", maxHeight:"700px"});
});
function gotoPage(cp){
	roadCommentList(cp);
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr align="center" valign="top">
<?php
$comment_listno	= 9;
$comment_pageno	= 10;
$cp	= $_POST["cp"] ? $_POST["cp"]:1;
$start_no	= ($cp-1) * $comment_listno;
$cnt	= 0;
$sql = "SELECT count(UID) FROM wizTable_".$GID."_".$BID."_reply WHERE MID=".$UID." and FLAG = 1";
$comment_total	= $dbcon->get_one($sql);

$sql = "SELECT * FROM wizTable_".$GID."_".$BID."_reply WHERE MID=".$UID." and FLAG = 1 ORDER BY UID desc limit ".$start_no.", ".$comment_listno;
$dbcon->_query($sql);
while($RepleList = $dbcon->_fetch_array()):
	$filepath = $_SERVER["DOCUMENT_ROOT"]."/config/wizboard/table/".$GID."/".$BID."/updir/".$RepleList["MID"]."/";
	$bigimagpath = "/config/wizboard/table/".$GID."/".$BID."/updir/".$RepleList["MID"]."/".$RepleList["ATTACHED"];

	//echo $filepath, "/", $RepleList["ATTACHED"];
?>   
	<td width="176"><table width="160" height="119" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" class="bd1" style="padding:3px;"><a class="single" href="<?php echo $bigimagpath;?>" title="<?php echo addslashes($RepleList["SUBJECT"]);?>"><img src="<?php echo $common->getthumbimg($filepath, $RepleList["ATTACHED"], 150, 113, null, true) ?>" width="150" height="113" border="0"></a></td>
        </tr>
      </table>
      <table width="160" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td height="10" colspan="2"></td>
        </tr>
        <tr class="ft2">
          <td width="40" height="25" align="center" bgcolor="#E8E8E8" class="ft2 style3">제목</td>
          <td height="25"  width="115" bgcolor="#F3F3F3" class="dot"> <?php echo $RepleList["SUBJECT"]?>
          	
<?php
if ($board->is_admin("../../../"))  echo '<a href="javascript:deleteComment(\''.$RepleList["UID"].'\')">[삭제]</a>';
?>
          </td>
        </tr>
      </table></td>
<?php
$cnt++;
if($cnt%3) echo "";
if(!($cnt%3) && $cnt != $comment_total) echo"</tr><tr align='center' valign='top'><td colspan='3'>&nbsp;</td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='0'><tr align='center' valign='top'>";
endwhile;
$tmpcnt = $cnt%3;

if($tmpcnt) for($i=$tmpcnt; $i<3; $i++){
	echo "<td width='176'></td>";
}

if(!$board->page_var["tc"]):/* 게시물이 존재하지 않을 경우 */

endif;
?>      
	  
  </tr>

</table>

<div>
<?php
$params = array("listno"=>$comment_listno,"pageno"=>$comment_pageno	,"cp"=>$cp,"total"=>$comment_total, "type"=>"bootstrappost"); 
echo $common->paging($params);
?>
</div>


<form id="comment_write_form" method="POST" enctype="multipart/form-data"><!-- action="./lib/ajax.board.php" -->
	
	<input type="hidden" name="UID" value="<?php echo $UID?>">
	<input type="hidden" name="BID" value="<?php echo $BID?>">
	<input type="hidden" name="GID" value="<?php echo $GID?>">
	<input type="hidden" name="smode" value="insertreple">
	<input type="hidden" name="RUID" value="">
	<!--
	<input type="hidden" name="adminmode" value="<?php echo $adminmode?>">
	<input type="hidden" name="cp" value="<?php echo $cp?>">
	<input type="hidden" name="BOARD_NO" value="<?php echo $BOARD_NO?>">
	<input type="hidden" name="ID" value="<?php echo $cfg["member"]["mid"]?>">
	
	<input type="hidden" name="ismember" value="false"><!-- 자바스크립트 제어를 위해 회원전용:true, 일반 : false 로서 플래그 값변경
	-->
	<input type="hidden" id="comment_spam_free" name="spamfree" value=""> 
	
	<table class="table">
		<col width = "100px">
		<col width = "*">
		<tr> 
			<th>
				제목
			</th>
			<td>
				<input type="text" name="SUBJECT" width="300px" class="required " value="" msg="제목을 입력하세요"> 
			</td>
		</tr>
		<tr> 
			<th>
				첨부화일
			</th>
			<td>
				 <input type="file" name="file[]" />
			</td>
		</tr>
	
	</table>
	<button type="submit" class="btn btn-default">저장</button>
</form>