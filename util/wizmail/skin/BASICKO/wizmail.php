<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>

<title>WizMailler</title>

<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

<link rel='stylesheet' href='body.css' type='text/css'>

</head>



<script language="javascript">

<!--

function addToMail()

{

	nameToDiv.insertAdjacentElement("BeforeEnd",document.createElement("<br><br>"));

	nameToDiv.insertAdjacentElement("BeforeEnd",document.createElement("<input type='text' name='nameTo[]' size='30' maxlength='30' value='' style='font: 9pt 굴림; border:1 solid #666666'>"));

}



function addFile()

{

	AttachDiv.insertAdjacentElement("BeforeEnd",document.createElement("<br><br>"));

	AttachDiv.insertAdjacentElement("BeforeEnd",document.createElement("<input type='file' name='file[]' size='25' maxlength='30' style='font: 9pt 굴림; border:1 solid #666666'>"));

}



function SendmailCheck(){

var f=document.WizMailer;

	if(f.FromEmail.value==""){

      alert ("이메일을 넣어주세요.");

      return false;

  }



}


window.resizeTo(406, 490);




-->

</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="400" border="0" cellspacing="0" cellpadding="0">

  <tr> 

    <td colspan="3"><img src="skin/<?=$WizMailSkin?>/images/img_mailform.gif" width="400" height="83"></td>

  </tr>

  <tr  height="3" > 

    <td width="10" height="3" align="center"></td>

    <td width="300" height="3" align="center" bgcolor="#999999"></td>

    <td width="10" height="3" align="center"></td>

  </tr>

  <tr> 

    <td colspan="3"><table width="400" height="92" border="1" cellpadding="0" cellspacing="0" bordercolor="#737373" style="border-collapse:collapse;">

        <tr> 

          <td align="center"><table width="380" border="0" cellspacing="1" cellpadding="0">

<form NAME="WizMailer" enctype='multipart/form-data' OnSubmit="javascript:return SendmailCheck()"; action="<?=$PHP_SELF?>" METHOD="POST"> 

<input type="hidden" name="sendit" value="ok"> 
<input type="hidden" name="nameTo[]" value="<?=$ToMail?>" >
              <tr  height="3"> 

                <td colspan="3"></td>

              </tr>

<!-- 			  

			  <tr> 

                <td width="87" height="24" align="center" bgcolor="#F2F2F2" class="company">받는사람</td>

                <td width="5" height="24">&nbsp; </td>

                <td width="293">

                    

                      

                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                      <tr> 

                        <td>

                          <div id='nameToDiv'><input type="text" name="nameTo[]" size="30" maxlength="30" value="" style="font: 9pt 굴림; border:1 solid #666666"></div>

                        </td>

                        <td valign="top">

<input type="button" name="Button" value="추가" onClick="javascript:addToMail();return false"; style="cursor:pointer">

                        </td>

                      </tr>

                    </table>

                  </td>

				    <td width="293">

                  <input type="text" name="nameTo[]" size="30" maxlength="30" value="" style="font: 9pt 굴림; border:1 solid #666666" >

                  </td> 

              </tr>-->			  

			  <tr> 

                <td width="87" height="24" align="center" bgcolor="#F2F2F2" class="company">보내는사람</td>

                <td width="5" height="24">&nbsp; </td>

                <td width="293">

                  <input type="text" name="FromEmail" size="30" maxlength="30" value="" style="font: 9pt 굴림; border:1 solid #666666" >

                </td>

              </tr>

              <tr> 

                <td height="26" align="center" bgcolor="#F2F2F2" class="company">제  목</td>

                <td width="5" height="26">&nbsp; </td>

                <td>

                  <input type="text" name="subject" size="40" maxlength="30" value="" style="font: 9pt 굴림; border:1 solid #666666" >

                </td>

              </tr>

              <tr> 

                <td align="center" bgcolor="#F2F2F2" class="company">내 용</td>

                <td width="5"><font color=#CC6600>&nbsp; </font></td>

                <td><font color=#CC6600>

                  <textarea name="comment" rows="15" cols="35"  style="border:1 solid #666666"></textarea>

                  </font></td>

              </tr>

			   <tr> 

                <td height="26" align="center" bgcolor="#F2F2F2" class="company">전송타입</td>

                <td width="5" height="26">&nbsp; </td>

                <td><table width="120" border="0" cellspacing="0" cellpadding="0">

                    <tr>

                      <td width="20"> 

                          <input type="radio" name="mType" value="0" checked>

                      </td>

                      <td> Text</td>

                      <td width="20"> 

                          <input type="radio" name="mType" value="1">

                      </td>

                      <td>Html</td>

                    </tr>

                  </table></td>

              </tr>

			  <tr> 

                <td height="26" align="center" bgcolor="#F2F2F2" class="company">첨부화일</td>

                <td width="5" height="26">&nbsp; </td>

                <!--<td>

                 <input type="file" name="file[]">

                  </td>-->

				                  <td>

                    

                      <table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr> 

                          <td>

                            <div id='AttachDiv'><input type='file' name='file[]' size='25' maxlength='30' style='font: 9pt 굴림; border:1 solid #666666'></div></td>

                          <!-- <td><input type="button" name="Button2" value="추가" onClick="addFile();return false"; style="cursor:pointer"></td> -->

                        </tr>

                      </table>

                    

                    

                  </td> 

              </tr>

              <tr> 

                <td height="25">&nbsp;</td>

                <td height="25" align="right">&nbsp;</td>

                  <td height="25" align="right">

<input type="image" src="skin/<?=$WizMailSkin?>/images/but_mailok.gif" width="55" height="21">
                    <img src="skin/<?=$WizMailSkin?>/images/but_mailcancel.gif" width="55" height="21" onclick="javascript:window.close();" style="cursor:pointer";></td>

              </tr></form>

            </table> </td>

        </tr>

      </table></td>

  </tr>

</table>

</body>

</html>

