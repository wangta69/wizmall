<?php
/* 
제작자 : 폰돌
제작자 URL : http://www.shop-wiz.com
제작자 Email : master@shop-wiz.com
Free Distributer 

*** Updating List ***
*/

include "./lib/inc.depth0.php";
include "./lib/class.board.php";
//include "./lib/class.filter.php";

$board = new board();
$board->get_object($dbcon, $common);

if(is_file("./config/wizboard/table/config.php")) include "./config/wizboard/table/config.php";//전체환경변수 입력

##클라스에 각종 변수값 입력
$geturl = $common->getdecode($_GET["getdata"]);//get 방식으로 호출된 data값 변환

$BID                    = $geturl["BID"]?$geturl["BID"]:$BID;
$GID                    = $geturl["GID"]?$geturl["GID"]:$GID;
$cp                     = $geturl["cp"] ? $geturl["cp"]:$cp;//현재페이지
$UID                    = $geturl["UID"]?$geturl["UID"]:$UID;
$category               = $geturl["category"]?$geturl["category"]:$category;
$mode                   = $geturl["mode"]?$geturl["mode"]:$mode;
if(!$mode) $mode        = "list";
$adminmode              = $geturl["adminmode"]?$geturl["adminmode"]:$adminmode;
$optionmode             = $geturl["optionmode"]?$geturl["optionmode"]:$optionmode;
$search_term            = $geturl["search_term"]?$geturl["search_term"]:$search_term;
$SEARCHTITLE            = $geturl["SEARCHTITLE"]?$geturl["SEARCHTITLE"]:$SEARCHTITLE;
$searchkeyword          = $geturl["searchkeyword"]?urldecode($geturl["searchkeyword"]):$searchkeyword;
//$RECOMMAND            = $geturl["RECOMMAND"]?$geturl["RECOMMAND"]:$RECOMMAND;
$oderflag               = $geturl["oderflag"]?$geturl["oderflag"]:$oderflag;


if($common->securityguard($BID)) $common->js_alert("잘못된 경로 사용");
if($common->securityguard($GID)) $common->js_alert("잘못된 경로 사용");

$board->bid             = $BID;
$board->gid             = $GID;
$board->page_var["cp"]  = $cp ? $cp:1;//현재페이지
$board->uid             = $UID;
$board->category        = $category;
$board->mode            = $mode;
$board->adminmode       = $adminmode;
$board->optionmode      = $optionmode;
$board->search_term     = $search_term;
$board->SEARCHTITLE     = $SEARCHTITLE;
$board->searchkeyword   = $searchkeyword;
$board->oderflag        = $oderflag;

//$optionmodeArr = explode("|", $optionmode);//추후 별도 옵션값이 필요할 경우 op=serialize() 를 이용하여 처리한다.(아래 것으로 처리)
$op     = unserialize(urldecode($optionmode));
//oc = true : 카테고리별 리스트 출력시 전체는 제외(only category);
//frame = true : 상하 인코딩을 제외한 현재것만 출력

if(!$BID) $common->js_alert("\\n\\n보드아이디가 존재하지 않습니다.\\n\\n", "cur");
if(!$GID) $common->js_alert("\\n\\n그룹아이디가 존재하지 않습니다.\\n\\n", "cur");
if(!is_dir("./config/wizboard/table/".$GID."/".$BID)) $common->js_alert("\\n\\n폴더가 존재하지 않습니다.\\n\\n", "cur");

$config_include_path = "./config/wizboard/table/".$GID."/".$BID;
include $config_include_path."/config.php";#보드관련 세부 config 관련 정보
if(!$board->listcnt) $board->listcnt            = $cfg["wizboard"]["ListNo"];
if(!$board->pagecnt) $board->pagecnt        = $cfg["wizboard"]["PageNo"];
$board->cfg = $cfg;//환경설정 파일들을 입력한다.
# 회원모드이면 로그인 상태와 회원등급을 책크하여 읽기/쓰시/수정 권한 책크.
$board->checkperm($cfg["member"]);

