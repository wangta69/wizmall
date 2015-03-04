<?php
/* 
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
제작자 : 폰돌
URL : http://www.webpiad.co.kr
Email : master@webpiad.co.kr
*** Updating List ***
receiver의 메일이 다른 데로 날아가던 버그 수정  - 2003. 09.23
기존 폼메일상에서 input type=hindden name=html의 value를 customercenter로 수정 및 기존 customer.php를 삭제  - 2003. 09.23
*/

//include "./lib/inc.depth0.php";
include "./lib/class.mail.php";
if($query == "sendmail"){







$save = "

<table width='537' border='0' cellspacing='0' cellpadding='0'>

    <tr> 

      <td><img src='".$cfg["admin"]["MART_BASEDIR"]."/html/img_customercenter/on_img_01.gif' width='536' height='15'></td>

    </tr>

    <tr> 

      <td> <table width='536' border='0' cellspacing='0' cellpadding='0'>

          <tr> 

            <td width='25' background='".$cfg["admin"]["MART_BASEDIR"]."/html/img_customercenter/on_img_02.gif'>&nbsp;</td>

            <td valign='top'> <table width='484' border='0' cellspacing='0' cellpadding='0'>

                <tr> 

                  <td height='5'></td>

                </tr>

                <tr> 

                  <td class='text1'> <table width='484' border='0' cellspacing='0' cellpadding='0' height='25'>

                      <tr> 

                        <td class='text' width='98'><img src='".$cfg["admin"]["MART_BASEDIR"]."/html/img_customercenter/on_img_05.gif' width='4' height='4' hspace='2' align='absmiddle'> 

                          제 목</td>

                        <td class='text' valign='middle'>$Subject

                        </td>

                      </tr>

                    </table></td>

                </tr>

                <tr> 

                  <td> <table width='484' border='0' cellspacing='0' cellpadding='0' height='25'>

                      <tr> 

                        <td class='text' width='98'><img src='".$cfg["admin"]["MART_BASEDIR"]."/html/img_customercenter/on_img_05.gif' width='4' height='4' hspace='2' align='absmiddle'> 

                          성 명</td>

                        <td class='text' valign='middle'>$Name

                        </td>

                      </tr>

                    </table></td>

                </tr>

                <tr> 

                  <td height='5'></td>

                </tr>

                <tr> 

                  <td align='center'><img src='".$cfg["admin"]["MART_BASEDIR"]."/html/img_customercenter/on_img_06.gif' width='484' height='1'></td>

                </tr>

                <tr> 

                  <td align='center' height='5'> </td>

                </tr>

                <tr> 

                  <td> <table width='484' border='0' cellspacing='0' cellpadding='0' height='25'>

                      <tr> 

                        <td class='text' width='98'><img src='".$cfg["admin"]["MART_BASEDIR"]."/html/img_customercenter/on_img_05.gif' width='4' height='4' hspace='2' align='absmiddle'> 

                          연락처</td>

                        

                      <td class='text' valign='middle'> <img src='".$cfg["admin"]["MART_BASEDIR"]."/html/img_customercenter/on_img_07.gif' width='4' height='6' hspace='7'>전<font color='#FFFFFF'>..</font> 

                        화 : $Tel1_1 - $Tel1_2 - $Tel1_3 </td>

                      </tr>

                    </table></td>

                </tr>

                <tr> 

                  <td align='center'> <table width='484' border='0' cellspacing='0' cellpadding='0' height='25'>

                      <tr> 

                        <td class='text' width='98'>&nbsp;</td>

                        

                      <td class='text' valign='middle'> <img src='".$cfg["admin"]["MART_BASEDIR"]."/html/img_customercenter/client/on_img_07.gif' width='4' height='6' hspace='7'>핸드폰 

                        : 

                        $Tel2_1 - $Tel2_2 - $Tel2_3

                        </td>

                      </tr>

                    </table></td>

                </tr>

                <tr> 

                  <td align='center'> <table width='484' border='0' cellspacing='0' cellpadding='0' height='25'>

                      <tr> 

                        <td class='text' width='98'>&nbsp;</td>

                        

                      <td class='text' valign='middle'> <img src='".$cfg["admin"]["MART_BASEDIR"]."/html/img_customercenter/on_img_07.gif' width='4' height='6' hspace='7'>팩<font color='#FFFFFF'>..</font> 

                        스 : 

                        $Tel3_1 - $Tel3_2 -  $Tel3_3

                        </td>

                      </tr>

                    </table></td>

                </tr>

                <tr> 

                  <td align='center' height='11' valign='middle'><img src='".$cfg["admin"]["MART_BASEDIR"]."/html/img_customercenter/client/on_img_06.gif' width='484' height='1'></td>

                </tr>

                <tr> 

                  <td align='center'> <table width='484' border='0' cellspacing='0' cellpadding='0' height='25'>

                      <tr> 

                        <td class='text' width='98'><img src='".$cfg["admin"]["MART_BASEDIR"]."/html/img_customercenter/on_img_05.gif' width='4' height='4' hspace='2' align='absmiddle'> 

                          E-mail</td>

                        <td class='text' valign='middle'> $sender

                        </td>

                      </tr>

                    </table></td>

                </tr>

                <tr> 

                  <td height='5'></td>

                </tr>

                <tr> 

                  <td><img src='".$cfg["admin"]["MART_BASEDIR"]."/html/img_customercenter/on_img_06.gif' width='484' height='1'></td>

                </tr>

                <tr> 

                  <td height='5'></td>

                </tr>

                <tr> 

                  <td align='center'> <table width='484' border='0' cellspacing='0' cellpadding='0' height='25'>

                      <tr> 

                        <td class='text' width='98'><img src='".$cfg["admin"]["MART_BASEDIR"]."/html/img_customercenter/on_img_05.gif' width='4' height='4' hspace='2' align='absmiddle'> 

                          문의항목</td>

                        <td class='text' valign='middle'> $Item </td>

                      </tr>

                    </table></td>

                </tr>

                <tr> 

                  <td align='center'> <table width='484' border='0' cellspacing='0' cellpadding='0' height='25'>

                      <tr> 

                        <td class='text' width='98' valign='top'><img src='".$cfg["admin"]["MART_BASEDIR"]."/html/img_customercenter/on_img_05.gif' width='4' height='4' hspace='2' align='absmiddle'> 

                          문의사항</td>

                        <td class='text' valign='middle'> $Contents

                        </td>

                      </tr>

                    </table></td>

                </tr>

              </table></td>

            <td width='27' background='".$cfg["admin"]["MART_BASEDIR"]."/html/img_customercenter/on_img_03.gif'>&nbsp;</td>

          </tr>

        </table></td>

    </tr>

    <tr> 

      <td><img src='".$cfg["admin"]["MART_BASEDIR"]."/html/img_customercenter/on_img_04.gif' width='536' height='28'></td>

    </tr>

    <tr> 

      <td align='center' height='7'></td>

    </tr>

</table>

";

//$receiver = "master@webpiad.co.kr";
//$receiver = $cfg["admin"]["ADMIN_EMAIL"];
//$mailheaders .=  "Return-Path: $sender\r\n";
//$mailheaders .=  "From: $Name<$sender>\r\n";
//$mailheaders .=  "X-Mailer: SHOP_WIZARD FORM Mailer\r\n";
//$mailheaders .=  "Mime-Version: 1.0\r\n";
//$mailheaders .=  "Content-Type: text/html; charset='iso-2022-kr'\r\n";





		$title = "공객상담문의메일[".$cfg["admin"]["ADMIN_TITLE"]."]";
		$sender = $Mail1."@".$Mail2;

		$mail		= new classMail();
		$mail->From ($cfg["admin"]["ADMIN_EMAIL"], $common->conv_euckr($cfg["admin"]["ADMIN_TITLE"]));
		$mail->To ($sender);
		$mail->Organization ($common->conv_euckr($cfg["admin"]["ADMIN_TITLE"]));
		$mail->Subject ($common->conv_euckr($title));
		$mail->Body ($common->conv_euckr($save));
		$mail->Priority (3);
		//$mail->debug	= true;
		$ret1 = $mail->Send();

		$mail		= new classMail();
		$mail->From ($sender, $common->conv_euckr($cfg["admin"]["ADMIN_TITLE"]));
		$mail->To ($cfg["admin"]["ADMIN_EMAIL"]);
		$mail->Organization ($common->conv_euckr($cfg["admin"]["ADMIN_TITLE"]));
		$mail->Subject ($common->conv_euckr($title));
		$mail->Body ($common->conv_euckr($save));
		$mail->Priority (3);
		//$mail->debug	= true;
		$ret2 = $mail->Send();

		if($ret2){
			  echo "<script>window.alert('정상적으로 메일이 발송되었습니다.\\n 받는이메일 : ".$cfg["admin"]["ADMIN_EMAIL"]." \\n 보내는 이메일 : $sender');location.replace('./');</script>";
		}else{
			  echo "<script>window.alert('Warnning Traffic Error!! Pls try again later');
					history.go(-1); </script>";
		}

/*
 $mresult = mail($receiver, $title, $save, $mailheaders);
 if($sender) mail($sender, $title, $save, $mailheaders);
  if($mresult){
          echo "<script>window.alert('정상적으로 메일이 발송되었습니다.\\n 받는이메일 : $receiver \\n 보내는 이메일 : $sender');location.replace('./');</script>";
  }else{

          echo "<script>window.alert('Warnning Traffic Error!! Pls try again later');

                history.go(-1); </script>";

       }

*/

    



}



