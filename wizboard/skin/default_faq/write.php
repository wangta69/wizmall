<div id="WRITE_FORM_TRANSFER_DIV" style="display:none">
작성글을 저장중입니다.
<p>&nbsp;</p>
잠시만 기다려 주시기 바랍니다.
</div>
<div id="WRITE_FORM_DIV" style="display:block">
  <form name="BOARD_WRITE_FORM" action="<?=$PHP_SELF?>" method="post" enctype="multipart/form-data"  onsubmit="return board_write_fnc(this);">
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
    <table width="100%" border="0" cellspacing="1" cellpadding="5">
      <? 
if($cfg["wizboard"]["CategoryEnable"]):
?>
      <tr>
        <td width="100" align="center" bgcolor="<?=$Bgcolort?>"><font color="<?=$Fontcolort?>"  style="font-family: '굴림', '돋움','Arial';font-size: 12px; line-height:140%">종류</font></td>
        <td width="100" bgcolor="<?=$Bgcolorl?>"><?=$board->getselectcategory($list["CATEGORY"])?>
        </td>
      </tr>
      <? endif; ?>
      <tr>
        <td width="100" align="center" bgcolor="<?=$Bgcolort?>"><font color="<?=$Fontcolort?>"  style="font-family: '굴림', '돋움','Arial';font-size: 12px; line-height:140%">제 
          목</font></td>
        <td bgcolor="<?=$Bgcolorl?>"><input type="text" name="SUBJECT" size="40" value="<?=$list[SUBJECT];?>" checkenable msg="제목을 입력하세요"></td>
      </tr>
      <tr>
        <td width="100" align="center" bgcolor="<?=$Bgcolort?>"><font color="<?=$Fontcolort?>"  style="font-family: '굴림', '돋움','Arial';font-size: 12px; line-height:140%">텍스트타입</font></td>
        <td bgcolor="<?=$Bgcolorl?>"><table width="132" height="19" border="0" cellpadding="0" cellspacing="0"  style="font-family: '굴림', '돋움','Arial';font-size: 12px; line-height:140%">
            <tr>
              <td bgcolor="<?=$Bgcolorl?>"><font color="#FFFFFF">
                <input type="radio" name="TxtType" value="0" <? if(!$list["TxtType"]) ECHO "CHECKED";?>>
                </font></td>
              <td><font color="<?=$Fontcolort?>">Text</font> </td>
              <td><font color="#FFFFFF">
                <input type="radio" name="TxtType" value="1" <? if(!strcmp($list["TxtType"],"1")) ECHO "CHECKED";?>>
                </font></td>
              <td><font color="<?=$Fontcolort?>">Html</font></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td width="100" align="center" bgcolor="<?=$Bgcolort?>"><font color="<?=$Fontcolort?>"  style="font-family: '굴림', '돋움','Arial';font-size: 12px; line-height:140%">내 
          용</font></td>
        <td bgcolor="<?=$Bgcolorl?>"><textarea name="CONTENTS" rows="15" style="width:100%;" checkenable msg="내용을 입력하세요"><?=$list[CONTENTS];?>
</textarea>
        </td>
      </tr>
      <?
		for($i=0; $i<$WIZCONF["ATTACHEDCOUNT"]; $i++){
		?>
      <tr>
        <td width="100" align="center" bgcolor="<?=$Bgcolort?>"><font color="<?=$Fontcolort?>"  style="font-family: '굴림', '돋움','Arial';font-size: 12px; line-height:140%">첨부화일</font></td>
        <td bgcolor="<?=$Bgcolorl?>"><input type="file" name="file[<?=$i;?>]">
          <? if($mode == "modify") echo "<input name='file_del[$i]' type='checkbox' value='1'>파일삭제"; ?>
        </td>
      </tr>
      <?
	   }
	  ?>
    </table>
    <div id="iconbox"><? echo $board->showBoardIcon('save');?> <? echo $board->showBoardIcon('cancel');?></div>
  </form>
</div>
