<form name="categoryselect" action="<?$PHP_SELF?>" method="POST">
	<input type="hidden" name="BID" value="<?=$BID?>" />
	<input type="hidden" name="GID" value="<?=$GID?>" />
	<input type="hidden" name="adminmode" value="<?=$adminmode?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<? if($cfg["wizboard"]["CategoryEnable"]): //분류가 있으면?>
			<td><?
	  $categoryname = $board->getcategorylist();
	   
$sqlstr = "select ordernum, catname, uid from wizTable_Category where gid = '$GID' and bid = '$BID' order by ordernum asc";
$dbcon->_query($sqlstr);
	echo "<select name='category' onChange='document.categoryselect.submit()';>";
	echo "<option value=''>카테고리선택</option>";
		while($list = $dbcon->get_rows()):
			$ordernum	= $list["ordernum"];
			$catname	= $list["catname"];
			$selected	= $category == $ordernum?"selected":"";
			$categoryname[$ordernum] = $catname;
			echo "<option value=\"".$ordernum."\" ${selected}>".$catname."</option>";
		endwhile;
	echo "</select>";
?></td>
			<? endif; ?>
			<td class="agn_r">Page
				<?=$board->page_var["cp"]?>
				/
				<?=$board->page_var["tp"]?>
			</td>
		</tr>
	</table>
</form>
<table class="table table-striped table-hover">
	<col width="50" />
	<col width="*" />
	<col width="70" />
	<col width="60" />
	<col width="50" />
	<thead>
	<tr align="center">
		<th>번호</th>
		<th>제목</th>
		<th>글쓴이</th>
		<th>날짜</th>
		<th>조회</th>
	</tr>
	</thead>
	<tbody>
<?php
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
		<td class="orange">공지</td>
		<td class="agn_l"><a href="<?=$PHP_SELF?>?getdata=<?=$getdata?>">
			<?=$list["print_subject"]?>
			</a></td>
		<td><?=$list["NAME"];?></td>
		<td><?=date("Y.m.d", $list["W_DATE"])?></td>
		<td><?=$list["COUNT"];?></td>
	</tr>
<?php
$cnt++;
endwhile;

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
		<td><?=$board->ini_board_no;?></td>
		<td class="agn_l"><a href="<?=$PHP_SELF?>?getdata=<?=$getdata?>">
			<?=$list["print_subject"]?>
			</a></td>
		<td><?=$list["NAME"];?></td>
		<td><?=date("Y.m.d", $list["W_DATE"])?></td>
		<td><?=$list["COUNT"];?></td>
	</tr>
<?php
$board->ini_board_no--;
$cnt++;
endwhile;
if(!$board->page_var["tc"]):/* 게시물이 존재하지 않을 경우 */
?>
	<tr>
		<td>&nbsp;</td>
		<td> 등록된 글이 없습니다.</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
<?php
endif;
?>
</tbody>
</table>
<div class="row">
  <div class="col-lg-3">
<?php
include "./wizboard/skin_btnm/".$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]."/index.php";
?>
  </div>
  <div class="col-lg-6">
		<form name="board_search" action="<?=$PHP_SELF?>" mehtod="POST" onsubmit="return boardSearch(this)" class="form-inline" role="form">
			<input type="hidden" name="BID" value="<?=$BID?>" >
			<input type="hidden" name="GID" value="<?=$GID?>" >
			<input type="hidden" name="adminmode" value="<?=$adminmode?>">
			<input type="hidden" name="optionmode" value="<?=$optionmode?>">
			<input type="hidden" name="category" value="<?=$category?>">
			<input type="hidden" name="mode" value="<?=$mode?>">
			<input type="hidden" name="UID" value="<?=$UID?>">
			<input type="hidden" name="cp" value="<?=$cp?>">
			<div class="row">
				<div class="col-lg-3">
					<select onBlur= "" name="search_term" class="form-control">
						<option value=""<? if(!$search_term) echo " selected";?>>전체</option>
						<option value="<?=60*60*24*7?>"<? if($search_term == 60*60*24*7 ) echo " selected";?>>최근한주</option>
						<option value="<?=60*60*24*7*2?>"<? if($search_term == 60*60*24*7*2 ) echo " selected";?>>최근두주</option>
						<option value="<?=60*60*24*30?>"<? if($search_term == 60*60*24*30 ) echo " selected";?>>한달</option>
					</select>
				</div>
				<div class="col-lg-3">
					<select name="SEARCHTITLE" class="form-control">
						<!--<select name="SEARCHTITLE" checkenable msg="검색범위를 선택해주세요">-->
						<option value=""<? if($SEARCHTITLE == "" ) echo " selected";?>>전체</option>
						<option value="SUBJECT"<? if($SEARCHTITLE == "SUBJECT" ) echo " selected";?>>제 
						목</option>
						<option value="NAME"<? if($SEARCHTITLE == "NAME" ) echo " selected";?>>글쓴이</option>
						<option value="CONTENTS"<? if($SEARCHTITLE == "CONTENTS" ) echo " selected";?>>내 
						용</option>
					</select>
				</div>
				<div class="col-lg-4">
					<input type="text" name="searchkeyword" size="20" value="<? echo $searchkeyword; ?>" checkenable msg="키워드를 입력하세요" class="form-control"/>
				</div>
				<div class="col-lg-1">
					<button type="submit" class="btn btn-default">검색</button>
				</div>
			</div>
		</form>
  </div>
  <div class="col-lg-3">
<?php
echo $board->showBoardIcon('list', 1);
echo $board->showBoardIcon('write');
?>
  </div>
</div>