?>
<script>
function checkForm(){

	var f=document.InquireForm;
	
	if(f.Subject.value == ''){
		alert('제목을 입력해주세요');
		f.Subject.focus();
		return false;
	}  
	else if(f.Name.value == ''){
		alert('성함을 입력해주세요');
		f.Name.focus();
		return false;
	}
}
</script>
<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active">고객센터</li>
</ul>

<img src="html/img_customercenter/title_01.gif" width="567" height="30">
<p></p>
<div class="well well-sm">
<?=$cfg["admin"]["ADMIN_TITLE"]?>
을 이용해 주셔서 감사합니다. </span>
<p>저희
	<?=$cfg["admin"]["ADMIN_TITLE"]?>
	에서는 무엇보다도 완벽한 품질의 제품과 최고의 서비스를 
	
	제공하기<br>
	위하여 끊임없이 노력하고 있습니다.</p>
<p>저희 제품에 대하여 궁금하신 사항이나 사용상의 문제점 등 제반 문의사항이 
	있으시면<br>
	전화(
	<?=$cfg["admin"]["CUSTOMER_TEL"]?>
	) 또는 이메일을 주십시오.</p>
</div>
<p>☞ 회사 연락처<br>
<div class="well well-sm">
	주 소 :
	<?=$cfg["admin"]["COMPANY_ADD"]?>
	<br>
	전 화 :
	<?=$cfg["admin"]["CUSTOMER_TEL"]?>
	<br>
	팩 스 :
	<?=$cfg["admin"]["CUSTOMER_FAX"]?>
	<br>
	<span>E-mail :
	<?=$cfg["admin"]["ADMIN_EMAIL"]?>
	</span>
