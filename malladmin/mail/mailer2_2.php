<?
include "../config/cfg.core.php";
//$MART_BASEDIR;
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
2003.10.10 등급별메일발송 추가
2004. 05. 12 스킨선택기능 삽입
2004. 06. 14 보내는 메일 DB저장 연동
2004. 09. 16 보내는 메일서버에서 폼의 위치를 프로그램으로 통일(mall/web)
 */

//header("Content-type:text/html");
?>
<?
function inputTo($uid, $to){
	$sqlstr = "update wizSendmaillist set tomember = concat(tomember, '{$to};') where uid = $uid"; 
	$dbcon->_query($sqlstr);
}

if($MailSkin) { 
$contenttype = 0; // 메일폼을 html로 고정 
$body_txt = eregi_replace("<", "&lt;", $body_txt);
$body_txt = eregi_replace(">", "&gt;", $body_txt);
$body_txt = eregi_replace("\"", "&quot;", $body_txt);
$body_txt = eregi_replace("\|", "&#124;", $body_txt);
$body_txt = nl2br($body_txt);


if(eregi("malladmin", $PHP_SELF)) $wizsolution = "malladmin";
else if(eregi("malladmin", $PHP_SELF)) $wizsolution = "webadmin";

//Pls Leplace Mail
$file_list = file($cfg["admin"]["MART_BASEDIR"]."/$wizsolution/mailskin/$MailSkin/mailform.php");
for($i=0; $i < sizeof($file_list); $i++){
$mailform .= $file_list[$i];
}
$body_txt = ereg_replace("Pls Leplace Mail",$body_txt,$mailform);
}
?>
<p>&nbsp;</p>
<table>
  <tr>
    <td> <table>
        <form name="messageform" method="post" action="<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=mail/mail2" enctype='multipart/form-data'>
          <tr> 
            <td> 메일발송중!!!!</td>
          </tr>

          <tr> 
            <td> &nbsp;&nbsp;&nbsp;&nbsp; <p>메일을 보내고 있습니다. 잠시만 기다려 
                주십시요!</p>
              <p>(서버 Traffic 상 다수의 메일 발송은 문제가 될 수 있습니다.)</p>
</td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
<p><br />
</p>
<?
$id = "$FromName";
if($query == "grade") $ulevel = $grade;  else $ulevel = "전체";
if($query == "sex") $sex = $sex;  else $sex = "전체";
$comment = $body_txt;
$signdate = time();
$sqlstr = "insert into wizSendmaillist (uid,id,ulevel,sex,job,subject,comment,signdate)
values('$uid','$id','$ulevel','$sex','$job','$subject','$comment','$signdate')";
$dbcon->_query($sqlstr);
unset($sqlstr);
/* 보내는 메일 저장이 있으면 메일 DB에 저장 끝 */
#Sendmail의 uid 값을 가져온다.
$sqlstr = "select max(uid) from wizSendmaillist";
$Send_uid = $dbcon->get_one($sqlstr);


