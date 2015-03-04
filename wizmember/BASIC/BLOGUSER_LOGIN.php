<?
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
?>
<script language="JavaScript">
<!--
function SearchZipcode(){
window.open("./util/zipcode/zipcode.php?form=InquireForm&zip1=zip1&zip2=zip2&firstaddress=Address1&secondaddress=Address2","ZipWin","width=490,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no");
}
function checkForm(){
var f=document.wizBlogForm;
  if(f.subject.value == ''){
  alert('블로그 제목을 입력해 주세요');
  f.subject.focus();
  return false;
  } else if(f.comment.value == ''){
  alert('블로그 소개란을 넣어주세요');
  f.comment.focus();
  return false;
  }
 }
//-->
</script>
<table>
  <tr>
    <td>&nbsp; <table>
	<form name="wizBlogForm" method="POST" action="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/BlogMemberRegisQry.php" onsubmit='return checkForm();' enctype="multipart/form-data">
        <input type="hidden" name="mode" value="writing">
        <tr> 
          <td>블로그 제목</td>
          <td><input type="text" name="subject" class="input_1" style="width:340px;height:18px" maxlength="64"></td>
        </tr>
        <tr> 
          <td colspan="2"></td>
        </tr>
        <tr> 
          <td>블로그 소개</td>
          <td><textarea name="comment" style="width:340px;height:80px" maxlength="254"></textarea></td>
        </tr>
        <tr> 
          <td colspan="2"></td>
        </tr>
        <tr> 
          <td>기본사진</td>
          <td><input type="file" name="file[0]" class="input_1" style="width:340px;height:18px"></td>
        </tr>
        <tr> 
          <td colspan="2"></td>
        </tr>
        <tr> 
          <td>스킨관리</td>
          <td>초기에는 기본 스킨이 적용됩니다.<br />
            변경은 [블로그 관리]를 통해서 자유롭게 수정하실 수 있습니다.</td>
        </tr>
        <tr> 
          <td colspan="2"></td>
        </tr>
        <tr> 
          <td colspan="2"><img src="blogimages/save_btn.gif" width="61" height="21">&nbsp;<img src="blogimages/cancel_btn.gif" width="61" height="21"></td>
        </tr>
        <tr>
          <td colspan="2"></td>
        </tr></form>
      </table></td>
  </tr>
</table>

