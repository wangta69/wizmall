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

    //**************************************************************************************************************
    //NICE신용평가정보 Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED
    
    //서비스명 :  체크플러스 - 안심본인인증 서비스
    //페이지명 :  체크플러스 - 결과 페이지
    
    //보안을 위해 제공해드리는 샘플페이지는 서비스 적용 후 서버에서 삭제해 주시기 바랍니다. 
    //**************************************************************************************************************
    
	//session_start();
	
    $sitecode = $cfg["mem"]["realnameID"];					// NICE로부터 부여받은 사이트 코드
    $sitepasswd = $cfg["mem"]["realnamePWD"];				// NICE로부터 부여받은 사이트 패스워드
    
    $cb_encode_path = $server_path."CPClient";		// NICE로부터 받은 암호화 프로그램의 위치 (절대경로+모듈명)
		
    $enc_data = $_POST["EncodeData"];		// 암호화된 결과 데이타
    $sReserved1 = $_POST['param_r1'];		
		$sReserved2 = $_POST['param_r2'];
		$sReserved3 = $_POST['param_r3'];

		//////////////////////////////////////////////// 문자열 점검///////////////////////////////////////////////
	if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match)) {echo "입력 값 확인이 필요합니다"; exit;}
	if(base64_encode(base64_decode($enc_data))!= $enc_data) {echo " 입력 값 확인이 필요합니다"; exit;}
    if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReserved1, $match)) {echo "문자열 점검 : ".$match[0]; exit;}
    if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReserved2, $match)) {echo "문자열 점검 : ".$match[0]; exit;}
    if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReserved3, $match)) {echo "문자열 점검 : ".$match[0]; exit;}
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		
    if ($enc_data != "") {

        $plaindata = `$cb_encode_path DEC $sitecode $sitepasswd $enc_data`;		// 암호화된 결과 데이터의 복호화
       // echo "[plaindata]  " . $plaindata . "<br>";

        if ($plaindata == -1){
            $returnMsg  = "암/복호화 시스템 오류";
        }else if ($plaindata == -4){
            $returnMsg  = "복호화 처리 오류";
        }else if ($plaindata == -5){
            $returnMsg  = "HASH값 불일치 - 복호화 데이터는 리턴됨";
        }else if ($plaindata == -6){
            $returnMsg  = "복호화 데이터 오류";
        }else if ($plaindata == -9){
            $returnMsg  = "입력값 오류";
        }else if ($plaindata == -12){
            $returnMsg  = "사이트 비밀번호 오류";
        }else{
            // 복호화가 정상적일 경우 데이터를 파싱합니다.
            $ciphertime = `$cb_encode_path CTS $sitecode $sitepasswd $enc_data`;	// 암호화된 결과 데이터 검증 (복호화한 시간획득)
       // print_r($plaindata);
            $requestnumber = GetValue($plaindata , "REQ_SEQ");
            $responsenumber = GetValue($plaindata , "RES_SEQ");
            $authtype = GetValue($plaindata , "AUTH_TYPE");
            $name = GetValue($plaindata , "NAME");
            $birthdate = GetValue($plaindata , "BIRTHDATE");
            $gender = GetValue($plaindata , "GENDER");
            $nationalinfo = GetValue($plaindata , "NATIONALINFO");	//내/외국인정보(사용자 매뉴얼 참조)
            $dupinfo = GetValue($plaindata , "DI");
            $conninfo = GetValue($plaindata , "CI");
			// 휴대폰 번호 : MOBILE_NO => GetValue($plaindata , "MOBILE_NO");
			// 이통사 정보 : MOBILE_CO => GetValue($plaindata , "MOBILE_CO");
			// checkplus_success 페이지에서 결과값 null 일 경우, 관련 문의는 관리담당자에게 하시기 바랍니다.
            if(strcmp($_SESSION["REQ_SEQ"], $requestnumber) != 0)
            {
            	echo "세션값이 다릅니다. 올바른 경로로 접근하시기 바랍니다.<br>";
                $requestnumber = "";
                $responsenumber = "";
                $authtype = "";
                $name = "";
            		$birthdate = "";
            		$gender = "";
            		$nationalinfo = "";
            		$dupinfo = "";
            		$conninfo = "";
            }
        }
    }