$contenttype=trim($contenttype);
if(!$reply) $reply = $FromEmail;

        if ($userfile_size) {
        $f = fopen($userfile, "r");
        $filedata = fread($f, filesize($userfile));
        fclose($f); unlink($userfile);
        $AttachFile[] = array("name" => $userfile_name, "data" => $filedata);
        unset($filedata);
        }

        $charset="UTF-8";
        $textencode="8bit";
        $charset = $charset =! "" ? "; charset=$charset" : "";
        $add_header = "From: $FromName<$FromEmail>\n";
        $add_header .= "Reply-To: $reply\n";
        if ($AttachFile == "") { /* 첨부 파일이 없을 경우 */
                if (!strcmp($contenttype,"0")) {
                        $add_header .= "MIME-Version: 1.0\n";
                        $add_header .= "Content-Type: text/html$charset\n"; }
                else $add_header .= "Content-Type: text/plain$charset\n";
        $add_header .= "ShopWiz-Mailer: WizMall Mailer";;
        }
        else {/* 첨부 파일이 있을 경우 */
                $boundary = "___==MultiPart_" . strtoupper(md5(uniqid(rand()))) . "==___";
                $add_header .= "MIME-Version: 1.0\n";
                $add_header .= "Content-type: multipart/mixed; BOUNDARY=\"$boundary\"\n";
                $add_header .= "ShopWiz Mailer : WizMall Mailer ver1.0 \n\n";;
                $add_header .= "This is a multi-part message in MIME format.\n\n";
                $add_header .= "--$boundary\n";
                if (!strcmp($contenttype,"0")) $add_header .= "Content-Type: text/html$charset\n";
                else $add_header .= "Content-Type: text/plain$charset\n";

                $add_header .= "Content-Transfer-Encoding: $textencode\n\n";
                $add_header .= $body_txt . "\n\n";

                for ($i=0; $i < sizeof($userfile); $i++) {
                        $add_header .= "--" . $boundary . "\n";
                        $add_header .= "Content-Type: application/octet-stream;";
                        $add_header .= " name=\"" . $AttachFile[$i][name] . "\"\n";
                        $add_header .= "Content-Transfer-Encoding: base64\n";
                        $add_header .= "Content-Disposition: attachment;";
                        $add_header .= " filename=\"" . $AttachFile[$i][name] . "\"\n\n";
                        $filedata = base64_encode($AttachFile[$i][data]);  // 첨부파일경우 파일을 base64_encode로 변경
                        $filedata = chunk_split($filedata);// 첨부파일경우 파일을 base64_encode로 변경
                        $add_header .= $filedata . "\n";// 첨부파일경우 파일을 base64_encode로 변경
                }
                $add_header .= "--" . $boundary . "--\n";
                $body_txt = "";
        }
$body_txt = ereg_replace("\r?\n\.\r?\n", "\n .\n", $body_txt);
$body_txt = stripslashes($body_txt);
$add_header = ereg_replace("\r?\n\.\r?\n", "\n .\n", $add_header);

if($querymass != "amail"){
$MailArr = explode("\n", $userMailList);
$MailCount = sizeof($MailArr);

//echo "\$MailCount = $MailCount <br />";
//exit;
//        $number_rows = @$dbcon->_num_rows($result);
        $seq=0;
        for($start_number=0 ; $start_number<$MailCount ; $start_number++)
        {
				$MailArr[$seq] = ereg_replace("\r", "", $MailArr[$seq]);
				$MailArr[$seq] = ereg_replace("\n\r", "", $MailArr[$seq]);
                 $mailto = trim($MailArr[$seq]);
				//echo "\$mailto = $mailto <br />";
       if(mail($mailto, $subject, $body_txt, $add_header)){
                        $seq++;
						inputTo($Send_uid, $mailto);
                       echo "$mailto <br />";
                        flush(stdout);
                        usleep(50000);
                }
                else{
            echo "Mail전송 실패";
                       //exit;
               }
        } //for문 닫음
} else if($querymass == "amail"){

            if(mail($personalmass, $subject, $body_txt, $add_header)){
				echo "{$personalmass}님께 멜이 발송되었습니다";
				inputTo($Send_uid, $personalmass);
//              if(mail($amail, $subject, "", $add_header))  echo "$amail님께 멜이 발송되었습니다";
             }else echo "${personalmall}님께 Mail전송실패";
			 $seq = 1;
			 echo "<script >window.alert('$seq 개의 메일 발송을 완료하였습니다.'); history.go(-1);< /script>";
			 exit;
          }
//exit;		  
//mysql_close($connect);
echo "$seq 개의 메일 발송을 완료하였습니다.";

/* 메일 전송 완료 후 현재 wizmailservice.SendResult를 'sucess' 로 변경한다. */
echo "<script >window.alert('$seq 개의 메일 발송을 완료하였습니다.'); history.go(-1);< /script>";
?>