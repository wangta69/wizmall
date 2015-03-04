<?
//echo session_id();
$common->mkfolder("./config/tmp_upload/".session_id()."/");
$upload_path		= "./config/tmp_upload/".session_id()."/";
?>
<script type="text/javascript" src="./js/swfobject.js"></script> 
<script type="text/javascript" src="./js/jquery.plugins/uploadify/jquery.uploadify.v2.1.4.min.js"></script> 
<link href="./js/jquery.plugins/uploadify/uploadify.css" rel="stylesheet" type="text/css" media="screen" /> 
<script type="text/javascript"> 
	$(function() {
		$('#custom_file_upload').uploadify({
			'uploader'       : './js/jquery.plugins/uploadify/uploadify.swf',
			'script'         : './js/jquery.plugins/uploadify/uploadify.php',
			'cancelImg'      : './js/jquery.plugins/uploadify/cancel.png',
			'folder'         : '<?=$upload_path?>',
			'multi'          : true,
			'auto'           : true,
			'fileExt'        : '*.jpg;*.gif;*.png',
			'fileDesc'       : 'Image Files (.JPG, .GIF, .PNG)',
			'queueID'        : 'custom-queue',
			'queueSizeLimit' : 20,
			'simUploadLimit' : 20,
			'removeCompleted': false,
			'onSelectOnce'   : function(event,data) {
				$('#status-message').text(data.filesSelected + ' files have been added to the queue.');
			},
			'onAllComplete'  : function(event,data) {
				$('#status-message').text(data.filesUploaded + ' files uploaded, ' + data.errors + ' errors.');
				//("#multiupload").val("");
				//rtn_true();
				//return true;
				//alert(data.fileCount);
				//alert('There are ' + data.fileCount + ' files remaining in the queue.');
			},
			'onError'     : function (event,ID,fileObj,errorObj) {
				alert(errorObj.type + ' Error: ' + errorObj.info);
			}
		});
	});

function board_write_uploadify(f){
	if($("#sethtmleditor").val() == "1") oEditors.getById["CONTENTS"].exec("UPDATE_IR_FIELD", []); //smart Editor 에 대한 보강

	if(f.spamfree.value){
		alert('데이타가 전송중입니다.');
		return false;	
	}else if(autoCheckForm(f)){
		//첨부된 파일 정보를 바꾼다.	
		if(f.multi_file_list != undefined){
			var multi_file_len = f.multi_file_list.length;
			var TmpMultiFileValue = '';		
			var tmparr = "";
			for(var i=0; i< multi_file_len; i++){
				if(f.multi_file_list.options[i]) TmpMultiFileValue += f.multi_file_list.options[i].value + '|';
			}
			f.MultiFileValue.value = TmpMultiFileValue;
		}
		f.spamfree.value='<?=time()?>';
		$('#file_upload').uploadifyUpload();//파일을 업로드 시킨다.

		

		
    }else return false;
}


function rtn_true(){
			$("#WRITE_FORM_TRANSFER_DIV").show();
		$("#WRITE_FORM_DIV").hide();
		return true;
}
</script> 
<style type="text/css"> 

 .uploadifyQueueItem {
  background-color: #FFFFFF;
  border: none;
  border-bottom: 0px solid #E5E5E5;
  font: 11px Verdana, Geneva, sans-serif;
  height: 20px;
  margin-top: 0;
  padding: 1px;
  width: 350px;
}

.uploadifyError {
  background-color: #FDE5DD !important;
  border: none !important;
  border-bottom: 1px solid #FBCBBC !important;
}
.uploadifyQueueItem .cancel {
  float: right;
}
.uploadifyQueue .completed {
  color: #C5C5C5;
}
.uploadifyProgress {
  background-color: #E5E5E5;
  margin-top: 1px;
  width: 100%;
}
.uploadifyProgressBar {
  background-color: #0099FF;
  height: 3px;
  width: 1px;
}
#custom-queue {
  border: 1px solid #E5E5E5;
  height: 100px;
margin-bottom: 10px;
  width: 370px;
}	

#attachBox {
    width:600;
    height:115;
    overflow:auto;
    padding:0px;
    border:0 solid;

}
</style> 
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
    <input type="hidden" name="CATEGORY" value="<?=$category?>">
    <input type="hidden" name="ID" value="<?=$cfg["member"]["mid"];?>">
    <input type="hidden" name="spamfree" value="">
	<input type="hidden" name="multiupload" id="multiupload" value="uploadify"><!-- uploadify사용시 -->
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr  height="2" >
              <td height="2" colspan="7" bgcolor="#999999"></td>
            </tr>
            <tr>
              <td width="99" height="30" align="center">제목</td>
              <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="1" height="25"></td>
              <td colspan="5" align="left">&nbsp;&nbsp;
               <input name="SUBJECT" type="text" id="SUBJECT" class="board_text" value="<?=$list[SUBJECT];?>" size="50" checkenable msg="제목을 입력하세요" autocomplete="off" />
               
