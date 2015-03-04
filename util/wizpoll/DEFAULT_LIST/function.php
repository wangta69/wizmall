<?
/***********************************************************************************
Wiz제품군 대한 라이센스 입니다. 삭제 및 수정을 하여 임의로 배포되는 것을 금지 합니다.

▶ 개인, 단체, 기관, 회사 등등 모든 사이트에서 사용 가능합니다.
▶ 이 프로그램을 상업적인(판매, 대여) 목적으로 사용할 수 없습니다.
▶ 배포는 SHOP-WIZ 에서만 가능합니다.(다른 사이트에서 배포시에는 허락후 배포 가능합니다.)
▶ 이 프로그램은 수정해서 사용 가능하나 재배포는 될수 없습니다. 
▶ 본 프로그램으로 인한 손해에 대해서는 제작자는 책임을 지지 않습니다.
▶ 원 제작자를 명시 해주시기 바랍니다.

▶ 제 작 자 : 폰돌
▶ 메    일 : master@shop-wiz.com
▶ 홈페이지 : http://www.shop-wiz.com
▶ 배포버전 : wizPoll ver 1.0
**************************************************************************************/


$AdminPass= "test"; // 관리자 패스워드 ( 대소문자 구별 )


//---------- 기본값 [임의로 변수값 줘두 됨 (wizpoll?width=xx)] ---------\\

if(!$bar_width) $bar_width = "100"; // 투표 % 막대 너비
if(!$bar_height) $bar_height = "4"; // 투표 % 막대 높이
if(!$bar_color) $bar_color = "#008080"; // 투표 막대 색

if(!$width) $width = "200"; // 투표 너비

if(!$window_width) $window_width = "220"; // 투표창 너비
if(!$window_height) $window_height = "320"; // 투표창 높이



// 공백 체크
function CheckField($field) {
	if(!ereg("([^[:space:]]+)",$field) || !$field) return true;
}
// 에러메시지
function ErrorMsg($message){
ECHO"<script>window.alert('$message'); history.go(-1);</script>";
exit;
}
function LocationReplace($location){
ECHO"<script>location.replace('$location');</script>";
exit;
}

// 에러메시지
function WindowAlert($message){
ECHO"<script>window.alert('$message'); history.go(-1);</script>";
exit;
}

// 숫자 체크
function CheckInt($field) {
	if(ereg("[^[:digit:]]",$field)) return true;
}

// 페이지 링크
function page_link($url) {
	global $page_num,$page,$total_page,$path;
     $first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
     $last_page = $first_page+($page_num-1);
     if($last_page > $total_page) $last_page = $total_page;
     
	 echo"<font size='1' face='verdana'>[<a href='$PHP_SELF?&page=1'>First</a>]...";
     $prev = $first_page-1;
     if($page > $page_num) echo"[<a href='$PHP_SELF?&page=$prev'>Prev</a>] ";
    
     for($i = $first_page; $i <= $last_page; $i++) {
       if($page == $i) echo"[<b>$i</b>] ";
	   else echo"<a href='$PHP_SELF?&page=$i'>[$i]</a> ";
     }

     $next = $last_page+1;
     if($next <= $total_page) echo"[<a href='$PHP_SELF?&page=$next'>Next</a>]";

	 echo"...[<a href='$PHP_SELF?&page=$total_page'>Last</a>]</font>";
}


// 로그인 체크
function Login_Check() {
	session_start();
	global $AdminPass,$AdminPassSession;
	if(strcmp($wizpollAdmin,$wizpollSession)) {
		ECHO "<script>window.alert('당신은 권한이 없습니다.'); history.go(-1);</script>";
		exit;
	}
}

 // 총 게시물 수 구해오기 검색|일반
function total_search() {
    // 현재 시간
	$today = time();

	// all
	$total[all] =$dbcon->get_one("select count(*) from wizpoll");

	// ing
    $total[ing] = $dbcon->get_one("select count(*) from wizpoll where ToDay > $today");
	  
	// end
	$total[end] = $dbcon->get_one("select count(*) from wizpoll where ToDay < $today");
    return $total;
}

// 글 뽑아오는 쿼리문 전달 검색|일반
function select_query() {
	global $poll,$limit;
	// 현재 시간
	$today = time();
	$query = "select * from wizpoll ";

	// ing
	if($poll == "ing") $query .= "where ToDay > $today ";

	// end
	else if($poll == "end") $query .= "where ToDay < $today ";

    $query .= "order by uid desc $limit";
	return $query;
}

?>