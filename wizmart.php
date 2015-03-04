<?php
/* 
제작자 : 폰돌
제작자 URL : http://www.shop-wiz.com
제작자 Email : master@shop-wiz.com
Free Distributer 

*** Updating List ***
*/
include "./lib/inc.depth0.php";
include ("./lib/class.wizmall.php");
include ("./lib/inc.wizmart.php");
$mall = new mall;
$mall->get_object($dbcon,$common);
$mall->cfg = $cfg;


//경로 관련 보안처리 실행
if($common->securityguard($cfg["skin"]["LayoutSkin"])) $common->js_alert("잘못된 경로 사용");
if($common->securityguard($cfg["skin"]["CoorBuySkin"])) $common->js_alert("잘못된 경로 사용");
if($common->securityguard($cfg["skin"]["ShopSkin"])) $common->js_alert("잘못된 경로 사용");
if($common->securityguard($cfg["skin"]["ViewerSkin"])) $common->js_alert("잘못된 경로 사용");


//옵션값 분리(각종 추가 옵션을 하나의 변수에 담아서 처리) op=key1:val1,key2|val2...
//iframe:true



if($op){
	$opArr = explode(",",$op);
	if(is_array($opArr)){
		foreach($opArr as $key=>$val){
			$tmp		= explode(":",$val);
			$cfg["op"][$tmp[0]]	= $tmp[1];
		}
	}
}

//블로그셰어에서 inframe으로 넘어온 경우 시작
if($InFrame=="Y" && $cfg["op"]["iframe"] != "true"){ 
	$cfg["op"]["iframe"] = "true";
	//$op	.= ",iframe:true"; //추후 op가 많을 경우 사용
	$op	= "iframe:true";//현재는 이것만사용
}

//블로그셰어에서 inframe으로 넘어온 경우 끝
$mall->op	= $op;





## 공동구매 관련 경로
$coor_path = "skinwiz/wizcoorbuy/".$cfg["skin"]["CoorBuySkin"];

if($query == "compare_save"){ //상품비교일 경우 현재 상품 비교 파일의 wizmember_tmp/goods_compare 파일생성 및 쿠키여부 책크
	$LOG_DIR = opendir("./config/wizmember_tmp/goods_compare");
	while($LOG_FILE = readdir($LOG_DIR)) {
		if($LOG_FILE !="." && $LOG_FILE !=".."){
			if(file_exists("./config/wizmember_tmp/goods_compare/".$LOG_FILE) && mktime() - filemtime("./config/wizmember_tmp/goods_compare/".$LOG_FILE) > 60*60*2) {
							unlink("./config/wizmember_tmp/goods_compare/".$LOG_FILE);
			}
		} //if($LOG_FILE !="." && $LOG_FILE !="..") 닫음
	}
	closedir($LOG_DIR);

	if(!$_COOKIE["MEMBER_COMPARE"] || !file_exists("./config/wizmember_tmp/goods_compare/".$_COOKIE["MEMBER_COMPARE"])){/* 처음 저장인 경우 */
		$MicroTsmp = explode(" ",microtime());
		$START_TIME = $MicroTsmp[0]+$MicroTsmp[1];
		$COMPARE_CODE = substr(str_replace(".", "", $START_TIME), 0, 13); // 상품 비교 쿠키
		setcookie("MEMBER_COMPARE",$COMPARE_CODE,0,"/");
		$fp = fopen("./config/wizmember_tmp/goods_compare/".$COMPARE_CODE, "w");
			if(is_array($mall_chk)){
				while (list($key,$value) = each($mall_chk)) :
						fwrite($fp, $key."|\n");
				endwhile;
			}else{
				fwrite($fp, $uid."|\n");
			}
		fclose($fp);			
	}else { /* 이미 다른 값이 저장되어 있는 경우 */
		//$COMPARE_CODE = $_COOKIE[MEMBER_COMPARE];//$COMPARE_CODE는 쿠키처리되므로 초기 include 시 쿠키가 먹지 않는 버그 수정
		$CompareArr = file("./config/wizmember_tmp/goods_compare/".$_COOKIE["MEMBER_COMPARE"]);
		for($i=0; $i < sizeof($CompareArr); $i++){ // 기존에 저장되어 있는 값을 배열에 저장
			$CompareUID = explode("|", $CompareArr[$i]);
			$VALUE = $CompareUID[0];
			$newCompare[$VALUE] = chop($CompareArr[$i]);
		}
		if(is_array($mall_chk)){
			while (list($key,$value) = each($mall_chk)) : // 현재 넘어 온 값을 배열에 저장
						$newCompare[$key] = $key."|";
			endwhile;
		}else{
		$newCompare[$uid] = $uid."|";
		}

		$fp = fopen("./config/wizmember_tmp/goods_compare/".$_COOKIE["MEMBER_COMPARE"], "w");
		while (list($key,$value) = each($newCompare)) : // 기존과 현재 넘어 온값을 파일로 저장
			//echo "key = $key <br>";
			fwrite($fp, $key."|\n");
		endwhile;		
		fclose($fp);
	}
		$query = "compare";

}else if($query == "compare_del"){
        if (file_exists("./config/wizmember_tmp/goods_compare/".$_COOKIE["MEMBER_COMPARE"])){
        $Cart_Data = file("./config/wizmember_tmp/goods_compare/".$_COOKIE["MEMBER_COMPARE"]);
        $fp = fopen("./config/wizmember_tmp/goods_compare/".$_COOKIE["MEMBER_COMPARE"], "w");
        while ($Cart_Data_f = each($Cart_Data)) {
			$C_dat = explode("|", chop($Cart_Data_f[1]));
				if($C_dat[0] != $uid) {
					fwrite($fp, chop($Cart_Data_f[1])."\n");
				}
			}
        fclose($fp);
        }
		$query = "compare";
}