#그룹정보가져오기
//$sqlstr = "select Grp from wizTable_Main where BID = '$BID' and GID = '$GID'";
//$sqlqry=$dbcon->get_one($sqlstr);
#테이블 정보 가져오기
$sqlstr = "select BoardDes from wizTable_Main where BID = '".$BID."' and GID = '".$GID."'";
$row    = $dbcon->get_row($sqlstr);
$cfg["board"]["BoardDes"] = $row["BoardDes"];
//echo $cfg["board"]["BoardDes"];

include ("./config/cfg.core.php");;



/****[스킨은 다르지만 동일한 데이트를 사용할때, 즉 SameDB가 있을 때] *******/

if(!$SameDB){
     $tb_name="wizTable_".$GID."_".$BID;
     $UpdirPath = $GID."/".$BID;
}else{
    $tb_name="wizTable_".$SameDB;
    $UpdirPath = $SameDB;
}
$board->boardname = $tb_name;

## RECOMMAND(추천)글이면 추천 RECCOUNT를 1씩 올린다. 비추천이면 NONRECCOUNT를 1씩 올린다.
## 이후 lib/ajax.replevote.php 에서 처리
//if($RECOMMAND) $board->addreccount($RECOMMAND, $UID);
/****[확장DB사용시] *******/
if($ExtendDB && $ExtendDBUse=="checked")
$tb_name    = $ExtendDB;
/******************************************************************************/

/* 리플을 등록한다 */
switch($REPLE_MODE){
    case "WRITE":
        $board->insertreple($_POST);
    break;
    case "update":
        $board->updatereple($_POST);
    break;
}

## 쓰기 모드(write/modify/reply) 실행
/************************************************ mode가 write일때 **********************************************************/
if(!strcmp($mode,"write") && $bmode=="write"){
    $board->data_processing($_POST);
}

/************************************ bmode가 modify일때 ******************************************************************/
if(!strcmp($mode,"modify") && !strcmp($bmode,"modify")){ //수정실행
    $board->data_processing($_POST);
}if(!strcmp($mode,"modify")){//수정 정보 가져오기
    $board_view = $board->getmodifyview($UID);
    
}

/**************************************************** mode가 reply일때 *****************************************************/
if(!strcmp($mode,"reply") && !strcmp($bmode,"reply")){//쓰기 실행
    $board->data_processing($_POST);
}else if(!strcmp($mode,"reply")){//쓰기 정보 가져오기
    $board_view         = $board->getreplyview($UID);   
    $board_view["UID"]  = $UID;
}
## 쓰기 모드(write/modify/reply)끝


/****************** 본격적으로 본론 진입 ***********************/
if(!strcmp($cfg["wizboard"]["INCLUDE_MALL_SKIN"],"yes") && $tableskin !="skip" && $adminmode != "true" && $op["frame"] != "true"):/* Board에 스킨 인클루드 책크시나 관리자단에서 보는 것이 아니거나 옵션모드가 프래임(프래임을 이용하여 wizboard삽입)이 아닐경우 */
    //경로 관련 보안처리 실행
    if($common->securityguard($cfg["skin"]["LayoutSkin"])) $common->js_alert("잘못된 경로 사용");
    if($common->securityguard($cfg["wizboard"]["BOARD_SKIN_TYPE"])) $common->js_alert("잘못된 경로 사용");
    if($common->securityguard($cfg["wizboard"]["ICON_SKIN_TYPE"])) $common->js_alert("잘못된 경로 사용");
    if($common->securityguard($cfg["wizboard"]["REPLE_SKIN_TYPE"])) $common->js_alert("잘못된 경로 사용");


    
    if(is_file("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_start.php")) include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_start.php");
?>

    <!-- top menu start -->

<?php
    if (file_exists("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_top.php")) include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_top.php");
?>

<!-- top menu end -->
    
<!-- left menu start -->
<div class="container bs-docs-container">
    <div class="row">
        <div class="col-left">
<?php
    if ($cfg["skin"]["MenuSkin_Inc"] == 'checked') include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_left.php");
?>
        </div><!-- col-lg-3 -->
        <div class="col-main">
<!-- left menu end  -->
<?php
    /* Board에 스킨 인클루드 책크시 */
endif;


