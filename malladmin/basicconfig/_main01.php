<?php
#CREATE TABLE `wizbanner` (
#  `uid` int(11) NOT NULL auto_increment,
#  `flag1` varchar(10) NOT NULL default '',
#  `ordernum` int(5) NOT NULL default '0',
#  `url` varchar(50) NOT NULL default '',
#  `target` varchar(20) NOT NULL default 'root',
#  `attached` varchar(250) NOT NULL default '',
#  `wdate` int(13) NOT NULL default '0',
#  PRIMARY KEY  (`uid`)
#) TYPE=MyISAM AUTO_INCREMENT=1 ;

$BOARD_NAME="wizbanner";
if(!$flag1) $flag1 = "main";
/******************************************************************************/

if ($query == 'delete') {   //삭제옵션시 실행
while (list($key,$value) = each($_GET)) {
        if(ereg("deleteItem", $key)) {
                $VIEW_QUERY = "SELECT * FROM $BOARD_NAME WHERE uid='$value'";
                $list = $dbcon->_fetch_array($dbcon->_query($VIEW_QUERY));
				$Loaded = explode("|", $list[UPDIR1]);
				for($i=0; $i<sizeof($Loaded); $i++){
               	 if (is_file("../wizstock/$Loaded[$i]") && $Loaded[$i]) {
                  	      unlink("../wizstock/$Loaded[$i]");
				 }
                }
                $dbcon->_query("DELETE FROM $BOARD_NAME WHERE uid=$value");
        }
} 
} //삭제옵션 끝

//include "../wizboard/func/STR_CUTTING_FUNC.php";
$whereis = "WHERE uid <> '0' and flag1 = '$flag1'";
/* 총 갯수 구하기 */
$TOTAL_STR = "SELECT count(uid) FROM $BOARD_NAME $whereis";
$TOTAL = $dbcon->get_one($TOTAL_STR);
$ListNo=10; /* 페이지당 출력 리스트 수 */
$PageNo=10; /* 페이지 밑의 출력 수 */
if(empty($SUB_cp) || $SUB_cp <= 0) $SUB_cp = 1;

?>
<SCRIPT LANGUAGE=javascript>
function deletefnc(){
        var f = document.forms.BrdList;
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
        if (confirm('\n\n삭제하는 게시물은 복구가 불가능합니다!!! \n\n정말로 삭제하시겠습니까?\n\n')) return true;
        return false;
}
</SCRIPT>

<table  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="8"></td>
    <td height="8"></td>
  </tr>
  <tr>
    <td></td>
    <td valign="top"><table class="table_title">
        <tr>
          <td bgcolor="#FFFFFF"><b><font color="#FF6600">메인베너관리</font></b></td>
        </tr>
        <tr>
          <td height="53" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="s1">
              <tr>
                <td width="70" align="center" valign="top"><font color=#ff6600>[note]</font></td>
                <td>order가 작은 순서가 상위에 위치합니다.</td>
              </tr>
            </table></td>
        </tr>
      </table>
      <br />
<table class="table">
          <tr align="center" bgcolor="E0E4E8">
            <td width="100">베너위치</td>
            <td>&nbsp;</td>
          </tr>
<? 
foreach($banner_cat as $key=>$value){ 
?>
          <tr bgcolor="#FFFFFF">
            <td colspan="2" align="center"><?=$value?></td>
          </tr>
          <tr align="center" bgcolor="F2F2F2">
            <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="5%" align="center"><input type="image" style="cursor:hand" src="img/del02.gif" align="middle" width="53" height="20">                  </td>
                  <td width="95%"><a href="<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=basicconfig/main01_write&flag1=<?=$flag1?>&mode=insert"><img src="img/dung.gif" width="55" height="20" border="0" align="absmiddle"></a></td>
                </tr>
              </table></td>
          </tr>
<?
}
?>
      </table>      
      <table class="table">
        <form action="<?=$PHP_SELF?>" Name="BrdList" onsubmit='return deletefnc()'>
          <input type='hidden' name='menushow' value='<?=$menushow?>'>
          <input type="hidden" name="theme" value="<?=$theme;?>">
          <input type="hidden" name="cp" value="<?=$cp?>">
          <input type="hidden" name="SUB_cp" value="<?=$SUB_cp?>">
          <input type="hidden" name="query" value="delete">
          <input type="hidden" name="flag1" value="<?=$flag1?>">
          <tr align="center" bgcolor="E0E4E8">
            <td width="30">삭제</td>
            <td width="50">order</td>
            <td>url</td>
            <td width="150">이미지</td>
            <td width="70" bgcolor="E0E4E8">수정</td>
          </tr>
          <? 
$START_NO = ($SUB_cp - 1) * $ListNo;
$BOARD_NO=$TOTAL-($ListNo*($SUB_cp-1));
$orderby = "uid@DESC";
$qry = $dbcon->get_select('*',$BOARD_NAME,$whereis, $orderby, $START_NO, $ListNo);	
while($list=$dbcon->_fetch_array($qry)):
extract($list);
?>
          <tr bgcolor="#FFFFFF">
            <td align="center"><input type="checkbox" name="deleteItem_<?=$uid?>" value="<?=$uid?>">
            </td>
            <td align="center"><?=$ordernum;?>
            </td>
            <td><?=$url;?></td>
            <td align="center"><img src="../config/banner/<?=$attached?>" width=100> </td>
            <td align="center"><a href="<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=basicconfig/main01_write&flag1=<?=$flag1?>&mode=update&uid=<?=$uid;?>"><img src="img/su.gif" width="53" height="20" border="0" /></a></td>
          </tr>
          <?
$BOARD_NO--;
endwhile;
?>
          <tr align="center" bgcolor="F2F2F2">
            <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="5%" align="center"><input type="image" style="cursor:hand" src="img/del02.gif" align="middle" width="53" height="20">
                  </td>
                  <td width="95%"><a href="<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=basicconfig/main01_write&flag1=<?=$flag1?>&mode=insert"><img src="img/dung.gif" width="55" height="20" border="0" align="absmiddle"></a></td>
                </tr>
              </table></td>
          </tr>
        </form>
      </table>
      <table width="760" border="0" cellpadding="0" cellspacing="0" class="s1">
        <tr>
          <td align="center"><?
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
$page_arg1 = $PHP_SELF."?menushow=$menushow&theme=$theme&flag1=$flag1&cp=$cp&SEARCHTITLE=$SEARCHTITLE&searchkeyword=".urlencode($searchkeyword);
$page_arg2 = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL); 
$page_arg3 = array("pre"=>"./img/pre.gif","next"=>"./img/next.gif");
echo $common->paging($page_arg1,$page_arg2,$page_arg3);
?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
