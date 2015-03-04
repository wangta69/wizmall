<?
/************************************************/
/**                                            **/
/**    프로그래명 : wizMailer For wizMall      **/
/**                                            **/
/**    수정자 : 폰돌                           **/
/**                                            **/
/**    수정일 : 2002.8.20                      **/
/**    두번째 수정일 : 2003. 05.13             **/
/************************************************/
/* 위즈몰용으로 기존 프로그램을 수정보완하였습니다.
현재 프로그램을 wizMember의 wizMembers DB와 호환되게 다시 수정 보완 배포합니다.
E-mail : master@shop-wiz.com
Url : http://www.shop-wiz.com
상업적 목적이 없는 한 수정 및 재 배포가 자유롭습니다. 


 */
include ("../config/cfg.core.php");
?>
<script  language="Javascript">
<!--
function display(flag){
var f= document.messageform;

	if(flag == '1'){//회원테이블로 부터 메일 보내기
		optionTable1.style.display = 'block';
		optionTable2.style.display = 'none';
		optionTable3.style.display = 'none';
		optionTable4.style.display = 'none';
		optionTable5.style.display = 'none';
		f.theme.value="mail/mailer2";
	}else if(flag == '2'){//주소록 Table로 부터 메일 보내기
		optionTable1.style.display = 'none';
		optionTable2.style.display = 'block';
		optionTable3.style.display = 'none';
		optionTable4.style.display = 'none';
		optionTable5.style.display = 'none';
		f.theme.value="mail/mailer2_1";
	}else if(flag == '3'){//단체개별메일보내기
		optionTable1.style.display = 'none';
		optionTable2.style.display = 'none';
		optionTable3.style.display = 'block';
		optionTable4.style.display = 'none';
		optionTable5.style.display = 'none';
		f.theme.value="mail/mailer2_2";
	}else if(flag == '4'){//csv파일로 부터 메일보내기
		optionTable1.style.display = 'none';
		optionTable2.style.display = 'none';
		optionTable3.style.display = 'none';
		optionTable4.style.display = 'block';
		optionTable5.style.display = 'none';
		f.theme.value="mail/mailer2_3";
	}else if(flag == '5'){//뉴스레터로 부터 메일보내기
		optionTable1.style.display = 'none';
		optionTable2.style.display = 'none';
		optionTable3.style.display = 'none';
		optionTable4.style.display = 'none';
		optionTable5.style.display = 'block';
		f.theme.value="mail/mailer2_4";
	}
}

//-->
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">메일발송하기</div>
	  <div class="panel-body">
		 메일발송옵션에서 선택된 회원에게 메일이 발송됩니다.<br />
                      메일발송은 서버에 부하가 주어지므로 만단위 이상의 메일은 자제해 주시기 바랍니다.
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
      <br /> <table class="table">
        <form name="messageform" method="post" action="<?=$PHP_SELF?>" enctype='multipart/form-data'>
		<input type='hidden' name='menushow' value='<?=$menushow?>'>
		<input type="hidden" name="theme" value="mail/mailer2">
          <tr> 
            <th>보내는 분</th>
            <td>  
              <input size=50 name="FromName" value="클리클로">
            </td>
          </tr>
          <tr> 
            <th>Email</th>
            <td>  
              <input name="FromEmail" value="cliclo@clliclo.com" size="50">
            </td>
          </tr>
          <tr> 
            <th>Reply-To </th>
            <td> <input name="reply" value="cliclo@clliclo.com" size=50></td>
          </tr>
          <tr> 
            <th>제목</th>
            <td>  
              <input size=81 
                        name=subject>
              </td>
          </tr>
          <tr> 
            <th>텍스트타입</th>
            <td>  
              <input 
                        type="radio" checked value=0 name=contenttype>
              HTML 로 보내기 
              <input type="radio" value=1 name=contenttype>
              TXT 로 보내기 </td>
          </tr>
          <tr> 
            <th>스킨선택</th>
            <td>  
              <select style="width: 160px" name=MailSkin>
                <option value="">스킨없슴</option>
                <?
$vardir = "./mailskin";
$open_dir = opendir($vardir);
        while($opendir = readdir($open_dir)) {
                if(($opendir != ".") && ($opendir != "..") && is_dir("$vardir/$opendir")) {
                                echo "<option value=\"$opendir\">$opendir 스킨</option>\n";
                }
        }
closedir($open_dir);
?>
              </select>
              </td>
          </tr>
          <tr> 
            <td>내용</td>
            <td> <textarea name=body_txt rows=15 cols=80></textarea>> 
            </td>
          </tr>
          <tr> 
            <td>파일첨부 </td>
            <td>  
              <input name="userfile" type="file" id="userfile"></td>
          </tr>
          <tr> 
            <td>메일Table선택</td>
            <td>
              <input name="addsource" type="radio" value="1" checked onClick="display('1')">
              회원Table 
              </td>
          </tr>
          <tr> 
            <td>메일발송옵션</td>
            <td> <table id="optionTable1">
                <tbody>
                  <tr> 
                    <td>  
                      <input type="radio" value="all" name="sOption">
                      전체 &nbsp;&nbsp;&nbsp; 
                      <input type="checkbox" checked value="1" name="mailreject">
                      수신거부회원은 메일 발송안함</td>
                  </tr>

                  <tr> 
                    <td>  
                      <input type="radio" checked value="testMail" name="sOption">
                      개인멜 
                      <input name="testMailAddress">
                      (하나의 이멜을 적어주세요 - 테스트용)</td>
                  </tr>
                  <tr> 
                    <td>&nbsp;</td>
                  </tr>
                </tbody>
              </table>
              <table  id="optionTable2" style="display:none">
                <tr> 
                  <td>&nbsp;</td>
                </tr>
              </table>
              <table  id="optionTable3" style="display:none">
                <tr> 
                  <td></td>
                </tr>

              </table>
              <table  id="optionTable4" style="display:none">
                <tr> 
                  <td>&nbsp;</td>
                </tr>
              </table><table  id="optionTable5" style="display:none">
                <tr> 
                  <td>&nbsp;</td>
                </tr>
                
            </table></td>
          </tr>
          <tr> 
            <td colspan=2> <input type="image" src="img/mail.gif">
              &nbsp;&nbsp;&nbsp; </td>
          </tr>
        </form>
      </table>
      <br />  </td>
  </tr>
</table>
