<?php
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
include "../lib/inc.depth1.php";

$member->loginpoint = $cfg["mem"]["LPoint"];//로그인 포인트 지급
$member->saveflag	= $saveflag;//아이디저장여부
$result = $member->login_check($wizmemberID, $wizmemberPWD);//로그인처리
if($result["result"] <> "0"){
	$common->js_alert($result["msg"]);
}
?>
<!DOCTYPE html>
<html lang="kr">
<head>
<meta charset="<?php echo $cfg["common"]["lan"]?>">
<title>무료 쇼핑몰 솔루션 - 숍위즈(http://www.shop-wiz.com)</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg["common"]["lan"]?>" />
<script>
window.alert('\n\n안녕하세요.. \n\n<?php echo $member->meminfo["mname"]?>님께서는 로그인되셨습니다... \n\n즐거운 시간 되세요...   \n\n');
</script>
<?php
/* 팝업창에서 호출하였을 경우 팝업창을 닫는다 */
if(!strcmp($ispopup, "yes")){
    echo "<script>opener.location.reload();top.window.close();</script>";
    exit;
}else if($rtnurl){
	$rtnurl = base64_decode($rtnurl);
	echo "<META http-equiv=\"refresh\" content=\"0;url=".$rtnurl."\"></HTML>";
	exit;	
}else if ($file=="wizboard") { // 게시판
	echo "<META http-equiv=\"refresh\" content=\"0;url=../".$file.".php?BID=".$goto."&GID=".$goto1."&category=".$hiddenvalue1."&mode=".$hiddenvalue2."&UID=".$hiddenvalue3."&op=".$op."\"></HTML>";
	exit;
}else if ($file=="wizbag") { // 장바구니 - 현재방식
	echo "<META http-equiv=\"refresh\" content=\"0;url=../".$file.".php?query=".$goto."check=".$chec."&op=".$op."\"></HTML>";
	exit;
}else if ($file=="wizcafe") { // 장바구니 - 현재방식
	echo "<META http-equiv=\"refresh\" content=\"0;url=../".$file.".php?op=".$op."\"></HTML>";
	exit;
}else if ($file=="wizhtml") { // wizhtml에서 넘어 온 경우
	echo "<META http-equiv=\"refresh\" content=\"0;url=../".$file.".php?html=".$goto."&op=".$op."\"></HTML>";
	exit;
}else if ($file=="wizmypage") { // 마이페이지에서 넘어올 경우(미팅솔루션과 연동)
	echo "<META http-equiv=\"refresh\" content=\"0;url=../".$file.".php?mypage=".$goto."&op=".$op."\"></HTML>";
	exit;
}else if ($file=="wizmember") { //wizmember 에서 넘어오는 경우
	echo "<META http-equiv=\"refresh\" content=\"0;url=../".$file.".php?query=".$goto."&op=".$op."\"></HTML>";
	exit;
//}else if(ereg(".php", $file) || ereg(".html", $file) || ereg(".htm", $file) || ereg(".cgi", $file) || ereg(".php3", $file) ) { // 기타 파일에서 넘어 온 경우
//	echo "<META http-equiv=\"refresh\" content=\"0;url=".$file."\"></HTML>";
//	exit;
}else if($log_from) { // $_SERVER["REQUEST_URI"] 로 만들어진 파일
	echo "<META http-equiv=\"refresh\" content=\"0;url=".$log_from."\"></HTML>";
	exit;
}else {  // 홈
	echo "<META http-equiv=\"refresh\" content=\"0;url=../\"></HTML>";
	exit;
}