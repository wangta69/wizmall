<?php
/* 
제작자 : 폰돌
제작자 URL : http://www.shop-wiz.com
제작자 Email : master@shop-wiz.com
Free Distributer 

*** Updating List ***
*/

include "./lib/inc.depth0.php";

include ("./lib/class.cart.php");
$cart = new cart;
$cart->get_object($dbcon,$common);

include ("./lib/class.wizmall.php");
$mall = new mall;
$mall->get_object($dbcon,$common);
$mall->cfg = $cfg;

include "./config/common_array.php";

$CART_CODE = $cart->mkcartcode();##장바구니 코드가 없을 경우 - 장바구니 코드 생성


//config 에서 0값 세팅
$cfg["pay"]["DIFF_CARD_VALUE"] = $cfg["pay"]["DIFF_CARD_VALUE"] == "" ? 0:$cfg["pay"]["DIFF_CARD_VALUE"];



//경로 관련 보안처리 실행
if($common->securityguard($cfg["skin"]["LayoutSkin"])) $common->js_alert("잘못된 경로 사용");
if($common->securityguard($cfg["skin"]["CartSkin"])) $common->js_alert("잘못된 경로 사용");


$cart->op	= $op;
if($op){
	$opArr = explode(",",$op);
	if(is_array($opArr)){
		foreach($opArr as $key=>$val){
			$tmp		= explode(":",$val);
			$cfg["op"][$tmp[0]]	= $tmp[1];
		}
	}
}


//재결재 페이지에서 넘어오는 경우 결제시 CART_CODE로 대처
$CART_CODE = $RepayOrderID ? $RepayOrderID : $CART_CODE;
//echo "CART_CODE = ".$CART_CODE."<br>";
if (!strcmp($query,"cmp")) {## 다중 장바구니
	while (list($key,$value) = each($mall_chk)) :
		## 상품중 옵션필드가 있는 경우 리턴시킨다.(추가 프로그램 예정) 
		$cart->wizCartExe($CART_CODE,$key,$BUYNUM,$optionfield);
	endwhile;
	$common->js_location("wizbag.php?op=".$op);
}else if (!strcmp($query,"cart_save")) {  ## 단일 장바구니
	$cart->wizCartExe($CART_CODE, $_POST);
	if($sub_query) $common->js_location("wizbag.php?query=step1&op=".$op);
	else $common->js_location("wizbag.php?op=".$op); 
}else if (!strcmp($query,"qtyup")){ ## 장바구니 택일수정//update_qty
	$cart->changeCartqty($cuid, $BUYNUM);
	$common->js_location("wizbag.php?op=".$op); 
}else if (!strcmp($query,"qde")){ // 장바구니 택일삭제
	$sqlstr = "delete from wizCart where uid = ".$cuid;
	$dbcon->_query($sqlstr);
	$common->js_location("wizbag.php?op=".$op); 
}else if (!strcmp($query,"step5")){ // 장바구니 쿠키삭제
	setcookie("CART_CODE","",0,"/");
}else if (!strcmp($query,"trash")){ // 장바구니 비우기
	$sqlstr = "delete from wizCart where oid = '".$CART_CODE."'";
	$dbcon->_query($sqlstr);
	setcookie("CART_CODE","",0,"/");
	if($goto) $common->js_location($goto); 
	else $common->js_location("wizbag.php?op=".$op); 
}

/*********************************************************************************
결제하기 선택(step1)이고 회원로그인 상태이며 style=B 이면 바로 배송지적리 페이지로 넘긴다.
* style=B는 enushop에서 처음 적용되었으며 결제선택란이 배송지 적는란과 동일한 페이지에 있다.
단점으로는 포인트결제가 되지 않는다.
*********************************************************************************/
	
