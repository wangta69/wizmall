<?
/* 
제작자 : 폰돌
스킨 : wizboard list skin 
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
?>
<script language = javascript>
<!--
function DELETE_REPLE(UID,cp,BID,GID,BUID,adminmode){
	window.open("./wizboard/skin_reple/<?=$REPLE_SKIN_TYPE;?>/delete.php?UID="+UID+"&cp="+cp+"&BID="+BID+"&GID="+GID+"&BUID="+BUID+"&adminmode="+adminmode,"","scrollbars=no, toolbar=no, width=320, height=220, top=220, left=350")
}
//-->
</script>
<table width="620" border="0" cellspacing="0" cellpadding="0">
  <tr  height="1"> 
    <td height="1" colspan="6" align="center" bgcolor="#CCCCCC"></td>
  </tr>
  <?      

$sqlstr = "SELECT * FROM wizTable_${GID}_${BID}_reply WHERE MID='$UID' ORDER BY UID asc";

$dbcon->_query($sqlstr);
while($RepleList = $dbcon->_fetch_array()):

$RepleList[W_DATE]= ereg_replace("\-",".",$RepleList[W_DATE]);

$RepleList[CONTENTS] = stripslashes($RepleList[CONTENTS]);

$RepleList[CONTENTS] = str_replace(" ", "&nbsp;", $RepleList[CONTENTS]);

$RepleList[CONTENTS] = str_replace("	", "&nbsp;&nbsp;&nbsp;&nbsp;", $RepleList[CONTENTS]);

$RepleList[CONTENTS] = nl2br($RepleList[CONTENTS]);

?>
  <tr> 
    <td width="30">&nbsp;</td>
    <td width="50">
      <?=$RepleList[NAME]?>
    </td>
    <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="<%=skin_path%>images/dotline.gif" width="1" height="25"></td>
    <td width="380" >
      <?=$RepleList[CONTENTS]?>
    </td>
    <td align="center" >
      <?=date("Y.m.d",$RepleList[W_DATE])?>
    </td>
    <td width="20" align="center"><a href="javascript:;" onClick="DELETE_REPLE('<?=$RepleList[UID]?>','<?=$cp;?>','<?=$BID;?>','<?=$GID;?>','<?=$UID?>','<?=$adminmode?>');"><img src="./wizboard/skin_reple/<?=$REPLE_SKIN_TYPE;?>/images/memo_del.gif" width="9" height="9" border="0"></a></td>
  </tr>
  <tr  height="1"> 
    <td height="1" colspan="6" align="center" bgcolor="#CCCCCC"></td>
  </tr>
  <? endwhile;?>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
</table> 
 <form name="COMMENT" method="POST" action="<?=$PHP_SELF?>" onsubmit="return comment_write_fnc(this)">
          <input type="hidden" name="REPLE_MODE" value="WRITE">
		  <input type="hidden" name="UID" value="<?=$UID?>">
          <input type="hidden" name="BID" value="<?=$BID?>">
          <input type="hidden" name="GID" value="<?=$GID?>">
          <input type="hidden" name="mode" value="<?=$mode?>">
		  <input type="hidden" name="adminmode" value="<?=$adminmode?>">
          <input type="hidden" name="cp" value="<?=$cp?>">
          <input type="hidden" name="BOARD_NO" value="<?=$BOARD_NO?>">
          <input type="hidden" name="ID" value="<?=$cfg["member"]["mid"]?>">
		  <input type="hidden" name="ismember" value="false"><!-- 자바스크립트 제어를 위해 회원전용:true, 일반 : false 로서 플래그 값변경-->
          <input type="hidden" name="spamfree" value=""> 
<table width="620"  border="0" cellspacing="0" cellpadding="0">

    <tr align="left"> 
      <td height="18" colspan="8">한즐글 쓰기</td>
    </tr>
    <tr  height="1"> 
      <td height="1" colspan="8" align="center" bgcolor="#CCCCCC"></td>
    </tr>
    <tr> 
      <td width="70" height="30">이름</td>
      <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="<%=skin_path%>images/dotline.gif" width="1" height="25"></td>
      <td align="left">&nbsp; <input name="NAME" type="text" id="NAME" value="<?=$cfg["member"]["mname"]?>" checkenable msg="이름을 입력하세요" /></td>
      <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="<%=skin_path%>images/dotline.gif" width="1" height="25"></td>
      <td width="70">비밀번호</td>
      <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="<%=skin_path%>images/dotline.gif" width="1" height="25"></td>
      <td align="left">&nbsp;
      <input name="PASSWD" type="password" id="PASSWD"  value="" checkenable msg="비밀번호를 입력하세요" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr  height="1"> 
      <td height="1" colspan="8" align="center" bgcolor="#CCCCCC"></td>
    </tr>
    <tr> 
      <td>내용</td>
      <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="<%=skin_path%>images/dotline.gif" width="1" height="25"></td>
      <td colspan="5" align="left">&nbsp; <textarea name="CONTENTS"  rows="3" id="CONTENTS" style="width:98%" checkenable msg="내용을 입력하세요" editable=0 /></textarea></td>
      <td align="center"><input type="submit" name="Submit" value="작성" style="width=60px; height=35px;"></td>
    </tr>
    <tr> 
      <td height="5"></td>
      <td colspan="8"></td>
    </tr>
    <tr  height="1"> 
      <td height="1" colspan="9" align="center" bgcolor="#CCCCCC"></td>
    </tr>
</table>  
</form>
<!-- 한줄 쓰기 끝 -->