## 카테고리별 적용된 스킨을 불러온다.
$mall->get_mart_skin($code);
$cfg["skin"]["ShopSkin"]		= $mall->cfg["skin"]["ShopSkin"];
$cfg["skin"]["ViewerSkin"]	= $mall->cfg["skin"]["ViewerSkin"];
#상단 네비게이션 display
$mall->getNavy($code);
## 인클루드 파일명
$whatincfile = $mall->whatincfile($code);

if($query == "view" || $query == "co_view"){//상품상세보기
	$mall->add_hit($no);## 조회수 증가
	$mall->SaveViewItem($no);##오늘본 상품에 쿠키값을 저장한다.
	$prenext = $mall->getprenext($no, $code);##이전다음제품 구하기
	/* 이전 디렉토리 구하기 */
	$pre_dir = $mall->getpredir($code,$optionvalue);

}else{//상품리스트인경우
	// 사용자 페이징 설정
	//echo "ShopListNo = ".$_POST["ShopListNo"]."<br>";
	if(empty($cp) || $cp <= 0) $cp = 1;
	
	if($_POST["ShopListNo"]){
		setcookie("ShopListNo", $_POST["ShopListNo"], 0, "/");
		$ShopListNo = $_POST["ShopListNo"];
	}else if($_COOKIE["ShopListNo"]){
		$ShopListNo = $_COOKIE["ShopListNo"];
	}else{
		$ShopListNo = $cfg["skin"]["ListNo"];
		setcookie("ShopListNo", $cfg["skin"]["ListNo"], 0, "/");
	}
	$PageNo = $cfg["skin"]["PageNo"];
	
	if(!$sel_orderby) $sel_orderby= "m1.UID@desc";
	$tmp = explode("@", $sel_orderby);
	$orderbystr = "order by ".$tmp[0]." ".$tmp[1];
	$whereis = "where 1 and (m1.opflag <> 'c' or m1.opflag is null)";//공동구매가 아닌 것
	
	if($query == "option" && trim($optionvalue)){## 옵션 제품만 디스플레이인경우
		$RegOptionRevArr = array_flip($RegOptionArr);
		$tmpkey = $RegOptionRevArr[$optionvalue];
		$pos = $tmpkey*2 + 1;
		$whereis .= " and SUBSTRING(m1.Regoption,".$pos.",1)= '1' and m1.UID = m2.UID";
	}

	if($cfg["skin"]["stockoutDisplay"] != "1"){//품절상품 표시안함
		$whereis .= " and m1.None <> '1'";
	}
	
	if($mode == "internalsearch"){//내부검색이 존재할 경우 
		if($Category) $whereis .= " and m1.Category like '%".$Category."'";
		if($skey && $stitle){
			$whereis .= " and ".$stitle." like '%".$skey."%'";
		}else if($skey){
			$whereis .= " and (m1.Name like '%".$skey."%' or m1.Brand like '%".$skey."%' or m1.Description1 like '%".$skey."%')";
		}
	}else{
		$whereis .= $mall->productWhere; 
	}
	/* 총 갯수 구하기 */
	
	$TOTAL_STR = "SELECT count(1) FROM wizMall m2 left join wizMall m1 on m1.UID = m2.PID ".$whereis;
	$TOTAL = $dbcon->get_one($TOTAL_STR);
	
	if ($ShopListNo == "all"){
		$ShopListNo =  $TOTAL;
	}
	
	$START_NO = ($cp - 1) * $ShopListNo;
	$BOARD_NO=$TOTAL-($ShopListNo*($cp-1));
}

