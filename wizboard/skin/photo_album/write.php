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
    <input type="hidden" name="SUBJECT" value="이미지">
    <table width="100%" border="0" cellspacing="1" cellpadding="5">
      <tr>
        <td colspan="2" align="center" bgcolor="<?=$Bgcolort?>">이미지를 등록해 주세요</td>
      </tr>
      <? 
if($cfg["wizboard"]["CategoryEnable"]):
$fileArr = file("./config/wizboard/table/$BID/config6.php");
?>
      <? endif; ?>
      <?if(!strcmp($ATTACH1, "checked")):?>
      <tr>
        <td width="100" align="center" bgcolor="<?=$Bgcolort?>"><font color="<?=$Fontcolort?>">첨부화일</font></td>
        <td width="100" bgcolor="<?=$Bgcolorl?>"><input type="file" name="file[0]">
          <? if($mode == "modify") echo "<input name='file_del[0]' type='checkbox' value='1'>파일삭제"; ?>
        </td>
      </tr>
      <? endif;?>
    </table>
    <div id="iconbox"><? echo $board->showBoardIcon('save');?> <? echo $board->showBoardIcon('cancel');?></div>
  </form>
</div>
