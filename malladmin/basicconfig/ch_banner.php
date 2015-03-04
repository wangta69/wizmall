<?
#CREATE TABLE `wizbanner` (
#  `uid` int(11) NOT NULL auto_increment,
#  `flag1` varchar(10) NOT NULL default '',
#  `ordernum` int(5) NOT NULL default '0',
#  `url` varchar(50) NOT NULL default '',
#  `target` varchar(20) NOT NULL default 'root',
#  `attached` varchar(250) NOT NULL default '',
#  `wdate` int(13) NOT NULL default '0',
#  PRIMARY KEY  (`uid`)
#) type=MyISAM AUTO_INCREMENT=1 ;

$BOARD_name="wizbanner";
if(!$flag1) $flag1 = "main";
$path = "../config/banner/";
/******************************************************************************/

if($smode="qde"){
	//파일삭제
	$sqlstr = "select attached from wizbanner where uid = '$uid'";
	$attached = $dbcon->get_one($sqlstr);
	$common->delallfile($path, $attached);//thumb 파일이 있을 경우 thumb 파일 까지 삭제
	
	//데이타 삭제
	$sqlstr = "delete from wizbanner where uid = '$uid'";
	$dbcon->_query($sqlstr);
}


if ($query == 'qde') {   //삭제옵션시 실행
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
<script LANGUAGE=javascript>
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


var old_menu = '';
function menuclick(submenu)
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

function gotoWrite(flag, uid){
	if (uid == undefined) uid = "";
	location.href="<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=basicconfig/ch_banner_write&flag1="+flag+"&mode=qup&uid="+uid;
}

function del_cfm(uid){
	if(confirm('삭제된 데이타는 복구되지 않습니다.\n삭제하시겠습니까?')){
		location.href="<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=<?=$theme?>&flag1=<?=$flag1?>&smode=qde&uid="+uid;
	}
}

function chflag(uid, v){
	$.post("../../lib/ajax.admin.php", {smode:"chflag",uid:uid}, function (data){
		//var result=data.split("|");
		var result = data;
		if(result == 1) v.innerHTML = "출력";
		else v.innerHTML = "<font color='red'>미출력";
	});
}
-->
</script>

<table class="table_outline">
  <tr>
    <td><fieldset class="desc">
      <legend>베너관리[
      <?=$banner_cat[$flag1]?>
      ]</legend>
      <div class="notice">[note]</div>
      <div class="comment"> order가 작은 순서가 상위에 위치합니다.</div>
      </fieldset>
      <div class="space20"></div>
      <table class="table">
        <tr>
          <th>번호</th>
          <th>이미지</th>
          <th>제목/주소</th>
          <th>등록일</th>
          <th>관리</th>
        </tr>
        <? 
$orderby = "wdate@desc";
$whereis = " where flag1 = $flag1";
if($keyword && $stitle) $whereis .= " and $stitle like '%".$keyword."%'";
$sqlstr = "select count(uid) from $BOARD_NAME $whereis";
$TOTAL = $dbcon->get_one($sqlstr);
$NO = $TOTAL-($ListNo*($cp-1));
$qry = $dbcon->get_select('*',$BOARD_NAME,$whereis, $orderby);	
while($list=$dbcon->_fetch_array($qry)):
extract($list);
if($showflag == "1") $showflagstr = "출력";
else $showflagstr = "<font color='red'>미출력";
?>
        <tr>
          <td>&nbsp;
            <?=$NO?></td>
          <td>&nbsp;<img src="../config/banner/<?=$attached?>"> </td>
          <td><?=$subject;?><p></p>
		  <?=$url;?></td>
          <td><?=date("Y.m.d", $wdate);?></td>
          <td><button type="button" id="dp_btn" name="dp_btn" style="cursor:pointer" onclick="chflag(<?=$uid?>, this)"><?=$showflagstr?></button>
          <br />
            <input type="button" name="button2" id="button2" value="수정" style="cursor:pointer" onclick="gotoWrite(<?=$flag1?>, <?=$uid?>)" />
            <br />
          <input type="button" name="button3" id="button3" value="삭제" style="cursor:pointer" onclick="del_cfm(<?=$uid?>)" /></td>
        </tr>
        <?
$NO--;		
endwhile;
?>
      </table>
      <div class="space10"></div>
      <div class="paging_box1"><?
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
$page_arg1 = $PHP_SELF."?menushow=$menushow&theme=$theme&flag1=$flag1&stitle=$stitle&keyword=".urlencode($keyword);
$page_arg2 = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL); 
$page_arg3 = array("pre"=>"./img/pre.gif","next"=>"./img/next.gif");
echo $common->paging($page_arg1,$page_arg2,$page_arg3);
?></div>
    <div class="btn_box1"><a href="javascript:gotoWrite(<?=$flag1?>)"><img src="img/dung.gif"></a></div>
    <form>
    <input type="hidden" name="stitle" value="subject" />
    <input type="hidden" name="menushow" value="<?=$menushow?>" />
    <input type="hidden" name="theme" value="<?=$theme?>" />
     <input type="hidden" name="flag1" value="<?=$flag1?>" />
    <div>제목
      <input type="text" name="keyword" id="keyword" />
      <input type="submit" name="button" id="button" value="검색" />
    </div>
    </form>
    </td>
  </tr>
</table>
