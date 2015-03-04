<?php
	include "../../../../config/cfg.core.php";
	//KCB 테스트용 회원사 코드 : P00000000000
	$relative_path = eregi_replace("\/[^/]*\.php$", "/", $_SERVER['PHP_SELF']); 
	// 웹 문서의 뿌리 경로를 뺀 상대 경로
		
	$base_URL = ($_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
	$base_URL .= ($_SERVER['SERVER_PORT'] != '80') ? $_SERVER['HTTP_HOST'].':'.$_SERVER['SERVER_PORT'] : $_SERVER['HTTP_HOST'];
	// 바탕 URL
	
	$web_path = $base_URL.$relative_path;




	// KCB 테스트서버를 호출할 경우
	//$idpUrl    = "https://tipin.ok-name.co.kr:8443/tis/ti/POTI90B_SendCertInfo.jsp";
	// KCB 운영서버를 호출할 경우
	$idpUrl    = "https://ipin.ok-name.co.kr/tis/ti/POTI90B_SendCertInfo.jsp";

	// 아이핀 인증을 마치고 돌아올 페이지 주소. opener(ipin1.php)의 도메일과 일치하도록 설정해야 함.
	// (http://www.test.co.kr과 http://test.co.kr는 다른 도메인으로 인식하며, http 및 https도 일치해야 함)
	$returnUrl = $web_path."ipin3.php";		// 아이핀 인증을 마치고 돌아올 페이지 주소

	$idpCode   = "V";					// 고정값. KCB기관코드
	$cpCode    = $cfg["mem"]["realnameIpinID"];		// 회원사코드 (테스트인 경우 'P00000000000'를 사용하며 운영시 발급받은 회원사코드를 설정)


	// 모듈 경로 지정 및 권한 부여 (절대경로)
	$exe = "./okname";
	// 암호화키 파일 설정 (절대경로) - 파일은 주어진 파일명으로 자동 생성되며 매월마다 갱신됨. 웹서버에 해당파일을 생성할 권한 필요.
	$keyPath = "../../../../config/okname.key";
	$memId = $cpCode;			// 회원사코드
	$reserved1 = "0";			//reserved1
	$reserved2 = "0";			//reserved2
	$endPointURL = "http://twww.ok-name.co.kr:8888/KcbWebService/OkNameService";// 테스트 서버
	//$endPointURL = "http://www.ok-name.co.kr/KcbWebService/OkNameService";// 운영 서버
	// 로그 경로 지정 및 권한 부여 (절대경로)
	// options값에 'L'을 추가하는 경우에만 로그가 생성됨.
	$logPath = "../../../../config/log";					// 로그파일을 남기는 경우 로그파일이 생성될 경로
	$options = "CLU";// Option

	// 명령어
	$cmd = "$exe $keyPath $memId \"{$reserved1}\" \"{$reserved2}\" $endPointURL $logPath $options";

	// 파라미터 정의 (K모드)
	//echo "$cmd<br>";
	
	// 실행
	exec($cmd, $out, $ret);

	//echo "ret=".$ret."<br/>";

	$retcode = "";										// 결과코드
	$pubkey = "";
	$sig = "";
	$curtime = "";

	if ($ret == 0) {//성공일 경우 변수를 결과에서 얻음
		$retcode=sprintf("B%03d", $ret);
		$pubkey=$out[0];
		$sig=$out[1];
		$curtime=$out[2];
	}
	else {
		if($ret <=200)
			$retcode=sprintf("B%03d", $ret);
		else
			$retcode=sprintf("S%03d", $ret);
	}

/*
echo "$pubkey<br/>";
echo "$sig<br/>";
echo "$curtime<br/>";
*/
//echo $returnUrl;
//exit;
?>
<!DOCTYPE html>
<html lang="kr">
<head>
<meta charset="utf-8">
	<script language="JavaScript">
	//<!--
	function certKCBIpin(){
		document.kcbInForm.target = "_self";

		//KCB 테스트서버를 호출할 경우
		//document.kcbInForm.action = "https://tipin.ok-name.co.kr:8443/tis/ti/POTI01A_LoginRP.jsp";

		//KCB 운영서버를 호출할 경우
		document.kcbInForm.action = "https://ipin.ok-name.co.kr/tis/ti/POTI01A_LoginRP.jsp";

		//인증요청
		document.kcbInForm.submit();
		return	;
	}
	//-->
	</script>
  </head>
<body onload="javascript:certKCBIpin();">
	<form name="kcbInForm" method="post" >
		<input type="hidden" name="IDPCODE" value="<?=$idpCode?>" />
		<input type="hidden" name="IDPURL" value="<?=$idpUrl?>" />
		<input type="hidden" name="CPCODE" value="<?=$cpCode?>" />
		<input type="hidden" name="CPREQUESTNUM" value="<?=$curtime?>" />
		<input type="hidden" name="RETURNURL" value="<?=$returnUrl?>" />
		<input type="hidden" name="WEBPUBKEY" value="<?=$pubkey?>" />
		<input type="hidden" name="WEBSIGNATURE" value="<?=$sig?>" />
	</form>
</body>
</html>