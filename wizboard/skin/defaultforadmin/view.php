<?
/* 
제작자 : 폰돌
스킨 : wizboard list skin 
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/

/* VIEW 내용을 DB에서 가져온다 */
//스킨별 추가 프로그램이 필요하면 이곳에서 처리
?>
<SCRIPT>
<!--
document.title = '<?=addslashes($boardview["SUBJECT"]);?>';
//-->
</SCRIPT>
  
<div id="imgLayer" style="display:none;position:absolute;z-index:1000";>
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="right"><a href="javascript:closeImgLayer()">닫기[x]</a></td>
    </tr>
    <tr>
      <td><img src="" id="popLayerImg"></td>
    </tr>
  </table>
</div>
<table cellspacing=1 bordercolordark=white width="100%" bgcolor=#c0c0c0 bordercolorlight=#dddddd border=0 class="s1">
  <tr bgcolor="<?=$Bgcolort?>">
    <td width="100%" height="27" bgcolor="#FFFFFF"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bullets3.gif" width="7" height="7" hspace="3"> <font color="<?=$Fontcolort?>" style="word-break:break-all;">
      <?=$LIST[SUBJECT];?>
      </font> </td>
  </tr>
  <tr bgcolor="<?=$Bgcolorl?>">
    <td width="100%" align="right" bgcolor="#FFFFFF"><font color="<?=$Fontcolors?>">

      <b>첨부화일</b> :
<?
$attached = $boardview["filename"];
for($i=0; $i<count($attached); $i++){
if(trim($attached[$i])):
	$filepath = "./config/wizboard/table/$GID/$BID/updir/".$attached[$i];
	$fileextention = $common->getextention($attached[$i]);
?>      
       <a href="javascript:down('<?=$attached[$i]?>','<?=$boardview["UID"]?>')">
      <?=$common->getImgName($attached[$i])?>
      </a> <? echo "[".$common->my_filesize($filepath)."]";?>
<?
endif;		
}
?>
      <b>작성자</b> :
      <?=$LIST[NAME];?>
      &nbsp;&nbsp; <b>작성일</b> :
      <?=date("Y.m.d", $LIST[W_DATE])?>
      <b>&nbsp;&nbsp;
      <?if($LIST[EMAIL]):?>
      e-mail</b> : <a href="javascript:sendmail('<?=$BID?>','<?=$LIST[UID]?>')">
      <?=$boardview[EMAIL];?>
      </a>
      <?endif;?>
      </font> </td>
  </tr>
  <tr bgcolor="<?=$Bgcolorl?>">
    <td width="100%" height="250" valign="top" bgcolor="#FFFFFF"><?
for($i=0; $i < count($boardview["viewAttachedImg"]); $i++){
?>
      <table width="100%" border="0" cellspacing="5">
        <tr>
          <td><?=$boardview["viewAttachedImg"][$i]?>
          </td>
        </tr>
      </table>
      <?
}
?>
      <font class="boardviewcontents">
      <?=$boardview["CONTENTS"];?>
      </font> </td>
  </tr>
  <tr align="right" bgcolor="<?=$Bgcolors?>">
    <td width="100%" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="right"><!-- <img alt="추천" src="./wizboard/icon/<?=$ICON_SKIN_TYPE;?>/recomm_btn.gif" hspace="4" onClick="javascript:location.replace('<?=$PHP_SELF;?>?BID=<?=$boardview[BID];?>&UID=<?=$UID;?>&mode=view&cp=<?=$cp;?>&RECOMMAND=OK');" style="cursor:pointer";> 
            <img alt="프린트" src="./wizboard/icon/<?=$ICON_SKIN_TYPE;?>/print_btn.gif" hspace="4" onClick="javascript:printThis();" style="cursor:pointer";> -->
            <!-- <img alt="이전" src="./wizboard/icon/<?=$ICON_SKIN_TYPE;?>/prev_btn.gif" hspace="4" onClick="javascript:location.replace('<?=$PHP_SELF;?>?BID=<?=$BID;?>&category=<?=$category?>&mode=view&UID=<?=$PRE_BOARD[0];?>&cp=<?=$cp;?>');" style="cursor:pointer";> 
            <img alt="다음" src="./wizboard/icon/<?=$ICON_SKIN_TYPE;?>/next_btn.gif" hspace="4" onClick="javascript:location.replace('<?=$PHP_SELF;?>?BID=<?=$BID;?>&category=<?=$category?>&mode=view&UID=<?=$NEXT_BOARD[0];?>&cp=<?=$cp;?>');" style="cursor:pointer";> -->
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><script>nhnButton('답변','black9','javascript:location.replace("<?=$PHP_SELF?>?BID=<?=$BID?>&GID=<?=$GID?>&category=<?=$category?>&mode=reply&UID=<?=$UID;?>&cp=<?=$cp;?>");',4,0,'#565656','#FFFFFF','#C4C4C4','#ffffff','#ffffff','#ffffff')</script></td>
                <td>&nbsp;</td>
                <td><script>nhnButton('수정','black9','javascript:location.replace("<?=$PHP_SELF?>?BID=<?=$BID?>&GID=<?=$GID?>&category=<?=$category?>&mode=modify&UID=<?=$UID;?>&cp=<?=$cp;?>");',4,0,'#565656','#FFFFFF','#C4C4C4','#ffffff','#ffffff','#ffffff')</script></td>
                <td>&nbsp;</td>
                <td><script>nhnButton('삭제','black9','javascript:DELETE_THIS("<?=$UID;?>","<?=$cp;?>","<?=$BID;?>","<?=$GID;?>");',4,0,'#565656','#FFFFFF','#C4C4C4','#ffffff','#ffffff','#ffffff')</script></td>
                <td>&nbsp;</td>
                <td><script>nhnButton('쓰기','black9','javascript:location.replace("<?=$PHP_SELF;?>?BID=<?=$BID;?>&GID=<?=$GID?>&mode=write&category=<?=$category?>");',4,0,'#565656','#FFFFFF','#C4C4C4','#ffffff','#ffffff','#ffffff')</script></td>
                <td>&nbsp;</td>
                <td><script>nhnButton('목록','black9','javascript:location.replace("<?=$PHP_SELF?>?BID=<?=$BID?>&GID=<?=$GID?>&category=<?=$category?>&cp=<?=$cp;?>&SEARCHTITLE=<?=$SEARCHTITLE?>&searchkeyword=<?=$searchkeyword?>");',4,0,'#565656','#FFFFFF','#C4C4C4','#ffffff','#ffffff','#ffffff')</script></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
