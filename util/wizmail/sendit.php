<?
// 메일 보내는 라이브러리 불러옴
$Dir="."; //현재 sendit.php가 있는 경로
require_once("./mail.php");
/*
$body 내용
$mType 메일 타입(text/planin, text/html)
$MailTo 받는 사람
$MailFrom = "보내는사람 명 <보내는 사람 메일주소>";
$MailSubject = 제목
$MailBody = 내용
$charset = "euc-kr"; 언어
*/
$charset = "euc-kr";
if($mType == 0)
    $mType = 'text/plain';
else
    $mType = 'text/html';




$m = new Mail(); //메일 객체 생성
$nameFrom="${FromName}<${FromEmail}>";
$m->From( $nameFrom ); //보낸사람

$i = 0;
while( $i<count($nameTo) )
{
	$m->To( $nameTo[$i] ); //받는사람	
	$i++;
}

$m->Subject( $subject ); //제목
$m->Body( $comment, $charset, $mType ); //메일 내용, charset
$m->Priority(0); //메일 중요도



$up_dir = "./tmpdir"; // 첨부파일이 저장될 위치(701 혹은 707 권한)
//파일 업로드를 할수있게 클래스를 생성한다.
require("./attach.php");
$F = new upload( "", "134217728", "$Dir/$up_dir" );

$i = 0;
$n = 0;
while( $i<count($file) )
{
	if( $file[$i] )
	{
		$filetype[$n] = $file_type[$i];
		$ofilename[$n] = $file_name[$i];
		$filesize[$n] = $file_size[$i];

		$filename[$n] = $F -> putFile("$filetype[$n]", "$ofilename[$n]", "$filesize[$n]", "$file[$i]");
		$m->Attach( "$Dir/$up_dir/$filename[$n]", "$filetype[$n]" );
		$n++;
	}
	$i++;
}



$a = $m->Send(); //메일 보내기

$i = 0;
while( $i<count($filename) )
{
	if( $filename[$i] && file_exists("$Dir/$up_dir/$filename[$i]") )
	{
		unlink("$Dir/$up_dir/$filename[$i]");
	}
	$i++;
}

?>