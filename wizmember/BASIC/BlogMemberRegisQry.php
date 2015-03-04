<?
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
include ("../../config/db_info.php");


$RegDate = time();
$GrantSta=$cfg["mem"]["EGrantSta"];

/**********************************************************************/
if ( !$Subject || !$Comment ) {
	$Str = "\\n\\n비정상적인 방법으로 접근하였습니다.\\n\\n"; WindowAlert($Str);
}

/*****************************************************************************
  DB CONNECT -> INSERT INTO wizBlogMembers ; DB연결후 회원데이터를 저장한다.
*****************************************************************************/
/* wizBlogMembers
  MID,Subject,Comment,Picture,Skin,GrantSta,RegDate
*/
/* 신규 블로거를 위한 고유 블로그 Room 을 생성한다.*/
$newbloger = $HTTP_COOKIE_VARS[MEMBER_ID];
if(!file_exists("../../wizblogroom/$newbloger")){
$result = mkdir("../../wizblogroom/$newbloger", 0777);
}
if(!file_exists("../../wizblogroom/$newbloger/update")){
$result = mkdir("../../wizblogroom/$newbloger/update", 0777);
}

/* 파일 업로딩 시작 */
unset($Picture);
for($i=0; $i<sizeof($file); $i++){
	if($file[$i]!="none" && $file[$i]){
    	if (file_exists(".../../wizblogroom/$HTTP_COOKIE_VARS[MEMBER_ID]/update/$file_name[$i]")) {
	    $file_name[$i] = date("is")."_$file_name[$i]";
    	}    
	    if(!copy($file[$i], "../../wizblogroom/$HTTP_COOKIE_VARS[MEMBER_ID]/update/$file_name[$i]")) {
    	echo "파일 업로드에 실패 하였습니다.";
	    exit;}
	$Picture .=$file_name[$i]."|";
	}	
}
/* 파일 업로딩 끝 */

$qrystr = "INSERT INTO wizBlogMembers (
MID,Subject,Comment,Picture,Skin,GrantSta,RegDate
)
VALUES(
'$HTTP_COOKIE_VARS[MEMBER_ID]','$Subject','$Comment','$Picture','$Skin','$GrantSta','$RegDate'
)";	
$result = $dbcon->_query($qrystr,$DB_CONNECT);
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>">
<script language=javascript>
window.alert('\n가입이 정상적으로 이루어졌습니다. \n블로그 회원으로 가입해 주신 <?=$HTTP_COOKIE_VARS[MEMBER_NAME]?>님께 진심으로 감사드립니다.');
</script>
<meta http-equiv='refresh' content='0;url=../../myblog.php'>
</head>
<body>
</body>
</html>