</div>
<div class="orange">문의메일</div>
<div class="well well-sm">
	<form name="InquireForm" method="POST" action="<?=$PHP_SELF?>" onsubmit='return checkForm();' enctype="multipart/form-data" class="form-horizontal" role="form">
		<input type="hidden" name="html" value="customercenter">
		<input type="hidden" name="query" value="sendmail">
		<div class="form-group">
			<label for="inputSubject" class="col-lg-2 control-label">제 목</label>
			<div class="col-lg-10">
				<input name="Subject" type="text" id="inputSubject" class="form-control" placeholder="" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputName" class="col-lg-2 control-label">성 명</label>
			<div class="col-lg-10">
				<input name="Name" type="text" id="inputName" class="form-control" placeholder="" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputSubject" class="col-lg-2 control-label">연락처</label>
			<div class="col-lg-10">
				<input name="Tel1_1" type="text" class="w50"/>
				-
				<input name="Tel1_2" type="text" class="w50" />
				-
				<input name="Tel1_3" type="text" class="w50" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputSubject" class="col-lg-2 control-label">핸드폰</label>
			<div class="col-lg-10">
				<input name="Tel2_1" type="text" class="w50" />
				-
				<input name="Tel2_2" type="text" class="w50" />
				-
				<input name="Tel2_3" type="text" class="w50" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputSubject" class="col-lg-2 control-label">팩 스</label>
			<div class="col-lg-10">
				<input name="Tel3_1" type="text" class="w50" />
				-
				<input name="Tel3_2" type="text" class="w50" />
				-
				<input name="Tel3_3" type="text" class="w50" />
			</div>
		</div>		
		<div class="form-group">
			<label for="inputMail1" class="col-lg-2 control-label">E-mail</label>
			<span class="add-on"><i class="icon-user"></i></span><div class="col-lg-10">
				<input name="Mail1" type="text" id="inputMail1" class="form-control" placeholder="" />
				@
					<input name="Mail2" type="text" id="Mail2" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputSubject" class="col-lg-2 control-label">문의항목</label>
			<div class="col-lg-10">
				<select name="Item" id="Item" class="form-control">
						<option selected>==항목을 
						
						선택하세요==</option>
						<option>---------------------</option>
						<option value="제품 구입에 관한 문의">제품 
						
						구입에 관한 문의</option>
						<option value="제품 사용법에 관한 문의">제품 
						
						사용법에 관한 문의</option>
						<option value="제품 서비스에 관한 문의">제품 
						
						서비스에 관한 문의</option>
						<option value="기타">기타</option>
					</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputContents" class="col-lg-2 control-label">문의사항</label>
			<div class="col-lg-10">
				<textarea name="Contents" rows="5" wrap="VIRTUAL" id="inputContents"  class="form-control" placeholder=""></textarea>
			</div>
		</div>
	
	  <div class="form-group">
	    <div class="col-lg-offset-2 col-lg-10">
	      <button type="submit" class="btn btn-default">확인</button> <button type="button" class="btn btn-default" onclick="history.go(-1)";>취소</button>
	    </div>
	  </div>
	
	</form>
