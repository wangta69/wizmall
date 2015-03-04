<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>메일보내기</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<style type="text/css">
<!--
@import url("./skin/<?=$WizMailSkin?>/body.css");
-->
</style>
<script>
window.resizeTo(435, 590);
</script>
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
-->
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="420" height="560" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10" height="10"></td>
    <td height="10"></td>
    <td width="10" height="10"></td>
  </tr>
  <tr>
    <td width="10"></td>
    <td valign="top">
<table width="400" height="540" border="0" cellpadding="0" cellspacing="1" bgcolor="#666666">
        <tr> 
          <td valign="top" bgcolor="#FFFFFF">
<table width="398" border="0" cellspacing="0" cellpadding="0">
<form NAME="WizMailer" enctype='multipart/form-data' OnSubmit="javascript:return SendmailCheck()"; action="<?=$PHP_SELF?>" METHOD="POST"> 
<input type="hidden" name="sendit" value="ok"> 
<input type="hidden" name="nameTo[]" value="<?=$ToMail?>" >
              <tr> 
                <td colspan="3"><img src="skin/<?=$WizMailSkin?>/images/mailform_top.jpg" width="398" height="94"></td>
              </tr>
              <tr> 
                <td width="10" height="15"></td>
                <td width="380" height="15" valign="top"></td>
                <td height="15" width="12"></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td width="380" valign="top"> <table width="378" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF" class="text-board">
			
                    <tr bgcolor="#efefef"> 
                      <td width="90" height="33" align="center" bgcolor="#E8E8E8">보내는사람</td>
                      <td width="290" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp; <input name="FromEmail" type="text" class="board-box"  id="name" size="45"> 
                      </td>
                    </tr>
                    <tr bgcolor="#efefef"> 
                      <td height="33" align="center" bgcolor="#E8E8E8">제목</td>
                      <td bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp; <input name="subject" type="text" class="board-box"  id="name22" size="45"></td>
                    </tr>
                    <tr bgcolor="#efefef"> 
                      <td height="210" align="center" bgcolor="#E8E8E8">내용</td>
                      <td bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp; <textarea name="comment" wrap="VIRTUAL" class="board-box" id="content" style="width:95%; height:210"></textarea></td>
                    </tr>
                    <tr bgcolor="#efefef"> 
                      <td height="66" rowspan="2" align="center" bgcolor="#E8E8E8">파일첨부</td>
                      <td height="43" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp; 
                        <input name="file[]" type="file" class="board-box" size="20">
                        &nbsp;<font color="#003300">[1M이하]</font></td>
                    </tr>
                    <tr bgcolor="#efefef"> 
                      <td height="23" valign="top" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;<font color="#003300">용량이 
                        크면 시간이 오래걸립니다. 기다려주세요.</font></td>
                    </tr>
                    <tr bgcolor="#efefef"> 
                      <td height="33" align="center" bgcolor="#E8E8E8">전송타입</td>
                      <td bgcolor="#FFFFFF">&nbsp;&nbsp; <input type="radio" name="mType" value="0">
                        Text&nbsp;&nbsp;&nbsp; <input type="radio" name="mType" value="1">
                        Html</td>
                    </tr>
                  </table></td>
                <td height="2">&nbsp;</td>
              </tr>
              <tr> 
                <td height="1"></td>
                <td width="380" valign="top" height="1"></td>
                <td height="1"></td>
              </tr>
              <tr> 
                <td height="1"></td>
                <td width="380" valign="top" bgcolor="#acacac" height="1"></td>
                <td height="1"></td>
              </tr>
              <tr>
                <td height="10"></td>
                <td valign="top" height="10"></td>
                <td height="10"></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td align="right" valign="top"> <table width="120" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td width="55"><input type="image" src="skin/<?=$WizMailSkin?>/images/bu_send.gif" width="55" height="21" border="0"></td>
                      <td width="10">&nbsp;</td>
                      <td width="55"><img src="skin/<?=$WizMailSkin?>/images/bu_cancel.gif" width="55" height="21" border="0" onclick="javascript:window.close();" style="cursor:pointer";></td>
                    </tr>
                  </table></td>
                <td height="3">&nbsp;</td>
              </tr></form>
            </table> </td>
        </tr>
      </table></td>
    <td width="10"></td>
  </tr>
  <tr>
    <td width="10" height="10"></td>
    <td height="10"></td>
    <td width="10" height="10"></td>
  </tr>
</table>
</body>
</html>
