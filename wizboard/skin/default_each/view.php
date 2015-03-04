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
<table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr  height="2" >
          <td height="1" colspan="7" bgcolor="#cccccc"></td>
        </tr>
        <tr>
          <td width="99" height="30" align="center" bgcolor="#f7f7f8">제목</td>
          <td width="1" align="center" valign="middle" bgcolor="#f7f7f8"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/dotline.gif" width="1" height="25"></td>
          <td colspan="5" bgcolor="#f7f7f8">&nbsp;&nbsp;
            <?=$boardview["SUBJECT"];?></td>
        </tr>
        <tr  height="1">
          <td height="1" colspan="7" align="center" bgcolor="#EBEBEB"></td>
        </tr>
        <tr>
          <td width="99" height="30" align="center">글쓴이</td>
          <td width="1" align="center" valign="middle"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/dotline.gif" width="1" height="25"></td>
          <td width="199">&nbsp;&nbsp;
            <?=$boardview[NAME];?></td>
          <td width="1" align="center" valign="middle"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/dotline.gif" width="1" height="25"></td>
          <td width="99" align="center">이메일</td>
          <td width="1" align="center" valign="middle"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/dotline.gif" width="1" height="25"></td>
          <td width="200">&nbsp;&nbsp;
            <?=$boardview[EMAIL];?></td>
        </tr>
        <tr  height="1">
          <td height="1" colspan="7" align="center" bgcolor="#EBEBEB"></td>
        </tr>
        <tr>
          <td height="30" colspan="7"><?
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
        <tr  height="1">
          <td height="1" colspan="7" align="center" bgcolor="#e1e1e1"></td>
        </tr>
   
<?
$attached = $boardview["filename"];
for($i=0; $i<count($attached); $i++){
if(trim($attached[$i])):
	$filepath = "./config/wizboard/table/$GID/$BID/updir/".$attached[$i];
	$fileextention = $common->getextention($attached[$i]);
?>
        <tr>
          <td width="99" height="30" align="center" bgcolor="f0f0f0">첨부화일</td>
          <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/dotline.gif" width="1" height="25"></td>
          <td colspan="5" bgcolor="f0f0f0">&nbsp;&nbsp; <a href="javascript:down('<?=$attached[$i]?>','<?=$boardview["UID"]?>')">
      <?=$common->getImgName($attached[$i])?>
      </a> <? echo "[".$common->my_filesize($filepath)."]";?></td>
        </tr>
        <tr  height="1">
          <td height="1" colspan="7" align="center" bgcolor="#e1e1e1"></td>
        </tr>
<?
endif;		
}
?> 
         <?if(!strcmp($cfg["wizboard"]["CommentEnable"],"yes")):?>
        <tr>
          <td height="30" colspan="7"><? include "./wizboard/skin_reple/".$cfg["wizboard"]["REPLE_SKIN_TYPE"]."/reple.php"; ?></td>
        </tr>
        <tr  height="1">
          <td height="1" colspan="7" align="center" bgcolor="#e1e1e1"></td>
        </tr>
        <? endif;?>        
        <tr>
          <td colspan="7" align="center">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right"><table width="215" height="30" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <?if(!strcmp($cfg["wizboard"]["ReplyBtn"],"yes")):?>
          <td width="50"><? echo $board->showBoardIcon('reply');?> </td>
          <? endif;?>
          <?
if ($board->is_admin() || $cfg["wizboard"]["AdminOnly"] != "yes") :
?>
          <td width="50"><? echo $board->showBoardIcon('modify');?></td>
          <? endif; ?>
          <?
if ($board->is_admin() || $cfg["wizboard"]["AdminOnly"] != "yes") :
?>
          <td width="50"><? echo $board->showBoardIcon('delete');?></td>
          <? endif; ?>
          <td width="80"> <? echo $board->showBoardIcon('list');?></td>
        </tr>
      </table></td>
  </tr>
</table>
