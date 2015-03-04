<?
/* 
제작자 : 폰돌
스킨 : wizboard list skin 
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
?>   
 <SCRIPT language=JavaScript>
	<!--
	
	var old_menu = '';
	function board_menuclick(submenu)
	{
	  if( old_menu != submenu ) {
	    if( old_menu !='' ) {
	      old_menu.style.display = 'none';
	    }
	    submenu.style.display = 'block';
	    old_menu = submenu;
	
	  } else {
	    submenu.style.display = 'none';
	    old_menu = '';
	  }
	}
	
-->
</SCRIPT>
    
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
  <tr> 
<? if($CategoryEnable): //분류가 있으면?>  
   <FORM name="categoryselect" ACTION="<?$PHP_SELF?>" METHOD="POST">
 <input type="hidden" name="BID" value="<?=$BID?>" >
 <input type="hidden" name="GID" value="<?=$GID?>" >
    <td><?
$catstr = "select ordernum, catname, uid from wizTable_Category where gid = '$GID' and bid = '$BID' order by ordernum asc";
$catqry = $dbcon->_query($catstr);	
	echo "<select name='category' style='BACKGROUND-COLOR: #FFFFFF; BORDER: #D0D0D0 1 solid; font-family:돋움; font-size:11px; color:#5E5E5E; HEIGHT: 19px; width: 70px' value='25' onChange='document.categoryselect.submit()';>";
	echo "<option value=''>카테고리선택</option>";
		while($catlist = $dbcon->_fetch_array($catqry)):
			$ordernum = $catlist["ordernum"];
			$catname = $catlist["catname"];
			$selected = $LIST[BID] == $ordernum?"selected":"";
			$categoryname[$ordernum] = $catname;
			echo "<option value=\"".$ordernum."\" ${selected}>".$catname."</option>";
		endwhile;
	echo "</select>";
?></td>
</form>
<? endif; ?>
    <td align="right"><font color="#000000">Page 
      <?=$board->page_var["cp"]?>
      /
      <?=$board->page_var["tp"]?>
      </font></td>
  </tr>
</table>
            
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
  <tr bgcolor="<?=$Linecolor?>"> 
    <td height="3"></td>
    <td height="3"></td>
    <td height="3"></td>
  </tr>
 <tr align="center" bgcolor="<?=$Bgcolort?>"> 
    <td height="27" width="30"><font color="<?=$Fontcolort?>">번호</font></td>
    <td height="27"><font color="<?=$Fontcolort?>">제목</font></td>
    <td height="27" width="30" align="center"><font color="<?=$Fontcolort?>">조회</font></td>
  </tr>
  <tr bgcolor="<?=$Linecolor?>"> 
    <td height="1"></td>
    <td height="1"></td>
    <td height="1"></td>
  </tr>
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
  <tr bgcolor="<?=$Bgcolorl?>"> 
    <td width="30" align="center"> 
      <font color="<?=$Fontcolort?>"><?=$board->ini_board_no;?></font>    </td>
    <td> 
<A href="javascript:board_menuclick(submenu<?=$board->ini_board_no;?>)" style="CURSOR: pointer"> 
	  <?=$list["print_subject"]?>
      </a> 
	   <? echo $SecretImg; echo $NewWriteImg; ?>
<?   
if($adminmode == "true" or $_COOKIE["ROOT_ID"]){
?>
<a href="<?=$PHP_SELF?>?getdata=<?=$getdata?>" style="TEXT-DECORATION: none; COLOR: #777777;">
[보기]</a>
 <a href="javascript:DELETE_THIS('<?=$list["UID"];?>','<?=$cp;?>','<?=$BID;?>','<?=$GID;?>','<?=$adminmode?>'); "style="TEXT-DECORATION: none; COLOR: #777777;">[삭제]</a>
    
<?
}
?>
 </td>
    <td width="30" align="center"> 
      <font color="<?=$Fontcolort?>"><?=$list["COUNT"];?></font>    </td>
  </tr>
  <tr bgcolor="<?=$Bgcolorl?>" id="submenu<?=$board->ini_board_no;?>" style="DISPLAY: none"> 
    <td width="30" align="center"> 
      <font color="<?=$Fontcolort?>">A</font>    </td>
    <td> 
<?
for($i=0; $i < count($list["viewAttachedImg"]); $i++){
?>
      <table width="100%" border="0" cellspacing="5">
        <tr>
          <td><?=$list["viewAttachedImg"][$i]?>
          </td>
        </tr>
      </table>
      <?
}
?>
      <font color="<?=$Fontcolorl?>" style="word-break:break-all;">
      <?=$list["CONTENTS"];?>
      </font> </td>
    <td width="30" align="center"> 
      <font color="<?=$Fontcolort?>"><?=$list["COUNT"];?></font>    </td>
  </tr>  
<?
$board->ini_board_no--;
$cnt++;
endwhile;
if(!$board->page_var["tc"]):/* 게시물이 존재하지 않을 경우 */
?>
  <tr bgcolor="<?=$Bgcolorl?>"> 
    <td align="center">&nbsp; </td>
    <td> 등록된 글이 없습니다.</td>
    <td align="center">&nbsp; </td>
  </tr>
