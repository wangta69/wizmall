<?php
/* 

제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/

/* 인자의  Valid 여부 check */
$BOARD_NAME="wizTable_".$AdminGID."_".$AdminBID;
/******************************************************************************/
if ( !$AdminBID || !is_dir("../config/wizboard/table/".$AdminGID."/".$AdminBID) )
{

   echo  "<script>window.alert('\\n\\n존재하지 않는 보드입니다.\\n\\n');
   history.go(-1);</script>";
   exit;
}

if ($query == 'delete') {   //삭제옵션시 실행
	while (list($key,$value) = each($deleteItem)) {
		$VIEW_QUERY = "SELECT * FROM ".$BOARD_NAME." WHERE UID=".$key;
		$list = $dbcon->_fetch_array($dbcon->_query($VIEW_QUERY));
		$Loaded = split("\|", $list["UPDIR1"]);
			for($i=0; $i<sizeof($Loaded); $i++){
				if (is_file("../config/wizboard/table/".$AdminGID."/".$AdminBID."/updir/".$Loaded[$i]) && $Loaded[$i]) {
				unlink("../config/wizboard/table/".$AdminGID."/".$AdminBID."/updir/".$Loaded[$i]);
				}
			}
		$dbcon->_query("DELETE FROM ".$BOARD_NAME." WHERE UID=".$key);
	} 
} //삭제옵션 끝


$whereis = "WHERE UID <> 0";
/* 검색 키워드 및 WHERE 구하기 */
//if($SEARCHTITLE && $searchkeyword){
//$whereis = "WHERE $SEARCHTITLE LIKE '%$searchkeyword%'";
//}
/* 총 갯수 구하기 */
$TOTAL_STR = "SELECT count(UID) FROM ".$BOARD_NAME." ".$whereis;
$TOTAL = $dbcon->get_one($TOTAL_STR);
$LIST_NO=10; /* 페이지당 출력 리스트 수 */
$PageNo=10; /* 페이지 밑의 출력 수 */
if(empty($SUB_cp) || $SUB_cp <= 0) $SUB_cp = 1;
//--페이지링크를 작성하기--
?>
<SCRIPT LANGUAGE=javascript>
<!--
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

function modify_colum(bid,uid,columname){
window.open('./colum_mod.php?bid='+bid+'&uid='+uid+'&colum='+columname,'ColumModifyWindow','width=500, height=500');
}
//-->
</SCRIPT>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="s1">
  <tr>
    <td><b>
      <?php echo $AdminBID;?>
      </b> 테이블 리스트입니다. </td>
  </tr>
</table>
<table cellspacing=1 bordercolordark=white width="100%" bgcolor=#c0c0c0 bordercolorlight=#dddddd border=0 class="s1">
  <form action="<?php echo $PHP_SELF?>" Name="BrdList" onsubmit='return deletefnc()'>
    <input type="hidden" name="AdminBID" value="<?php echo $AdminBID?>">
    <input type="hidden" name="AdminGID" value="<?php echo $AdminGID?>">
    <input type="hidden" name="menu7" value="show">
    <input type="hidden" name="THEME" value="boardadmin">
    <input type="hidden" name="cp" value="<?php echo $cp?>">
    <input type="hidden" name="SUB_cp" value="<?php echo $SUB_cp?>">
    <input type="hidden" name="CP" value="<?php echo $CP?>">
    <input type="hidden" name="ListCount" value="<?php echo $ListCount?>">
    <input type="hidden" name="query" value="delete">
    <tr align="center" bgcolor="F2F2F2">
      <td bgcolor="E0E4E8"></td>
      <td bgcolor="#B9C2CC">NO.</td>
      <td bgcolor="E0E4E8">제목</td>
      <td bgcolor="#B9C2CC">글쓴이</td>
      <td bgcolor="E0E4E8">등록일</td>
      <td bgcolor="#B9C2CC">조회수</td>
      <td bgcolor="E0E4E8">추천수</td>
      <td bgcolor="#B9C2CC">수정</td>
    </tr>
