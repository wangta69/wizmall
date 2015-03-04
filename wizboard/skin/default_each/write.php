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
      <tr  height="2" >
        <td height="1" colspan="7" bgcolor="#cccccc"></td>
      </tr>
      <tr>
        <td width="99" height="35" align="center" bgcolor="#f7f7f8">제목</td>
        <td width="1" align="center" valign="middle" bgcolor="#f7f7f8"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/dotline.gif" width="1" height="25"></td>
        <td colspan="5" bgcolor="#f7f7f8">&nbsp;
          <input name="SUBJECT" type="text"  checkenable msg="제목을 넣어주세요" value="<?=$list[SUBJECT];?>" style="width:98%" maxlength="80" >
        </td>
      </tr>
      <tr  height="1">
        <td height="1" colspan="7" align="center" bgcolor="#EBEBEB"></td>
      </tr>
      <tr>
        <td width="99" height="35" align="center" bgcolor="#FFFFFF">옵션</td>
        <td width="1" align="center" valign="middle" bgcolor="#FFFFFF"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/dotline.gif" width="1" height="25"></td>
        <td colspan="5" bgcolor="#FFFFFF">&nbsp;
          <input type=checkbox name="TxtType" value="1" <? if($list["TxtType"]) ECHO "CHECKED";?>>
          HTML사용 </td>
      </tr>
      <tr  height="1">
        <td height="1" colspan="7" align="center" bgcolor="#EBEBEB"></td>
      </tr>
      <tr>
        <td height="180" colspan="7" align="center"><textarea name="CONTENTS" rows="12"  checkenable msg="내용을 넣어주세요" style="width:98%; border:1px EBEBEB solid;background-color: #F7F7F8;;font-family: "굴림";font-size: 12px;line-height: 18px;color: #333333;"><?=$list[CONTENTS];?>
</textarea></td>
      </tr>
      <tr  height="1">
        <td height="1" colspan="7" align="center" bgcolor="#E1E1E1"></td>
      </tr>
      <? if(!strcmp($ATTACH1, "checked")):?>
      <tr>
        <td width="99" height="30" align="center">첨부파일</td>
        <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="<%=skin_path%>images/dotline.gif" width="1" height="25"></td>
        <td colspan="5">&nbsp;&nbsp;
          <input name="file[0]" type="file"  id="file[0]" size="65" maxlength="80">
          <? if($mode == "modify") echo "<input name='file_del[0]' type='checkbox' value='1'>파일삭제"; ?>
        </td>
      </tr>
      <tr  height="1">
        <td height="1" colspan="7" align="center" bgcolor="#E1E1E1"></td>
      </tr>
      <? endif; ?>
      <tr>
        <td colspan="7" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><div id="iconbox"><? echo $board->showBoardIcon('save');?> <? echo $board->showBoardIcon('cancel');?></div></td>
      </tr>
    </table>
  </form>
</div>
