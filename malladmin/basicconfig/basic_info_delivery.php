<?
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
if($qry == "qup"){
	$sqlstr = "update wizdeliver set 
				d_name = '".$d_name[$uid]."',  
				d_code = '".$d_code[$uid]."', 
				d_url = '".$d_url[$uid]."', 
				d_inquire_url = '".$d_inquire_url[$uid]."', 
				d_method = '".$d_method[$uid]."'
				where uid = '$uid'";
	$dbcon->_query($sqlstr);
}else if($qry == "qin"){
	$sqlstr = "insert into wizdeliver (d_name,d_code,d_url,d_inquire_url,d_method) 
				values
				('".$d_name."','".$d_code."','".$d_url."','".$d_inquire_url."','".$d_method."')";
	$dbcon->_query($sqlstr);
}else if($qry == "qdel"){
	$sqlstr = "delete from wizdeliver where uid = '$uid'";
	$dbcon->_query($sqlstr);
}
?>
<html>
<head>
<?
$title = "위즈몰 관리자 모드 - 택배사 관리";
include ("../common/header_html.php");
?>
<script language="javascript">
<!--
$(function(){
	$(".btn_close").click(function(){
		self.close();
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
</head>
<body>
택배사 리스트(택배사고유키는 기존 주문과연동되므로 가급적  삭제를  피해 주시기 바랍니다.)<br>
<table class="table_main w100p">
	<tr>
		<th>택배사명</th>
		<th> 부가코드</th>
		<th>택배사URL</th>
		<th>조회페이지</th>
		<th>전송방식</th>
		<th>&nbsp;</th>
	</tr>
	<form  action='<?=$PHP_SELF?>' name="PublicForm" method="post">
		<input type="hidden" name="uid" value="">
		<input type="hidden" name="qry" value="qup">
		<?
$sqlstr = "select * from  wizdeliver order by uid asc";
$dbcon->_query($sqlstr);
while($list =$dbcon->_fetch_array()):
	$uid			= $list["uid"];
	$d_name			= $list["d_name"];
	$d_code			= $list["d_code"];
	$d_url			= $list["d_url"];
	$d_inquire_url	= $list["d_inquire_url"];
	$d_method		= $list["d_method"];
?>
		<tr>
			<td><input name="d_name[<?=$uid?>]" type="text" id="d_name" value="<?=$d_name?>" class="w100"></td>
			<td><input name="d_code[<?=$uid?>]" type="text" id="d_code" value="<?=$d_code?>" class="w100"></td>
			<td><input name="d_url[<?=$uid?>]" type="text" id="d_url" value="<?=$d_url?>" class="w100"></td>
			<td><input name="d_inquire_url[<?=$uid?>]" type="text" id="d_inquire_url" value="<?=$d_inquire_url?>" class="w100"></td>
			<td><select name="d_method[<?=$uid?>]" id="d_method">
					<option value="GET" <? if($d_method == "GET") echo " selected";?>>GET</option>
					<option value="POST" <? if($d_method == "POST") echo " selected";?>>POST</option>
				</select>
			</td>
			<td><input type="button" name="button2" id="button2" value="수정" onClick="qryStatus('<?=$uid;?>', 'qup')" style="cursor:pointer">
				<input type="button" name="button3" id="button3" value="삭제" onClick="qryStatus('<?=$uid;?>', 'qdel')" style="cursor:pointer">
			</td>
		</tr>
		<?
endwhile;
?>
	</form>
	<form  action='<?=$PHP_SELF?>' name="PublicForm1" method="post">
		<input type="hidden" name="qry" value="qin">
		<tr>
			<td><input name="d_name" type="text" id="d_name" class="w100">
			</td>
			<td><input name="d_code" type="text" id="d_code" class="w100"></td>
			<td><input name="d_url" type="text" id="d_url" class="w100"></td>
			<td><input name="d_inquire_url" type="text" id="d_inquire_url" class="w100"></td>
			<td><select name="d_method" id="d_method">
					<option value="GET">GET</option>
					<option value="POST">POST</option>
				</select></td>
			<td><input type="submit" name="button2" id="button2" value="등록"></td>
		</tr>
	</form>
</table>
<br />
<div class="agn_c"><span class="button bull btn_close"><a>닫기</a></span></div>
</body>
</html>
