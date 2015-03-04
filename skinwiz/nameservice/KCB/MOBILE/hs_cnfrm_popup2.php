<?php
    /**************************************************************************
	 * 파일명 : hs_cnfrm_popup2.php
	 *
	 * 본인확인서비스 개인 정보 입력 화면
	 *    (고객 인증정보 KCB팝업창에서 입력용)
     *
     * ※주의
     * 	실제 운영시에는 
     * 	response.write를 사용하여 화면에 보여지는 데이터를 
     * 	삭제하여 주시기 바랍니다. 방문자에게 사이트데이터가 노출될 수 있습니다.
     **************************************************************************/

	// 서비스거래번호를 생성한다.
	function generateSvcTxSeqno() {   
		$numbers  = "0123456789";   
		$svcTxSeqno = date("YmdHis");   
		$nmr_loops = 6;   
		while ($nmr_loops--) {   
			$svcTxSeqno .= $numbers[mt_rand(0, strlen($numbers))];   
		}   
		return $svcTxSeqno;   
	}   

	/**************************************************************************
	 * okname 본인확인서비스 파라미터
	 **************************************************************************/
	$inTpBit = $_POST["in_tp_bit"];	// 입력구분코드(0:없음, 1:기본정보, 2:내외국인, 4:휴대폰정보)
	$name = "x";										// 성명
	$birthday = "x";									// 생년월일 
	$gender = "x";										// 성별
	$nation="x";										// 내외국인구분 
	$telComCd="x";										// 이동통신사코드 
	$telNo="x";											// 휴대폰번호 

	$inTpBitVal = intval($inTpBit, 0);
	if (($inTpBitVal & 1) == 1) {
		$name = $_POST["name"];							// 성명
	}
	
	if (($inTpBitVal & 2) == 2) {
		$birthday = $_POST["birthday"];					// 생년월일
	}
	
	if (($inTpBitVal & 4) == 4) {
		$gender = $_POST["gender"];						// 성별
		$nation = $_POST["nation"];			// 내외국인구분
	}
	
	if (($inTpBitVal & 8) == 8) {
		$telComCd = $_POST["tel_com_cd"];			// 통신사코드
		$telNo = $_POST["tel_no"];					// 휴대폰번호
	}

	$svcTxSeqno = generateSvcTxSeqno();					// 거래번호. 동일문자열을 두번 사용할 수 없음. (최대 30자리의 문자열. 0-9,A-Z,a-z 사용)
	
	// ########################################################################
	// # 운영전환시 확인 필요
	// ########################################################################
	$memId = "P00000000000";							// 회원사코드

	$clientIp = "x";									// 모듈설치 서버에 설정된 IP
	$clientDomain = "ok-name.co.kr";					// 회원사 도메인. (휴대폰인증번호 발송시 제휴사명에 노출)
	
	$rsv1 = "0";										// 예약 항목
	$rsv2 = "0";										// 예약 항목
	$rsv3 = "0";										// 예약 항목
	
	$hsCertMsrCd = "10";								// 인증수단코드 2byte  (10:핸드폰)
	$hsCertRqstCausCd = "00";							// 인증요청사유코드 2byte  (00:회원가입, 01:성인인증, 02:회원정보수정, 03:비밀번호찾기, 04:상품구매, 99:기타)
	
	$returnMsg = "x";									// 리턴메시지 (고정값 'x') 
	
	// ########################################################################
	// # 리턴 URL 설정
	// ########################################################################
	// opener(hs_cnfrm_popup1.php)의 도메일과 일치하도록 설정해야 함. 
	// (http://www.test.co.kr과 http://test.co.kr는 다른 도메인으로 인식하며, http 및 https도 일치해야 함)
	$returnUrl = "http://localhost:8008/test/hs_cnfrm_popup3.php";// 본인인증 완료후 리턴될 URL (도메인 포함 full path)
	
	// ########################################################################
	// # 운영전환시 변경 필요
	// ########################################################################
	$endPointURL = "http://tsafe.ok-name.co.kr:29080/KcbWebService/OkNameService";	// 테스트 서버
	//$endPointURL = "http://safe.ok-name.co.kr/KcbWebService/OkNameService"; // 운영 서버 
	
    //okname 실행 정보
	// ########################################################################
	// # 모듈 경로 지정 및 권한 부여 (절대경로)
	// ########################################################################
	$exe = "c:\\okname\\win32\\okname.exe";				// okname 실행 정보

	// ########################################################################
	// # 로그 경로 지정 및 권한 부여 (절대경로)
	// ########################################################################
	$logPath = "c:\\okname\\";

	// ########################################################################
	// # 옵션값에 'L'을 추가하는 경우에만 로그(logPath변수에 설정된)가 생성됨.
	// ########################################################################
	$options = "QL";		// Q:인증요청데이터 암호화
	
	$cmd = "$exe $svcTxSeqno \"$name\" $birthday $gender $nation $telComCd $telNo $rsv1 $rsv2 $rsv3 \"$returnMsg\" $returnUrl $inTpBit $hsCertMsrCd $hsCertRqstCausCd $memId $clientIp $clientDomain $endPointURL $logPath $options";
	
