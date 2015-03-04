<?
/* 
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
tabindex 코딩, mode 별(프린트 혹은 메일)로 각기 출력방식선택 기본은 Mail  - 2003. 08.15
*/

/********************************** id search 인 경우 아래를 실행한다. **************************/
if($action == 'idsearch'){
$Compnum = $compno1."-".compno2;
//echo "select * from wizMembers where Name='$name' AND Jumin1='$juminno1' AND Jumin2='$juminno2'";
if($juminno1 && $juminno2){
	$result = $dbcon->_fetch_array($dbcon->_query( "select * from wizMembers where Name='$name' AND Jumin1='$juminno1' AND Jumin2='$juminno2'", $DB_CONNECT )); 
	}else if($compno1 && $compno2){
	$result = $dbcon->_fetch_array($dbcon->_query( "select * from wizMembers where Name='$name' AND Compnum = '$Compnum'", $DB_CONNECT )); 
	}
		
	$Email=$result[Email];	
	if ( !$result ) {
		ECHO "<script language=javascript>
		window.alert(' 일치하는 데이터를 찾지 못했습니다. ');
		history.go(-1);
		</script>";
		exit;
	}else if($result[GrantSta] == "00"){
		ECHO "<script language=javascript>
		window.alert(' 이미 탈퇴된 회원입니다. ');
		history.go(-1);
		</script>";
		exit;
	}else if($mode == "mail"){
		include ("./wizmember/".$cfg["skin"]["MemberSkin"]."/IDPASS_MAIL.php");
		ECHO "<script language=javascript>
		window.alert(' 아이디와 패스워드를 $email 로 발송하여 드렸습니다. ');
		location.replace('./');
		</script>";
		exit;
	}
	else if($mode == "print"){
	?>
<table width="630" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td height="70" valign="bottom"><img src="images/title_mypage01.gif" width="630" height="48"> 
                        <table width="623" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td width="30">&nbsp;</td>
                            <td width="1"><img src="images/subtitle_line01.gif" width="1" height="29"></td>
                            <td width="80"><a href="wizmember.php?query=passsearch"><img src="images/mypage01_sub01.gif" width="79" height="29" border="0"></a></td>
                            <td width="1"><img src="images/subtitle_line01.gif" width="1" height="29"></td>
                            <td width="80"><a href="wizmember.php?query=info"><img src="images/mypage01_sub02.gif" width="79" height="29" border="0"></a></td>
                            <td width="1"><img src="images/subtitle_line01.gif" width="1" height="29"></td>
                            <td width="80"><a href="./wizmember.php?query=out"><img src="images/mypage01_sub03.gif" width="79" height="29" border="0"></a></td>
                            <td width="1"><img src="images/subtitle_line01.gif" width="1" height="29"></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr bgcolor="#CCCCCC"> 
                            <td height="2px"></td>
                            <td height="2px"></td>
                            <td height="2px"></td>
                            <td height="2px"></td>
                            <td height="2px" ></td>
                            <td height="2px"></td>
                            <td height="2px"  bgcolor="#3F58AC"></td>
                            <td height="2px"></td>
                            <td height="2px"></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr> 
                      <td><br>
                        <table width="600" border="0" align="center" cellpadding="0" cellspacing="10" background="images/pattern02.gif">
                          <tr> 
                            <td>
<table width="580" border="0" cellpadding="4" cellspacing="1" bgcolor="#DDDDDD">
                                <tr> 
                                  <td bgcolor="#FFFFFF">
<table width="570" border="0" cellspacing="0" cellpadding="0" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
                                      <tr> 
                                        <td><img src="images/mypage01_menu01.gif" width="185" height="28"></td>
                                      </tr>
                                      <tr> 
                                        <td align="center">고객님의 아이디는 <strong><font color="#0092B6"><?=$result[ID]?></font></strong> 
                                            입니다</td>
                                      </tr>
                                      <tr> 
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr> 
                                        <td height="1px" bgcolor="#dddddd"></td>
                                      </tr>
                                      <tr> 
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr> 
                                        <td><div align="center"><a href="./"><img src="images/mypage01_ic03.gif" width="61" height="21" border="0"></a></div></td>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table>
                        <br>
                      </td>
                    </tr>
                  </table>
	<?
	exit;
	}
}
?>
<?
/********************************** pass search 인 경우 아래를 실행한다. **************************/
if($action == 'passsearch'){
	include ("./config/db_info.php");
	include "../../lib/class.database.php";
	$dbcon	= new database($cfg["sql"]);


$Compnum = $compno1."-".compno2;
if($juminno1 && $juminno2){
	$result = $dbcon->_fetch_array($dbcon->_query( "select * from wizMembers where ID='$id' AND Jumin1='$juminno1' AND Jumin2='$juminno2'", $DB_CONNECT )); 
	}else if($compno1 && $compno2){
	$result = $dbcon->_fetch_array($dbcon->_query( "select * from wizMembers where Name='$name' AND Compnum = '$Compnum'", $DB_CONNECT )); 
	}
		
	$Email=$result[Email];	
	if ( !$result ) {
		ECHO "<script language=javascript>
		window.alert(' 일치하는 데이터를 찾지 못했습니다. ');
		history.go(-1);
		</script>";
		exit;
	}

	else if($mode == "mail"){
		include ("./wizmember/".$cfg["skin"]["MemberSkin"]."/IDPASS_MAIL.php");
		ECHO "<script language=javascript>
		window.alert(' 아이디와 패스워드를 $email 로 발송하여 드렸습니다. ');
		location.replace('./');
		</script>";
		exit;
	}
	else if($mode == "print"){
	?>
<table width="630" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td height="70" valign="bottom"><img src="images/title_mypage01.gif" width="630" height="48"> 
                        <table width="623" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td width="30">&nbsp;</td>
                            <td width="1"><img src="images/subtitle_line01.gif" width="1" height="29"></td>
                            <td width="80"><a href="wizmember.php?query=passsearch"><img src="images/mypage01_sub01.gif" width="79" height="29" border="0"></a></td>
                            <td width="1"><img src="images/subtitle_line01.gif" width="1" height="29"></td>
                            <td width="80"><a href="wizmember.php?query=info"><img src="images/mypage01_sub02.gif" width="79" height="29" border="0"></a></td>
                            <td width="1"><img src="images/subtitle_line01.gif" width="1" height="29"></td>
                            <td width="80"><a href="./wizmember.php?query=out"><img src="images/mypage01_sub03.gif" width="79" height="29" border="0"></a></td>
                            <td width="1"><img src="images/subtitle_line01.gif" width="1" height="29"></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr bgcolor="#CCCCCC"> 
                            <td height="2px"></td>
                            <td height="2px"></td>
                            <td height="2px"></td>
                            <td height="2px"></td>
                            <td height="2px" ></td>
                            <td height="2px"></td>
                            <td height="2px"  bgcolor="#3F58AC"></td>
                            <td height="2px"></td>
                            <td height="2px"></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr> 
                      <td><br>
                        <table width="600" border="0" align="center" cellpadding="0" cellspacing="10" background="images/pattern02.gif">
                          <tr> 
                            <td>
<table width="580" border="0" cellpadding="4" cellspacing="1" bgcolor="#DDDDDD">
                                <tr> 
                                  <td bgcolor="#FFFFFF">
<table width="570" border="0" cellspacing="0" cellpadding="0" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
                                      <tr> 
                                        <td><img src="images/mypage01_menu02.gif" width="185" height="28"></td>
                                      </tr>
                                      <tr> 
                                        
                      <td align="center">고객님의 패스워드는 <strong><font color="#0092B6"><?=$result[PWD]?></font></strong> 입니다 </td>
                                      </tr>
                                      <tr> 
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr> 
                                        <td height="1px" bgcolor="#dddddd"></td>
                                      </tr>
                                      <tr> 
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr> 
                                        <td><div align="center"><a href="./"><img src="images/mypage01_ic04.gif" width="61" height="21" border="0"></a></div></td>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table>
                        <br>
                      </td>
                    </tr>
                  </table>
	<?
	exit;
	}
}
?>
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
                <td><table width="564" border="0" cellpadding="0" cellspacing="0" bgcolor="F2F2F2">
                    <form action='<?=$PHP_SELF?>?query=passsearch' method=post>
                      <input type=hidden name=action value=idsearch>
                      <input type=hidden name=mode value=mail>
                      <tr> 
                        <td width="89">&nbsp;</td>
                        <td width="365"><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_searchid.gif" width="345" height="55"></td>
                        <td width="110">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                        <td><table width="377" border="0" cellpadding="0" cellspacing="0">
                            <tr height="1"> 
                              <td width="82"></td>
                              <td colspan="2" bgcolor="BCBCBC"></td>
                            </tr>
                            <tr> 
                              <td colspan="2"><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_search01.gif" width="83" height="30"></td>
                              <td width="282"> <input name="name" type="text" size="17" tabindex="1"></td>
                            </tr>
                            <tr height="1"> 
                              <td width="82"></td>
                              <td colspan="2" bgcolor="BCBCBC"></td>
                            </tr>
                            <tr> 
                              <td colspan="2"><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_search02.gif" width="83" height="30"></td>
                              <td> <input name="juminno1" type="text" size="17"tabindex="2">
                                - 
                                <input name="juminno2" type="text" size="17"tabindex="3"></td>
                            </tr>
                            <tr height="1"> 
                              <td width="82"></td>
                              <td colspan="2" bgcolor="BCBCBC"></td>
                            </tr>
                          </table></td>
                        <td align="center"><input name="image" type=image src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_search.gif"tabindex="4"></td>
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
                <td><table width="564" border="0" cellpadding="0" cellspacing="0" bgcolor="F2F2F2">
                    <form action='<?=$PHP_SELF?>?query=passsearch' method=post>
                      <input type=hidden name=action value=passsearch>
                      <input type=hidden name=mode value=mail>
                      <tr> 
                        <td width="89">&nbsp;</td>
                        <td width="365"><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_searchpass.gif" width="345" height="55"></td>
                        <td width="110">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                        <td><table width="376" border="0" cellpadding="0" cellspacing="0">
                            <tr height="1"> 
                              <td width="82"></td>
                              <td colspan="2" bgcolor="BCBCBC"></td>
                            </tr>
                            <tr> 
                              <td colspan="2"><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_search03.gif" width="83" height="30"></td>
                              <td width="281"> <input name="id" type="text" size="17"tabindex="5"></td>
                            </tr>
                            <tr height="1"> 
                              <td width="82"></td>
                              <td colspan="2" bgcolor="BCBCBC"></td>
                            </tr>
                            <tr> 
                              <td colspan="2"><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_search02.gif" width="83" height="30"></td>
                              <td> <input name="juminno1" type="text" size="17" tabindex="6">
                                - 
                                <input name="juminno2" type="text" size="17"tabindex="7"></td>
                            </tr>
                            <tr height="1"> 
                              <td width="82"></td>
                              <td colspan="2" bgcolor="BCBCBC"></td>
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
