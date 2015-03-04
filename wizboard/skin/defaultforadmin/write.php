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
    <table cellspacing=1 bordercolordark=white width="100%" bgcolor=#c0c0c0 bordercolorlight=#dddddd border=0 class="s1">
      <tr bgcolor="#FFFFFF">
        <td width="100" height="27" align="center" bgcolor="F2F2F2"><font color="<?=$Fontcolort?>"  style="font-family: '굴림', '돋움','Arial';font-size: 12px; line-height:140%">이 
          름</font></td>
        <td height="27"><input type="text" name="NAME" size="15" value="<? if($list[NAME]) echo "$list[NAME]"; else echo $cfg["member"]["mname"];?>">
        </td>
        <td width="100" height="27" align="center" bgcolor="F2F2F2"><font color="<?=$Fontcolort?>"  style="font-family: '굴림', '돋움','Arial';font-size: 12px; line-height:140%">비밀번호</font></td>
        <td height="27"><input type="password" name="PASSWD" size="15" <? if($_COOKIE[BOARD_PASS] || $_COOKIE[ROOT_PASS]) echo "value='$list[PASSWD]'"; ?>>
        </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td width="100" align="center" bgcolor="F2F2F2"><font color="<?=$Fontcolort?>"  style="font-family: '굴림', '돋움','Arial';font-size: 12px; line-height:140%">전자메일</font></td>
        <td colspan="3"><input type="text" name="EMAIL" size="40" value="<? if($list[EMAIL]) echo "$list[EMAIL]"; else echo $cfg["member"]["mmail"];?>">
        </td>
      </tr>
      <? 
if($cfg["wizboard"]["CategoryEnable"]):
$fileArr = file("./config/wizboard/table/$BID/config6.php");
?>
      <tr bgcolor="#FFFFFF">
        <td width="100" align="center" bgcolor="F2F2F2"><font color="<?=$Fontcolort?>"  style="font-family: '굴림', '돋움','Arial';font-size: 12px; line-height:140%">종류</font></td>
        <td colspan="3"><?=$board->getselectcategory($list["CATEGORY"])?>
        </td>
      </tr>
      <? endif; ?>
      <tr bgcolor="#FFFFFF">
        <td width="100" align="center" bgcolor="F2F2F2"><font color="<?=$Fontcolort?>"  style="font-family: '굴림', '돋움','Arial';font-size: 12px; line-height:140%">제 목</font></td>
        <td colspan="3"><input type="text" name="SUBJECT" size="40" value="<?=$list[SUBJECT];?>">
          <!--<input type=checkbox value="secrete" name=SPARE1<? if($list[SPARE1]=="secrete") echo " checked";?>>
        비밀 게시물 --></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td width="100" align="center" bgcolor="F2F2F2"><font color="<?=$Fontcolort?>"  style="font-family: '굴림', '돋움','Arial';font-size: 12px; line-height:140%">옵션</font></td>
        <td colspan="3"> 텍스트 타입 :
          <input type="radio" name="TxtType" value="0" <? if(!$list["TxtType"]) ECHO "CHECKED";?>>
          Text
          <input type="radio" name="TxtType" value="1" <? if(!strcmp($list["TxtType"],"1")) ECHO "CHECKED";?>>
          Html |
          <input name="Secret" type="checkbox" value="1" <? if(!strcmp($list["Secret"],"1")) ECHO "CHECKED";?>>
          비밀글 </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td width="100" align="center" bgcolor="F2F2F2"><font color="<?=$Fontcolort?>"  style="font-family: '굴림', '돋움','Arial';font-size: 12px; line-height:140%">내 용</font></td>
        <td colspan="3"><textarea name="CONTENTS" rows="15" style="width:100%;"><?=$list[CONTENTS];?>
</textarea>
        </td>
      </tr>
      <?if(!strcmp($ATTACH1, "checked")):?>
      <tr bgcolor="#FFFFFF">
        <td width="100" align="center" bgcolor="F2F2F2"><font color="<?=$Fontcolort?>"  style="font-family: '굴림', '돋움','Arial';font-size: 12px; line-height:140%">첨부화일</font></td>
        <td colspan="3"><input type="file" name="file[0]">
          <? if($mode == "modify") echo "<input name='file_del[0]' type='checkbox' value='1'>파일삭제"; ?>
        </td>
      </tr>
      <? endif;?>
    </table>
    <div id="iconbox"><? echo $board->showBoardIcon('save');?> <? echo $board->showBoardIcon('cancel');?></div>
  </form>
</div>
