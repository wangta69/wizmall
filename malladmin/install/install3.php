<?php
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/
include "../../lib/cfg.common.php";
include ("../../lib/class.common.php");
$common = new common();

$db_host				= trim($_POST["db_host"]);
$db_user				= trim($_POST["db_user"]);
$db_password			= trim($_POST["db_password"]);
$USER_DB				= trim($_POST["USER_DB"]);
$admin					= trim($_POST["admin"]);
$PASS					= trim($_POST["PASS"]);
$cfg["sql"]["host"]		= $db_host;
$cfg["sql"]["dbname"]	= $USER_DB;
$cfg["sql"]["id"]		= $db_user;
$cfg["sql"]["pwd"]		= $db_password;

include "../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);

include "../../lib/class.board.php";
$board = new board();
$board->get_object($dbcon, $common);


$WIZTABLE["MAIN"]="wizTable_Main";
$WIZTABLE["GROUP"]="wizTable_Grp";
$WIZTABLE["BOARDCATEGORY"]="wizTable_Category";
$WIZTABLE["CATEGORY"]="wizCategory";
$WIZTABLE["BUYER"]="wizBuyers";
$WIZTABLE["BUYER1"]="wizBuyersMore";//추후 삭제
$WIZTABLE["CART"]="wizCart";
$WIZTABLE["INPUTER"]="wizInputer";
$WIZTABLE["COMPANY"]="wizCom";
$WIZTABLE["ESTIMATE"]="wizEstim";
$WIZTABLE["EVALU"]="wizEvalu";
$WIZTABLE["PRODUCT"]="wizMall";
$WIZTABLE["PRODUCTIMG"]="wizMall_img";
$WIZTABLE["MEMBER"]="wizMembers";
$WIZTABLE["MEMBER1"]="wizMembers_ind";
$WIZTABLE["POINT"]="wizPoint";
$WIZTABLE["COORBUY"]="wizcoorbuy";
$WIZTABLE["COORBUYER"]="wizcoorbuyer";
$WIZTABLE["ACCOUNT"]="wizaccount";
$WIZTABLE["DAILYACCOUNT"]="wizdailyaccount";
$WIZTABLE["MAILLIST"]="wizSendmaillist";
$WIZTABLE["ADDRESSBOOK"]="wizMailAddressBook";
$WIZTABLE["ADDRESSBOOKG"]="wizMailAddressBookG";
$WIZTABLE["VISIT_COUNTER"]="wizcounter_main";
$WIZTABLE["VISIT_REFERER"]="wizcounter_referer";
$WIZTABLE["INQUIRE"]="wizInquire";
$WIZTABLE["MESSAGE"]="wizordermail";
$WIZTABLE["POPUP"]="wizpopup";
$WIZTABLE["ZIPCODE"]="wizzipcode";


