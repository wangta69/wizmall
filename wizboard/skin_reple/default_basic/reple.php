<?
/* 
제작자 : 폰돌
스킨 : wizboard list skin 
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
?>
<script>
function DELETE_REPLE(UID,cp,BID,GID,BUID,adminmode){
	window.open("<?=$folder_reple?>/delete.php?UID="+UID+"&cp="+cp+"&BID="+BID+"&GID="+GID+"&BUID="+BUID+"&adminmode="+adminmode,"","scrollbars=no, toolbar=no, width=320, height=220, top=220, left=350")
}

function showrepleList(flag){
	repleList1.style.display = "none";
	repleList2.style.display = "none";
	switch(flag){
		case 1:repleList1.style.display = "block";break;
		case 2:repleList2.style.display = "block";break;
		break;
	}
}
//-->
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="25"><table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td style="cursor:pointer" onclick="showrepleList(1)">[댓글보기]</td>
          <td>&nbsp;</td>
          <td style="cursor:pointer" onclick="showrepleList(2)">[엮인글보기]</td>
        </tr>
      </table></td>
  </tr>  
  <tr> 
    <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="3" class="board1" style="display:block" id="repleList1">
        <?      
$sqlstr = "SELECT * FROM wizTable_${GID}_${BID}_reply WHERE MID='$UID' and FLAG = 1 ORDER BY UID asc";
$dbcon->_query($sqlstr);
while($RepleList = $dbcon->_fetch_array()):
	$RepleList["W_DATE"]= ereg_replace("\-",".",$RepleList["W_DATE"]);
	$RepleList["CONTENTS"] = stripslashes($RepleList["CONTENTS"]);
	$RepleList["CONTENTS"] = str_replace(" ", "&nbsp;", $RepleList["CONTENTS"]);
	$RepleList["CONTENTS"] = str_replace("	", "&nbsp;&nbsp;&nbsp;&nbsp;", $RepleList["CONTENTS"]);
	$RepleList["CONTENTS"] = nl2br($RepleList["CONTENTS"]);
?>
        <tr> 
          <td width="91" valign="top"> <div align="center" style="word-break:break-all;"> 
              <?=$RepleList["NAME"]?>
            </div></td>
            <td width="1" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td bgcolor="#F5F5F5" width="10" height="15"></td>
              </tr>
            </table></td>
          <td valign="top" style="word-break:break-all;"> 
            <?=$RepleList["CONTENTS"]?>          </td>
          <td width="10">&nbsp;</td>
          <td width="114"> <div align="center"> 
              <?=date("Y.m.d",$RepleList[W_DATE])?>
              <img src="<?=$folder_reple?>/images/delete_btn.gif" onClick="javascript:DELETE_REPLE('<?=$RepleList["UID"]?>','<?=$cp;?>','<?=$BID;?>','<?=$GID;?>','<?=$UID?>','<?=$adminmode?>');" style="cursor:pointer";> 
            </div></td>
        </tr>
        <tr>
          <td colspan="5" height="1" bgcolor="#F5F5F5"></td>
        </tr>
        <? endwhile;?>
    </table><table width="100%" border="0" cellspacing="0" cellpadding="3" class="board1" style="display:none" id="repleList2">
        <tr> 
          <td height="30" valign="top">
<? $tb_url = $cfg["admin"]["MART_BASEDIR"]."/wizboard/tb/tb.php/".$GID."/".$BID."/".$UID; ?>
          <a href="javascript:urlCopy('<?=$tb_url?>')">트랙백주소 : <?=$tb_url?></a></td>
        </tr>    
<?      
$sqlstr = "SELECT * FROM wizTable_${GID}_${BID}_reply WHERE MID='$UID' and FLAG = 2 ORDER BY UID asc";
$dbcon->_query($sqlstr);
while($RepleList = $dbcon->_fetch_array()):
	$RepleList["W_DATE"]= ereg_replace("\-",".",$RepleList["W_DATE"]);
	$RepleList["CONTENTS"] = stripslashes($RepleList["CONTENTS"]);
	$RepleList["CONTENTS"] = eregi_replace(" ", "&nbsp;", $RepleList["CONTENTS"]);
	$RepleList["CONTENTS"] = eregi_replace("	", "&nbsp;&nbsp;&nbsp;&nbsp;", $RepleList["CONTENTS"]);
	$RepleList["CONTENTS"] = nl2br($RepleList["CONTENTS"]);
?>
        <tr> 
          <td valign="top"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="30"><b><a href="<?=$RepleList["URL"]?>" target="_blank"><?=$RepleList["SUBJECT"]?></a></b></td>
                </tr>
                <tr>
                  <td height="30"><a href="<?=$RepleList["URL"]?>" target="_blank"><font color="#339999"><?=$RepleList[NAME]?></font></a>
                    <?=date("Y.m.d",$RepleList[W_DATE])?>
              <img src="./wizboard/skin_reple/<?=$cfg["wizboard"]["REPLE_SKIN_TYPE"];?>/images/delete_btn.gif" onClick="javascript:DELETE_REPLE('<?=$RepleList[UID]?>','<?=$cp;?>','<?=$BID;?>','<?=$GID;?>','<?=$UID?>','<?=$adminmode?>');" style="cursor:pointer";> <!-- <? if($board->is_admin() || $RepleList[ID] == $cfg["member"]["mid"]){ ?> <a href="javascript:repleMod(<?=$RepleList["UID"]?>)">[수정]</a> <a href="javascript:DELETE_REPLE('<?=$RepleList[UID]?>','<?=$cp;?>','<?=$BID;?>','<?=$GID;?>','<?=$board->uid?>','<?=$adminmode?>');">[삭제]</a><? } ?>--> </td>
                </tr>
                <tr>
                  <td height="30"><?=$RepleList["CONTENTS"]?> </td>
                </tr>
              </table></td>
        </tr>
        <tr>
          <td height="1" bgcolor="#F5F5F5"></td>
        </tr>
        <? endwhile;?>
    </table></td>
  </tr>
  <tr> 
    <td height="7"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#CCCCCC"></td>
  </tr>
  <tr> 
    <td height="7"></td>
  </tr>
  <tr> 
    <td>        <form name="COMMENT" method="POST" action="<?=$PHP_SELF?>" onsubmit="return comment_write_fnc(this)">
          <input type="hidden" name="REPLE_MODE" value="WRITE">
		  <input type="hidden" name="UID" value="<?=$UID?>">
          <input type="hidden" name="BID" value="<?=$BID?>">
          <input type="hidden" name="GID" value="<?=$GID?>">
          <input type="hidden" name="mode" value="<?=$mode?>">
		  <input type="hidden" name="adminmode" value="<?=$adminmode?>">
          <input type="hidden" name="cp" value="<?=$cp?>">
          <input type="hidden" name="BOARD_NO" value="<?=$BOARD_NO?>">
          <input type="hidden" name="ID" value="<?=$cfg["member"]["mid"]?>">
		  <input type="hidden" name="RUID" value=""> 
		  <input type="hidden" name="ismember" value="false"><!-- 자바스크립트 제어를 위해 회원전용:true, 일반 : false 로서 플래그 값변경-->
          <input type="hidden" name="spamfree" value=""> 
          <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr> 
            <td width="9"> <font color="#000000">&nbsp; </font></td>
            <td width="81"> <font color="#000000">글쓴이 성함</font> <input type="text" name="NAME" size="5" class="textnew" value="<?=$cfg["member"]["mname"]?>" checkenable msg="이름을 입력하세요"> 
            </td>
            <td width="6"></td>
            <td> <textarea name="CONTENTS" cols="50" wrap="VIRTUAL" rows="3" style="width:98%" checkenable msg="내용을 입력하세요" editable=0 ></textarea> 
            </td>
            <td width="105"> <div align="right"><font color="#000000">비밀번호</font> 
                <input type="password" name="PASSWD" size="5" class="textnew" value="" checkenable msg="비밀번호를 입력하세요">
                <br />
                <input type="image" src="<?=$folder_reple?>//images/write_btn.gif" /></div></td>
            <td width="9"></td>
          </tr>
       
      </table> </FORM></td>
  </tr>
  <tr> 
    <td height="7"></td>
  </tr>
  <tr> 
    <td></td>
  </tr>
</table>