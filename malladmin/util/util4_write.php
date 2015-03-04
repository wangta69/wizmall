<?php
#CREATE TABLE `wizbanner` (
#  `uid` int(11) NOT NULL auto_increment,
#  `ordernum` int(5) NOT NULL default '0',
#  `url` varchar(50) NOT NULL default '',
#  `target` varchar(20) NOT NULL default 'root',
#  `attached` varchar(250) NOT NULL default '',
#  `wdate` int(13) NOT NULL default '0',
#  PRIMARY KEY  (`uid`)
#) type=MyISAM AUTO_INCREMENT=1 ;
$BOARD_NAME="wizbanner";
/******************************************************************************/

if ($query == 'qin') {   //
/* 파일 업로딩 시작 */
	$file_field_name = "file";
	file_uploade($file_field_name);
	//echo sizeof($file);
	for($i=0; $i<sizeof($file); $i++){
	$MicroTsmp = explode(" ",microtime());
	$newFileName = str_replace(".", "", $MicroTsmp[0]);
		//echo "file_name[$i] = ".$file_name[$i]." <br />";
		if($file_name[$i]!="none" && $file_name[$i]){
		//echo "test";
			$extention = strrchr($file_name[$i], ".");	
			$file_name[$i] = time()."".$extention;
			if($oldfile[$i]) unlink("../wizstock/$oldfile[$i]");
			if (file_exists("../wizstock/$file_name[$i]")) {
			$file_name[$i] = $newFileName."_$file_name[$i]";
			}    
			if(!move_uploaded_file($file_tmp_name[$i], "../wizstock/$file_name[$i]")) {
			echo "파일 업로드에 실패 하였습니다.";
			exit;}
		$UPDIR[$i]=$file_name[$i];
		}else $UPDIR[$i]=$oldfile[$i];
			
	
	$linkimg[$i] =$UPDIR[$i];
	}//exit;
	/* 파일 업로딩 끝 */
	$wdate = time();	
	$sqlstr = "insert into $BOARD_NAME (flag1, ordernum, url, attached, wdate) values('$flag1', '$ordernum', '$url', '$linkimg[0]', '$wdate')";
	$dbcon->_query($sqlstr);
	//echo "sqlstr = $sqlstr <br />";
	//exit;
	echo "<script >location.href('$PHP_SELF?theme=util/util4&menushow=$menushow&flag1=$flag1');</script>";
	//exit;
}else if ($query == 'qup') {   //if ($query == 'insert') {   //
/* 파일 업로딩 시작 */
	$file_field_name = "file";
	file_uploade($file_field_name);
	//echo sizeof($file);
	for($i=0; $i<sizeof($file); $i++){
	$MicroTsmp = explode(" ",microtime());
	$newFileName = str_replace(".", "", $MicroTsmp[0]);
		//echo "file_name[$i] = ".$file_name[$i]." <br />";
		if($file_name[$i]!="none" && $file_name[$i]){
		//echo "test";
			$extention = strrchr($file_name[$i], ".");	
			$file_name[$i] = time()."".$extention;
			if($oldfile[$i]) unlink("../wizstock/$oldfile[$i]");
			if (file_exists("../wizstock/$file_name[$i]")) {
			$file_name[$i] = $newFileName."_$file_name[$i]";
			}    
			if(!move_uploaded_file($file_tmp_name[$i], "../wizstock/$file_name[$i]")) {
			echo "파일 업로드에 실패 하였습니다.";
			exit;}
		$UPDIR[$i]=$file_name[$i];
		}else $UPDIR[$i]=$oldfile[$i];
			
	
	$linkimg[$i] =$UPDIR[$i];
	}//exit;
	/* 파일 업로딩 끝 */	
	$sqlstr = "update $BOARD_NAME set ordernum='$ordernum', url='$url', attached='$linkimg[0]' where uid='$uid'";
	//echo "sqlstr = $sqlstr <br />";
	//exit;
	$dbcon->_query($sqlstr);
	$mode = "qup";
}

if($mode == "qup"){
$sqlstr = "select * from $BOARD_NAME where uid = '$uid'";
$dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array();
}else $mode = "qin";
?>
<script>

function check_field(){
	var f = document.forms.BrdList;
}
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">베너관리</div>
	  <div class="panel-body">
		 order가 작은 순서가 상위에 위치합니다.
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
						<p></p>
					    <table class="table">
        <form action="<?php echo $PHP_SELF?>" enctype="multipart/form-data" name="BrdList" method="post" onsubmit='return check_field()'>
          <input type='hidden' name='menushow' value='<?php echo $menushow?>'>
          <input type="hidden" name="theme" value="<?php echo $theme;?>">
          <input type="hidden" name="cp" value="<?php echo $cp;?>">
          <input type="hidden" name="SUB_cp" value="<?php echo $SUB_cp;?>">
          <input type="hidden" name="query" value="<?php echo $mode;?>">
          <input type="hidden" name="uid" value="<?php echo $uid;?>">
		  <input type="hidden" name="flag1" value="<?php echo $flag1;?>">
          <tr> 
            <td>우선순위</td>
            <td><input name="ordernum" type="text" size="3" value="<?php echo $list["ordernum"];?>"></td>
          </tr>
          <tr> 
            <td>URL </td>
            <td><input name="url" type="text" size="30" value="<?php echo $list["url"];?>"> 
            </td>
          </tr>
          <tr> 
            <td>첨부화일</td>
            <td><input type="file" name="file[0]">
              <input type='hidden' name='oldfile[0]'  value="<?php echo $list["attached"];?>"></td>
          </tr>
          <tr> 
            <td colspan="2"> <table>
                <tr> 
                  <td> <input type="image" src="img/dung.gif" width="55"></a>
                  </td>
                </tr>
              </table></td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
