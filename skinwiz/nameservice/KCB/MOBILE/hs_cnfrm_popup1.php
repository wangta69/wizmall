<?php
//**************************************************************************
// 파일명 : hs_cnfrm_popup1.php
//
// 본인확인서비스 요청 정보 입력 화면
//
//**************************************************************************
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="euc-kr">
<title>KCB 본인확인서비스 샘플</title>
<script>
<!--
	function jsSubmit(){	
		var form1 = document.form1;
		var isChecked = false;
		var inTpBit = "";

		for(i=0; i<form1.in_tp_bit.length; i++){
			if(form1.in_tp_bit[i].checked){
				inTpBit = form1.in_tp_bit[i].value;
				isChecked = true;
				break;
			}
		}
		
		if(!(isChecked)){
			alert("입력유형을 선택해주세요");
			return;
		}

		if (inTpBit & 1) {
			if (form1.name.value == "") {
				alert("성명을 입력해주세요");
				return;
			}
		}
		if (inTpBit & 2) {
			if (form1.birthday.value == "") {
				alert("생년월일을 입력해주세요");
				return;
			}
		}
		if (inTpBit & 8) {
			if (form1.tel_com_cd.value == "") {
				alert("통신사코드를 입력해주세요");
				return;
			}
			if (form1.tel_no.value == "") {
				alert("휴대폰번호를 입력해주세요");
				return;
			}
		}

		window.open("", "auth_popup", "width=430,height=590,scrollbar=yes");

		var form1 = document.form1;
		form1.target = "auth_popup";
		form1.submit();
	}
//-->
</script>
</head>
 <body>
	<form name="form1" action="hs_cnfrm_popup2.php" method="post">
		<table>
			<tr>
				<td colspan="2"><strong> - KCB 인증정보 입력용</strong></td>
			</tr>
			<tr>
				<td>입력유형</td>
				<td>
					<?php
					// 입력유형은 다음의 조합을 따릅니다.
					//  1 : 0001 - 성명
					//  2 : 0010 - 생년월일
					//  3 : 0011 - 생년월일 + 성명 
					//  4 : 0100 - 성별,내외국인구분
					//  5 : 0101 - 성별,내외국인구분 + 성명
					//  6 : 0110 - 성별,내외국인구분 + 생년월일
					//  7 : 0111 - 성별,내외국인구분 + 생년월일 + 성명
					//  8 : 1000 - 통신사,휴대폰번호
					//  9 : 1001 - 통신사,휴대폰번호 + 성명
					// 10 : 1010 - 통신사,휴대폰번호 + 생년월일
					// 11 : 1011 - 통신사,휴대폰번호 + 생년월일 + 성명
					// 12 : 1100 - 통신사,휴대폰번호 + 성별,내외국인구분
					// 13 : 1101 - 통신사,휴대폰번호 + 성별,내외국인구분 + 성명
					// 14 : 1110 - 통신사,휴대폰번호 + 성별,내외국인구분 + 생년월일
					// 15 : 1111 - 통신사,휴대폰번호 + 성별,내외국인구분 + 생년월일 + 성명
					?>
					<input type="radio" name="in_tp_bit" value="0">없음 (팝업에서 모든 정보를 입력)<br/>
					<input type="radio" name="in_tp_bit" value="7">성명+생년월일+성별,내외국인구분<br/>
					<input type="radio" name="in_tp_bit" value="8">통신사,휴대폰번호<br/>
					<input type="radio" name="in_tp_bit" value="15" checked>성명+생년월일+성별,내외국인구분+통신사,휴대폰번호<br/>
				</td>
			</tr>
			<tr>
				<td>성명</td>
				<td>
					<input type="text" name="name" maxlength="20" size="20" value="">
				</td>
			</tr>
			<tr>
				<td>생년월일</td>
				<td>
					<input type="text" name="birthday" maxlength="8" size="10" value="">
				</td>
			</tr>
			<tr>
				<td>성별</td>
				<td>
					<input type="radio" name="gender" value="1" checked>남
					<input type="radio" name="gender" value="0">여
			</tr>
			<tr>
				<td>내외국인구분</td>
				<td>
					<input type="radio" name="nation" value="1" checked>내국인
					<input type="radio" name="nation" value="2">외국인
			</tr>
			<tr>
				<td>휴대폰</td>
				<td>
					<input type="radio" name="tel_com_cd" value="01" checked>SKT
					<input type="radio" name="tel_com_cd" value="02">KT
					<input type="radio" name="tel_com_cd" value="03">LGU<br/>
					<input type="text" name="tel_no" maxlength="11" size="15" value="">
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="button" value="본인확인서비스" onClick="jsSubmit();"></td>
			</tr>
		</table>
	</form>

	<!-- 본인확인 처리결과 정보 -->
	<form name="kcbResultForm" method="post" >
        <input type="hidden" name="idcf_mbr_com_cd" 		value="" 	/>
        <input type="hidden" name="hs_cert_svc_tx_seqno" 	value=""	/>
        <input type="hidden" name="hs_cert_rqst_caus_cd" 	value="" 	/>
        <input type="hidden" name="result_cd" 				value="" 	/>
        <input type="hidden" name="result_msg" 				value="" 	/>
        <input type="hidden" name="cert_dt_tm" 				value="" 	/>
        <input type="hidden" name="di" 						value="" 	/>
        <input type="hidden" name="ci" 						value="" 	/>
        <input type="hidden" name="name" 					value="" 	/>
        <input type="hidden" name="birthday" 				value="" 	/>
        <input type="hidden" name="gender" 					value="" 	/>
        <input type="hidden" name="nation" 					value="" 	/>
        <input type="hidden" name="tel_com_cd" 				value="" 	/>
        <input type="hidden" name="tel_no" 					value="" 	/>
        <input type="hidden" name="return_msg" 				value="" 	/>
	</form>  
 </body>
</html>
