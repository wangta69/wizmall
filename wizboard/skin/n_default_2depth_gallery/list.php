<?
/* 
제작자 : 폰돌
스킨 : wizboard list skin 
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td align="center"> 
      <!-- ##################board list 테이블시작입니다##########################-->
        <form NAME="board_search" action="<?php echo $PHP_SELF?>" mehtod="POST" onsubmit="return boardSearch(this)">
    <input type="hidden" name="BID" value="<?php echo $BID?>" >
    <input type="hidden" name="GID" value="<?php echo $GID?>" >
    <input type="hidden" name="adminmode" value="<?php echo $adminmode?>">
    <input type="hidden" name="optionmode" value="<?php echo $optionmode?>">
    <input type="hidden" name="category" value="<?php echo $category?>">
    <input type="hidden" name="mode" value="<?php echo $mode?>">
    <input type="hidden" name="UID" value="<?php echo $UID?>">
    <input type="hidden" name="cp" value="<?php echo $cp?>">    
        <table width="100%" height="35" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center">&nbsp;</td>
            <td width="270" align="center"><table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><select name="SEARCHTITLE" >
        <!--<select name="SEARCHTITLE" checkenable msg="검색범위를 선택해주세요">-->
          <option value=""<?php if($SEARCHTITLE == "" ) echo " selected";?>>전체</option>
          <option value="SUBJECT"<?php if($SEARCHTITLE == "SUBJECT" ) echo " selected";?>>제 
          목</option>
          <option value="NAME"<?php if($SEARCHTITLE == "NAME" ) echo " selected";?>>글쓴이</option>
          <option value="CONTENTS"<?php if($SEARCHTITLE == "CONTENTS" ) echo " selected";?>>내 
          용</option>
        </select></td>
                  <td><input type="text" name="searchkeyword" size="20" value="<?php echo $searchkeyword; ?>" checkenable msg="키워드를 입력하세요"></td>
                  <td><input type="image" src="./wizboard/icon/<?php echo $cfg["wizboard"]["ICON_SKIN_TYPE"];?>/search_btn.gif" align="absmiddle" alt="검색(searching)" /></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center"></td>
            <td height="5" align="right"></td>
          </tr>
        </table>
      </FORM>
<!-- Image Table Start -->	  
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr align="center" valign="top">
<?php
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
	<td width="176"><table width="160" height="119" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" class="bd1" style="padding:3px;"><a href="<?php echo $PHP_SELF?>?getdata=<?php echo $getdata?>"><img src="<?php echo $common->getthumbimg($filepath, $list["attached"][0], 150, 113) ?>" width="150" height="113" border="0"></a></td>
        </tr>
      </table>
      <table width="160" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td height="10" colspan="2"></td>
        </tr>
        <tr class="ft2">
          <td width="40" height="25" align="center" bgcolor="#E8E8E8" class="ft2 style3">제목</td>
          <td height="25"  width="115" bgcolor="#F3F3F3" class="dot"><a href="<?php echo $PHP_SELF?>?getdata=<?php echo $getdata?>" style="TEXT-DECORATION: none;">
      <?php echo $list["print_subject"]?>
      </a></td>
        </tr>
      </table></td>
<?php
$board->ini_board_no--;
$cnt++;
if($cnt%3) echo "";
if(!($cnt%3) && $cnt != $TOTAL) echo"</tr><tr align='center' valign='top'><td colspan='3'>&nbsp;</td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='0'><tr align='center' valign='top'>";
endwhile;
$tmpcnt = $cnt%3;
for($i=$tmpcnt; $i<3; $i++){
	echo "<td width='176'></td>";
}

if(!$board->page_var["tc"]):/* 게시물이 존재하지 않을 경우 */

endif;
?>      
	  
  </tr>

</table>
<!-- Img Table End -->
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
          <td align="right"><?
echo $board->showBoardIcon('list', 1);
?>

<?
echo $board->showBoardIcon('write');
?></td>
        </tr>
      </table></td>
  </tr>
</table>