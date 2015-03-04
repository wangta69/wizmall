<?php
/* 
제작자 : 폰돌
제작자 URL : http://www.shop-wiz.com
제작자 Email : master@shop-wiz.com
Free Distributer 
- http://www.shop-wiz.com
*** Updating List ***
*/

include "../lib/inc.depth1.php";
include "../lib/class.board.admin.php";
$boardadm = new boardadm();
$boardadm->dbcon = $dbcon;
$boardadm->common = $common;

include("./admin_check.php");


if ($query == 'update') {    
	foreach($Newcatname as $key => $value){
		unset($ups);
		$ups["catname"]	= $value;
		$dbcon->updateData("wizTable_Category", $ups, "uid=".$key);
	}
}else if ($query == 'move') {
	$TableName = "wizTable_".$GID."_".$BID;

	foreach($Newcatname as $key => $value){
		if($value){
			unset($ups);
			$ups["CATEGORY"]	= $value;
			print_r($ups["CATEGORY"]);
			//exit;
			//$dbcon->updateData($TableName, $ups, "CATEGORY=".$key);
		}
	}

	exit;
}else if($query=="OptionPageChange"){
	include ("./configwrite.php");
}else if($query == "emp_input"){
	$op_icon	= $op_icon;
	$op_strong	= $op_strong ? $op_strong : 0;
	$op_color = $op_color;
	$op_em = $op_em ? $op_em : 0;
	$opflag = $op_icon."|".$op_strong."|".$op_color."|".$op_em;
	
	unset($ins);
	$ins["bid"]		= $BID;
	$ins["gid"]		= $GID;
	$ins["point"]	= $point;
	$ins["opflag"]	= $opflag;
	$dbcon->insertData("wizTable_Emp", $ins);
	$common->js_location($PHP_SELF."?BID=".$BID."&GID=".$GID);
}else if($query == "emp_delete"){
	$sqlstr = "delete from wizTable_Emp where uid = ".$uid;
	$dbcon->_query($sqlstr);
	$common->js_location($PHP_SELF."?BID=".$BID."&GID=".$GID);
}else if($query == "emp_update"){
	$point = $op_point[$uid];
	$op_icon	= $op_icon[$uid];
	$op_strong	= $op_strong[$uid] ? $op_strong[$uid] : 0;
	$op_color = $op_color[$uid];
	$op_em = $op_em[$uid] ? $op_em[$uid] : 0;
	$opflag = $op_icon."|".$op_strong."|".$op_color."|".$op_em;
	
	unset($ups);
	$ups["point"]	= $point;
	$ups["opflag"]	= $opflag;
	$dbcon->updateData("wizTable_Emp", $ups, "uid=".$uid);
	$common->js_location($PHP_SELF."?BID=".$BID."&GID=".$GID);
}

include "../config/wizboard/table/".$GID."/".$BID."/config.php";

include "./admin_pop_top.php";
?>

<div id="table_pop_layout">
	<div class="pop_menu"> <a href="./admin1.php?BID=<?php echo $BID?>&GID=<?php echo $GID?>">LayOut</a>
	<a href="./admin2.php?BID=<?php echo $BID?>&GID=<?php echo $GID?>">ListPage</a>
	<a href="./admin3.php?BID=<?php echo $BID?>&GID=<?php echo $GID?>">ViewPage</a>
	<a href="./admin4.php?BID=<?php echo $BID?>&GID=<?php echo $GID?>">WritePage</a>
	<a class="on">Option</a> </div>
	<form action="<?php echo $PHP_SELF?>" method="POST" name="BasicInfo">
		<input type="hidden" name="query" value="OptionPageChange">
		<input type="hidden" id="BID" name="BID" value="<?php echo $BID;?>">
		<input type="hidden" id="GID" name="GID" value="<?php echo $GID;?>">
		<?php  
