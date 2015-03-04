<div id="WRITE_FORM_TRANSFER_DIV" style="display:none">
작성글을 저장중입니다.
<p>&nbsp;</p>
잠시만 기다려 주시기 바랍니다.
</div>
<div id="WRITE_FORM_DIV" style="display:block">
  <form name="BOARD_WRITE_FORM" action="<?=$PHP_SELF?>" method="post" enctype="multipart/form-data" onsubmit="return board_write_fnc(this);">
    <? if(!$bmode) $bmode="write"; ?>
    <input type="hidden" name="blank" value="">
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
        <td height="2" colspan="7" bgcolor="#999999"></td>
      </tr>
      <tr>
        <td width="99" height="30" align="center">제목</td>
        <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/dotline.gif" width="1" height="25"></td>
        <td width="520" colspan="5">&nbsp;&nbsp;
          <input name="SUBJECT" type="text"  checkenable msg="제목을 넣어주세요" value="<?=$list[SUBJECT];?>" size="60" maxlength="80" >
        </td>
      </tr>
      <tr  height="1">
        <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td width="99" height="30" align="center">옵션</td>
        <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/dotline.gif" width="1" height="25"></td>
        <td colspan="5">&nbsp;&nbsp;
          <input type=checkbox name="TxtType" value="1" <? if($list["TxtType"]) ECHO "CHECKED";?>>
          HTML사용
          <input type=checkbox value="1" name=Secret<? if($list["Secret"]) echo " checked";?>>
          비밀 게시물
          <?
//echo $_COOKIE[BOARD_PASS].",".$_COOKIE[ROOT_PASS];		  
if($_COOKIE[BOARD_PASS] || $_COOKIE[ROOT_PASS]):
?>
          <input type=checkbox value="1" name=MainDisplay<? if($list["MainDisplay"]) echo " checked";?>>
          공지글
          <?
endif;
?>
        </td>
      </tr>
      <tr  height="1">
        <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="180" colspan="7" align="center"><textarea name="CONTENTS" rows="12"  checkenable msg="내용을 넣어주세요" style=" width:99%; border:1px DDDECE solid;background-color: #F5F5F0;;font-family: "굴림";font-size: 12px;line-height: 18px;color: #333333;"><?=$list[CONTENTS];?>
</textarea></td>
      </tr>
      <tr  height="1">
        <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
      </tr>
      <?
		for($i=0; $i<$cfg["wizboard"]["ATTACHEDCOUNT"]; $i++){
		?>
      <tr>
        <td width="100" align="center" bgcolor="#EBEBEB"><font  style="font-family: '굴림', '돋움','Arial';font-size: 12px; line-height:140%">첨부화일</font></td>
        <td colspan="3"><input type="file" name="file[<?=$i;?>]">
          <? if($mode == "modify" && $list["filename"][$i]) echo $common->getImgName($list["filename"][$i])." <input name='file_del[$i]' type='checkbox' value='1'>파일삭제"; ?>
        </td>
      </tr>
      <tr  height="1">
        <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
      </tr>      
      <?
	   }
	  ?>
      <tr>
        <td colspan="7" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><div id="iconbox"><? echo $board->showBoardIcon('save');?> <? echo $board->showBoardIcon('cancel');?></div></td>
      </tr>
    </table>
  </form>
</div>
