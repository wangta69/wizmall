<?
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
/*
////////////////////////////////////////////////////////////////////////////////
function MemberCheckField()
{
var f=document.FrmUserInfo;

	if (f.ppasswd.value.length=="") {
	alert("비밀번호를 넣어주세요");
	f.ppasswd.focus();
	return false;
	}
	
	if (f.passwd.value && f.passwd.value.length < 4) {
	alert("비밀번호는 4자 이상이어야 합니다. ");
	f.passwd.focus();
	return false;
	}
	
	if (f.passwd.value && (f.passwd.value) != (f.cpasswd.value)) {
	alert("비밀번호재확인을 정확히 입력해 주세요. ");
	f.cpasswd.focus();
	return false;
	}

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

return true;
}
*/

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
<?
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
<div class="navy">Home &gt; 회원정보변경</div>
<fieldset class="desc">
<legend>[안내]</legend>
<div class="notice">회원정보변경</div>
<div class="comment">
회원정보를 수정하는 란입니다.<br />
아래의 내용중 수정을 원하시는 부분을 입력하신 후 <span class="orange">[확인]</span>단추를 누르세요</div>
</fieldset>

			 <form name="FrmUserInfo" id="FrmUserInfo" method="post" action="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/MEMBER_MODIFYQUERY.php">
			<table class="table_main w100p">
                <tr> 
                  <th>* 회원 ID </th>
                  <td> 
                    <?=$mid?>
                    <input type="hidden" name="id" value="<?=$mid?>">                    </td>
                </tr>
                <tr> 
                  <th>현재 비밀번호</th>
                  <td> <input name="ppasswd" type="password" class="required" msg="현재 비밀 번호를 입력해주세요" >                  </td>
                </tr>
                <tr> 
                  <th>새 비밀번호</th>
                  <td> <input name="passwd" type="password" id="passwd" ></td>
                </tr>
                <tr> 
                  <th>비밀번호 확인</th>
                  <td> <input name="cpasswd" type="password" id="cpasswd" >                  </td>
                </tr>
                <tr> 
                  <th>* 이름</th>
                  <td> 
                    <?=$list[mname]?>
                    <input name="name" type="hidden" id="name" value="<?=$list[mname]?>">                  </td>
                </tr>
                <?if(!strcmp($cfg["mem"]["ESex"],"checked")):?>
                <tr> 
                  <th>성 별</th>
                  <td> <input name="gender" type="radio" value="1" <?if(!strcmp($list[gender], "1")) echo"checked";?>>
                    남자 &nbsp; <input type="radio" name="gender" value="2" <?if(!strcmp($list[gender], "2")) echo"checked";?>>
                    여자</td>
                </tr>
                <? endif; ?>
                <tr> 
                  <th>* 주민등록번호</th>
                  <td> 
                    <?=$list[jumin1]?>
                    - 
                    <?=$list[jumin2]?><input type="hidden" name="jumin1" value="<?=$list[jumin1]?>">
					<input type="hidden" name="jumin2" value="<?=$list[jumin2]?>">                  </td>
                </tr>
<? if(!strcmp($PasswordHintEnable,"checked")):?>				
                <tr>
                  <th>* 비밀번호 
                        분실시 질문</th>
                  <td align='left'><select name="pwdhint" class=select id="pwdhint">
                          <option value=''>선택하십시오.</option>
<?
reset($PasswordHintArr);
while(list($key, $value) = each($PasswordHintArr)):
	$selected = ($list["pwdhint"] == $value)?" selected":"";
	echo "<option value='$value'$selected>$value</option>\n";
endwhile;
?></select>                  </td>
                </tr>
                <tr>
                  <th>* 비밀번호 
                        분실시 답변</th>
                  <td align='left'><input name="pwdanswer" type="text" id="pwdanswer" value="<?=$list[pwdanswer]?>" >                  </td>
                </tr>	
<? endif;?>				
                <?if(!strcmp($cfg["mem"]["EBirthDay"],"checked")):?>
                <tr> 
                  <th>생년월일</th>
                  <td> <select name="birthyy" id="birthyy">
				  <option value=''>년도</option>
                      <?