$nodp = array("ListForMember","ReadForMember","WriteForMember","DownForMember","UpLoadingOverWriteEnable","CategoryEnable","WritingPointEnable");

		  foreach($cfg["wizboard"] as $key=>$value)  
		  if (!in_array($key, $nodp)) 
		  echo "<input type='hidden' name='".$key."' value='".$value."'>\n"; 
		  ?>
		<div>회원관련(일부 스킨만 적용가능, 1~10등급가능,WizMember와 호환)</div>
		<table class="table_main list">
			<col width="130" />
			<col width="*" />
			<tbody>
				<tr>
					<th>회원전용(읽기)
						<input name="ReadForMember" type="checkbox" id="ReadForMember" value="checked" <?php echo $cfg["wizboard"]["ReadForMember"]?>></th>
					<td><select name="ReadMemberGrade">
							<?php
	$common->getSelectfromFielArray($gradetostr_info, $cfg["wizboard"]["ReadMemberGrade"]);
?>
						</select>
						<?php
$selArr1 = array("over"=>"이상","less"=>"이하","only"=>"만");
$common->mkselectmenu("ReadMemberGradeBoundary", $selArr1, $cfg["wizboard"]["ReadMemberGradeBoundary"]);
?>
						<?php
$selArr2 = array(""=>"성별선택","1"=>"남성전용","2"=>"여성전용");
$common->mkselectmenu("ReadMemberGenderBoundary", $selArr2, $cfg["wizboard"]["ReadMemberGenderBoundary"]);
?>
					</td>
				</tr>
				<tr>
					<th>회원전용(쓰기)
						<input name="WriteForMember" type="checkbox" value="checked" <?php echo $cfg["wizboard"]["WriteForMember"]?>></th>
					<td><select name="WriteMemberGrade">
							<?php
$common->getSelectfromFielArray($gradetostr_info, $cfg["wizboard"]["WriteMemberGrade"]);
?>
						</select>
						<?php
$common->mkselectmenu("WriteMemberGradeBoundary", $selArr1, $cfg["wizboard"]["WriteMemberGradeBoundary"]);
?>
						<?php
$common->mkselectmenu("WriteMemberGenderBoundary", $selArr2, $cfg["wizboard"]["WriteMemberGenderBoundary"]);
?></td>
				</tr>
				<tr>
					<th>회원전용(다운)
						<input name="DownForMember" type="checkbox" value="checked" <?php echo $cfg["wizboard"]["DownForMember"]?>>
					</th>
					<td><select name="DownMemberGrade">
							<?php
$common->getSelectfromFielArray($gradetostr_info, $cfg["wizboard"]["DownMemberGrade"]);
?>
						</select>
						<?php
$common->mkselectmenu("DownMemberGradeBoundary", $selArr1, $cfg["wizboard"]["DownMemberGradeBoundary"]);
?>
						<?php
$common->mkselectmenu("DownMemberGenderBoundary", $selArr2, $cfg["wizboard"]["DownMemberGenderBoundary"]);
?></td>
				</tr>
				<tr>
					<th>회원전용(리스트)
						<input name="ListForMember" type="checkbox" value="checked" <?php echo $cfg["wizboard"]["ListForMember"]?>></th>
					<td><select name="ListMemberGrade">
							<?php
$common->getSelectfromFielArray($gradetostr_info, $cfg["wizboard"]["ListMemberGrade"]);
?>
						</select>
<?php
$common->mkselectmenu("ListMemberGradeBoundary", $selArr1, $cfg["wizboard"]["ListMemberGradeBoundary"]);
?>
						<?php
