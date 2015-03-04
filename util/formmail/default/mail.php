<?
$file = "../util/formmail/dongha/mailform.php";
$HOME_URL = "http://dongha.infoblue.co.kr";
$Tomail = "dongha135@hanmail.net";
//$Tomail = "winkzone@infoblue.co.kr";
$Subject = "제품/견적문의가 접수 되었습니다.";
$From = "견적문의";//이메일이 들어가야함
$From = "From:$From\nContent-Type:text/html";
	$tmpContents = file_get_contents($file);
	$contents = nl2br($contents);
	$tmpContents = ereg_replace("<!--HOME_URL-->",$HOME_URL,$tmpContents);
	$tmpContents = ereg_replace("<!--name-->",$name,$tmpContents);
	$tmpContents = ereg_replace("<!--zip-->",$zip,$tmpContents); 
	$tmpContents = ereg_replace("<!--address1-->",$address1,$tmpContents); 
	$tmpContents = ereg_replace("<!--tel-->",$tel,$tmpContents); 
	$tmpContents = ereg_replace("<!--email-->",$email,$tmpContents); 
	$tmpContents = ereg_replace("<!--subject-->",$subject,$tmpContents); 
	$tmpContents = ereg_replace("<!--contents-->",$contents,$tmpContents); 
	$Contents = $tmpContents;
	
	$result = mail($Tomail, $Subject, $Contents, $From);
?>