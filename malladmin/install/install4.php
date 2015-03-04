<?php
include "../../lib/cfg.common.php";
include ("../../lib/class.common.php");
$common = new common();

/***
* powered by 폰돌
* Reference URL : http://www.shop-wiz.com
* Contact Email : master@shop-wiz.com
* Free Distributer : 
* Copyright shop-wiz.com
*** Updating List ***
***/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>">
<script language=javascript src="../../js/jquery.min.js"></script>
<script language=javascript src="../../js/jquery.plugins/jquery-ui-1.7.2.custom.min.js"></script>
<script language=javascript src="../../js/jquery.plugins/jqalerts/jquery.alerts.js"></script>
<link rel=StyleSheet href="../../css/base.css" type="text/css">
<link rel=StyleSheet href="../../css/admin.css" type="text/css">
<link rel=StyleSheet href="../../css/install.css" type="text/css">
<link rel="stylesheet" href="../../js/jquery.plugins/jqalerts/jquery.alerts.css" type="text/css" />
<title>▒▒ WizBoard For PHP Install ▒▒</title>
<script>

$(function(){
	$(".btn_done").click(function(){
		$("#s_form").submit();
	});
});

</script>
</head>
<body>
<div id="layout">
	<form name="s_form" id="s_form" action='install5.php' method='post'>
		<input type=hidden name=query value='adminsave'>
		<div class="step1_agree">WEB 관리자정보 및 환경을 변경합니다.</div>
		<table class="table_main  b_white">
			<tr>
				<th>상호명</th>
				<td><input type="text" name="COMPANY_NAME" size="20" value='<?=$COMPANY_NAME?>'>
				</td>
			</tr>
			<tr>
				<th>홈페이지명</th>
				<td><input type="text" name="ADMIN_TITLE" size="20" value='<?=$ADMIN_TITLE?>'>
				</td>
			</tr>
			<tr>
				<th> 관리자이메일</th>
				<td><input type="text" name="ADMIN_EMAIL" size="40" value='<?=$ADMIN_EMAIL?>'></td>
			</tr>
			<tr>
				<th>WizMall 절대경로</th>
				<td><input type="text" name="MART_BASEDIR" size="40" value='<?=$MART_BASEDIR?>'>
					<br />
					(보기 : http://www.shop-wiz.com ) </td>
			</tr>
		</table>
		<div class="btn_box">
			<span class="btn_done button bull"><a>설 정 완 료</a></span>
		</div>
	</form>
</div>
</body>
</html>
