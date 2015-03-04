<?
// 사용자 IP 얻어옴
$user_ip=$REMOTE_ADDR;
$referer=$HTTP_REFERER;
if(!$referer) $referer="Typing or Bookmark Moving On This Site";

// 오늘의 날자 구함
$today		= mktime(0,0,0,date("m"),date("d"),date("Y"));
$yesterday	= mktime(0,0,0,date("m"),date("d"),date("Y"))-60*60*24;
$tomorrow	= mktime(0,0,-1,date("m"),date("d")+1,date("Y"));
$time		= time();
//------------------- 카운터 테이블에 데이타 입력 부분 -------------------------------------------------------
//$u_agent = $_SERVER['HTTP_USER_AGENT']; 브라우저 판별을 위해서는 이부분을 고도화 시킨다.
// wizcounter_main에서 오늘날짜 행이 없으면 추가.
$sqlstr = "select count(*) from wizcounter_main where date = '$today'";
$todaycount=$dbcon->get_one($sqlstr);
if(!$todaycount){
	$dbcon->_query("insert into wizcounter_main (date, unique_counter, pageview) values ('$today', '0', '0')");
}

// 지금 아이피로 접속한 사람이 오늘 처음 온 사람인지 검사
$sqlstr = "select count(*) from wizcounter_referer where date between $today and $tomorrow and ip='$user_ip'";
$unique_ip = $dbcon->get_one($sqlstr);

// 오늘 처음왔을때
if(!$unique_ip){	// 전체랑 오늘 카운터 올림
	$dbcon->_query("update wizcounter_main set unique_counter=unique_counter+1, pageview=pageview+1 where no=1 or date='$today'");  

}else{// 페이지뷰 올림
	$dbcon->_query("update wizcounter_main set pageview=pageview+1 where no=1 or date='$today'");
}

	$dbcon->_query("insert into wizcounter_referer (date, referer, ip) values ('$time','$referer','$user_ip')");
?>