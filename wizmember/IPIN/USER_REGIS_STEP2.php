<?php
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/

include_once "./config/common_array.php";

//kcb IPIN일경우 변수값 변경
$UserName		= $_POST["realname"];
$gender			= $_POST["sex"];
$birthdate		= $common->splitDate($_POST["birthdate"]);
?>
<script language="javascript" src="./js/jquery.plugins/jquery.validator-1.0.1.js"></script>

<script>

$(function(){
	$(".btn_cancel").click(function(){
		history.go(-1);
	});
	
	$(".btn_confirm").click(function(){
		if($('#FrmUserInfo').formvalidate()){
			//alert('passed');
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
	winobject.document.location = "./wizmember/<?php echo $cfg["skin"]["MemberSkin"]?>/ID_EXISTS.php?id=" + f.id.value;
	winobject.focus();
}

function nickNamecheck()
{
	var f=document.FrmUserInfo;
	winobject = window.open("","","scrollbars=no,resizable=yes,width=380,height=300");
	winobject.document.location = "./wizmember/<?php echo $cfg["skin"]["MemberSkin"]?>/NICKNAME_EXISTS.php?nickname=" + f.nickname.value;
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
	winobject.document.location = "./wizmember/<?php echo $cfg["skin"]["MemberSkin"]?>/Jumin_EXISTS.php?jumin1=" + f.jumin1.value+"&jumin2=" + f.jumin2.value;
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
	winobject.document.location = "./wizmember/<?php echo $cfg["skin"]["MemberSkin"]?>/REQER_EXISTS.php?id=" + f.recid.value;
	winobject.focus();
}
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

<form name="FrmUserInfo" id="FrmUserInfo" method="post" action="./wizmember/<?php echo $cfg["skin"]["MemberSkin"]?>/MEMBER_REGISQUERY.php" class="form-horizontal" role="form">
	<input type="hidden" id="idchk_result" name="idchk_result" value="" />
	<input type="hidden" id="nickchk_result" name="nickchk_result" value="" />
	<input type="hidden" id="hidden_ci" name="hidden_ci" value="<?php echo $_POST["coinfo1"]?>" />
	<input type="hidden" id="hidden_di" name="hidden_di" value="<?php echo $_POST["dupinfo"]?>" />
	<!--
	<input type="text" id="hidden_di" name="hidden_di" value="<?php echo $_POST["birthdate"]?>" />
	<input type="text" id="hidden_di" name="hidden_di" value="<?php echo $_POST["sex"]?>" />
	<input type="text" id="hidden_di" name="hidden_di" value="<?php echo $_POST["realname"]?>" />
	 
  <input type="hidden" name="goto" value="MEMBER_REGIST_DONE"> <!--회원가입완료후 별도의 페이지가 있을 경우 
  <input type="hidden" name="goto" value="REGIST_PAYMEMBER"><!--회원가입완료후 유료 결제 페이지로 이동할 경우 
  <input type="hidden" name="mgrade" value="<?php echo $mgrade?>"><!--앞단에서 회원별 선택으로 처리될 경우
 //-->
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">* 회원 ID</label>
		<div class="col-lg-2">
			<input name="id" type="text" id="id" onclick="javascript:IDcheck()" maxlength="9" readonly="readonly" class="required check_engnum min6 max15 form-control" msg="영문및 숫자만 가능합니다.">
		</div>
		<button type="button" class="btn btn-default" onclick="javascript:IDcheck()">중복검색</button>
	</div>
	<div class="form-group">
		<label for="passwd" class="col-lg-2 control-label">* 비밀번호</label>
		<div class="col-lg-10">
			<input name="passwd" type="password" id="passwd" maxlength="30" class="required text_grp form-control" group="text_grp" msg="비밀번호를 정확하게 입력해주세요">
		</div>
	</div>
	<div class="form-group">
		<label for="cpasswd" class="col-lg-2 control-label">* 비밀번호 확인</label>
		<div class="col-lg-10">
			<input name="cpasswd" type="password" id="cpasswd" maxlength="30" class="form-control text_grp" >
		</div>
	</div>
	<div class="form-group">
		<label for="name" class="col-lg-2 control-label">* 이름</label>
		<div class="col-lg-10">
			<input type="text" name="name" id="name" value="<?php echo $UserName; ?>" size="20" maxlength="30" class="form-control required" msg="이름을 입력해주세요">
		</div>
	</div>
<?php if(!strcmp($cfg["mem"]["ESex"],"checked")):?>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">성 별</label>
		<div class="col-lg-10">
			<div class="radio-inline">
				<label>
					<input type="radio" name="gender" value="1"<?php if($gender == "1") echo " checked"; ?> /> 남자 
				</label>
			</div>
			<div class="radio-inline">
				<label>
					<input type="radio" name="gender" value="2"<?php if($gender == "2") echo " checked"; ?> /> 여자
				</label>
			</div>
		</div>
	</div>
<?php endif;?>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">생년월일</label>
		<div class="col-lg-2">
			<select name="birthyy" id="birthyy" class="form-control">
				<option value=''>년도</option>
<?php 
	for($i=1950; $i<date("Y"); $i++){
		$selected = $birthdate[0] == $i ? "selected":"";
		echo "<option value='$i' $selected>".$i."년</option>\n";
	}
?>
			</select>
			
		</div>
		<div class="col-lg-2">
			<select name="birthmm" id="birthmm" class="form-control">
				<option value=''>월</option>
<?php 
	for($i=1; $i<13; $i++){
		$selected = $birthdate[1] == str_pad($i, 2, "0", STR_PAD_LEFT) ? "selected":"";
		echo "<option value='".str_pad($i, 2, "0", STR_PAD_LEFT)."' $selected>".str_pad($i, 2, "0", STR_PAD_LEFT)."월</option>\n";
	}
?>
				</select>
		</div>
		<div class="col-lg-2">
			<select name="birthdd" id="birthdd" class="form-control">
				<option value=''>일</option>
<?php 
	for($i=1; $i<32; $i++){
		$selected = $birthdate[2] == str_pad($i, 2, "0", STR_PAD_LEFT) ? "selected":"";
		echo "<option value='".str_pad($i, 2, "0", STR_PAD_LEFT)."' $selected>".str_pad($i, 2, "0", STR_PAD_LEFT)."일</option>\n";
	}
?>
			</select>
		</div>
		<div class="col-lg-2">
			<div class="radio-inline">
				<label>
					<input type="radio" name="birthtype" value="0"> 양력 
				</label>
			</div>
			<div class="radio-inline">
				<label>
                	<input type="radio" name="birthtype" value="1"> 음력
                </label>
			</div>
		</div>
	</div>
<?php if(!strcmp($cfg["mem"]["EMarrStatus"],"checked")):?>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">결혼여부</label>
		<div class="col-lg-10">
			<select name="marryy" id="marryy">
				  <option value=''>년도</option>
<?php 
	for($i=1950; $i<date("Y"); $i++){
		echo "<option value='$i'>$i</option>\n";
	}
?>
			</select>년
			<select name="marrmm" id="marrmm">
				  <option value=''>월</option>
<?php 
	for($i=1; $i<13; $i++){
		echo "<option value='$i'>$i</option>\n";
	}
?>
			</select>월
			<select name="marrdd" id="marrdd">
				  <option value=''>일</option>
<?php 
	for($i=1; $i<32; $i++){
		echo "<option value='$i'>$i</option>\n";
	}
?>
			</select>일
			<div class="radio-inline">
				<label>
					<input type="radio" name="marrstatus" value="0"> 미혼 
				</label>
			</div>
			<div class="radio-inline">
				<label>
                    <input type="radio" name="marrstatus" value="1"> 기혼
				</label>
			</div>
		</div>
	</div>
<?php endif;?>
<?php if(!strcmp($cfg["mem"]["EJob"],"checked")):?>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">직업</label>
		<div class="col-lg-10">
			<select name="job" id="job" class="form-control">
<?php 
	reset($JobArr);
	foreach($JobArr as $key=>$value){
		echo "<option value='$key'$value</option>\n";
	}
?>
                   </select>
		</div>
	</div>
<?php endif;?>
<?php if(!strcmp($cfg["mem"]["EScholarship"],"checked")):?>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">학력</label>
		<div class="col-lg-10">
			<select name="scholarship" id="scholarship" class="form-control">
<?php 
	reset($ScholarshipArr);
	foreach($ScholarshipArr as $key=>$value){
		echo "<option value='$key'>$value</option>\n";
	}
?>
                    </select>
		</div>
	</div>
<?php endif;?>
<?php if (!strcmp($cfg["mem"]["ECompany"],"checked")):?>	
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">회사명</label>
		<div class="col-lg-10">
			<input name="company" type="text" id="company" class="form-control" value="" > 
		</div>
	</div>
<?php endif;?>
<?php if(!strcmp($cfg["mem"]["ECompnum"],"checked")):?>	
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">사업자등록번호</label>
		<div class="col-lg-2">
				<input name="companynum1" type="text" value=""  class="form-control" onKeyup="moveFocus(3,this,this.form.Compnum2);">
			</div> 
		<div style="display: inline-block; float:left">-</div>
		<div class="col-lg-2">
			<input name="companynum2" type="text" value="" class="form-control" onKeyup="moveFocus(2,this,this.form.Compnum3);"/> 
		</div>
		<div style="display: inline-block; float:left">-</div>
		<div class="col-lg-2">
			<input name="companynum3" type="text" value="" class="form-control"/> 
		</div>
	</div>
<?php endif;?>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">자택주소</label>
		<div class="col-lg-10">
			<div class="col-lg-2 padlzero">
				<input type="text" name="zip1_1" id="zip1_1" value="" maxlength="3" readonly="readonly" class="form-control" />
			</div>
            <div style="display: inline-block; float:left">-</div>
            <div class="col-lg-2">
            	<input type="text" name="zip1_2" id="zip1_2" value="" maxlength="3" readonly="readonly" class="form-control" /> 
            </div>
            <button type="button" class="btn btn-default" onclick="OpenZipcode()">우편번호찾기</button>
            <p><br/><input name="address1" type="text" id="address1" value="" readonly="readonly" class="form-control"/></p>
            <p><input name="address2" type="text" id="address2" value="" class="form-control" /></p>
                    (상세주소)
		</div>
	</div>
<?php if(!strcmp($cfg["mem"]["EAddress3"],"checked")):?>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">직장주소</label>
		<div class="col-lg-10">
			<input type="text" name="zip2_1" id="zip2_1" value="" maxlength="3" readonly="readonly"/>
                    - 
            <input type="text" name="zip2_2" id="zip2_2" value="" maxlength="3" readonly="readonly"/> 
            <button type="button" class="btn btn-default" onclick="OpenZipcode1()">우편번호찾기</button>
            <br /> <input name=address3 type="text" id="address3" value="" readonly="readonly" class="form-control"/> 
            <br /> <input name=address4 type="text" id="address4" value="" class="form-control" />
                    (상세주소)
		</div>
	</div>
<?php endif;?>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">* 전화번호</label>
		<div class="col-lg-10">
			<div class="col-lg-2 padlzero">
				<select name="tel1_1" id="telephone1" class="form-control">
<?php
	foreach($PhoneArr2 as $key=>$val){
		echo "<option>".$key."</option>\n";
	}
?>
         		</select>
        	</div>
			<div style="display: inline-block; float:left">-</div>
			<div class="col-lg-2">
				<input name="tel1_2" type="text" value="" maxlength="4" class="form-control" />
			</div>
			 <div style="display: inline-block; float:left">-</div>
			<div class="col-lg-2">
			<input name="tel1_3" type="text" value="" maxlength="4" class="form-control" />
			</div>
		</div>
	</div>
<?php if(!strcmp($cfg["mem"]["ETel2"],"checked")):?>	
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">이동전화</label>
		<div class="col-lg-10">
			<div class="col-lg-2 padlzero">
				<select name="tel2_1" id="select2" class="form-control" >
<?php
	foreach($PhoneArr1 as $key=>$val){
		$selected = $tel2[0] == $key ? " selected":"";
		echo "<option>".$key."</option>\n";
	}
?>
	
				</select>
			</div>
			<div style="display: inline-block; float:left">-</div>
			<div class="col-lg-2">
				<input name="tel2_2" type="text" value=""  class="form-control" data-format="dddd-dddd"/>
			</div> 
			<div style="display: inline-block; float:left">-</div>
			<div class="col-lg-2">
				<input name="tel2_3" type="text" value="" class="form-control"/> 
			</div>
                    
		</div>
	</div>
<?php endif;?>	
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">* 
                    전자우편</label>
		<div class="col-lg-10">
			<div class="col-lg-3 padlzero">
				<input name="email_1" type="text" id="email_1" value="" class="form-control">
			</div>
			<div style="display: inline-block; float:left">@</div>
			<div class="col-lg-3">
				<input name="email_2" type="text" id="email_2" value="" class="form-control" />
			</div>
			<div class="col-lg-3">
				<select name="tmpmail" onChange="email_chk(this)" class="form-control">
					<option value=''>선택해주세요</option>
<?php 
	reset($MailArr);
	foreach($MailArr as $key=>$value){
		echo "<option value='$value'>$value</option>\n";
	}
?>
				<option value='etc'>기타</option>
			</select>
		</div>
		</div>
	</div>
<?php if(!strcmp($cfg["mem"]["EMailReceive"],"checked")):?>	
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">정기소식메일</label>
		<div class="col-lg-10">
			<input name="mailreceive" type="radio" value="1">
                    수신 
                    <input type="radio" name="mailreceive" value="0">
                    수신하지 않음
		</div>
	</div>
<?php endif;?>
<? if(!strcmp($cfg["mem"]["ERecID"],"checked")):?>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">추천인 ID</label>
		<div class="col-lg-10">
			<input name="recid" type="text" class="form-control" value="" > 
		</div>
	</div>
<?endif;?>
<div class="btn_box">
		<span class="btn_confirm btn btn-success"><a>확인</a></span>
		<span class="btn_cancel btn btn-success"><a>취소</a></span>
	</div>	
</form>
