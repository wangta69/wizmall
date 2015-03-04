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
단, 수정시 상기를 표시해 주시면 감솨여....^^
Upgrade 2003.08.20 wizmall에 맞게 재구성
2003.10.10  성별 에러 발생되던 것을 수정 및 등급별 발송 선택
2004. 05. 12 스킨선택기능 삽입
2004. 06 30 개인Address에서 가져오기 기능 추가
2004. 07 9  텍스트로 된 대량 메일 발송 기능 추가
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
						<p></p>	
					    <table class="table">
        <form name="messageform" method="post" action="<?=$PHP_SELF?>" enctype='multipart/form-data'>
		<input type='hidden' name='menushow' value='<?=$menushow?>'>
		<input type="hidden" name="theme" value="mail/mailer2">
          <tr> 
            <td>사용 테이블 선택</td>
            <td><a href="<?=$PHP_SELF;?>?menushow=<?=$menushow;?>&theme=mail/mailer1_cl"> 발송프로그램</a></td>
          </tr>
        </form>
      </table>
    <br />  </td>
  </tr>
</table>
