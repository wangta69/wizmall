<?php
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
2004-03-05 : 수정단의 버그(히든 값이 안들어가던) 변경

*/

if ($action == 'poll_write') {
$fp = fopen("../config/wizPoll_info.php", "w");
fwrite($fp,"<?
\$Poll_Skin_Name = \"$Poll_Skin_Name\";
\$Poll_ID = \"$Poll_ID\";
\$Poll_PopWidth = \"$Poll_PopWidth\";
\$Poll_PopHeight = \"$Poll_PopHeight\";
?>");
fclose($fp);
}

include "../config/wizPoll_info.php";

if(!$query):	
	if(!$dbcon->is_table("wizpoll")) ECHO"<script >location.replace('$PHP_SELF?menushow=$menushow&theme=$theme&query=install');</script>";
	else ECHO"<script >location.replace('$PHP_SELF?menushow=$menushow&theme=$theme&query=list');</script>"; 

/***** [Install Page] **********************************************************************************************/
elseif($query == "install"):
?>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">wizPoll Data Base Install</div>
	  <div class="panel-body">
		 현재 투표창과 관련하여 DataBase가 생성되지 않았으므로 아래 설치하기를 클릭하여 <br />
        DataBase를 생성해 주세요
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
      <div class="space20"></div>
      <table class="table_main w_default">
        <form action='<?php echo $PHP_SELF?>' method='post'>
          <input type='hidden' name='query' value='install_ok'>
          <input type='hidden' name='menushow' value='<?php echo $menushow?>'>
          <input type='hidden' name='theme' value='<?php echo $theme?>'>
          <tr>
            <td><input type="image" src="img/util_icon11.gif" width="129"></td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
<?php
elseif($query == "install_ok"):
	// 투표 테이블 생성
$Result = $dbcon->_query("
		  CREATE TABLE wizpoll(
          UID INT AUTO_INCREMENT NOT NULL,
		  PID VARCHAR(200) NOT NULL,
		  Subject VARCHAR(255),
		  Contents VARCHAR(255),
		  Vote VARCHAR(255),
		  FromDay int(13),
		  ToDay int(13),
		  PRIMARY KEY(UID, PID)
		)");
if($Result) echo "<script >location.replace('$PHP_SELF?menushow=$menushow&theme=$theme&query=list');</script>"; 
exit;

/***** [list display] **********************************************************************************************/
elseif($query == "list"):

$BOARD_NAME = "wizpoll";
$ListNo = 10;
$PageNo = 10;
$Todaydate = time();
/* 검색 키워드 및 WHERE 구하기 */
$WHERE = "WHERE UID <> ''";

if($pollquery == "ing") $WHERE .=" and FromDay <= '$Todaydate' and ToDay >= '$Todaydate'";
else if($pollquery == "end") $WHERE .=" and ToDay < '$Todaydate'";
if($stitle && $keyword){
$WHERE .= " AND $stitle LIKE '%$keyword%'";
}

/* 총 갯수 구하기 */

$TOTAL_STR = "SELECT count(UID) FROM $BOARD_NAME $WHERE";
$TOTAL = $dbcon->get_one($TOTAL_STR);

for($i=0; $i<3; $i++){
global $BOARD_NAME, $Todaydate;
	if($i==0) $totalwhere = "";
	else if($i==1) $totalwhere = "where FromDay <= '$Todaydate' and ToDay >= '$Todaydate'";
	else if($i==2) $totalwhere = "where ToDay < '$Todaydate'";
	$totalstr = "select count(*) from $BOARD_NAME $totalwhere";
	$total[$i] = $dbcon->get_one($totalstr);
}	
if(empty($cp) || $cp <= 0) $cp = 1;

?>
<script>
	function gotoPage(cp){
		$("#cp").val(cp);
		$("#sform").submit();
	}
</script>

<form id="sform">
	<input type='hidden' name='menushow' value='<?php echo $menushow?>'>
	<input type="hidden" name="theme"  value='<?php echo $theme?>'>
	<input type="hidden" name="cp" id="cp"  value='<? echo $cp?>' >
</form>

<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">wizPoll Listing</div>
	  <div class="panel-body">
		 현재 투표상황등을 일괄적으로 보실 수 있습니다.<br />
        메인에서 poll창 생성방법:<br />
        include &quot;./util/wizpoll/wizpoll_func.php&quot;;<br />
        include &quot;./config/wizPoll_info.php&quot;; 확인<br />
        넣고 싶은 위치에 <br />
        wizpoll_skin_include($Poll_Skin_Name,$Poll_ID,$Poll_PopWidth,$Poll_PopHeight);
	  </div>
	</div>
	      Total : <?php echo $total_no?> - Page : <?php echo $page?> / <?php echo $total_page?>
      <table class="table_main w_default">
        <tr>
          <td <?php echo $bgcolor_all?>><a href='<?php echo $PHP_SELF?>?menushow=<?php echo $menushow?>&theme=<?php echo $theme?>&query=list'>모든 
            투표[<font color='blue'>
            <?php echo $total[0]?>
            ]</a></td>
          <td <?php echo $bgcolor_ing?>><a href='<?php echo $PHP_SELF?>?menushow=<?php echo $menushow?>&theme=<?php echo $theme?>&query=list&pollquery=ing'>진행중인 
            투표[<font color='blue'>
            <?php echo $total[1]?>
            ]</a></td>
          <td <?php echo $bgcolor_end?>><a href='<?php echo $PHP_SELF?>?menushow=<?php echo $menushow?>&theme=<?php echo $theme?>&query=list&pollquery=end'>종료된 
            투표[<font color='blue'>
            <?php echo $total[2]?>
            ]</a> </td>
          <td><span class="button bull"><a href="<?php echo $PHP_SELF?>?menushow=<?php echo $menushow?>&theme=<?php echo $theme?>&query=input_1&pollquery=<?php echo $poll?>">등록하기</a></span></td>
        </tr>
      </table>
      
            <table class="table table-hover table-striped">
        <tr>
          <th>번호</th>
          <th>코드</th>
          <th>주제</th>
          <th>투표</th>
          <th>시작일</th>
          <th>종료일</th>
          <th>&nbsp;</th>
        </tr>
<?php 
$START_NO = ($cp - 1) * $ListNo;
$BOARD_NO=$TOTAL-($ListNo*($cp-1));
$SELECT_STR="SELECT * FROM $BOARD_NAME $WHERE ORDER BY UID DESC LIMIT $START_NO, $ListNo";
$SELECT_QRY=$dbcon->_query($SELECT_STR);
$cnt=0;
while($List=@$dbcon->_fetch_array($SELECT_QRY)):
$today = time();
// 총 투표수
$Vote = explode("|",$List[Vote]);
$total_vote = "0";
for($i=0; $i<count($Vote)-1; $i++) $total_vote += $Vote[$i];

?>
        <tr class="success">
          <td><?php echo $BOARD_NO?>
          </td>
          <td><?php echo $List[UID]?>
          </td>
          <td><?php echo $List[Subject]?>
          </td>
          <td><?php echo $total_vote?>
          </td>
          <td><?php echo date("Y.m.d",$List[FromDay])?>
          </td>
          <td <?php echo $bgcolor?>><?php echo date("Y.m.d",$List[ToDay])?>
          </td>
          <td><table>
              <tr>
                <td><span class="button bull"><a href='javascript:window.open("../util/wizpoll/DEFAULT/result.php?uid=<?php echo $List[UID]?>&mode=view&window_open=y","WizPollViewPage_<?php echo $List[UID]?>'>보기</a></span></td>
                <td>&nbsp;</td>
                <td><span class="button bull"><a href="<?php echo $PHP_SELF?>?menushow=<?php echo $menushow?>&theme=<?php echo $theme?>&query=del&uid=<?php echo $List[UID]?>&poll=<?php echo $poll?>&page=<?php echo $page?>">삭제</a></span></td>
                <td>&nbsp;</td>
                <td><span class="button bull"><a href="<?php echo $PHP_SELF?>?menushow=<?php echo $menushow?>&theme=<?php echo $theme?>&query=modify_1&uid=<?php echo $List[UID]?>&poll=<?php echo $poll?>&page=<?php echo $page?>">수정</a></span></td>
              </tr>
            </table></td>
        </tr>
<?php
$cnt++;
$BOARD_NO--;
endwhile;
if(!$cnt):/* 게시물이 존재하지 않을 경우 */
?>
        <tr>
          <td colspan="7"  class="text-center">투표가 없습니다.</td>
        </tr>
<?php
endif;
?>
      </table>
      
      <div class="text-center">
<?php
$params = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL, "type"=>"bootstrappost"); 
echo $common->paging($params);
?>
	</div>
	
	
	<form name="" action="<?php echo $PHP_SELF?>">
        <input type="hidden" name="memu13" value="show">
        <input type="hidden" name="theme" value="<?php echo $theme?>">
        <input type="hidden" name="action" value="poll_write">
        <table class="table_main w_default">
          <tr>
            <th>스킨명</th>
            <th>폴코드</th>
            <th>폭(Pixel)</th>
            <th>높이(Pixel)</th>
          </tr>
          <tr>
            <td><select style="width: 160px" name="Poll_Skin_Name">
                <?
$vardir = "../util/wizpoll";
$open_dir = opendir($vardir);
        while($opendir = readdir($open_dir)) {
                if(($opendir != ".") && ($opendir != "..") && ($opendir != "func") && is_dir("$vardir/$opendir")) {
                        if($Poll_Skin_Name == "$opendir") $selected = "selected"; 
						else unset($selected);
                              echo "<option value=\"$opendir\" $selected>$opendir 스킨</option>\n";

                }
        }
closedir($open_dir);
?>
              </select></td>
            <td><select style="width: 160px" name="Poll_ID">
                <?
$sqlsubstr = "select UID from $BOARD_NAME where FromDay <= '$Todaydate' and ToDay >= '$Todaydate' ORDER BY UID DESC";
$sqlsubqry = $dbcon->_query($sqlsubstr);
$cnt = 0;
        while($pidlist = $dbcon->_fetch_array($sqlsubqry)):
			if($Poll_ID == "$pidlist[UID]") $selected = "selected";
			else unset($selected);
					echo "<option value=\"$pidlist[UID]\" $selected>$pidlist[UID]</option>\n";
			$cnt ++;
       endwhile;
	   if(!$cnt) echo "<option value=\"\" $selected>진행중인 설문이 없습니다.</option>\n";
?>
              </select>
              &nbsp; </td>
            <td><input name='Poll_PopWidth' type='text' size="10" value="<?php echo $Poll_PopWidth?>">
              pixel </td>
            <td><input name='Poll_PopHeight' type='text' size="10" value="<?php echo $Poll_PopHeight?>">
              pixel </td>
          </tr>
        </table>
        <div class="paging_box"><span class="button bull"><a href="javascript:submit()">등록하기</a></span></div>
      </form>
	
	
</div>

<?

## 투표 등록
elseif($query == "input_1"):

	// 등록 양식 출력
?>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">Step1[투표등록]</div>
	  <div class="panel-body">
		 코드는 되도록 영문및 숫자로만 기입해주세요(예, Poll1)<br />
        주제는 투표의 특성에 가장 적합한 항목을 선택해 주세요(예, 내가 투표하는 이유는?)<br />
        항목은 주제에 대한 항목의 갯수를 지정해 주세요<br />
        기간은 투표기간으로서 숫자로만 입력바랍니다(예, 15)
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
      <div class="space20"></div>
      <form action='<?php echo $PHP_SELF?>' method='post'>
        <input type='hidden' name='query' value='input_2'>
        <input type='hidden' name='menushow' value='<?php echo $menushow?>'>
        <input type='hidden' name='theme' value='<?php echo $theme?>'>
        <table class="table_main w_default">
          <tr>
            <th>주제 
              : </th>
            <td><input name='Subject' type='text' size="50"></td>
          </tr>
          <tr>
            <th>항목 
              : </th>
            <td><input name='Contents' type='text' size="5">
              개(숫자로 입력 요망)</td>
          </tr>
          <tr>
            <th>기간 
              : </th>
            <td><?
$ThisYear = date("Y");
$ThisMonth = date("m");
$ThisDay = date("d");
if(!$regyear) $regyear = $ThisYear;
if(!$regmonth) $regmonth = $ThisMonth;
if(!$regday) $regday = $ThisDay;
?>
              <select name="fyear">
                <?
for($i=$ThisYear-1; $i <$ThisYear+2; $i++){
if($regyear == "$i") $selected = "selected";
else unset($selected);
 echo "<option value='$i' $selected>$i</option>";
}
?>
              </select>
              년
              <select name="fmonth">
                <?
for($i=01; $i < 13; $i++){
$k = substr("0".$i, -2);
if($regmonth == "$k") $selected = "selected";
else unset($selected);
 echo "<option value='$k' $selected>$k</option>";
}
?>
              </select>
              월
              <select name="fday">
                <?
for($i=01; $i < 32; $i++){
$k = substr("0".$i, -2);
if($regday == "$k") $selected = "selected";
else unset($selected);
 echo "<option value='$k' $selected>$k</option>";
}
?>
              </select>
              일~
              <select name="tyear">
                <?
for($i=$ThisYear-1; $i <$ThisYear+2; $i++){
if($regyear == "$i") $selected = "selected";
else unset($selected);
 echo "<option value='$i' $selected>$i</option>";
}
?>
              </select>
              년
              <select name="tmonth">
                <?
for($i=01; $i < 13; $i++){
$k = substr("0".$i, -2);
if($regmonth == "$k") $selected = "selected";
else unset($selected);
 echo "<option value='$k' $selected>$k</option>";
}
?>
              </select>
              월
              <select name="tday">
                <?
for($i=01; $i < 32; $i++){
$k = substr("0".$i, -2);
if($regday == "$k") $selected = "selected";
else unset($selected);
 echo "<option value='$k' $selected>$k</option>";
}
?>
              </select>
              일</td>
          </tr>
        </table>
        <div class="paging_box"> <span class="button bull"><a href="javascript:history.back()">이전</a></span> <span class="button bull"><a href="javascript:submit()">다음</a></span> </div>
      </form></td>
  </tr>
</table>
<?
elseif($query == "input_2"):

	if(CheckField($Subject)|| CheckField($Contents) || CheckField($period)) ECHO"<center>모두 입력 하셔야 다음 단계로 갈수 있습니다.<br />[뒤로가기] 버튼을 누르시고 모두 입력하시기 바랍니다.</center>";
	if(CheckInt($Contents)) ECHO("항목은 숫자로만 이루어 져야 합니다.");
	$FromDay = mktime(0,0,0,$fmonth, $fday, $fyear);
	$ToDay = mktime(0,0,-1, $tmonth, $tday+1, $tyear);
	$period = ($ToDay - $FromDay)/(60*60*24)+1;
?>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">Step2[항목입력]</div>
	  <div class="panel-body">
		 각의 항목을 넣어주세요
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
      <div class="space20"></div>
      <form action='<?php echo $PHP_SELF?>' method='post'>
        <input type='hidden' name='menushow' value='<?php echo $menushow?>'>
        <input type='hidden' name='theme' value='<?php echo $theme?>'>
        <input type='hidden' name='query' value='input_3'>
        <input type='hidden' name='poll' value='<?php echo $poll?>'>
        <input type='hidden' name='Subject' value='<?php echo $Subject?>'>
        <input type='hidden' name='FromDay' value='<?php echo $FromDay?>'>
        <input type='hidden' name='ToDay' value='<?php echo $ToDay?>'>
        <input type='hidden' name='period' value='<?php echo $period?>'>
        <table class="table_main w_default">
          <tr>
            <th>주제 
              : </th>
            <td><?php echo $Subject?>
            </td>
          </tr>
          <tr>
            <th>항목 
              : </th>
            <td><?php echo $Contents?>
              개</td>
          </tr>
          <?		
	// 항목 출력
	for($i=1; $i<=$Contents; $i++) {
?>
          <tr>
            <th><?php echo $i?>
              . </th>
            <td><input name='Contents[]' type='text' size="50">
            </td>
          </tr>
          <?
	}
?>
          <tr>
            <th>기간 
              : </th>
            <td><?php echo date("Y년m월d일", $FromDay);?>
              ~
              <?php echo date("Y년m월d일", $ToDay);?>
              (
              <?php echo floor($period)?>
              일간)</td>
          </tr>
        </table>
        <div class="paging_box"><span class="button bull"><a href="javascript:history.back()">이전</a></span> <span class="button bull"><a href="javascript:submit()">다음</a></span></div>
      </form></td>
  </tr>
</table>
<?


elseif($query == "input_3"):
	if(CheckField($Subject) || CheckField($period))  
	echo "<script >window.alert('항목을 입력하셔야 다음 단계로 갈수가 있습니다. \\n\\n[뒤로가기] 버튼을 눌러서 항목을 입력하세요.'); history.go(-1);</script>";
    // 총 항목수 체크
    for($i=0; $i<count($Contents)-1; $i++) $total .= $Contents[$i];
	if(CheckField($total)) ECHO"<center>항목을 입력하셔야 다음 단계로 갈수가 있습니다.<br />[뒤로가기] 버튼을 눌러서 항목을 입력하세요.</center>";
?>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">Step3[확인 단계]</div>
	  <div class="panel-body">
		 아래 입력 사항으로 등록 하시려면 [등록하기] 버튼을 누르세요.<br />
        수정하시려면 [이전단계] 버튼을 누르세요.
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
      <div class="space20"></div>
      <form action='<?php echo $PHP_SELF?>' method='post'>
        <input type='hidden' name='menushow' value='<?php echo $menushow?>'>
        <input type='hidden' name='theme' value='<?php echo $theme?>'>
        <input type='hidden' name='query' value='input_ok'>
        <input type='hidden' name='poll' value='<?php echo $poll?>'>
        <input type='hidden' name='Subject' value='<?php echo $Subject?>'>
        <input type='hidden' name='FromDay' value='<?php echo $FromDay?>'>
        <input type='hidden' name='ToDay' value='<?php echo $ToDay?>'>
        <table class="table_main w_default">
          <tr>
            <th>주제 
              : </th>
            <td><?php echo $Subject?>
            </td>
          </tr>
          <tr>
            <th>항목 
              : </th>
            <td><?php echo sizeof($Contents)?>
              개</td>
          </tr>
          <?
	// 항목 출력
    $j = 1;
	for($i=0; $i<count($Contents); $i++) {
		if($Contents[$i]) {
?>
          <input type='hidden' name='Contents[]' value='<?php echo $Contents[$i]?>'>
          <input type='hidden' name='Vote[]' value='0'>
          <tr>
            <th><?php echo $j?>
              . </th>
            <td><?php echo $Contents[$i]?>
            </td>
          </tr>
          <?	
			$j++;
		}
	}
?>
          <tr>
            <th>기간 
              : </th>
            <td><?php echo date("Y년m월d일", $FromDay);?>
              ~
              <?php echo date("Y년m월d일", $ToDay);?>
              (
              <?php echo floor($period)?>
              일간)</td>
          </tr>
        </table>
        <div class="paging_box"> <span class="button bull"><a href="javascript:history.back()">이전</a></span> <span class="button bull"><a href="javascript:submit()">다음</a></span></div>
      </form></td>
  </tr>
</table>
<?


elseif($query == "input_ok"):

	if(CheckField($Subject) || CheckField($FromDay) || CheckField($ToDay) || CheckField($Contents) || CheckField($Vote)) 
	echo "<script >window.alert('등록중 에러가 발생하였습니다!!'); history.go(-1);</script>";
	for($i=0; $i<count($Vote); $i++) {
		$Contents_ok .= $Contents[$i]."|";
		$vote_ok .= $Vote[$i]."|";
	}


	// 등록 실패 메시지
$Result = $dbcon->_query("insert into wizpoll (Subject,Contents,Vote,FromDay,ToDay) values('$Subject','$Contents_ok','$vote_ok','$FromDay','$ToDay')");
ECHO"<script >location.replace('$PHP_SELF?menushow=$menushow&theme=$theme&query=list&poll=$poll&page=$page');</script>";
exit;

/* 이후 수정하기 $Step1 */
## 수정하기
elseif($query == "modify_1"):
	$query = $dbcon->_query("select * from wizpoll where UID='$uid'");
	$List = $dbcon->_fetch_array($query);
    $Contentsexp = explode("|",$List[Contents]);
    $Voteexp = explode("|",$List[Vote]);
    $total_Contents = count($Contentsexp)-1;
// 기간 (종료일에서 등록일을 뺀 값을 가지고 기간을 구한다)
$period = ($List[ToDay]-$List[FromDay])/60/60/24;

?>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">Step1[수정 단계]</div>
	  <div class="panel-body">
		 수정하시려면 수정할 내용을 변경 후 [다음단계] 버튼을 누르세요.
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
      <div class="space20"></div>
      <form action='<?php echo $PHP_SELF?>' method='post'>
        <input type='hidden' name='menushow' value='<?php echo $menushow?>'>
        <input type='hidden' name='theme' value='<?php echo $theme?>'>
        <input type='hidden' name='query' value='modify_2'>
        <input type='hidden' name='poll' value='<?php echo $poll?>'>
        <input type='hidden' name='page' value='<?php echo $page?>'>
        <input type='hidden' name='uid' value='<?php echo $uid?>'>
        <table class="table_main w_default">
          <?
		for($i=0; $i<sizeof($Contentsexp); $i++) {
			if($Voteexp[$i] == "") $Voteexp[$i] = "0";
?>
          <input type='hidden' name='Contents[]' value='<?php echo $Contentsexp[$i]?>'>
          <input type='hidden' name='Vote[]' value='<?php echo $Voteexp[$i]?>'>
          <?
	    }
?>
          <tr>
            <th>주제 : </th>
            <td><input name='Subject' type='text' value='<?php echo $List[Subject]?>' size="50"></td>
          </tr>
          <tr>
            <th> 항목 :</th>
            <td><input name='total_Contents' type='text' value='<?php echo $total_Contents?>' size="5">
            </td>
          </tr>
          <tr>
            <th>기간 
              : </th>
            <td><?
$ThisYear = date("Y");
$ThisMonth = date("m");
$ThisDay = date("d");
$regyear = date("Y", $List[FromDay]);
$regmonth = date("m", $List[FromDay]);
$regday = date("d", $List[FromDay]);
?>
              <select name="fyear">
                <?
for($i=$ThisYear-1; $i <$ThisYear+2; $i++){
if($regyear == "$i") $selected = "selected";
else unset($selected);
 echo "<option value='$i' $selected>$i</option>";
}
?>
              </select>
              년
              <select name="fmonth">
                <?
for($i=01; $i < 13; $i++){
$k = substr("0".$i, -2);
if($regmonth == "$k") $selected = "selected";
else unset($selected);
 echo "<option value='$k' $selected>$k</option>";
}
?>
              </select>
              월
              <select name="fday">
                <?
for($i=01; $i < 32; $i++){
$k = substr("0".$i, -2);
if($regday == "$k") $selected = "selected";
else unset($selected);
 echo "<option value='$k' $selected>$k</option>";
}
?>
              </select>
              일~
              <?
$regyear = date("Y", $List[ToDay]);
$regmonth = date("m", $List[ToDay]);
$regday = date("d", $List[ToDay]);
?>
              <select name="tyear">
                <?
for($i=$ThisYear-1; $i <$ThisYear+2; $i++){
if($regyear == "$i") $selected = "selected";
else unset($selected);
 echo "<option value='$i' $selected>$i</option>";
}
?>
              </select>
              년
              <select name="tmonth">
                <?
for($i=01; $i < 13; $i++){
$k = substr("0".$i, -2);
if($regmonth == "$k") $selected = "selected";
else unset($selected);
 echo "<option value='$k' $selected>$k</option>";
}
?>
              </select>
              월
              <select name="tday">
                <?
for($i=01; $i < 32; $i++){
$k = substr("0".$i, -2);
if($regday == "$k") $selected = "selected";
else unset($selected);
 echo "<option value='$k' $selected>$k</option>";
}
?>
              </select>
              일</td>
          </tr>
        </table>
        <div class="paging_box"> <span class="button bull"><a href="javascript:history.back()">이전</a></span> <span class="button bull"><a href="javascript:submit()">다음</a></span> </div>
      </form></td>
  </tr>
</table>
<?
elseif($query == "modify_2") :
	if(CheckField($Subject) || CheckField($Contents) || CheckInt($total_Contents) || CheckField($Vote))  
	echo "<script >window.alert('모두 입력하셔야 수정 됩니다.'); history.go(-1);</script>";
?>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">Step2[수정 단계]</div>
	  <div class="panel-body">
		 항목을 수정하시고 [다음단계] 버튼을 누르세요.
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
      <div class="space20"></div>
      <?	  
	$FromDay = mktime(0,0,0,$fmonth, $fday, $fyear);
	$ToDay = mktime(0,0,-1, $tmonth, $tday+1, $tyear);
	$period = ($ToDay - $FromDay)/(60*60*24)+1;
?>
      <form action='<?php echo $PHP_SELF?>' method='post'>
        <input type='hidden' name='menushow' value='<?php echo $menushow?>'>
        <input type='hidden' name='theme' value='<?php echo $theme?>'>
        <input type='hidden' name='query' value='modify_3'>
        <input type='hidden' name='poll' value='<?php echo $poll?>'>
        <input type='hidden' name='page' value='<?php echo $page?>'>
        <input type='hidden' name='uid' value='<?php echo $uid?>'>
        <input type='hidden' name='Subject' value='<?php echo $Subject?>'>
        <input type='hidden' name='FromDay' value='<?php echo $FromDay?>'>
        <input type='hidden' name='ToDay' value='<?php echo $ToDay?>'>
        <input type='hidden' name='period' value='<?php echo $period?>'>
        <table class="table_main w_default">
          <tr>
            <th>주제 
              : </th>
            <td><?php echo $Subject?>
            </td>
          </tr>
          <tr>
            <th> 항목 :</th>
            <td><?php echo $total_Contents?>
              개 </td>
          </tr>
          <?
	// 항목 출력
	for($i=0; $i<$total_Contents; $i++) {
		$no = $i+1;

		if(!$Vote[$i]) $Vote[$i] = "0";
?>
          <tr>
            <th><?php echo $no?>
              .</th>
            <td><input name='Contents[]' type='text' value='<?php echo $Contents[$i]?>' size="50">
              <input name='Vote[]' type='text' value='<?php echo $Vote[$i]?>' size="5"></td>
          </tr>
          <?
		$no++;
	}
?>
          <input type='hidden' name='period' value='<?php echo $period?>'>
          <tr>
            <th>기간 
              : </th>
            <td><?php echo date("Y년m월d일", $FromDay);?>
              ~
              <?php echo date("Y년m월d일", $ToDay);?>
              (
              <?php echo floor($period)?>
              일간)</td>
          </tr>
        </table>
        <div class="paging_box"> <span class="button bull"><a href="javascript:history.back()">이전</a></span> <span class="button bull"><a href="javascript:submit()">다음</a></span></div>
      </form></td>
  </tr>
</table>
</form>
<?
elseif($query == "modify_3") :
	if(CheckField($Subject) || CheckField($Contents) || CheckField($Vote) || CheckField($FromDay) || CheckField($period))  ECHO "<script >window.alert('모두 입력하셔야 수정 됩니다.'); history.go(-1);</script>";
?>
<?
	$total_Contents = count($Contents);
?>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">Step3[수정 단계]</div>
	  <div class="panel-body">
		 아래 내용이 맞으면 [수정완료] 버튼을 누르세요.
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
      <div class="space20"></div>
      <form action='<?php echo $PHP_SELF?>' method='post'>
        <input type='hidden' name='menushow' value='<?php echo $menushow?>'>
        <input type='hidden' name='theme' value='<?php echo $theme?>'>
        <input type='hidden' name='query' value='modify_ok'>
        <input type='hidden' name='poll' value='<?php echo $poll?>'>
        <input type='hidden' name='page' value='<?php echo $page?>'>
        <input type='hidden' name='uid' value='<?php echo $uid?>'>
        <input type='hidden' name='Subject' value='<?php echo $Subject?>'>
        <input type='hidden' name='FromDay' value='<?php echo $FromDay?>'>
        <input type='hidden' name='ToDay' value='<?php echo $ToDay?>'>
        <table class="table_main w_default">
          <tr>
            <th>주제 
              : </th>
            <td><?php echo $Subject?>
            </td>
          </tr>
          <tr>
            <th> 항목 :</th>
            <td><?php echo $total_Contents?>
              개 </td>
          </tr>
          <?
	$no = "1";
	for($i=0; $i<$total_Contents; $i++) {
		if($Contents[$i]) {
		if(!$Vote[$i]) $Vote[$i] = "0";
		if(CheckInt($Vote[$i])) $Vote[$i] = "0";
		?>
          <input type='hidden' name='Contents[]' value='<?php echo $Contents[$i]?>'>
          <input type='hidden' name='Vote[]' value='<?php echo $Vote[$i]?>'>
          <tr>
            <th><?php echo $no?>
              .</th>
            <td><?php echo $Contents[$i]?>
              : [
              <?php echo $Vote[$i]?>
              ] </td>
          </tr>
          <?
		$no++;
		}
	}
?>
          <tr>
            <th>기간 
              : </th>
            <td><?php echo date("Y년m월d일", $FromDay);?>
              ~
              <?php echo date("Y년m월d일", $ToDay);?>
              (
              <?php echo floor($period)?>
              일간)</td>
          </tr>
        </table>
        <div class="paging_box"><span class="button bull"><a href="javascript:history.back()">이전</a></span> <span class="button bull"><a href="javascript:submit()">수정완료</a></span></div>
      </form></td>
  </tr>
</table>
<?
elseif($query == "modify_ok"):
	if(CheckField($Subject) || CheckField($Contents) || CheckField($Vote) || CheckField($FromDay))  
	ECHO "<script >window.alert('모두 입력하셔야 수정 됩니다.'); history.go(-1);</script>";
	for($i=0; $i<count($Contents); $i++) {
		$Contents_ok .= $Contents[$i]."|";
		$vote_ok .= $Vote[$i]."|";
	}

// 수정
$sqlstr = "UPDATE wizpoll SET Subject = '$Subject',Contents= '$Contents_ok',Vote = '$vote_ok',FromDay = '$FromDay',ToDay = '$ToDay' where UID='$uid'";
$Result =$dbcon->_query($sqlstr);
ECHO"<script >location.replace('$PHP_SELF?menushow=$menushow&theme=$theme&query=list&poll=$poll&page=$page');</script>";
exit;	


## 삭제하기
elseif($query == "del"):
	if(!@$dbcon->_query("delete from wizpoll where UID='$uid'")) {
		echo "<script >window.alert('선택한 폴은 삭제되지 않습니다.'); history.go(-1);</script>";
	}
ECHO"<script >location.replace('$PHP_SELF?menushow=$menushow&theme=$theme&query=list&poll=$poll&page=$page&poll=$poll&page=$page');</script>";
exit;		

## 지난 투표
elseif($query == "etc") :
    // 한페이지에 표시될 페이지 링크수 
	$page_num = "10";

	// 한페이지에 보여질 투표 갯수
	$limit = "5";

	// 투표 갯수 뽑아오기
	$total_no = $dbcon->get_one("select count(*) from wizpoll");

    // 페이지 구하기
    if(!$page) $page=1;

    $total_page = intval(($total_no-1)/$limit)+1;
    $first = ($page-1)*$limit;
    $last = $limit;
    if($total_no < $last) $last = $total_no;
    $limit = "limit $first,$last";

    // 게시물 뽑아오기
    $query = $dbcon->_query("select * from wizpoll order by UID desc $limit");
 ?>
 <div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">지난 투표 보기</div>

	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
      <div class="space20"></div>
      Total :
      <?php echo $total_no?>
      - Page :
      <?php echo $page?>
      /
      <?php echo $total_page?>
      <table class="table_main w_default">
        <tr>
          <th>번호</th>
          <th>주제</th>
          <th>투표</th>
          <th>참여</th>
        </tr>
        <?
	// 투표가 하나도 없을때
    if($total_no == "0") {
?>
        <tr>
          <td colspan='4'>투표가 없습니다.</td>
        </tr>
        <?	}

	else {

	while($List = $dbcon->_fetch_array($query)) {
		$num = $total_no - $first;
?>
        <tr>
          <td nowrap><?php echo $num?>
          </td>
          <td nowrap><a href=javascript:void(window.open('<?php echo $PHP_SELF?>?uid=<?php echo $List[UID]?>&window_open=y&bar_width=<?php echo $bar_width?>&bar_height=<?php echo $bar_height?>&bar_color=<?php echo $bar_color?>&width=<?php echo $width?>','wizpoll_<?php echo $List[UID]?>','width=<?php echo $window_width?>,height=<?php echo $window_height?>,srollbar=auto,toolbar=no,statusbar=no'))>
            <?php echo $List[Subject]?>
            </a></td>
          <td><table>
              <?

		$Contents = explode("|",$List[Contents]);
		$Vote = explode("|",$List[Vote]);

		// 총 투표수
		for($y=0; $y<count($Contents)-1; $y++) $total_vote += $Vote[$y];

		for($z=0; $z<count($Contents)-1; $z++) {
			//$Contents[$z] = str_replace("58(3A)","|",$Contents[$z]);
			$no_Contents = $z+1;
			$percent = @intval($Vote[$z]/$total_vote*100);
			$bar_width = 99;
			$bar_length = @intval($Vote[$z]/$total_vote*$bar_width)+1;
?>
              <tr>
                <td><?php echo $no_Contents?>
                  .
                  <?php echo $Contents[$z]?>
                </td>
                <td><table height='<?php echo $bar_height?>' width='<?php echo $bar_length?>' bgcolor='<?php echo $bar_color?>'>
                  </table></td>
                <td><font size='1' face='verdana'>&nbsp;
                  <?php echo $Vote[$z]?>
                  표 :
                  <?php echo $percent?>
                  %&nbsp; </td>
              </tr>
              <?
		}
?>
            </table></td>
          <td><font color='blue' size='1' face='verdana'>
            <?php echo $total_vote?>
          </td>
        </tr>
        <?
		$first++;
	}

	}

?>
        <tr>
          <td colspan='4'><?
	page_link("$PHP_SELF?menushow=$menushow&theme=$theme&query=etc");
?>
          </td>
        </tr>
      </table>
      <?
	$no = "1";
	for($i=0; $i<$total_Contents; $i++) {
		if($Contents[$i]) {
		if(!$Vote[$i]) $Vote[$i] = "0";
		if(CheckInt($Vote[$i])) $Vote[$i] = "0";
		?>
      <input type='hidden' name='Contents[]' value='$_Contents'>
      <input type='hidden' name='Vote[]' value='$Vote[$i]'>
      <?
		$no++;
		}
	}
	// 마감일 구하기
	$endday = $FromDay+($period*24*60*60);
	
	// 정확한 날짜 구하기
	$startday_time = date("Y년m월d일",$FromDay);
	$endday_time = date("Y년m월d일",$endday);
?>
    </td>
  </tr>
</table>
<?
endif;
?>