$big_code = substr($code,-3);
$mid_code = substr($code, -6, 3);
$small_code = substr($code, -9, 3);



/* 상품평 쓰기일경우(오픈창이아니라 바로작성) */
if(!strcmp($repleqry,"insert")){
	$mall->pd_write_estim($_POST);
}else if(!strcmp($repleqry, "delete")){
/* 작성자와 현재 로그인 사용자가 같은 지 확인 */
$sqlstr = "select ID from wizEvalu where UID = ".$repleuid;
$RepleID= $dbcon->get_one($sqlstr);
	if($RepleID != $cfg["member"]){
		echo "<script>window.alert('본인이 작성한 글만을 지울 수가 있습니다.');location.replace('$PHP_SELF?query=".$query."&code=".$code."&no=".$GID."');</script>";
		exit;
	}else{
		$sqlstr = "delete from wizEvalu where UID = ".$repleuid;
		$dbcon->_query($sqlstr);
		echo "<script>location.replace('$PHP_SELF?query=".$query."&code=".$code."&no=".$GID."');</script>";
		exit;
	}
}

if(file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_start.php") && $cfg["op"]["iframe"] != "true") include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_start.php");

if(file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/iframelayout_start.php") && $cfg["op"]["iframe"] == "true") include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/iframelayout_start.php");

echo "<!-- top menu start -->";
if (file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_top.php") && $cfg["op"]["iframe"] != "true") include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_top.php");
echo "<!-- top menu end -->";
?>

<!-- left menu start -->
<div class="container bs-docs-container">
	<div class="row">
		<div class="col-left">
<?php
if ($cfg["skin"]["MenuSkin_Inc"] == 'checked' && $cfg["op"]["iframe"] != "true") include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_left.php");
?>
<!-- left menu end -->
		</div><!-- col-lg-3 -->
		<div class="col-main">
<!-- main menu start -->

<?php

$mart_skin = $mall->get_mart_design($code);## 사용자 정의 상단 하단 코딩이 책크.
echo $mart_skin["top"];
				  
switch ( $query ){
	case ( "view" ) ://상품상세보기
		include ("./skinwiz/viewer/".$cfg["skin"]["ViewerSkin"]."/view.php");
	break;
	case ( "compare" ) ://비교상품보기
		include ("./skinwiz/shop/".$cfg["skin"]["ShopSkin"]."/compare.php");
	break;
	case ( "option" ) ://옵션상품보기
		include ("./skinwiz/shop/".$cfg["skin"]["ShopSkin"]."/optionlist.php");
	break;		
	default :
	case ( "martmain" ) ://숍메인보기
		include ("./skinwiz/shop/".$cfg["skin"]["ShopSkin"]."/martmain.php");
	break;	
// 공동구매 관련 시작
	case ("co_view") :
		include ($coor_path."/view.php");
	break;
	case ("co_req") :
		$where_log = "wizcoorbuy";
		$query = "login";
		include ("./wizmember/".$cfg["skin"]["MemberSkin"]."/USER_LOGIN.php");
	break;
	case ("co_req_form") :
		include ($coor_path."/req_form.php");
	break;
	case ("co_list") :
		include ($coor_path."/index.php");
	break;
// 공동구매 관련 끝
	
	default :	
	//exit;
	//echo "whatincfile=".$whatincfile;
	include ("./skinwiz/shop/".$cfg["skin"]["ShopSkin"]."/".$whatincfile);
	break;
}
echo $mart_skin["bottom"];
?>
		</div><!-- col-lg-9 -->
	</div><!-- row -->
</div><!-- container bs-docs-container-->
<!-- main menu end -->

<?php
echo "<!-- bottom menu start -->";
if (file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_bottom.php") && $cfg["op"]["iframe"] != "true") include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_bottom.php");
echo "<!-- bottom menu end -->";

include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_close.php");
$dbcon->_close();