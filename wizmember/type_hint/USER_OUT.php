<?
/*
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
전체적인 폼 교정  - 2003. 08.15
*/
if($mode=="ok"){
	$sqlstr="SELECT UID FROM wizMembers WHERE ID='$_COOKIE[MEMBER_ID]' AND PWD='$UserPass'";
	$result=$dbcon->get_one($sqlstr);
	if(!$result) {ECHO"<script>window.alert('\\n\\n일치하는 데이타를 찾지 못했습니다.\\n\\n 다시 한 번 책크해주세요\\n'); 
	location.replace('./wizmember.php?query=out'); </script>";
	exit;
	}else{
	$sqlstr = "UPDATE wizMembers SET GrantSta ='00' WHERE ID ='$_COOKIE[MEMBER_ID]' "; 
    $result1= $dbcon->_query($sqlstr);
	$sqlstr = "UPDATE wizMembersMore SET MType ='$contents' WHERE MID ='$_COOKIE[MEMBER_ID]' "; 
    $result1= $dbcon->_query($sqlstr);	
	 ECHO"<script>window.alert('\\n 탈퇴가 신청되었습니다.\\n 빠른 처리를 하겠습니다.\\n');             
	 location.replace('./'); </script>";
	exit;
	}
}
?>

<script language = "javascript">
function MemberCheckField(){

var f=document.FrmUserInfo;
	if  (f.UserPass.value.length =="") {
	alert("패스워드를 입력해주세요");
	f.UserPass.focus();
	return false;
	} else if (confirm('\n입력하신 모든 값들이 정말로 정확합니까?\n')) return true;
        return false;

}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><table width="608" height="18" border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#F6F6F6"> 
          <td width="15" height="22" class="company">&nbsp;</td>
          <td width="18" height="22" valign="middle"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/sn_arrow.gif" width="13" height="13"></td>
          <td width="576" height="22" class="company">Home &gt; 회원탈퇴</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="39">&nbsp;</td>
  </tr>
  <tr> 
    <td align="center"><table width="95%" border="0" cellspacing="0" cellpadding="5" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
        <tr> 
          <td bgcolor="#EEEEEE">- 회원님꼐서 탈퇴하시더라도 회원님의 개인정보는 안전하게 처리됩니다.<br>
            - 탈퇴후 아이디는 재 사용될 수 없으므로, <font color="#FF0000">동일 아이디로 재 가입하실 수 없습니다.</font><br>
              - 기 등록된 물건에 대한 회원님의 정보가 사라집니다.</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td align="center">
<table width="564" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td background="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/bg_top.gif" height="16" colspan="3"></td>
        </tr>
        <tr> 
          <td width="16" background="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/bg_left.gif">&nbsp;</td>
          <td align="center"> <table width="531" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td width="132"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_member_out02.gif" width="132" height="266"></td>
                <td><table width="399" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="399"> <br> </td>
                    </tr>
                    <tr> 
                      <td><table width="389" border="0" cellpadding="0" cellspacing="0">
                          <form method="post" name="FrmUserInfo" action="<?=$PHP_SELF?>" OnSubmit="javascript:return MemberCheckField();">
						  <input type="hidden" name="query" value="out">
                            <input type="hidden" name="mode" value="ok">
                            <tr height="1"> 
                              <td width="24"></td>
                              <td colspan="3" bgcolor="D4D0C8"></td>
                            </tr>
                            <tr> 
                              <td width="24">&nbsp;</td>
                              <td width="24"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_pass.gif" width="76" height="30"></td>
                              <td width="165" align="center" bgcolor="F2F2F2"><input name="UserPass" type="password" id="UserPass" size="17"></td>
                              <td width="176"><input name="image" type=image src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_member_out.gif" width="70" height="30"></td>
                            </tr>
                            <tr height="1"> 
                              <td width="24"></td>
                              <td colspan="3" bgcolor="D4D0C8"></td>
                            </tr>
                          </form>
                        </table>
                        <br> </td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
          <td width="16" background="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/bg_left.gif">&nbsp;</td>
        </tr>
        <tr> 
          <td background="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/bg_top.gif" height="16" colspan="3"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
