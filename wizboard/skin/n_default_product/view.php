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
//$attached = $boardview["filename"];
//for($i=0; $i<count($attached); $i++){
//	if(trim($attached[$i])):
//		$filepath[$i] = "config/wizboard/table/$GID/$BID/updir/".$boardview["UID"]."/".$attached[$i];
//	endif;		
//}

//print_r($boardview);
//print_r($boardview["viewAttachedfilepath"]);
?>
<script type="text/javascript" src="./js/jquery.plugins/jquery.wizimageoverlap-1.0.1.js"></script>
<script> 
$(function(){
	$(".thumimg").mouseover(function(){
		$(this).wizimagech();
	});
});


	
	document.title = '<?=addslashes($boardview["SUBJECT"]);?>';
	$(document).ready(function(){
		$(".single").colorbox({photo:true, maxWidth:"700px", maxHeight:"700px"});
	});


</script> 
<style type="text/css">
#boardContents img {
  max-width: 720px;
}

.prd_spec_tbl {
	border-collapse:collapse;
	width:100%;
}
.prd_spec_tbl tr {
	border-bottom: 1px solid #E6E6E6;
}

.prd_thumb_tbl{
	border:0px;
}

.prd_thumb_tbl tr {
	border:0px;
}

.prd_thumb_tbl img{
	margin:10px;
}
/*
.prd_spec_tbl th {

}
.prd_spec_tbl tr {
	border-bottom: 1px;
	padding: 0px;
	border-style: solid;
	border-color: gray;
	-moz-border-radius: ;
}
*/


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
	<col width="250"/>
	<col width="*"/>
	<tr>
		<td align="center">
		제품명 : <?=$boardview["SUBJECT"]?>

		<br />
		<br />
			<div style="width:200px;height:250px;">
				<div id="bigImg" style="position:relative;"><img src="<?=$boardview["viewAttachedfilepath"][0]?>" width="200" height="200" class='curImage'></div>
			</div>
		</td>
		<td valign="top">
		
			<table class="prd_spec_tbl">
				<col width="80"/>
				<col width="*"/>
				<tr>
					<th>품목</th>
					<td>: <?=$boardview["SUBJECT"]?></td>
				</tr>

				<tr>
					<th>규격</th>
					<td>: <?=$boardview["EMAIL"]?></td>
				</tr>
				<tr>
					<th>옵션</th>
					<td>: <?=$boardview["URL"]?></td>
				</tr>
				<tr>
					<th>연식</th>
					<td>: <?=$boardview["SUB_TITLE1"]?></td>
				</tr>
				<tr>
					<th>제작사</th>
					<td>: <?=$boardview["NAME"]?></td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<table class="prd_thumb_tbl">
							<tr>
								<td><a class='single' href="<?=$boardview["viewAttachedfilepath"][0]?>" title=""><img src="<?=$boardview["viewAttachedfilepath"][0]?>" width="60" height="60" class="thumimg"><a></td>
								<td><a class='single' href="<?=$boardview["viewAttachedfilepath"][1]?>" title=""><img src="<?=$boardview["viewAttachedfilepath"][1]?>" width="60" height="60" class="thumimg"></a></td>
								<td><a class='single' href="<?=$boardview["viewAttachedfilepath"][2]?>" title=""><img src="<?=$boardview["viewAttachedfilepath"][2]?>" width="60" height="60" class="thumimg"></a></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		
		
		
		</td>
	</tr>
	<tr>
		<td colspan="2">상세정보</td>
	</tr>
	<tr>
		<td colspan="2" align="left" class="boardviewcontents"><?=$boardview["CONTENTS"];?></td>
	</tr>
</table>
<!--

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
      <table width="100%" height="90" border="0" cellpadding="0" cellspacing="1" bgcolor="D7D7D7">
        <tr>
          <td bgcolor="#F3F3F3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr valign="bottom">
                <td width="76" align="center" class="font1">이름</td>
                <td width="20" align="left"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="2" height="15"></td>
                <td align="left"><?=$boardview["NAME"];?></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td bgcolor="#F3F3F3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr valign="bottom">
                <td width="76" align="center" class="font1">상세</td>
                <td width="20" align="left"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="2" height="15"></td>
                <td align="left">date :
                  <?=date("Y.m.d", $boardview[W_DATE])?>
                  , hit 
                  :
                  <?=number_format($boardview[COUNT])?>
				  <? if($boardview["EMAIL"]){ ?> , email : <? echo $boardview["EMAIL"]; }?></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td bgcolor="#F3F3F3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr valign="bottom">
                <td width="75" align="center" class="font1">제목</td>
                <td width="19" align="left"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="2" height="15"></td>
                <td align="left"><?=$boardview["SUBJECT"];?></td>
                <td width="76" align="center"><span class="font1">첨부화일</span></td>
                <td width="9" align="left"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="2" height="15"></td>
                <td width="150" align="left"><?

for($i=0; $i<count($attached); $i++){
if(trim($attached[$i])):
	$filepath = "config/wizboard/table/$GID/$BID/updir/".$boardview["UID"]."/".$attached[$i];
?>
                  <a href="javascript:down('<?=$attached[$i]?>','<?=$boardview["UID"]?>')"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/icon_data.gif" width="13" height="13" border="0" align="absmiddle"></a>
                  <?
endif;		
}
?>
                </td>
              </tr>
            </table></td>
        </tr>
      </table>
      <?
for($i=0; $i < count($boardview["viewAttachedImg"]); $i++){
?>
      <table width="100%" border="0" cellpadding="0" cellspacing="10">
        <tr>
          <td align="center" class="text"><a class='single' href="<?=$boardview["viewAttachedfilepath"][$i]?>" title=""><?=$boardview["viewAttachedImg"][$i]?></a></td>
        </tr>
      </table>
      <?
}
?>
      <table width="100%" border="0" cellpadding="0" cellspacing="10">
        <tr>
          <td align="left" class="txt1" style="word-break:break-all;" id="boardContents"><?=$boardview["CONTENTS"];?></td>
        </tr>
      </table>

	  -->
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="1" bgcolor="D7D7D7"></td>
        </tr>
        <tr>
          <td height="40" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="70" height="25" align="right">이전제품 : &nbsp;</td>
                <td align="left"><? if($board->listpre["UID"]){?>
                  <a href="<?=$board->listpre["URL"]?>" style="TEXT-DECORATION: none; COLOR: #777777;">
                  <?=$board->listpre["SUBJECT"]?>
                  </a>
                  <? }else echo "이전제품이 없습니다.";?></td>
              </tr>
              <tr>
                <td height="1" colspan="2" align="right" bgcolor="#E6E6E6"></td>
              </tr>
              <tr>
                <td width="70" height="25" align="right">다음제품 : &nbsp;</td>
                <td align="left"><? if($board->listnext["UID"]){?>
                  <a href="<?=$board->listnext["URL"]?>" style="TEXT-DECORATION: none; COLOR: #777777;">
                  <?=$board->listnext["SUBJECT"]?>
                  </a>
                  <? }else echo "다음제품이 없습니다.";?></td>
              </tr>
            </table></td>
        </tr>
     <?if(!strcmp($cfg["wizboard"]["CommentEnable"],"yes")):?>
  <tr>
    <td>
      <!-- reply start -->
     <? include "./wizboard/skin_reple/".$cfg["wizboard"]["REPLE_SKIN_TYPE"]."/reple.php"; ?>
    </td>
  </tr>
  <?endif;?>
      </table>
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