for($i=1950; $i<date("Y"); $i++){
$selected = $birthdate[0] == $i ? "selected":"";
echo "<option value='$i' $selected>$i</option>\n";
}
?>
                    </select>
                    년
<select name="birthmm" id="birthmm">
				  <option value=''>월</option>
                      <?
for($i=1; $i<13; $i++){
$selected = $birthdate[1] == $i ? "selected":"";
echo "<option value='$i' $selected>$i</option>\n";
}
?>
                    </select>
                    월
<select name="birthdd" id="birthdd">
				  <option value=''>일</option>
                      <?
for($i=1; $i<32; $i++){
$selected = $birthdate[2] == $i ? "selected":"";
echo "<option value='$i' $selected>$i</option>\n";
}
?>
                    </select>					

                    일&nbsp;&nbsp;&nbsp; <input type="radio" name="birthtype" value="0" <?if(!strcmp($list["birthtype"], "0")) echo"checked";?>>
                    양력 
                    <input type="radio" name="birthtype" value="1" <?if(!strcmp($list["birthtype"], "1")) echo"checked";?>>
                    음력 </td>
                </tr>
                <? endif;?>
                <?if(!strcmp($cfg["mem"]["EMarrStatus"],"checked")):?>
                <tr> 
                  <th>결혼여부</th>
                  <td><select name="marryy" id="marryy">
				  <option value=''>년도</option>
                      <?
for($i=1950; $i<date("Y"); $i++){
$selected = $marrdate[0] == $i ? "selected":"";
echo "<option value='$i' $selected>$i</option>\n";
}
?>
                    </select>
                    년
<select name="marrmm" id="marrmm">
				  <option value=''>월</option>
                      <?
for($i=1; $i<13; $i++){
$selected = $marrdate[1] == $i ? "selected":"";
echo "<option value='$i' $selected>$i</option>\n";
}
?>
                    </select>
                    월
<select name="marrdd" id="marrdd">
				  <option value=''>일</option>
                      <?
for($i=1; $i<32; $i++){
$selected = $marrdate[2] == $i ? "selected":"";
echo "<option value='$i' $selected>$i</option>\n";
}
?>
                    </select>					

                    일&nbsp;&nbsp;&nbsp; <input type="radio" name="marrstatus" value="미혼" <?if(!strcmp($list["marrstatus"], "미혼")) echo"checked";?>>
                    미혼 
                    <input type="radio" name="marrstatus" value="기혼" <?if(!strcmp($list["marrstatus"], "기혼")) echo"checked";?>>
                    기혼 </td>
                </tr>
                <? endif;?>
                <?if(!strcmp($cfg["mem"]["EJob"],"checked")):?>
                <tr> 
                  <th>직업</th>
                  <td> <select name="job" id="job">
<?
reset($JobArr);
foreach($JobArr as $key=>$value){
$selected = $list["job"] == $key ? "selected":""; 
echo "<option value='$key' $selected>$value</option>\n";
}
?>
                   </select> </td>
                </tr>
                <? endif;?>
                <?if(!strcmp($cfg["mem"]["EScholarship"],"checked")):?>
                <tr> 
                  <th>학력</th>
                  <td> <select name="scholarship" id="scholarship">
