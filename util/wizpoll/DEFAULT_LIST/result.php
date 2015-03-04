<?
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
include "../../../lib/cfg.common.php";
include "../../../config/db_info.php";

include "../../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);

include "./function.php";
?>
<?
if(CheckField($PID)) {
	ErrorMsg("잘못된 경로로 부터의 접금입니다.");
}
else {
	$total = $dbcon->_query("select count(1) from wizpoll where PID='$PID'");
	if($total == 0) {
		echo"생성되지 않은 코드입니다.";
		exit;
	}
}

// 투표 기간이 종료 되었을때
$Sqlqry = $dbcon->_query("SELECT * FROM wizpoll WHERE PID='$PID'");
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
?>

<?
if($mode == "poll" && !${"wizPollCookie".$PID}) {


	if(!$num || CheckInt($num)) {
	WindowAlert("항목을 선택해 주세요.");
	}

    // 총 항목수
	$Vote = explode("|",$List[Vote]);
	if($num > count($Vote)-1) {
		WindowAlert("잘못된 경로로부터의 접근입니다.");
	}

	// 쿠키 체크 -> 투표 증가
    if(!${"wizPollCookie".$PID}) {
		for($i=0; $i<count($Vote)-1; $i++) {
			if($num-1 == $i) $Vote[$i] += 1;
			$vote_ok .= $Vote[$i]."|";
		}
		
		// 항목 투표수 1 증가
		$Result = $dbcon->_query("UPDATE wizpoll SET Vote='$vote_ok' where PID='$PID'");
		
		// 투표 한사람에게 쿠키 생성(1일)
		//setcookie("wizPollCookie".$PID,"1",time()+86400);
	// 결과 보여주기
	LocationReplace("$PHP_SELF?PID=$PID&mode=view&window_open=$window_open&width=$width");
		
		
    }

}

## 투표 결과
else if($mode == "view" || ${"wizPollCookie".$PID}) {
	$Subject = explode("|",$List[Subject]);
	$Vote = explode("|",$List[Vote]);

    // 총 투표수
	for($i=0; $i<count($Subject)-1; $i++) {
		$TotalVote += $Vote[$i];
	}

	// 등록일 : 종료일 : 종료일 - 등록일 = 일수(기간)
	$FromDay = date("Y.m.d",$List[FromDay]);
	$ToDay = date("Y.m.d",$List[ToDay]);
	$day = ($List[ToDay]-$List[FromDay])/24/60/60;
?>
        <title>WizPoll ver1.0 : <?=$List[Subject]?></title>
		<style>
        P, BODY,TD , DIV , CENTER , PRE ,  BLOCKQUOTE , TD , TR , BR , TABLE {FONT-SIZE: 9pt; color: black; font-family :굴림;}

		A:link{color:black;text-decoration:none;}
        A:visited {color:black;text-decoration:none;}
        A:active{color:black;text-decoration:none;}
        A:hover{color:black;text-decoration:underline;}

        </style>
		
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width='100%' border=0 align="center" cellpadding='2' cellspacing='1' bgcolor='#0072A8'>
  <tr>
		<td colspan='3' style='word-break:break-all;' bgcolor='white'>&nbsp;&#149; <?=$List[Subject]?></td>
		</tr>
		<tr>
		<td colspan='3' height='1' bgcolor='white'></td>
		</tr>
<?

    // 항목 : 투표수 출력
	for($i=0; $i<count($Contents)-1; $i++) {

		$no = $i+1;
		// %와 바 길이
		$percent = @intval($Vote[$i]/$TotalVote*100);
		$bar_width = 100;
		$bar_length = @intval($Vote[$i]/$TotalVote*$bar_width)+1;
?>
		<tr>
		
    <td width='100%' colspan='3' style='word-break:break-all;' bgcolor='white'>
      <?=$no?>
      . 
      <?=$Contents[$i]?>
    </td>
		</tr>
		<tr>
		<td align='right' width='100%' bgcolor='#F4FCFF'>
			<table border='0' width='<?=$bar_length?>' height='<?=$bar_height?>' bgcolor='<?=$bar_color?>' cellspacing='0' cellpadding='0'>
			<tr><td></td></tr>
			</table>
		</td>
	    <td bgcolor='#F8FCFC' nowrap>&nbsp;<b><?=$Vote[$i]?></b> 표 <font face=tahoma>: <?=$percent?> %</font>&nbsp;</td>
		</tr>
<?
	}

	// 투표 기간 종료 메시지
    if($day_end == "y") {
?>
		<tr>
		<td colspan='3' align='center'><font color='white'>투표 기간 종료</font></td>
		</tr>
<?
	}

	// 총 투표수 : 투표 기간(등록일~종료일,기간)
?>
		<tr>
		<td colspan='3' bgcolor='white'> 총 <b><font color='blue'><?=$TotalVote?></font></b> 명 참여 </td>
		</tr>
		<tr>
		<td colspan='3' bgcolor='white'><!-- <?=$FromDay?> ~ <?=$ToDay?> [<?=$day?> 일간]<br> → <a href='admin.php?mode=etc' target='_blank'>지난 투표 보기</a> --></td>
		</tr>
	<tr>
		<a href='javascript:window.close();'>
		<td colspan='3' align='center' style='cursor:pointer;'><font color='white'><b> c l o s e </b></font></td>
		</a>
		</tr>
		</table>
<?
}

?>