$common->mkselectmenu("ListMemberGenderBoundary", $selArr2, $cfg["wizboard"]["ListMemberGenderBoundary"]);
?></td>
				</tr>
			</tbody>
		</table>
		<div>게시물점수(게시물당 점수 부여)</div>
		<table class="table_main list">
			<col width="130" />
			<col width="*" />
			<col width="130" />
			<col width="*" />
			<tbody>
				<tr>
					<th> 추천</th>
					<td><input name="bp_recommand" type="text" id="bp_recommand" value="<?php echo $cfg["wizboard"]["bp_recommand"]?>" class="w30">
						포인트 </td>
					<th>비추천</th>
					<td><input name="bp_nonerecommand" type="text" id="commentPoint" value="<?php echo $cfg["wizboard"]["bp_nonerecommand"]?>" class="w30">
						(감점:음수기입)</td>
				</tr>
				<tr>
					<th> 코멘트 </th>
					<td><input name="bp_reple" type="text" id="bp_reple" value="<?php echo $cfg["wizboard"]["bp_reple"]?>" class="w30">
						포인트 </td>
					<th>답글</th>
					<td><input name="bp_reply" type="text" id="commentPoint" value="<?php echo $cfg["wizboard"]["bp_reply"]?>" class="w30">
						포인트 </td>
				</tr>
			</tbody>
		</table>
		<div>게시물 레벨 설정(상기 게시물에 따른 등급 부여)</div>
		<table class="table_main list">
			<col width="130" />
			<col width="*" />
			<tbody>
				<tr>
					<th>중박 게시물</th>
					<td colspan="3"><input name="np_lv10" type="text" id="np_lv10" value="<?php echo $cfg["wizboard"]["np_lv10"]?>" class="w30" /></td>
				</tr>
				<tr>
					<th>대박 게시물</th>
					<td colspan="3"><input name="np_lv20" type="text" id="np_lv20" value="<?php echo $cfg["wizboard"]["np_lv20"]?>" class="w30" /></td>
				</tr>
				<tr>
					<th>명예 게시물</th>
					<td colspan="3"><input name="np_lv30" type="text" id="np_lv30" value="<?php echo $cfg["wizboard"]["np_lv30"]?>" class="w30" /></td>
				</tr>
			</tbody>
		</table>
		<div>게시판 활동점수(게시판 활동을 통한 회원 포인트 설정)<br />
			회수에서 -1 일경우 무제한</div>
		<table class="table_main list">
			<col width="130" />
			<col width="*" />
			<tbody>
				<tr>
					<th> 글쓰기</th>
					<td colspan="3">경험치
						<input type="text" name="writeExp" value="<?php echo $cfg["wizboard"]["writeExp"]?>" class="w30">
						,  머니
						<input type="text" name="writePoint" value="<?php echo $cfg["wizboard"]["writePoint"]?>" class="w30">
						,
						<input type="text" name="writePer" value="<?php echo $cfg["wizboard"]["writePer"]?>" class="w30">
						회(하루)</td>
				</tr>
				<tr>
					<th> 코멘트</th>
					<td colspan="3">경험치
						<input type="text" name="commentExp" value="<?php echo $cfg["wizboard"]["commentExp"]?>" class="w30">
						,  머니
						<input name="commentPoint" type="text" id="commentPoint" value="<?php echo $cfg["wizboard"]["commentPoint"]?>" class="w30">
						,
						<input type="text" name="commentPer" value="<?php echo $cfg["wizboard"]["commentPer"]?>" class="w30">
						회(하루)</td>
				</tr>
				<tr>
					<th> 답글/토론참여</th>
					<td colspan="3">경험치
						<input type="text" name="replyExp" value="<?php echo $cfg["wizboard"]["replyExp"]?>" class="w30">
						,  머니
						<input name="replyPoint" type="text" id="replyPoint" value="<?php echo $cfg["wizboard"]["replyPoint"]?>" class="w30">
						,
						<input type="text" name="replyPer" value="<?php echo $cfg["wizboard"]["replyPer"]?>" class="w30">
						회(하루)</td>
				</tr>
				<tr>
					<th> 추천/비추천</th>
					<td colspan="3">경험치
						<input type="text" name="rccomExp" value="<?php echo $cfg["wizboard"]["rccomExp"]?>" class="w30">
						,  머니
						<input name="rccomPoint" type="text" id="rccomPoint" value="<?php echo $cfg["wizboard"]["rccomPoint"]?>" class="w30">
						,
						<?php echo $cfg["wizboard"]["rccomPer"]?>
						회(총게시판별)</td>
				</tr>
			</tbody>
		</table>
		<div>파일업로딩 금지 확장자 설정하기(","로 나열)<a href="#" onClick="window.open('http://shop-wiz.com/wizmanual.php?BID=manual&mode=view&UID=1&cp=1&BOARD_NO=1&SEARCHTITLE=&searchkeyword=&category=1','OnlineManual','width=500, height=400,scrollbars=yes,resizable=yes')";><img src="images/help.gif" width="20" height="9"></a></div>
		<textarea name="ProhibitExtention" class="w100p"><?php echo $cfg["wizboard"]["ProhibitExtention"]?>
