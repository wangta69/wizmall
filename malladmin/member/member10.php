<?php
$cfg["skin"]["MemberSkin"] = "BASIC";
?>
<script  language="javascript" src="../js/wizmall.js"></script>
<script>
/////////////////////////////////////////////////////////////////////////////////

function OpenZipcode(){
window.open("../util/zipcode/zipcode.php?form=FrmUserInfo&zip1=zip1_1&zip2=zip1_2&firstaddress=address1&secondaddress=address2","ZipWin","width=490,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no");
}
function OpenZipcode1(){
window.open("../util/zipcode/zipcode.php?form=FrmUserInfo&zip1=zip2_1&zip2=zip2_2&firstaddress=address3&secondaddress=address4","ZipWin","width=490,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no");
}

////////////////////////////////////////////////////////////////////////////////

function MemberCheckField(){
	var f=document.FrmUserInfo;
	if (!TypeCheck(f.id.value, ALPHA+NUM)) {
		alert("ID는 영문자 및 숫자로만 사용할 수 있습니다. ");
		f.id.focus();
		return false;
	}else if ((f.id.value.length < 4) || (f.id.value.length > 12)) {
		alert("ID는 4자 이상, 12자 이내이어야 합니다.");
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
	}else if (f.name.value=="") {
		alert("이름을 넣어주세요. ");
		f.name.focus();
		return false;		
	}else if (f.idavail.value!="1") {
	alert(f.idavail.value);
		alert("아이디 확인을 해주시기 바랍니다. ");
		f.id.focus();
		return false;		
	}else f.submit();
}

$(function(){
	$("#btn_check_dup").click(function(){
		var id = $("#id").val();
		if(id == ""){
			alert("id를 입력해 주세요");
		}else{
			$.post("../lib/ajax.member.php", {smode:"id_check",id:id}, function (data){
				if(data == "0"){
					$("#idavail").val("");
					alert("이미 사용중인 아이디 입니다.");
				}else{
					alert("사용가능한 아이디 입니다.");
					$("#idavail").val("1");
				} 
			});
		}
	});
});
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">회원가입</div>
	  <div class="panel-body">
		 수동으로 회원 가입을 하실 경우 사용하시면 됩니다.
	  </div>
	</div>
</div>
<table class="table_outline">
	<tr>
		<td>
			<div class="space20"></div>
			<form name="FrmUserInfo" method="post" action="../wizmember/<?php echo $cfg["skin"]["MemberSkin"]?>/MEMBER_REGISQUERY.php">
				<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
				<input type="hidden" name="WhereRegis" value="Admin">
				<input type="hidden" name="idavail" id="idavail" value="">
				<table class="table">
					<tr>
						<th>* 
							회원 등급 </th>
						<td colspan="3"><select name='mgrade'>
								<?
foreach($gradetostr_info as $key=>$value){ 
	$selected = $key == $List["mgrade"] ? "selected":"";
	ECHO "<option value='$key' $selected>".$value."</option>";
}
?>
							</select></td>
					</tr>
					<tr>
						<th>* 
							회원 ID </th>
						<td colspan="3"><input type="text" name="id" maxlength="9" value="" id="id" >
							<span class="button bull"><a id="btn_check_dup">중복책크</a></span></td>
					</tr>
					<tr>
						<th>* 
							비밀번호</th>
						<td colspan="3"><input type="password" name="passwd" maxlength="30" >
						</td>
					</tr>
					<tr>
						<th>* 
							비밀번호 확인</th>
						<td colspan="3"><input type="password" name="cpasswd" maxlength="30" id="cpasswd" >
						</td>
					</tr>
					<!--<tr> 
                  <td><font color="#000000">회사명/부서</td>
                  <td colspan="3"> <input type="text" name="Company" maxlength="30" value="" >                  </td>
                </tr>
                <tr> 
                  <td><font color="#000000">사업자등록번호</td>
                  <td colspan="3"> <input type="text" name="Compnum1" maxlength="3">
                    - 
                    <input type="text" name="Compnum2" maxlength="2" >
                    - 
                    <input type="text" name="Compnum3" maxlength="5" >                  </td>
                </tr>-->
					<tr>
						<th>이름</th>
						<td colspan="3"><input type="text" name="name" maxlength="30" >
						</td>
					</tr>
					<tr>
						<th>주소</th>
						<td colspan="3"><input type="text" name="zip1_1" maxlength="3" READONLY id="zip1_1" class="w30">
							-
							<input type="text" name="zip1_2" maxlength="3" READONLY id="zip1_2" class="w30">
							<img src="../wizmember/<?php echo $cfg["skin"]["MemberSkin"]?>/images/but_post.gif" width="91" onClick="javascript:OpenZipcode()" style="cursor:pointer";> <br />
							<input type=text name=address18 READONLY id="address1" class="w300">
							<br />
							<input type=text name=address28 id="address2" class="w300">
							(상세주소)</td>
					</tr>
					<tr>
						<th>전화번호</th>
						<td colspan="3"><input name="tel1_1" type="text" id="tel1_1" maxlength="4" class="w30">
							-
							<input name="tel1_2" type="text" id="tel1_2" maxlength="4" class="w30">
							-
							<input name="tel1_3" type="text" id="tel1_3" maxlength="4" class="w30">
							&nbsp;</td>
					</tr>
					<tr>
						<th>이동전화</th>
						<td colspan="3"><input type="text" name="tel2_1" maxlength="4" id="tel2_1" class="w30">
							-
							<input type="text" name="tel2_2" maxlength="4" id="tel2_2" class="w30">
							-
							<input type="text" name="tel2_3" maxlength="4" id="tel2_3" class="w30">
						</td>
					</tr>
					<tr>
						<th>전자우편</th>
						<td colspan="3"><input type="text" name="email_1" id="email_1" >
							@
							<input type="text" name="email_2" id="email_2" /></td>
					</tr>
				</table>
				<div class="btn_box">
					<input type="button" name="button2" id="button2" value="등록하기" style="cursor:pointer" onclick="MemberCheckField()" />
					<input type="button" name="button3" id="button3" value="취소하기" style="cursor:pointer" onclick="history.go(-1);" />
				</div>
			</form>
			<br /></td>
	</tr>
</table>
