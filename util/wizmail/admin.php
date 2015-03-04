<?
include "../../lib/cfg.common.php";
if(!strcmp($mode,"saveThis")){
$STRING = "
\<\?
\$WizMailSkin = \"".$wizskin."\";
\$cfg[\"admin\"][\"ADMIN_EMAIL\"] = \"".$cfg["admin"]["ADMIN_EMAIL"]."\";
\?>";

$fp = fopen("../../config/mailcfg.php", "w");
fwrite($fp, "$STRING"); 
fclose($fp);

}

include "../../config/mailcfg.php";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>위즈폼메일 스킨선택</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>">
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="42"><strong><font color="#333399">WizFormMailer ver.1.1</font></strong></td>
  </tr>
  <form name="WizMailFormFrm" action="<?=$PHP_SELF?>">
    <input type="hidden" name="mode" value="saveThis">
    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td align="center"> <table width="96%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td height="16"><p>스킨선택하기</p></td>
          </tr>
          <tr> 
            <?
$skskin_dir = opendir("./skin");
$NO = 1;
        while($skskdir = readdir($skskin_dir)) :
		
                if(($skskdir != ".") && ($skskdir != "..")) {
//				echo "\$skskdir=$skskdir <br>";
?>
            <td height="16"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td align="center"><img src="./skin/<?=$skskdir?>/index.gif"></td>
                </tr>
                <tr> 
                  <td align="center"> <input type="radio" name="wizskin" value="<?=$skskdir?>" <?if(!strcmp($WizMailSkin,$skskdir)) echo"checked";?>> 
                  </td>
                </tr>
              </table></td>
            <?			
                } // if(($skskdir != ".") && ($skskdir != ".."))
				
if(!($NO%2)) echo "</tr><tr>";
else echo "<td>&nbsp;</td>";
$NO++;
/* 여분의 공간을 계산하여 공간을 채운다 */
//if($NO == $TOTAL && ($LAST=$TOTAL%4)){$WIDTH=(25*(5-$LAST))."%";}
				
        endwhile;
closedir($skskin_dir);
?>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td align="center"><table width="95%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td>받는 사람 메일</td>
            <td>: 
              <input name="ADMIN_EMAIL" type="text" value="<?=$cfg["admin"]["ADMIN_EMAIL"]?>"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td align="center"><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </form>	
    <tr> 
      <td align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">/****************************************************************************************************/<br>
        /*<br>
        WizForm Mailer ver 1.1<br>
        제작자 : 폰돌<br>
        이메일 : master@shop-wiz.com<br>
        모든 라이센스는 본인한테 있습니다.<br>
        상업적인 목적없이 자유 배포가 가능합니다.<br>
        */
        
      <p>링크방법 : <br>
          &lt;A HREF=&quot;javascript: void(window.open('경로/wizmail/wizmail.php','WizFormMailler','height=460, 
          width=400'));&quot;&gt;E-mail&lt;/A&gt;</p>
        <p>예)<br>
          &lt;A HREF=&quot;javascript: void(window.open('./util/wizmail/wizmail.php','WizFormMailler','height=460, 
          width=400'));&quot;&gt;E-mail&lt;/A&gt;</p>
        <p>사용법<br>
          퍼미션조절 : wizmail/tmpdir의 퍼미션을 707로 조절한다.<br>
          wizmail/config의 퍼미션을 707로 조절한다.<br>
          <br>
          관리자 모드 : ./util/wizmail/admin.php</p>
        <p><br>
          1. 관리자 모드에 접속하여 스킨을 스택하고 받으실 이메일을 선택합니다.<br>
          2. 링크방법을 참조하여 적당하게 링크를 합니다.</p>
        <p>참조로 기본 디렉토리는 ./util/밑으로 넣어시면됩니다.</p>
        <p>신나는 하루 되세요</p></td>
    </tr>

</table>
</body>
</html>
