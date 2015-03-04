<?php
/*

 제작자 : 폰돌                     
 URL : http://www.shop-wiz.com      
 Email : master@shop-wiz.com       
 Copyright (C) 2003  shop-wiz.com 
*/


$url="./wizboard/secret_log_check.php?BID=$board->bid&GID=$board->gid&Mode=MemberLogin&UID=$board->uid&mode=$mode&nmode=$nmode&adminmode=$adminmode&optionmode=$optionmode&cp=$cp&ExtendDB=$ExtendDB&category=$category";
if($board->is_admin()){
	echo "<HTML><META http-equiv=\"refresh\" content =\"0;url=${url}\"></HTML>";
	exit;
}

if($cfg["member"]){
	$sqlstr = "select count(UID) from $tb_name where UID = $UID and ID='".$cfg["member"]["mid"]."'";
	$result = $dbcon->get_one($sqlstr);
	if($result){
		echo "<HTML><META http-equiv=\"refresh\" content =\"0;url=${url}\"></HTML>";
		exit;
	}
}
?>

<script language=javascript>
<!--
$(function(){
	$(".focus").focus();
});


function loginForm(f) {
	if ( !f.MEMBERPASS.value.length ) {
		alert('\n패스워드를 입력해 주십시오. \n');
		f.MEMBERPASS.focus();
		return false;
	}
}
//-->
</script>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><br>
      <br>
      <br>
      <br> <form action="./wizboard/secret_log_check.php" METHOD="POST" NAME='ADMIN_LOG' onsubmit='return loginForm(this);'>
      <table width="50%" border=0 align="center" cellpadding="0" cellspacing="0" style=font-family:'굴림';font-size:12px;line-height:20px;color:#333333>
	   
		<input type="hidden" name="BID" value="<?=$board->bid?>">
		<input type="hidden" name="GID" value="<?=$board->gid?>">
		<input type="hidden" name="Mode" value="MemberLogin">
		<input type="hidden" name="UID" value="<?=$board->uid?>">
		<input type="hidden" name="mode" value="<?=$mode?>">
		<input type="hidden" name="adminmode" value="<?=$adminmode?>">
		<input type="hidden" name="optionmode" value="<?=$optionmode?>">
		<input type="hidden" name="nmode" value="<?=$nmode?>">
		<input type="hidden" name="cp" value="<?=$cp?>">
		<input type="hidden" name="ExtendDB" value="<?=$ExtendDB?>">
		<input type="hidden" name="category" value="<?=$category?>">
      <tr align="center"> 
        <td height="5" bgcolor="#999999"></td>
      </tr>	  
      <tr align="center"> 
        <td height="50" bgcolor="#EEEEEE">글 작성 시의 <strong><font color="#0000FF">비밀번호</font></strong>를 
          입력해주세요<br>
              관리자이면<font color="#0066FF"> 보드관리비번</font> 혹은 <font color="#0066FF">슈퍼관리자비번</font>을 
              입력해주세요</td>
      </tr>
      <tr> 
        <td height="30" align="center" bgcolor="#FFFFFF">비밀번호: 
          <input type="password" name="MEMBERPASS" size="10" class="focus">
      </td>
      </tr>
      <tr> 
        <td align="center" bgcolor="#EEEEEE" height="100%"><input name="Submit" type="submit" style="border-bottom: black 1px solid; border-left: black 1px solid; border-right: black 1px solid; border-top: black 1px solid; height:40;" value="로그인">&nbsp;<input type="button" value="취소하기" onClick="history.go(-1);" style="border-bottom: black 1px solid; border-left: black 1px solid; border-right: black 1px solid; border-top: black 1px solid; height:40;"></td>
      </tr>
   
  </table> </form>
    </td>
  </tr>
</table>