//echo "<div id=\"body\">";
if($adminmode == "true" || $op["frame"] == "true"){
    include "./wizboard/default/top.php";
    include "./wizboard/default/default.css.js.php";
}else if(file_exists($config_include_path."/top.php")){
    include $config_include_path."/top.php";
    include "./wizboard/default/default.css.js.php";
}
?>
  <!-- wizboard 관련하여 공통 자바스크립트 및 css 사용 -->
<script type="text/javascript" language="javascript" src="./js/jquery.plugins/colorbox/jquery.colorbox-min.js"></script>
<link type="text/css" media="screen" rel="stylesheet" href="./js/jquery.plugins/colorbox/colorbox.css" /> 
<link rel="stylesheet" href="./css/board.css" type="text/css" />
<script type="text/javascript" src="./js/jquery.plugins/jquery.validator.js"></script>
<script>
    //기본 전영 변수 설정
    var _uid        = "<?php echo $UID?>";
    var _gid        = "<?php echo $GID;?>";
    var _bid        = "<?php echo $BID?>";
    var _skin_type  = "<?php echo $cfg["wizboard"]["BOARD_SKIN_TYPE"];?>";
    var _timestamp  = "<?php echo time();?>";// _timestamp = Math.round(+new Date()/1000); 자바스크립트로 처리할 경우 서버와 로컬 피씨간의 시간차 문제가 발생하 ㄹ수 있다.
</script>
<script type="text/javascript" src="./js/wizboard.js"></script>
<!--
        <script type="text/javascript"> 
            $(document).ready(function(){
            $(".single").colorbox({photo:true});
            });
        </script> 
-->
<!-- color picker
<link rel="stylesheet" media="screen" type="text/css" href="./js/jquery.plugins/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="./js/jquery.plugins/colorpicker/js/colorpicker.js"></script>
 -->


<!--// 공용으로 사용할 form 입력시작  //-->
<form id="boardForm" action="wizboard.php" method="post">
    <input type="hidden" name="BID" id="BID" value="<?php echo $BID?>" />
    <input type="hidden" name="GID" id="GID" value="<?php echo $GID?>" />
    <input type="hidden" name="adminmode" id="adminmode" value="<?php echo $adminmode?>">
    <input type="hidden" name="optionmode" id="optionmode" value="<?php echo $optionmode?>">
    <input type="hidden" name="category" id="category" value="<?php echo $category?>" />
    <input type="hidden" name="mode" id="mode" value="<?php echo $mode?>">
    <input type="hidden" name="UID" id="UID" value="<?php echo $UID?>">
    <input type="hidden" name="cp" id="cp" value="<?php echo $cp?>">
    <input type="hidden" id="sethtmleditor" value="<?php echo $cfg["wizboard"]["editorenable"]?>">
</form>
<!--// 공용으로 사용할 form 입력끝  //-->

  <div id="wizboardmain" style="width:<?php echo $cfg["wizboard"]["TABLE_WIDTH"]?><?php echo $cfg["wizboard"]["TABLE_WIDTH_UNIT"]?>; text-align:<?php echo $cfg["wizboard"]["TABLE_ALIGN"]?>">
<?php
#html 편집기 사용
if($cfg["wizboard"]["editorenable"] == "1") echo "<script language=\"javascript\" src=\"js/Smart/js/HuskyEZCreator.js\" type=\"text/javascript\"></script>";

$folder_skin = "./wizboard/skin/".$cfg["wizboard"]["BOARD_SKIN_TYPE"];
$folder_icon = "./wizboard/icon/".$cfg["wizboard"]["ICON_SKIN_TYPE"];
$folder_btnm = "";
$folder_reple = "./wizboard/skin_reple/".$cfg["wizboard"]["REPLE_SKIN_TYPE"];

