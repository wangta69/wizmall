<?php
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
include "../../../lib/inc.depth3.php";
include "../../../lib/class.board.php";
$board = new board();
$board->get_object($dbcon, $common);
$board->cfg = $cfg;

$tb_name="wizTable_${GID}_${BID}_reply";
//include "../../../config/wizboard/table/${GID}/${BID}/config.php";

if($mode==ok) {
	if($UID=='') $common->js_alert("잘못된 경로의 접근입니다.","/wizboard.php?BID=$BID&GID=$GID");

	/* 현재 삭제될 글의 상세정보를 가져온다 */
	
	$sqlstr="SELECT ID,NAME,PASSWD FROM $tb_name WHERE UID='$UID'";
	$list=$dbcon->get_row($sqlstr);
	$list["PASSWD"]=trim($list["PASSWD"]);
	
	/*** ADMIN 패스워드 가져오기 ******/
	$ADMIN_STR="SELECT Pass FROM wizTable_Main WHERE BID='$BID' and GID='$GID'";
	$ADMINPWD=$dbcon->get_one($ADMIN_STR);;
	
	/*** 글 작성자 패스워드 가져오기 *****/
	if($member != "1"){ //회원제가 아닐경우
		if($passwd != $list["PASSWD"] && $passwd !=$ADMINPWD) $common->js_alert("패스워드가 틀립니다.");
	
	}else if(!$board->is_admin("../../../")){ //회원제일 경우 로그인 여부를 책크 및 로그인 아이디및 게시판 아이디 필드를 비교한다. 
		if(!$cfg["member"]) $common->js_windowclose("먼저 로그인 하여 주시기 바랍니다.");
		if(!trim($list[ID]) || ($cfg["member"]["mid"] != $list[ID])){
			$common->js_windowclose("글을 삭제할 권한이 없습니다 \\n\\n 글작성시 아이디로 로긴 하여 주시기 바랍니다.");
		}
	}

/******* 테이블로 부터 정보 삭제 *********/
	$board->deletereple($UID, $tb_name);
	$goto = "../../../wizboard.php?BID=${BID}&GID=${GID}&mode=view&adminmode=${adminmode}&UID=${BUID}&cp=${cp}&BOARD_NO=${BOARD_NO}";
	$common->js_windowclose("게시물을 삭제했습니다.", $goto);
}
?>
<head>
<title>글 삭제</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>">
<script>
function sSubmit(){
var f =  document.delete_form;
checkenable = new Array(); 
    if(f.checkenable && !f.member.checked){
    var checkenablelen = f.checkenable.length
        for (i = 0; i < checkenablelen; i++){
            if(f.checkenable[i].value == ""){
            alert(f.checkenable[i].title);
            f.checkenable[i].focus();
            return false;
            }
        }
        if(!checkenablelen && f.checkenable.value == ""){
        alert(f.checkenable.title);
        f.checkenable.focus();
        return false;
        }
    }
	
    f.submit();
}
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<center>
  <?
/* 회원 및 비회원게시판일 경우(즉, 패스워드 입력이 있고 없고에 따라 삭제 모드 표시를 달리 한다. */
$sqlstr="SELECT ID FROM $tb_name WHERE UID='$UID'";
$ID = $dbcon->get_one($sqlstr);
if(!$ID && !$board->is_admin("../../../")): //회원제 전용이 아닐 경우(즉, 패스워드 폼이 필요없을 경우)
?>
  <table width="100%" height="100%" border=0 cellpadding="0" cellspacing="0" style=font-family:'굴림';font-size:12px;line-height:20px;color:#333333>
    <form name="delete_form" action="<?=$PHP_SELF?>" method=post>
      <input type='hidden' name='mode' value='ok'>
      <input type='hidden' name='UID' value='<?=$UID?>'>
      <input type='hidden' name='cp' value='<?=$cp?>'>
      <input type='hidden' name='BID' value='<?=$BID?>'>
      <input type='hidden' name='GID' value='<?=$GID?>'>
      <input type='hidden' name='adminmode' value='<?=$adminmode?>'>
      <input type='hidden' name='BUID' value='<?=$BUID?>'>
      <tr align="center">
        <td height="5" bgcolor="#999999"></td>
      </tr>
      <tr align="center">
        <td height="50" bgcolor="#EEEEEE">글 작성 시의 <strong><font color="#0000FF">비밀번호</font></strong>를 
          입력해주세요<br>
          삭제된 글은 <font color="#FF0000">복구가 불가능</font>합니다.</td>
      </tr>
      <tr>
        <td height="30" align="center">비밀번호:
          <input type="password" name="passwd" size="10" style='BACKGROUND-COLOR: white; BORDER: 1; HEIGHT: 18px; border-bottom: black 1px solid; border-left: black 1px solid; border-right: black 1px solid; border-top: black 1px solid;' id="checkenable" title="비밀번호를 입력해 주세요";>
          <input type="checkbox" name="member" value="1">
          회원제</td>
      </tr>
      <tr>
        <td align="center" bgcolor="#EEEEEE" height="100%"><input type="button" value="삭제하기" onClick="javascript:sSubmit();" style="border-bottom: black 1px solid; border-left: black 1px solid; border-right: black 1px solid; border-top: black 1px solid; height:40;">
          &nbsp;
          <input type="button" value="취소하기" onClick="javascript:window.close();" style="border-bottom: black 1px solid; border-left: black 1px solid; border-right: black 1px solid; border-top: black 1px solid; height:40;"></td>
      </tr>
    </form>
  </table>
  <script language="JavaScript">
document.delete_form.passwd.focus();
</script>
  <? 
else: //회원제 전용일 경우 
?>
  <table width="100%" height="100%" border=0 cellpadding="0" cellspacing="0" style=font-family:'굴림';font-size:12px;line-height:20px;color:#333333>
    <form name="delete_form" action="<?=$PHP_SELF?>" method=post>
      <input type='hidden' name='mode' value='ok'>
      <input type='hidden' name='UID' value='<?=$UID?>'>
      <input type='hidden' name='cp' value='<?=$cp?>'>
      <input type='hidden' name='BID' value='<?=$BID?>'>
      <input type='hidden' name='GID' value='<?=$GID?>'>
      <input type='hidden' name='adminmode' value='<?=$adminmode?>'>
      <input type="hidden" name="member" value="1">
      <input type='hidden' name='BUID' value='<?=$BUID?>'>
      <tr align="center">
        <td height="5" bgcolor="#999999"></td>
      </tr>
      <tr align="center">
        <td height="50" bgcolor="#EEEEEE"><br>
          삭제된 글은 <font color="#FF0000">복구가 불가능</font>합니다.</td>
      </tr>
      <tr>
        <td height="30" align="center">정말삭제하시겠습니까?</td>
      </tr>
      <tr>
        <td align="center" bgcolor="#EEEEEE" height="100%"><input type="button" value="삭제하기" onClick="javascript:sSubmit();" style="border-bottom: black 1px solid; border-left: black 1px solid; border-right: black 1px solid; border-top: black 1px solid; height:40;">
          &nbsp;
          <input type="button" value="취소하기" onClick="javascript:window.close();" style="border-bottom: black 1px solid; border-left: black 1px solid; border-right: black 1px solid; border-top: black 1px solid; height:40;"></td>
      </tr>
    </form>
  </table>
  <?
endif;
?>
</center>
</body>
</html>