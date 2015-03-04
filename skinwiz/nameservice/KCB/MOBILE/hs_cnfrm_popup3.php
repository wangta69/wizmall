<?php
/**************************************************************************
	파일명 : hs_cnfrm_popup3.php
	
	본인확인서비스 결과 화면(return url)
**************************************************************************/
	
	/* 공통 리턴 항목 */
	$idcfMbrComCd			=	$_POST["idcf_mbr_com_cd"];		// 고객사코드
	$hsCertSvcTxSeqno		=	$_POST["hs_cert_svc_tx_seqno"];	// 거래번호
	$rqstSiteNm				=	$_POST["rqst_site_nm"];			// 접속도메인	
	$hsCertRqstCausCd		=	$_POST["hs_cert_rqst_caus_cd"];	// 인증요청사유코드 2byte  (00:회원가입, 01:성인인증, 02:회원정보수정, 03:비밀번호찾기, 04:상품구매, 99:기타)

	$resultCd				=	$_POST["result_cd"];			// 결과코드
	$resultMsg				=	$_POST["result_msg"];			// 결과메세지
	$certDtTm				=	$_POST["cert_dt_tm"];			// 인증일시

	/**************************************************************************
	 * 모듈 호출	; 본인확인서비스 결과 데이터를 복호화한다.
	 **************************************************************************/
	$encInfo = $_POST["encInfo"];

	//KCB서버 공개키
	$WEBPUBKEY = trim($_POST["WEBPUBKEY"]);
	//KCB서버 서명값
	$WEBSIGNATURE = trim($_POST["WEBSIGNATURE"]);

	// ########################################################################
	// # 운영전환시 변경 필요
	// ########################################################################
	$endPointUrl = "http://tsafe.ok-name.co.kr:29080/KcbWebService/OkNameService";//EndPointURL, 테스트 서버
	//$endPointUrl = "http://safe.ok-name.co.kr/KcbWebService/OkNameService";// 운영 서버
		  
	//okname 실행 정보
	// ########################################################################
	// # 모듈 경로 지정 및 권한 부여 (hs_cnfrm_popup2.php에서 설정된 값과 동일하게 설정)
	// ########################################################################
	$exe = "C:\\okname\\win32\\okname.exe";

	// ########################################################################
	// # 암호화키 파일 설정 (절대경로) - 파일은 주어진 파일명으로 자동 생성되며, 매월마다 갱신됨 
	// # 만일 키파일이 갱신되지 않으면 복화화데이터가 깨지는 현상이 발생됨.
	// ########################################################################
	$keyPath = "C:\\okname\\safecert_$idcfMbrComCd.key";

	// ########################################################################
	// # 로그 경로 지정 및 권한 부여 (hs_cnfrm_popup2.asp에서 설정된 값과 동일하게 설정)
	// ########################################################################
	$logPath = "C:\\okname\\";

	// ########################################################################
	// # 옵션값에 'L'을 추가하는 경우에만 로그가 생성됨.
	// ########################################################################
	$options = "SL";	// S:인증결과복호화
		
	// 명령어
	$cmd = "$exe $keyPath $idcfMbrComCd $endPointUrl $WEBPUBKEY $WEBSIGNATURE $encInfo $logPath $options";
	echo "$cmd<br>";
	
	// 실행
	exec($cmd, $out, $ret);
    echo "ret=$ret<br/>";
    
	if($ret == 0) {
		echo "복호화 요청 호출 성공.<br/>";		 
		// 결과라인에서 값을 추출
		foreach($out as $a => $b) {
			if($a < 17) {
				$field[$a] = $b;
			}
		}
	}
	else {
		echo "복호화 요청 호출 에러. 리턴값 : ".$ret."<br/>";		 
	}

    echo "복호화처리결과코드:$ret	<br/>";		 
    echo "처리결과코드		:$field[0]	<br/>";		 
    echo "처리결과메시지	:$field[1]	<br/>";		 
    echo "거래일련번호		:$field[2]	<br/>";		 
    echo "인증일시			:$field[3]	<br/>";		 
    echo "DI				:$field[4]	<br/>";		 
    echo "CI				:$field[5]	<br/>";		 
    echo "성명				:$field[7]	<br/>";		 
    echo "생년월일			:$field[8]	<br/>";		 
    echo "성별				:$field[9]	<br/>";		 
    echo "내외국인구분		:$field[10]	<br/>";	 
    echo "통신사코드		:$field[11]	<br/>";	 
    echo "휴대폰번호		:$field[12]	<br/>";	 
    echo "리턴메시지		:$field[16]	<br/>";	 
    
//*/
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html" charset="euc-kr">
	<title>KCB 본인확인서비스 샘플</title>
    <script language="javascript" type="text/javascript" >
	function fncOpenerSubmit() {
		opener.document.kcbResultForm.idcf_mbr_com_cd.value = "<?=$idcfMbrComCd?>";
		opener.document.kcbResultForm.hs_cert_rqst_caus_cd.value = "<?=$hsCertRqstCausCd?>";
		opener.document.kcbResultForm.result_cd.value = "<?=$field[0]?>";
		opener.document.kcbResultForm.result_msg.value = "<?=$field[1]?>";
		opener.document.kcbResultForm.hs_cert_svc_tx_seqno.value = "<?=$field[2]?>";
		opener.document.kcbResultForm.cert_dt_tm.value = "<?=$field[3]?>";
		opener.document.kcbResultForm.di.value = "<?=$field[4]?>";
		opener.document.kcbResultForm.ci.value = "<?=$field[5]?>";
		opener.document.kcbResultForm.name.value = "<?=$field[7]?>";
		opener.document.kcbResultForm.birthday.value = "<?=$field[8]?>";
		opener.document.kcbResultForm.gender.value = "<?=$field[9]?>";
		opener.document.kcbResultForm.nation.value = "<?=$field[10]?>";
		opener.document.kcbResultForm.tel_com_cd.value = "<?=$field[11]?>";
		opener.document.kcbResultForm.tel_no.value = "<?=$field[12]?>";
		opener.document.kcbResultForm.return_msg.value = "<?=$field[16]?>";
		opener.document.kcbResultForm.action = "hs_cnfrm_popup4.php";

		opener.document.kcbResultForm.submit();
		self.close();
	}	
	</script>
</head>
<body>
	<b>본인확인결과</b>
 	결과코드		: <?=$resultCd?><br />
 	결과메세지		: <?=$resultMsg?><br />
	거래번호		: <?=$hsCertSvcTxSeqno?><br />
 	인증일시		: <?=$certDtTm?><br />
	고객사코드		: <?=$idcfMbrComCd?><br />
	접속도메인		: <?=$rqstSiteNm?><br />
	인증요청사유코드: <?=$hsCertRqstCausCd?><br />
</body>
<?php
	if($ret == 0) {
		//인증결과 복호화 성공
		echo ("<script>fncOpenerSubmit();</script>");
	} else {
		//인증결과 복호화 실패
		echo ("<script>alert(\"인증결과복호화 실패 : $ret.\"); self.close(); </script>");
	}
?>
</html>