</textarea>
		<input type="button" name="Button" value="수정" onClick="javascript:submit()"; style="cursor:pointer;">
	</form>
	<div class="space10"></div>
	<form name="catForm" method="post" onsubmit="return false;">
		<input type="hidden" name="BID" value="<?php echo $BID?>" />
		<input type="hidden" name="GID" value="<?php echo $GID?>" />
		<input type="hidden" name="query" value="" />
		카테고리사용
		<input name="CategoryEnable" type="checkbox" value="checked" <?php echo $cfg["wizboard"]["CategoryEnable"]?> onClick="setBoardcfg(this)">
		(동일테이브로 옵션선택 - 링크방법은 wizboard.php?BID=보드아이디&amp;category=카테고리번호)<br />
		표시형식 :
		<input type="radio" name="CategoryType" value="radio" <? if($cfg["wizboard"]["CategoryType"] == "radio") echo "checked";?> onclick="setBoardcfg(this)">
		라디오버튼
		<input type="radio" name="CategoryType" value="select" <? if($cfg["wizboard"]["CategoryType"] == "select") echo "checked";?> onclick="setBoardcfg(this)">
		실렉트버튼<br />
		<?php
$catstr = "select ordernum, catname, uid from wizTable_Category where gid = '".$GID."' and bid = '".$BID."' order by ordernum asc";
$catqry = $dbcon->_query($catstr);
$TotalCount = $dbcon->_num_rows($catqry);
?>
		전체 <? echo number_format($TotalCount);?> 개
		카테고리 
		카테고리명 :
		<input name="input_catname" id="input_catname" type="text">
		<button name="btn" onClick="CategoryManager('insert');" title="등록">등록</button>
		<table class="table_main list">
			<thead>
				<tr class="altern">
					<th>선택</th>
					<th>번호</th>
					<th>카테고리명</th>
					<th>게시물의 <br>
						카테고리이동</th>
					<th>삭제</th>
				</tr>
			<thead>
			<tbody>
<?php

$cnt=0;
while($catlist = $dbcon->_fetch_array($catqry)):
?>
				<tr attr-cat-uid="<?php echo $catlist["uid"]?>">
					<td><input name="MultiSelect[<?php echo $catlist["uid"]?>]" type="checkbox" value="<?php echo $catlist["uid"]?>"></td>
					<td><?php echo $catlist["ordernum"]?></td>
					<td><input type="text" name="Newcatname[<?php echo $catlist["uid"]?>]" size="10" value="<?php echo $catlist["catname"]?>" style="width:100%"></td>
					<td><select name="Movecatname" class="tcat"><!--[<?php echo $catlist["ordernum"]?>] -->
										<option value="0">전체</option>
<?php	
$subcatstr = "select ordernum, catname, uid from wizTable_Category where gid = '".$GID."' and bid = '".$BID."' order by ordernum asc";
$dbcon->_query($subcatstr);
while($subcatlist = $dbcon->_fetch_array()):
$selected = $subcatlist["ordernum"] == $catlist["ordernum"]?"selected":"";
//$selectvalue = $subcatlist["ordernum"] == $catlist["ordernum"]?"":$subcatlist["ordernum"];
echo "<option value='".$subcatlist["ordernum"]."' ".$selected.">".$subcatlist["catname"]."</option>\n";
endwhile;
?>
									</select>
									로 게시물 <button type="button" name="btn" class="btn_cat_move" title="이동">이동</button></td>
					<td><? if($cnt <> 0):?>
						<button type="button" name="btn" onClick="CategoryManager('delete','<?php echo $catlist["uid"]?>');" title="삭제">삭제</button>
						<? endif; ?></td>
				</tr>
