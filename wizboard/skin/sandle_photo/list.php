<?
/* 
제작자 : 폰돌
스킨 : wizboard list skin 
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
?>
<table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td height="50" align="center"><table width="100%" height="40" border="0" cellpadding="0" cellspacing="3" bgcolor="DADADA">
        <tr bgcolor="f0f0f0">
          <td align="center" bgcolor="F7F7F8"><table width="99%" border="0" cellspacing="0" cellpadding="0">
  <FORM NAME="board_search" ACTION="<?=$PHP_SELF?>" METHOD="POST" onsubmit="return autoCheckForm(this)">
    <input type="hidden" name="BID" value="<?=$BID?>" >
    <input type="hidden" name="GID" value="<?=$GID?>" >
    <input type="hidden" name="adminmode" value="<?=$adminmode?>">
    <input type="hidden" name="optionmode" value="<?=$optionmode?>">
    <input type="hidden" name="category" value="<?=$category?>">
    <input type="hidden" name="mode" value="<?=$mode?>">
    <input type="hidden" name="UID" value="<?=$UID?>">
    <input type="hidden" name="cp" value="<?=$cp?>">
                <tr>
                  <td width="66" align="center"><img src="./wizboard/skin/<?=$cfg["wizboard"]["BOARD_SKIN_TYPE"]?>/images/search.gif" width="54" height="17"></td>
                  <td width="58"><select name="SEARCHTITLE" checkenable msg="검색범위를 선택해주세요">
          <option value=""<? if($SEARCHTITLE == "" ) echo " selected";?>>전체</option>
          <option value="SUBJECT"<? if($SEARCHTITLE == "SUBJECT" ) echo " selected";?>>제 
          목</option>
          <option value="NAME"<? if($SEARCHTITLE == "NAME" ) echo " selected";?>>글쓴이</option>
          <option value="CONTENTS"<? if($SEARCHTITLE == "CONTENTS" ) echo " selected";?>>내 
          용</option>
        </select></td>
                  <td width="404"><input name="searchkeyword" type="text" class="input3" id="searchkeyword" value="<? echo $searchkeyword; ?>" checkenable msg="키워드를 입력하세요" style="width:99%" maxlength="70"></td>
                  <td width="52"><input type="image" src="./wizboard/icon/<?=$cfg["wizboard"]["ICON_SKIN_TYPE"];?>/search_btn.gif" align="absmiddle" alt="검색(searching)" /></td>
                </tr>
              </form>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
<? 
$result = $board->getboardlist();
$cnt=0;
while($dbcon->_data_seek($result,$cnt)):
	$list = $dbcon->_fetch_assoc($result);
	$list = $board->listtrim($list);##현재의 리스트를 기준으로 필요한 필드를 처리한다.
	##listtrim은 기본적인 리스트 처리이고 별도로 할경우 상기 listtrim을 빼고 바로 작업하거나 별도의 함수를 생성하여 처리한다.
	$list["print_subject"] = $UID==$list["UID"]? "<font color='#FF0000'>".$list["print_subject"]."</font>":$list["print_subject"];
	$getdata="BID=".$BID."&GID=".$GID."&adminmode=".$adminmode."&optionmode=".$optionmode."&category=".$category."&mode=view&UID=".$list["UID"];
	$getdata.="&search_term=".$search_term."&SEARCHTITLE=".$SEARCHTITLE."&searchkeyword=".urlencode($searchkeyword);
	$getdata = $common->getencode($getdata);
	$filepath = "./config/wizboard/table/".$UpdirPath."/updir/".$list["UID"]."/";
?>
          <td width="33%" height="175" align="center"><table width="160" height="119" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" class="bd1" style="padding:3px;"><a href="<?=$PHP_SELF?>?getdata=<?=$getdata?>"><img src="<?=$common->getthumbimg($filepath, $list["attached"][0], 150, 113) ?>" width="150" height="113" border="0"></a> </td>
              </tr>
            </table>
            <table width="160" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td height="10" colspan="2"></td>
              </tr>
              <tr class="ft2">
                <td width="40" height="25" align="center" bgcolor="#E8E8E8" class="ft2 style3">제목</td>
                <td height="25"  width="115" bgcolor="#F3F3F3" class="dot"><a href="<?=$PHP_SELF?>?getdata=<?=$getdata?>" style="TEXT-DECORATION: none;">
      <?=$list["print_subject"]?>
      </a></td>
              </tr>
            </table></td>
          <?
$board->ini_board_no--;
$cnt++;
if($cnt%3) echo "";
if(!($cnt%3) && $cnt != $TOTAL) ECHO"</tr></table><br><br><table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
endwhile;
$tmpcnt = $cnt%3;
for($i=$tmpcnt; $i<3; $i++){
	echo "<td width='33%' valign='top'></td>";
}

if(!$board->page_var["tc"]):/* 게시물이 존재하지 않을 경우 */

endif;
?>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="1" align="center" bgcolor="#CCCCCC"></td>
        </tr>
        <tr>
          <td height="30" align="center"><?
include "./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/index.php";
?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="right"><table width="76" height="30" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><?
if ($_COOKIE[BOARD_PASS] || $_COOKIE[ROOT_PASS] || $cfg["wizboard"]["AdminOnly"] != "yes") :
echo $board->showBoardIcon('write');
endif;
?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
