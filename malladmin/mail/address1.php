<?php
/*
 powered by 폰돌
 Reference URL : http://www.shop-wiz.com
 Contact Email : master@shop-wiz.com
 Free Distributer :
 Copyright shop-wiz.com
 *** Updating List ***
 */
$user_id = "admin";
if (!strcmp($query, "addrmove")) {
	while (list($key, $value) = each($_GET)) {
		if ($value == "wizMail") {
			$key = ereg_replace("_", ".", $key);
			$sql_update = "update wizMailAddressBook set grp='$movebox' where userid='" . $user_id . "' and idx=$key";
			$dbcon -> _query($sql_update);
		}
	}
} else if (!strcmp($query, "addrdelete")) {
	while (list($key, $value) = each($_GET)) {
		if ($value == "wizMail") {
			$key = ereg_replace("_", ".", $key);

			$sql_delete = "delete from wizMailAddressBook where userid='" . $user_id . "' and idx=$key";
			$sth = $dbcon -> _query($sql_delete);
		}
	}
} else if (!strcmp($query, "groupedit")) {
	if ($groupcode != "all") {
		$sql_update = "update wizMailAddressBookG set subject='$groupname' where userid='" . $user_id . "' and code='$groupcode'";
		$dbcon -> _query($sql_update);
	}
} else if (!strcmp($query, "groupdatadelete")) {
	if ($segroup != "all") {
		$sql_delete = "delete from wizMailAddressBook where userid='" . $user_id . "' and grp='$segroup'";
		$dbcon -> _query($sql_delete);
	}
} else if (!strcmp($query, "groupdelete")) {
	if ($segroup != "all") {
		$sql_delete = "delete from wizMailAddressBookG where userid='" . $user_id . "' and code='$segroup'";
		$dbcon -> _query($sql_delete);
	}
}
?>

<script>
	function reverse() {
		var i;

		for ( i = 0; i < document.addrbook.elements.length; i++)
			if (document.addrbook.elements[i].name.indexOf('@'))
				if (document.addrbook.chkboxse.value == '1')
					document.addrbook.elements[i].checked = true;
				else
					document.addrbook.elements[i].checked = false;

		if (document.addrbook.chkboxse.value == '1') {
			document.addrbook.chkboxse.value = '0';
			btn1.innerHTML = "<img src='./img/button2.gif'>";
		} else {
			document.addrbook.chkboxse.value = '1';
			btn1.innerHTML = "<img src='./img/button1.gif'>";
		}
	}

	function addrbook_move() {
		var boxselectedval = document.addrbook.movebox.value;
		var i;

		if (boxselectedval == 0)
			return;

		if (document.addrbook.elements.length == 0) {
			alert('\n이동할 사람을 선택해 주세요!\n\n');
			return;
		}
		document.addrbook.query.value = 'addrmove';
		document.addrbook.submit();
	}

	function selected_addrbook_delete() {
		if (document.addrbook.elements.length == 0) {
			alert('\n삭제할 사람을 선택해 주세요!\n\n');
			return;
		}

		if (confirm('\n선택한 사람들을 삭제합니다\n\n삭제작업을 진행하실려면 확인을 클릭하세요\n\n')) {
			document.addrbook.query.value = 'addrdelete';
			document.addrbook.submit();
		}
	}

	function search() {
		document.addrbook.query.value = '';
		document.addrbook.submit();
	}

	function gotoPage(cp) {
		$("#cp").val(cp);
		$("#sform").submit();
	}

</script>

<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">주소록 관리 > <?php
	if ($segroupname)
		echo "$segroupname";
	else
		echo "전체그룹";
	?></div>
	  <div class="panel-body">
		 
	  </div>
	</div>
	
	
		<div class="row">
	  <div class="col-lg-4">
	  	
		<ul class="list-group">
			<li class="list-group-item">
				<a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=<?php echo $theme ?>'>전체그룹</a>
			</li>
<?php

$sql	= "select * from wizMailAddressBookG where userid='".$user_id."' order by idx asc";
$qry	= $dbcon->_query($sql);
$Total	= $dbcon->_num_rows();