<?php 
$START_NO = ($SUB_cp - 1) * $LIST_NO;
$BOARD_NO=$TOTAL-($LIST_NO*($SUB_cp-1));

$orderby = "order by  FID DESC, THREAD ASC, UID DESC";
$dbcon->get_select('*',$BOARD_NAME,$whereis, $orderby, $START_NO, $ListNo);
while( $list = $dbcon->_fetch_array()) :
	$list["SUBJECT"]=stripslashes($list["SUBJECT"]);
	$list["W_DATE"] = ereg_replace("\-",".",$list["W_DATE"]);
	/* REPLY에 이미지가 있을 경우 아래 방법을 사용합니다. */
	$IMGNUM=strlen($list["THREAD"])-1;
	$SPACE="";
	for($i=0; $i<$IMGNUM-1; $i++){
	$SPACE .="&nbsp;&nbsp;";
	}
?>
    <tr bgcolor="#FFFFFF">
      <td align="center"><input type="checkbox" name="deleteItem[<?php echo $list["UID"]?>]" value="<?php echo $list["UID"]?>">
      </td>
      <td align="center"><?php echo $BOARD_NO;?>
      </td>
      <td><?php if($IMGNUM){ echo $SPACE." Re_";} ?>
        <a href="javascript:void(window.open('../wizboard.php?BID=<?php echo $AdminBID;?>&mode=view&UID=<?php echo $list["UID"];?>&SUB_cp=<?php echo $SUB_cp;?>&BOARD_NO=<?php echo $BOARD_NO;?>&Goto=<?php echo $PHP_SELF?>','BoardViewWindow',''))"> <font color="#000000">
        <?php echo $list["SUBJECT"];?>
        </font> </a></td>
      <td align="center"><?php echo $list["NAME"];?>
      </td>
      <td align="center"><a href="javascript:;" onClick="modify_colum('<?php echo $AdminBID;?>','<?php echo $list["UID"]?>','W_DATE')">
        <?php echo date("Y.m.d",$list["W_DATE"]);?>
        </a> </td>
      <td align="center"><?php echo $list["COUNT"];?>
      </td>
      <td align="center"><?php echo $list["RECCOUNT"];?>
      </td>
      <td align="center"><img src="images/su.gif" width="53" height="20" border="0" onClick="javascript:window.open('../wizboard.php?BID=<?php echo $AdminBID?>&GID=<?php echo $AdminGID?>&mode=modify&UID=<?php echo $list["UID"];?>&category=<?php echo $list[BID];?>&SUB_cp=<?php echo $SUB_cp;?>','수정모드','');" style="cursor:pointer";> </td>
    </tr>
<?php
$BOARD_NO--;
endwhile;
?>
    <tr align="center" bgcolor="F2F2F2">
      <td colspan="8"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="5%" align="center"><input type="image" style="cursor:pointer" src="images/del02.gif" align="middle" width="53" height="20">
            </td>
            <td width="95%" bgcolor="E0E4E8"><img src="images/dung.gif" width="55" height="20" align="absmiddle" style="cursor:pointer" onClick="javascript:window.open('../wizboard.php?BID=<?php echo $AdminBID?>&GID=<?php echo $AdminGID?>&mode=write','WRITEMODE','');";></td>
          </tr>
        </table></td>
    </tr>
  </form>
</table>
</td>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="s1">
  <tr>
    <td align="center">
	
<?php
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
$page_arg1 = $PHP_SELF."?AdminBID=".$AdminBID."&AdminGID=".$AdminGID."&menu7=show&THEME=boardadmin&cp=".$cp."&SEARCHTITLE=".$SEARCHTITLE."&searchkeyword=".$searchkeyword;
$page_arg2 = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL); 
//$page_arg3 = array("pre"=>"./img/pre.gif","next"=>"./img/next.gif");
echo $common->paging($page_arg1,$page_arg2,$page_arg3);
?>
    </td>
  </tr>
</table>