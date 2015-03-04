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

$tablename="wizbanner";
if(!$flag1) $flag1 = "main";
/******************************************************************************/

if ($query == 'qde') {   //삭제옵션시 실행
	while (list($key,$value) = each($_GET)) {
		if(ereg("deleteItem", $key)) {
			$VIEW_QUERY = "SELECT * FROM $tablename WHERE uid='$value'";
			$list = $dbcon->_fetch_array($dbcon->_query($VIEW_QUERY));
			$Loaded = explode("|", $list["UPDIR1"]);
			for($i=0; $i<sizeof($Loaded); $i++){
				if (is_file("../wizstock/$Loaded[$i]") && $Loaded[$i]) {
					unlink("../wizstock/$Loaded[$i]");
				}
			}
			$dbcon->_query("DELETE FROM $tablename WHERE uid=$value");
		}
	} 
}else if($smode == "qde"){ //삭제옵션 끝
			$VIEW_QUERY = "SELECT * FROM $tablename WHERE uid='$uid'";
			$list = $dbcon->_fetch_array($dbcon->_query($VIEW_QUERY));
			$Loaded = explode("|", $list["UPDIR1"]);
			for($i=0; $i<sizeof($Loaded); $i++){
				if (is_file("../wizstock/$Loaded[$i]") && $Loaded[$i]) {
					unlink("../wizstock/$Loaded[$i]");
				}
			}
			$dbcon->_query("DELETE FROM $tablename WHERE uid=$uid");
}
//include "../wizboard/func/STR_CUTTING_FUNC.php";
$whereis = "WHERE uid <> '0' and flag1 = '$flag1'";
/* 총 갯수 구하기 */
$TOTAL_STR = "SELECT count(uid) FROM $tablename $whereis";
$TOTAL = $dbcon->get_one($TOTAL_STR);
$ListNo=10; /* 페이지당 출력 리스트 수 */
$PageNo=10; /* 페이지 밑의 출력 수 */
if(empty($sub_cp) || $sub_cp <= 0) $sub_cp = 1;

?>
<script>
$(function(){
	$(".btn_click").click(function(i){
		$(".submenu").hide();
		$(".submenu").eq($(".btn_click").index(this)).show(); //메서드
	});
	
	$(".btn_delete").click(function(){
		var uid = $(this).attr("uid");
		location.href="<?=$PHP_SELF;?>?menushow=<?=$menushow?>&theme=<?=$theme?>&smode=qde&uid="+uid
	});
});

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

function gotoWrite(flag, uid){
	if (uid == undefined) uid = "";
	location.href="<?=$PHP_SELF?>?menushow=<?=$menushow?>&theme=basicconfig/main01_write&flag1="+flag+"&mode=qup&uid="+uid;
}
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">메인베너관리</div>
	  <div class="panel-body">
		 order가 작은 순서가 상위에 위치합니다.</br>
		 하기의 각 베너 타이틀을 클릭하신 후 등록/수정 가능하십니다.</br>
		 추가 베너가 필요하신 경우 /config/common_array.php에서 $banner_cat를 변경하시면 됩니다.
	  </div>
	</div>
	
	<div class="panel panel-default">
<?php

foreach($banner_cat as $key=>$value){ 
$orderby = "ordernum@asc";
$whereis = " where flag1 = $key";
?>
		<div class="panel-heading btn_click">
			<?=$value["pos"]?>(그룹코드 :<?=$key?>)
		</div>
		<table class="table submenu" style="display:none">
			<col width="50px" />
			<col width="*" />
			<col width="*" />
			<col width="80px" />
			<col width="80px" />
			<tr>
				<th>order</th>
				<th>url</th>
				<th>이미지</th>
				<th>수정</th>
				<th>삭제</th>
			</tr>
<?php
$qry = $dbcon->get_select('*',$tablename,$whereis, $orderby);	
while($list=$dbcon->_fetch_array($qry)):
extract($list);
?>
			<tr>
				<td><?=$ordernum;?></td>
				<td><?=$url;?></td>
				<td><img src="../config/banner/<?=$attached?>"> </td>
				<td><span class="button bull"><a href="javascript:gotoWrite(<?=$key?>, <?=$uid?>)">수정</a></span></td>
				<td><span class="btn_delete button bull" uid="<?=$uid?>"><a>삭제</a></span></td>
			</tr>
<?php
endwhile;
?>

		</table>
<?php
}
?>
	</div>

</div>

