<?
/* 쿠키저장방식 
이부분을 관리자 모드와 연동하여 ip / 하루 혹은 다른 방식으로 쿠키를 제어하게 한다. 
*/
$CookieMethod = "aday";
include("../../../config/db_info.php");
include "../../../lib/class.database.php";

$dbcon	= new database($cfg["sql"]);
include_once('./function.php');

/* 투표저장하기 */
$sqlstr = "SELECT * FROM wizpoll WHERE UID='$uid'";
$Sqlqry = $dbcon->_query($sqlstr);

$List = $dbcon->_fetch_array();
$Contents = explode("|",$List[Contents]);
$Vote = explode("|",$List[Vote]);

	if($List[ToDay] < time()) {
	$mode = "view"; // 기간 종료시 투표 결과 보이기
	$day_end = "y"; // 기간 종료시 메시지 보이기 유.무
}
    // 총 투표수
	for($i=0; $i<count($Contents)-1; $i++) {
		$TotalVote += $Vote[$i];
	}

	// 등록일 : 종료일 : 종료일 - 등록일 = 일수(기간)
	$FromDay = date("Y.m.d",$List[FromDay]);
	$ToDay = date("Y.m.d",$List[ToDay]);
	$day = ($List[ToDay]-$List[FromDay])/24/60/60;
	//echo "sqlstr = $sqlstr <br>";
if($query == "save") {
	if(${"wizPollCookie".$uid}){
	echo "<script>window.alert('이미 투표하셨습니다.'); location.href('../wizpoll.php')</script>";
	exit;	
	}
	
	if(!$num || CheckInt($num)) {
	WindowAlert("항목을 선택해 주세요.");
	}

    // 총 항목수
	if($num > count($Vote)-1) {
		WindowAlert("잘못된 경로로부터의 접근입니다.");
	}

	// 투표 증가
		unset($vote_ok);
		for($i=0; $i<count($Vote)-1; $i++) {
			if($num-1 == $i) $Vote[$i] += 1;
			$vote_ok .= $Vote[$i]."|";
    }			
		
		$dbcon->_query("UPDATE wizpoll SET Vote='$vote_ok' where UID='$uid'");
		
		// 투표 한사람에게 쿠키 생성(1일)
	if($CookieMethod == "aday")	setcookie("wizPollCookie".$uid,"1",time()+60*60*24);
	
	echo "<script>window.alert('투표해 주셨어 감사합니다.'); location.href('../wizpoll.php')</script>";
	exit;


}
/* 투표저장하기 끝 */
?>