if (!strcmp($query,"step1") && !strcmp($style,"B") ){
	if ($cfg["member"] || !strcmp($cfg["skin"]["NoneMemOnly"],"checked")) 
	$common->js_location("wizbag.php?query=step2&check=".$check."&op=".$op); 
}else if (!strcmp($query,"step1") && !strcmp($style,"inputone") ){#장바구니중 택1 하나만이 결제단으로 넘어간다.
	$filepath = "./config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE"];
	if (file_exists($filepath)){
	$Cart_Data = file($filepath);
	$fp = fopen($filepath, "w");
	while ($Cart_Data_f = each($Cart_Data)) {
	$C_dat = explode("|", chop($Cart_Data_f[1]));
			if($C_dat[0]."-".$C_dat[3]."-".$C_dat[4] == $value) {
					fwrite($fp, chop($Cart_Data_f[1])."\n");
			}
	}
	fclose($fp);
	}
	
		
	if ($common->getLogininfo() || !strcmp($cfg["skin"]["NoneMemOnly"],"checked")) $common->js_location("wizbag.php?query=step2&check=".$check);
}
/*********************************************************************************
결제하기 선택(step1)이고 회원로그인 상태이면 바로 결제방법선택(step2)로 넘어가고,
회원로그인 상태가 아니면 회원로그인 창으로 넘어간다.
*********************************************************************************/
if (!strcmp($query,"step1")){
	if ($common->getLogininfo() || !strcmp($cfg["skin"]["NoneMemOnly"],"checked")) {
		$common->js_location("wizbag.php?query=step2&check=".$check."&op=".$op);
	}
}else if ($query == 'step2' && $cfg["pay"]["CARD_ENABLE"] != 'checked' && $POINT_ENABLE != 'checked' && $COMPO_ENABLE != 'checked') {
/*********************************************************************************
결제방법선택(step2)에서 카드나 포인트결제가 없으면 바로 온라인결제가 되어 배송지 적기 페이지로 넘긴다,
*********************************************************************************/
 	$common->js_location("wizbag.php?query=step3&op=".$op);
}

$cart_skin_path = "./skinwiz/cart/".$cfg["skin"]["CartSkin"];//

//if(file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_start.php")) include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_start.php");
if(file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_start.php") && $cfg["op"]["iframe"] != "true") include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_start.php");
if(file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/iframelayout_start.php") && $cfg["op"]["iframe"] == "true") include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/iframelayout_start.php");
?>
<!-- top menu start -->
<?php
if (file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_top.php") && $cfg["op"]["iframe"] != "true") include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_top.php");
echo "<!-- top menu end -->";
?>
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
<!-- main menu start -->
<?php
switch ( $query ){
	case ( "cart_save" ) :
		include ($cart_skin_path."/CART_SAVE.php");
	break;
	case ( "step1" ) :
		include ($cart_skin_path."/CART_LOGIN.php");
	break;
	case ( "step2" ) :
	//include ("./skinwiz/cart/".$cfg["skin"]["CartSkin"]."/CART_SELECT.php");
	//break;
	case ( "step3" ) :
		include ($cart_skin_path."/CART_WRITE.php");
	break;
	case ( "step4" ) :
		include ($cart_skin_path."/CART_FINISH.php");
	break;
	case ( "step5" ) :
		$sqlstr		= "select * from wizBuyers where OrderID = '".$OrderID."'";
		$list		= $dbcon->get_row($sqlstr);
		$BuyDate	= date ("Y.m.d", $list["BuyDate"]);
		$cart->stock("oid",$OrderID,"10");## 상품재고처리
		include ($cart_skin_path."/ORDER_MAIL.php");## 주문 메일 발송
		include ($cart_skin_path."/CART_QUERY_FINAL.php");
	break;
	case ( "cardchecking" ) :
		include ($cart_skin_path."/CARD_CHECKING.php");
	break;
	default :
		include ($cart_skin_path."/CART_SAVE.php");
	break;
}

?>
		</div><!-- col-lg-9 -->
	</div><!-- row -->
</div><!-- container bs-docs-container-->
<!-- main menu end -->
<!-- bottom menu start -->
<?php
if (file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_bottom.php") && $cfg["op"]["iframe"] != "true") include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_bottom.php");
?>
<!-- bottom menu end -->
<?php
include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_close.php");
$dbcon->_close();