<?php
#CREATE TABLE `wizpopup` (
#  `uid` int(6) NOT NULL auto_increment,
#  `pskinname` varchar(50) NOT NULL default '',
#  `pwidth` int(5) NOT NULL default '0',
#  `pheight` int(5) NOT NULL default '0',
#  `ptop` int(5) NOT NULL default '0',
#  `pleft` int(5) NOT NULL default '0',
#  `psubject` varchar(250) NOT NULL default '',
#  `pcontents` text NOT NULL,
#  `pattached` varchar(100) NOT NULL default '',
#  `popupenable` int(2) NOT NULL default '0',
#  `options` text NOT NULL,
#  PRIMARY KEY  (`uid`)
#) type=MyISAM AUTO_INCREMENT=1 ;

$tbl_name="wizpopup";
/******************************************************************************/

if ($query == 'qde') {   //삭제옵션시 실행
while (list($key,$value) = each($_GET)) {
        if(ereg("deleteItem", $key)) {
                $sqlstr = "SELECT * FROM ".$tbl_name." WHERE uid=".$value;
                $LIST = $dbcon->_fetch_array($dbcon->_query($sqlstr));
				$Loaded = explode("|", $LIST["pattached"]);
				for($i=0; $i<sizeof($Loaded); $i++){
               	 if (is_file("../config/wizpopup/".$Loaded[$i]) && $Loaded[$i]) {
                  	      unlink("../config/wizpopup/".$Loaded[$i]);
				 }
                }
                $dbcon->_query("DELETE FROM ".$tbl_name." WHERE uid=".$value);
        }
} 
} //삭제옵션 끝

//include "../wizboard/func/STR_CUTTING_FUNC.php";
$WHERE = "WHERE uid <> '0' ";
/* 총 갯수 구하기 */
$TOTAL_STR = "SELECT count(uid) FROM ".$tbl_name." ".$WHERE;
$TOTAL = $dbcon->get_one($TOTAL_STR);
$LIST_NO=10; /* 페이지당 출력 리스트 수 */
$PageNo=10; /* 페이지 밑의 출력 수 */
if(empty($SUB_cp) || $SUB_cp <= 0) $SUB_cp = 1;
?>
<script>
$(function(){
	$(".btn_delete").click(function(){
		if($(".Item:checkbox:checked").length < 1){
			jAlert('한개이상 선택해 주세요.');
		}else{

			jConfirm('삭제되는 메시지는 복구 불가능합니다.\n삭제하시겠습니까', '', function(rtn){
				
				if(rtn == true) $("#l_form").submit();
			
			});

		}
	});
	
	$(".direct").click(function(){
		var i	= $(".direct").index(this);
		var status_1	= $(this).parent().parent().attr("status");
		var status		= status_1.split(",");
		
		var url = "../../util/wizpopup/index.php?uid="+status[0];
		$(this).popup({url:url, top:status[2], left:status[1], width:status[3], height:status[4]});
	});	
})

	function popupview(uid, pleft, ptop, pwidth, pheight){
		window.open('../util/wizpopup/index.php?uid='+uid,'PopUpWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,left='+pleft+',top='+ptop+',width='+pwidth+',height='+pheight);
	
	}


	function gotoPage(cp){
		$("#cp").val(cp);
		$("#sform").submit();
	}
	
</script>
<form id="sform">
	<input type='hidden' name='menushow' value='<?php echo $menushow?>'>
	<input type="hidden" name="theme"  value='<?php echo $theme?>'>
	<input type="hidden" name="cp" id="cp"  value='<? echo $cp?>' >
</form>

<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">팝업창 관리</div>
	  <div class="panel-body">
		 팝업창을 관리 하실 수 있습니다.
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
      <p></p>
      <form action="<?php echo $PHP_SELF?>" name="l_form" id="l_form">
        <input type='hidden' name='menushow' value='<?php echo $menushow?>'>
        <input type="hidden" name="theme" value="<?php echo $theme;?>">
        <input type="hidden" name="cp" value="<?php echo $cp?>">
        <input type="hidden" name="SUB_cp" value="<?php echo $SUB_cp?>">
        <input type="hidden" name="query" value="qde">
        <input type="hidden" name="flag1" value="<?php echo $flag1?>">
       <table class="table table-hover table-striped">
        <col width="50px" title="삭제" />
        <col width="80px" title="사용여부" />
        <col width="*" title="제목" />
        <col width="50px" title="보기" />
        <col width="50px" title="수정" />
          <tr class="success">
            <th>삭제</th>
            <th>사용여부</th>
            <th>제목</th>
            <th>보기</th>
            <th>수정</th>
          </tr>
<?php
$START_NO = ($SUB_cp - 1) * $LIST_NO;
$BOARD_NO=$TOTAL-($LIST_NO*($SUB_cp-1));
$sqlstr="SELECT * FROM ".$tbl_name." ".$WHERE." ORDER BY uid DESC LIMIT ".$START_NO.", ".$LIST_NO;
//echo "sqlstr = $sqlstr <br />";
$sqlqry=$dbcon->_query($sqlstr);
while($LIST=@$dbcon->_fetch_array($sqlqry)):
?>
          <tr status="<?php echo $LIST["uid"]?>,<?php echo $LIST["pleft"]?>,<?php echo $LIST["ptop"]?>,<?php echo $LIST["pwidth"]?>,<?php echo $LIST["pheight"]?>">
            <td><input type="checkbox" class="Item" name="deleteItem_<?php echo $LIST["uid"]?>" value="<?php echo $LIST["uid"]?>">
            </td>
            <td><?php echo $LIST["popupenable"]=="1"?"보임":"숨김";?> </td>
            <td><?php echo $LIST["psubject"];?>
            </td>
            <td><span class="button bull"><!-- class=" direct"를 주면 팝업 레이어로 변신--><a href="javascript:popupview('<?php echo $LIST["uid"]?>', '<?php echo $LIST["pleft"]?>', '<?php echo $LIST["ptop"]?>', '<?php echo $LIST["pwidth"]?>', '<?php echo $LIST["pheight"]?>')">보기</a></span></td>
            <td><span class="button bull"><a href="<?php echo $PHP_SELF?>?menushow=<?php echo $menushow?>&theme=util/popup1_write&mode=qup&uid=<?php echo $LIST["uid"];?>">수정</a></span></td>
          </tr>
<?php
$BOARD_NO--;
endwhile;
?>
        </table>
        <div class="w_default"><span class="button bull btn_delete"><a>삭제</a></span>
         <span class="button bull"> <a href="<?php echo $PHP_SELF?>?menushow=<?php echo $menushow?>&theme=util/popup1_write&mode=qin">등록</a></span> </div>
      </form>
	<div class="text-center">
<?php
$params = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL, "type"=>"bootstrappost"); 
echo $common->paging($params);
?>
	</div>
	</td>
  </tr>
</table>
