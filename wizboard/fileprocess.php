<?php
include "../lib/inc.depth1.php";

include "../lib/class.board.php";
$board = new board();
$board->get_object($dbcon, $common);

$uppath = "../config/wizboard/table/".$gid."/".$bid."/updir/";

if($smode == "moveout"){
	$file_name = explode(",",substr($file_name,0,-1));
	$count = count($file_name);
	echo "<div id='content2'><div id='box2'><ul class='content_box2'><li>*<span class='latestName4'> <?=$count?> 개</span> 파일 삭제중 ...</li></ul></div></div>";

	for($i=0 ; $i<$count ; $i++)
	{
		$board->deletefile($bid,$gid,$file_name[$i],$uid,$uppath);
		//unlink($uppath.$file_name[$i]);
	}
	
	$common->js_windowclose();
}else if ($smode == "fileup"){
	$common->upload_path = $uppath;
	$common->AllowExtention = "gif,jpg,jpeg,png";
	$common->uploadfile("attachfile");
	
	if(is_array($common->returnfile)) $filename = $common->returnfile[0];
	if($filename){
	$weburl = "./config/wizboard/table/".$gid."/".$bid."/updir/".$filename;
	list($_width, $_height, $type, $attr) = getimagesize($common->upload_path.$filename);
?>
	<script type="text/javascript">
	function filepaste(fileseq,filename)
	{
		form = window.parent.opener.document.BOARD_WRITE_FORM;
		form["multi_file_list"].options.length = form["multi_file_list"].options.length + 1;
		form["multi_file_list"].options[form["multi_file_list"].options.length-1].text = filename;
		form["multi_file_list"].options[form["multi_file_list"].options.length-1].value = fileseq;
		window.close();
	}
	</script>
	<script type="text/javascript">
	var _iframe = '';
	var imgpath = "<img src='<?=$weburl?>' width='<?= $_width?>' height='<?= $_height?>'>"

	   var _iframe = opener.document.getElementById('CONTENTS_alditor');
	   
		_iframe.contentWindow.focus();
		_iframe.contentWindow.document.execCommand("delete", false, null);
		if (window.showModelessDialog)//true 면 MS 계열
		{
			_iframe.contentWindow.document.selection.createRange().pasteHTML(imgpath);
		} else {//Nestcape 계열
			_iframe.contentWindow.document.execCommand("InsertHTML", false, imgpath);
		}
	
	filepaste("<?=$filename?>","<?=$common->getImgName($filename)?> (<?=$common->my_filesize($common->upload_path.$filename) ?>)");
	</script>
<?
	exit;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>">
<title></title>
<style type="text/css">
form {display:inline;}
div,ul,ol,dl,li,dt,dd,h1,h2,h3,h4,h5,h6,pre,form,body,html,p,blockquote,fieldset,input,object,iframe { margin:0; padding: 0; }
#container #content2 {
	float: left;
	width: 310px;
}

#container #content2 #box2 {
	float: left;
	width: 310px;
	padding: 0px 0px 20px 0px;
}

#container #content2 #box2 li{
	float: left;
	width: 310px;
	height: 40px;
}

.content_box2 {
	float: left;
	color: #555555; 
	border:1px solid #D6D4D4; 
	background:#FBFBFB; 
	width:310px;
	height:130px;
	font-size: 11px;
	text-align: center;
	list-style-type: none;
	padding-top: 25px;
}

.latestName4 { 
	font-size: 11px; 
	color: #FF4200;
	font-weight: bold;
}

.inputbox {
	border:1px solid #999999;
	font-family:돋움;
	font-size:12px;
	height:18px;
	color:#666666;
}
</style>
</head>
<body>
<div id="container">
<script type="text/javascript">
<!--
function in_check(t)
{
	var fname = t.attachfile.value;
	if(fname.length <=0)
	{
		window.alert("파일을 선택하세요");
		t.attachfile.focus();
		return false;
	}
	if (!fname.match(/\.(gif|jpg|jpeg|png|GIF|JPG|PNG|JPEG)$/) || fname.length <= 0)
	{
		window.alert("첨부할수 있는 파일형태가 아닙니다.gif|jpg|jpeg|png|GIF|JPG|PNG|JPEG 타입만 첨부 가능 합니다.");
		t.attachfile.focus();
		return false;
	}
}
-->
</script>
<form method="post" id="inform" enctype="multipart/form-data" action="<?=$PHP_SELF;?>" onSubmit="return in_check(this);">
<div id="content2">
	<div id="box2">
		<ul class="content_box2">
			<li><input type="file" name="attachfile[]" size="30" class="inputbox" /></li>
			<li>*<span class="latestName4"> 500kb</span> 미만의 파일만 올릴 수 있습니다.</li>
			<li><input type="image" src="./images/btn_confirm2.gif" title="확인" alt="확인" /></li>
		</ul>
	</div>
<fieldset>
<input type="hidden" name="smode" value="fileup" />
<input type="hidden" name="bid" value="<?=$bid?>" />
<input type="hidden" name="gid" value="<?=$gid?>" />
</fieldset>    
</div>

</form>
</div>
</body>
</html>