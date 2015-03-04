<style>
	#customWidget{display:inline-block; position:relative;}
	#colorSelector {
		position: relative;top: 4px;left: 4px;width: 28px;height: 28px;background: url(./js/jquery.plugins/colorpicker/images/select2.png) center; background-color:#000000;
	}
	#colorpickerHolder {
		top:32px; left:4px; width: 356px;height: 0;overflow: hidden;position: absolute; background-color:red;
	}
</style>
<script type="text/javascript">        
  $(document).ready(
    function()
    {
		var defaultColor = '<?=$list["txtcolor"]?>';
		var setColor = defaultColor ? defaultColor:'000000';

		$("#colorSelector").css("backgroundColor", '#' + defaultColor);
		$('#colorpickerHolder').ColorPicker({
			flat: true,
			color: '#'+setColor,
			onChange: function (hsb, hex, rgb) { $("#txtcolor").val(hex); $('#colorSelector').css('backgroundColor', '#' + hex);},
			onSubmit: function(hsb, hex, rgb) {
				$('#colorSelector div').css('backgroundColor', '#' + hex);
			}
		}).bind('click', function(){
});

	var widt = false;
	$('#colorSelector').bind('click', function() {
		$('#colorpickerHolder').stop().animate({height: widt ? 0 : 173}, 500);
		widt = !widt;
	});

});
</script>



<div id="WRITE_FORM_TRANSFER_DIV" style="display:none">
작성글을 저장중입니다.
<p>&nbsp;</p>
잠시만 기다려 주시기 바랍니다.
</div>
<div id="WRITE_FORM_DIV" style="display:block">
  <form name="BOARD_WRITE_FORM" action="<?=$PHP_SELF?>" method="post" enctype="multipart/form-data" onsubmit="return board_write_fnc(this);">
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
    <input type="hidden" name="c_category" value="<?=$category?>">
<? if(!$cfg["wizboard"]["CategoryEnable"]) echo "<input type=\"hidden\" name=\"CATEGORY\" value=\"".$list["CATEGORY"]."\">"; ?>
    <input type="hidden" name="ID" value="<?=$cfg["member"]["mid"];?>">
    <input type="hidden" name="spamfree" value="">
    <table class="boardTbl_write">
				<col width="120" />
			<col width="*" />
			<col width="120" />
			<col width="*" />		
      <tr>
        <th>이  름</th>
        <td class="agn_l"><input type="text" name="NAME" size="15" value="<? if($list[NAME]) echo "$list[NAME]"; else echo $cfg["member"]["mname"];?>" checkenable msg="이름을 입력하세요" autocomplete="off" />
        </td>
        <th>비밀번호</th>
        <td  class="agn_l"><input type="password" name="PASSWD" size="15" value="<? echo $list["PASSWD"]; ?>" checkenable msg="비밀번호를 입력하세요" autocomplete="off" />
        </td>
      </tr>
      <tr>
        <th>전자메일</th>
        <td class="agn_l" colspan="3"><input type="text" name="EMAIL" size="40" value="<? if($list[EMAIL]) echo "$list[EMAIL]"; else echo $cfg["member"]["mmail"];?>" autocomplete="off" />
        </td>
      </tr>
      <? 
if($cfg["wizboard"]["CategoryEnable"]):
?>
      <tr>
        <th>종류</th>
        <td colspan="3" class="agn_l"><? 
$selcat = $list["CATEGORY"] != "" ? $list["CATEGORY"] :$category;
echo $board->getselectcategory($selcat)
?> 
        </td>
      </tr>
      <? endif; ?>
      <tr>
        <th>제  목</th>
        <td  class="agn_l" colspan="3"><input type="text" name="SUBJECT" size="40" value="<?=$list[SUBJECT];?>" checkenable msg="제목을 입력하세요" autocomplete="off" />
		
		<input type="checkbox" value="1" name="txtbold"<? if($list["txtbold"]) echo " checked";?>> BOLD<!-- 텍스트 굵기 옵션 -->
		<input type="hidden" id="txtcolor" name="txtcolor" value="<?=$list["txtcolor"]?>"></input><!-- color picker 옵션 -->
		<div id="customWidget">
			<div id="colorSelector"></div>
			<div id="colorpickerHolder"></div>
		</div>

          <input type="checkbox" value="1" name="Secret"<? if($list["Secret"]) echo " checked";?>>
          비밀 게시물
          <?  
if ($board->is_admin()) :
?>
          <input type="checkbox" value="1" name="MainDisplay"<? if($list["MainDisplay"]) echo " checked";?>>
          공지글
          <?
endif;
?>
          <input name="tb_url_enable" type="checkbox" id="tb_url_enable" value="1" onclick="tb_box(this)">
          엮인글(트랙백)</td>
      </tr>
      <tr id="tb_url_box" style="display:none">
        <th>엮인글URL</th>
        <td colspan="3" class="agn_l"><input type="text" name="tb_url" size="40"></td>
      </tr>
<?     
if($cfg["wizboard"]["editorenable"] == "1"){   
echo "<input type='hidden' name='TxtType' value='1'>";
}else{
?>    
      <tr>
        <th>텍스트타입</th>
        <td colspan="3" class="agn_l">
<?
if($cfg["wizboard"]["editorenable"] == "1"){
?>
<input type=hidden name="TxtType" value="1" /> 
<?
}else{
?>
                <input type="radio" name="TxtType" value="0" <? if(!$list["TxtType"]) ECHO "CHECKED";?>> Text 
				<input type="radio" name="TxtType" value="1" <? if(!strcmp($list["TxtType"],"1")) ECHO "CHECKED";?>> Html 
				
<?
}
?>				
				</td>
      </tr>
<?
}
?>      
      <tr>
        <th>내  용</th>
        <td colspan="3" class="agn_l">
<textarea name="CONTENTS" rows="15" style="width:100%;" id="CONTENTS" checkenable msg="내용을 입력하세요"><?=$list[CONTENTS];?></textarea>

        </td>
      </tr>
<?
if($cfg["wizboard"]["editorenable"] == "1"){
?>
<script>
var oEditors = [];
nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "CONTENTS",
	sSkinURI: "./js/Smart/SmartEditor2Skin.html",
	fCreator: "createSEditor2"
});
</script>
<?
}//if($cfg["wizboard"]["editorenable"] == "1"){
		for($i=0; $i<$cfg["wizboard"]["ATTACHEDCOUNT"]; $i++){
		?>
      <tr>
        <th>첨부화일</th>
        <td colspan="3" class="agn_l"><input type="file" name="file[<?=$i;?>]">
          <? if($mode == "modify" && $list["filename"][$i]) echo $common->getImgName($list["filename"][$i])." <input name='file_del[$i]' type='checkbox' value='1'>파일삭제"; ?>
        </td>
      </tr>
      <tr  height="1">
        <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
      </tr>      
      <?
	   }
	  ?>
    </table>
    <div id="btn_box"><? echo $board->showBoardIcon('save');?> <? echo $board->showBoardIcon('cancel');?> </div>
  </form>
</div>
