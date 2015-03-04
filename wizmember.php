<?php
/* 
제작자 : 폰돌
제작자 URL : http://www.shop-wiz.com
제작자 Email : master@shop-wiz.com
Free Distributer 

*** Updating List ***
*/
include "./lib/inc.depth0.php";
if($common->securityguard($cfg["skin"]["LayoutSkin"])) $common->js_alert("잘못된 경로 사용");
if($common->securityguard($cfg["skin"]["MemberSkin"])) $common->js_alert("잘못된 경로 사용");
if($common->securityguard($cfg["skin"]["WishSkin"])) $common->js_alert("잘못된 경로 사용");

/****************** // 장바구니 비우기(주문완료후 query=order&option=trash 일경우 ***********************/
if (!strcmp($option,"trash")){ 
        if (file_exists("./config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE"])){
        unlink("./config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE"]);
        setcookie("CART_CODE","",0,"/");
        }
}

include ("./lib/class.wizmall.php");
$mall = new mall;
$mall->db_connect($dbcon);

include ("./lib/class.cart.php");
$cart = new cart;
$cart->get_object($dbcon,$common);

if ($query == 'non_member_order') {
	$dbcon->_query("SELECT * FROM wizBuyers WHERE OrderID='".$OrderID."'");
	$LLIST = $dbcon->_fetch_array();
	if (!$LLIST) {
		echo "<script language=javascript>
		window.alert(' 주문번호에 문제가 있습니다. \\n 다시 한 번 확인해주시기 바랍니다.');
		history.go(-1);
		</script>";
		exit;
	}
}


//옵션값 분리(각종 추가 옵션을 하나의 변수에 담아서 처리) op=key1:val1,key2|val2...
//iframe:true
$mall->op	= $op;
if($op){
	$opArr = explode(",",$op);
	if(is_array($opArr)){
		foreach($opArr as $key=>$val){
			$tmp		= explode(":",$val);
			$cfg["op"][$tmp[0]]	= $tmp[1];
		}
	}
}



/****************** 본격적으로 본론 진입 ***********************/
$mem_skin_path = "./wizmember/".$cfg["skin"]["MemberSkin"];//

if(!strcmp($cfg["mem"]["INCLUDE_MALL_SKIN"],"yes")):/* WizMember 스킨 인클루드 책크시 */

if(file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_start.php") && $cfg["op"]["iframe"] != "true") include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_start.php");
if(file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/iframelayout_start.php") && $cfg["op"]["iframe"] == "true") include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/iframelayout_start.php");

if(!$TABLE_WIDTH) $TABLE_WIDTH = "100%";
if(!$TABLE_ALIGN) $TABLE_ALIGN = "DEFAULT";
?>
<script language="javascript" src="./js/wizmall.js"></script>
<!-- top menu start -->
<?php
if (file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_top.php") && $cfg["op"]["iframe"] != "true") include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_top.php");
?>
<!-- top menu end -->
<div class="container bs-docs-container">
	<div class="row">
		<div class="col-left">
<!-- left menu start -->
<?php
if ($cfg["skin"]["MenuSkin_Inc"] == 'checked' && $cfg["op"]["iframe"] != "true") include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_left.php");
?>
<!-- left menu end -->
		</div><!-- col-lg-3 -->
		<div class="col-main">
<?php
/* wizMember에 스킨 인클루드 책크시 */
endif;
?>
<!-- main menu start -->

<?php			  
if(file_exists("./config/MemberSkinTop.php")) include "./config/MemberSkinTop.php";

