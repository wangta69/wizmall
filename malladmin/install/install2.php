<?php
include "../../lib/cfg.common.php";
header("Content-Type: text/html; charset=".$cfg["common"]["lan"]);
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
	$(".btn_start").click(function(){
		if ( !$("#db_host").val() ) {
			jAlert('MYSQL 호스트를 입력해 주십시오.');
			return false;
		}else if ( !$("#USER_DB").val() ) {
			jAlert('사용하실 MYSQL DB의 이름을 입력해 주십시오.');
			return false;
		}else if ( !$("#db_user").val() ) {
			jAlert('MYSQL DB 아이디를 입력해 주십시오.');
			return false;
		}else if ( !$("#admin").val() ) {
			jAlert('관리자 ID를 입력해 주십시오.');
			return false;
		}else if ( !$("#PASS").val() ) {
			jAlert('초기로 등록하실 관리자 패스워드를 입력해 주십시오.');
			return false;
		}else if ( !$("#PASS1").val()) {
			jAlert('초기로 등록하실 관리자 패스워드를 다시한번 입력해 주십시오.');
			return false;
		}else if ( $("#PASS").val() != $("#PASS1").val() ) {
			jAlert('초기로 등록하실 관리자 패스워드와 확인하신 패스워드가 다릅니다.');
			return false;
		}else{
			jConfirm('입력하신 모든 값들이 정말로 정확합니까?', '', function(t){
				if(t)$("#s_form").submit();
			});
		}
	});
});
</script>
</head>
<body>
<div id="layout">
<form name="s_form" id="s_form" action='./install3.php' method='post'>
	<table class="table_main b_white">
		<tr>
			<td colspan=4>&nbsp; 다음의 
				필드들을 정확히 입력해 주시기 바랍니다.</td>
		</tr>
		<tr>
			<th>* MYSQL호스트</th>
			<td><input type="text" name="db_host" id="db_host" value="localhost">
			</td>
			<th>* 사용DB이름</th>
			<td><input type="text" name="USER_DB" id="USER_DB">
			</td>
		</tr>
		<tr>
			<th>* DB 아이디</th>
			<td><input type="text" name="db_user" id="db_user">
			</td>
			<th>* DB 패스워드</th>
			<td><input type="password" name="db_password" id="db_password">
			</td>
		</tr>
		<tr>
			<td colspan=4>* MYSQL호스트가 타 호스트인 
				경우 변경해 주십시오. MYSQL 정보가 정확해야 정상적으로 설치됩니다. </td>
		</tr>
		<tr>
			<th>* Admin ID</th>
			<td colspan="3"><input type="text" name="admin" id="admin">
			</td>
		</tr>
		<tr>
			<th>* 패스워드등록</th>
			<td><input type="password" name="PASS" id="PASS">
			</td>
			<th>* 패스워드확인</th>
			<td><input type="password" name="PASS1" id="PASS1">
			</td>
		</tr>
		<tr>
			<td colspan=4>* ID 및 패스워드는 반드시 
				기억하고 계셔야합니다.</td>
		</tr>
	</table>
	<div class="btn_box">
		<span class="btn_start button bull"><a>INSTALL START</a></span>
	</div>
</form>
</div>
</body>
</html>