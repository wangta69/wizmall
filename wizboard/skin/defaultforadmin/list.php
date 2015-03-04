<?
/* 
제작자 : 폰돌
스킨 : wizboard list skin 
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
?>
<script language="javascript" src="./js/button.js"></script>
<SCRIPT LANGUAGE=javascript>
<!--
function deletefnc(){
	var f = document.BrdList;
	var i = 0;
	var chked = 0;
	for(i = 0; i < f.length; i++ ) {
			if(f[i].type == 'checkbox') {
					if(f[i].checked) {
							chked++;
					}
			}
	}
	if( chked < 1 ) {
			alert('삭제하고자 하는 게시물을 하나 이상 선택해 주세요.');
			return false;
	}
	if (confirm('\n\n삭제하는 게시물은 복구가 불가능합니다!!! \n\n정말로 삭제하시겠습니까?\n\n')){
		f.submit();	
	}else{
		return false;
	}
}
//-->
</SCRIPT>
<table cellspacing=1 bordercolordark=white width="100%" bgcolor=#c0c0c0 bordercolorlight=#dddddd border=0 class="s1">
  <tr align="center" bgcolor="F2F2F2"> 
    <td width="30">&nbsp;</td>
    <td width="30" height="27"><font color="<?=$Fontcolort?>">번호</font></td>
    <td height="27"><font color="<?=$Fontcolort?>">제목</font></td>
    <td width="70" height="27" align="center"><font color="<?=$Fontcolort?>">글쓴이</font></td>
    <td width="60" height="27" align="center"><font color="<?=$Fontcolort?>">날짜</font></td>
    <td width="30" height="27" align="center"><font color="<?=$Fontcolort?>">조회</font></td>
	<td width="30" height="27" align="center"><font color="<?=$Fontcolort?>">보기</font></td>
	<td width="30" height="27" align="center"><font color="<?=$Fontcolort?>">수정</font></td>
  </tr>
<form action="<?=$PHP_SELF?>" Name="BrdList">
<input type="hidden" name="mode" value="delete">	  
<input type="hidden" name="BID" value="<?=$BID?>"> 
<input type="hidden" name="GID" value="<?=$GID?>">
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
?>
  <tr bgcolor="#FFFFFF"> 
    <td width="30" align="center"><input type="checkbox" name="deleteItem[<?=$list["UID"]?>]?>" value="1"> 
    </td>
    <td width="30" align="center"> <font color="<?=$Fontcolort?>"> 
      <?=$board->ini_board_no;?>
      </font> </td>
    <td> 
      <a href="javascript:location.href='<?=$PHP_SELF?>?getdata=<?=$getdata?>'" style="TEXT-DECORATION: none;">
      <?=$list["print_subject"]?>
      </a></td>
    <td width="70" align="center"> <font color="<?=$Fontcolort?>"> 
      <?=$list["NAME"];?>
      </font> </td>
    <td width="60" align="center"> <font color="<?=$Fontcolort?>"> 
      <?=date("Y.m.d", $list["W_DATE"])?>
      </font> </td>
    <td width="30" align="center"> <font color="<?=$Fontcolort?>"> 
      <?=$list["COUNT"];?>
      </font> </td>
    <td width="30" align="center"><script>nhnButton('보기','black9','javascript:window.open("./wizboard.php?BID=<?=$BID;?>&GID=<?=$GID;?>&mode=view&UID=<?=$LIST[UID];?>&cp=<?=$cp;?>&BOARD_NO=<?=$board->ini_board_no;?>&SEARCHTITLE=<?=$SEARCHTITLE?>&searchkeyword=<?=$searchkeyword?>&category=<?=$category?>","","");',4,0,'#565656','#FFFFFF','#C4C4C4','#ffffff','#ffffff','#ffffff')</script></td>
	<td width="30" align="center"><script>nhnButton('수정','black9','javascript:window.open("./wizboard.php?BID=<?=$BID;?>&GID=<?=$GID;?>&mode=modify&UID=<?=$LIST[UID];?>&cp=<?=$cp;?>&BOARD_NO=<?=$board->ini_board_no;?>&SEARCHTITLE=<?=$SEARCHTITLE?>&searchkeyword=<?=$searchkeyword?>&category=<?=$category?>","","");',4,0,'#565656','#FFFFFF','#C4C4C4','#ffffff','#ffffff','#ffffff')</script></td>	  
  </tr>
<?
$board->ini_board_no--;
$cnt++;
endwhile;
if(!$board->page_var["tc"]):/* 게시물이 존재하지 않을 경우 */
?>
  <tr bgcolor="#FFFFFF"> 
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp; </td>
    <td> 등록된 글이 없습니다.</td>
    <td align="center">&nbsp; </td>
    <td align="center">&nbsp; </td>
    <td align="center">&nbsp; </td>
	<td align="center"> </td>
	<td align="center"> </td>
  </tr>
  <?