if($Total)
{
	$cnts = 0;
	while($list = $dbcon->_fetch_array($qry))
	{
?>

			<li class="list-group-item">
					<a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=<?php echo $theme ?>&idx=<?php echo $list["idx"] ?>'> <?php echo $list["subject"] ?></a>
			</li>
<?php
$cnts = $cnts + 1;
}
}
?>
		</ul>
		
		<!--<input type="text" id="newgroupname"><button type="button" class="btn btn-default btn-xs btn_add_group">그룸추가</button>-->
		<a href="<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=mail/address2" class="btn btn-default btn-xs">그룹관리</a>
      	  	
	  </div><!-- col-lg-4" -->

	  
	  <div class="col-lg-7">
<?php
$ListNo = 10;
$PageNo = 10;
/* 검색 키워드 및 WHERE 구하기 */
if (!$WHERE)
	$WHERE = "WHERE userid='" . $user_id . "'";
if ($idx)
	$WHERE .= " and grp='$idx' ";

if ($sehkey != "all") {

	$WHERE .= $admin -> hangul_qurey($sehkey);
}

if (!empty($searchkeyword)) {
	$idx = "";
	$sehkey = "all";
	$WHERE = "WHERE userid='" . $user_id . "' and $searchkey like '%$searchkeyword%' ";
}

/* 총 갯수 구하기 */
$sqlstr = "select * from wizMailAddressBook $WHERE order by binary name";
$dbcon -> _query($sqlstr);
$TOTAL = $dbcon -> _num_rows();

if (empty($cp) || $cp <= 0)
	$cp = 1;