?>

<?
    function GetValue($str , $name)
    {
        $pos1 = 0;  //length의 시작 위치
        $pos2 = 0;  //:의 위치

        while( $pos1 <= strlen($str) )
        {
            $pos2 = strpos( $str , ":" , $pos1);
            $len = substr($str , $pos1 , $pos2 - $pos1);
            $key = substr($str , $pos2 + 1 , $len);
            $pos1 = $pos2 + $len + 1;
            if( $key == $name )
            {
                $pos2 = strpos( $str , ":" , $pos1);
                $len = substr($str , $pos1 , $pos2 - $pos1);
                $value = substr($str , $pos2 + 1 , $len);
                return $value;
            }
            else
            {
                // 다르면 스킵한다.
                $pos2 = strpos( $str , ":" , $pos1);
                $len = substr($str , $pos1 , $pos2 - $pos1);
                $pos1 = $pos2 + $len + 1;
            }            
        }
    }


	//print_r($_SESSION);
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg["common"]["lan"];?>" />
    <title>NICE신용평가정보 - CheckPlus 본인인증 </title>
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

</head>
<body onLoad="javascript:fncOpenerSubmit();">

<form name="dForm" method="post">
  <input type="hidden" name="ciphertime" 	value ="<?=$ciphertime ?>" /><!--복호화한 시간 -->
  <input type="hidden" name="requestnumber" 		value="<?=$requestnumber?>" /><!-- 요청 번호 -->
  <input type="hidden" name="responsenumber" 		value="<?=$responsenumber?>" /><!-- 나신평응답 번호 -->
  <input type="hidden" name="authtype" 		value="<?=$authtype?>" /><!-- 인증수단 -->
  <input type="hidden" name="name" 		value="<?=conv_utf8($name)?>" /><!-- 성명 -->
  <input type="hidden" name="birthdate"  	value="<?=$birthdate?>" /><!-- birthdate yyyymmdd -->
  <input type="hidden" name="gender"        value="<?=$gender?>" /><!-- 성별 man: 1, woman : 2--> 
  <input type="hidden" name="nationalinfo" 		value="<?=$nationalinfo?>" /><!--내/외국인정보 내국인 : 0  -->
  <input type="hidden" name="dupinfo"	 value="<?=$dupinfo?>" /><!-- DI -->
  <input type="hidden" name="conninfo" 			value="<?=$conninfo?>" /><!-- CI -->
</form>
<!--

    <center>
    <p><p><p><p>
    본인인증이 완료 되었습니다.<br>
    <table border=1>
        <tr>
            <td>복호화한 시간</td>
            <td><?= $ciphertime ?> (YYMMDDHHMMSS)</td>
        </tr>
        <tr>
            <td>요청 번호</td>
            <td><?= $requestnumber ?></td>
        </tr>            
        <tr>
            <td>나신평응답 번호</td>
            <td><?= $responsenumber ?></td>
        </tr>            
        <tr>
            <td>인증수단</td>
            <td><?= $authtype ?></td>
        </tr>
                <tr>
            <td>성명</td>
            <td><?= $name ?></td>
        </tr>
                <tr>
            <td>생년월일</td>
            <td><?= $birthdate ?></td>
        </tr>
                <tr>
            <td>성별</td>
            <td><?= $gender ?></td>
        </tr>
                <tr>
            <td>내/외국인정보</td>
            <td><?= $nationalinfo ?></td>
        </tr>
                <tr>
            <td>DI(64 byte)</td>
            <td><?= $dupinfo ?></td>
        </tr>
                <tr>
            <td>CI(88 byte)</td>
            <td><?= $conninfo ?></td>
        </tr>
        <tr>
          <td>RESERVED1</td>
          <td><?= $sReserved1 ?></td>
	      </tr>
	      <tr>
	          <td>RESERVED2</td>
	          <td><?= $sReserved2 ?></td>
	      </tr>
	      <tr>
	          <td>RESERVED3</td>
	          <td><?= $sReserved3 ?></td>
	      </tr>
    </table>
    </center>
	-->
</body>
</html>
