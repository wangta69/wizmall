<?php
/*
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
$mid = $cfg["member"]["mid"];

if(!$cfg["member"]){
	echo "<script>alert('로그인후 이용해주시기 바랍니다.');history.go(-1)'</script>";
	exit;
}

?>
<script language=javascript src="./js/jquery.plugins/jquery.validator-1.0.1.js"></script>
<script language=javascript>
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
/*  실제 유효  */
/////////////////////////////////////////////////////////////////////////////////
function OpenZipcode(){
window.open("./util/zipcode/zipcode.php?form=FrmUserInfo&zip1=zip1_1&zip2=zip1_2&firstaddress=address1&secondaddress=address2","ZipWin","width=490,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no");
}
function OpenZipcode1(){
window.open("./util/zipcode/zipcode.php?form=FrmUserInfo&zip1=zip2_1&zip2=zip2_2&firstaddress=address3&secondaddress=address4","ZipWin","width=490,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no");
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
</script>
<?php
$sqlstr = "select m.*, i.* from wizMembers m left join wizMembers_ind i on m.mid = i.id where m.mid = '".$mid."'";
$dbcon->_query($sqlstr);
$list		= $dbcon->_fetch_array();
$zip1		= explode("-", $list["zip1"]);
$zip2		= explode("-", $list["zip2"]);
$tel1		= explode("-", $list["tel1"]);
$tel2		= explode("-", $list["tel2"]);
$fax		= explode("-", $list["fax"]);
$companynum	= explode("-", $list["companynum"]);
$birthdate	= explode("/", $list["birthdate"]);
$marrdate	= explode("/", $list["marrdate"]);
$email		= explode("@", $list["email"]);
?>
<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active">회원정보변경</li>
</ul>
<div class="panel">
	회원정보변경
	<div class="panel-footer">
		회원정보를 수정하는 란입니다.<br />
아래의 내용중 수정을 원하시는 부분을 입력하신 후 <span class="orange">[확인]</span>단추를 누르세요
	</div>
</div>


<form name="FrmUserInfo" id="FrmUserInfo" method="post" action="./wizmember/<?php echo $cfg["skin"]["MemberSkin"]?>/MEMBER_MODIFYQUERY.php" class="form-horizontal" role="form">
	
	<input type="hidden" name="id" value="<?php echo $mid?>" /> 
	<input name="name" type="hidden" id="name" value="<?php echo $list["mname"]?>" />  
	<input type="hidden" name="jumin1" value="<?php echo $list["jumin1"]?>" />
	<input type="hidden" name="jumin2" value="<?php echo $list["jumin2"]?>" />
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">* 회원 ID</label>
		<div class="col-lg-10">
			<p class="form-control-static"><?php echo $mid?></p>
		</div>
	</div>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">현재 비밀번호</label>
		<div class="col-lg-10">
			<input name="ppasswd" type="password" class="required form-control" placeholder="현재 비밀 번호를 입력해주세요" msg="현재 비밀 번호를 입력해주세요" > 
		</div> 
	</div>
	<div class="form-group">
		<label for="passwd" class="col-lg-2 control-label">새 비밀번호</label>
		<div class="col-lg-10">
			<input name="passwd" type="password" id="passwd" class="form-control" >
		</div>
	</div>
	<div class="form-group">
		<label for="cpasswd" class="col-lg-2 control-label">비밀번호 확인</label>
		<div class="col-lg-10">
			<input name="cpasswd" type="password" id="cpasswd" class="form-control" >
		</div>
	</div>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">* 이름</label>
		<div class="col-lg-10">
			<p class="form-control-static">
			 	<?php echo $list["mname"]?>
			 </p>
		</div>
	</div>
<?php if(!strcmp($cfg["mem"]["ESex"],"checked")):?>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">성 별</label>
		<div class="col-lg-10">
			<div class="radio-inline">
				<label>
					<input type="radio" name="gender" value="1" <?php if(!strcmp($list["gender"], "1")) echo"checked";?> /> 남자 
				</label>
			</div>
			<div class="radio-inline">
				<label>
					<input type="radio" name="gender" value="2" <?php if(!strcmp($list["gender"], "2")) echo"checked";?> /> 여자
				</label>
			</div>
		</div>
	</div>
<?php endif; ?>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">생년월일</label>
		<div class="col-lg-2">
			<select name="birthyy" id="birthyy" class="form-control">
				<option value=''>년도</option>
<?php 
	for($i=1950; $i<date("Y"); $i++){
		$selected = $birthdate[0] == $i ? "selected":"";
		echo "<option value='".$i."' ".$selected.">".$i."년</option>\n";
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
		echo "<option value='".str_pad($i, 2, "0", STR_PAD_LEFT)."' ".$selected.">".str_pad($i, 2, "0", STR_PAD_LEFT)."월</option>\n";
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
		echo "<option value='".str_pad($i, 2, "0", STR_PAD_LEFT)."' ".$selected.">".str_pad($i, 2, "0", STR_PAD_LEFT)."일</option>\n";
	}
?>
			</select>
		</div>
		<div class="col-lg-2">
			<div class="radio-inline">
				<label>
					<input type="radio" name="birthtype" value="0" <?php if(!strcmp($list["birthtype"], "0")) echo"checked";?>> 양력 
				</label>
			</div>
			<div class="radio-inline">
				<label>
                	<input type="radio" name="birthtype" value="1" <?php if(!strcmp($list["birthtype"], "1")) echo"checked";?>> 음력
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
		$selected = $marrdate[0] == $i ? "selected":"";
		echo "<option value='".$i."' ".$selected.">".$i."</option>\n";
	}