<?
if($cfg["wizboard"]["editorenable"] == "1"){
?>
<input type=hidden name="TxtType" value="1" /> 
<?
}else{
?>
               <input type=checkbox name="TxtType" <? if(!strcmp($list["TxtType"],"1")) ECHO " checked";?> value="1" />                
               HTML사용&nbsp;&nbsp;
<?
}
?>

                <input type=checkbox name="Secret" <? if($list["Secret"]) echo " checked";?> value="1">
                비밀글                      &nbsp;&nbsp;
          
 <?
//echo $_COOKIE[BOARD_PASS].",".$_COOKIE[ROOT_PASS];		  
if($_COOKIE[BOARD_PASS] || $_COOKIE[ROOT_PASS]):
?>
          <input type=checkbox value="1" name="MainDisplay"<? if($list["MainDisplay"]) echo " checked";?>>
          공지글
          <?
endif;
?>              </td>
            </tr>
            <tr  height="1">
              <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
            </tr>
            <tr>
              <td width="99" height="30" align="center">글쓴이</td>
              <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="1" height="25"></td>
              <td align="left">&nbsp;&nbsp;<input type="text" name="NAME" size="15" value="<? if($list[NAME]) echo "$list[NAME]"; else echo $cfg["member"]["mname"];?>" checkenable msg="이름을 입력하세요" autocomplete="off" class="board_text" />              </td>
              <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="1" height="25"></td>
              <td width="99" align="center">비밀번호</td>
              <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="1" height="25"></td>
              <td align="left">&nbsp;&nbsp;<input type="password" name="PASSWD" size="15" value="<? echo $list["PASSWD"]; ?>" checkenable msg="비밀번호를 입력하세요" autocomplete="off" class="board_text" /></td>
            </tr>
            <tr  height="1">
              <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
            </tr>
            <tr>
              <td width="99" height="30" align="center">이메일</td>
              <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="1" height="25"></td>
              <td colspan="5" align="left">&nbsp;&nbsp;<input type="text" name="EMAIL" size="40" value="<? if($list[EMAIL]) echo "$list[EMAIL]"; else echo $cfg["member"]["mmail"];?>" autocomplete="off"  class="board_text" /></td>
            </tr>
            <tr  height="1">
              <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
            </tr>
<? 
if($cfg["wizboard"]["CategoryEnable"]):
?>
            <tr>
              <td width="99" height="30" align="center"> 카테고리 </td>
              <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="1" height="25"></td>
              <td colspan="5" align="left">&nbsp;&nbsp;
<?=$board->getselectcategory($list["CATEGORY"])?>              </td>
            </tr>
            <tr  height="1">
              <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
            </tr>
<? endif; ?>
           
            <tr>
              <td height="180" colspan="7" align="center"><textarea name="CONTENTS" rows="15" id="CONTENTS" checkenable msg="내용을 입력하세요" class="board_text"  style=" width:98%;" /><?=$list[CONTENTS];?></textarea></td>
            </tr>
            <tr  height="1">
              <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
            </tr>
<?
if($cfg["wizboard"]["editorenable"] == "1"){
?>
<script>
var oEditors = [];
nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "CONTENTS",
	sSkinURI: "./js/Smart/SEditorSkin.html",
	fCreator: "createSEditorInIFrame"
});

function insertIMG(irid,fileame)
{
 
    var sHTML = "<img src='" + fileame + "' border='0'>";
    oEditors.getById[irid].exec("PASTE_HTML", [sHTML]);
 
}
</script>
<?
}//if($cfg["wizboard"]["editorenable"] == "1"){
		//for($i=0; $i<$cfg["wizboard"]["ATTACHEDCOUNT"]; $i++){
?>
            <tr>
              <td width="99" height="30" align="center">첨부파일</td>
              <td width="1" align="center" valign="middle" bgcolor="f0f0f0"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="1" height="25"></td>
              <td colspan="5" align="left">
			  <div id="attachBox">
				<div id="custom-queue" class="fleft"></div>
				<div class="fleft"><input id="custom_file_upload" type="file" name="Filedata" /></div>
				</div>
				<div>

				<? 
				if($mode == "modify"){
					if(is_array($list["filename"]))
					foreach($list["filename"] as $key=>$val){
						echo $common->getImgName($list["filename"][$key])." <input name='file_del[".$key."]' type='checkbox' value='1'>파일삭제 "; 
					}
				}
				?>
				</div>
			</td>
            </tr>
            <tr  height="1">
              <td height="1" colspan="7" align="center" bgcolor="#CCCCCC"></td>
            </tr>
<?
//}//for($i=0; $i<$cfg["wizboard"]["ATTACHEDCOUNT"]; $i++){
?>
            <tr>
              <td colspan="7" align="center">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center"><table height="30" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="62"><? echo $board->showBoardIcon('save');?></td>
              <td width="62"><? echo $board->showBoardIcon('cancel');?></td>
            </tr>
          </table></td>
      </tr>
  </table>
  </form>
</div>