</div>

<!--
<form name="InquireForm" method="POST" action="<?=$PHP_SELF?>" onsubmit='return checkForm();' enctype="multipart/form-data">
	<input type="hidden" name="html" value="customercenter">
	<input type="hidden" name="query" value="sendmail">
	<table class="table_main w100p">
		<col width="120px" />
		<col width="*" />
		<tr>
			<th><img src="../html/img_customercenter/list_icon_1.gif" width="4" height="4" hspace="2" align="absmiddle" /> 제 목</th>
			<td><input name="Subject" type="text" id="address" />
			</td>
		</tr>
		<tr>
			<th><img src="../html/img_customercenter/list_icon_1.gif" width="4" height="4" hspace="2" align="absmiddle" /> 성 명</th>
			<td><input name="Name" type="text" id="Tel4" />
			</td>
		</tr>
		<tr>
			<th><img src="../html/img_customercenter/list_icon_1.gif" width="4" height="4" hspace="2" align="absmiddle" /> 연락처</th>
			<td><img src="../html/img_customercenter/list_icon.gif" width="4" height="6" hspace="7" />전 화
				<input name="Tel1_1" type="text" id="Tel1_1" class="w50"/>
				-
				<input name="Tel1_2" type="text" id="Tel1_2" class="w50" />
				-
				<input name="Tel1_3" type="text" id="Tel1_3" class="w50" />
				<br />
				<img src="../html/img_customercenter/list_icon.gif" width="4" height="6" hspace="7" />핸드폰
				<input name="Tel2_1" type="text" id="Tel5" class="w50" />
				-
				<input name="Tel2_2" type="text" id="Tel6" class="w50" />
				-
				<input name="Tel2_3" type="text" id="Tel7" class="w50" />
				<br />
				<img src="../html/img_customercenter/list_icon.gif" width="4" height="6" hspace="7" />팩 스
				<input name="Tel3_1" type="text" id="Tel1" class="w50" />
				-
				<input name="Tel3_2" type="text" id="Tel2" class="w50" />
				-
				<input name="Tel3_3" type="text" id="Tel3" class="w50" />
			</td>
		</tr>
		<tr>
			<th><img src="../html/img_customercenter/list_icon_1.gif" width="4" height="4" hspace="2" align="absmiddle" /> E-mail</th>
			<td><input name="Mail1" type="text" id="Mail1" />
				@
				<input name="Mail2" type="text" id="Mail2" />
			</td>
		</tr>
		<tr>
			<th><img src="../html/img_customercenter/list_icon_1.gif" width="4" height="4" hspace="2" align="absmiddle" /> 문의항목</th>
			<td><select name="Item" id="Item">
					<option selected>==항목을 
					
					선택하세요==</option>
					<option>---------------------</option>
					<option value="제품 구입에 관한 문의">제품 
					
					구입에 관한 문의</option>
					<option value="제품 사용법에 관한 문의">제품 
					
					사용법에 관한 문의</option>
					<option value="제품 서비스에 관한 문의">제품 
					
					서비스에 관한 문의</option>
					<option value="기타">기타</option>
				</select>
			</td>
		</tr>
		<tr>
			<th><img src="../html/img_customercenter/list_icon_1.gif" width="4" height="4" hspace="2" align="absmiddle" /> 문의사항</th>
			<td><textarea name="Contents" rows="5" wrap="VIRTUAL" id="Contents" class="w100p"></textarea>
			</td>
		</tr>
	</table>
	<div class="btn_box">
		<input name="image" type="image" src="html/img_customercenter/enter_img.gif" width="70" height="29">
		&nbsp;&nbsp;<img src="html/img_customercenter/cancle_btn.gif" width="70" height="29" hspace="5" onclick="history.go(-1)"; style="cursor:pointer"> </div>
</form>
-->