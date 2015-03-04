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
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr  height="2" >
                <td height="2" colspan="3" bgcolor="#999999"></td>
              </tr>
              <tr>
                <td width="99" height="30" align="center" bgcolor="f0f0f0">제목</td>
                <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/dotline.gif" width="1" height="25"></td>
                <td bgcolor="f0f0f0">&nbsp;&nbsp;
                  <?=$boardview["SUBJECT"];?></td>
              </tr>
            </table></td>
        </tr>
        <?
if ($cfg["wizboard"]["AdminOnly"] != "yes") :
?>
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr  height="1">
                <td height="1" align="center" bgcolor="#CCCCCC" colspan="7"></td>
              </tr>
              <tr>
                <td width="99" height="30" align="center" bgcolor="f0f0f0">글쓴이</td>
                <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/dotline.gif" width="1" height="25"></td>
                <td bgcolor="f0f0f0">&nbsp;&nbsp;
                  <?=$boardview[NAME];?></td>
                <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/dotline.gif" width="1" height="25"></td>
                <td width="99" align="center" bgcolor="f0f0f0">이메일</td>
                <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/dotline.gif" width="1" height="25"></td>
                <td bgcolor="f0f0f0">&nbsp;&nbsp;
                  <?=$boardview[EMAIL];?></td>
              </tr>
            </table></td>
        </tr>
        <?
endif;
?>
        <tr>
          <td height="1" align="center" bgcolor="#CCCCCC"></td>
        </tr>
        <tr>
          <td height="30"><?
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
<?
$attached = $boardview["filename"];
for($i=0; $i<count($attached); $i++){
if(trim($attached[$i])):
	$filepath = "./config/wizboard/table/$GID/$BID/updir/".$attached[$i];
	$fileextention = $common->getextention($attached[$i]);
?>
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td height="1" colspan="3" align="center" bgcolor="#CCCCCC"></td>
              </tr>
              <tr>
                <td width="99" height="30" align="center" bgcolor="f0f0f0">첨부화일</td>
                <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/dotline.gif" width="1" height="25"></td>
                <td bgcolor="f0f0f0">&nbsp;&nbsp; <a href="javascript:down('<?=$UPDIR1[$i]?>','<?=$boardview[UID]?>')">
      <?=$common->getImgName($UPDIR1[0])?>
      </a> <? echo "[".$common->my_filesize($filepath)."]";?></td>
              </tr>
            </table></td>
        </tr>
<?
endif;		
}
?>
        <tr>
          <td height="1" align="center" bgcolor="#CCCCCC"></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="right"><table width="215" height="30" border="0" cellpadding="0" cellspacing="0">
        <tr>

          <td align="right">
		  <? echo $board->showBoardIcon('reply');?> 
		  <? echo $board->showBoardIcon('modify');?> 
          <? echo $board->showBoardIcon('delete');?>
          <? echo $board->showBoardIcon('list');?></td>
        </tr>
      </table></td>
  </tr>
</table>
