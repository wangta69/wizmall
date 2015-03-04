<?php
/*
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*/

include "../lib/cfg.common.php";
include "../config/cfg.core.php";
include "../config/WizApplicationStartDate_info.php";

include "../config/common_array.php";
include "../config/db_info.php";
include "../lib/class.database.php";
$dbcon		= new database($cfg["sql"]);


include "../lib/class.common.php";
$common = new common();
$common->db_connect($dbcon);
$common->pub_path = "../";
$cfg["member"] = $common->getLogininfo();//로그인 정보를 가져옮

//print_r($cfg);

include "../lib/class.wizmall.php";
$mall = new mall();
$mall->get_object($dbcon,$common);

include "../lib/class.admin.php";
$admin = new admin();
$admin->get_object($dbcon, $common, $mall);

include ("./ROOT_CHECK.php");

## 전페이지 일반 변수 설정
if(!$ListNo) $ListNo = "15";
$PageNo = "10";
if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $ListNo;

?>
<!DOCTYPE html>
<html lang="kr">
<head>
<title>WizMall_Admin Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg["common"]["lan"]?>">
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.plugins/jqalerts/jquery.alerts.js"></script>
<script type="text/javascript" src="../js/wizmall.js"></script>
<script type="text/javascript" src="../js/admin.js"></script>
<script type="text/javascript" src="../js/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
/*
$(function(){
	$(".altern th:odd").addClass("bg3"); //basic이라는 클래스네임을 가진 요소의 tr 요소 중 홀수번째에 bg1클래스 부여
	$(".altern th:even").addClass("bg4");
	$(".list tr:odd").addClass("bg1");
	$(".list tr:even").addClass("bg2");

});
*/
</script>
<link rel="stylesheet" type="text/css" media="screen" href="../css/jquery-ui/jquery-ui.custom.css" />
<link rel="stylesheet" href="../js/jquery.plugins/jqalerts/jquery.alerts.css" type="text/css" />
<link href="/js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="/js/bootstrap/css/bootstrap-glyphicons.css" rel="stylesheet">
<link rel="stylesheet" href="../css/base.css" type="text/css">
<link rel="stylesheet" href="../css/admin.css" type="text/css" />




<style type="text/css">
<?php // 좌측 메뉴 보이고 숨기기 
for($i = 0;$i <= 13;$i ++) echo "#sub #menu".$i."{display : none }\n";
echo "#sub #".$menushow."{display : block; width:188px; }\n";
?>
</style>
</head>
<body>
<!--// 각종 팝업용 Start //-->
<div id="dynamicPop"></div>
<!--// 각종 팝업용 End //-->
<div id="head">
	<!--
	<div id="logo">
		<div id="logo_title"><a href="./main.php?menushow=menu0&theme=front">관리자페이지</a></div>
		<div id="logo_word"><script language='javascript'>document.write(quote);</script></div>
	</div>
-->
	<!--onMouseOver="this.style.background='#70AF41'" onMouseOut="this.style.background='#5A9D28'"-->
	<div id="top">
		<a href="./main.php?menushow=menu1&theme=basicconfig/basic_info2" class="topnavigation">기본환경</a>
		<a href="./main.php?menushow=menu2&theme=product/product1" class="topnavigation">상품관리</a>
		<a href="./main.php?menushow=menu3&theme=catmanager/shopmanager1" class="topnavigation">매장관리</a>
		<a href="./main.php?menushow=menu4&theme=order/order1" class="topnavigation">주문배송관리</a>
		<a href="./main.php?menushow=menu6&theme=member/member1" class="topnavigation">회원관리</a>
		<a href="./main.php?menushow=menu11&theme=mail/mailer1" class="topnavigation">메일링</a>
		<a href="./main.php?menushow=menu7&theme=board/boardadmin" class="topnavigation">게시판관리</a>
		<a href="main.php?menushow=menu8&theme=visitor/visitor1" class="topnavigation">방문자통계</a>
		<a href="main.php?menushow=menu5&theme=agent/agent/naver" class="topnavigation">제휴업체관리</a>
		<a href="./main.php?menushow=menu9&theme=mallstatistic/statistic2" class="topnavigation">매출통계</a>
		<a href="./main.php?menushow=menu13&theme=util/util1" class="topnavigation">기타관리</a>
		<a href="javascript:wizwindow('./about/about.php','about_wizmall', 'width=300, height=300')" class="topnavigation">ABOUT</a>
			<!--<a id="aboutpopup" class="topnavigation" href="#"><b>ABOUT</b></a></div>//-->
	</div>
</div>

<div class="clear"></div>

<!-- body Start -->
<div id="body_wrapper">
	<!-- lefet menu -->
	<div id="sub">
		<?php include ("./admin_left_menu.php"); ?>
	</div>
	<!-- main contents -->
	<div id="mainbody"> 
		<div  id="mainbody_top"><img src="img/admintop_img01.gif" width="762" height="75"></div>
		<?php if(file_exists("./${theme}.php"))require("./${theme}.php"); ?>
	</div>
</div>

<!-- bottom -->
<div class="space30"></div>
<div id="foot">Copyright ⓒ 2014
	<?php echo $cfg["admin"]["ADMIN_TITLE"]?>
	. All rights reserved. Powered by <a href="http://www.shop-wiz.com" target="_blank">shop-wiz.com </a> </div>
</body>
</html>