<?
endif;
?>
</table>
            
<br>
            
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family: '굴림', '돋움','Arial';font-size: 12px; color:#666666;line-height:140%">
  <tr> 
                <td bgcolor="<?=$Linecolor?>" height="1" colspan="2"></td>
  </tr>
              <tr> 
                
    <td align="center" height="25" width="90%"> 
<?
include "./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/index.php";
?>
    </td>
                
    <td align="right" height="25" width="10%">
<?
if ($_COOKIE[BOARD_PASS] || $_COOKIE[ROOT_PASS] || $cfg["wizboard"]["AdminOnly"] != "yes") :
echo $board->showBoardIcon('write');
endif;
?>    
	</td>
              </tr>
              <tr> 
                <td bgcolor="BEBEBE" height="1" colspan="2"></td>
              </tr>
</table>
            
<table width="100%" border="0" cellspacing="0" cellpadding="2" height="30" bgcolor="<?=$Bgcolors?>">
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
                <td width="100%" align="center">  <select style="border:0 solid #88CFD6; background-color=FFFFFF ; font-size:9pt; color:#6666666; width:90px;" maxlength="150" onBlur= "" name="search_term">
          <option value="<?=60*60*24*7?>"<? if($search_term == 60*60*24*7 ) echo " selected";?>>최근한주</option>
          <option value="<?=60*60*24*7*2?>"<? if($search_term == 60*60*24*7*2 ) echo " selected";?>>최근두주</option>
          <option value="<?=60*60*24*30?>"<? if($search_term == 60*60*24*30 ) echo " selected";?>>한달</option>
          <option value=""<? if(!$search_term) echo " selected";?>>전체</option>
        </select> <select name="SEARCHTITLE" checkenable msg="검색범위를 선택해주세요">
          <option value=""<? if($SEARCHTITLE == "" ) echo " selected";?>>전체</option>
          <option value="SUBJECT"<? if($SEARCHTITLE == "SUBJECT" ) echo " selected";?>>제 
          목</option>
          <option value="NAME"<? if($SEARCHTITLE == "NAME" ) echo " selected";?>>글쓴이</option>
          <option value="CONTENTS"<? if($SEARCHTITLE == "CONTENTS" ) echo " selected";?>>내 
          용</option>
        </select> <input type="text" name="searchkeyword" size="20" value="<? echo $searchkeyword; ?>" checkenable msg="키워드를 입력하세요"> 
        <input type="image" src="./wizboard/icon/<?=$cfg["wizboard"]["ICON_SKIN_TYPE"];?>/search_btn.gif" align="absmiddle" alt="검색(searching)" /> 
                </td>
              </tr>
</FORM>			  
</table>
