<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><!-- ##################board list 테이블시작입니다##########################-->
  <form NAME="board_search" action="<?=$PHP_SELF?>" mehtod="POST" onsubmit="return boardSearch(this)">
    <input type="hidden" name="BID" value="<?=$BID?>" >
    <input type="hidden" name="GID" value="<?=$GID?>" >
    <input type="hidden" name="adminmode" value="<?=$adminmode?>">
    <input type="hidden" name="optionmode" value="<?=$optionmode?>">
    <input type="hidden" name="category" value="<?=$category?>">
    <input type="hidden" name="mode" value="<?=$mode?>">
    <input type="hidden" name="UID" value="<?=$UID?>">
    <input type="hidden" name="cp" value="<?=$cp?>">    
        <table width="100%" height="35" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center">&nbsp;</td>
            <td width="270" align="center"><table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><select name="SEARCHTITLE" >
        <!--<select name="SEARCHTITLE" checkenable msg="검색범위를 선택해주세요">-->
          <option value=""<? if($SEARCHTITLE == "" ) echo " selected";?>>전체</option>
          <option value="SUBJECT"<? if($SEARCHTITLE == "SUBJECT" ) echo " selected";?>>제 
          목</option>
          <option value="NAME"<? if($SEARCHTITLE == "NAME" ) echo " selected";?>>글쓴이</option>
          <option value="CONTENTS"<? if($SEARCHTITLE == "CONTENTS" ) echo " selected";?>>내 
          용</option>
        </select></td>
                  <td><input type="text" name="searchkeyword" size="20" value="<? echo $searchkeyword; ?>" checkenable msg="키워드를 입력하세요"></td>
                  <td><input type="image" src="./wizboard/icon/<?=$cfg["wizboard"]["ICON_SKIN_TYPE"];?>/search_btn.gif" align="absmiddle" alt="검색(searching)" /></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center"></td>
            <td height="5" align="right"></td>
          </tr>
        </table>
      </FORM>
    <table width="100%" height="30" border="0" cellpadding="0" cellspacing="1" bgcolor="D7D7D7">
          <tr>
            <td bgcolor="F3F3F3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr valign="bottom">
                  <td width="33" align="center" class="font1">번호</td>
                  <td width="2"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="2" height="15" /></td>
                  <td align="center" class="font1">제목</td>
                  <td width="2"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="2" height="15" /></td>
                  <td width="85" align="center" class="font1">글쓴이</td>
                  <td width="2"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="2" height="15" /></td>
                  <td width="78" align="center" class="font1">날짜</td>
                  <td width="1"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/bar_1.gif" width="2" height="15" /></td>
                  <td width="50" align="center" class="font1">조회수</td>
                </tr>
            </table></td>
          </tr>
        </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
         <? 
$result = $board->getboardlist(1);//인자값 1일경우 notice리스트를 뽑아온다.
$cnt=0;
while($dbcon->_data_seek($result,$cnt)):
	$list = $dbcon->_fetch_assoc($result);
	$list = $board->listtrim($list,1);##현재의 리스트를 기준으로 필요한 필드를 처리한다.
	##listtrim은 기본적인 리스트 처리이고 별도로 할경우 상기 listtrim을 빼고 바로 작업하거나 별도의 함수를 생성하여 처리한다.
	$list["print_subject"] = $UID==$list["UID"]? "<font color='#FF0000'>".$list["print_subject"]."</font>":$list["print_subject"];
	$getdata="BID=".$BID."&GID=".$GID."&adminmode=".$adminmode."&optionmode=".$optionmode."&category=".$category."&mode=view&UID=".$list["UID"];
	$getdata = $common->getencode($getdata);
?>
          <tr>
            <td width="33" height="26" align="center">공지</td>
            <td width="2">&nbsp;</td>
            <td align="left">&nbsp;<a href="<?=$PHP_SELF?>?getdata=<?=$getdata?>">
      <?=$list["print_subject"]?>
      </a></td>
            <td width="2">&nbsp;</td>
            <td width="85" align="center"><?=$list["NAME"];?></td>
            <td width="2">&nbsp;</td>
            <td width="76" align="center"><?=date("Y.m.d", $list["W_DATE"])?></td>
            <td width="2">&nbsp;</td>
            <td width="53" align="center"><?=$list["COUNT"];?></td>
          </tr>
          <tr bgcolor="E6E6E6">
            <td height="1" colspan="9"></td>
          </tr>
  <?
$cnt++;
endwhile;
?>
<? 
$result = $board->getboardlist();
$cnt=0;
while($list = $dbcon->_fetch_array($result)):
	//$list = $dbcon->_fetch_assoc($result);
	$list = $board->listtrim($list);##현재의 리스트를 기준으로 필요한 필드를 처리한다.
	##listtrim은 기본적인 리스트 처리이고 별도로 할경우 상기 listtrim을 빼고 바로 작업하거나 별도의 함수를 생성하여 처리한다.
	$list["print_subject"] = $UID==$list["UID"]? "<font color='#FF0000'>".$list["print_subject"]."</font>":$list["print_subject"];
	$getdata="BID=".$BID."&GID=".$GID."&adminmode=".$adminmode."&optionmode=".$optionmode."&category=".$category."&mode=view&UID=".$list["UID"];
	$getdata.="&search_term=".$search_term."&SEARCHTITLE=".$SEARCHTITLE."&searchkeyword=".urlencode($searchkeyword);
	$getdata = $common->getencode($getdata);
?>
          <tr>
            <td width="33" height="26" align="center"><?=$board->ini_board_no;?></td>
            <td width="2">&nbsp;</td>
            <td align="left">&nbsp;<a href="<?=$PHP_SELF?>?getdata=<?=$getdata?>">
      <?=$list["print_subject"]?>
      </a></td>
            <td width="2">&nbsp;</td>
            <td width="85" align="center"><?=$list["NAME"];?></td>
            <td width="2">&nbsp;</td>
            <td width="76" align="center"><?=date("Y.m.d", $list["W_DATE"])?></td>
            <td width="2">&nbsp;</td>
            <td width="53" align="center"><?=$list["COUNT"];?></td>
          </tr>
          <tr bgcolor="E6E6E6">
            <td height="1" colspan="9"></td>
          </tr>
<?
$board->ini_board_no--;
$cnt++;
endwhile;
if(!$board->page_var["tc"]):/* 게시물이 존재하지 않을 경우 */
?>          
      <tr>
            <td height="26" colspan="9" align="center" >등록된글이없습니다</td>
          </tr>
          <tr bgcolor="E6E6E6">
            <td height="1" colspan="9"></td>
          </tr>
<?
endif;
?>
          <tr>
            <td height="26" colspan="9" align="center"><table width="100%" height="26"  border="0" cellpadding="0" cellspacing="1" bgcolor="D7D7D7">
                <tr>
                  <td height="15" bgcolor="#F3F3F3">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
        </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="10"></td>
          </tr>
          <tr>
            <td align="center"><?
include "./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/index.php";
?></td>
          </tr>
          <tr>
            <td align="right">
<?
echo $board->showBoardIcon('list', 1);
?>

<?
echo $board->showBoardIcon('write');
?></td>
        </tr>
      </table></td>
  </tr>
</table>
