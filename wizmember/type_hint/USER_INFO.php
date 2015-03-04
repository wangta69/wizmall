<?
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
다양한 리스트 추가  - 2003. 08.15
*/
?>
<script language=javascript src="./js/wizmall.js"></script>
<script language=javascript>
/*  실제 유효  */
/////////////////////////////////////////////////////////////////////////////////
function OpenZipcode(){
window.open("./util/zipcode/zipcode.php?form=FrmUserInfo&zip1=Zip1_1&zip2=Zip1_2&firstaddress=Address1&secondaddress=Address2","ZipWin","width=490,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no");
}
function OpenZipcode1(){
window.open("./util/zipcode/zipcode.php?form=FrmUserInfo&zip1=Zip2_1&zip2=Zip2_2&firstaddress=Address3&secondaddress=Address4","ZipWin","width=490,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no");
}

////////////////////////////////////////////////////////////////////////////////
function MemberCheckField()
{
var f=document.FrmUserInfo;

	if (f.PresentPWD.value.length=="") {
	alert("비밀번호를 넣어주세요");
	f.PresentPWD.focus();
	return false;
	}
	
	if (f.PWD.value && f.PWD.value.length < 4) {
	alert("비밀번호는 4자 이상이어야 합니다. ");
	f.PWD.focus();
	return false;
	}
	
	if (f.PWD.value && (f.PWD.value) != (f.CPWD.value)) {
	alert("비밀번호재확인을 정확히 입력해 주세요. ");
	f.CPWD.focus();
	return false;
	}

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

return true;
}
////////////////////////////////////////////////////////////////////////////////
function CompanyCheckField()
{
var f=document.FrmUserInfo;
	if (f.PresentPWD.value.length=="") {
	alert("비밀번호를 넣어주세요");
	f.PresentPWD.focus();
	return false;
	}
	
	if (f.PWD.value && f.PWD.value.length < 4) {
	alert("비밀번호는 4자 이상이어야 합니다. ");
	f.PWD.focus();
	return false;
	}
	
	if (f.PWD.value && (f.PWD.value) != (f.CPWD.value)) {
	alert("비밀번호재확인을 정확히 입력해 주세요. ");
	f.CPWD.focus();
	return false;
	}
	
	if ((f.Name.value.length < 2) || (f.Name.value.length > 5)) {
	alert("담당자명을 정확히 적어주십시오.");
	f.Name.focus();
	return false;
	}
	
	if (f.Email.value.length < 3) {
	alert("E-mail 주소가 부정확합니다. 확인해 주십시오");
	f.Email.focus();
	return false;
	}
	
	if  (f.address.value.length < 5) {
	alert("주소를 정확히 입력해 주세요.");
	f.address.focus();
	return false;
	}  
	if  (f.MoreAdd.value.length < 2) {
	alert("번지수/통/반을 정확히 입력해 주세요.[예:123번지] ");
	f.MoreAdd.focus();
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
</script>
<?
$sqlstr = "select * from wizMembers where ID = '$_COOKIE[MEMBER_ID]'";
$dbcon->_query($sqlstr);
$List = $dbcon->_fetch_array();
$Zip1 = split("\-", $List[Zip1]);
$Zip2 = split("\-", $List[Zip2]);
$Tel1 = split("\-", $List[Tel1]);
$Tel2 = split("\-", $List[Tel2]);
$Fax = split("\-", $List[Fax]);
$Compnum = split("\-", $List[Compnum]);
$BirthDay = split("\/", $List[BirthDay]);
$MarrDate = split("\/", $List[MarrDate]);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="68" valign="top"><table width="670" height="68" border="0" cellpadding="0" cellspacing="0" background="/images/main/bg_tit.gif">
        <tr> 
          <td width="258"><img src="/images/member/tit_join.gif"></td>
          <td width="412" align="right">home &gt; 정보수정</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td valign="top" style="padding-left:30px; padding-right:30px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
       <FORM name="FrmUserInfo" method="post" OnSubmit="return MemberCheckField();" action="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/MEMBER_MODIFYQUERY.php">
          <tr> 
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td align="center"> <table width="100%" border="0" cellpadding="5" cellspacing="0">
                      <tr> 
                        <td height="2" colspan="2" bgcolor="#bbbbbb"></td>
                      </tr>
                      <tr> 
                        <td width="134" height="20" bgcolor="#fafafa" style="padding-left:10px">아이디</td>
                        <td width="483" style="padding-left:10px; padding-top:5px"> 
                          <?=$_COOKIE[MEMBER_ID]?>
                          <input type="hidden" name="ID" value="<?=$_COOKIE[MEMBER_ID]?>"> 
                        </td>
                      </tr>
                      <tr> 
                        <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                      </tr>
                      <tr> 
                        <td width="134" bgcolor="#fafafa" style="padding-left:10px">현재비밀번호</td>
                        <td style="padding-left:10px"> <p> 
                            <input name="PresentPWD" type="password" id="PresentPWD">
                          </p></td>
                      </tr>
                      <tr> 
                        <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                      </tr>
                      <tr> 
                        <td width="134" bgcolor="#fafafa" style="padding-left:10px">새비밀번호</td>
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
                        <td style="padding-left:10px">
                          <?=$List[Name]?>
                          <input type="hidden" name="UserName" value="<?=$List[UserName]?>"></td>
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
	$selected = ($List[PWDHint] == "$value")?" selecte":"";
	echo "<option value='$value'$selected>$value</option>\n";
endwhile;
?>
                            <option value='나의 보물 1호는?'>나의 보물 1호는? 
                            <option value='할아버님 성함은?'>할아버님 성함은? 
                            <option value='할머님 성함은?'>할머님 성함은? 
                            <option value='아버님 성함은'>아버님 성함은 
                            <option value='어머님 성함은?'>어머님 성함은? 
                            <option value='초등학교 6학년때 은사님 성함은?'>초등학교 6학년때 은사님 성함은? 
                            <option value='제일 가보고 싶은 나라는?'>제일 가보고 싶은 나라는? 
                            <option value='제일 좋아하는 색깔은?사랑하는 사람은? '>제일 좋아하는 색깔은?사랑하는 
                            사람은? 
                            <option value=' 여자친구이름은?'> 여자친구이름은? 
                            <option value=' 남자친구이름은?'> 남자친구이름은? </select> </td>
                      </tr>
                      <tr> 
                        <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                      </tr>
                      <tr> 
                        <td width="134" bgcolor="#fafafa" style="padding-left:10px">비밀번호 
                          분실시 답변</td>
                        <td style="padding-left:10px"> <p> 
                            <input name="PWDAnswer" type="text" value="<?=$List[PWDAnswer]?>">
                          </p></td>
                      </tr>
                      <tr> 
                        <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                      </tr>
                      <tr> 
                        <td width="134" bgcolor="#fafafa" style="padding-left:10px">E-mail<br></td>
                        <td style="padding-left:10px"> <p> 
                            <input name="Email" type="text" id="Email" value="<?=$List[Email]?>">
                            한메일을 제외한 E-mail을 입력. </p></td>
                      </tr>
                      <tr> 
                        <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                      </tr>
                      <!--<tr> 
                        <td width="134" bgcolor="#fafafa" style="padding-left:10px">주민등록번호<br></td>
                        <td style="padding-left:10px"><?=$List[Jumin1]?>
                    - 
                    <?=$List[Jumin2]?>
</td>
                      </tr>
                      <tr> 
                        <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                      </tr>-->
                      <tr> 
                        <td width="134" bgcolor="#fafafa" style="padding-left:10px">연락처<br></td>
                        <td style="padding-left:10px"> <p> 
                            <input name="Tel1_1" type="text" id="Tel1_1" value="<?=$Tel1[0]?>" size="4">
                            - 
                            <input name="Tel1_2" type="text" id="Tel1_2" value="<?=$Tel1[1]?>" size="4">
                            - 
                            <input name="Tel1_3" type="text" id="Tel1_3" value="<?=$Tel1[2]?>" size="4">
                            (예:02-123-1234) 실제 연락가능한 연락처를 입력. </p></td>
                      </tr>
                      <tr> 
                        <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                      </tr>
                      <tr> 
                        <td width="134" bgcolor="#fafafa" style="padding-left:10px">휴대전화</td>
                        <td style="padding-left:10px"> <p> 
                            <input name="Tel2_1" type="text" id="Tel2_1" value="<?=$Tel2[0]?>" size="4">
                            - 
                            <input name="Tel2_2" type="text" id="Tel2_2" value="<?=$Tel2[1]?>" size="4">
                            - 
                            <input name="Tel2_3" type="text" id="Tel2_3" value="<?=$Tel2[2]?>" size="4">
                            (예:010-123-1234) 실제 연락가능한 휴대전화번호를 입력. </p></td>
                      </tr>
                      <tr> 
                        <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                      </tr>
                      <tr> 
                        <td width="134" rowspan="2" bgcolor="#fafafa" style="padding-left:10px">주소입력</td>
                        <td style="padding-left:10px"> <p> 
                            <input name="Zip1_1" type="text" id="Zip1_1" value="<?=$Zip1[0]?>" size="4">
                            - 
                            <input name="Zip1_2" type="text" id="Zip1_2" value="<?=$Zip1[1]?>" size="4">
                            <a href="javascript:OpenZipcode()"><img src="images/common/button/btn_post.gif" width="100" height="19" hspace="5" border="0" align="absmiddle"></a> 
                          </p></td>
                      </tr>
                      <tr> 
                        <td style="padding-left:10px"><input name="Address1" type="text" id="Address1" value="<?=$List[Address1]?>" size="50"> 
                          <br> <input name="Address2" type="text" id="Address2" value="<?=$List[Address2]?>" size="50"> 
                        </td>
                      </tr>
                      <tr> 
                        <td height="1" colspan="2" bgcolor="#eeeeee"></td>
                      </tr>
                      <tr> 
                        <td width="134" bgcolor="#fafafa" style="padding-left:10px">E-mail수신여부</td>
                        <td style="padding-left:10px"> <p> 
                            <input name="MailReceive" type="checkbox" id="MailReceive" style="border:0" value="1" <? if(!strcmp($List[MailReceive], "1")) echo"checked";?>>
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
          </tr>
        </form>
      </table></td>
  </tr>
</table>
