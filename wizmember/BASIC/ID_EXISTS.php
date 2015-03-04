<?
include ("../../lib/cfg.common.php");
include ("../../config/db_info.php");
include ("../../lib/class.database.php");
$dbcon		= new database($cfg["sql"]);

$sqlstr = "SELECT count(uid) FROM wizMembers WHERE mid='$user_id'";
$result = $dbcon->get_one($sqlstr);

if(!$user_id) {
	$message = "id를 입력해 주세요";
	$status = "false";
}else if((strlen($user_id) > 12) || (strlen($user_id) < 6)) {
	$message = "아이디는 6~12자 사이의 영문숫자 혼합으로 구성되어야 합니다.";
	$status = "false";
}else if ( $result ) {
	$message = "<span class='orange'>".$user_id."</span>은(는) 이미 사용중인 아이디입니다.";
	$status = "false";
}
else {
	$message	= "<span class='orange'>".$user_id."</span>은(는) 사용가능한 ID입니다.";
	$status = "true";
}
$dbcon->_close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>" />
<title>ID 체크</title>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script language="javascript" src="../../js/wizmall.js"></script>
<link rel="stylesheet" href="../../css/common.css" type="text/css" />
<script language="JavaScript">
<!--
$(function(){
	$("#btn_search").click(function(){
		if($("#user_id").val() == ""){
			alert("아이디를 입력해주세요");
			$("#user_id").focus();
		}else{
			$("#s_form").submit();
		}
	});
});
	function setting(user_id) {
		$("#id",opener.document).val(user_id)
		$("#idchk_result",opener.document).val(1)
		self.close();
	}
-->
</script>
</head>
<body>
<form name="s_form" id="s_form">
	<input type="hidden" name="action" value="user_idcheck">
	<div class="agn_l b white b_black">아이디 체크</div>
	<div class="space15"></div>
	아이디는 영/숫자 혼합으로 6~15자가 가능합니다.
	<div class="space15"></div>
	아이디
	<input type="text" name="user_id" id="user_id"  value="<?=$user_id?>" size=15>
	<? if($status == "true") : ?>
	<span class="button bull"><a href="javascript:setting('<?=$user_id?>')">적용</a></span>
	<? endif; ?>
	<span class="button bull" id="btn_search"><a>검색</a></span>
	<div class="space15"></div>
	<div class="msg">
		<?=$message?>
	</div>
</form>
</body>
</html>
