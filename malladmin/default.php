<?php
/*
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
Updating List
*/

include "../lib/cfg.common.php";
include "../lib/class.common.php";
$common = new common();
$common->db_connect($dbcon);
$common->pub_path = "../";
$cfg["member"] = $common->getLogininfo();//로그인 정보를 가져옮

include "../lib/class.admin.php";
$admin = new admin();
$admin->get_object($dbcon, $common);

if(is_file("../config/WizApplicationStartDate_info.php")) include "../config/WizApplicationStartDate_info.php";
if(!$WizApplicationStartDate){
	$fp = fopen("../config/WizApplicationStartDate_info.php", "w"); 
	$Startday = time();
	fwrite($fp,"<?
	\$WizApplicationStartDate=$Startday;
	?>"); 
	fclose($fp);
}


if($admin->accessGrade($cfg["member"]["mgrade"])) $common->js_location("main.php?menushow=menu0&theme=front");

?>
<!DOCTYPE html>
<html lang="kr">
<head>
<title>관리자님 환영합니다. [위즈몰 관리자 페이지1]</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>">
<script language="javascript" src="../js/jquery.min.js" type="text/javascript"></script>
<script language="javascript" src="../js/jquery.plugins/jquery.locationcenter-1.0.1.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	$("#wizmemberID").focus();
	$("#main").locationcenter();
});

function loginForm(f) {
	if ( !f.wizmemberID.value.length ) {
		alert('\n아이디를 입력해 주십시오. \n');
		return false;
	}else if ( !f.wizmemberPWD.value.length ) {
		alert('\n패스워드를 입력해 주십시오. \n');
		return false;
	}
}
</script>
<link rel="stylesheet" href="../css/base.css" type="text/css">
<link rel="stylesheet" href="../css/admin.css" type="text/css">
</head>
<body>
<script language="javascript" src="http://www.shop-wiz.com/register_check.js"></script>
<div id="main" class="agn_c">
	<form action='./admin_log_check.php' method='POST' name='ADMIN_LOG' onsubmit='return loginForm(this);'>
		<input name="AdminGrade" type="radio" value="1" checked>
		관리자
		<input type="radio" name="AdminGrade" value="2">
		일반
		<table width="552" border="0" height="254" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td><img src="./img/log01.gif" width="552" height="82"></td>
			</tr>
			<tr>
				<td><table width="552" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td><img src="./img/log02.gif" width="177" height="78"></td>
							<td width="242" height="78" background="./img/logbg.gif"><table width="242" border="0" cellpadding="0" cellspacing="0" class="text-admin">
									<tr>
										<td width="48"><img src="./img/id.gif" width="28" height="18"></td>
										<td width="194"><input name="wizmemberID" class="w100" id="wizmemberID" style="width:100px" tabindex=1 value="<?=$_COOKIE["saved_id"]?>"  autocomplete="off" >
											<input name="saveflag" type="checkbox" id="saveflag" value="1" <? if($_COOKIE["saveflag"]) echo "checked";?>>
											ID 저장</td>
									</tr>
									<tr>
										<td width="48"><img src="./img/pw.gif" width="28" height="20"></td>
										<td width="194"><input name="wizmemberPWD" type="password" class="w100" tabindex=2 size=20 id="wizmemberPWD" autocomplete="off"></td>
									</tr>
								</table></td>
							<td><input type="image" src="./img/log04.gif" width="89" height="78" tabindex=3></td>
							<td><img src="./img/log05.gif" width="44" height="78"></td>
						</tr>
					</table></td>
			</tr>
			<tr>
				<td><img src="./img/log06.gif" width="552" height="94"></td>
			</tr>
		</table>
	</form>
	<div class="agn_l">
		<ul>
			<li>* 이곳은 위즈몰 관리자 영역입니다.</li>
			<li>* 관리자외에 접근할 수 없도록 비밀번호관리를 잘 하여주시기 바랍니다.</li>
			<li>* <a href="../">홈으로 돌아가기</a></li>
			<li class="orange">* <a href="http://www.shop-wiz.com" target="_blank">powered by 숍위즈</a></li>
		</ul>
	</div>
</div>
</body>
</html>
