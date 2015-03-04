<?php
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 

Copyright shop-wiz.com
*** Updating List ***
*/
include ("../common/header_pop.php");
include ("../../config/common_array.php");

//print_r($_POST);
/*
CREATE TABLE IF NOT EXISTS `wizpdoption` (
  `uid` int(11) NOT NULL auto_increment,
  `op_name` varchar(20) default NULL,
  `op_main_order` tinyint(4) default NULL,
  `op_main_image` varchar(100) default NULL,
  `op_main_cnt` tinyint(4) default NULL,
  `op_display` set('Y','N') NOT NULL default 'N',
  PRIMARY KEY  (`uid`)
)

uid,op_name,op_main_order,op_main_image,op_main_cnt,op_display


*/
$uid			= $_POST["uid"];
$serno			= $_POST["serno"];
$qry			= $_POST["qry"];
$oldfile		= $_POST["oldfile"];
$op_name		= $_POST["op_name"];
$op_main_order	= $_POST["op_main_order"];
$op_display		= $_POST["op_display"];
$op_main_cnt	= $_POST["op_main_cnt"];
				
				
if($qry == "qup"){
	## 파일 업로딩 시작 
	$common->upload_path	= "../../config/pdoption";
	$common->uploadmode		= "update";
	$common->oldfilename	= $oldfile;
	$common->uploadfile("file");
	$op_main_image = $common->returnfile[$serno]? $common->returnfile[$serno]:$oldfile;
	
	$common->uploadfile("file_icon");
	$op_icon_image = $common->returnfile[$serno]? $common->returnfile[$serno]:$oldfile;
	
	## 파일 업로딩 끝	

	$sqlstr = "update wizpdoption set 
				op_name = '".$op_name[$uid]."',  
				op_main_order = '".$op_main_order[$uid]."', 
				op_main_image = '".$op_main_image."', 
				op_icon_image = '".$op_icon_image."', 
				op_main_cnt = '".$op_main_cnt[$uid]."', 
				op_display = '".$op_display[$uid]."'
				where uid = '$uid'";
	$dbcon->_query($sqlstr);
}else if($qry == "qin"){
	## 파일 업로딩 시작 
	$common->upload_path = "../../config/pdoption";
	$common->uploadmode = "insert";
	$common->uploadfile("file");
	$op_main_image = $common->returnfile[0];
	$common->uploadfile("file_icon");
	$op_icon_image = $common->returnfile[0];
	## 파일 업로딩 끝

	$sqlstr = "insert into wizpdoption (op_name,op_main_order,op_main_image,op_icon_image,op_main_cnt,op_display) 
				values
				('".$op_name."','".$op_main_order."','".$op_main_image."','".$op_icon_image."','".$op_main_cnt."','".$op_display."')";
	$dbcon->_query($sqlstr);
}else if($qry == "qdel"){
	$sqlstr = "delete from wizpdoption where uid = '$uid'";
	$dbcon->_query($sqlstr);
}

?>

<html>
<?php
$title = "위즈몰 관리자 모드 - 상품등록옵션 관리";
include ("../common/header_html.php");
?>
<script language="javascript">
<!--
$(function(){
	$(".btn_close").click(function(){
		self.close();
	});

	$(".btn_save").click(function(){
		$("#s_form").submit();
	});

	$(".btn_delete").click(function(){
		var val	= $(this).parent().parent().attr("value");
		var tmp	= val.split("|");
		
		$("#oldfile").val(tmp[1]);
		
		$("#serno").val($(".btn_delete").index(this));
		qryStatus(tmp[0], "qdel");
	});

	$(".btn_update").click(function(){
		var val	= $(this).parent().parent().attr("value");
		var tmp	= val.split("|");

		$("#oldfile").val(tmp[1]);
		$("#serno").val($(".btn_update").index(this));
		qryStatus(tmp[0], "qup");
	});
});
	function qryStatus(uid, qry){
		var f = document.PublicForm;
		f.uid.value = uid;
		f.qry.value = qry;
		f.submit();
	}
//-->
</script>
<body>
상품등록옵션입니다. 이부분은 상품옵션과 연관이 있으므로 등록후 수정/삭제는 자제해 주시기 바랍니다.<br>
<table class="table_main w100p">
	<tr>
		<th>옵션명</th>
		<th>메인정렬순서</th>
		<th>메인이미지</th>
		<th>아이콘</th>
		<th>출력여부</th>
		<th>메인출력갯수</th>
		<th>&nbsp;</th>
	</tr>
	<form  action='<?php echo $PHP_SELF; ?>' name="PublicForm" method="post" enctype="multipart/form-data">
		<input type="hidden" name="uid" value="">
		<input type="hidden" name="serno" id="serno" value="">
		<input type="hidden" name="qry" value="qup">
		<input type="hidden" name="oldfile" id="oldfile" value="">
		<?php
$sqlstr = "select * from  wizpdoption order by uid asc";
$dbcon->_query($sqlstr);
while($list =$dbcon->_fetch_array()):
	$uid			= $list["uid"];
	$op_name		= $list["op_name"];
	$op_main_order	= $list["op_main_order"];
	$op_main_image	= $list["op_main_image"];
	$op_icon_image	= $list["op_icon_image"];
	$op_main_cnt	= $list["op_main_cnt"];
	$op_display		= $list["op_display"];
?>
		<tr value="<?php echo $uid;?>|<?php echo $op_main_image?>">
			<td><input name="op_name[<?php echo $uid?>]" type="text" value="<?=$op_name?>" class="w100"></td>
			<td><input name="op_main_order[<?php echo $uid?>]" type="text" value="<?=$op_main_order?>" class="w30"></td>
			<td><input type='file' name='file[<?php echo $uid?>]'><? if($op_main_image):?><img src="../../config/pdoption/<?php echo $op_main_image; ?>" width="50" /><? endif; ?></td>
			<td><input type='file' name='file_icon[<?php echo $uid?>]'><? if($op_icon_image):?><img src="../../config/pdoption/<?php echo $op_icon_image; ?>" width="50" /><? endif; ?></td>
			<td><select name="op_display[<?php echo $uid?>]" >
					<option value="Y" <?php if($op_display == "Y") echo " selected";?>>Y</option>
					<option value="N" <?php if($op_display == "N") echo " selected";?>>N</option>
				</select>
			</td>
			<td><input name="op_main_cnt[<?php echo $uid?>]" type="text" value="<?php echo $op_main_cnt?>" class="w30"></td>
			<td>
			<span class="button bull btn_update"><a>수정</a></span>
			<span class="button bull btn_delete"><a>삭제</a></span>
			</td>
		</tr>
<?php
endwhile;
?>
	</form>
	<form  action='<?php echo $PHP_SELF?>' id="s_form" method="post"  enctype="multipart/form-data">
		<input type="hidden" name="qry" value="qin">
		<tr>
			<td><input name="op_name" type="text" class="w100"></td>
			<td><input name="op_main_order" type="text" class="w30"></td>
			<td><input type='file' name='file[0]'></td>
			<td><input type='file' name='file_icon[0]'></td>
			<td><select name="op_display" >
					<option value="Y">Y</option>
					<option value="N" selected>N</option>
				</select></td>
			<td><input name="op_main_cnt" type="text" class="w30"></td>
			<td><span class="button bull btn_save"><a>등록</a></span></td>
		</tr>
	</form>
</table>
<br />
<div class="agn_c"><span class="button bull btn_close"><a>닫기</a></span></div>
</body>
</html>
