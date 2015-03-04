<?
/* 
제작자 : 폰돌
URL : http://www.webpiad.co.kr
Email : master@webpiad.co.kr
*** Updating List ***
다양한 리스트 추가  - 2003. 08.15
*/
?>
<script language=javascript src="./js/wizmall.js"></script>
<script language=javascript>
<!--
function MemberCheckField()
{
var f=document.FrmUserInfo;
	if (!f.agree.checked) {
	alert("이용약관에 동의해 주시기 바랍니다.");
	f.agree.focus();
	return false;
	}
	
	if (!TypeCheck(f.ID.value, ALPHA+NUM)) {
	alert("ID는 영문자 및 숫자로만 사용할 수 있습니다. ");
	f.ID.focus();
	return false;
	}
	
	if ((f.ID.value.length < 4) || (f.ID.value.length > 12)) {
	alert("ID는 4자 이상, 12자 이내이어야 합니다.");
	f.ID.focus();
	return false;
	}
	
	if (f.PWD.value.length < 4) {
	alert("비밀번호는 4자 이상이어야 합니다. ");
	f.PWD.focus();
	return false;
	}
	
	if ((f.PWD.value) != (f.CPWD.value)) {
	alert("비밀번호재확인을 정확히 입력해 주세요. ");
	f.CPWD.focus();
	return false;
	}
	
	if ((f.UserName.value.length < 2) || (f.UserName.value.length > 5)) {
	alert("이름을 정확히 적어주십시오.");
	f.UserName.focus();
	return false;
	}
	
	if(!IsJuminChk(f.Jumin1.value, f.Jumin2.value)){
	f.Jumin1.focus();
	return false;
	}
	
	<?if(!strcmp($cfg["mem"]["EBirthDay"],"checked")):?>
	mm = parseInt(f.BirthMM.value, 10);
	dd = parseInt(f.BirthDD.value, 10);
	
	if ((!TypeCheck(f.BirthYY,NUM)) || (!TypeCheck(f.BirthMM,NUM)) || (!TypeCheck(f.BirthDD, NUM)) ) {
	alert("생년월일에 잘못된 문자가 있습니다.");
	f.BirthYY.focus();
	return false;
	}
	
	if ((mm < 1) || (mm > 12)) {
	alert("생년 월일이 잘못되었습니다.");
	f.BirthMM.focus();
	return false;
	}
	
	if ((dd < 1) || (dd > 31)) {
	alert("생년 월일이 잘못되었습니다.");
	f.BirthDD.focus();
	return false;
	}          
	<? endif;?>
	if(!IsEmailChk(f.Email.value)){ //이메일 유효성검사
	f.Email.focus();
	return false;
	}
	
	if  (f.Address1.value.length < 5) {
	alert("주소를 정확히 입력해 주세요.");
	f.Address1.focus();
	return false;
	}  
	if  (f.Address2.value.length < 2) {
	alert("번지수/통/반을 정확히 입력해 주세요.[예:123번지] ");
	f.Address2.focus();
	return false;
	} 
	//if  (!f.OK.checked) {
	//alert(" 가입약관에 동의하셔야 가입하실 수 있습니다. ");
	//f.OK.focus();
	//return false;
	//} 
return true;
}
////////////////////////////////////////////////////////////////////////////////
function CompanyCheckField()
{
var f=document.FrmUserInfo;
// 사업자등록증 책크 시작
	if(!chkWorkNum(f.Compnum1.value, f.Compnum2.value, f.Compnum3.value)){
			f.Compnum1.focus();
			return false;
			}
	return true;
}




