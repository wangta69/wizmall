<?php
include "../../../../lib/cfg.common.php";
include "../../../../config/cfg.core.php";
$file_server_path = realpath(__FILE__);// PHP 파일 이름이 들어간 절대 서버 경로
$php_filename = basename(__FILE__);// PHP 파일 이름
$server_path = str_replace(basename(__FILE__), "", $file_server_path);// PHP 파일 이름을 뺀 절대 서버 경로
$base_URL = ($_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
$base_URL .= ($_SERVER['SERVER_PORT'] != '80') ? $_SERVER['HTTP_HOST'].':'.$_SERVER['SERVER_PORT'] : $_SERVER['HTTP_HOST'];
$relative_path = preg_replace("`\/[^/]*\.php$`i", "/", $_SERVER['PHP_SELF']);
$web_path = $base_URL.$relative_path;

function conv_utf8($str){
	if(iconv("UTF-8","UTF-8",$str) == $str){
		return $str;
	}else return  iconv("EUC-KR","UTF-8",$str);
}
?>
<html>
<head>
	<title>NICE신용평가정보 가상주민번호 서비스</title>
	<script language="javascript" src="../../../../js/jquery.min.js"></script>
	<script language="JavaScript">
		var realName = '<?php echo $_SESSION["realName"];?>';
		 
		function fncOpenerSubmit() {
			switch(realName){
				case "memregis":
					memRegis();
				break;
				case "findIdPwd":
					findidpwd();
				break;
			}
		}

		function memRegis(){
			opener.document.OutForm.auth_name.value = document.dForm.name.value;
			opener.document.OutForm.auth_gender.value = document.dForm.gender.value;
			opener.document.OutForm.auth_birthdate.value = document.dForm.birthdate.value;
			opener.document.OutForm.auth_ci.value = document.dForm.conninfo.value;
			opener.document.OutForm.auth_di.value = document.dForm.dupinfo.value;
			opener.document.OutForm.action = "./wizmember.php?query=regis_step2";
			opener.document.OutForm.submit();
			self.close();
		}

		function findidpwd(){
			var params = {result_di : "<?=$field[0] ?>", result_ci:"<?=$field[1] ?>", result_name:"<?=$field[6] ?>", result_age:"<?=$field[8] ?>", result_gender:"<?=$field[9] ?>", result_birthdate:"<?=$field[11]?>"}
			if(document.dForm.dupinfo.value != "" && document.dForm.coinfo1.value !=""){
				opener.parentCheckResultFunction(true, params);
			}else{
				opener.parentCheckResultFunction(false, params);
			}
			self.close();
		}
	</script>
<style type="text/css"> 
BODY
{
    COLOR: #7f7f7f;
    FONT-FAMILY: "Dotum","DotumChe","Arial";
    BACKGROUND-COLOR: #ffffff;
}
</style>
</head>

<body onLoad="javascript:fncOpenerSubmit();">

<?php

//보안을 위해 제공해드리는 샘플페이지는 서비스 적용 후 서버에서 삭제해 주시기 바랍니다. 

	/********************************************************************************************************************************************
		NICE신용평가정보 Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED
		
		서비스명 : 가상주민번호서비스 (IPIN) 서비스
		페이지명 : 가상주민번호서비스 (IPIN) 사용자 인증 정보 결과 페이지
		
				   수신받은 데이터(인증결과)를 복호화하여 사용자 정보를 확인합니다.
	*********************************************************************************************************************************************/
	
	$sSiteCode					= $cfg["mem"]["realnameIpinID"];			// IPIN 서비스 사이트 코드		(NICE신용평가정보에서 발급한 사이트코드)
	$sSitePw					= $cfg["mem"]["realnameIpinPWD"];			// IPIN 서비스 사이트 패스워드	(NICE신용평가정보에서 발급한 사이트패스워드)
	
	$sEncData					= "";			// 암호화 된 사용자 인증 정보
	$sDecData					= "";			// 복호화 된 사용자 인증 정보
	
	$sRtnMsg					= "";			// 처리결과 메세지
	$sModulePath				= $server_path."IPINClient";			// 하단내용 참조
	
  $sEncData = $_POST['enc_data'];	// ipin_process.php 에서 리턴받은 암호화 된 사용자 인증 정보
  
		//////////////////////////////////////////////// 문자열 점검///////////////////////////////////////////////
    if(preg_match('~[^0-9a-zA-Z+/=]~', $sEncData, $match)) {echo "입력 값 확인이 필요합니다"; exit;}
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////  
	
	// ipin_main.php 에서 저장한 세션 정보를 추출합니다.
	// 데이타 위변조 방지를 위해 확인하기 위함이므로, 필수사항은 아니며 보안을 위한 권고사항입니다.
	$sCPRequest = $_SESSION['CPREQUEST'];
    
    if ($sEncData != "") {
    
    	// 사용자 정보를 복호화 합니다.
    	// 실행방법은 싱글쿼터(`) 외에도, 'exec(), system(), shell_exec()' 등등 귀사 정책에 맞게 처리하시기 바랍니다.
    	$sDecData = `$sModulePath RES $sSiteCode $sSitePw $sEncData`;
    	
    	if ($sDecData == -9) {
    		$sRtnMsg = "입력값 오류 : 복호화 처리시, 필요한 파라미터값의 정보를 정확하게 입력해 주시기 바랍니다.";
    	} else if ($sDecData == -12) {
    		$sRtnMsg = "NICE신용평가정보에서 발급한 개발정보가 정확한지 확인해 보세요.";
    	} else {
    	
    		// 복호화된 데이타 구분자는 ^ 이며, 구분자로 데이타를 파싱합니다.
    		/*
    			- 복호화된 데이타 구성
    			가상주민번호확인처리결과코드^가상주민번호^성명^중복확인값(DupInfo)^연령정보^성별정보^생년월일(YYYYMMDD)^내외국인정보^고객사 요청 Sequence
    		*/
    		$arrData = explode("^", $sDecData);
    		$iCount = count($arrData);
    		
//echo "arrData";
//print_r($arrData);
    		if ($iCount >= 5) {
    		
    			/*
					다음과 같이 사용자 정보를 추출할 수 있습니다.
					사용자에게 보여주는 정보는, '이름' 데이타만 노출 가능합니다.
				
					사용자 정보를 다른 페이지에서 이용하실 경우에는
					보안을 위하여 암호화 데이타($sEncData)를 통신하여 복호화 후 이용하실것을 권장합니다. (현재 페이지와 같은 처리방식)
					
					만약, 복호화된 정보를 통신해야 하는 경우엔 데이타가 유출되지 않도록 주의해 주세요. (세션처리 권장)
					form 태그의 hidden 처리는 데이타 유출 위험이 높으므로 권장하지 않습니다.
				*/
				
				$strResultCode	= $arrData[0];			// 결과코드
				if ($strResultCode == 1) {
					$strCPRequest	= $arrData[8];			// CP 요청번호
					
					if ($sCPRequest == $strCPRequest) {
				
						$sRtnMsg = "사용자 인증 성공";
						
						$strVno      		= $arrData[1];	// 가상주민번호 (13자리이며, 숫자 또는 문자 포함)
						$strUserName		= $arrData[2];	// 이름
						$strDupInfo			= $arrData[3];	// 중복가입 확인값 (64Byte 고유값)
						$strAgeInfo			= $arrData[4];	// 연령대 코드 (개발 가이드 참조)
					    $strGender			= $arrData[5];	// 성별 코드 (개발 가이드 참조)
					    $strBirthDate		= $arrData[6];	// 생년월일 (YYYYMMDD)
					    $strNationalInfo	= $arrData[7];	// 내/외국인 정보 (개발 가이드 참조)
					
					} else {
						$sRtnMsg = "CP 요청번호 불일치 : 세션에 넣은 $sCPRequest 데이타를 확인해 주시기 바랍니다.";
					}
				} else {
					$sRtnMsg = "리턴값 확인 후, NICE신용평가정보 개발 담당자에게 문의해 주세요. [$strResultCode]";
				}
    		
    		} else {
    			$sRtnMsg = "리턴값 확인 후, NICE신용평가정보 개발 담당자에게 문의해 주세요.";
    		}
    	
    	}
    } else {
    	$sRtnMsg = "처리할 암호화 데이타가 없습니다.";
    }
    
    /*
	┌ sModulePath 변수에 대한 설명  ─────────────────────────────────────────────────────
		모듈 경로설정은, '/절대경로/모듈명' 으로 정의해 주셔야 합니다.
		
		+ FTP 로 모듈 업로드시 전송형태를 'binary' 로 지정해 주시고, 권한은 755 로 설정해 주세요.
		
		+ 절대경로 확인방법
		  1. Telnet 또는 SSH 접속 후, cd 명령어를 이용하여 모듈이 존재하는 곳까지 이동합니다.
		  2. pwd 명령어을 이용하면 절대경로를 확인하실 수 있습니다.
		  3. 확인된 절대경로에 '/모듈명'을 추가로 정의해 주세요.
	└────────────────────────────────────────────────────────────────────
	*/
	
?>


<form name="dForm" method="post">
  <input type="hidden" name="name" 		value="<?=conv_utf8($strUserName)?>" /><!-- 성명 -->
  <input type="hidden" name="birthdate"  	value="<?=$strBirthDate?>" /><!-- birthdate yyyymmdd -->
  <input type="hidden" name="gender"        value="<?=$strGender?>" /><!-- 성별 man: 1, woman : 2--> 
  <input type="hidden" name="nationalinfo" 		value="<?=$strNationalInfo?>" /><!--내/외국인정보 내국인 : 0  -->
  <input type="hidden" name="dupinfo"	 value="<?=$strDupInfo?>" /><!-- DI -->
  <input type="hidden" name="conninfo" 			value="<?=$conninfo?>" /><!-- CI -->
</form>
<!--
	처리결과 : <?= $sRtnMsg ?><br>
	이름 : <?= $strUserName ?><br>
-->
	<form name="user" method="post">
		<input type="hidden" name="enc_data" value="<?= $sEncData ?>"><br>
	</form>
</body>
</html>