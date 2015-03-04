<script>
$(function(){
	$(".comment_modify").click(function(){
		var uid = $(this).attr("data");
		var bid = $("#hidden_bid").val();
		var gid = $("#hidden_gid").val();
		$.post("./lib/ajax.board.php", {smode:"getmainreple", uid:uid, bid:bid, gid:gid}, function(data){
			eval("var obj="+data);
			$("#CONTENTS").val(obj["CONTENTS"]);
			$("#hidden_uid").val(uid);
			$("#hidden_mode").val("modify");
			$("#hidden_bmode").val("modify");
		});
		//alert(uid);
	});
	
	$(".replecomment").click(function(){
		//alert("replecomment");
		var i = $(".replecomment").index(this);
		var uid = $(this).attr("uid");
		$(".commentHtml").eq(i).show();
		$(".commentHTML").html("");
		$(".commentHTML").eq(i).load("./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/repleWrite.php", function(){
			//alert("");
			$("#reple_hidden_uid").val(uid);
			$("#htmlSaveBtn").html('<? if($cfg["member"]["mid"]) echo "<img src=\"/wizboard/icon/n_default/save_btn.gif\" id=\"btn_board_write\">";?>');
			
		});
		
	});

	$("#btn_board_write").live("click", function(){
		$("#reple_hidden_spamfree").val('<?=time()?>');
		$("#board_write_form").attr("action", "/wizboard.php");
		$("#reple_hidden_bid").val("<?=$BID?>");
		$("#reple_hidden_gid").val("<?=$GID?>");
		$("#reple_hidden_adminmode").val("<?=$adminmode?>");
		$("#reple_hidden_optionmode").val("<?=$optionmode?>");

		 
		$("#reple_hidden_CATEGORY").val("<?=$category?>");
		$("#reple_hidden_ID").val("<?=$cfg["member"]["mid"];?>");
		$("#board_write_form").submit();

	});
});
</script>
<div id="WRITE_FORM_TRANSFER_DIV" style="display:none"> 작성글을 저장중입니다.
  <p>&nbsp;</p>
  잠시만 기다려 주시기 바랍니다. </div>
<div id="WRITE_FORM_DIV" style="display:block">
  <form name="BOARD_WRITE_FORM" action="<?=$PHP_SELF?>" method="post" enctype="multipart/form-data" onsubmit="return board_write_fnc(this);">
    <? if(!$bmode) $bmode="write"; ?>
    <input type="hidden" name="blank" value="">
    <!-- mysql에서 언어가 kr 이 아닌경우 modify시 맨처음 hidden값이 사라지는 알지못할 버그발생땜에 -->
    <input type="hidden" id="hidden_bid" name="BID" value="<?=$BID?>">
    <input type="hidden" id="hidden_gid" name="GID" value="<?=$GID?>">
    <input type="hidden" id="hidden_mode" name="mode" value="write">
    <input type="hidden" id="hidden_bmode" name="bmode" value="write">
    <input type="hidden" name="adminmode" value="<?=$adminmode?>">
    <input type="hidden" name="optionmode" value="<?=$optionmode?>">
    <input type="hidden" id="hidden_uid" name="UID" value="">
	<input type="hidden" name="flag" value="list_only">
	 
    <input type="hidden" name="CATEGORY" value="<?=$category?>">
    <input type="hidden" name="ID" value="<?=$cfg["member"]["mid"];?>">
    <input type="hidden" name="spamfree" value="">
     <input type="hidden" name="SUBJECT" value="한줄쓰기" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <col width="*" />
    <col width="1px" />
    <col width="100px" />
      <tr height="2" >
        <td colspan="3" bgcolor="#999999"></td>
      </tr>
      <tr>
        <td class="agn_l"><textarea name="CONTENTS" rows="3" id="CONTENTS" checkenable msg="내용을 입력하세요" class="board_text"  style="width:98%;" /><? if(!$cfg["member"]["mid"]) echo "로그인 해주세요";?></textarea></td>
        <td align="center"></td>
        <td align="center"><? if($cfg["member"]["mid"]) echo $board->showBoardIcon('save');?></td>
      </tr>
      <tr height="1">
        <td height="1" colspan="3" align="center" bgcolor="#CCCCCC"></td>
      </tr>
      <?
		for($i=0; $i<$cfg["wizboard"]["ATTACHEDCOUNT"]; $i++){
?>
      <tr height="30">
        <td class="agn_l"><input type="file" name="file[<?=$i?>]" style="width:350px;" class="board_text" />
          <? if($mode == "modify" && $list["filename"][$i]) echo $common->getImgName($list["filename"][$i])." <input name='file_del[$i]' type='checkbox' value='1'>파일삭제"; ?></td>
        <td align="center" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="1" height="25"></td>
        <td align="left">&nbsp;&nbsp;</td>
      </tr>
      <tr height="1">
        <td colspan="3" align="center" bgcolor="#CCCCCC"></td>
      </tr>
      <?
}//for($i=0; $i<$cfg["wizboard"]["ATTACHEDCOUNT"]; $i++){
?>
      <tr>
        <td colspan="3" align="center">&nbsp;</td>
      </tr>
    </table>
  </form>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><!-- ##################board list 테이블시작입니다##########################-->
      <form NAME="board_search" action="<?=$PHP_SELF?>" mehtod="POST" onsubmit="return boardSearch(this)">
        <input type="hidden" name="BID" value="<?=$BID?>" >
        <input type="hidden" name="GID" value="<?=$GID?>" >
        <input type="hidden" name="adminmode" value="<?=$adminmode?>">
        <input type="hidden" name="optionmode" value="<?=$optionmode?>">
        <input type="hidden" name="category" value="<?=$category?>">
        <input type="hidden" name="mode" value="<?=$mode?>">
        <input type="hidden" name="UID" value="<?=$UID?>">
        <input type="hidden" name="cp" value="<?=$cp?>">
      </form>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <col width="33px" title="board no">
	  <col width="2px" title="space">
	  <col width="*" title="">
	  <col width="2px" title="space">
	   <col width="120px" title="">
        <? 
