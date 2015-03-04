<?
if(!$uid) {
echo "<script>window.alert('잘못된 경로로 부터의 접근입니다.');history.go(-1);</script>";
exit;
}

// 투표 기간이 종료 되었을때
$Sqlqry = $dbcon->_query("SELECT * FROM wizpoll WHERE UID='$uid'");
$List = $dbcon->_fetch_array($Sqlqry);
$Contents = explode("|",$List[Contents]);
$Vote = explode("|",$List[Vote]);
    // 총 투표수
	for($i=0; $i<count($Contents)-1; $i++) {
		$TotalVote += $Vote[$i];
	}

?>
<?

## 투표 결과
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
<table width="608" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" colspan="7">&nbsp;</td>
  </tr>
  <tr> 
    <td width="62"><img src="../../images/board/tit_tit01.gif" width="62" height="27"></td>
    <td width="11"></td>
    <td width="541" colspan="5" bgcolor="#FFFFFF" style="padding: 5 0 0 10;"><strong>
      <?=$List[Subject]?>
      </strong></td>
  </tr>
  <tr> 
    <td height="4" colspan="7"></td>
  </tr>
  <tr> 
    <td width="62"><img src="../../images/board/tit_poll_date.gif" width="62" height="27"></td>
    <td width="11" ></td>
    <td width="541" style="padding: 5 0 0 10;">
      <?=date("Y-m-d", $List[FromDay])?>
      ~ 
      <?=date("Y-m-d", $List[ToDay])?>
    </td>
    <td width="62">&nbsp;</td>
    <td width="100" >&nbsp;</td>
    <td width="62"><img src="../../images/board/tit_poll_no.gif" width="62" height="27"></td>
    <td width="80"  style="padding: 5 0 0 15;">
      <?=$TotalVote?>
    </td>
  </tr>
  <tr> 
    <td height="4" colspan="7"></td>
  </tr>
  <tr align="center"> 
    <td  width="608" colspan="7" bgcolor="E6E4DF" ><br> 
      <!--투표결과-->
      <table width="500" border="0" cellspacing="0" cellpadding="0">
        <!-- 100%일때-->
        <?

    // 항목 : 투표수 출력
	for($i=0; $i<count($Contents)-1; $i++) {

		$no = $i+1;
		// %와 바 길이
		$percent = @intval($Vote[$i]/$TotalVote*100);
		$bar_width = 260;
		$bar_length = @intval($Vote[$i]/$TotalVote*$bar_width)+1;
?>
        <tr> 
          <td width="135" height="25"> 
            <?=$Contents[$i]?>
          </td>
          <td width="295"><img src="../../images/board/poll_data.gif" width="<?=$bar_length?>" height="18"></td>
          <td width="70">
            <?=$percent?>% (<?=$Vote[$i]?>/<?=$TotalVote?>)</td>
        </tr>
        <!-- 50%일때-->
        <?
	}
?>
        <!-- 10%일때-->
        <!-- 80%일때-->
      </table>
      <br> <table width="500" border="0" cellspacing="0" cellpadding="0">
        <form action='./func/pollsave.php' method='post'>
          <input type='hidden' name='uid' value='<?=$List[UID]?>'>
          <input type='hidden' name='query' value='save'>
          <input type='hidden' name='mode' value='view'>
          <tr> 
            <td colspan="3"><img src="../../images/participation/poll_img.gif" width="500" height="74"></td>
          </tr>
          <tr> 
            <td width="12"><img src="../../images/participation/poll_left.gif" width="12" height="102"></td>		  
            <td width="386" valign="top" bgcolor="DEDAD0"><table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
            <td width="388" height="11" bgcolor="DEDAD0"></td>
</tr>			
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
                  <td height="20" bgcolor="DEDAD0" style="padding-left:30px;"><input type="radio" name="num" value='<?=$no?>' <?=$checked?>> 
                    <?=$Contents[$i]?>
                  </td>
                </tr>
                <?
	}/* for 문 닫음 */

?>
          <tr> 
            <td height="11" bgcolor="DEDAD0"></td>
          </tr>
              </table></td>
            <td width="102"><input type="image" src="../../images/participation/poll_btn.gif" width="102" height="102" border="0"></td>			  
          </tr>

        </form>
      </table>
      <br> </td>
  </tr>
  <tr> 
    <td height="4" colspan="7"></td>
  </tr>
  <tr> 
    <td height="2" colspan="7" bgcolor="E6E4DF"></td>
  </tr>
  <tr align="right"> 
    <td height="50" colspan="7"> 
      <!-- 목록버튼-->
      <a href="<?=$PHP_SELF?>"><img src="../../images/btn/btn_list.gif" width="54" height="21" border="0"></a></td>
  </tr>
</table>