<?
reset($ScholarshipArr);
foreach($ScholarshipArr as $key=>$value){
$selected = $list["scholarship"] == $key ? "selected":"";
echo "<option value='$key' $selected>$value</option>\n";
}
?>
                    </select> </td>
                </tr>
                <? endif;?>
                <?if (!strcmp($cfg["mem"]["ECompany"],"checked")):?>
                <tr> 
                  <th>회사명</th>
                  <td> <input name="company" type="text" id="company" value="<?=$list[company]?>" >                  </td>
                </tr>
                <? endif;?>
                <?if(!strcmp($cfg["mem"]["ECompnum"],"checked")):?>
                <tr> 
                  <th>사업자등록번호</th>
                  <td> 
                    <?=$companynum[0]?>
                    - 
                    <?=$companynum[1]?>
                    - 
                    <?=$companynum[2]?>                  </td>
                </tr>
                <? endif;?>
                <tr> 
                  <th>자택주소</th>
                  <td> <input name="zip1_1" type="text" id="zip1_1" value="<?=$zip1[0]?>" maxlength="3" readonly="readonly" class="w30" />
                    - 
                    <input name="zip1_2" type="text" id="zip1_2" value="<?=$zip1[1]?>" maxlength="3" readonly="readonly" class="w30" /> 
                    <img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_post.gif" width="91" onClick="javascript:OpenZipcode()" style="cursor:pointer";> 
                    <br /> <input name=address1 type="text" id="address1" value="<?=$list[address1]?>" readonly="readonly" class="w300" /> 
                    <br /> <input name=address2 type="text" id="address2" value="<?=$list[address2]?>" class="w300" />
                    (상세주소)</td>
                </tr>
                <?if(!strcmp($cfg["mem"]["EAddress3"],"checked")):?>
                <tr> 
                  <th>직장주소</th>
                  <td> <input name="zip2_1" type="text" id="zip2_1" value="<?=$zip2[0]?>" maxlength="3" readonly="readonly" class="w30" />
                    - 
                    <input name="zip2_2" type="text" id="zip2_2" value="<?=$zip2[1]?>" maxlength="3" readonly="readonly" class="w30" /> 
                    <img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_post.gif" width="91" onClick="javascript:OpenZipcode1()" style="cursor:pointer";> 
                    <br /> <input name=address3 type="text" id="address3" value="<?=$list[address3]?>" readonly="readonly" class="w300" /> 
                    <br /> <input name=address4 type="text" id="address4" value="<?=$list[address4]?>" class="w300" />
                    (상세주소)</td>
                </tr>
                <?endif;?>
                <tr> 
                  <th>* 
                    전화번호</th>
                  <td> <select name="tel1_1" id="telephone1">
		  <? 
		  foreach($PhoneArr2 as $key=>$val){
				$selected = $tel1[0] == $key ? " selected":"";
				echo "<option".$selected.">".$key."</option>\n";
			}
		?>
          </select>
                    - 
                    <input name="tel1_2" type="text" value="<?=$tel1[1]?>" maxlength=4 class="w50" />
                    - 
                    <input name="tel1_3" type="text" value="<?=$tel1[2]?>" maxlength=4 class="w50" />                  </td>
                </tr>
                <?if(!strcmp($cfg["mem"]["ETel2"],"checked")):?>
                <tr> 
                  <th>이동전화</th>
                  <td> <select name="tel2_1" id="select2">
		  <? 
		  foreach($PhoneArr1 as $key=>$val){
			  $selected = $tel2[0] == $key ? " selected":"";
				echo "<option".$selected.">".$key."</option>\n";
			}
		?>

          </select>
                    - 
                    <input name="tel2_2" type="text" value="<?=$tel2[1]?>" maxlength=4 class="w50" />
                    - 
                    <input name="tel2_3" type="text" value="<?=$tel2[2]?>" maxlength=4 class="w50" />                  </td>
                </tr>
                <? endif;?>
                <tr> 
                  <th>* 
                    전자우편</th>
                  <td><input name=email_1 type="text" id="email_1" value="<?=$email[0]?>" >
                    @
                      <input name=email_2 type="text" id="email_2" value="<?=$email[1]?>" />
                    <select name="tmpmail" onChange="email_chk(this)">
                      <option value=''>선택해주세요</option>
<?
reset($MailArr);
foreach($MailArr as $key=>$value){
	if($email[1] == $value) $status = "on";
	$selected = $email[1] == $value ? "selected":"";
	echo "<option value='$value' $selected>$value</option>\n";
}
?>
                      <option value='etc' <? if($status <> "on") echo "selected"; ?>>기타</option>
                    </select></td>
                </tr>
                <?if(!strcmp($cfg["mem"]["EMailReceive"],"checked")):?>
                <tr> 
                  <th>정기소식메일</th>
                  <td> <input name="mailreceive" type="radio" value="1" <?if(!strcmp($list[mailreceive], "1")) echo"checked";?>>
                    수신 
                    <input type="radio" name="mailreceive" value="0" <?if(!strcmp($list[mailreceive], "0")) echo"checked";?>>
                    수신하지 않음</td>
                </tr>
                <? endif;?>
            </table>

<div class="btn_box">
	<span class="btn_confirm button bull"><a>확인</a></span>
	<span class="btn_cancel button bull"><a>취소</a></span>
</div>			
			</form>
