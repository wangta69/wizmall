<?
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/

include_once "./config/common_array.php";
?>
<script language=javascript src="./js/jquery.plugins/jquery.validator-1.0.1.js"></script>

<script language="javascript">
<!--
$(function(){
	$(".btn_cancel").click(function(){
		history.go(-1);
	});
	
	$(".btn_confirm").click(function(){
	
	});	
});
function MemberCheckField(f)
{
	if (!TypeCheck(f.id.value, ALPHA+NUM)) {
		alert("ID는 영문자 및 숫자로만 사용할 수 있습니다. ");
		f.id.focus();
		return false;
	}else if ((f.id.value.length < 4) || (f.id.value.length > 12)) {
		alert("ID는 4자 이상, 12자 이내이어야 합니다.");
		f.id.focus();
		return false;
	}else if (f.idchk_result.value != "1") {
		alert("아이디 중복확인을 해주시기 바랍니다.");
		f.id.focus();
		return false;		
	}else if (f.passwd.value.length < 4) {
		alert("비밀번호는 4자 이상이어야 합니다. ");
		f.passwd.focus();
		return false;
	}else if ((f.passwd.value) != (f.cpasswd.value)) {
		alert("비밀번호재확인을 정확히 입력해 주세요. ");
		f.cpasswd.focus();
		return false;
	}else if ((f.name.value.length < 2) || (f.name.value.length > 5)) {
		alert("이름을 정확히 적어주십시오.");
		f.name.focus();
		return false;
	}else if(!IsJuminChk(f.jumin1.value, f.jumin2.value)){
	f.jumin1.focus();
	return false;
	}
	
	<? if(!strcmp($cfg["mem"]["EBirthDay"],"checked")):?>
	mm = parseInt(f.birthmm.value, 10);
	dd = parseInt(f.birthdd.value, 10);
	
	if ((!TypeCheck(f.birthyy,NUM)) || (!TypeCheck(f.birthmm,NUM)) || (!TypeCheck(f.birthdd, NUM)) ) {
	alert("생년월일에 잘못된 문자가 있습니다.");
	f.birthyy.focus();
	return false;
	}
	
	if ((mm < 1) || (mm > 12)) {
	alert("생년 월일이 잘못되었습니다.");
	f.birthmm.focus();
	return false;
	}
	
	if ((dd < 1) || (dd > 31)) {
	alert("생년 월일이 잘못되었습니다.");
	f.birthdd.focus();
	return false;
	}          
	<? endif;?>
	if(!IsEmailChk(f.email_1.value+"@"+f.email_2.value)){ //이메일 유효성검사
	f.email_1.focus();
	return false;
	}
	
	if  (f.address1.value.length < 5) {
	alert("주소를 정확히 입력해 주세요.");
	f.address1.focus();
	return false;
	}  
	if  (f.address2.value.length < 2) {
	alert("번지수/통/반을 정확히 입력해 주세요.[예:123번지] ");
	f.address2.focus();
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
	if(!chkWorkNum(f.companynum1.value, f.companynum2.value, f.companynum3.value)){
			f.companynum1.focus();
			return false;
			}
	return true;
}




function FillBirthDay()
{
var f=document.FrmUserInfo;

	if ( ! TypeCheck(f.jumin1.value, NUM)) {
	alert("주민등록 번호에 잘못된 문자가 있습니다. ");
	f.jumin1.focus();
	return false;
	}
	
	num = f.jumin1.value;
	
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
	
	f.birthyy.value = "19" + num.substring(0,2);
	f.birthmm.value = num.substring(2,4);
	f.birthdd.value = num.substring(4,6);
	
	
	f.jumin2.focus();
}



function OpenZipcode(){
	wizwindow("./util/zipcode/zipcode.php?form=FrmUserInfo&zip1=zip1_1&zip2=zip1_2&firstaddress=address1&secondaddress=address2","ZipWin","width=490,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no");
}
function OpenZipcode1(){
	wizwindow("./util/zipcode/zipcode.php?form=FrmUserInfo&zip1=zip2_1&zip2=zip2_2&firstaddress=address3&secondaddress=address4","ZipWin","width=490,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no");
}

function IDcheck()
{
	var f=document.FrmUserInfo;
	winobject = window.open("","","scrollbars=no,resizable=yes,width=470,height=150");
	winobject.document.location = "./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/ID_EXISTS.php?id=" + f.id.value;
	winobject.focus();
}

function nickNamecheck()
{
	var f=document.FrmUserInfo;
	winobject = window.open("","","scrollbars=no,resizable=yes,width=380,height=300");
	winobject.document.location = "./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/NICKNAME_EXISTS.php?nickname=" + f.nickname.value;
	winobject.focus();
}

function Jumincheck()
{
	var f=document.FrmUserInfo;
		if(!IsJuminChk(f.jumin1.value, f.jumin2.value)){
		f.jumin1.focus();
		return false;
		}
	winobject = window.open("","","scrollbars=no,resizable=yes,width=1,height=1");
	winobject.document.location = "./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/Jumin_EXISTS.php?jumin1=" + f.jumin1.value+"&jumin2=" + f.jumin2.value;
	winobject.focus();
}
function Reqercheck()
{
var f=document.FrmUserInfo;
if (f.recid.value == "") {
alert("추천인 ID를 입력해 주세요. ");
return false;
}

winobject = window.open("","","scrollbars=no,resizable=yes,width=100,height=100");
winobject.document.location = "./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/REQER_EXISTS.php?id=" + f.recid.value;
winobject.focus();
}
//-->
</script>

<div class="navy">Home &gt; 회원가입</div>
<fieldset class="desc">
<legend>[안내]</legend>
<div class="notice">회원가입</div>
<div class="comment">
아래의 내용을 정확히 입력하신 후 [확인]단추를 누르세요.<br />
개인정보는 절대 외부로 유출되지 않으니 안심하세요
</div>
</fieldset>
<form name="FrmUserInfo" method="post" OnSubmit="return MemberCheckField(this);" action="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/MEMBER_REGISQUERY.php">
	<input type="hidden" id="idchk_result" name="idchk_result" value="" />
	<input type="hidden" id="nickchk_result" name="nickchk_result" value="" />
	<!-- 
  <input type="hidden" name="goto" value="MEMBER_REGIST_DONE"> <!--회원가입완료후 별도의 페이지가 있을 경우 
  <input type="hidden" name="goto" value="REGIST_PAYMEMBER"><!--회원가입완료후 유료 결제 페이지로 이동할 경우 
  <input type="hidden" name="mgrade" value="<?=$mgrade?>"><!--앞단에서 회원별 선택으로 처리될 경우
 //-->

	<table class="table_main w100p">
	<tbody>
		<tr>
			<th>* 회원 ID </th>
			<td><input name="id" type="text" id="id" onClick="javascript:IDcheck()" maxlength="9" readonly class="required check_engnum min6 max15" msg="영문및 숫자만 가능합니다.">
				&nbsp; <img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_id.gif" width="78" onClick="javascript:IDcheck()" style="cursor:pointer";> 영(소문자)/숫자 6~15자 ID중복검사</td>
		</tr>
		<tr>
			<th>* 비밀번호</th>
			<td align='left'><input name="passwd" type="password" id="passwd" maxlength="30" class="required text_grp" group="text_grp" msg="비밀번호를 정확하게 입력해주세요">
			</td>
		</tr>
		<tr>
			<th>* 비밀번호 확인</th>
			<td align='left'><input name="cpasswd" type="password" id="cpasswd" maxlength="30" class="text_grp">
			</td>
		</tr>
		<tr>
			<th>* 이름</th>
			<td align='left'><input name="name" type="text" id="name" value="<?=$UserName?>" size="20" maxlength="30" class="required" msg="이름을 입력해주세요">
			</td>
		</tr>
		<? if(!strcmp($cfg["mem"]["ESex"],"checked")):?>
		<tr>
			<th>성 별</th>
			<td align='left'><input name="gender" type="radio" value="1" checked>
				남자 &nbsp;
				<input type="radio" name="gender" value="2">
				여자 </td>
		</tr>
		<?endif;?>
		<tr>
			<th>* 주민등록번호</th>
			<td align='left'><input name="jumin1" type="text" id="jumin1" onKeyup=moveFocus(6,this,this.form.Jumin2); value="<?=$UserJumin1?>" size="10" maxlength="6" readonly onChange="setBirthday();" class="required check_jumin1">
				-
				<input name="jumin2" type="password" id="jumin2" value="<?=$UserJumin2?>" size="10" maxlength="7" readonly onChange="setGender();" class="required check_jumin2">
			</td>
		</tr>
		<? if(!strcmp($PasswordHintEnable,"checked")):?>
		<tr>
			<th>* 비밀번호 
				분실시 질문</th>
			<td align='left'><select name="pwdhint" id="pwdhint"  class="required" msg="질문을 선택해 주세요">
					<option value=''>선택하십시오.</option>
					<?
reset($PasswordHintArr);
while(list($key, $value) = each($PasswordHintArr)):
	
	echo "<option value='$value'>$value</option>\n";
endwhile;
?>
				</select>
			</td>
		</tr>
		<tr>
			<th>* 비밀번호 
				분실시 답변</th>
			<td align='left'><input name="pwdanswer" type="text" id="pwdanswer" size="20" maxlength="30"  class="required" msg="답변을 입력해주세요" >
			</td>
		</tr>
		<? endif;?>
		<? if(!strcmp($cfg["mem"]["EBirthDay"],"checked")):?>
		<tr>
			<th>생년월일</th>
			<td align='left'><select name="birthyy" id="birthyy">
					<option value=''>년도</option>
					<?
for($i=1950; $i<date("Y"); $i++){
echo "<option value='$i'>$i</option>\n";
}
?>
				</select>
				년
				<select name="birthmm" id="birthmm">
					<option value=''>월</option>
					<?
for($i=1; $i<13; $i++){
echo "<option value='$i'>$i</option>\n";
}
?>
				</select>
				월
				<select name="birthdd" id="birthdd">
					<option value=''>일</option>
					<?
for($i=1; $i<32; $i++){
echo "<option value='$i'>$i</option>\n";
}
?>
				</select>
				일&nbsp;&nbsp;&nbsp;
				<input type="radio" name="birtytype" value="0">
				양력
				<input type="radio" name="birtytype" value="1">
				음력 </td>
		</tr>
		<? endif;?>
		<?if(!strcmp($Ecfg["mem"]["EMarrStatus"],"checked")):?>
		<tr>
			<th>결혼기념일</th>
			<td align='left'><select name="marryy" id="marryy">
					<option value=''>년도</option>
					<?
for($i=1950; $i<date("Y"); $i++){
echo "<option value='$i'>$i</option>\n";
}
?>
				</select>
				년
				<select name="marrmm" id="marrmm">
					<option value=''>월</option>
					<?
for($i=1; $i<13; $i++){
echo "<option value='$i'>$i</option>\n";
}
?>
				</select>
				월
				<select name="marrdd" id="marrdd">
					<option value=''>일</option>
					<?
for($i=1; $i<32; $i++){
echo "<option value='$i'>$i</option>\n";
}
?>
				</select>
				일&nbsp;&nbsp;&nbsp;
				<input type="radio" name="marrstatus" value="0">
				미혼
				<input type="radio" name="marrstatus" value="1">
				기혼</td>
		</tr>
		<? endif; ?>
		<? if(!strcmp($cfg["mem"]["EJob"],"checked")):?>
		<tr>
			<th>직업</th>
			<td align='left'><select name="job" id="job">
					<?
reset($JobArr);
foreach($JobArr as $key=>$value){
echo "<option value='$key'>$value</option>\n";
}
?>
				</select>
			</td>
		</tr>
		<? endif;?>
		<? if(!strcmp($cfg["mem"]["EScholarship"],"checked")):?>
		<tr>
			<th>학력</th>
			<td align='left'><select name="Scholarship">
					<?
reset($ScholarshipArr);
foreach($ScholarshipArr as $key=>$value){
echo "<option value='$key'>$value</option>\n";
}
?>
				</select>
			</td>
		</tr>
		<? endif; ?>
		<? if(!strcmp($cfg["mem"]["ECompany"],"checked")):?>
		<tr>
			<th>회사명</th>
			<td align='left'><input type="text" name="company" size="20" maxlength="30" value="" >
			</td>
		</tr>
		<? endif;?>
		<? if(!strcmp($cfg["mem"]["ECompnum"],"checked")):?>
		<tr>
			<th>사업자등록번호</th>
			<td align='left'><input type="text" name="companynum1" maxlength="3" onKeyup="moveFocus(3,this,this.form.Compnum2);" class="w50">
				-
				<input type="text" name="companynum2" maxlength="2"  onKeyup="moveFocus(2,this,this.form.Compnum3)"; class="w50">
				-
				<input type="text" name="companynum3" maxlength="5" class="w50">
			</td>
		</tr>
		<?endif;?>
		<tr>
			<th>자택주소</th>
			<td><input type="text" name="zip1_1" id="zip1_1" maxlength="3" READONLY class="w30">
				-
				<input name="zip1_2" type="text" id="zip1_2" maxlength="3" READONLY class="w30">
				<img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_post.gif" width="91" onClick="javascript:OpenZipcode()" style="cursor:pointer";> <br />
				<input name=address1 type="text" id="address1" READONLY class="w300">
				<br />
				<input name=address2 type="text" id="address2" class="w300">
				(상세주소)<br />
				정확하게 기입해주세요 </td>
		</tr>
		<? if(!strcmp($cfg["mem"]["EAddress3"],"checked")):?>
		<tr>
			<th>직장주소</th>
			<td><input name="zip2_1" type="text" id="zip2_1" maxlength="3" READONLY class="w30">
				-
				<input name="zip2_2" type="text" id="zip2_2" maxlength="3" READONLY class="w30">
				<img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_post.gif" width="91" onClick="javascript:OpenZipcode1()" style="cursor:pointer";> <br />
				<input name=address3 type="text" id="address3" class="w300"READONLY>
				<br />
				<input name=address4 type="text" id="address4" class="w300">
				(상세주소)<br />
				정확하게 기입해주세요 </td>
		</tr>
		<?endif;?>
		<tr>
			<th>* 전화번호</th>
			<td align='left'><input name=tel1_1 type="text" id="tel1_1" maxlength=4 class="w30">
				-
				<input name=tel1_2 type="text" id="tel1_2" maxlength=4 class="w30">
				-
				<input name=tel1_3 type="text" id="tel1_3" maxlength=4 class="w30">
				&nbsp;</td>
		</tr>
		<? if(!strcmp($cfg["mem"]["ETel2"],"checked")):?>
		<tr>
			<th>이동전화</th>
			<td align='left'><input name="tel2_1" type="text" id="tel2_1" class="w30" maxlength=4>
				-
				<input name="tel2_2" type="text" id="tel2_2" maxlength=4 class="w30">
				-
				<input name="tel2_3" type="text" id="tel2_3" maxlength=4 class="w30">
			</td>
		</tr>
		<?endif;?>
		<tr>
			<th>* 전자우편</th>
			<td align='left'><input name=email_1 type="text" id="email_1" >
				@
				<input name=email_2 type="text" id="email_2" />
				<select name="tmpmail" onChange="email_chk(this)">
					<option value=''>선택해주세요</option>
					<?
reset($MailArr);
foreach($MailArr as $key=>$value){
	echo "<option value='$value'>$value</option>\n";
}
?>
					<option value='etc'>기타</option>
				</select></td>
		</tr>
		<? if(!strcmp($cfg["mem"]["EMailReceive"],"checked")):?>
		<tr>
			<th>정기소식메일</th>
			<td align='left'><input name="mailreceive" type="radio" value="1" checked>
				수신
				<input type="radio" name="mailreceive" value="0">
				수신하지 않음</td>
		</tr>
		<? endif;?>
		<? if(!strcmp($cfg["mem"]["ERecID"],"checked")):?>
		<tr>
			<th>추천인 ID </th>
			<td><input type="text" name="recid" maxlength="9" value="" >
			</td>
		</tr>
		<?endif;?>
		</tbody>
	</table>
	<div class="space15"></div>
	<div class="btn_box">
		<span class="btn_confirm button bull"><a>확인</a></span> <span class="btn_cancel button bull"><a>취소</a></span></div>
</form>
