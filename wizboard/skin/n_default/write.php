<div id="WRITE_FORM_TRANSFER_DIV" style="display:none">
작성글을 저장중입니다.
<p>&nbsp;</p>
잠시만 기다려 주시기 바랍니다.
</div>
<div id="WRITE_FORM_DIV" style="display:block">
  <form name="BOARD_WRITE_FORM" action="<?=$PHP_SELF?>" method="post" enctype="multipart/form-data" onsubmit="return board_write_fnc(this);">
    <? if(!$bmode) $bmode="write"; ?>
    <input type="hidden" name="blank" value="">
    <!-- mysql에서 언어가 kr 이 아닌경우 modify시 맨처음 hidden값이 사라지는 알지못할 버그발생땜에 -->
    <input type="hidden" name="BID" value="<?=$BID?>">
    <input type="hidden" name="GID" value="<?=$GID?>">
    <input type="hidden" name="mode" value="<?=$mode?>">
    <input type="hidden" name="bmode" value="<?=$mode;?>">
    <input type="hidden" name="adminmode" value="<?=$adminmode?>">
    <input type="hidden" name="optionmode" value="<?=$optionmode?>">
    <input type="hidden" name="UID" value="<?=$list["UID"];?>">
    <input type="hidden" name="c_category" value="<?=$category?>">
<? if(!$cfg["wizboard"]["CategoryEnable"]) echo "<input type=\"hidden\" name=\"CATEGORY\" value=\"".$list["CATEGORY"]."\">"; ?>
    <input type="hidden" name="ID" value="<?=$cfg["member"]["mid"];?>">
    <input type="hidden" name="spamfree" value="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<col width="100px" />
        	<col width="2px" />
        	<col width="*" />
        	<col width="2px" />
        	<col width="100px" />
        	<col width="2px" />
        	<col width="200px" />
            <tr  height="2" >
              <td height="2" colspan="7" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td width="99" height="30" align="center">제목</td>
              <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="1" height="25"></td>
              <td colspan="5" align="left">&nbsp;&nbsp;
               <input name="SUBJECT" type="text" id="SUBJECT" class="board_text" value="<?=$list[SUBJECT];?>" size="50" checkenable msg="제목을 입력하세요" autocomplete="off" />
               
<?
if($cfg["wizboard"]["editorenable"] == "1"){
?>
<input type=hidden name="TxtType" value="1" /> 
<?
}else{
?>
               <input type=checkbox name="TxtType" <? if(!strcmp($list["TxtType"],"1")) ECHO " checked";?> value="1" />                
               HTML사용&nbsp;&nbsp;
<?
}
?>

                <input type=checkbox name="Secret" <? if($list["Secret"]) echo " checked";?> value="1">
                비밀글                      &nbsp;&nbsp;
          
 <?
//echo $_COOKIE[BOARD_PASS].",".$_COOKIE[ROOT_PASS];		  
if ($board->is_admin()) :
?>
          <input type=checkbox value="1" name="MainDisplay"<? if($list["MainDisplay"]) echo " checked";?>>
          공지글
          <?
endif;
?>              </td>
            </tr>
            <tr  height="1">
              <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
            </tr>
            <tr>
              <td height="30" align="center">글쓴이</td>
              <td align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="1" height="25"></td>
              <td align="left">&nbsp;&nbsp;<input type="text" name="NAME" size="15" value="<? if($list["NAME"]) echo $list["NAME"]; else echo $cfg["member"]["mname"];?>" checkenable msg="이름을 입력하세요" autocomplete="off" class="board_text" />              </td>
              <td align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="1" height="25"></td>
              <td align="center">비밀번호</td>
              <td align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="1" height="25"></td>
              <td align="left">&nbsp;&nbsp;<input type="password" name="PASSWD" size="15" value="<? echo $list["PASSWD"]; ?>" checkenable msg="비밀번호를 입력하세요" autocomplete="off" class="board_text" /></td>
            </tr>
            <tr  height="1">
              <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
            </tr>
            <tr>
              <td height="30" align="center">이메일</td>
              <td align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="1" height="25"></td>
              <td colspan="5" align="left">&nbsp;&nbsp;<input type="text" name="EMAIL" size="40" value="<? if($list["EMAIL"]) echo $list["EMAIL"]; else echo $cfg["member"]["mmail"];?>" autocomplete="off"  class="board_text" /></td>
            </tr>
            <tr  height="1">
              <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
            </tr>
<? 
if($cfg["wizboard"]["CategoryEnable"]):
?>
            <tr>
              <td height="30" align="center"> 카테고리 </td>
              <td align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="1" height="25"></td>
              <td colspan="5" align="left">&nbsp;&nbsp;
<? 
$selcat = $list["CATEGORY"] != "" ? $list["CATEGORY"] :$category;
echo $board->getselectcategory($selcat)
?>               </td>
            </tr>
            <tr  height="1">
              <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
            </tr>
<? endif; ?>
           
            <tr>
              <td colspan="7" align="center"><textarea name="CONTENTS" rows="15" id="CONTENTS" checkenable msg="내용을 입력하세요" class="board_text"  style=" width:98%;" /><?=$list[CONTENTS];?></textarea></td>
            </tr>
            <tr  height="1">
              <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
            </tr>
<?
if($cfg["wizboard"]["editorenable"] == "1"){
?>
<script>
var oEditors = [];
nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "CONTENTS",
	sSkinURI: "./js/Smart/SmartEditor2Skin.html",
	fCreator: "createSEditor2"
});
</script>
<?
}//if($cfg["wizboard"]["editorenable"] == "1"){
		for($i=0; $i<$cfg["wizboard"]["ATTACHEDCOUNT"]; $i++){
?>
            <tr>
              <td width="99" height="30" align="center">첨부파일(<?=$i?>)</td>
              <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="1" height="25"></td>
              <td colspan="5" align="left">&nbsp;&nbsp;
               
                <input type="file" name="file[<?=$i?>]" style="width:350px;" class="board_text" />
                <? if($mode == "modify" && $list["filename"][$i]) echo $common->getImgName($list["filename"][$i])." <input name='file_del[$i]' type='checkbox' value='1'>파일삭제"; ?></td>
            </tr>
            <tr  height="1">
              <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
            </tr>
<?
}//for($i=0; $i<$cfg["wizboard"]["ATTACHEDCOUNT"]; $i++){
?>
            <tr>
              <td colspan="7" align="center">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center"><table height="30" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="62"><? echo $board->showBoardIcon('save');?></td>
              <td width="62"><? echo $board->showBoardIcon('cancel');?></td>
            </tr>
          </table></td>
      </tr>
  </table>
  </form>
</div>