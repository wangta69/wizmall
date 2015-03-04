<script>
<!--
function wizPoll()
        {
			window.open('', 'wizPoll_<?=$PID?>','width=<?=$popwidth?>,height=<?=$popheight?>,marginwidth=0,marginheight=0,resizable=no,scrollbars=auto'); 
        }
//-->		
</script>
<table border="0" cellspacing="0" cellpadding="0" width="160">
<?

if(!ereg("([^[:space:]]+)",$PID) || !$PID) {
	echo "<script>window.alert('잘못된 경로로 부터의 접금입니다.');history.go(-1);</script>";
}
else {
	$total = $dbcon->get_one("select count(*) from wizpoll where PID='$PID'");
	if($total == 0) {
		echo"생성되지 않은 코드입니다.";
		exit;
	}
}

// 투표 기간이 종료 되었을때
$Sqlqry = $dbcon->_query("SELECT * FROM wizpoll WHERE PID='$PID'");
$List = $dbcon->_fetch_array($Sqlqry);
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
## 투표 하기
if($mode == "" && !${"wizPollCookie".$PID}) {
?>
		<form action='./util/wizpoll/DEFAULT/result.php' method='post' onsubmit ='javascript:wizPoll()' target='wizPoll_<?=$PID?>'>
		<input type='hidden' name='PID' value='<?=$PID?>'>
		<input type='hidden' name='mode' value='poll'>
                                      <tr> 
                                        <td><img src="./util/wizpoll/DEFAULT/images/left_menu03.gif" width="160" height="26"></td>
                                      </tr>
                                      <tr> 
                                        <td><table width="150" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td colspan="2"><span style="font-size:11px; color:#095F68;"><?=$List[Subject]?></span></td>
        </tr>
        <tr> 
          <td height="5" colspan="2"></td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td><table width="100%" border='0' cellpadding='0' cellspacing="0" cellspacign='0'>
<?
	// 항목 출력
	for($i=0; $i<sizeof($Contents)-1; $i++) {
		$no = $i+1;
        $Contents[$i] = str_replace("58(3A)","|",$Contents[$i]);

		// 제일 처음 항목에 기본 체크 하기
		if($no == 1) $checked = "checked";
		else $checked = "";

?>
              <tr> 
                <td><input type='radio' name='num' value='<?=$no?>' <?=$checked?>> 
                  <?=$Contents[$i]?>
                </td>
              </tr>
<?
	}/* for 문 닫음 */

?>
            </table>
            </td>
        </tr>
      </table></td>
                                      </tr>
                                      <tr>
                                        <td height="30"> 
                                          <div align="center"><input type="image" src="./util/wizpoll/DEFAULT/images/left_ic02.gif" width="44" height="16">
          &nbsp;&nbsp;&nbsp;<img src="./util/wizpoll/DEFAULT/images/left_ic03.gif" onclick="javascript:window.open('./util/wizpoll/DEFAULT/result.php?PID=<?=$PID?>&mode=view','WizPOLLViewWindow_<?=$PID?>','width=<?=$popwidth?>,height=<?=$popheight?>,srollbar=auto,toolbar=no,statusbar=no');" style="cursor:pointer";></div></td>
                                      </tr></form>
                                    
<?
}
?>
</table>								