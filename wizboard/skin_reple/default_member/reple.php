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
<div class="space10"></div>
<table width="98%" border="0" cellspacing="0" cellpadding="0">

  <!--<tr> 
    <td height="25"><table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td style="cursor:pointer" onclick="showrepleList(1)">[댓글보기]</td>
          <td>&nbsp;</td>
          <td style="cursor:pointer" onclick="showrepleList(2)">[엮인글보기]</td>
        </tr>
      </table></td>
  </tr>  -->
  <tr><td height="1" bgcolor="#F5F5F5"></td></tr>
  <tr><td height="3"></td></tr>
  <tr><td height="1" bgcolor="#F5F5F5"></td></tr>
  <tr><td height="25"></td></tr>
  <tr> 
    <td valign="top"> 
	
	<table width="100%" border="0" cellspacing="0" cellpadding="3" class="board1"  id="repleList1">
        <?      
$sqlstr = "SELECT * FROM wizTable_${GID}_${BID}_reply WHERE MID='$UID' and FLAG = 1 ORDER BY UID asc";
$dbcon->_query($sqlstr);
while($RepleList = $dbcon->_fetch_array()):
	$RepleList[W_DATE]= ereg_replace("\-",".",$RepleList[W_DATE]);
	$RepleList[CONTENTS] = stripslashes($RepleList[CONTENTS]);
	$RepleList[CONTENTS] = str_replace(" ", "&nbsp;", $RepleList[CONTENTS]);
	$RepleList[CONTENTS] = str_replace("	", "&nbsp;&nbsp;&nbsp;&nbsp;", $RepleList[CONTENTS]);
	$RepleList[CONTENTS] = nl2br($RepleList[CONTENTS]);
?>
        <tr> 
          <td valign="top" class="agn_l"> 


            <p  style="color:#FF6600"> <?=$RepleList[NAME]?> <? if($RepleList["URL"]) echo "[".$RepleList["URL"]."]" ?> <?=date("Y.m.d H:i",$RepleList[W_DATE])?></p>
<p><?=$RepleList[CONTENTS]?>  </p>

           </td>
          <td width="10">&nbsp;</td>
          <td width="114"> <div align="center"> 
              
              <img src="<?=$folder_reple?>/images/delete_btn.gif" onClick="javascript:DELETE_REPLE('<?=$RepleList[UID]?>','<?=$cp;?>','<?=$BID;?>','<?=$GID;?>','<?=$UID?>','<?=$adminmode?>');" style="cursor:pointer";> 
            </div></td>
        </tr>
        <tr>
          <td colspan="3" height="1"><div class="space1 b_gray"></div></td>
        </tr>
        <? endwhile;?>
    </table>
	
	
	<table width="100%" border="0" cellspacing="0" cellpadding="3" class="board1" style="display:none" id="repleList2">
        <tr> 
          <td height="30" valign="top">
<? $tb_url = $cfg["admin"]["MART_BASEDIR"]."/wizboard/tb/tb.php/".$GID."/".$BID."/".$UID; ?>
          <a href="javascript:urlCopy('<?=$tb_url?>')">트랙백주소 : <?=$tb_url?></a></td>
        </tr>    
<?      
$sqlstr = "SELECT * FROM wizTable_${GID}_${BID}_reply WHERE MID='$UID' and FLAG = 2 ORDER BY UID asc";
$dbcon->_query($sqlstr);
while($RepleList = $dbcon->_fetch_array()):
	$RepleList[W_DATE]= ereg_replace("\-",".",$RepleList[W_DATE]);
	$RepleList[CONTENTS] = stripslashes($RepleList[CONTENTS]);
	$RepleList[CONTENTS] = eregi_replace(" ", "&nbsp;", $RepleList[CONTENTS]);
	$RepleList[CONTENTS] = eregi_replace("	", "&nbsp;&nbsp;&nbsp;&nbsp;", $RepleList[CONTENTS]);
	$RepleList[CONTENTS] = nl2br($RepleList[CONTENTS]);
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



</table>
<div class="space10"></div>
<div class="space1 b_gray"></div>
<form name="COMMENT" id="userCommentFrm" method="POST" action="<?=$PHP_SELF?>">
          <input type="hidden" name="REPLE_MODE" value="WRITE">
		  <input type="hidden" name="UID" value="<?=$UID?>">
          <input type="hidden" name="BID" value="<?=$BID?>">
          <input type="hidden" name="GID" value="<?=$GID?>">
          <input type="hidden" name="mode" value="<?=$mode?>">
		  <input type="hidden" name="adminmode" value="<?=$adminmode?>">
          <input type="hidden" name="cp" value="<?=$cp?>">
          <input type="hidden" name="BOARD_NO" value="<?=$BOARD_NO?>">
          <input type="hidden" name="ID" id="commnet_user_id" value="<?=$cfg["member"]["mid"]?>">
		  <input type="hidden" name="RUID" value=""> 
		  <input type="hidden" name="ismember" value="true"><!-- 자바스크립트 제어를 위해 회원전용:true, 일반 : false 로서 플래그 값변경-->
          <input type="hidden" name="spamfree" id="comment_user_spamfree" value=""> 
          <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr> 
            <td>
				<textarea id="comment_user_contents" name="CONTENTS" wrap="VIRTUAL" rows="3" style="width:98%"></textarea> 
            </td>
            <td width="80">
				<div class="agn_r button bull"><span id="btn_comment_write"><a>코멘트</a></span></div>
			</td>
          </tr>
       
      </table> </form>
<div class="space10"></div>