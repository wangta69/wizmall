<script>
document.title = '<?=addslashes($boardview["SUBJECT"]);?>';
</script>
  
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
<table class="table">
  <tr class="success">
    <td>
      <?=$boardview["SUBJECT"];?>
     </td>
  </tr>
  <tr>
    <td class="agn_r"> <b>작성자</b> :
      <?=$boardview["NAME"];?>
      &nbsp;&nbsp; <b>작성일</b> :
      <?=date("Y.m.d", $boardview[W_DATE])?>
      <b>&nbsp;&nbsp;
      <? if($boardview["EMAIL"]):?>
      e-mail</b> : <a href="javascript:sendmail('<?=$BID?>','<?=$boardview["UID"]?>')">
      <?=$boardview["EMAIL"];?>
      </a>
      <?endif;?></td>
  </tr>
  <?
$attached = $boardview["filename"];
for($i=0; $i<count($attached); $i++){
if(trim($attached[$i])):
	$filepath = "config/wizboard/table/$GID/$BID/updir/".$boardview["UID"]."/".$attached[$i];
?>
  <tr>
    <td bgcolor="#f6f6f6" class="agn_l">&nbsp;&nbsp;<B>- Download :</B> <?=$board->getattachedIcon($attached[$i])?> <a href="javascript:down('<?=$attached[$i]?>','<?=$boardview["UID"]?>')">
      <?=$common->getImgName($attached[$i])?>
      </a>
      <? echo "[".$common->my_filesize($filepath)."]";?></td>
  </tr>
<?
endif;		
}
?>
  <tr>
    <td class="agn_l"><?
for($i=0; $i < count($boardview["viewAttachedImg"]); $i++){
?>
      <div class="contents">
      		<a class='single' href="<?=$boardview["viewAttachedfilepath"][$i]?>" title=""><?=$boardview["viewAttachedImg"][$i]?></a>
      </div>
      <?
}
?>
      <div class="boardviewcontents">
      <?=$boardview["CONTENTS"];?>
      </div> </td>
  </tr>
  <tr>
    <td>
	
	<div class="form-group">
		<label class="col-lg-2 control-label">[ 이전글 ]</label>
		<label fclass="col-lg-10 control-label"><?php if($board->listpre["UID"]){?>
            <a href="<?=$board->listpre["URL"]?>">
            <?=$board->listpre["SUBJECT"]?>
            </a>
            <? }else echo "이전글이 없습니다.";?></label>
	</div>
	<div class="form-group">
		<label class="col-lg-2 control-label">[ 다음글 ]</label>
		<label fclass="col-lg-10 control-label"><? if($board->listnext["UID"]){?>
            <a href="<?=$board->listnext["URL"]?>">
            <?=$board->listnext["SUBJECT"]?>
            </a>
            <? }else echo "다음글이 없습니다.";?></label>
	</div>
	
		
	</td>
  </tr>
  
</table>
 <?if(!strcmp($cfg["wizboard"]["CommentEnable"],"yes")):?>
 <? include "./wizboard/skin_reple/".$cfg["wizboard"]["REPLE_SKIN_TYPE"]."/reple.php"; ?>
<?endif;?>
<div class="btn_box agn_r"><?if(!strcmp($cfg["wizboard"]["ReplyBtn"],"yes")):?>
            <? echo $board->showBoardIcon('reply');?>
            <? endif;?>
<?
if ( $board->is_admin() || $cfg["wizboard"]["AdminOnly"] != "yes") :
?>
            <? echo $board->showBoardIcon('modify');?>
            <? endif; ?>
            <?
if ($board->is_admin() || $cfg["wizboard"]["AdminOnly"] != "yes") :
?>
            <? echo $board->showBoardIcon('delete');?>
            <? endif; ?>
            <? echo $board->showBoardIcon('recomm');?> <? echo $board->showBoardIcon('print');?>
            <?if($board->listpre["UID"]):?>
            <? echo $board->showBoardIcon('prev');?>
            <?endif; if($board->listnext["UID"]):?>
            <? echo $board->showBoardIcon('next');?>
            <?endif;?>
<?
if ( $board->is_admin() || $cfg["wizboard"]["AdminOnly"] != "yes") :
?>
            <? echo $board->showBoardIcon('write');?>
            <?
endif;
?>
            <? echo $board->showBoardIcon('list');?></div>