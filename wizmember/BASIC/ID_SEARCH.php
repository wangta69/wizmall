<?
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
tabindex 코딩, mode 별(프린트 혹은 메일)로 각기 출력방식선택 기본은 Mail  - 2003. 08.15
*/

/********************************** id search 인 경우 아래를 실행한다. **************************/
if($action == 'idsearch'){
	include ("./config/db_info.php");

$Compnum = $compno1."-".compno2;
//echo "select * from wizMembers where name='$name' AND Jumin1='$juminno1' AND Jumin2='$juminno2'";
	if($juminno1 && $juminno2){
		$result = $dbcon->get_row( "select * from wizMembers where name='$name' AND Jumin1='$juminno1' AND Jumin2='$juminno2'"); 
	}else if($compno1 && $compno2){
		$result = $dbcon->get_row( "select * from wizMembers where name='$name' AND Compnum = '$Compnum'"); 
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
<table>
                    <tr> 
                      <td><img src="images/title_mypage01.gif"> 
                        <table>
                          <tr> 
                            <td>&nbsp;</td>
                            <td><img src="images/subtitle_line01.gif"></td>
                            <td><a href="wizmember.php?query=passsearch"><img src="images/mypage01_sub01.gif"></a></td>
                            <td><img src="images/subtitle_line01.gif"></td>
                            <td><a href="wizmember.php?query=info"><img src="images/mypage01_sub02.gif"></a></td>
                            <td><img src="images/subtitle_line01.gif"></td>
                            <td><a href="./wizmember.php?query=out"><img src="images/mypage01_sub03.gif"></a></td>
                            <td><img src="images/subtitle_line01.gif"></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr> 
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr> 
                      <td><br />
                        <table background="images/pattern02.gif">
                          <tr> 
                            <td>
<table>
                                <tr> 
                                  <td>
<table>
                                      <tr> 
                                        <td><img src="images/mypage01_menu01.gif" width="185"></td>
                                      </tr>
                                      <tr> 
                                        <td>고객님의 아이디는 <?=$result[ID]?> 
                                            입니다</td>
                                      </tr>
                                      <tr> 
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr> 
                                        <td></td>
                                      </tr>
                                      <tr> 
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr> 
                                        <td><div><a href="./"><img src="images/mypage01_ic03.gif" width="61" height="21"></a></div></td>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table>
                        <br />
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

$Compnum = $compno1."-".compno2;
if($juminno1 && $juminno2){
	$result = $dbcon->get_row( "select * from wizMembers where ID='$id' AND Jumin1='$juminno1' AND Jumin2='$juminno2'"); 
	}else if($compno1 && $compno2){
	$result = $dbcon->get_row( "select * from wizMembers where name='$name' AND Compnum = '$Compnum'"); 
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
<table>
                    <tr> 
                      <td><img src="images/title_mypage01.gif"> 
                        <table>
                          <tr> 
                            <td>&nbsp;</td>
                            <td><img src="images/subtitle_line01.gif"></td>
                            <td><a href="wizmember.php?query=passsearch"><img src="images/mypage01_sub01.gif"></a></td>
                            <td><img src="images/subtitle_line01.gif"></td>
                            <td><a href="wizmember.php?query=info"><img src="images/mypage01_sub02.gif"></a></td>
                            <td><img src="images/subtitle_line01.gif"></td>
                            <td><a href="./wizmember.php?query=out"><img src="images/mypage01_sub03.gif"></a></td>
                            <td><img src="images/subtitle_line01.gif"></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr> 
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr> 
                      <td><br />
                        <table background="images/pattern02.gif">
                          <tr> 
                            <td>
<table>
                                <tr> 
                                  <td>
<table>
                                      <tr> 
                                        <td><img src="images/mypage01_menu02.gif" width="185"></td>
                                      </tr>
                                      <tr> 
                                        
                      <td>고객님의 패스워드는 <?=$result[PWD]?> 입니다 </td>
                                      </tr>
                                      <tr> 
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr> 
                                        <td></td>
                                      </tr>
                                      <tr> 
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr> 
                                        <td><div><a href="./"><img src="images/mypage01_ic04.gif" width="61" height="21"></a></div></td>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table>
                        <br />
                      </td>
                    </tr>
                  </table>
	<?
	exit;
	}
}
?>
<table>
  <tr> 
    <td><table>
        <tr> 
          <td>&nbsp;</td>
          <td><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/sn_arrow.gif" width="13" height="13"></td>
          <td>Home &gt; 아이디 및 비밀번호 
            찾기 </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td> <table>
        <tr> 
          <td>- 회원님!! 아이디 또는 비밀번호를 
            잊으셨나요? 입력하신 후 [확인]단추를 누르세요</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td> <table>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td> <table>
              <tr> 
                <td><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/title_id.gif" height="21"></td>
              </tr>
              <tr> 
                <td background="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/bg_top.gif"></td>
              </tr>
              <tr> 
                <td><table>
                    <form action='<?=$PHP_SELF?>?query=passsearch' method=post>
                      <input type="hidden" name=action value=idsearch>
                      <input type="hidden" name=mode value=mail>
                      <tr> 
                        <td>&nbsp;</td>
                        <td><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_searchid.gif" width="345" height="55"></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                        <td><table>
                            <tr> 
                              <td></td>
                              <td colspan="2"></td>
                            </tr>
                            <tr> 
                              <td colspan="2"><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_search01.gif" width="83"></td>
                              <td> <input name="name" type="text" size="17" tabindex="1"></td>
                            </tr>
                            <tr> 
                              <td></td>
                              <td colspan="2"></td>
                            </tr>
                            <tr> 
                              <td colspan="2"><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_search02.gif" width="83"></td>
                              <td> <input name="juminno1" type="text" size="17"tabindex="2">
                                - 
                                <input name="juminno2" type="text" size="17"tabindex="3"></td>
                            </tr>
                            <tr> 
                              <td></td>
                              <td colspan="2"></td>
                            </tr>
                          </table></td>
                        <td><input name="image" type=image src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_search.gif"tabindex="4"></td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </form>
                  </table></td>
              </tr>
              <tr> 
                <td background="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/bg_bottom.gif"></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td> <table>
              <tr> 
                <td><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/title_pass.gif" width="91"></td>
              </tr>
              <tr> 
                <td background="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/bg_top.gif"></td>
              </tr>
              <tr> 
                <td><table>
                    <form action='<?=$PHP_SELF?>?query=passsearch' method=post>
                      <input type="hidden" name=action value=passsearch>
                      <input type="hidden" name=mode value=mail>
                      <tr> 
                        <td>&nbsp;</td>
                        <td><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_searchpass.gif" width="345" height="55"></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                        <td><table>
                            <tr> 
                              <td></td>
                              <td colspan="2"></td>
                            </tr>
                            <tr> 
                              <td colspan="2"><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_search03.gif" width="83"></td>
                              <td> <input name="id" type="text" size="17"tabindex="5"></td>
                            </tr>
                            <tr> 
                              <td></td>
                              <td colspan="2"></td>
                            </tr>
                            <tr> 
                              <td colspan="2"><img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_search02.gif" width="83"></td>
                              <td> <input name="juminno1" type="text" size="17" tabindex="6">
                                - 
                                <input name="juminno2" type="text" size="17"tabindex="7"></td>
                            </tr>
                            <tr> 
                              <td></td>
                              <td colspan="2"></td>
                            </tr>
                          </table></td>
                        <td><input name="image" type=image src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_search.gif" tabindex="8"></td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </form>
                  </table></td>
              </tr>
              <tr> 
                <td background="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/bg_bottom.gif"></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>