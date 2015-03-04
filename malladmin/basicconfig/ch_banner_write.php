<?
#CREATE TABLE `wizbanner` (
#  `uid` int(11) NOT NULL auto_increment,
#  `ordernum` int(5) NOT NULL default '0',
#  `url` varchar(50) NOT NULL default '',
#  `target` varchar(20) NOT NULL default 'root',
#  `attached` varchar(250) NOT NULL default '',
#  `wdate` int(13) NOT NULL default '0',
#  PRIMARY KEY  (`uid`)
#) type=MyISAM AUTO_INCREMENT=1 ;


$BOARD_name="wizbanner";
/******************************************************************************/

if ($query == 'qin') {   //
	## 파일 업로딩 시작 
	$common->upload_path = "../config/banner";
	$common->uploadmode = "insert";
	$common->uploadfile("file");
	$linkimg = $common->returnfile[0];
	## 파일 업로딩 끝
	
	$sqlstr = "select max(ordernum) from $BOARD_NAME where flag1 = '$flag1'";
	$max = $dbcon->get_one($sqlstr);
	$max = $max?$max+1:1;
	$sqlstr = "insert into $BOARD_NAME (flag1, ordernum, subject, url, target, attached, showflag, wdate) values('$flag1', '$max','$subject', '$url','$target', '$linkimg','$showflag',".time().")";
	$sqlqry = $dbcon->_query($sqlstr);
	$common->js_location("$PHP_SELF?theme=basicconfig/ch_banner&menushow=$menushow&flag1=$flag1");
	
	
}else if ($query == 'qup') {   //if ($query == 'insert') {   //
	## 파일 업로딩 시작 
	$common->upload_path = "../config/banner";
	$common->uploadmode = "update";
	$common->oldfilename = $oldfile;
	$common->uploadfile("file");
	$linkimg = $common->returnfile[0];
	## 파일 업로딩 끝	
	
	$sqlstr = "update $BOARD_NAME set ordernum='$ordernum', url='$url', target='$target', attached='$linkimg' where uid='$uid'";
	$sqlqry = $dbcon->_query($sqlstr);
	$mode = "qup";
}

if($uid){
	$sqlstr = "select * from $BOARD_NAME where uid = '$uid'";
	$dbcon->_query($sqlstr);
	$list = $dbcon->_fetch_array();
	extract($list);
	$mode = "qup";
}else $mode = "qin";
?>
<script LANGUAGE=javascript>
<!--
function check_field(){
	var f = document.forms.BrdList;
}
//-->
</script>
<table class="table_outline">
  <tr>
    <td><fieldset class="desc">
						<legend>베너관리[
      <?=$banner_cat[$flag1]?>
      ]</legend>
						<div class="notice">[note]</div>
						<div class="comment"></div>
						</fieldset>
						<p></p>        <form action="<?=$PHP_SELF?>" enctype="multipart/form-data" name="BrdList" method="post" onsubmit='return check_field()'>
          <input type='hidden' name='menushow' value='<?=$menushow?>'>
          <input type="hidden" name="theme" value="<?=$theme;?>">
          <input type="hidden" name="query" value="<?=$mode;?>">
          <input type="hidden" name="uid" value="<?=$uid;?>">
		  <input type="hidden" name="flag1" value="<?=$flag1?>">
					    <table class="table">

          <tr> 
            <td>제목</td>
            <td><input name="subject" type="text" id="subject" value="<?=$subject;?>" size="30" /></td>
          </tr>
          <tr> 
            <td>URL </td>
            <td><input name="url" type="text" size="30" value="<?=$url;?>"> 
            </td>
          </tr>
          <tr> 
            <td>target </td>
            <td><select name="target" id="target">
              <option value="_self"<? if($target == "_self") echo " selected";?>>_self</option>
              <option value="_blank"<? if($target == "_blank") echo " selected";?>>_blank</option>
            </select>
            </td>
          </tr>          
          <tr> 
            <td>첨부화일</td>
            <td><input type="file" name="file[0]">
              <input type='hidden' name='oldfile'  value="<?=$attached;?>"></td>
          </tr>
          <tr> 
            <td>출력여부</td>
            <td><input name="showflag" type="radio" id="radio" value="1" checked="checked"<?=$show=="1"?" checked":""?> />
              출력
                <input type="radio" name="showflag" id="radio2" value="0"<?=$show=="0"?" checked":""?> />
                미출력</td>
          </tr>          
        
      </table></form><div class="btn_box"><input type="image" src="img/dung.gif"></div></td>
  </tr>
</table>
