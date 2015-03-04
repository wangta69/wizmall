<?
include "../lib/class.mail.php";
$class_mail		= new classMail();

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
 */

//header("Content-type:text/html");
?>
<div class="agn_c">
<p>&nbsp;</p>
<p class="red"> 메일발송중.....</p>
<p>메일을 보내고 있습니다. 잠시만 기다려  주십시요!</p>
<p>(서버 Traffic 상 다수의 메일 발송은 문제가 될 수 있습니다.)</p>
<div>
<br />
<?
function inputTo($uid, $to){
	global $dbcon;
	$sqlstr = "update wizSendmaillist  set tomember = concat(tomember, '{$to};') where uid = $uid"; 
	$dbcon->_query($sqlstr);
}


$Roopcnt = $Roopcnt ? $Roopcnt : 1000;//1000개씩 메일 발송
$currentRoop = $currentRoop ? $currentRoop : 1;//for 문에의한 반복 횟수 설정
$startno = ($currentRoop - 1) * $Roopcnt;

//echo "startno:".$startno;
$sendMailCnt = $sendMailCnt ? $sendMailCnt : 0;//메일발송수

if($currentRoop == "1"){//현재 페이지를 계속해서 돌린다.(현재는 1page);
//첨부파일을 배열에 저장해 둔다.
//print_r($userfile);
	if ($userfile!="none" && $userfile["size"]) {
	$userfile_name	= $userfile["name"];
	  if(!move_uploaded_file($userfile["tmp_name"], "../config/tmp_upload/".$userfile["name"])) {
			echo "파일 업로드에 실패 하였습니다.";
        	exit;
    	}
	}

	$sqlstr = "insert into wizSendmaillist 
	(sendername,senderemail,reply,subject,contenttype,mailskin,body_txt,userfile,addsource,soption,mailreject,startseq,stopseq,genderselect,gradeselect,testmailaddress,usermaillist,sdate)
	values
	('$FromName','$FromEmail','$reply','$subject','$contenttype','$MailSkin','$body_txt','$userfile_name','$addsource','$soption','$mailreject','$startseq','$stopseq','$genderSelect','$gradeSelect','$testMailAddress','$userMailList',".time().")";
	$dbcon->_query($sqlstr);
	
	/* 보내는 메일 저장이 있으면 메일 DB에 저장 끝 */
	#Sendmail의 uid 값을 가져온다.
	$Send_uid = $dbcon->_insert_id();
}


// 저장된 정보를 다시 가져온다.
// 이렇게 바로 처리하지 않고 하는 이유는 for문을 통한 메일 발송때문에 처리하였습니다.

$sqlstr = "select * from wizSendmaillist  where uid = '$Send_uid'";
$dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array();
$FromName			= $list["sendername"];
$FromEmail			= $list["senderemail"];
$reply				= $list["reply"];
$subject			= $list["subject"];
$contenttype		= $list["contenttype"];
$MailSkin			= $list["mailskin"];
$body_txt			= $list["body_txt"];
$userfile_name		= $list["userfile"];
$addsource			= $list["addsource"];
$soption			= $list["soption"];
$mailreject			= $list["mailreject"];
$startseq			= $list["startseq"];
$stopseq			= $list["stopseq"];
$genderSelect		= $list["genderselect"];
$gradeSelect		= $list["gradeselect"];
$testMailAddress	= $list["testmailaddress"];
$userMailList		= $list["usermaillist"];


$userfile = "../config/tmp_upload/".$userfile_name;
unset($AttachFile);
if(is_file($userfile)){
	$f = fopen($userfile, "r");
	$filedata = fread($f, filesize($userfile));
	fclose($f);
	$AttachFile[] = array("name" => $userfile_name, "data" => $filedata);
	unset($filedata);
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

$id = "$FromName";
$comment = addslashes($body_txt);
$contenttype=trim($contenttype);
if(!$reply) $reply = $FromEmail;


if ($soption != "") {
	if ($AttachFile == "") { /* 첨부 파일이 없을 경우 */
		if (!strcmp($contenttype,"0")) {
			$add_header .= "MIME-Version: 1.0\n";
			$add_header .= "Content-Type: text/html$charset\n"; 
		}else{
			$add_header .= "Content-Type: text/plain$charset\n";
		}
//	$add_header .= "ShopWiz-Mailer: WizMall Mailer";;
	}else {/* 첨부 파일이 있을 경우 */
		$boundary = "___==MultiPart_" . strtoupper(md5(uniqid(rand()))) . "==___";
		$add_header .= "MIME-Version: 1.0\n";
		$add_header .= "Content-type: multipart/mixed; BOUNDARY=\"$boundary\"\n";
		$add_header .= "ShopWiz Mailer : WizMall Mailer ver1.0 \n\n";;
		$add_header .= "This is a multi-part message in MIME format.\n\n";
		$add_header .= "--$boundary\n";
		if (!strcmp($contenttype,"0")){ 
			$add_header .= "Content-Type: text/html$charset\n";
		}else{
			$add_header .= "Content-Type: text/plain$charset\n";
		}
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

}

$class_mail->charset = 'UTF-8';//한국어
$class_mail->Priority (3);
$class_mail->From ($FromEmail, $FromName);
$class_mail->ReplyTo ($reply, "");

$class_mail->Subject ($subject);
$class_mail->Body ($body_txt);

if($soption == "testMail"){

	$class_mail->To ($testMailAddress);
	if($class_mail->Send()){  
		echo $testMailAddress."님께 멜이 발송되었습니다";
		inputTo($Send_uid, $testMailAddress);
	}else echo "${testMailAddress}님께 Mail전송실패";

	$seq = 1;
	echo "<script >window.alert('$seq 개의 메일 발송을 완료하였습니다.'); history.go(-1);< /script>";
	exit;

}else{
	include "./mail/shopwizMemberInfo.php";

	if(is_array($rEmail)){
		foreach($rEmail as $key => $value){
			if(trim($value)){
				$mailto	= trim($value);
				$name	= trim($rEmail[$key]);		
				$class_mail->To ($mailto);
				if($class_mail->Send()){ 
					$sendMailCnt++;
					inputTo($Send_uid, $mailto);
					echo "성공메일 : $mailto <br />";
					flush(stdout);
					usleep(50000);
				}else{
					echo "$mailto : Mail전송 실패 <br />";
				}
			}//if(trim($value)){
		}//foreach($xml_parser->filename["ORDNO"] as $key => $value){
	}

	if($startno < $totalmail){
		echo "<script >location.replace('$PHP_SELF?menushow=$menushow&theme=$theme&Send_uid=$Send_uid&currentRoop=".($currentRoop+1)."&sendMailCnt=$sendMailCnt');</script>";		
	}
}

echo "$sendMailCnt 개의 메일 발송을 완료하였습니다.";
/* 메일 전송 완료 후 현재 wizmailservice.SendResult를 'sucess' 로 변경한다. */
echo "<script >window.alert('$seq 개의 메일 발송을 완료하였습니다.'); history.go(-1);< /script>";
?>