function FillBirthDay()
{
var f=document.FrmUserInfo;

	if ( ! TypeCheck(f.Jumin1.value, NUM)) {
	alert("주민등록 번호에 잘못된 문자가 있습니다. ");
	f.Jumin1.focus();
	return false;
	}
	
	num = f.Jumin1.value;
	
	mm = parseInt(num.substring(2,4), 10);
	dd = parseInt(num.substring(4,6), 10);
	
	if ((mm < 1) || (mm > 12)) {
	alert ("주민등록 번호 앞자리가 잘못되었습니다.");
	return false;
	}
	
	if ((dd < 1) || (dd > 31)) {
	alert ("주민등록 번호 앞자리가 잘못되었습니다.");
	return false;
	}
	
	f.BirthYY.value = "19" + num.substring(0,2);
	f.BirthMM.value = num.substring(2,4);
	f.BirthDD.value = num.substring(4,6);
	
	
	f.Jumin2.focus();
}
//-->
</script> 
<script language="JavaScript">
<!--
function OpenZipcode(){
window.open("./util/zipcode/zipcode.php?form=FrmUserInfo&zip1=Zip1_1&zip2=Zip1_2&firstaddress=Address1&secondaddress=Address2","ZipWin","width=490,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no");
}
function OpenZipcode1(){
window.open("./util/zipcode/zipcode.php?form=FrmUserInfo&zip1=Zip2_1&zip2=Zip2_2&firstaddress=Address3&secondaddress=Address4","ZipWin","width=490,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no");
}

function IDcheck()
{
var f=document.FrmUserInfo;
	winobject = window.open("","","scrollbars=no,resizable=yes,width=470,height=150");
	winobject.document.location = "./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/ID_EXISTS.php?id=" + f.ID.value;
	winobject.focus();
}

function Jumincheck()
{
	var f=document.FrmUserInfo;
		if(!IsJuminChk(f.Jumin1.value, f.Jumin2.value)){
		f.Jumin1.focus();
		return false;
		}
	winobject = window.open("","","scrollbars=no,resizable=yes,width=1,height=1");
	winobject.document.location = "./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/Jumin_EXISTS.php?jumin1=" + f.Jumin1.value+"&jumin2=" + f.Jumin2.value;
	winobject.focus();
}
function Reqercheck()
{
var f=document.FrmUserInfo;
if (f.RecID.value == "") {
alert("추천인 ID를 입력해 주세요. ");
return false;
}

winobject = window.open("","","scrollbars=no,resizable=yes,width=100,height=100");
winobject.document.location = "./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/REQER_EXISTS.php?id=" + f.RecID.value;
winobject.focus();
}
//-->
</script>
<table width="100%" height="359" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="68" valign="top"><table width="670" height="68" border="0" cellpadding="0" cellspacing="0" background="/images/main/bg_tit.gif">
        <tr> 
          <td width="258"><img src="/images/member/tit_join.gif"></td>
          <td width="412" align="right">home &gt; 회원가입</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td valign="top" style="padding-left:30px; padding-right:30px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><strong>요꾸요꾸의 회원으로 가입하시면...</strong><br>
            - 구매/경매대행 신청시 할인혜택을 받으실 수 있는 적립포인트 500점을 드립니다.<br>
            - 가입즉시 요꾸요꾸의 모든 서비스를 이용하실 수 있습니다.<br>
            - 회원가입시 기재하신 모든 정보는 완벽한 보안시스템에 의해 보호됩니다.<br>
            - 요꾸요꾸의 이용약관은 공정거래위원회 표준약관을 따르고 있습니다.</td>
        </tr>
        <tr> 
          <td>&nbsp; </td>
        </tr>
        <tr> 
          <td><textarea name="textarea" cols="100%" rows="10" style="color:#666666; ">       
