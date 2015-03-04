<?
/*
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
수정자 : 폰돌
URL : http://www.shop-wiz.com
E-mail : master@shop-wiz.com
<!--- UpDate List  ---------------------------------->
마지막 수정일: 2003. 04. 17
2004. 04. 10 - 위즈보드와의 호환성강화(wizmail이 현재 위즈웹이나 위즈보드에서만 가능하던 것을 wizboard에서의 회원 메일 클릭시 팝업이 뜨는 것으로 변경 
*/

if(!strcmp($sendit,"ok")){
include "./sendit.php";
ECHO"<script>window.alert('메일이 성공적으로 발송되었습니다.');
window.close();</script>";
exit;
}


if(!$WizMailSkin) include "./config/config1.php"; /* WizMailSkin 정보가 들어가 있다. wizboard에서 넘어 올경우는 wizMailSkin이 있기 때문에 바로 변수 입력된다.*/
if(!$userEmail){ 
	include "../../config/cfg.core.php"; /* wizmall 이나 wizweb과 호환하기 위해 */
	$ToMail = $cfg["admin"]["ADMIN_EMAIL"];
}else if($userEmail) $ToMail = $userEmail; //$userEmail 은 위즈보드에서 넘어오는 값이다. 
include "./skin/$WizMailSkin/wizmail.php";
?>