?>
			</select>년
			<select name="marrmm" id="marrmm">
				  <option value=''>월</option>
<?php 
	for($i=1; $i<13; $i++){
		$selected = $marrdate[1] == $i ? "selected":"";
		echo "<option value='".$i."' ".$selected.">".$i."</option>\n";
	}
?>
			</select>월
			<select name="marrdd" id="marrdd">
				  <option value=''>일</option>
<?php 
	for($i=1; $i<32; $i++){
		$selected = $marrdate[2] == $i ? "selected":"";
		echo "<option value='".$i."' ".$selected.">".$i."</option>\n";
	}
?>
			</select>일
			<div class="radio-inline">
				<label>
					<input type="radio" name="marrstatus" value="0" <?php if(!strcmp($list["marrstatus"], "0")) echo"checked";?>> 미혼 
				</label>
			</div>
			<div class="radio-inline">
				<label>
                    <input type="radio" name="marrstatus" value="1" <?php if(!strcmp($list["marrstatus"], "1")) echo"checked";?>> 기혼
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
		$selected = $list["job"] == $key ? "selected":""; 
		echo "<option value='".$key."' ".$selected.">".$value."</option>\n";
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
		$selected = $list["scholarship"] == $key ? "selected":"";
		echo "<option value='".$key."' ".$selected.">".$value."</option>\n";
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
			<input name="company" type="text" id="company" class="form-control" value="<?php echo $list["company"]?>" > 
		</div>
	</div>
<?php endif;?>
<?php if(!strcmp($cfg["mem"]["ECompnum"],"checked")):?>	
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">사업자등록번호</label>
		<div class="col-lg-10">
			<?php echo $companynum[0]?> - <?php echo $companynum[1]?> - <?php echo $companynum[2]?> 
		</div>
	</div>
<?php endif;?>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">자택주소</label>
		<div class="col-lg-10">
			<div class="col-lg-2 padlzero">
				<input name="zip1_1" type="text" id="zip1_1" value="<?php echo $zip1[0]?>" maxlength="3" readonly="readonly" class="form-control" />
			</div>
            <div style="display: inline-block; float:left">-</div>
            <div class="col-lg-2">
            	<input name="zip1_2" type="text" id="zip1_2" value="<?php echo $zip1[1]?>" maxlength="3" readonly="readonly" class="form-control" /> 
            </div>
            <button type="button" class="btn btn-default" onClick="javascript:OpenZipcode()">우편번호찾기</button>
            <p><br/><input name=address1 type="text" id="address1" value="<?php echo $list["address1"]?>" readonly="readonly" class="form-control"/></p>
            <p><input name=address2 type="text" id="address2" value="<?php echo $list["address2"]?>" class="form-control" /></p>
                    (상세주소)
		</div>
	</div>
