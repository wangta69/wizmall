<?php
if($cfg["member"]["mgrade"] == "") $common->js_alert("로그인해주시기 바랍니다.","./default.php");
unset($AccessAllowed);
if(!$theme) { //popup 이나 iframe 일경우
	$theme = $PHP_SELF;
}
$AccessAllowed = array(
 "front"=>array("1","1","1","1","1","1","0","0","0","0","0"),
 "basicconfig/basic_info2"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "basicconfig/basic_info4"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "basicconfig/main01"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "basicconfig/basic_info8"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "basicconfig/basic_info9"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "member/member1"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "member/member_stat"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "member/member3"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "member/member5"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "member/member5_1"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "member/member10"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "mail/mailer1"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "mail/mailer2"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "mail/mailer3"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "mail/address1"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "board/boardadmin"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "avatar/avatar_list"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "visitor/visitor1"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "util/util1"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "product/game1"=>array("1","0","0","0","0","0","0","0","0","0","0"), 
 "product/game2"=>array("1","0","0","0","0","0","0","0","0","0","0"), 
 "product/gamepoint"=>array("1","0","0","0","0","0","0","0","0","0","0"), 
 "product/news"=>array("1","0","0","0","0","0","0","0","0","0","0"),  
 "product/newslist"=>array("1","0","0","0","0","0","0","0","0","0","0"),  
 "product/newspoint"=>array("1","0","0","0","0","0","0","0","0","0","0"),  
 "product/journal"=>array("1","0","0","0","0","0","0","0","0","0","0"),   
 "product/journallist"=>array("1","0","0","0","0","0","0","0","0","0","0"),   
 "product/journalpoint"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "/malladmin/member/member1_1.php"=>array("1","0","0","0","0","0","0","0","0","0","0"),
 "/malladmin/member/member1_2.php"=>array("1","0","0","0","0","0","0","0","0","0","0"), 
 "/malladmin/product/gameserviceeva.php"=>array("1","0","0","0","0","0","0","0","0","0","0"),
"/malladmin/product/refgame.php"=>array("1","0","0","0","0","0","0","0","0","0","0")
 ); 
 
$access_grade = $cfg["member"]["mgrade"]-1;
if(!$admin->accessGrade($cfg["member"]["mgrade"])){
	if($cfg["member"]["mgrade"] != "admin" && !$AccessAllowed[$theme][$access_grade]){
		$common->js_alert("접근이 금지된 페이지 입니다.");
	}
}