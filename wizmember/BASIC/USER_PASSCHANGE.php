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
<script language=javascript>
<!--
function MemberCheckField(f){
	if (f.ppasswd.value.length=="") {
		alert("비밀번호를 넣어주세요");
		f.ppasswd.focus();
		return false;
	}else if (f.passwd.value && f.passwd.value.length < 4) {
		alert("비밀번호는 4자 이상이어야 합니다. ");
		f.passwd.focus();
		return false;
	}else if (f.passwd.value && (f.passwd.value) != (f.cpasswd.value)) {
		alert("비밀번호재확인을 정확히 입력해 주세요. ");
		f.cpasswd.focus();
		return false;
	}else return true;
}
//-->
</script>

<table>
                    <form name="FrmUserInfo" method="post" OnSubmit="return MemberCheckField(this);" action="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/MEMBER_MODIFYQUERY.php">
                      <input type="hidden" name="smode" value="chpwd" />
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><table>
                            <tr>
                              <td><p>현재 패스워드</p></td>
                              <td><input type="text" name="ppasswd" id="ppasswd"></td>
                            </tr>
                            <tr>
                              <td>신규패스워드</td>
                              <td><input type="text" name="passwd" id="passwd">
                                （4~12자）</td>
                            </tr>
                            <tr>
                              <td>패스워드확인</td>
                              <td><input type="text" name="cpasswd" id="cpasswd"></td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><input type="image" src="images/mypage/btn_pwedit.jpg" width="193"></td>
                      </tr>
                    </form>
                  </table>