<?php if(!strcmp($cfg["mem"]["EAddress3"],"checked")):?>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">직장주소</label>
		<div class="col-lg-10">
			<input name="zip2_1" type="text" id="zip2_1" value="<?=$zip2[0]?>" maxlength="3" readonly="readonly"/>
                    - 
            <input name="zip2_2" type="text" id="zip2_2" value="<?=$zip2[1]?>" maxlength="3" readonly="readonly"/> 
            <button type="button" class="btn btn-default" onClick="javascript:OpenZipcode1()">우편번호찾기</button>
            <br /> <input name=address3 type="text" id="address3" value="<?php echo $list["address3"]?>" readonly="readonly" class="form-control"/> 
            <br /> <input name=address4 type="text" id="address4" value="<?php echo $list["address4"]?>" class="form-control" />
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
		$selected = $tel1[0] == $key ? " selected":"";
		echo "<option".$selected.">".$key."</option>\n";
	}
?>
         		</select>
        	</div>
			<div style="display: inline-block; float:left">-</div>
			<div class="col-lg-2">
				<input name="tel1_2" type="text" value="<?php echo $tel1[1]?>" maxlength="4" class="form-control" />
			</div>
			 <div style="display: inline-block; float:left">-</div>
			<div class="col-lg-2">
			<input name="tel1_3" type="text" value="<?php echo $tel1[2]?>" maxlength="4" class="form-control" />
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
		echo "<option".$selected.">".$key."</option>\n";
	}
?>
	
				</select>
			</div>
			<div style="display: inline-block; float:left">-</div>
			<div class="col-lg-2">
				<input name="tel2_2" type="text" value="<?php echo $tel2[1]?>"  class="form-control" data-format="dddd-dddd"/>
			</div> 
			<div style="display: inline-block; float:left">-</div>
			<div class="col-lg-2">
				<input name="tel2_3" type="text" value="<?php echo $tel2[2]?>" class="form-control"/> 
			</div>
                    
		</div>
	</div>
<?php endif;?>	
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">* 
                    전자우편</label>
		<div class="col-lg-10">
			<div class="col-lg-3 padlzero">
				<input name=email_1 type="text" id="email_1" value="<?php echo $email[0]?>" class="form-control">
			</div>
			<div style="display: inline-block; float:left">@</div>
			<div class="col-lg-3">
				<input name=email_2 type="text" id="email_2" value="<?php echo $email[1]?>" class="form-control" />
			</div>
			<div class="col-lg-3">
				<select name="tmpmail" onChange="email_chk(this)" class="form-control">
					<option value=''>선택해주세요</option>
<?php 
	reset($MailArr);
	foreach($MailArr as $key=>$value){
		if($email[1] == $value) $status = "on";
		$selected = $email[1] == $value ? "selected":"";
		echo "<option value='".$value."' ".$selected.">".$value."</option>\n";
	}
?>
				<option value='etc' <?php if($status <> "on") echo "selected"; ?>>기타</option>
			</select>
		</div>
		</div>
	</div>
<?php if(!strcmp($cfg["mem"]["EMailReceive"],"checked")):?>	
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">정기소식메일</label>
		<div class="col-lg-10">
			<input name="mailreceive" type="radio" value="1" <?php if(!strcmp($list["mailreceive"], "1")) echo"checked";?>>
                    수신 
                    <input type="radio" name="mailreceive" value="0" <?php if(!strcmp($list["mailreceive"], "0")) echo"checked";?>>
                    수신하지 않음
		</div>
	</div>
<?php endif;?>
	<div class="btn_box">
		<span class="btn_confirm button bull"><a>확인</a></span>
		<span class="btn_cancel button bull"><a>취소</a></span>
	</div>			
</form>
