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


$tablename="wizbanner";
/******************************************************************************/

if ($query == 'qin') {   //
	## 파일 업로딩 시작 
	$common->upload_path = "../config/banner";
	$common->uploadmode = "insert";
	$common->uploadfile("file");
	$linkimg = $common->returnfile[0];
	## 파일 업로딩 끝
	
	$sqlstr = "select max(ordernum) from $tablename where flag1 = '$flag1'";
	$max = $dbcon->get_one($sqlstr);
	$max = $max?$max+1:1;
	$sqlstr = "insert into $tablename (flag1, ordernum, url, target, attached, wdate) values('$flag1', '$max', '$url','$target', '$linkimg',".time().")";
	$sqlqry = $dbcon->_query($sqlstr);
	$common->js_location("$PHP_SELF?theme=basicconfig/main01&menushow=$menushow&flag1=$flag1");
	
	
}else if ($query == 'qup') {   //if ($query == 'insert') {   //
	## 파일 업로딩 시작 
	$common->upload_path = "../config/banner";
	$common->uploadmode = "update";
	$common->oldfilename = $oldfile;
	$common->uploadfile("file");
	$linkimg = $common->returnfile[0];
	## 파일 업로딩 끝	
	
	$sqlstr = "update $tablename set ordernum='$ordernum', url='$url', target='$target', attached='$linkimg' where uid='$uid'";
	$sqlqry = $dbcon->_query($sqlstr);
	$mode = "qup";
}

if($uid){
	$sqlstr = "select * from $tablename where uid = '$uid'";
	$dbcon->_query($sqlstr);
	$list = $dbcon->_fetch_array();
	extract($list);
	$mode = "qup";
}else $mode = "qin";
?>
<script language="javascript" type="text/javascript">
<!--
$(function(){
	$("#btn_save").click(function(){
		$("#s_form").submit();
	});
})
//-->
</script>

<table class="table_outline">
	<tr>
		<td><fieldset class="desc">
			<legend>베너관리</legend>
			<div class="notice">[note]</div>
			<div class="comment"> order가 작은 순서가 상위에 위치합니다. </div>
			</fieldset>
			<div class="space20"></div>
			<form action="<?=$PHP_SELF?>" enctype="multipart/form-data" id="s_form" method="post">
				<input type='hidden' name='menushow' value='<?=$menushow?>'>
				<input type="hidden" name="theme" value="<?=$theme;?>">
				<input type="hidden" name="query" value="<?=$mode;?>">
				<input type="hidden" name="uid" value="<?=$uid;?>">
				<input type="hidden" name="flag1" value="<?=$flag1?>">
				<table class="table">
					<tr>
						<th>우선순위</th>
						<td><input name="ordernum" type="text" class="w30" value="<?=$ordernum;?>"></td>
					</tr>
					<tr>
						<th>URL </th>
						<td><input name="url" type="text" class="w100p" value="<?=$url;?>">
						</td>
					</tr>
					<tr>
						<th>target </th>
						<td><select name="target" id="target">
								<option value="_self"<? if($target == "_self") echo " selected";?>>_self</option>
								<option value="_blank"<? if($target == "_blank") echo " selected";?>>_blank</option>
							</select>
						</td>
					</tr>
					<tr>
						<th>첨부화일</th>
						<td><input type="file" name="file[0]">
							<input type='hidden' name='oldfile'  value="<?=$attached;?>"></td>
					</tr>
				</table>
				<div class="btn_box" id="btn_save"><span class="button bull"><a>등록</a></span></div>
			</form></td>
	</tr>
</table>
