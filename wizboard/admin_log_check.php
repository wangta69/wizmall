<?php
/*
 제작자 : 폰돌                     
 URL : http://www.shop-wiz.com      
 Email : master@shop-wiz.com       
 Copyright (C) 2003  shop-wiz.com 
 *********** Updating List *******************
 2003-09-29 - 메인에서클릭 후 수정클릭시 로그인 후 다시 리스트 페이지가 보이던 버그 수정
 2004-04-17 category 변수 추가
*/

include "../lib/inc.depth1.php";

if(!strcmp($Mode, "MemberLogin")): /* Board Member로 로그인시 */
	$sqlstr = "SELECT * FROM wizTable_Main WHERE BID ='".$BID."'";
	$dbcon->_query($sqlstr);
	$list = $dbcon->_fetch_array();

	if(!strcmp($mode,"down"))
	$url="../wizboard.php?BID=".$BID."&GID=".$GID."&mode=view&UID=".$UID."&category=".$category."&adminmode=".$adminmode;
	else
	$url="../wizboard.php?BID=".$BID."&GID=".$GID."&category=".$category."&mode=".$nmode."&adminmode=".$adminmode."&UID=".$UID."&cp=".$cp;

	if($MEMBERPASS == $list["Pass"]){
		setcookie($GID."_".$BID."_MEMBER_PASS", $MEMBERPASS, 0, "/");
		
		$str = "\\n 보드 MEMBER로 로그인 되셨습니다. \\n";
		$goto = $url;
		$common->js_alert($str, $goto);
	}else{
		$goto = "../wizboard.php?BID=".$BID."&GID=".$GID."&UID=".$UID."&category=".$category."&adminmode=".$adminmode."&cp=".$cp."&mode=".$nmode;
		$common->js_location($goto);
	}
else:  /* Main Admin으로 로그인시 */
	$member->membertype="admin";
	$rtn= $member->login_check($ADMINID, $ADMINPASS);//로그인처리

	if($rtn["result"] == "0"){
		$goto = "./admin.php";
		$str = "로그인 되셨습니다.";
		$common->js_alert($str, $goto);
	}else{

		$goto = "./main.php";
		$str = $rtn["msg"];
		$common->js_alert($str, $goto);
	}

endif;			