<?php
$cnt++;
endwhile;
if(!$cnt){
?>
				<tr>
					<td colspan="5">등록된 카테고리가 없습니다. </td>
				</tr>
<?php
}
?>
			</tbody>
			<tr>
				<td colspan="3"><button type="button" name="btn" onClick="CategoryManager('update');" title="카테고리명수정">카테고리명수정</button></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</form>
	<div>획득포인트별 제목 강조</div>
	<table class="table_main list">
		<thead>
			<tr class="altern">
				<th>점수(이상)</th>
				<th>강조옵션</th>
				<th>삭제</th>
			</tr>
		</thead>
		<tbody>
		<form>
			<input type="hidden" name="BID" value="<?php echo $BID?>" />
			<input type="hidden" name="GID" value="<?php echo $GID?>" />
			<input type="hidden" name="query" value="emp_input" />
			<tr>
				<td><input name="point" type="text" id="point" class="w30"></td>
				<td>아이콘
					<select name="op_icon" id="op_icon">
					</select>
					, 강조
					<input name="op_strong" type="checkbox" id="op_strong" value="1" />
					, 색상
					<input type="text" name="op_color" id="op_color" class="w50" />
					, 이태릭
					<input name="op_em" type="checkbox" id="op_em" value="1" /></td>
				<td><button type="submit" name="btn" title="등록">등록</button></td>
			</tr>
		</form>
		<form name="empForm" method="post">
			<input type="hidden" name="uid" value="" />
			<!-- 수정용 -->
			<input type="hidden" name="query" value="emp_update" />
<?php
$sqlstr = "select * from wizTable_Emp where bid='".$BID."' and gid='".$GID."' order by point asc";
$sqlqry = $dbcon->_query($sqlstr);
$cnt=0;
while($list = $dbcon->_fetch_array($sqlqry)):
	$opflag = explode("|", $list["opflag"]);
	$op_icon = $opflag[0];
	$op_strong = $opflag[1]=="1"? " checked":"";
	$op_color = $opflag[2];
	$op_em = $opflag[3]=="1"? " checked":"";
	$uid = $list["uid"];
?>
			<tr>
				<td><input name="op_point[<?php echo $uid?>]" type="text" id="point[<?php echo $uid?>]" value="<?php echo $list["point"]?>" class="w30"></td>
				<td>아이콘
					<select name="op_icon[<?php echo $uid?>]" id="op_icon[<?php echo $uid?>]">
					</select>
					, 강조
					<input name="op_strong[<?php echo $uid?>]" type="checkbox" id="op_strong[<?php echo $uid?>]" value="1"<?php echo $op_strong?> />
					, 색상
					<input type="text" name="op_color[<?php echo $uid?>]" id="op_color[<?php echo $uid?>]" value="<?php echo $op_color?>" class="w50" />
					, 이태릭
					<input name="op_em[<?php echo $uid?>]" type="checkbox" id="op_em[<?php echo $uid?>]" value="1"<?php echo $op_em?> /></td>
				<td><button name="btn" type="button" onClick="emp_manager('update','<?php echo $list["uid"]?>');" title="삭제">수정</button>
					<button name="btn" type="button" onClick="emp_manager('delete','<?php echo $list["uid"]?>');" title="삭제">삭제</button></td>
			</tr>
<?php
$cnt++;
endwhile;
if(!$cnt){
?>
			<tr>
				<td colspan="3">등록된 옵션이 없습니다. </td>
			</tr>
			<?
}
?></form>
			</tbody>
			
		
	</table>
</div>
<?php
include "./admin_pop_bottom.php";
?>