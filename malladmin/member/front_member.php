<?php
include "../common/header_pop.php";
include "../common/header_html.php";
//프론트단의 관리자단과 동일 구성
$mem_skin_path = "../../wizmember/".$cfg["skin"]["MemberSkin"];//

/* 로그인 후 움직이는 페이지 */
unset($status); /* 로그인과 이후 혹은 query 값에 대한 다양한 결과가 요구되므로 $status의 상황에 따라 각각 행동 반경을 정한다. */
$setpath = "../../wizmember/".$cfg["skin"]["MemberSkin"];
if ($cfg["member"]) {
	if ($query == 'point') {
		include ($setpath."/USER_POINT.php");
		$status = $query;
	}
	else if ($query == 'order') {
		include ($setpath."/USER_ORDER.php");
		$status = $query;
	}
	else if ($query == 'info') {
		include ($setpath."/USER_INFO.php");
		$status = $query;
	}
	else if ($query == 'logout') {
		include ("../../wizmember/LOG_OUT.php");
		$status = $query;
	}
	else if ($query == 'wish') {
		include ($setpath."/USER_WISH.php");
		$status = $query;
	}
	else if ($query == "mypage") { /*MyPage Total list */
		include ($setpath."/MYPAGE.php");
		$status = $query;
	}
	else if ($query == "logmanage") { /* 일정관리 관련 */
		include ("./util/wizcalendar/DEFAULT_MALL/index.php");
		$status = $query;
	}
	else if ($query == "logmanage_list") { /* 일정관리 관련 */
		include ("./util/wizcalendar/DEFAULT_MALL/list.php");
		$status = $query;
	}
	else if ($query == "logmanage_write") { /* 일정관리 관련 */
		include ("./util/wizcalendar/DEFAULT_MALL/write.php");
		$status = $query;
	}
	else if ($query == "clickpd") { /* 오늘 본 상품 */
		include ($setpath."/clickPd.php");
		$status = $query;
	}
	else if ($query == "mycoupon") { /* 쿠폰페이지 */
		include ($setpath."/mycoupon.php");
		$status = $query;
	}
	else if ($query == 'out') {//회원탈퇴
		include ($setpath."/USER_OUT.php");
		$status = $query;
	}
	else if ($query == 'regismore') {  //회원가입단계중 추가회원정보입력시 이 옵션 사용(커뮤니티 사이트용)
		include ($setpath."/USER_REGIS_MORE.php");
		$status = $query;
	}
	else if ($query == 'login' || $query == 'regis_step1' ) {  //회원가입단계중 추가회원정보입력시 이 옵션 사용(커뮤니티 사이트용)
		include ($setpath."/USER_INFO.php");
		$status = "info";
	}	
	else if ($query == 'chpass') {  //패스워드만 단독 변경
		include ($setpath."/USER_PASSCHANGE.php");
		$status = "chpass";
	}		
}
/* 로그인 없이 갈 수 있는 페이지 */
	//exit;	
if (!strcmp($query,"passsearch") && !$status) {
	include ($setpath."/PASS_SEARCH.php");
}
else if (!strcmp($query,"idsearch") && !$status) {
	include ($setpath."/ID_SEARCH.php");
}
else if (!strcmp($query,"idpasssearch") && !$status) {
	include ($setpath."/IDPASS_SEARCH.php");
}				
else if (!strcmp($query,"accept") && !$status) { /* 일반회원가입 */
	include ($setpath."/USER_REGIS_AGGREE.php");
}
else if (!strcmp($query,"select") && !$status) { /* 일반회원가입 */
	include ($setpath."/USER_REGIS_SELECT.php");
}		
else if (!strcmp($query,"regis_step1") && !$status) { /*  점진적으로 regis를 regis_step1, 2, 3...으로변경*/
	include ($setpath."/USER_REGIS_STEP1.php");
}		
else if (!strcmp($query,"regis_step2") && !$status) { /*  */
	include ($setpath."/USER_REGIS_STEP2.php");
}		
else if (!strcmp($query,"regis_step3") && !$status) { /*  */
	include ($setpath."/USER_REGIS_STEP3.php");
}
else if (!strcmp($query,"regis_done") && !$status) { /*  */
	include ($setpath."/MEMBER_REGIST_DONE.php");
}
else if (!strcmp($query,"regis_paymember") && !$status) { /*  */
	include ($setpath."/USER_REGIS_PAY.php");
}			
else if (!strcmp($query,"myblog") && !$status) { /*블로그회원가입 */
	include ($setpath."/BlogUserLogin.php");
}
else if(!strcmp($query,"non_member_order") && !$status) {
	include ($setpath."/USER_ORDER_SPEC.php");
}
else if(!strcmp($query,"order_spec") && !$status) {
	include ($setpath."/USER_ORDER_SPEC.php");
}
else if(!strcmp($query,"login") && !$status) {
	include ($setpath."/USER_LOGIN.php");
}					
else if(!$status){
	
	$file="wizmember";
	$goto=$query;		
	include ($setpath."/USER_LOGIN.php");
}

?>
	</body>
</html>
  