?>

			<form action='<?php echo $PHP_SELF ?>' name='addrbook' method='get' id="sform">
				<input type='hidden' name='menushow' value='<?php echo $menushow ?>'>
				<input type='hidden' name='theme' value='<?php echo $theme ?>'>
				<input type="hidden" name="cp" id="cp" value='<?php echo $cp ?>'>
				<input type='hidden' name='query' value=''>
				<input type='hidden' name='chkboxse' value='1'>
				<input type='hidden' name='idx' value='<?php echo $idx ?>'>
				<input type='hidden' name='sehkey' value='<?php echo $sehkey ?>'>
				<input type='hidden' name='sehkeyword' value='<?php echo $sehkeyword ?>'>
			<!-- 주소록 본문시작 -->

				<div class="btn-group">
					<a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=<?php echo $theme ?>&sehkey=all' class="btn btn-default btn-xs">전체</a></td>
					<a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=<?php echo $theme ?>&sehkey=<?php echo urlencode("ㄱ"); ?>' class="btn btn-default btn-xs">ㄱ</a>
					<a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=<?php echo $theme ?>&sehkey=<?php echo urlencode("ㄴ"); ?>' class="btn btn-default btn-xs">ㄴ</a>
					<a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=<?php echo $theme ?>&sehkey=<?php echo urlencode("ㄷ"); ?>' class="btn btn-default btn-xs">ㄷ</a>
					<a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=<?php echo $theme ?>&sehkey=<?php echo urlencode("ㄹ"); ?>' class="btn btn-default btn-xs">ㄹ</a>
					<a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=<?php echo $theme ?>&sehkey=<?php echo urlencode("ㅁ"); ?>' class="btn btn-default btn-xs">ㅁ</a>
					<a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=<?php echo $theme ?>&sehkey=<?php echo urlencode("ㅂ"); ?>' class="btn btn-default btn-xs">ㅂ</a>
					<a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=<?php echo $theme ?>&sehkey=<?php echo urlencode("ㅅ"); ?>' class="btn btn-default btn-xs">ㅅ</a>
					<a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=<?php echo $theme ?>&sehkey=<?php echo urlencode("ㅇ"); ?>' class="btn btn-default btn-xs">ㅇ</a>
					<a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=<?php echo $theme ?>&sehkey=<?php echo urlencode("ㅈ"); ?>' class="btn btn-default btn-xs">ㅈ</a>
					<a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=<?php echo $theme ?>&sehkey=<?php echo urlencode("ㅊ"); ?>' class="btn btn-default btn-xs">ㅊ</a>
					<a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=<?php echo $theme ?>&sehkey=<?php echo urlencode("ㅋ"); ?>' class="btn btn-default btn-xs">ㅋ</a>
					<a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=<?php echo $theme ?>&sehkey=<?php echo urlencode("ㅌ"); ?>' class="btn btn-default btn-xs">ㅌ</a>
					<a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=<?php echo $theme ?>&sehkey=<?php echo urlencode("ㅍ"); ?>' class="btn btn-default btn-xs">ㅍ</a>
					<a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=<?php echo $theme ?>&sehkey=<?php echo urlencode("ㅎ"); ?>' class="btn btn-default btn-xs">ㅎ</a>
					<a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=<?php echo $theme ?>&sehkey=eng' class="btn btn-default btn-xs">eng</a>
				</div>
	
				<select name='searchkey' class='select'>
					<option value='name' selected>이름</option>
					<option value='company'>회사명</option>
					<option value='hphone'>전화번호</option>
					<option value='hand'>전화번호</option>
				</select>
				<input name='searchkeyword' type='text' size='12' class='input'>
				<a href='javascript:search();' class="btn btn-default btn-xs">검색</a>
				<span class="button bull"><a href='javascript:reverse()'>전체선택</a></span>
				
				선택한 사람을
				<span class="button bull"><a href='javascript:selected_addrbook_delete()'>삭제</a></span>
				<select name='movebox' sytle='width:134' onChange='addrbook_move()'>
				<option value='0' selected>다른 그룹으로 이동</option>
				<?

				$SQL = "select * from wizMailAddressBookG where userid='" . $user_id . "' order by idx asc";
				$Rs = $dbcon -> _query($SQL);
				$Total = $dbcon -> _num_rows($Rs);

				if ($Total) {
					$cnts = 0;
					while ($list = $dbcon -> _fetch_array($Rs)) {
						$grpcode = $list["code"];
						$grpname = $list["subject"];

						echo("<option value='$grpcode'>$grpname</option>");

						$cnts = $cnts + 1;
					}
				}
				?>
				</select><span class="button bull"><a href='<?php echo $PHP_SELF ?>?menushow=<?php echo $menushow ?>&theme=mail/address5'>주소추가</a></span>
				<!--<a href="#" onClick="window.open('./address1_1.php','GroupAddWindwo','')"><img src='img/button10.gif' width="66"></a> -->
				<table class="table">
					<col width="60" />
					<col width="*" />
					<col width="70" />
					<col width="100" />
					<col width="100" />
					<thead>
						<tr class="active">
							<th>선택</th>
							<th>이름</th>
							<th>직장명</th>
							<th>전화번호</th>
							<th>전자우편</th>
						</tr>
					</thead>
						<tbody>
<?php
$START_NO = ($cp - 1) * $ListNo;
$BOARD_NO=$TOTAL-($ListNo*($cp-1));
$SELECT_STR="$sqlstr LIMIT $START_NO, $ListNo";
$SELECT_QRY=$dbcon->_query($SELECT_STR);
$cnt = 0;
while($list=@$dbcon->_fetch_array($SELECT_QRY)):
?>
						<tr>
						<td><input type='checkbox' name='<?php echo $list["idx"] ?>' value='wizMail'></td>
						<td><?php echo $list["name"] ?>
						</td>
						<td><?php echo $list["company"] ?>
						</td>
						<td><?php echo $list["cphone"]; ?>
						</td>
						<td><?php echo $list["email"] ?>
						</td>
						</tr>
<?php
$cnt++;
$BOARD_NO--;
endwhile;
if(!$cnt):/* 게시물이 존재하지 않을 경우 */
?>
						<tr>
						<td colspan="9">검색된 데이타가 없습니다.</td>
						</tr>
	<?php
	endif;
	?>
					</tbody>
				</table>
			</form>
			
			<!-- 주소록 본문종료 -->
			<div class="text-center">
				<?php
				$params = array("listno" => $ListNo, "pageno" => $PageNo, "cp" => $cp, "total" => $TOTAL, "type" => "bootstrappost");
				echo $common -> paging($params);
				?>
			</div>		

	  </div><!--col-lg-8 -->
	</div><!-- row -->
</div>
