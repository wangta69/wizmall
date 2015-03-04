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
		if($('#FrmUserInfo').formvalidate()){
			$("#FrmUserInfo").submit();
		}

	});	
});

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
	winobject = window.open("","","scrollbars=no,resizable=yes,width=300,height=200");
	winobject.document.location = "./wizmember/<?php echo$cfg["skin"]["MemberSkin"]?>/ID_EXISTS.php?id=" + f.id.value;
	winobject.focus();
}

function nickNamecheck()
{
	var f=document.FrmUserInfo;
	winobject = window.open("","","scrollbars=no,resizable=yes,width=380,height=300");
	winobject.document.location = "./wizmember/<?php echo$cfg["skin"]["MemberSkin"]?>/NICKNAME_EXISTS.php?nickname=" + f.nickname.value;
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
	winobject.document.location = "./wizmember/<?php echo$cfg["skin"]["MemberSkin"]?>/Jumin_EXISTS.php?jumin1=" + f.jumin1.value+"&jumin2=" + f.jumin2.value;
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
winobject.document.location = "./wizmember/<?php echo$cfg["skin"]["MemberSkin"]?>/REQER_EXISTS.php?id=" + f.recid.value;
winobject.focus();
}
//-->
</script>

<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active">회원가입</li>
</ul>

<div class="panel">
	회원가입
	<div class="panel-footer">
		아래의 내용을 정확히 입력하신 후 [확인]단추를 누르세요.<br />
개인정보는 절대 외부로 유출되지 않으니 안심하세요
	</div>
</div>

<form name="FrmUserInfo" id="FrmUserInfo" method="post" action="./wizmember/<?php echo$cfg["skin"]["MemberSkin"]?>/MEMBER_REGISQUERY.php">
	<input type="hidden" id="idchk_result" name="idchk_result" value="" />
	<input type="hidden" id="nickchk_result" name="nickchk_result" value="" />
	<!-- 
  <input type="hidden" name="goto" value="MEMBER_REGIST_DONE"> <!--회원가입완료후 별도의 페이지가 있을 경우 
  <input type="hidden" name="goto" value="REGIST_PAYMEMBER"><!--회원가입완료후 유료 결제 페이지로 이동할 경우 
  <input type="hidden" name="mgrade" value="<?php echo$mgrade?>"><!--앞단에서 회원별 선택으로 처리될 경우
 //-->

	<table class="table_main w100p">
	<col width="130" />
	<col width="*" />
	<tbody>
		<tr>
			<th>* 회원 ID </th>
			<td><input name="id" type="text" id="id" onClick="javascript:IDcheck()" maxlength="9" readonly="readonly" class="required check_engnum min6 max15" msg="영문및 숫자만 가능합니다.">
				&nbsp; <img src="wizmember/<?php echo$cfg["skin"]["MemberSkin"]?>/images/but_id.gif" width="78" onClick="javascript:IDcheck()" style="cursor:pointer";> 영(소문자)/숫자 6~15자 ID중복검사</td>
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
			<td align='left'><input name="name" type="text" id="name" value="<?php echo$UserName?>" size="20" maxlength="30" class="required" msg="이름을 입력해주세요">
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
			<td align='left'><input name="jumin1" type="text" id="jumin1" onKeyup=moveFocus(6,this,this.form.jumin2); value="<?php echo$UserJumin1?>" maxlength="6" readonly="readonly" onChange="setBirthday();" class="w100 required check_jumin1">
				-
				<input name="jumin2" type="password" id="jumin2" value="<?php echo$UserJumin2?>" maxlength="7" readonly="readonly" onChange="setGender();" class="w100 required check_jumin2">
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
			<td><input type="text" name="zip1_1" id="zip1_1" maxlength="3" readonly="readonly" class="w30 required" msg="우편번호를 입력해주세요">
				-
				<input name="zip1_2" type="text" id="zip1_2" maxlength="3" readonly="readonly" class="w30 required" msg="우편번호를 입력해주세요">
				<img src="wizmember/<?php echo$cfg["skin"]["MemberSkin"]?>/images/but_post.gif" width="91" onClick="javascript:OpenZipcode()" style="cursor:pointer";> <br />
				<input name=address1 type="text" id="address1" readonly="readonly" class="w300 required" msg="주소를 입력해주세요">
				<br />
				<input name=address2 type="text" id="address2" class="w300 required" msg="상세주소를 입력해주세요">
				(상세주소)<br />
				정확하게 기입해주세요 </td>
		</tr>
		<? if(!strcmp($cfg["mem"]["EAddress3"],"checked")):?>
		<tr>
			<th>직장주소</th>
			<td><input name="zip2_1" type="text" id="zip2_1" maxlength="3" readonly="readonly" class="w30">
				-
				<input name="zip2_2" type="text" id="zip2_2" maxlength="3" readonly="readonly" class="w30">
				<img src="wizmember/<?php echo$cfg["skin"]["MemberSkin"]?>/images/but_post.gif" width="91" onClick="javascript:OpenZipcode1()" style="cursor:pointer";> <br />
				<input name=address3 type="text" id="address3" class="w300"readonly="readonly">
				<br />
				<input name=address4 type="text" id="address4" class="w300">
				(상세주소)<br />
				정확하게 기입해주세요 </td>
		</tr>
		<?endif;?>
		<tr>
			<th>* 전화번호</th>
			<td align='left'>
					  <select name="tel1_1" id="telephone1" class="required" msg="전화번호를 입력해주세요">
		  <? 
		  foreach($PhoneArr2 as $key=>$val){
				echo "<option>".$key."</option>\n";
			}
		?>
          </select>
				-
				<input name="tel1_2" type="text" id="tel1_2" maxlength="4" class="w30 required" msg="전화번호를 입력해주세요" />
				-
				<input name="tel1_3" type="text" id="tel1_3" maxlength="4" class="w30 required" msg="전화번호를 입력해주세요" /></td>
		</tr>
		<? if(!strcmp($cfg["mem"]["ETel2"],"checked")):?>
		<tr>
			<th>이동전화</th>
			<td align='left'>
			<select name="tel2_1" id="select2">
		  <? 
		  foreach($PhoneArr1 as $key=>$val){
				echo "<option>".$key."</option>\n";
			}
		?>

          </select>

				-
				<input name="tel2_2" type="text" id="tel2_2" maxlength=4 class="w30">
				-
				<input name="tel2_3" type="text" id="tel2_3" maxlength=4 class="w30">
			</td>
		</tr>
		<?endif;?>
		<tr>
			<th>* 전자우편</th>
			<td align='left'><input name=email_1 type="text" id="email_1" class="w100 required check_email" groupemail="email_grp" msg="이메일을 입력해주세요" />
				@
				<input name=email_2 type="text" id="email_2" class="w100 email_grp" />
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