제1조(목적)
이 약관은 네오커머스(이하 "회사"라 함)가 운영하는 요꾸요꾸 인터넷 사이트 (http://www.YokuYoku.com) 이하 "요꾸요꾸 사이트"라 한다)에서 제공하는 인터넷 관련 서비스(이하 "서비스"라 한다)를 이용함에 있어 회사와 회원의 권리·의무 및 책임사항을 규정 함을 목적으로 합니다.

제2조(정의)
1. "요꾸요꾸"라 함은 회사가 본 약관에 의하여 상품을 회원에게 제공하기 위하여 컴퓨터등 정보통 신설비를 이용하여 상품을 거래할 수 있도록 설정한 사이버상의 영업장을 말하며, 아울러 요꾸요꾸를 운영하는 회사의 의미로도 사용합니다.

2. "요꾸요꾸 서비스"라 함은 일본의 상품들을 국내에 판매하며 국내의 상품을 일본에 판매하고 구매대행을 할 수 있는 서비스를 말합니다.

3. "회원"이라 함은 요꾸요꾸에 개인정보를 제공하여 회원등록을 한 개인 이용자로서, 요꾸요꾸의 정보를 지속적으로 제공받으며 요꾸요꾸가 제공하는 서비스를 계속적으로 이용할 수 있는 자를 말합니다. 단,법인이나 회사명의 등으로의 가입은 별도의 공지가 없는 한 요꾸요꾸의 회원등록이 불가능합니다.

제3조(약관의 명시와 개정)

1. 요꾸요꾸는 이 약관의 내용과 상호, 영업소 소재지, 대표자의 성명, 사업자 등록번호, 연락처(전화,팩스,전자우편주소 등) 등을 회원이 알 수 있도록 요꾸요꾸 사이트에 게시합니다.
2. 요꾸요꾸는 약관의 규제 등에 관한 법률, 전자거래기본법, 전자서명법, 정보통신망 이용촉진 등에 관한 법률, 방문판매 등에 관한 법률, 소비자보호법 등 관련법을 위배하지 않는 범위에서 이 약관을 개정할 수 있습니다.
3. 요꾸요꾸가 약관을 개정할 경우에는 적용일자 및 개정사유를 명시하여 현행약관과 함께 사이트의 초기화면에 공지 하거나 회원이 제공한 E-mail로 전송하는 방식으로 공지합니다.
4. 요꾸요꾸가 약관을 개정할 경우에는 그 개정약관은 그 적용일자 이후에 체결되는 계약에만 적용되고 그 이전에 이미 체결된 계약에 대해서는 개정 전의 약관조항이 그대로 적용됩니다. 다만 이미 계약을 체결한 회원이 개정약관 조항의 적용을 받기를 원하는 뜻을 제3항에 의한 개정약관의 공지기간 내에 요꾸요꾸에 송신하여 요꾸요꾸의 동의를 받은 경우에는 개정약관 조항이 적용됩니다.
5. 이 약관에서 정하지 아니한 사항과 이 약관의 해석에 관하여는 대한민국정부가 제정한 전자거래소비자 보호지침 및 관계법령 또는 상관례에 따릅니다.

제4조(서비스의 제공 및 변경)
요꾸요꾸는 다음과 같은 업무를 수행합니다.
 
가. 상품판매에 대한 정보제공 및 구매대행계약의 체결
나. 회원이 요꾸요꾸 및 제3자를 통해 제3국으로부터 구매 또는 구매대행을 의뢰한 물건에 대한 개별운송 계약의 체결
다. 회원이 구매 또는 구매대행을 의뢰한 재화의 배송
라. 기타 요꾸요꾸가 정하는 업무



제5조(서비스의 중단)
1. 요꾸요꾸는 컴퓨터 등 정보통신설비의 보수, 점검, 교체 및 고장, 통신의 두절 등의 사유가 발생한 경우에는서비스의 제공을 일시적으로 중단할 수 있습니다.
2. 회사는 경영상 결정에 의하여 요꾸요꾸 서비스의 제공을 중단할 수 있습니다.

 
제6조(회원가입)
1. 회원은 이 약관에 동의한다는 의사표시를 한 후 요꾸요꾸가 정한 가입양식에 따라 회원정보를기입함으로서 회원가입을 신청합니다.
2. 요꾸요꾸는 제1항과 같이 회원으로 가입할 것을 신청한 회원 중 다음 각 호에 해당하지 않는 한 회원으로 등록합니다.  
가. 등록 내용에 허위, 기재누락, 오기가 있는 경우
나. 법인정보를 이용하여 법인명의로 등록하는 경우
다. 기타 회원으로 등록하는 것이 요꾸요꾸의 기술상 현저히 지장이 있다고 판단되는 경우
라. 가입신청자의 연령이 만 14세 미만인 경우
 
 
3. 회원가입계약의 성립시기는 요꾸요꾸의 회원가입 승낙이 회원에게 도달한 시점으로 합니다.
4. 회원은 회원가입시 기입한 회원정보에 변경이 있는 경우, 즉시 전자우편이나 기타 방법으로 요꾸요꾸에 그 변경사항을 알려야 합니다.
5. 회원가입 정보를 받은 경우도 본조2항 가, 나, 다, 라 항목에 해당될 시에는 회원가입이 승인되지 않은 것으로 
합니다.

제7조(회원탈퇴 및 자격상실 등)
1. 회원은 요꾸요꾸에 언제든지 회원탈퇴를 요청할 수 있으며 요꾸요꾸는 즉시 이를 처리합니다.
2. 회원이 다음 각 호의 사유에 해당하는 경우, 요꾸요꾸는 회원자격을 제한 또는 정지시킬 수 있습니다.  
가.가입신청 내역에 허위내용이 발견된 경우.
나. 다른 사람의 요꾸요꾸 이용을 방해하거나 그 정보를 도용하는 등 전자상거래 질서를 위협하는 경우
다. 회원이 제출한 주소 또는 연락처의 변경통지를 하지 않는 등 회원의 귀책사유로 인해 회원이 소재 불명 되어 요꾸요꾸가 회원에게 통지, 연락을 할 수 없다고 판단되는 경우.
라. 요꾸요꾸를 이용하여 관련법령과 이 약관이 금지하거나 공서양속에 반하는 행위를 하는 경우.


제8조(서비스 대상물품)
요꾸요꾸는 이 약관에 달리 정함이 없는 한 회원을 수취인으로 하여 요꾸요꾸 주소로 배송된 모든 물품을 결제시에 회원이 지정하는 장소로 배송하는 것을 원칙으로 합니다.
 
제9조(대금지급)
서비스이용에 대한 대금지급방법은 다음 각 호의 하나로 할 수 있습니다.
 
가. 계좌이체
나. 신용카드 결제
다. 온라인 무통장 입금
라. 쿠폰 및 회사가 정하는 마일리지 
마. 기타 요꾸요꾸가 인정하는 결제수단 
 

제 9조(수신확인통지, 배송신청 변경 및 취소)
1. 요꾸요꾸가 회원에게 회원이 구매한 물품의 거래내역을 요청할 경우 회원이 이에 대한 통보(배송요청)를 할 경우 요꾸요꾸는 회원에게 수신확인통지를 합니다.
2. 수신확인통지를 받은 회원은 의사표시의 불일치 등이 있는 경우에 수신확인통지를 받은후 즉시 배송신청 변경 및 취소를 요청할 수 있습니다.

제10조(개인정보보호)
1. 요꾸요꾸가 회원의 개인식별이 가능한 개인정보를 수집하는 때에는 반드시 당해 회원의 동의를 받습니다. 
2. 요꾸요꾸는 제1항의 규정에 의한 회원의 동의를 얻고자 하는 경우에는 미리 다음 각 호의 사항을 회원에게 명시하거나 고지합니다. 
 
가. 개인정보관리책임자의 성명, 소속부서, 직위 및 전화번호 기타 연락처
나. 개인정보의 수집목적 및 이용목적
다. 개인정보를 제3자에게 제공하는 경우의 제공받는 자, 제공목적 및 제공할 정보의 내용
라. 그 밖에 개인정보를 위해 필요한 사항으로서 정보통신망이용촉진 및 정보보호등에 관한 법률상에 대통령 령이 정하는 사항  
 
제11조(회원의 ID 및 비밀번호에 대한 의무)
1. 제19조의 경우를 제외한 ID와 비밀번호에 관한 관리책임은 회원에게 있습니다.
2. 회원은 자신의 ID 및 비밀번호를 제3자에게 이용하게 해서는 안됩니다.
3. 회원이 자신의 ID 및 비밀번호를 도난 당하거나 제3자가 사용하고 있음을 인지한 경우에는 바로 요꾸요꾸에 통보하고 요꾸요꾸의 안내가 있는 경우에는 그에 따라야 합니다

제21조(회원의 의무)
회원은 다음 각 호의 행위를 하여서는 안됩니다.
 
가. 회원가입 또는 회원정보 변경 시 허위내용의 등록 및 타 회원의 정보도용행위
나. 요꾸요꾸에 게시된 정보의 변경
다. 요꾸요꾸가 정한 정보 이외의 정보(컴퓨터 프로그램 등)의 송신 또는 게시
라. 요꾸요꾸 기타 제3자의 저작권 등 지적재산권에 대한 침해
마. 요꾸요꾸 기타 제3자의 명예를 손상시키거나 업무를 방해하는 행위
바. 외설 또는 폭력적인 메시지·화상·음성 기타 공서양속에 반하는 정보를 요꾸요꾸에 공개또는 게시하는 행위  
 
본 약관은 2002년 12월 1일부터 시행합니다.    
</textarea> 
          </td>
        </tr>
        <tr> 
          <td height="15"></td>
        </tr><FORM name="FrmUserInfo" method="post" OnSubmit="return MemberCheckField();" action="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/MEMBER_REGISQUERY.php">
        <tr> 
          <td><font color="#000000"> 
            <input type="checkbox" name="agree" value="1" style="border:0">
            </font><strong>위에 이용약관에 동의함. </strong></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td align="center"> <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr> 
                      <td height="2" colspan="2" bgcolor="#bbbbbb"></td>
                    </tr>
                    <tr> 
                      <td width="134" height="20" rowspan="2" bgcolor="#fafafa" style="padding-left:10px">아이디</td>
                      <td width="483" style="padding-left:10px; padding-top:5px"> 
                        <input name="ID" type="text" id="ID"> <a href="javascript:IDcheck()"><img src="images/common/button/btn_overlap.gif" width="70" height="19" border="0" align="absmiddle"></a> 
                      </td>
                    </tr>
                    <tr> 
                      <td style="padding-left:10px">영문 또는 영문/숫자혼합하여 4-12자.(한글불가) 
                      </td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                    </tr>
                    <tr> 
                      <td width="134" bgcolor="#fafafa" style="padding-left:10px">비밀번호</td>
                      <td style="padding-left:10px"> <p> 
                          <input name="PWD" type="password" id="PWD">
                          영문 또는 영문/숫자혼합하여 4-12자. </p></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                    </tr>
                    <tr> 
                      <td width="134" bgcolor="#fafafa" style="padding-left:10px">비밀번호 
                        확인 </td>
                      <td style="padding-left:10px"> <p> 
                          <input name="CPWD" type="password" id="CPWD">
                        </p></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                    </tr>
                    <tr> 
                      <td width="134" bgcolor="#fafafa" style="padding-left:10px">이름</td>
                      <td style="padding-left:10px"> <p> 
                          <input name="UserName" type="text" id="UserName">
                          <br>
                          실명으로 기입하셔야 하며, 한글 또는 영문 2-5자까지 가능. </p></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                    </tr>
                    <tr> 
                      <td width="134" bgcolor="#fafafa" style="padding-left:10px">비밀번호 
                        분실시 질문</td>
                      <td style="padding-left:10px"> <select name=PWDHint class=select>
                          <option value=''>선택하십시오.</option>
<?
reset($PasswordHintArr);
while(list($key, $value) = each($PasswordHintArr)):
	
	echo "<option value='$value'>$value</option>\n";
endwhile;
?></select> </td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                    </tr>
                    <tr> 
                      <td width="134" bgcolor="#fafafa" style="padding-left:10px">비밀번호 
                        분실시 답변</td>
                      <td style="padding-left:10px"> <p> 
                          <input type="text" name="PWDAnswer">
                        </p></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                    </tr>
                    <tr> 
                      <td width="134" bgcolor="#fafafa" style="padding-left:10px">E-mail<br></td>
                      <td style="padding-left:10px"> <p> 
                          <input name="Email" type="text" id="Email">
                          한메일을 제외한 E-mail을 입력. </p></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                    </tr>
                    <tr> 
                      <td width="134" bgcolor="#fafafa" style="padding-left:10px">주민등록번호<br></td>
                      <td style="padding-left:10px"> <p> 
                          <input name="Jumin1" type="text" id="Jumin1" size="10" maxlength="6">
                          - 
                          <input name="Jumin2" type="password" id="Jumin2" size="15" maxlength="7">
                          주민등록번호 유출방지를 위해 암호화하여 저장. </p></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                    </tr>
                    <tr> 
                      <td width="134" bgcolor="#fafafa" style="padding-left:10px">연락처<br></td>
                      <td style="padding-left:10px"> <p> 
                          <input name="Tel1_1" type="text" id="Tel1_1" size="4">
                          - 
                          <input name="Tel1_2" type="text" id="Tel1_2" size="4">
                          - 
                          <input name="Tel1_3" type="text" id="Tel1_3" size="4">
                          (예:02-123-1234) 실제 연락가능한 연락처를 입력. </p></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                    </tr>
                    <tr> 
                      <td width="134" bgcolor="#fafafa" style="padding-left:10px">휴대전화</td>
                      <td style="padding-left:10px"> <p> 
                          <input name="Tel2_1" type="text" id="Tel2_1" size="4">
                          - 
                          <input name="Tel2_2" type="text" id="Tel2_2" size="4">
                          - 
                          <input name="Tel2_3" type="text" id="Tel2_3" size="4">
                          (예:010-123-1234) 실제 연락가능한 휴대전화번호를 입력. </p></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                    </tr>
                    <tr> 
                      <td width="134" rowspan="2" bgcolor="#fafafa" style="padding-left:10px">주소입력</td>
                      <td style="padding-left:10px"> <p> 
                          <input name="Zip1_1" type="text" id="Zip1_1" size="4">
                          - 
                          <input name="Zip1_2" type="text" id="Zip1_2" size="4">
                          <a href="javascript:OpenZipcode()"><img src="images/common/button/btn_post.gif" width="100" height="19" hspace="5" border="0" align="absmiddle"></a> 
                        </p></td>
                    </tr>
                    <tr> 
                      <td style="padding-left:10px"><input name="Address1" type="text" id="Address1" size="50"> 
                        <br> <input name="Address2" type="text" id="Address2" size="50"> 
                      </td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                    </tr>
                    <tr> 
                      <td width="134" bgcolor="#fafafa" style="padding-left:10px">E-mail수신여부</td>
                      <td style="padding-left:10px"> <p> 
                          <input name="MailReceive" type="checkbox" id="MailReceive" style="border:0" value="1">
                          요꾸요꾸의 E-mail을 수신 합니다. </p></td>
                    </tr>
                    <tr> 
                      <td height="2" colspan="2" bgcolor="#dddddd"></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td width="730" align="center">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td align="center"><input type="image" src="images/common/button/btn_join3.gif" width="89" height="23" border="0"> 
                        <!--<a href="#"><img src="images/common/button/btn_rewrite2.gif" width="89" height="23" border="0"></a>--> 
                      </td>
                    </tr>
                    <tr> 
                      <td align="center">&nbsp;</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr></form>
      </table></td>
  </tr>
</table>