/* 로그인 후 움직이는 페이지 */
unset($status); /* 로그인과 이후 혹은 query 값에 대한 다양한 결과가 요구되므로 $status의 상황에 따라 각각 행동 반경을 정한다. */
if ($cfg["member"] && $cfg["member"]["mgrade"] != "1") {
	if ($query == 'point') {
		include ($mem_skin_path."/USER_POINT.php");
		$status = $query;
	}
	else if ($query == 'order') {
		include ($mem_skin_path."/USER_ORDER.php");
		$status = $query;
	}
	else if ($query == 'infopass') {//회원정보수정시 먼저 패스워드 한번더 확인
		include ($mem_skin_path."/USER_INFO_PASS.php");
		$status = $query;
	}
	else if ($query == 'info') {
		include ($mem_skin_path."/USER_INFO.php");
		$status = $query;
	}
	else if ($query == 'logout') {
        $common->js_location("./wizmember/LOG_OUT.php");
        exit;
	}
	else if ($query == 'wish') {
		include ("./skinwiz/wizwish/".$cfg["skin"]["WishSkin"]."/USER_WISH.php");
		$status = $query;
	}
	else if ($query == "mypage") { /*MyPage Total list */
		include ($mem_skin_path."/MYPAGE.php");
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
		include ($mem_skin_path."/clickPd.php");
		$status = $query;
	}
	else if ($query == "mycoupon") { /* 쿠폰페이지 */
		include ($mem_skin_path."/mycoupon.php");
		$status = $query;
	}
	else if ($query == 'out') {//회원탈퇴
		include ($mem_skin_path."/USER_OUT.php");
		$status = $query;
	}
	else if ($query == 'regismore') {  //회원가입단계중 추가회원정보입력시 이 옵션 사용(커뮤니티 사이트용)
		include ($mem_skin_path."/USER_REGIS_MORE.php");
		$status = $query;
	}
	else if ($query == 'login' || $query == 'regis_step1' ) {  //회원가입단계중 추가회원정보입력시 이 옵션 사용(커뮤니티 사이트용)
		include ($mem_skin_path."/USER_INFO.php");
		$status = "info";
	}	
	else if ($query == 'chpass') {  //패스워드만 단독 변경
		include ($mem_skin_path."/USER_PASSCHANGE.php");
		$status = "chpass";
	}		
}
/* 로그인 없이 갈 수 있는 페이지 */
	//exit;	
if (!strcmp($query,"passsearch") && !$status) {
	include ($mem_skin_path."/PASS_SEARCH.php");
}
else if (!strcmp($query,"idsearch") && !$status) {
	include ($mem_skin_path."/ID_SEARCH.php");
}
else if (!strcmp($query,"idpasssearch") && !$status) {
	include ($mem_skin_path."/IDPASS_SEARCH.php");
}				
else if (!strcmp($query,"accept") && !$status) { /* 일반회원가입 */
	include ($mem_skin_path."/USER_REGIS_AGGREE.php");
}
else if (!strcmp($query,"select") && !$status) { /* 일반회원가입 */
	include ($mem_skin_path."/USER_REGIS_SELECT.php");
}		
else if (!strcmp($query,"regis_step1") && !$status) { /*  점진적으로 regis를 regis_step1, 2, 3...으로변경*/
	$_SESSION['realName']="memregis"; //실명인증을 위한 처리
	include ($mem_skin_path."/USER_REGIS_STEP1.php");
}		
else if (!strcmp($query,"regis_step2") && !$status) { /*  */
	include ($mem_skin_path."/USER_REGIS_STEP2.php");
}		
else if (!strcmp($query,"regis_step3") && !$status) { /*  */
	include ($mem_skin_path."/USER_REGIS_STEP3.php");
}
else if (!strcmp($query,"regis_done") && !$status) { /*  */
	include ($mem_skin_path."/MEMBER_REGIST_DONE.php");
}
else if (!strcmp($query,"regis_paymember") && !$status) { /*  */
	include ($mem_skin_path."/USER_REGIS_PAY.php");
}			
else if (!strcmp($query,"myblog") && !$status) { /*블로그회원가입 */
	include ($mem_skin_path."/BlogUserLogin.php");
}
else if(!strcmp($query,"non_member_order") && !$status) {
	include ($mem_skin_path."/USER_ORDER_SPEC.php");
}
else if(!strcmp($query,"order_spec") && !$status) {
	include ($mem_skin_path."/USER_ORDER_SPEC.php");
}
else if(!strcmp($query,"login") && !$status) {
	include ($mem_skin_path."/USER_LOGIN.php");
}					
else if(!$status){
	
	$file="wizmember";
	$goto=$query;		
	include ($mem_skin_path."/USER_LOGIN.php");
}

if(file_exists("./config/MemberSkinBottom.php")) include "./config/MemberSkinBottom.php";
?>
		</div><!-- col-lg-9 -->
	</div><!-- row -->
</div><!-- container bs-docs-container-->
<!-- main menu end -->
<?php
if(!strcmp($cfg["mem"]["INCLUDE_MALL_SKIN"],"yes")):/* wizMember에 스킨 인클루드 책크시 */				  
if (file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_bottom.php") && $cfg["op"]["iframe"] != "true") include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_bottom.php");
include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_close.php");
/* WizMember 에 스킨 인클루드 책크시 */
endif;
$dbcon->_close();