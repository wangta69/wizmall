<?
/* 
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
tabindex 코딩, mode 별(프린트 혹은 메일)로 각기 출력방식선택 기본은 Mail  - 2003. 08.15
2004. 06. 18 - alert창 대신 현재 창에 디스플레이 하는 방식으로 변경
*/

/********************************** id search 인 경우 아래를 실행한다. **************************/
if($action == 'idsearch'){
	$Compnum = $compno1."-".compno2;
	if($juminno1 && $juminno2){
	$result = $dbcon->_fetch_array($dbcon->_query( "select * from wizMembers where Name='$name' AND Jumin1='$juminno1' AND Jumin2='$juminno2'", $DB_CONNECT )); 
	}else if($compno1 && $compno2){
	$result = $dbcon->_fetch_array($dbcon->_query( "select * from wizMembers where Name='$name' AND Compnum = '$Compnum'", $DB_CONNECT )); 
	}
	
	$Email=$result[Email];	
	if ( !$result ) {
		$result_code = "0001";
		$message_idsearch = "일치하는 데이터를 찾지 못했습니다. <br> 새로 검색해 주시기 바랍니다.";
	}else if($result[GrantSta] == "00"){
		$result_code = "0002";
		$message_idsearch = "이미 탈퇴된 회원입니다.";
	}else if($mode == "mail"){
		$result_code = "0000";
		include ("./wizmember/".$cfg["skin"]["MemberSkin"]."/IDPASS_MAIL.php");
		$message_idsearch = " 아이디와 패스워드를 <font color='blue'>".$result[Email]."</font>로 발송하여 드렸습니다.";
	}else if($mode == "print"){
		$result_code = "0000";
		$message_idsearch = "고객님의 아이디는 <strong><font color='#0092B6'>".$result[ID]."</font></strong> 입니다";
	}
/********************************** pass search 인 경우 아래를 실행한다. **************************/

}else if($action == 'passsearch'){
	$Compnum = $compno1."-".compno2;
	if($juminno1 && $juminno2){
	$result = $dbcon->_fetch_array($dbcon->_query( "select * from wizMembers where ID='$id' AND Jumin1='$juminno1' AND Jumin2='$juminno2'", $DB_CONNECT )); 
	}else if($compno1 && $compno2){
	$result = $dbcon->_fetch_array($dbcon->_query( "select * from wizMembers where Name='$name' AND Compnum = '$Compnum'", $DB_CONNECT )); 
	}
	
	$Email=$result[Email];
		
	if ( !$result ) {
		$result_code = "1001";
		$message_passsearch = "일치하는 데이터를 찾지 못했습니다. <br> 새로 검색해 주시기 바랍니다.";
	}else if($mode == "mail"){
		$result_code = "1000";
		include ("./wizmember/".$cfg["skin"]["MemberSkin"]."/IDPASS_MAIL.php");
		$message_passsearch = " 아이디와 패스워드를 <font color='blue'>".$result[Email]."</font>로 발송하여 드렸습니다.";
	}else if($mode == "print"){
		$result_code = "1000";
		$message_passsearch = "고객님의 패스워드는 <strong><font color='#0092B6'>".$result[PWD]."</font></strong> 입니다";
	}
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script language="JavaScript" src="./js/wizmall.js"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><table width="100%" height="18" border="0" cellpadding="0" cellspacing="0" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
        <tr bgcolor="#F6F6F6"> 
          <td width="15" height="22" class="company">&nbsp;</td>
          <td width="18" height="22" valign="middle"><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/sn_arrow.gif" width="13" height="13"></td>
          <td height="22" bgcolor="#F6F6F6" class="company">Home &gt; 아이디 및 비밀번호 
            찾기 </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td align="center"> <table width="95%" border="0" cellspacing="0" cellpadding="5" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
        <tr> 
          <td bgcolor="#EEEEEE">- 회원님!! <font color="#89BE38">아이디 또는 비밀번호</font>를 
            잊으셨나요? 입력하신 후 [확인]단추를 누르세요</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td align="center"> <table width="95%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="center">&nbsp;</td>
        </tr>
        <tr> 
          <td align="right">&nbsp;</td>
        </tr>
        <tr> 
          <td align="center"> <table width="564" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td height="16"><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/title_id.gif" width="80" height="21"></td>
              </tr>
              <tr> 
                <td background="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/bg_top.gif" height="16"></td>
              </tr>
              <tr> 
                <td><table width="564" border="0" cellpadding="0" cellspacing="0" bgcolor="F2F2F2" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
                    <form action='<?=$PHP_SELF?>' method=post name="idsearch_form">
					 <input type="hidden" name="query" value="idpasssearch">
                      <input type=hidden name="action" value="idsearch">
                      <input type=hidden name="mode" value="print">
                      <tr> 
                        <td width="89">&nbsp;</td>
                        <td width="365"><? if($message_idsearch) echo $message_idsearch; else echo "ID(아이디)를 잊으셨나요?<br>
                          <strong><font color='#FF9900'>이름</font></strong>과 <font color='#FF9900'><strong>주민등록번호</strong></font>를 
                          입력하신 후 <font color='#FF9900'><strong>&quot;찾기</strong></font>&quot;버튼을 눌러주세요"; ?></td>
                        <td width="110">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                        <td><table width="377" border="0" cellpadding="0" cellspacing="0" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
                            <tr height="1"> 
                              <td width="82" bgcolor="BCBCBC"></td>
                              <td bgcolor="BCBCBC"></td>
                            </tr>
                            <tr> 
                              <td><font color="#006600"><strong>이름</strong></font></td>
                              <td width="282"> <input name="name" type="text" size="17" tabindex="1">
                              </td>
                            </tr>
                            <tr height="1"> 
                              <td width="82" bgcolor="BCBCBC"></td>
                              <td bgcolor="BCBCBC"></td>
                            </tr>
                            <tr> 
                              <td><font color="#006600"><strong>주민등록번호</strong></font></td>
                              <td> <input name="juminno1" type="text"tabindex="2" size="6" maxlength="6" onkeyup="moveFocus(6,this,document.idsearch_form.juminno2)" >
                                - 
                                <input name="juminno2" type="text"tabindex="3" size="7" maxlength="7"></td>
                            </tr>
                            <tr height="1"> 
                              <td width="82" bgcolor="BCBCBC"></td>
                              <td bgcolor="BCBCBC"></td>
                            </tr>
                          </table></td>
                        <td align="center"><input name="image" type=image src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_search.gif" tabindex="4"></td>
                      </tr>
                      <tr> 
                        <td height="10">&nbsp;</td>
                        <td height="10">&nbsp;</td>
                        <td height="10" align="center">&nbsp;</td>
                      </tr>
                    </form>
                  </table></td>
              </tr>
              <tr> 
                <td background="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/bg_bottom.gif" height="16"></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td align="center">&nbsp;</td>
        </tr>
        <tr> 
          <td align="center"> <table width="564" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td height="16"><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/title_pass.gif" width="91" height="20"></td>
              </tr>
              <tr> 
                <td background="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/bg_top.gif" height="16"></td>
              </tr>
              <tr> 
                <td><table width="564" border="0" cellpadding="0" cellspacing="0" bgcolor="F2F2F2" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
                    <form action='<?=$PHP_SELF?>' method=post name="passsearch_form">
					<input type="hidden" name="query" value="idpasssearch">
                      <input type=hidden name="action" value="passsearch">
                      <input type=hidden name="mode" value="mail">
                      <tr> 
                        <td width="89" height="49">&nbsp;</td>
                        <td width="365">
                          <? if($message_passsearch) echo $message_passsearch; else echo "회원님의 비밀번호를 잊으셨나요?<br>
                          <font color='#FF9900'><strong>아이디</strong></font>와 <strong><font color='#FF9900'>주민등록번호</font></strong>를 
                          입력하신 후 <strong><font color='#FF9900'>&quot;찾기&quot;</font></strong>버튼을 눌러주세요"; ?>
                        </td>
                        <td width="110">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                        <td><table width="376" border="0" cellpadding="0" cellspacing="0" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
                            <tr height="1"> 
                              <td width="82" bgcolor="BCBCBC"></td>
                              <td  bgcolor="BCBCBC"></td>
                            </tr>
                            <tr> 
                              <td><font color="#006600"><strong>아이디</strong></font></td>
                              <td width="281"> <input name="id" type="text" size="17"tabindex="5"></td>
                            </tr>
                            <tr height="1"> 
                              <td width="82"bgcolor="BCBCBC"> </td>
                              <td bgcolor="BCBCBC"> </td>
                            </tr>
                            <tr> 
                              <td><font color="#006600"><strong>주민등록번호</strong></font></td>
                              <td> <input name="juminno1" type="text" tabindex="6" size="6" maxlength="6" onkeyup="moveFocus(6,this,document.passsearch_form.juminno2)" >
                                - 
                                <input name="juminno2" type="text"tabindex="7" size="7" maxlength="7"></td>
                            </tr>
                            <tr height="1"> 
                              <td width="82"bgcolor="BCBCBC"> </td>
                              <td bgcolor="BCBCBC"> </td>
                            </tr>
                          </table></td>
                        <td align="center"><input name="image" type=image src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_search.gif" tabindex="8"></td>
                      </tr>
                      <tr> 
                        <td height="10">&nbsp;</td>
                        <td height="10">&nbsp;</td>
                        <td height="10" align="center">&nbsp;</td>
                      </tr>
                    </form>
                  </table></td>
              </tr>
              <tr> 
                <td background="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/bg_bottom.gif" height="16"></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