$fp = fopen("../../config/db_info.php", "w");
fwrite($fp,"<?php
\$cfg[\"sql\"][\"host\"] = \"".$db_host."\";
\$cfg[\"sql\"][\"dbname\"] = \"".$USER_DB."\";
\$cfg[\"sql\"][\"id\"] = \"".$db_user."\";
\$cfg[\"sql\"][\"pwd\"] =\"".$db_password."\";


\$WIZTABLE[\"MAIN\"]=\"wizTable_Main\";
\$WIZTABLE[\"GROUP\"]=\"wizTable_Grp\";
\$WIZTABLE[\"CATEGORY\"]=\"wizCategory\";
\$WIZTABLE[\"BUYER\"]=\"wizBuyers\";
\$WIZTABLE[\"BUYER1\"]=\"wizBuyersMore\";
\$WIZTABLE[\"INPUTER\"]=\"wizInputer\";
\$WIZTABLE[\"COMPANY\"]=\"wizCom\";
\$WIZTABLE[\"ESTIMATE\"]=\"wizEstim\";
\$WIZTABLE[\"EVALU\"]=\"wizEvalu\";
\$WIZTABLE[\"PRODUCT\"]=\"wizMall\";
\$WIZTABLE[\"MEMBER\"]=\"wizMembers\";
\$WIZTABLE[\"MEMBER1\"]=\"wizMembers_ind\";
\$WIZTABLE[\"COORBUY\"]=\"wizcoorbuy\";
\$WIZTABLE[\"COORBUYER\"]=\"wizcoorbuyer\";
\$WIZTABLE[\"ACCOUNT\"]=\"wizaccount\";
\$WIZTABLE[\"DAILYACCOUNT\"]=\"wizdailyaccount\";
\$WIZTABLE[\"MAILLIST\"]=\"wizSendmaillist\";
\$WIZTABLE[\"ADDRESSBOOK\"]=\"wizMailAddressBook\";
\$WIZTABLE[\"ADDRESSBOOKG\"]=\"wizMailAddressBookG\";
\$WIZTABLE[\"VISIT_COUNTER\"]=\"wizcounter_main\";
\$WIZTABLE[\"VISIT_REFERER\"]=\"wizcounter_referer\";
\$WIZTABLE[\"INQUIRE\"]=\"wizInquire\";
\$WIZTABLE[\"MESSAGE\"]=\"wizordermail\";
\$WIZTABLE[\"POPUP\"]=\"wizpopup\";
");
fclose($fp);

/* 메인테이블wizTable_Main(생성테이블이 입력되는 테이블) 생성 ********************************************************************************************/
$Wdate = time();	
$result = $dbcon->is_table( $WIZTABLE["MAIN"] );
if ( !$result ) {
	$sqlstr = "CREATE TABLE `".$WIZTABLE["MAIN"]."` (";
	$sqlstr .= "`UID` int(10) NOT NULL auto_increment,";
	$sqlstr .= "`BID` varchar(20) NOT NULL default '',";
	$sqlstr .= "`GID` varchar(20) NOT NULL default 'root',";
	$sqlstr .= "`BoardDes` varchar(250) NOT NULL default '',";
	$sqlstr .= "`AdminName` varchar(50) NOT NULL default '',";
	$sqlstr .= "`Pass` varchar(25) NOT NULL default '',";
	$sqlstr .= "`Grade` char(1) NOT NULL default '',";
	$sqlstr .= "`Grp` int(5) NOT NULL default '0',";//삭제예정
	$sqlstr .= "`Wdate` int(11) NOT NULL default '0',";
	$sqlstr .= "`login_fail_cnt` tinyint(4) NOT NULL,";
	$sqlstr .= "PRIMARY KEY  (`UID`),";
	$sqlstr .= "UNIQUE KEY `uniquebidgid` (`BID`,`GID`)";
	$sqlstr .= ") DEFAULT CHARSET=utf8";
	$dbcon->_query($sqlstr);
	
	$sqlstr = "INSERT IGNORE INTO ".$WIZTABLE["MAIN"]." VALUES (1, '', '', '','$admin', '$PASS', 'A', '', $Wdate, 0)";
	$dbcon->_query($sqlstr);
}

/* 총 검색용 테이블 wizTable_TotalSearch 생성 ********************************************************************************************/	
$result = $dbcon->is_table( "wizTable_TotalSearch");
if ( !$result) {
	$sqlstr = "CREATE TABLE `wizTable_TotalSearch` (";
	$sqlstr .= "`CATEGORY` int(5) NOT NULL default '0',";
	$sqlstr .= "`BID` varchar(20) NOT NULL default '',";
	$sqlstr .= "`GID` varchar(20) NOT NULL default '',";
	$sqlstr .= "`UID` int(11) NOT NULL default '0',";
	$sqlstr .= "`SUBJECT` varchar(100) NOT NULL default '',";
	$sqlstr .= "`CONTENTS` text NOT NULL,";
	$sqlstr .= "`WDATE` int(11) NOT NULL";
	$sqlstr .= ")  DEFAULT CHARSET=utf8";
	$dbcon->_query($sqlstr);
}

/* 포인트별 제목 강조용  `wizTable_Emp` 생성 ********************************************************************************************/	
$result = $dbcon->is_table( "wizTable_Emp");
if ( !$result) {
	$sqlstr = "CREATE TABLE `wizTable_Emp` (";
	$sqlstr .= "`uid` int(10) NOT NULL auto_increment,";
	$sqlstr .= "`bid` varchar(50) NOT NULL default '',";
	$sqlstr .= "`gid` varchar(20) NOT NULL default 'root',";
	$sqlstr .= "`point` int(5) NOT NULL default '0',"; //위즈테이블. GETPOINT 보다 많은 경우 처리 
	$sqlstr .= "`opflag` varchar(100) NULL default '',"; // icon:아이콘경로|strong:checked|color:....|Italic:checked....)로 정의
	$sqlstr .= "PRIMARY KEY  (`uid`)";
	$sqlstr .= ") DEFAULT CHARSET=utf8";
	$dbcon->_query($sqlstr);
}


/* 그룹테이블 wizTable_Grp 생성 ********************************************************************************************/	
$result = $dbcon->is_table( $WIZTABLE["GROUP"] );
if ( !$result) {
	$sqlstr = "CREATE TABLE ".$WIZTABLE["GROUP"]." (";
	$sqlstr .= "UID int(10) NOT NULL auto_increment,";
	$sqlstr .= "GID VARCHAR(20) DEFAULT '' NOT NULL,";//그룹코드(기본:root, 예약:intra, cafe, mail, avatar);
	$sqlstr .= "AdminName varchar(30) NOT NULL default '',";//그룹관리자명->아이디로 변경
	$sqlstr .= "Pass varchar(30) NOT NULL default '',";//그룹관리자 패스워드->member db와 연동이 없을 경우 사용
	$sqlstr .= "Grade char(1) NOT NULL default '',";//접근등급->현재는 필요없음
	$sqlstr .= "GrpName varchar(50) NOT NULL default '',";//-->그룹명(상기 그룹코드와는 다름):실제 mall에서 사용하는 그룹명
	$sqlstr .= "GrpCode varchar(20) NOT NULL default '',";//삭제예정
	$sqlstr .= "Mdate int(10) NOT NULL default '0',";
	$sqlstr .= "PRIMARY KEY  (UID),";
	$sqlstr .= "UNIQUE KEY `GID` (`GID`)";
	$sqlstr .= ") DEFAULT CHARSET=utf8";
	$dbcon->_query($sqlstr);
	$Wdate = time();
	$sqlstr = "INSERT IGNORE INTO wizTable_Grp VALUES (1, 'root', '', '', '','일반게시판', '1', $Wdate)";
	$dbcon->_query($sqlstr);
}


/* wizTable_Category 테이블생성 ********************************************************************************************/	
$sqlstr = "CREATE TABLE IF NOT EXISTS  `".$WIZTABLE["BOARDCATEGORY"]."` (";
$sqlstr .= "`uid` int(10) NOT NULL auto_increment,";
$sqlstr .= "`bid` varchar(50) NOT NULL default '',";
$sqlstr .= "`gid` varchar(20) NOT NULL default 'root',";
$sqlstr .= "`ordernum` int(5) NOT NULL default '0',";
$sqlstr .= "`catname` varchar(100) NOT NULL default '',";
$sqlstr .= "PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);


/* 파일저장용 wizTable_File 생성 ********************************************************************************************/	
$result = $dbcon->is_table( "wizTable_File");
if ( !$result) {
	$sqlstr = "CREATE TABLE `wizTable_File` (";
	$sqlstr .= "`uid` int(10) NOT NULL auto_increment,";
	$sqlstr .= "`pid` int(11) NOT NULL default '0',";
	$sqlstr .= "`bid` varchar(20) NOT NULL default '',";
	$sqlstr .= "`gid` varchar(20) NOT NULL default 'root',";
	$sqlstr .= "`seq` int(2) NOT NULL default '1',";
	$sqlstr .= "`filename` varchar(255) NOT NULL default '',";
	$sqlstr .= "PRIMARY KEY  (`uid`)";
	$sqlstr .= ") DEFAULT CHARSET=utf8";
	$dbcon->_query($sqlstr);
}

/* wizCategory 테이블생성 ********************************************************************************************/	
$sqlstr = "CREATE TABLE IF NOT EXISTS  `".$WIZTABLE["CATEGORY"]."` (";
$sqlstr .= "`UID` int(5) NOT NULL auto_increment,";
$sqlstr .= "`cat_order` int(3) default '0',";//카테고리 순서
$sqlstr .= "`cat_flag` varchar(20) NOT NULL default 'wizmall',";//카테고리flag
$sqlstr .= "`cat_no` varchar(15) default NULL,";//뒷자리부터 3자리씩 1차/2차/3차...분류
$sqlstr .= "`cat_name` varchar(30) default NULL,";//카테고리명
$sqlstr .= "`cat_price` varchar(13) default NULL,";//카테고리별 차등 가격
$sqlstr .= "`cat_skin` varchar(30) default NULL,";//카테고리별 제품리스트 스킨
$sqlstr .= "`cat_skin_viewer` varchar(30) default NULL,";//카테고리별 제품 viewer 스킨
$sqlstr .= "`cat_top` mediumtext,";//카테고리별 top 코딩
$sqlstr .= "`cat_bottom` mediumtext,";//카테고리별 bottom 코딩
$sqlstr .= "`cat_img` varchar(50) default NULL,";//카테고리별 이미지
$sqlstr .= "`pcnt` int(7) default '0',";//카테고리별 제품등록수
$sqlstr .= "PRIMARY KEY  (`UID`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);



/* wizBuyers 테이블생성 ********************************************************************************************/	
$sqlstr = "CREATE TABLE IF NOT EXISTS ".$WIZTABLE["BUYER"]." (";
$sqlstr .= "`UID` int(11) NOT NULL auto_increment,";
$sqlstr .= "`SName` varchar(30) NOT NULL default '',";//주문자명
$sqlstr .= "`SEmail` varchar(50) NOT NULL default '',";//주문자이메일
$sqlstr .= "`STel1` varchar(14) NOT NULL default '',";//주문자 전화(집전화)
$sqlstr .= "`STel2` varchar(14) NOT NULL default '',";//주문자 전화(핸드폰)
$sqlstr .= "`SZip` varchar(7) NOT NULL default '',";//주문자 우편번호
$sqlstr .= "`SAddress1` varchar(80) NOT NULL default '',";//주문자 주소1
$sqlstr .= "`SAddress2` varchar(50) NOT NULL default '',";//주문자 주소2
$sqlstr .= "`RName` varchar(30) NOT NULL default '',";//수신자명
$sqlstr .= "`RCompany` varchar(50) NOT NULL default '',";//수신자회사
$sqlstr .= "`RTel1` varchar(14) NOT NULL default '',";//수신사 전화(집전화)
$sqlstr .= "`RTel2` varchar(15) NOT NULL default '',";//수신자전화(핸드폰)
$sqlstr .= "`RZip` varchar(7) NOT NULL default '',";//수신자 우편번호
$sqlstr .= "`RAddress1` varchar(80) NOT NULL default '',";//수신자 주소1
$sqlstr .= "`RAddress2` varchar(50) NOT NULL default '',";//수신자 주소2
$sqlstr .= "`ExpectDate` int(11) NOT NULL default '0',";//배송받고 싶은 날짜
$sqlstr .= "`Message` varchar(250) NOT NULL default '',";//기타 주문자 입력 메시지
$sqlstr .= "`Deliverer` int(3) NOT NULL default '0',"; //배송업체명 wizdeliver.uid 기존 varchar 30->int 3 으로 변경
$sqlstr .= "`InvoiceNo` varchar(20) NOT NULL default '',";//송장번호(택배번호)
$sqlstr .= "`PayMethod` varchar(15) NOT NULL default '',";//online:온라인(무통장입금), card:카드, hand:핸드폰, autobank:자동이체, point:포인트결제, all:다중결제(config/common_array.php의 $PaySortArr 참조
$sqlstr .= "`CardStatus` varchar(10) NOT NULL default '',";
$sqlstr .= "`CardSequenceNo` varchar(8) NOT NULL default '',";
$sqlstr .= "`BankInfo` varchar(50) NOT NULL default '',";//결제계좌정보 (은행명|계좌번호|예금주)
$sqlstr .= "`Inputer` varchar(20) NOT NULL default '',";//입금자명
$sqlstr .= "`AmountPoint` int(10) NOT NULL default '0',";//포인트결제금액
$sqlstr .= "`AmountOline` int(10) NOT NULL default '0',";//온라인결제금액
$sqlstr .= "`AmountPg` int(10) NOT NULL default '0',";//PG (Card) 결제금액
$sqlstr .= "`TotalAmount` int(10) NOT NULL default '0',";//총결제금액
$sqlstr .= "`OrderID` varchar(13) NOT NULL default '0',";//주문번호
$sqlstr .= "`OrderStatus` int(2) NOT NULL default '0',";//전체주문에 대한 주문상태
$sqlstr .= "`MemberID` varchar(20) NOT NULL default '',";//주문자아이디
$sqlstr .= "`PayDate` int(11) NOT NULL default '0',";//결제일(무통장일경우 결제일과 주문일이 불일치)
$sqlstr .= "`BuyDate` int(11) NOT NULL default '0',";//주문일
$sqlstr .= "`Reserved1` varchar(15) NOT NULL default '',";//스페어필드, 스페어 필드는 주로 카드결제용으로 남겨둠
$sqlstr .= "`Reserved2` varchar(15) NOT NULL default '',";//스페어필드
$sqlstr .= "PRIMARY KEY  (`UID`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);


/* wizCart 장바구니테이블생성 ********************************************************************************************/	
$sqlstr = "CREATE TABLE IF NOT EXISTS ".$WIZTABLE["CART"]." (";
$sqlstr .= "`uid` int(11) NOT NULL auto_increment,";
$sqlstr .= "`oid` varchar(15) NOT NULL default '0',";//wizBuyers.OrderID 주문번호
$sqlstr .= "`pid` int(10) NOT NULL default '0',";//제품코드 wizMall.UID
$sqlstr .= "`spid` int(10) NOT NULL default '0',";//제품코드 wizMall.UID(멀티카테고리일경우 자식 아이디, 장바구니엣 이전으로 갈경우)
$sqlstr .= "`qty` int(5) NOT NULL default '0',";//구매갯수
$sqlstr .= "`price` int(10) NOT NULL default '0',";//단가
$sqlstr .= "`tprice` int(10) NOT NULL default '0',";//총액(옵션가 포함)
$sqlstr .= "`point` int(10) NOT NULL default '0',";//포인트
$sqlstr .= "`tpoint` int(10) NOT NULL default '0',";//총포인트
$sqlstr .= "`optionflag` varchar(200) NOT NULL default '',";//옵션정보입력//flag::옵션명::옵션값::옵셔가격||";
$sqlstr .= "`option1` varchar(30) NOT NULL default '',";//삭제예정
//$sqlstr .= "`option1_price` int(10) NOT NULL default '0',";//삭제예정
//$sqlstr .= "`option2` varchar(30) NOT NULL default '',";//삭제예정
//$sqlstr .= "`option2_price` int(10) NOT NULL default '0',";//삭제예정
//$sqlstr .= "`option3` varchar(30) NOT NULL default '',";//삭제예정
//$sqlstr .= "`option3_price` int(10) NOT NULL default '0',";//삭제예정
//$sqlstr .= "`etc` varchar(200) NOT NULL default '',";//삭제예정
//$sqlstr .= "`flag1` int(2) NOT NULL default '0',";//주문단계 0 : 주문전 1 : 주문완료 2: 결제완료 삭제예정
//$sqlstr .= "`flag2` int(2) NOT NULL default '0',";//1 : 옵션가격차등적용, 2: 옵션가격으로 현가격변동|, 삭제예정
$sqlstr .= "`ostatus` int(2) NOT NULL default '0',";//각각의 제품에 대한 주문상태
$sqlstr .= "`deliverer` int(3) default NULL,";//각각의 제품에 대한 배송업체 wizdeliver.uid
$sqlstr .= "`invoiceno` varchar(30) default NULL,";//각각의 제품에 대한 송장번호

$sqlstr .= "`wdate` int(11) NOT NULL default '0',";
$sqlstr .= "PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);


/* wizBuyersMore 테이블생성 *******************************************************************************************	
$sqlstr = "CREATE TABLE IF NOT EXISTS ".$WIZTABLE["BUYER1"]." (";//추후 삭제
$sqlstr .= "BID int(10) NOT NULL auto_increment,";
$sqlstr .= "BuyCode varchar(13) NOT NULL default '',";
$sqlstr .= "BuyerID varchar(20) NOT NULL default '',";
$sqlstr .= "BuyGoodsCode varchar(15) NOT NULL default '',";
$sqlstr .= "BuyGoodsQty varchar(13) NOT NULL default '',";
$sqlstr .= "BuyPrice int(8) NOT NULL default '0',";
$sqlstr .= "BuyPrice1 int(8) NOT NULL default '0',";
$sqlstr .= "BuyWonga int(8) NOT NULL default '0',";
$sqlstr .= "BuyDate int(10) NOT NULL default '0',";
$sqlstr .= "PRIMARY KEY  (BID)";
$sqlstr .= ")";
$dbcon->_query($sqlstr);
*/
/* wizInputer 테이블생성 ********************************************************************************************/	
$sqlstr = "CREATE TABLE IF NOT EXISTS ".$WIZTABLE["INPUTER"]." (";
$sqlstr .= "IID int(10) NOT NULL auto_increment,";
$sqlstr .= "Icomid varchar(15) NOT NULL default '',";//입고처 아이디
$sqlstr .= "Ioid int(10) NOT NULL default '0',";//판매시 wizCart.uid
$sqlstr .= "Igoodscode int(10) NOT NULL default '0',";//쇼핑몰 판매 제품 아이디
$sqlstr .= "Iinputqty int(10) NOT NULL default '0',";//입고갯수
$sqlstr .= "Iunit varchar(20) NOT NULL default '',";//제품단위
$sqlstr .= "Iinputprice int(10) NOT NULL default '0',";//입고가격
$sqlstr .= "Iinputdate int(10) NOT NULL default '0',";//입고일
$sqlstr .= "PRIMARY KEY  (IID)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);


/* wizCom 테이블생성 ********************************************************************************************/	
$sqlstr = "CREATE TABLE IF NOT EXISTS ".$WIZTABLE["COMPANY"]." (";
$sqlstr .= "UID int(5) NOT NULL auto_increment,";
$sqlstr .= "CompSort tinyint(2) unsigned zerofill NOT NULL default '00',";// 01 도매공급자, 02 소매공급자, 03 생산자, 51 도매판매처, 52 소매판매처 
$sqlstr .= "CompID varchar(15) NOT NULL default '',";//아이디(아이디와 패스워드는 회원 wizmember 에서 통합관리
$sqlstr .= "CompPass varchar(15) NOT NULL default '',";//패스워드
$sqlstr .= "CompPersonalID varchar(15) NOT NULL default '',";
$sqlstr .= "CompName varchar(100) NOT NULL default '',";//상호명
$sqlstr .= "CompNum varchar(15) NOT NULL default '',";//사업자등록번호
$sqlstr .= "CompSortNum varchar(15) NOT NULL default '',";
$sqlstr .= "CompKind varchar(50) NOT NULL default '',";//업태
$sqlstr .= "CompType varchar(30) NOT NULL default '',";//종목
$sqlstr .= "CompMain varchar(30) NOT NULL default '',";//주종목
$sqlstr .= "CompFoundDay varchar(30) NOT NULL default '',";//설립일
$sqlstr .= "CompEmployeeNum varchar(30) NOT NULL default '',";//고용인원수
$sqlstr .= "CompZip1 varchar(7) NOT NULL default '0',";
$sqlstr .= "CompAddress1 varchar(100) NOT NULL default '',";
$sqlstr .= "CompAddress2 varchar(100) NOT NULL default '',";
$sqlstr .= "CompTel varchar(30) NOT NULL default '',";
$sqlstr .= "CompFax varchar(30) NOT NULL default '',";
$sqlstr .= "CompPreName varchar(15) NOT NULL default '',";//대표자명
$sqlstr .= "CompPreNum1 int(6) NOT NULL default '0',";//대표자 주민번호
$sqlstr .= "CompPreNum2 int(7) NOT NULL default '0',";
$sqlstr .= "CompPreTel varchar(30) NOT NULL default '',";//대표자 연락처
$sqlstr .= "CompUrl varchar(50) NOT NULL default '',";//
$sqlstr .= "CompEmail varchar(30) NOT NULL default '',";
$sqlstr .= "CompChaName varchar(30) NOT NULL default '',";//담당자명
$sqlstr .= "CompChaTel varchar(30) NOT NULL default '',";//담당자 전화번호
$sqlstr .= "CompChaEmail varchar(30) NOT NULL default '',";//담당자 이메일
$sqlstr .= "CompChaDep varchar(30) NOT NULL default '',";//담당자 부서
$sqlstr .= "CompChaLevel varchar(30) NOT NULL default '',";//담당자 직급
$sqlstr .= "CompChaBirthDay varchar(30) NOT NULL default '',";
$sqlstr .= "CompChaBirthType varchar(2) NOT NULL default '',";
$sqlstr .= "CompChaBirthGender varchar(2) NOT NULL default '',";
$sqlstr .= "CompContents text NOT NULL,";
$sqlstr .= "PRIMARY KEY  (UID)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

/* wizEstim 테이블생성 ********************************************************************************************/
	
$sqlstr = "CREATE TABLE IF NOT EXISTS ".$WIZTABLE["ESTIMATE"]." (";
$sqlstr .= "UID int(10) NOT NULL auto_increment,";
$sqlstr .= "Sender_Name varchar(10) NOT NULL default '',";
$sqlstr .= "Sender_Email varchar(50) NOT NULL default '',";
$sqlstr .= "Sender_Tel varchar(14) NOT NULL default '',";
$sqlstr .= "Sender_Pcs varchar(14) NOT NULL default '',";
$sqlstr .= "Re_Name varchar(10) NOT NULL default '',";
$sqlstr .= "Re_Tel varchar(14) NOT NULL default '',";
$sqlstr .= "Zip varchar(7) NOT NULL default '',";
$sqlstr .= "Address varchar(250) NOT NULL default '',";
$sqlstr .= "Re_Date varchar(14) NOT NULL default '',";
$sqlstr .= "Message text NOT NULL,";
$sqlstr .= "How_Buy varchar(15) NOT NULL default '',";
$sqlstr .= "How_Bank varchar(100) NOT NULL default '',";
$sqlstr .= "Point_Money int(10) NOT NULL default '0',";
$sqlstr .= "Ziro_Money int(10) NOT NULL default '0',";
$sqlstr .= "Card_Money int(10) NOT NULL default '0',";
$sqlstr .= "Total_Money int(10) NOT NULL default '0',";
$sqlstr .= "Co_Del varchar(8) NOT NULL default '',";
$sqlstr .= "CODE_VALUE varchar(13) NOT NULL default '',";
$sqlstr .= "Co_Now varchar(15) NOT NULL default '',";
$sqlstr .= "Co_Memberid varchar(13) NOT NULL default '',";
$sqlstr .= "Co_Name text NOT NULL,";
$sqlstr .= "Buy_Date int(11) NOT NULL default '0',";
$sqlstr .= "PRIMARY KEY  (UID)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

/* wizEvalu 테이블생성 ********************************************************************************************/
	
$sqlstr = "CREATE TABLE IF NOT EXISTS ".$WIZTABLE["EVALU"]." (";
$sqlstr .= "UID int(6) NOT NULL auto_increment,";
$sqlstr .= "GID varchar(20) NOT NULL default '',";
$sqlstr .= "ID varchar(20) NOT NULL default '',";
$sqlstr .= "Name varchar(50) NOT NULL default '',";
$sqlstr .= "Passwd varchar(20) NOT NULL default '',";
$sqlstr .= "Email varchar(30) NOT NULL default '',";
$sqlstr .= "Grade varchar(5) NOT NULL default '',";
$sqlstr .= "Subject varchar(100) NOT NULL default '',";
$sqlstr .= "Contents text NOT NULL,";
$sqlstr .= "TxtType varchar(10) NOT NULL default '',";
$sqlstr .= "Count int(5) NOT NULL default '0',";
$sqlstr .= "IP varchar(15) NOT NULL default '',";
$sqlstr .= "Wdate int(10) NOT NULL default '0',";
$sqlstr .= "PRIMARY KEY  (UID)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

/* wizMall 테이블생성 ********************************************************************************************/	
$sqlstr = "CREATE TABLE IF NOT EXISTS ".$WIZTABLE["PRODUCT"]." (";
$sqlstr .= "UID int(10) NOT NULL auto_increment,";
$sqlstr .= "`RegID` varchar(7) NOT NULL default 'wizmall',";//등록자 아이디(이후 mall in mall 확장을 위해)
$sqlstr .= "PID int(10) NOT NULL default '0',";
$sqlstr .= "OrderID int(5) NOT NULL default '0',";//상품디스플레이 순서
$sqlstr .= "SiteFlag varchar(20) NOT NULL default '',";//삭제예정
$sqlstr .= "Name varchar(100) binary NOT NULL default '',";
$sqlstr .= "Brand varchar(100) default NULL,";
$sqlstr .= "CompName varchar(50) default NULL,";
$sqlstr .= "Price int(8) NOT NULL default '0',";
$sqlstr .= "Price1 int(8) NOT NULL default '0',";
$sqlstr .= "WongaPrice int(8) NOT NULL default '0',";
$sqlstr .= "Point int(8) NOT NULL default '0',";
$sqlstr .= "Unit varchar(10) default NULL,";
$sqlstr .= "Model varchar(50) default NULL,";
$sqlstr .= "Regoption varchar(30) default NULL,";//Option3->Regoption//옵션상품
$sqlstr .= "SimilarPd varchar(30) default NULL,";//Option5->SimilarPd//유사상품
$sqlstr .= "Picture varchar(100) default NULL,";
$sqlstr .= "None int(1) NOT NULL default '0',";// 수정 1-> 품절,
$sqlstr .= "tmpOutput int(5) NOT NULL default '0',";//현재 판매대기량
$sqlstr .= "Output int(5) NOT NULL default '0',";//판매 누적 수량
$sqlstr .= "Stock int(4) NOT NULL default '0',";//현재고량
$sqlstr .= "PStatus int(2) NOT NULL default '0',";
$sqlstr .= "TStatus int(2) NOT NULL default '0',";
$sqlstr .= "Date int(10) NOT NULL default '0',";
$sqlstr .= "Description1 text,";
$sqlstr .= "Description2 text,";
$sqlstr .= "Description3 text,";
$sqlstr .= "CatFlag varchar(20) default NULL,";
$sqlstr .= "`Category` varchar(15) default NULL,";
$sqlstr .= "TextType varchar(8) default NULL,";//0|0|0 (상품상세설명html enable | 상품간략설명html enable | 배송정보 html enable
$sqlstr .= "`opflag` enum('c') default NULL,";//c: 공동구매, d: 차등가격
$sqlstr .= "Hit int(4) NOT NULL default '0',";
$sqlstr .= "GetComp varchar(15) default NULL,";
$sqlstr .= "PRIMARY KEY  (UID)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

/* wizMallExt 테이블생성 (기존 wizMall외에 추가 적인 필드 요구시 사용(uid 및 mid 는 고정) - 자유롭게 프로그램) ********************************************************************************************/
$sqlstr = "CREATE TABLE IF NOT EXISTS `wizMallExt` (";
$sqlstr .= "`uid` int(11) NOT NULL auto_increment,";
$sqlstr .= "`mid` int(11) NOT NULL default '0',";//wizMall.UID
$sqlstr .= "`filename` varchar(50) binary NOT NULL default '',";
$sqlstr .= "PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

/* wizMall_img 테이블생성 ********************************************************************************************/	
$sqlstr = "CREATE TABLE IF NOT EXISTS ".$WIZTABLE["PRODUCTIMG"]." (";
$sqlstr .= "`uid` int(11) NOT NULL auto_increment,";
$sqlstr .= "`pid` int(11) NOT NULL default '0',";
$sqlstr .= "`opflag` enum('m') NOT NULL,";
$sqlstr .= "`orderid` int(5) NOT NULL default '0',";
$sqlstr .= "`filename` varchar(100) NOT NULL default '',";
$sqlstr .= "`imgname` varchar(50) NOT NULL default '',";
$sqlstr .= "PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

/* wizMallDiffPrice 차등가격 적용 테이블생성 ********************************************************************************************/	
$sqlstr	= "CREATE TABLE IF NOT EXISTS `wizMallDiffPrice` (";
$sqlstr .= "`uid` int(11) NOT NULL auto_increment,";
$sqlstr .= "`pid` int(11) NOT NULL default '0',";
$sqlstr .= "`qty` int(11) NOT NULL default '0',";
$sqlstr .= "`price` int(11) NOT NULL default '0',";
$sqlstr .= "PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

/* `wizMembers` 테이블생성 ********************************************************************************************/		
$sqlstr = "CREATE TABLE IF NOT EXISTS ".$WIZTABLE["MEMBER"]." (";
$sqlstr .= "`uid` int(10) NOT NULL auto_increment,";
$sqlstr .= "`mid` varbinary(15) NOT NULL default '',";//회원아이디
$sqlstr .= "`mpasswd` varchar(150) NOT NULL default '',";//회원패스워드
$sqlstr .= "`mname` varchar(30) NOT NULL default '',";//회원명
$sqlstr .= "`mregdate` int(10) NOT NULL default '0',";//회원가입일
$sqlstr .= "`mgrantsta` char(2) NOT NULL default '',";//회원상태 :03(정상)
$sqlstr .= "`mpoint` int(10) NOT NULL default '0',";//회원포인트
$sqlstr .= "`mexp` int(11) NOT NULL default '0',";//회원경험치(커뮤니티용)
$sqlstr .= "`mtype` int(2) NOT NULL default '1',";//일반회원 : 1(회원등급외에 별도의 등급을 주기위해서 책크)
$sqlstr .= "`mgrade` int(2) NOT NULL default '0',";//회원등급
$sqlstr .= "`mailreceive` int(1) NOT NULL default '0',";//메일수신 1, 미수신:0;
$sqlstr .= "`msmsreceive` int(1) NOT NULL default '0',";//SMS수신 1, 미수신:0;
$sqlstr .= "`mwebmail` int(1) NOT NULL default '0',";//웹메일사용여부(웹메일솔루션과 연동시) 1: 사용
$sqlstr .= "`mloginnum` int(4) NOT NULL default '0',";//로그인횟수
$sqlstr .= "`mlogindate` int(10) NOT NULL default '0',";//최근로그인 데이타
$sqlstr .= "`mloginip` varchar(15) NOT NULL,";//최근로그인 아이피
$sqlstr .= "`mpointlogindate` int(11) default NULL,";//로그인 포인트를 지급받은 최근 데이타
$sqlstr .= "`mvaliddate` int(11) default NULL,";//??
$sqlstr .= "PRIMARY KEY  (`uid`),";
$sqlstr .= "UNIQUE KEY `mid` (`mid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

/* `wizMembers_login_log` 테이블생성 ********************************************************************************************/ 
$sqlstr = "CREATE TABLE IF NOT EXISTS `wizMembers_login_log` (";
$sqlstr .= "`mid` varbinary(25) NOT NULL,";
$sqlstr .= "`mlogindate` int(11) NOT NULL DEFAULT '0',";
$sqlstr .= "`mloginip` varchar(15) NOT NULL,";
$sqlstr .= "`mloginresult` tinyint(1) NOT NULL,";
$sqlstr .= "KEY `mid` (`mid`),";
$sqlstr .= "KEY `mlogindate` (`mlogindate`),";
$sqlstr .= "KEY `mloginresult` (`mloginresult`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);



/* wizPoint 포인트테이블생성 ********************************************************************************************/
$sqlstr = "CREATE TABLE IF NOT EXISTS ".$WIZTABLE["POINT"]." (";
$sqlstr .= "`uid` int(10) NOT NULL auto_increment,";
$sqlstr .= "`id` varchar(20) NOT NULL default '',";
$sqlstr .= "`pid` int(11) default NULL,";//게시판의 고유값
$sqlstr .= "`ptype` int(3) NOT NULL default '0',";
$sqlstr .= "`contents` varchar(30) default NULL,";

## 포인트 내용(ptype)
## member :1: 회원가입 ,2: 로그인포인트, 3: 회원추천->contents:추천인아이디
## board : 11:글등록->contents(테이블명)
## admin : 21:물품구매->contents(wizCart.uid)
## event : 기타코드-> 기타코드

$sqlstr .= "`point` int(10) NOT NULL default '0',";
$sqlstr .= "`flag` int(1) NOT NULL default '1',";
$sqlstr .= "`wdate` int(10) NOT NULL default '0',";
$sqlstr .= "PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);


/* `wizMembers_ind` 테이블생성 ********************************************************************************************/
		
$sqlstr = "CREATE TABLE IF NOT EXISTS ".$WIZTABLE["MEMBER1"]." (";
$sqlstr .= "`id` varbinary(15) NOT NULL default '',";
$sqlstr .= "`nickname` varbinary(30) NOT NULL default '',";
$sqlstr .= "`pwdhint` varchar(50) NOT NULL default '',";
$sqlstr .= "`pwdanswer` varchar(50) NOT NULL default '',";
$sqlstr .= "`gender` int(1) NOT NULL default '0',";//1:남성, 2:여성
$sqlstr .= "`jumin1` varchar(50) NOT NULL default '0',";
$sqlstr .= "`jumin2` varchar(50) NOT NULL default '0',";
$sqlstr .= "`ci` varchar(255) NOT NULL default '0',";
$sqlstr .= "`di` varchar(255) NOT NULL default '0',";
$sqlstr .= "`birthdate` varchar(11) NOT NULL default '',";//yyyy/mm/dd
$sqlstr .= "`birthtype` int(1) NOT NULL default '0',";//양력:0, 음력1
$sqlstr .= "`marrdate` varchar(11) NOT NULL default '',";//yyyy/mm/dd
$sqlstr .= "`marrstatus` int(2) NOT NULL default '0',";//미혼0, 기혼1
$sqlstr .= "`email` varchar(50) NOT NULL default '',";
$sqlstr .= "`mailreceive` tinyint(1) NOT NULL default '0',";//수신:0, 비수신:1
$sqlstr .= "`job` varchar(20) NOT NULL default '0',";
$sqlstr .= "`scholarship` varchar(20) NOT NULL default '0',";
$sqlstr .= "`company` varchar(30) NOT NULL default '0',";
$sqlstr .= "`companynum` varchar(12) NOT NULL default '0',";
$sqlstr .= "`telflag` int(1) NOT NULL default '0',";//수신전화번호:1:tel1, 2:tel2..
$sqlstr .= "`tel1` varchar(14) NOT NULL default '',";//집전화번호
$sqlstr .= "`tel2` varchar(14) NOT NULL default '',";//핸드폰번호
$sqlstr .= "`tel3` varchar(14) NOT NULL default '',";//기타번호(사무실등)
$sqlstr .= "`fax` varchar(14) NOT NULL default '',";
$sqlstr .= "`addressflag` int(1) NOT NULL default '0',";//주 수신 어드레스(1:집, 2:회사)
$sqlstr .= "`zip1` varchar(7) NOT NULL default '0',";
$sqlstr .= "`address1` varchar(100) NOT NULL default '',";
$sqlstr .= "`address2` varchar(50) NOT NULL default '',";
$sqlstr .= "`zip2` varchar(7) NOT NULL default '0',";
$sqlstr .= "`address3` varchar(100) NOT NULL default '',";
$sqlstr .= "`address4` varchar(50) NOT NULL default '',";
$sqlstr .= "`url` varchar(50) NOT NULL default '',";
$sqlstr .= "`recid` varchar(15) NOT NULL default '',";//추천인아이디
$sqlstr .= "`etccontents` varchar(150) default NULL,";//기타내용:관리자용 메모 혹은 자기 소개서
$sqlstr .= "PRIMARY KEY  (`id`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);


/* `wizMembers_withdrawal` [회원탈퇴 정보]테이블생성 ********************************************************************************************/
$sqlstr = "CREATE TABLE IF NOT EXISTS `wizMembers_withdrawal` (";
$sqlstr .= "`uid` int(10) NOT NULL auto_increment,";
$sqlstr .= "`wid` varchar(15) NOT NULL default '',";//탙퇴인아이디
$sqlstr .= "`wname` varchar(30) NOT NULL default '',";//탈퇴인이름
$sqlstr .= "`wtype` int(2) NOT NULL default '1',";//탈퇴인 타입(기업/일반)
$sqlstr .= "`wgrade` int(2) NOT NULL default '0',";//탈퇴인 등급
$sqlstr .= "`wreason` varchar(255) NOT NULL,";//탈퇴이유 | 으로 처리
$sqlstr .= "`wdate` int(11) default NULL,";//탈퇴일
$sqlstr .= "`content` text NOT NULL,";//기타 내용
$sqlstr .= "PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);


/* `wizMembers_log` 회원관련 각종 로그 ********************************************************************************************/
## reple 에 대한 값 매기기
$result = $dbcon->is_table("wizMembers_log");
if ( !$result ){	
	$sqlstr = "CREATE TABLE `wizMembers_log` (";
	$sqlstr .= "`uid` int(11) NOT NULL auto_increment,";
	$sqlstr .= "`userid` varchar(20) NOT NULL default '',";
	$sqlstr .= "`pid` int(11) NOT NULL default '0',";//아래 tb_name 테이블의 고유 아이디
	$sqlstr .= "`tb_name` varchar(30) NOT NULL default '',";
	$sqlstr .= "`wdate` int(11) NOT NULL default '0',";
	$sqlstr .= "PRIMARY KEY  (`uid`)";
	$sqlstr .= ") DEFAULT CHARSET=utf8";
	$dbcon->_query($sqlstr);
}

/* wizcoorbuy 테이블생성 ********************************************************************************************/
	
$sqlstr = "CREATE TABLE IF NOT EXISTS ".$WIZTABLE["COORBUY"]." (";
$sqlstr .= "UID int(11) NOT NULL auto_increment,";
$sqlstr .= "PID int(11) NOT NULL default '0',";//wizMall.UID
$sqlstr .= "PriceQty varchar(100) NOT NULL default '',";//price:qty:point||price1:qty1:point1..
$sqlstr .= "SDate int(11) NOT NULL default '0',";//시작일
$sqlstr .= "FDate int(11) NOT NULL default '0',";//종료일
$sqlstr .= "wdate int(11) NOT NULL default '0',";
$sqlstr .= "PRIMARY KEY  (UID)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

/* DAILYACCOUNT(일계장) 테이블생성 ********************************************************************************************/
		
$sqlstr = "CREATE TABLE IF NOT EXISTS ".$WIZTABLE["DAILYACCOUNT"]." (";
$sqlstr .= "CID int(10) NOT NULL auto_increment,";
$sqlstr .= "CMID varchar(20) NOT NULL default '',";
$sqlstr .= "Ccredititem varchar(250) NOT NULL default '',";
$sqlstr .= "Ccreditprice int(8) NOT NULL default '0',";
$sqlstr .= "Cincomprice int(8) NOT NULL default '0',";
$sqlstr .= "Cdate int(10) NOT NULL default '0',";
$sqlstr .= "UNIQUE KEY CID (CID),";
$sqlstr .= "KEY CID_2 (CID)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);


/* wizSendmaillist (보낸메일 리스트 테이블) 테이블생성 ********************************************************************************************/

$sqlstr = "CREATE TABLE IF NOT EXISTS ".$WIZTABLE["MAILLIST"]." (";
$sqlstr .= "`uid` int(10) unsigned NOT NULL auto_increment,";
$sqlstr .= "`sendername` varchar(30) default NULL,";
$sqlstr .= "`senderemail` varchar(30) default NULL,";
$sqlstr .= "`tomember` text NOT NULL,";
$sqlstr .= "`reply` varchar(30) default NULL,";
$sqlstr .= "`subject` varchar(100) default NULL,";
$sqlstr .= "`contenttype` int(1) unsigned default NULL,";
$sqlstr .= "`mailskin` varchar(20) default NULL,";
$sqlstr .= "`body_txt` text NOT NULL,";
$sqlstr .= "`userfile` varchar(50) default NULL,";
$sqlstr .= "`addsource` int(2) unsigned default NULL,";
$sqlstr .= "`soption` varchar(20) default NULL,";
$sqlstr .= "`mailreject` int(1) unsigned default NULL,";
$sqlstr .= "`startseq` int(11) default NULL,";
$sqlstr .= "`stopseq` int(11) default NULL,";
$sqlstr .= "`genderselect` int(1) unsigned default NULL,";
$sqlstr .= "`gradeselect` int(3) unsigned default NULL,";
$sqlstr .= "`testmailaddress` varchar(30) default NULL,";
$sqlstr .= "`usermaillist` varchar(30) default NULL,";
$sqlstr .= "`sdate` int(11) unsigned default NULL,";
$sqlstr .= "PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";

$dbcon->_query($sqlstr);



/* wizMailAddressBook (wizMail or 개인용 AddressBook) 테이블생성 ********************************************************************************************/
		
$sqlstr = "CREATE TABLE IF NOT EXISTS ".$WIZTABLE["ADDRESSBOOK"]." (";
$sqlstr .= "idx int(10) NOT NULL auto_increment,";
$sqlstr .= "userid varchar(20) default NULL,";
$sqlstr .= "name varchar(20) default NULL,";
$sqlstr .= "grp varchar(10) default NULL,";
$sqlstr .= "email varchar(60) default NULL,";
$sqlstr .= "company varchar(80) default NULL,";
$sqlstr .= "buseo varchar(80) default NULL,";
$sqlstr .= "work varchar(80) default NULL,";
$sqlstr .= "hphone varchar(11) default NULL,";
$sqlstr .= "cphone varchar(11) default NULL,";
$sqlstr .= "hand varchar(11) default NULL,";
$sqlstr .= "fax varchar(11) default NULL,";
$sqlstr .= "post varchar(6) default NULL,";
$sqlstr .= "addr1 varchar(200) default NULL,";
$sqlstr .= "addr2 varchar(200) default NULL,";
$sqlstr .= "memo text,";
$sqlstr .= "date varchar(30) default NULL,";
$sqlstr .= "shard char(1) default NULL,";
$sqlstr .= "phone char(2) default NULL,";
$sqlstr .= "KEY idx (idx)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

/* 주소록 그룹 테이블생성 ********************************************************************************************/
$sqlstr = "CREATE TABLE IF NOT EXISTS ".$WIZTABLE["ADDRESSBOOKG"]." (";
$sqlstr .= "idx int(10) NOT NULL auto_increment,";
$sqlstr .= "userid varchar(20) default NULL,";
$sqlstr .= "code varchar(10) default NULL,";
$sqlstr .= "subject varchar(20) default NULL,";
$sqlstr .= "KEY idx (idx)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

/* wizDiary (관리자 및 개인용 일정관리 프로그램) 테이블생성 ********************************************************************************************/
$sqlstr = "CREATE TABLE IF NOT EXISTS `wizDiary` (";
$sqlstr .= "`uid` int(11) NOT NULL AUTO_INCREMENT,";
$sqlstr .= "`user_id` varchar(20) NOT NULL DEFAULT '',";
$sqlstr .= "`schedule_date` int(11) NOT NULL DEFAULT '0',";
$sqlstr .= "`schedule_title` varchar(50) NOT NULL DEFAULT '',";
$sqlstr .= "`schedule_comment` text NOT NULL,";
$sqlstr .= "`status` varchar(25) DEFAULT NULL,";
$sqlstr .= "`category` varchar(10) NOT NULL DEFAULT '',";
$sqlstr .= "PRIMARY KEY (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);


/* wizcount counter_main table생성 ********************************************************************************************/
$result = $dbcon->is_table( $WIZTABLE["VISIT_COUNTER"] );
if ( !$result ){		
$sqlstr = "create table wizcounter_main (";
$sqlstr .= "no int(10) not null auto_increment primary key,";
$sqlstr .= "date int(10),";
$sqlstr .= "unique_counter int(10),";
$sqlstr .= "pageview int(10)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

$sqlstr = "INSERT IGNORE INTO wizcounter_main values ('1','0','0','0')";
$dbcon->_query($sqlstr);
}

/* wizcount counter_referer table생성 ********************************************************************************************/
	
$sqlstr = "CREATE TABLE IF NOT EXISTS ".$WIZTABLE["VISIT_REFERER"]." (";
$sqlstr .= "no int(10) not null auto_increment primary key,";
$sqlstr .= "date int(10),";
$sqlstr .= "hit int(10),";
$sqlstr .= "referer varchar(255),";
$sqlstr .= "ip varchar(15)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);


##위즈보드용 디렉토리 생성
$path = "../../config/wizboard";
$common->mkfolder($path);

$path = "../../config/wizboard/channel";
$common->mkfolder($path);

$path = "../../config/wizboard/table";
$common->mkfolder($path);

$fp = fopen("../../config/wizboard/table/config.php", "w"); 
fclose($fp); 

$fp = fopen("../../config/wizboard/table/prohibit_ip_list.php", "w"); 
fclose($fp); 

$SetupPath = "../../config/wizboard";
$SourcePath = "../../wizboard";
$default_option = "mall_default";
$Pass = "wizmall";
/* 고객게시판 ********************************************************************************************/
$bid = "board01";
$TABLE_DES = "고객게시판";
$board->createTable($bid, "root", $TABLE_DES, $AdminName, $Pass, $group, $SetupPath, $SourcePath,$default_option);
/* 공지사항 ********************************************************************************************/
$bid = "board02";
$TABLE_DES = "공지사항";
$board->createTable($bid, "root", $TABLE_DES, $AdminName, $Pass, $group, $SetupPath, $SourcePath,$default_option);

/* 자주묻는 질문 ********************************************************************************************/
$bid = "board03";
$TABLE_DES = "자주묻는 질문";
$board->createTable($bid, "root", $TABLE_DES, $AdminName, $Pass, $group, $SetupPath, $SourcePath,$default_option);

/* 커뮤니티 ********************************************************************************************/
$bid = "board04";
$TABLE_DES = "커뮤니티";
$board->createTable($bid, "root", $TABLE_DES, $AdminName, $Pass, $group, $SetupPath, $SourcePath,$default_option);

/* zipcode table생성 ********************************************************************************************/
$sqlstr= "CREATE TABLE IF NOT EXISTS `wizzipcode` (";
$sqlstr .= "`zipcode` varchar(7) NOT NULL default '',";
$sqlstr .= "`sido` varchar(10) NOT NULL default '',";
$sqlstr .= "`gugun` varchar(50) NOT NULL default '',";
$sqlstr .= "`dong` varchar(50) NOT NULL default '',";
$sqlstr .= "`bunji` varchar(50) NOT NULL default ''";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);


$zipdb = array("db_zip_seoul"=>"서울특별시", "db_zip_busan"=>"부산광역시", "db_zip_daegu"=>"대구광역시"
, "db_zip_incheon"=>"인천광역시", "db_zip_gwangju"=>"광주광역시", "db_zip_daejeon"=>"대전광역시"
, "db_zip_ulsan"=>"울산광역시", "db_zip_sejong"=>"세종특별자치시", "db_zip_gangwon"=>"강원도"
, "db_zip_gyeonggi"=>"경기도", "db_zip_gyeongsang_s"=>"경상남도", "db_zip_gyeongsang_n"=>"경상북도"
, "db_zip_jeolla_s"=>"전라남도", "db_zip_jeolla_n"=>"전라북도", "db_zip_jeju"=>"제주특별자치도"
, "db_zip_chungcheong_s"=>"충청남도", "db_zip_chungcheong_n"=>"충청북도");

foreach($zipdb as $key=>$val){
	$sqlstr= "CREATE TABLE IF NOT EXISTS `".$key."` (";
	$sqlstr .= "`zipcode` varchar(6) NOT NULL DEFAULT '',";
	$sqlstr .= "`serialno` varchar(3) NOT NULL DEFAULT '',";
	$sqlstr .= "`sido` varchar(20) NOT NULL DEFAULT '',";
	$sqlstr .= "`sigungu` varchar(20) NOT NULL DEFAULT '',";
	$sqlstr .= "`upmyeondong` varchar(20) NOT NULL DEFAULT '',";
	$sqlstr .= "`street_code` varchar(12) NOT NULL DEFAULT '',";
	$sqlstr .= "`street` varchar(20) NOT NULL DEFAULT '',";
	$sqlstr .= "`isbasement` varchar(1) NOT NULL DEFAULT '',";
	$sqlstr .= "`buildingno` varchar(10) NOT NULL DEFAULT '',";
	$sqlstr .= "`buildingsubno` varchar(30) NOT NULL DEFAULT '',";
	$sqlstr .= "`buildingmanageno` varchar(30) NOT NULL DEFAULT '',";
	$sqlstr .= "`massdelivery` varchar(20) NOT NULL DEFAULT '',";
	$sqlstr .= "`sigungubuildingname` varchar(20) NOT NULL DEFAULT '',";
	$sqlstr .= "`dongcode` varchar(10) NOT NULL DEFAULT '',";
	$sqlstr .= "`dongname` varchar(20) NOT NULL DEFAULT '',";
	$sqlstr .= "`ri` varchar(20) NOT NULL DEFAULT '',";
	$sqlstr .= "`san` varchar(20) NOT NULL DEFAULT '',";
	$sqlstr .= "`areano` varchar(10) NOT NULL DEFAULT '',";
	$sqlstr .= "`upmyeondongserial` varchar(10) NOT NULL DEFAULT '',";
	$sqlstr .= "`areasuno` varchar(10) NOT NULL DEFAULT '',";
    $sqlstr .= "KEY `sido` (`sido`),";
    $sqlstr .= "KEY `sigungu` (`sigungu`),";
    $sqlstr .= "KEY `upmyeondong` (`upmyeondong`)";
  
	$sqlstr .= ") DEFAULT CHARSET=utf8";
	$dbcon->_query($sqlstr);
}




$sqlstr= "CREATE TABLE IF NOT EXISTS `wizImg` (";##기타 이미지
$sqlstr .= "`uid` int(11) NOT NULL auto_increment,";
$sqlstr .= "`pid` int(11) NOT NULL default '0',";
$sqlstr .= "`orderid` int(5) NOT NULL default '0',";
$sqlstr .= "`filename` varchar(255) NOT NULL,";
$sqlstr .= "`imgname` varchar(50) NOT NULL default '',";
$sqlstr .= "`tbname` varchar(50) NOT NULL default '',";
$sqlstr .= "PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

/* inquire table생성 ********************************************************************************************/
$sqlstr= "CREATE TABLE IF NOT EXISTS `".$WIZTABLE["INQUIRE"]."` (";
$sqlstr .= "`uid` int(6) not null auto_increment,";
$sqlstr .= "`iid` varchar(10) not null default '',";
$sqlstr .= "`userid` varchar(30) not null default '',";
$sqlstr .= "`compname` varchar(30) not null default '',";
$sqlstr .= "`name` varchar(30) not null default '',";
$sqlstr .= "`juminno` varchar(15) not null default '',";
$sqlstr .= "`tel` varchar(30) not null default '',";
$sqlstr .= "`hand` varchar(20) not null default '',";
$sqlstr .= "`fax` varchar(30) not null default '',";
$sqlstr .= "`email` varchar(50) not null default '',";
$sqlstr .= "`url` varchar(100) not null default '',";
$sqlstr .= "`zip` varchar(7) not null default '',";
$sqlstr .= "`address1` varchar(50) not null default '',";
$sqlstr .= "`address2` varchar(30) not null default '',";
$sqlstr .= "`subject` varchar(200) not null default '',";
$sqlstr .= "`contents` text,";
$sqlstr .= "`contents1` text,";
$sqlstr .= "`contents2` text,";
$sqlstr .= "`option1` varchar(30) not null default '',";
$sqlstr .= "`option2` varchar(30) not null default '',";
$sqlstr .= "`option3` varchar(50) not null default '',";
$sqlstr .= "`attached` varchar(255) not null default '',";
$sqlstr .= "`wdate` int(10) not null default '0',";
$sqlstr .= "primary key  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);


$result = $dbcon->is_table( $WIZTABLE["MESSAGE"] );
if ( !$result) {
	$sqlstr= "CREATE TABLE `".$WIZTABLE["MESSAGE"]."` (";
	$sqlstr .= "`uid` int(10) NOT NULL auto_increment,";
	$sqlstr .= "`flag` varchar(10) NOT NULL default '',";
	$sqlstr .= "`delivery_status` varchar(10) NOT NULL default '',";
	$sqlstr .= "`message` text NOT NULL,";
	$sqlstr .= "`subject` varchar(200) NOT NULL default '',";
	$sqlstr .= "`skin` varchar(20) NOT NULL default '',";
	$sqlstr .= "`enable` int(1) NOT NULL default '0',";
	$sqlstr .= "PRIMARY KEY  (`uid`)";
	$sqlstr .= ") DEFAULT CHARSET=utf8";
	$dbcon->_query($sqlstr);
	
	## 메일용
	$sqlstr= "INSERT IGNORE INTO `".$WIZTABLE["MESSAGE"]."` VALUES (1, 'mail', '10', '', '', 'sdu', 0)";
	$dbcon->_query($sqlstr);
	$sqlstr= "INSERT IGNORE INTO `".$WIZTABLE["MESSAGE"]."` VALUES (2, 'mail', '20', '현재 입금대기중입니다.<br /><br />\r\n주문번호 : {주문번호}<br /><br />\r\n\r\ncopyright ⓒ Shop-Wiz All rights reserved.', '주문이 정상적으로 되었습니다.', 'sdu', 0)";
	$dbcon->_query($sqlstr);
	$sqlstr= "INSERT IGNORE INTO `".$WIZTABLE["MESSAGE"]."` VALUES (3, 'mail', '30', '입금확인이 되었습니다.<br /><br />\r\n주문번호 : {주문번호}<br /><br />\r\n\r\ncopyright ⓒ Shop-Wiz All rights reserved.', '입금확인이 되었습니다.', 'sdu', 0)";
	$dbcon->_query($sqlstr);
	$sqlstr= "INSERT IGNORE INTO `".$WIZTABLE["MESSAGE"]."` VALUES (4, 'mail', '40', '상품 배송중입니다.<br /><br />\r\n주문번호 : {주문번호}<br />\r\n송장번호 : {송장번호}<br /><br />\r\ncopyright ⓒ  Shop-Wiz All rights reserved.', '상품 배송중입니다.', 'sdu', 0)";
	$dbcon->_query($sqlstr);
	$sqlstr= "INSERT IGNORE INTO `".$WIZTABLE["MESSAGE"]."` VALUES (5, 'mail', '50', '주문하신 상품의 배송이 완료되었습니다.<br /><br />\r\n주문번호 : {주문번호}<br />\r\n송장번호 : {송장번호}<br /><br />\r\ncopyright ⓒ Shop-Wiz All rights reserved.\r\n', '배송이 완료되었습니다.', 'sdu', 0)";
	$dbcon->_query($sqlstr);
	$sqlstr= "INSERT IGNORE INTO `".$WIZTABLE["MESSAGE"]."` VALUES (6, 'mail', '60', '', '', 'sdu', 0)";
	$dbcon->_query($sqlstr);
	$sqlstr= "INSERT IGNORE INTO `".$WIZTABLE["MESSAGE"]."` VALUES (7, 'mail', '70', '', '', 'sdu', 0)";
	$dbcon->_query($sqlstr);

	##메시지용

	$sqlstr= "INSERT IGNORE INTO `".$WIZTABLE["MESSAGE"]."` VALUES (8, 'sms', '10', '', '', '', 0)";
	$dbcon->_query($sqlstr);
	$sqlstr= "INSERT IGNORE INTO `".$WIZTABLE["MESSAGE"]."` VALUES (9, 'sms', '20', '주문이 접수되었습니다.입금을 해주시기 바랍니다.', '', '', 0)";
	$dbcon->_query($sqlstr);
	$sqlstr= "INSERT IGNORE INTO `".$WIZTABLE["MESSAGE"]."` VALUES (10, 'sms', '30', '입금이 확인되었습니다.', '', '', 0)";
	$dbcon->_query($sqlstr);
	$sqlstr= "INSERT IGNORE INTO `".$WIZTABLE["MESSAGE"]."` VALUES (11, 'sms', '40', '배송준비중입니다.', '', '', 0)";
	$dbcon->_query($sqlstr);
	$sqlstr= "INSERT IGNORE INTO `".$WIZTABLE["MESSAGE"]."` VALUES (12, 'sms', '50', '배송이 완료되었습니다.', '', '', 0)";
	$dbcon->_query($sqlstr);
	$sqlstr= "INSERT IGNORE INTO `".$WIZTABLE["MESSAGE"]."` VALUES (13, 'sms', '60', '', '', '', 0)";
	$dbcon->_query($sqlstr);
	$sqlstr= "INSERT IGNORE INTO `".$WIZTABLE["MESSAGE"]."` VALUES (14, 'sms', '70', '', '', '', 0)";
	$dbcon->_query($sqlstr);
}

$sqlstr= "CREATE TABLE IF NOT EXISTS `".$WIZTABLE["POPUP"]."` (";
$sqlstr .= "`uid` int(6) NOT NULL auto_increment,";
$sqlstr .= "`pskinname` varchar(50) NOT NULL default '',";
$sqlstr .= "`pwidth` int(5) NOT NULL default '0',";
$sqlstr .= "`pheight` int(5) NOT NULL default '0',";
$sqlstr .= "`ptop` int(5) NOT NULL default '0',";
$sqlstr .= "`pleft` int(5) NOT NULL default '0',";
$sqlstr .= "`psubject` varchar(250) NOT NULL default '',";
$sqlstr .= "`pcontents` text NOT NULL,";
$sqlstr .= "`pattached` varchar(100) NOT NULL default '',";
$sqlstr .= "`imgposition` varchar(20) NOT NULL default '',";
$sqlstr .= "`popupenable` int(2) NOT NULL default '0',";
$sqlstr .= "`options` varchar(20) NOT NULL default '',";
$sqlstr .= "`click_url` varchar(250) NOT NULL default '',";
$sqlstr .= "PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

## 베너관련 테이블
$result = $dbcon->is_table( "wizbanner" );
if ( !$result) {
	$sqlstr= "CREATE TABLE IF NOT EXISTS `wizbanner` (";
	$sqlstr .= "`uid` int(11) NOT NULL auto_increment,";
	$sqlstr .= "`flag1` varchar(10) NOT NULL default '',";//config/common_array.php 의 $banner_cat 참조
	$sqlstr .= "`ordernum` int(5) NOT NULL default '0',";//정렬순서
	$sqlstr .= "`subject` varchar(255) default NULL,";//베너제목
	$sqlstr .= "`url` varchar(100) default NULL,";//url
	$sqlstr .= "`target` varchar(20) NOT NULL default 'root',";//클릭시 새창 or 현재..
	$sqlstr .= "`attached` varchar(100) default NULL,";
	$sqlstr .= "`showflag` int(1) NOT NULL,";//1: 디스플레이, 0:숨김
	$sqlstr .= "`cnt` int(11) NOT NULL default '0',";
	$sqlstr .= "`wdate` int(11) NOT NULL default '0',";
	$sqlstr .= "PRIMARY KEY  (`uid`)";
	$sqlstr .= ") DEFAULT CHARSET=utf8";
	$dbcon->_query($sqlstr);

	$sqlstr= "CREATE TABLE IF NOT EXISTS `wizbanner_log` (";
	$sqlstr .= "`pid` int(11) NOT NULL default '0',";//wizbanner.uid
	$sqlstr .= "`referer` varchar(50) default NULL,";
	$sqlstr .= "`wdate` int(11) NOT NULL default '0'";
	$sqlstr .= ") DEFAULT CHARSET=utf8";
	$dbcon->_query($sqlstr);

	$path = "../../config/banner";
	$common->mkfolder($path);

	$sqlstr = "INSERT IGNORE INTO `wizbanner` VALUES (1, 1, 1, '','/', '_self', 'dG9wbG9nby5naWY=', '1',0, 1236666446);";
	$dbcon->_query($sqlstr);
	$common->cpfile("dG9wbG9nby5naWY=", "../basicconfig/init_banner", "../../config/banner");

	$sqlstr = "INSERT IGNORE INTO `wizbanner` VALUES (2, 2, 1, '','', '_self', 'bG9nb19ib3R0b20uZ2lm','1', 0, 1236666577);";
	$dbcon->_query($sqlstr);
	$common->cpfile("bG9nb19ib3R0b20uZ2lm", "../basicconfig/init_banner", "../../config/banner");

	$sqlstr = "INSERT IGNORE INTO `wizbanner` VALUES (3, 5, 1, '','', '_self', 'bGVmZmJhbm5lcjEuZ2lm','1', 0, 1236669778);";
	$dbcon->_query($sqlstr);
	$common->cpfile("bGVmZmJhbm5lcjEuZ2lm", "../basicconfig/init_banner", "../../config/banner");

	$sqlstr = "INSERT IGNORE INTO `wizbanner` VALUES (4, 5, 2, '','', '_self', 'bGVmZmJhbm5lcjIuZ2lm','1', 0, 1236669789);";
	$dbcon->_query($sqlstr);
	$common->cpfile("bGVmZmJhbm5lcjIuZ2lm", "../basicconfig/init_banner", "../../config/banner");

	$sqlstr = "INSERT IGNORE INTO `wizbanner` VALUES (5, 5, 3, '','', '_self', 'bGVmZmJhbm5lcjMuZ2lm','1', 0, 1236669799);";
	$dbcon->_query($sqlstr);
	$common->cpfile("bGVmZmJhbm5lcjMuZ2lm", "../basicconfig/init_banner", "../../config/banner");

	$sqlstr = "INSERT IGNORE INTO `wizbanner` VALUES (6, 5, 4, '','', '_self', 'bGVmZmJhbm5lcjQuZ2lm','1', 0, 1236669990);";
	$dbcon->_query($sqlstr);
	$common->cpfile("bGVmZmJhbm5lcjQuZ2lm", "../basicconfig/init_banner", "../../config/banner");

	$sqlstr = "INSERT IGNORE INTO `wizbanner` VALUES (7, 5, 5, '','http://www.shop-wiz.com/html/pg.php', '_blank', 'bGVmZmJhbm5lcjUuZ2lm','1', 0, 1236670038);";
	$dbcon->_query($sqlstr);
	$common->cpfile("bGVmZmJhbm5lcjUuZ2lm", "../basicconfig/init_banner", "../../config/banner");

	$sqlstr = "INSERT IGNORE INTO `wizbanner` VALUES (8, 5, 6,'', '', '_self', 'bGVmZmJhbm5lcl9ibGFuay5naWY=', '1',0, 1236670065);";
	$dbcon->_query($sqlstr);
	$common->cpfile("bGVmZmJhbm5lcl9ibGFuay5naWY=", "../basicconfig/init_banner", "../../config/banner");

	$sqlstr = "INSERT IGNORE INTO `wizbanner` VALUES (9, 5, 7, '','', '_self', 'MDI1MTE0NzAwX2xlZmZiYW5uZXJfYmxhbmsuZ2lm', '1',0, 1236670073);";
	$dbcon->_query($sqlstr);
	$common->cpfile("MDI1MTE0NzAwX2xlZmZiYW5uZXJfYmxhbmsuZ2lm", "../basicconfig/init_banner", "../../config/banner");

	$sqlstr = "INSERT IGNORE INTO `wizbanner` VALUES (10, 3, 1, '','', '_self', 'bWFpbmltZy5qcGc=', '1',0, 1236670716);";
	$dbcon->_query($sqlstr);
	$common->cpfile("bWFpbmltZy5qcGc=", "../basicconfig/init_banner", "../../config/banner");

	$sqlstr = "INSERT IGNORE INTO `wizbanner` VALUES (11, 4, 1, '','', '_self', 'bWFpbmJhbm5lcjEuZ2lm', '1',0, 1236673146);";
	$dbcon->_query($sqlstr);
	$common->cpfile("bWFpbmJhbm5lcjEuZ2lm", "../basicconfig/init_banner", "../../config/banner");

	$sqlstr = "INSERT IGNORE INTO `wizbanner` VALUES (12, 4, 2, '','', '_self', 'bWFpbmJhbm5lcjIuZ2lm','1', 0, 1236673155);";
	$dbcon->_query($sqlstr);
	$common->cpfile("bWFpbmJhbm5lcjIuZ2lm", "../basicconfig/init_banner", "../../config/banner");

	$sqlstr = "INSERT IGNORE INTO `wizbanner` VALUES (13, 4, 3, '','', '_self', 'bWFpbmJhbm5lcjMuZ2lm', '1',0, 1236673163);";
	$dbcon->_query($sqlstr);
	$common->cpfile("bWFpbmJhbm5lcjMuZ2lm", "../basicconfig/init_banner", "../../config/banner");
}


## 쿠폰 테이블
$sqlstr	= "CREATE TABLE IF NOT EXISTS `wizCoupon` (";
$sqlstr .= "`uid` int(11) NOT NULL auto_increment,";
$sqlstr .= "`cname` varchar(50) NOT NULL default '',";//쿠폰명
$sqlstr .= "`cdesc` varchar(50) NOT NULL default '',";//쿠폰설명
$sqlstr .= "`cpubtype` int(2) NOT NULL default '0',";//쿠폰발급방식(운영자발급:1, 회원직접다운로드:2, 가입시자동발급:3, 구매후자동발급:4
$sqlstr .= "`cpubdowncnt` int(3) NOT NULL default '0',";//cpubtype이 2일경우, 다운횟수
$sqlstr .= "`cpubapplyall` int(1) NOT NULL default '0',";//cpubtype이 2일경우, 쿠폰이 적용된 상품을 동시에 다수 구매시 적용
$sqlstr .= "`cpubapplycontinue` int(1) NOT NULL default '0',";//cpubtype이 2일경우, 추후에도 동일 제품 구매시 쿠폰 사용가능
$sqlstr .= "`edncnt` int(3) NOT NULL default '0',";//cpubapplycontinue 선택시 다운카운트
$sqlstr .= "`ctype` int(2) NOT NULL default '0',";//쿠폰 타입: 할인쿠폰 : 1, 적립쿠폰 : 2
$sqlstr .= "`csaleprice` int(7) NOT NULL default '0',";//쿠폰할인금액(
$sqlstr .= "`csaletype` varchar(5) NOT NULL default '',";//구입상품에 대한 할인금액 : 1, 할인퍼센트 : 2
$sqlstr .= "`capplytype` int(1) NOT NULL default '0',";//쿠폰적용대한 : 1:전체상품, 2, 카테고리 전체, 3, 상품 : 2, 3일경우 별도 테이블 생성 
$sqlstr .= "`capplycategory` int(6) NOT NULL default '0',";//추후삭제
$sqlstr .= "`capplyproduct` int(11) NOT NULL default '0',";//추후삭제
$sqlstr .= "`cimg` int(2) NOT NULL default '0',";//쿠폰이미지
$sqlstr .= "`ctermtype` int(1) NOT NULL default '0',";//쿠폰기간 : 1: 시작일종료일 입력, 2:기간설정
$sqlstr .= "`cterm` int(5) NOT NULL default '0',";//기간설정
$sqlstr .= "`ctermf` int(11) NOT NULL default '0',";//사용시작일
$sqlstr .= "`cterme` int(11) NOT NULL default '0',";//사용종료일
$sqlstr .= "`crestric` int(7) NOT NULL default '0',";//쿠폰사용제한(특정금액이상만 쿠폰 적용가능)
$sqlstr .= "`wdate` int(11) NOT NULL default '0',";//쿠폰생성일
$sqlstr .= " PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

## 쿠폰 테이블
$sqlstr	= "CREATE TABLE IF NOT EXISTS `wizUsercoupon` (";
$sqlstr .= "`uid` int(11) NOT NULL auto_increment,";
$sqlstr .= "`userid` varchar(20) NOT NULL default '',";//쿠폰획득아이디
$sqlstr .= "`couponid` int(11) NOT NULL default '0',";//쿠폰번호 wizCoupon.uid
$sqlstr .= "`useflag` int(1) NOT NULL default '0',";//사용여부 : 0:미사용, 1:사용
$sqlstr .= "`gdate` int(11) NOT NULL default '0',";//쿠폰 취득일
$sqlstr .= "`udate` int(11) NOT NULL default '0',";//쿠폰 사용일
$sqlstr .= "PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

## 쿠폰 테이블
$sqlstr	= "CREATE TABLE IF NOT EXISTS `wizCouponapply` (";
$sqlstr .= "`uid` int(11) NOT NULL auto_increment,";
$sqlstr .= "`couponid` int(11) NOT NULL default '0',";//쿠폼아이디 wizCoupon.uid
$sqlstr .= "`category` int(6) NOT NULL default '0',";//적용카테고리 wizCategory.cat_no
$sqlstr .= "`pid` int(11) NOT NULL default '0',";//적용제품 wizMall.UID
$sqlstr .= "PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

## 제품 검색어 테이블
$sqlstr	= "CREATE TABLE IF NOT EXISTS `wizsearchKeyword` (";
$sqlstr .= "`uid` int(11) NOT NULL auto_increment,";
$sqlstr .= "`type` enum('s','k') NOT NULL default 's',";//s: 검색결과 저장, k:관리자에서 관리용
$sqlstr .= "`keyword` varchar(50) NOT NULL default '0',";
$sqlstr .= "`showflag` int(1) NOT NULL default '1',";//출력여부
$sqlstr .= "`wdate` int(11) NOT NULL default '0',";
$sqlstr .= "PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

## mall product option 테이블
$sqlstr	= "CREATE TABLE IF NOT EXISTS `wizMalloption` (";
$sqlstr .= "`uid` int(11) NOT NULL auto_increment,";
$sqlstr .= "`ouid` int(11) NOT NULL default '0',";//wizMalloptioncfg.uid
$sqlstr .= "`oname` varchar(30) NOT NULL default '',";//옵션명
$sqlstr .= "`oprice` int(10) NOT NULL default '0',";//옵션별 가격
$sqlstr .= "`oqty` int(5) NOT NULL default '0',";//재고갯수
$sqlstr .= "PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

## mall product option 테이블
$sqlstr	= "CREATE TABLE IF NOT EXISTS `wizMalloptioncfg` (";
$sqlstr .= "`uid` int(11) NOT NULL auto_increment,";
$sqlstr .= "`opid` int(11) NOT NULL default '0',";//상품아이디 wizMall.UID
$sqlstr .= "`oname` varchar(30) NOT NULL default '',";//옵션명
$sqlstr .= "`oorder` int(2) NOT NULL default '1',";//옵션순서
$sqlstr .= "`oflag` int(11) NOT NULL default '0',";//옵션정보 : 0:기본-옵션만 디스플레이, 1: 옵션가격추가, 2:상품자체가격변동
$sqlstr .= "PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

## 택배업체 테이블
$result = $dbcon->is_table( "wizdeliver" );
if ( !$result) {
	$sqlstr	= "CREATE TABLE IF NOT EXISTS  `wizdeliver` (";
	$sqlstr .= "`uid` int(10) unsigned NOT NULL auto_increment,";
	$sqlstr .= "`d_name` varchar(45) default NULL,";//택배업체명
	$sqlstr .= "`d_code` varchar(255) NOT NULL default '',";//배송추적조회 code
	$sqlstr .= "`d_url` varchar(255) default NULL,";//택배사 url
	$sqlstr .= "`d_inquire_url` varchar(255) default NULL,";//배송 추적 url
	$sqlstr .= "`d_method` varchar(10) default NULL,";//전송방식(일부 업체에서는 post사용)
	$sqlstr .= "KEY `uid` (`uid`)";
	$sqlstr .= ") DEFAULT CHARSET=utf8";
	$dbcon->_query($sqlstr);

	$sqlstr	= "INSERT IGNORE INTO `wizdeliver` VALUES (1, 'cj택배', 'slipno', 'http://www.cjgls.co.kr', 'http://nexs.cjgls.com/web/service02_01.jsp','GET')";
	$dbcon->_query($sqlstr);
	$sqlstr	= "INSERT IGNORE INTO `wizdeliver` VALUES (2, '한진택배', 'wbl_num', 'http://www.hanjinexpress.hanjin.net', 'http://www.hanjin.co.kr/Delivery_html/inquiry/result_waybill.jsp','GET')";
	$dbcon->_query($sqlstr);
	$sqlstr	= "INSERT IGNORE INTO `wizdeliver` VALUES (3, '로젠택배', 'slipno', 'http://www.ilogen.com', 'http://d2d.ilogen.com/d2d/delivery/invoice_tracesearch_quick.jsp','GET')";
	$dbcon->_query($sqlstr);
}

## 영수증 발급 요청 테이블
$sqlstr	= "CREATE TABLE IF NOT EXISTS `wizBillcheck` (";
$sqlstr .= "`uid` int(10) NOT NULL auto_increment,";
$sqlstr .= "`mid` varchar(30) NOT NULL default '',";//사용자아이디(기본 정보 불러올경우 사용)
$sqlstr .= "`oid` varchar(13) NOT NULL default '',";//주문번호
$sqlstr .= "`ptype` int(2) NOT NULL default '0',";//1:세금계산서 신청, 2:현금영수증신청
$sqlstr .= "`cnum` varchar(12) NOT NULL default '',";//사업장번호
$sqlstr .= "`cname` varchar(30) NOT NULL default '',";//사업장명/개인명
$sqlstr .= "`ceoname` varchar(30) NOT NULL default '',";//대표자명
$sqlstr .= "`cuptae` varchar(30) NOT NULL default '',";//업태명
$sqlstr .= "`cupjong` varchar(30) NOT NULL default '',";//업종명
$sqlstr .= "`cachreceipt` varchar(30) NOT NULL default '',";//현금영수증번호
$sqlstr .= "`caddress1` varchar(100) NOT NULL default '',";//사업장주소
$sqlstr .= "`presult` int(2) NOT NULL default '1',";//발행결과 : 1: 신청, 2:발행완료 3: 취소(부적격으로 인한 관리자 취소)
$sqlstr .= "`rdate` int(11) NOT NULL default '0',";//요청일시
$sqlstr .= "`pdate` int(11) NOT NULL default '0',";//발행일시
$sqlstr .= "PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

## 입금계좌테이블
$sqlstr	= "CREATE TABLE IF NOT EXISTS  `wizaccount` (";
$sqlstr .= "`uid` int(11) NOT NULL auto_increment,";
$sqlstr .= "`bankname` varchar(20) default NULL,";
$sqlstr .= "`account_no` varchar(20) default NULL,";
$sqlstr .= "`account_owner` varchar(50) default NULL,";
$sqlstr .= "PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);

## 상품옵션 테이블
$sqlstr	= "CREATE TABLE IF NOT EXISTS `wizpdoption` (";
$sqlstr .= "`uid` int(11) NOT NULL auto_increment,";
$sqlstr .= "`op_name` varchar(20) default NULL,";
$sqlstr .= "`op_main_order` tinyint(4) default NULL,";
$sqlstr .= "`op_main_image` varchar(100) default NULL,";
$sqlstr .= "`op_icon_image` varchar(100) default NULL,";
$sqlstr .= "`op_main_cnt` tinyint(4) default NULL,";
$sqlstr .= "`op_display` set('Y','N') NOT NULL default 'N',";
$sqlstr .= "PRIMARY KEY  (`uid`)";
$sqlstr .= ") DEFAULT CHARSET=utf8";
$dbcon->_query($sqlstr);


$sqlstr	= "INSERT IGNORE INTO `wizpdoption` (`uid`, `op_name`, `op_main_order`, `op_main_image`, `op_icon_image`, `op_main_cnt`, `op_display`) VALUES";
$sqlstr .= "(1, '추천상품', 0, '', 'aWNvbl9yZWNvbS5naWY,', 0, 'N'),";
$sqlstr .= "(2, '신규상품', 2, 'dGl0bGVfbmV3LmdpZg==', 'MDQ4MTE5NjAwX2ljb25fbmV3LmdpZg,,', 15, 'Y'),";
$sqlstr .= "(3, '인기상품', 0, '', 'MDIxMTU3OTAwX2ljb25faG90LmdpZg,,', 0, 'N'),";
$sqlstr .= "(4, '히트상품', 1, 'MDU3ODY4MzAwX3RpdGxlX2hpdC5naWY=', 'MDgwNzMzNDAwX2ljb25faGl0LmdpZg,,', 5, 'Y'),";
$sqlstr .= "(5, '베스트상품', 0, '', 'MDU2ODQ4MDAwX2ljb25fYmVzdC5naWY,', 0, 'N'),";
$sqlstr .= "(6, '스페셜상품', 0, '', 'MDI2MjA3NTAwX2ljb25fc3BlY2lhbC5naWY,', 0, 'N');";
$dbcon->_query($sqlstr);


/* 아래는 각종 디렉토리 생성입니다. */

$path = "../../config/session";//session 관련 로그인 정보 저장
$common->mkfolder($path);

$path = "../../config/wizmember_tmp";//member 관련 로그인 정보 저장
$common->mkfolder($path);

$path = "../../config/wizmember_tmp/wiz_wish";//위시리스트관련 정보저장
$common->mkfolder($path);

$path = "../../config/wizmember_tmp/mall_buyers";//구매관련 정보저장
$common->mkfolder($path);

$path = "../../config/wizmember_tmp/goods_compare";//상품비교관련 정보저장
$common->mkfolder($path);

$path = "../../config/wizmember_tmp/login_user";//로그인 사용자 정보
$common->mkfolder($path);

$path = "../../config/wizmember_tmp/user_image";//회원가입시 이미지 첨부욀 경우 관련 정보저장
$common->mkfolder($path);

$path = "../../config/wizmember_tmp/view_product";// 금일본 상품 저장
$common->mkfolder($path);

$path = "../../config/tmp_upload";//각종 임시 업로드 파일저장(메일발송등) 후 삭제
$common->mkfolder($path);

$path = "../../config/desc_img";
$common->mkfolder($path);

$path = "../../config/banner";//베너관련 이미지 저장
$common->mkfolder($path);

$path = "../../config/wizpopup";//팝업관련 이미지 저장
$common->mkfolder($path);

$path = "../../config/pdoption";//상품옵션 이미지
$common->mkfolder($path);
$common->cpfile("dGl0bGVfbmV3LmdpZg==", "../basicconfig/init_pdoption", "../../config/pdoption");
$common->cpfile("MDU3ODY4MzAwX3RpdGxlX2hpdC5naWY=", "../basicconfig/init_pdoption", "../../config/pdoption");

$common->cpfile("aWNvbl9yZWNvbS5naWY,", "../basicconfig/init_pdoption", "../../config/pdoption");//추천
$common->cpfile("MDQ4MTE5NjAwX2ljb25fbmV3LmdpZg,,", "../basicconfig/init_pdoption", "../../config/pdoption");//신규
$common->cpfile("MDIxMTU3OTAwX2ljb25faG90LmdpZg,,", "../basicconfig/init_pdoption", "../../config/pdoption");//인기
$common->cpfile("MDgwNzMzNDAwX2ljb25faGl0LmdpZg,,", "../basicconfig/init_pdoption", "../../config/pdoption");//히트
$common->cpfile("MDU2ODQ4MDAwX2ljb25fYmVzdC5naWY,", "../basicconfig/init_pdoption", "../../config/pdoption");//베스트
$common->cpfile("MDI2MjA3NTAwX2ljb25fc3BlY2lhbC5naWY,", "../basicconfig/init_pdoption", "../../config/pdoption");//스페셜

$path = "../../config/uploadfolder";
$common->mkfolder($path);

$path = "../../config/uploadfolder/productimg";//상품 이미지
$common->mkfolder($path);

$path = "../../config/uploadfolder/categoryimg";//카테고리 이미지
$common->mkfolder($path);

$path = "../../config/log";//각종 로그 생성
$common->mkfolder($path);

$path = "../../config/uploadfolder/editor";//상품에디터용 이미지 폴더
$common->mkfolder($path);

$path = "../../config/uploadfolder/etc";//기타(문의등 사용자 프로그램) 각종 첨부화일
$common->mkfolder($path);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>">
<script language="javascript" type="text/javascript">
        window.alert('\n\n<? echo $admin ; ?>님 Shop-wiz Data Base 및 디렉토리 설치가 완료되었습니다.\n\n상세 정보페이지 설정으로 이동합니다.. \n\n');
        window.top.location.replace('./install4.php?PASS=<?=$PASS?>&query=setcookie');
</script>
</head>
</html>