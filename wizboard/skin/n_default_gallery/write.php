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
    <input type="hidden" name="CATEGORY" value="<?=$category?>">
    <input type="hidden" name="ID" value="<?=$cfg["member"]["mid"];?>">
    <input type="hidden" name="spamfree" value="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr  height="2" >
              <td height="2" colspan="7" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td width="99" height="30" align="center">제목</td>
              <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="1" height="25"></td>
              <td colspan="5" align="left">&nbsp;&nbsp;
               <input name="SUBJECT" type="text" id="SUBJECT" style="border: 1px CCCCCC solid;background-color: #F7F7F7;font-family: '굴림';font-size: 12px;line-height: 18px;color: #333333;" value="<?=$list[SUBJECT];?>" size="50" checkenable msg="제목을 입력하세요" autocomplete="off" />
               
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
if($_COOKIE[BOARD_PASS] || $_COOKIE[ROOT_PASS]):
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
<? 
if($cfg["wizboard"]["CategoryEnable"]):
?>
            <tr>
              <td width="99" height="30" align="center"> 카테고리 </td>
              <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="1" height="25"></td>
              <td colspan="5" align="left">&nbsp;&nbsp;
<?=$board->getselectcategory($list["CATEGORY"])?>              </td>
            </tr>
            <tr  height="1">
              <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
            </tr>
<? endif; ?>
           
            <tr>
              <td height="180" colspan="7" align="center"><textarea name="CONTENTS" rows="15" id="CONTENTS" checkenable msg="내용을 입력하세요" style=" width:98%; border: 1px CCCCCC solid;background-color: #F7F7F7;font-family: '굴림';font-size: 12px;line-height: 18px;color: #333333;"><?=$list[CONTENTS];?></textarea></td>
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
               
                <input type="file" name="file[<?=$i;?>]" style="width:350px; border: 1px CCCCCC solid;background-color: #F7F7F7;font-family: '굴림';font-size: 12px;line-height: 18px;color: #333333;" />
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