//	echo $cmd."<br>";
	
	/**************************************************************************
	okname 실행
	**************************************************************************/
	
	//cmd 실행
	exec($cmd, $out, $ret);
//	echo "ret=".$ret."<br>";
	
	/**************************************************************************
	okname 응답 정보
	**************************************************************************/
	$retcode = "";										// 결과코드
	$retmsg = "";										// 결과메시지
	$e_rqstData = "";									// 암호화된요청데이터
	
	if ($ret == 0) {//성공일 경우 변수를 결과에서 얻음
		$retcode = $out[0];
		$retmsg  = $out[1];
		$e_rqstData = $out[2];
	}
	else {
		if($ret <=200)
			$retcode=sprintf("B%03d", $ret);
		else
			$retcode=sprintf("S%03d", $ret);
	}
	
	/**************************************************************************
	 * hs_cnfrm_popup3.php 실행 정보
	 **************************************************************************/
	$targetId = "";		// 타겟ID (결과를 전달할 팝업이 따로 있을 경우 해당 팝업명(window.name 설정값)을 설정. 일반적으로 ""으로 설정)

	// ########################################################################
	// # 운영전환시 변경 필요
	// ########################################################################
    $commonSvlUrl = "https://tsafe.ok-name.co.kr:2443/CommonSvl";	// 테스트 URL
    //$commonSvlUrl = "https://safe.ok-name.co.kr/CommonSvl";	// 운영 URL
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html" charset="euc-kr">
	<title>KCB 본인확인서비스 샘플</title>
	<script>
		function request(){
		window.name = "<?=$targetId?>";

		document.form1.action = "<?=$commonSvlUrl?>";
		document.form1.method = "post";

		document.form1.submit();
	}
	</script>
</head>

 <body>
	<form name="form1">
	<!-- 인증 요청 정보 -->
	<!--// 필수 항목 -->
	<input type="hidden" name="tc" value="kcb.oknm.online.safehscert.popup.cmd.P901_CertChoiceCmd">				<!-- 변경불가-->
	<input type="hidden" name="rqst_data"				value="<?=$e_rqstData?>">		<!-- 요청데이터 -->
	<input type="hidden" name="target_id"				value="<?=$targetId?>">				<!-- 타겟ID --> 
	<!-- 필수 항목 //-->	
	</form>
<?php
 	if ($retcode == "B000") {
		//인증요청
		echo ("<script>request();</script>");
	} else {
		//요청 실패 페이지로 리턴
		echo ("<script>alert(\"$retcode\"); self.close();</script>");
	}
?>
 </body>
</html>