switch ( $mode ){
    case ( "view" ) :
        if($NoticeBID){ //공지 테이블이 있으면 현재 BID 를 NoticeBID로 교체한다. 
            $tb_name = "wizTable_".$NoticeBID;
            //보드 교체후 view page가 끝나는 곳에서 반드시 원래 보드로 복귀시켜준다.
        }
        ## 잘못된 경로에서의 접근이면 list.php로 돌린다
        if(!$UID) echo "<script>location.replace('$PHP_SELF')</script>";
        
        if(!$RECOMMAND)## recommand 시 중복을 피하기 위해
        {
            $board->MakeChannel();## channel에 카운트 넣기## 보드별 통계치(Channel)를 만든다.
            $board->addviewcount($UID);## COUNT를 1씩 올린다.
        }
        ## 이전글 다음글에서 이전글의 UID 와 다음글의 UID를 구한다 

        $board->getpreitem($UID, $cfg["wizboard"]["SubjectLength"]);// 이전글 클라스내에 생성 $listpre
        $board->getpnextitem($UID, $cfg["wizboard"]["SubjectLength"]);//다음글 클라스내에 생성 $listnext

        ##  상세보기 관련 모든 내용 가져오기
        $boardview = $board->getview($UID);

        ## 비밀글 읽을 권한 책크
        $board->is_secret_perm($boardview["Secret"], $boardview["FID"]);

        $board->getcategorylist(); ## 카테고리정보구하기
        include ($folder_skin."/view.php");
        ## 리스트 페이지 삽입 
        if($cfg["wizboard"]["ListEnable"] == "yes"):
            //$ThisFileName = basename(__FILE__); // get the file name
            //$path = str_replace($ThisFileName,"",__FILE__);   // get the directory path
            //include "${path}/list.php"; 
            $board->getorderby($oderflag); ##정열값 구하기
            $board->getwhere($skey, $sstr); ## 검색 키워드 및 WHERE 구하기
            $board->get_total_cnt(); ##총갯수 구하기 ($this->page_var["tc"]);
            $board->getpagevar(); ## 페이징 관련 변수 구하기
            $board->getcategorylist(); ## 카테고리정보구하기
            include $folder_skin."/list.php"; 
        endif;      
        if($NoticeBID){ //공지테이블에서 원래 테이블로 변경한다. 
            $tb_name = "wizTable_".$BID;
        }
    break;
    case ( "write" ) :
    case ( "reply" ) :
    case ( "modify" ) :
        $board->getcategorylist(); ## 카테고리정보구하기
        $list = $board_view;
        $list["CATEGORY"] =  $list["CATEGORY"] ? $list["CATEGORY"] : $category;//쓰기 모드일경우 현재 카테고리 정보가 있으면 카테고리를 가져온다.
        include ($folder_skin."/write.php");
    break;
    case ( "delete" ) :
        //include ("./wizboard/boarddelete.php");
    break;
    case ( "login" ) :
        include ("./wizboard/member_login.php");
    break;
    case ( "modlogin" ) :
    case ( "secret" ) :
        include ("./wizboard/member_login_secret.php");
    break;
    case ( "down" ) :
        include ("./wizboard/member_login.php");
    break;                          
    default ://리스트
        $board->getorderby($oderflag); ##정열값 구하기
        $board->getwhere($skey, $sstr); ## 검색 키워드 및 WHERE 구하기
        $board->get_total_cnt(); ##총갯수 구하기 ($this->page_var["tc"]);
        $board->getpagevar(); ## 페이징 관련 변수 구하기
        $board->getcategorylist(); ## 카테고리정보구하기
        include ($folder_skin."/list.php");
    break;
}
?>
  </div><!-- wizboardmain end -->
<!-- </div> -->
  <!-- main menu end -->
<?php
if($adminmode == "true" || $op["frame"] == "true"){
    include "./wizboard/default/bottom.php";
}else if(file_exists($config_include_path."/bottom.php")){
    include $config_include_path."/bottom.php";
}

if(!strcmp($cfg["wizboard"]["INCLUDE_MALL_SKIN"],"yes") && $tableskin!="skip" && $adminmode != "true"  && $op["frame"] != "true"):/* Board에 스킨 인클루드 책크시 */                
?>
        </div><!-- col-lg-9 -->
    </div><!-- row -->
</div><!-- container bs-docs-container-->
<!-- bottom menu start -->
<?php
if (is_file("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_bottom.php") && $tableskin!="skip") include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/menu_bottom.php");
echo "<!-- bottom menu end -->";
include ("./skinwiz/layout/".$cfg["skin"]["LayoutSkin"]."/layout_close.php");
/* Board에 스킨 인클루드 책크시 */
endif;
$dbcon->_close();