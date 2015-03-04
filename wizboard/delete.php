<?php
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/

include "../lib/inc.depth1.php";

include "../lib/class.board.php";
$board = new board();
$board->get_object($dbcon, $common);
$board->cfg = $cfg;

$BOARD_NAME="wizTable_${GID}_${BID}";

$config_include_path = "../config/wizboard/table/$GID/$BID";
include $config_include_path."/config.php";#보드관련 세부 config 관련 정보
$board->cfg = $cfg;//환경설정 파일들을 입력한다.


if($mode=="ok") {
	if($UID=='') {
		$str = "잘못된 경로의 접근입니다.";
		$goto = "../wizboard.php?BID=$BID&GID=$GID";
		$common->js_alert($str, $goto);
	}

	/* 현재 삭제될 글의 상세정보를 가져온다 */
	$sqlstr="SELECT ID,NAME,PASSWD,EMAIL,THREAD,FID,UPDIR1 FROM $BOARD_NAME WHERE UID='$UID'";
	$dbcon->_query($sqlstr);
	$LIST=$dbcon->_fetch_array();
	
	/*** ADMIN 패스워드 가져오기 ******/
	$sqlstr="SELECT Pass FROM wizTable_Main WHERE BID='$BID' and GID='$GID'";
	$ADMINPWD=$dbcon->get_one($sqlstr);

	/*** 글 작성자 패스워드 가져오기 *****/
	if($member != "1" && !$board->is_admin("../")){ //회원제가 아닐경우
		$LIST["PASSWD"]=trim($LIST["PASSWD"]);
		if($passwd != $LIST["PASSWD"] && $passwd !=$ADMINPWD) {
			$common->js_alert("패스워드가 틀립니다.");
		}
	}else if(!$board->is_admin("../")){ //회원제일 경우 로그인 여부를 책크 및 로그인 아이디및 게시판 아이디 필드를 비교한다. 
		if(!$cfg["member"]){
			$str = "글을 삭제할 권한이 없습니다 \\n\\n 먼저 로그인 하여 주시기 바랍니다.";
			$common->js_windowclose($str);
		}else if(!trim($LIST["ID"]) || ($cfg["member"]["mid"] != $LIST["ID"])){
			$str = "글을 삭제할 권한이 없습니다 \\n\\n 글작성시 아이디로 로긴 하여 주시기 바랍니다.";
			$common->js_windowclose($str);
		}
	}

	##만약지우려는 글에 하위리플(리스트에서의 리플)이 달려있는 경우는 삭제불가능 */
	$ReplyComment = $LIST["THREAD"]."A";
	$Sqlstr = "select count(UID) from $BOARD_NAME where FID = '$LIST[FID]' AND THREAD = '$ReplyComment'";
	$count = $dbcon->get_one($Sqlstr);
	if($count > 0){
		$str = "리플이 달린 글은 지울수 없습니다.";
		$common->js_windowclose($str);
	}


	$board->delete_content($UID, $BID, $GID);
	$common->js_windowclose("게시물을 삭제했습니다.", "../wizboard.php?BID=$BID&GID=$GID&category=$category&adminmode=$adminmode&optionmode=$optionmode&cp=$cp");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
<body>
<center>
<?php
/* 회원 및 비회원게시판일 경우(즉, 패스워드 입력이 있고 없고에 따라 삭제 모드 표시를 달리 한다. */
$sqlstr="SELECT ID FROM $BOARD_NAME WHERE UID='$UID'";
$isID = $dbcon->get_one($sqlstr);
//print_r($cfg["member"]);
if(!$isID && $cfg["member"]["mid"] != "admin"): //회원제 전용이 아닐 경우(즉, 패스워드 폼이 필요없을 경우)
?>
  <table width="100%" height="100%" border=0 cellpadding="0" cellspacing="0" style=font-family:'굴림';font-size:12px;line-height:20px;color:#333333>
    <form name="delete_form" action="<?=$PHP_SELF?>" method=post>
      <input type='hidden' name='mode' value='ok'>
      <input type='hidden' name='UID' value='<?=$UID?>'>
      <input type='hidden' name='GID' value='<?=$GID?>'>
      <input type='hidden' name='BID' value='<?=$BID?>'>
      <input type='hidden' name='cp' value='<?=$cp?>'>
      <input type='hidden' name='category' value='<?=$category?>'>
      <input type='hidden' name='adminmode' value='<?=$adminmode?>'>
      <input type='hidden' name='optionmode' value='<?=$optionmode?>'>
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
<script>
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
      <input type='hidden' name='category' value='<?=$category?>'>
      <input type="hidden" name="member" value="1">
      <input type='hidden' name='adminmode' value='<?=$adminmode?>'>
      <input type='hidden' name='optionmode' value='<?=$optionmode?>'>
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
<?php
endif;
?>
</center>
</body>
</html>