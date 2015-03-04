<?
if($query == "qin"){
	$regdate = time();
	$useremail = $useremail1."@".$useremail2;
	$sqlstr = "insert into wiznewsletterregister (userid,username,usercom,userdep,usertel,useremail,regdate) 
	values 
	('$userid','$username','$usercom','$userdep','$usertel','$useremail','$regdate')";
	$result = $dbcon->_query($sqlstr);
	
	//echo "sqlstr = $sqlstr <br />";
	if($result){
		echo "<script >alert('정상적으로 신청되었습니다.\\n');opener.location.reload();self.close();</script>";
		exit;
	}
}else if($query == "qup"){
	$useremail = $useremail1."@".$useremail2;
	$sqlstr = "update wiznewsletterregister set
	userid = '$userid',
	username = '$username',
	usercom = '$usercom',
	userdep = '$userdep',
	usertel = '$usertel',
	useremail = '$useremail'
	where uid = '$uid'";
	$result = $dbcon->_query($sqlstr);
	
	//echo "sqlstr = $sqlstr <br />";
	if($result){
		echo "<script >alert('정상적으로 수정되었습니다.');opener.location.reload();self.close();</script>";
		exit;
	}
}

if(trim($uid)){
	$mode = "qup";
	$sqlstr = "select * from wiznewsletterregister where uid = '$uid'";
	$dbcon->_query($sqlstr);
	$list = $dbcon->_fetch_array();
	$useremail = explode("@", $list["useremail"]);
}else{
	$mode = "qin";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>::: WISEPOST Partners :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>">
<link href="../body.css" rel="stylesheet" type="text/css">
<script  language="javascript">
<!--
function checkForm(){
	var f = document.MailRegForm;
if(!f.checkenable) checkenable = new Array(); 
    if(f.checkenable){
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
}
//-->
</script>
</head>
<body>
<table>
<form name="MailRegForm" method="post" action="<?=$PHP_SELF;?>" onSubmit="return checkForm();">
<input type="hidden" name="query" value="<?=$mode?>">
<input type="hidden" name="uid" value="<?=$uid?>">
  <tr> 
    <td><table>
        <tr>
          <td><img src="../popup/image/mail_title.gif" width="380" height="100"></td>
        </tr>
        <tr>
          <td><table>
			  <tr>
                <td><img src="../popup/image/mail_01.gif"></td>
                <td><input name="username" type="text" class="mail-input" id="checkenable" title="성명을 입력해 주세요" value="<?=$list[username]?>" size="40"></td>
              </tr>
              <tr>
                <td><img src="../popup/image/mail_02.gif"></td>
                <td><input name="useremail1" type="text" class="mail-input" id="checkenable" title="이메일을 입력해 주세요" value="<?=$useremail[0]?>" size="15">
				@
				<input name="useremail2" type="text" class="mail-input" id="checkenable" title="이메일을 입력해 주세요" value="<?=$useremail[1]?>" size="20"></td>
              </tr>
              <tr>
                <td><img src="../popup/image/mail_03.gif"></td>
                <td><input name="usercom" type="text" class="mail-input" id="usercom" value="<?=$list[usercom]?>" size="40"></td>
              </tr>
			  <tr>
                <td><img src="../popup/image/mail_04.gif"></td>
                <td><input name="userdep" type="text" class="mail-input" id="userdep" value="<?=$list[userdep]?>" size="40"></td>
              </tr>
			  <tr>
                <td><img src="../popup/image/mail_05.gif"></td>
                <td><input name="usertel" type="text" class="mail-input" id="usertel" value="<?=$list[usertel]?>" size="40"></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td><table>
              <tr>
                <td><img src="../popup/image/mail_bottom.gif"></td>
              </tr>
              <tr>
                <td><table>
                    <tr> 
                      <td><img src="../image/blank.gif" ></td>
                      <td><input type="image" src="../notice/image/bt_submit.gif" hspace="0"></td>
                      <td><a href="javascript:window.close();" onFocus="this.blur()"><img src="../notice/image/bt_cancel.gif" width="57" hspace="0"></a></td>
                      </tr>
                    </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr></form>
</table>
</body>
</html>