endif;
?>  
  <tr bgcolor="#FFFFFF">
    <td width="30" align="center" bgcolor="#FFFFFF"><script>nhnButton('삭제','black9','javascript:deletefnc();',4,0,'#565656','#FFFFFF','#C4C4C4','#ffffff','#ffffff','#ffffff')</script></td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
	<td align="center"> </td>
	<td align="center"> </td>
  </tr>
</form>
</table>
<br>
<table cellspacing=1 bordercolordark=white width="100%" bgcolor=#c0c0c0 bordercolorlight=#dddddd border=0 class="s1">
  <tr bgcolor="#FFFFFF"> 
    <td width="90%" height="25" align="center">
      <?
include "./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/index.php";
?>
    </td>
    <td width="10%" height="25" align="right"> 
<?
if ($_COOKIE[BOARD_PASS] || $_COOKIE[ROOT_PASS] || $cfg["wizboard"]["AdminOnly"] != "yes") :
echo $board->showBoardIcon('write');
endif;
?>
    </td>
  </tr>
</table>

<br>
<table cellspacing=1 bordercolordark=white width="100%" bgcolor=#c0c0c0 bordercolorlight=#dddddd border=0 class="s1">
  <script language="JavaScript">
<!--
function search(){
var f=document.SEARCH_FORM;
  if(f.searchkeyword.value == ''){
  alert('검색어를 입력해주세요');
  f.searchkeyword.focus();
  } else { f.submit(); }
 }
//-->
</script>
<!--
  <FORM NAME="SEARCH_FORM" ACTION="<?$PHP_SELF?>" METHOD="GET">
    <input type="hidden" name="BID" value="<?=$BID?>" >
    <input type="hidden" name="category" value="<?=$category?>">
    <tr> 
      <td width="100%" align="center" bgcolor="#FFFFFF"> <select style="border:0 solid #88CFD6; background-color=FFFFFF ; font-size:9pt; color:#6666666; width:90px;" maxlength="150" onBlur= "" name="search_term">
          <option value="<?=60*60*24*7?>"<? if($search_term == 60*60*24*7 ) echo " selected";?>>최근한주</option>
          <option value="<?=60*60*24*7*2?>"<? if($search_term == 60*60*24*7*2 ) echo " selected";?>>최근두주</option>
          <option value="<?=60*60*24*30?>"<? if($search_term == 60*60*24*30 ) echo " selected";?>>한달</option>
          <option value=""<? if(!$search_term) echo " selected";?>>전체</option>
        </select> <select name="SEARCHTITLE">
          <option value="SUBJECT"<? if($SEARCHTITLE == "SUBJECT" ) echo " selected";?>>제 
          목</option>
          <option value="NAME"<? if($SEARCHTITLE == "NAME" ) echo " selected";?>>글쓴이</option>
          <option value="CONTENTS"<? if($SEARCHTITLE == "CONTENTS" ) echo " selected";?>>내 
          용</option>
        </select> <input type="text" name="searchkeyword" size="20" value="<? echo $searchkeyword; ?>"> 
        <img src="./wizboard/icon/<?=$ICON_SKIN_TYPE;?>/search_btn.gif" align="absmiddle" onclick="javascript:search();" style="cursor:pointer"; alt="검색(searching)"> 
      </td>
    </tr>
  </FORM>
</table> -->