$result = $board->getboardlist();
$cnt=0;
while($list = $dbcon->_fetch_array($result)):
	//$list = $dbcon->_fetch_assoc($result);
	$list = $board->listtrim($list);##현재의 리스트를 기준으로 필요한 필드를 처리한다.
	##listtrim은 기본적인 리스트 처리이고 별도로 할경우 상기 listtrim을 빼고 바로 작업하거나 별도의 함수를 생성하여 처리한다.
	$list["print_subject"] = $UID==$list["UID"]? "<font color='#FF0000'>".$list["print_subject"]."</font>":$list["print_subject"];
	$getdata="BID=".$BID."&GID=".$GID."&adminmode=".$adminmode."&optionmode=".$optionmode."&category=".$category."&mode=view&UID=".$list["UID"];
	$getdata.="&search_term=".$search_term."&SEARCHTITLE=".$SEARCHTITLE."&searchkeyword=".urlencode($searchkeyword);
	$getdata = $common->getencode($getdata);
?>
        <tr>
          <td width="33" height="37" align="center" valign="top"><?=$board->ini_board_no;?></td>
          <td width="2" valign="top"> </td>
          <td align="left" valign="top">
           <p  style="color:#FF6600"> <?=$list["pre_reple_space"] ?> <?=$list["NAME"];?> <? if($list["SUB_TITLE1"]) echo "[".$list["SUB_TITLE1"]."]"; ?> <?=date("Y.m.d H:I", $list["W_DATE"])?></p>

            <?=nl2br($list["CONTENTS"]);?>            </td>
          <td width="2">&nbsp;</td>
          <td width="53" align="center">
<? 
if(($list["ID"] == $cfg["member"]["mid"] || $board->is_admin()) && $cfg["member"]["mid"]):?>
<span class="button bull comment_modify hand" data="<?=$list["UID"]?>"><a>수정</a></span>
<span class="button bull"><a href="javascript:DELETE_THIS('<?=$list["UID"]?>','<?=$board->page_var["cp"]?>','<?=$board->bid?>','<?=$board->gid?>','<?=$board->adminmode?>','<?=$board->optionmode?>');">삭제</a></span>
<? endif;?>
<span class="button bull replecomment" uid="<?=$list["UID"];?>"><a>답글</a></span></td>
        </tr>
       <tr class="commentHtml none">
          <td colspan="5"><div class="commentHTML"></div></td>
        </tr>
        <tr>
          <td height="1" colspan="5" bgcolor="E6E6E6"> </td>
        </tr>
        <?
$board->ini_board_no--;
$cnt++;
endwhile;
if(!$board->page_var["tc"]):/* 게시물이 존재하지 않을 경우 */
?>
        <tr>
          <td height="26" colspan="5" align="center" >등록된글이없습니다</td>
        </tr>
        <tr bgcolor="E6E6E6">
          <td height="1" colspan="5"></td>
        </tr>
        <?
endif;
?>
        <tr>
          <td height="26" colspan="5" align="center"><table width="100%" height="26"  border="0" cellpadding="0" cellspacing="1" bgcolor="D7D7D7">
              <tr>
                <td height="15" bgcolor="#F3F3F3">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
      </table>
      <div class="agn_c">
        <?
include "./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/index.php";
?>
      </div></td>
  </tr>
</table>
