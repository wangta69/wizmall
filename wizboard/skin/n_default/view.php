<?php
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
<script> 
document.title = '<?=addslashes($boardview["SUBJECT"]);?>';
$(document).ready(function(){
	$(".single").colorbox({photo:true, maxWidth:"700px", maxHeight:"700px"});
});
</script> 
<style type="text/css">
#boardContents img {
  max-width: 720px;
}
</style>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><!-- ##################board  view테이블시작입니다##########################-->
    	
     <table  class="boardviewinfo">
    	<col width="76px" />
    	<col width="20px" />
    	<col width="*" />
    	<col width="76px" />
    	<col width="20px" />
    	<col width="200px" />
		<tr valign="bottom" bgcolor="#F3F3F3" height="25">
			<td align="center">이름</td>
			<td><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="2" height="15"></td>
			<td colspan="4"><?=$boardview["NAME"];?></td>
		</tr>
		<tr valign="bottom" bgcolor="#F3F3F3" height="25">
            <td align="center">상세</td>
            <td><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="2" height="15"></td>
            <td colspan="4">date :
              <?=date("Y.m.d", $boardview[W_DATE])?>
              , hit 
              :
              <?=number_format($boardview[COUNT])?>
			  <? if($boardview["EMAIL"]){ ?> , email : <? echo $boardview["EMAIL"]; }?>
			 </td>
          </tr>
          <tr valign="bottom" bgcolor="#F3F3F3" height="25">
            <td align="center">제목</td>
            <td align="left"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="2" height="15"></td>
            <td align="left"><?=$boardview["SUBJECT"];?></td>
            <td align="center"><span>첨부화일</span></td>
            <td align="left"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="2" height="15"></td>
            <td align="left"><?
$attached = $boardview["filename"];
for($i=0; $i<count($attached); $i++){
if(trim($attached[$i])):
	$filepath = "config/wizboard/table/$GID/$BID/updir/".$boardview["UID"]."/".$attached[$i];
?>
              <a href="javascript:down('<?=$attached[$i]?>','<?=$boardview["UID"]?>')"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/icon_data.gif" width="13" height="13" border="0" align="absmiddle"></a>
              <?
endif;		
}
?>
            &nbsp;</td>
          </tr>
	</table>
      

      
      
      <?
for($i=0; $i < count($boardview["viewAttachedImg"]); $i++){
?>
      <p class="agn_c"><a class='single' href="<?=$boardview["viewAttachedfilepath"][$i]?>" title=""><?=$boardview["viewAttachedImg"][$i]?></a></p>
      <?
}
?>
	<p class="boardviewcontents"><?=$boardview["CONTENTS"];?></p>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
                <td height="1" colspan="2" align="right" bgcolor="#E6E6E6"></td>
              </tr>
              <tr>
                <td width="70" height="25" align="right">이전글 : &nbsp;</td>
                <td align="left"><? if($board->listpre["UID"]){?>
                  <a href="<?=$board->listpre["URL"]?>" style="TEXT-DECORATION: none; COLOR: #777777;">
                  <?=$board->listpre["SUBJECT"]?>
                  </a>
                  <? }else echo "이전글이 없습니다.";?></td>
              </tr>
              <tr>
                <td height="1" colspan="2" align="right" bgcolor="#E6E6E6"></td>
              </tr>
              <tr>
                <td width="70" height="25" align="right">다음글 : &nbsp;</td>
                <td align="left"><? if($board->listnext["UID"]){?>
                  <a href="<?=$board->listnext["URL"]?>" style="TEXT-DECORATION: none; COLOR: #777777;">
                  <?=$board->listnext["SUBJECT"]?>
                  </a>
                  <? }else echo "다음글이 없습니다.";?></td>
              </tr>
            </table>
            
            
<?if(!strcmp($cfg["wizboard"]["CommentEnable"],"yes")):?>
      <!-- reply start -->
     <? include "./wizboard/skin_reple/".$cfg["wizboard"]["REPLE_SKIN_TYPE"]."/reple.php"; ?>
  <?endif;?>
  
  
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="1" bgcolor="D7D7D7"></td>
        </tr>
        <tr>
          <td height="40" align="right"><table height="30" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <?if(!strcmp($cfg["wizboard"]["ReplyBtn"],"yes")):?>
                <td width="62"><? echo $board->showBoardIcon('reply');?> </td>
                <? endif;?>
                <?
if ($board->is_admin() || $cfg["wizboard"]["AdminOnly"] != "yes") :
?>
                <td width="62"><? echo $board->showBoardIcon('modify');?> </td>
                <? endif; ?>
                <?
if ($board->is_admin() || $cfg["wizboard"]["AdminOnly"] != "yes") :
?>
                <td width="62"><? echo $board->showBoardIcon('delete');?> </td>
                <? endif; ?>
                <td width="80"><? echo $board->showBoardIcon('list');?> </td>
              </tr>
            </table></td>
        </tr>
      </table>
      <!-- ##################board  view테이블끝입니다##########################-->
    </td>
  </tr>
</table>
<br>
<br>