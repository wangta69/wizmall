<?php
$RECNUM = 20;
$LISTNUM = 10;
$START_NUM = ($PAGENUM-1)*$RECNUM;

if (!$sort) {$sort = "UID";}

if ($query == 'alpha') {
	$WHEREIS = "WHERE UID";
	if ($Category) { $WHEREIS = $WHEREIS." AND Category LIKE '%$Category'";}
	if ($Brand) {$WHEREIS =	$WHEREIS." AND Brand LIKE '%$compname%'";}
	if ($keyword && $Target) {
		if ($Target == 'all') {
			$WHEREIS = $WHEREIS." AND Name LIKE '%$keyword%' OR Description1 LIKE '%$keyword%' OR Model LIKE '%$keyword%'";
		}
		if ($Target == 'Name') {
			$WHEREIS = $WHEREIS." AND Name LIKE '$keyword%'";
		}
		if ($Target == 'Model') {
			$WHEREIS = $WHEREIS." AND Model LIKE '%$keyword%'";
		}
	}
}

$TOTAL_COUNT = $dbcon->get_one( "SELECT count(*) FROM wizMall"); 
$DATA_NUM = $dbcon->get_one( "SELECT count(*) FROM wizMall $WHEREIS"); 
$TOTAL_PAGE = intval(($DATA_NUM-1)/$RECNUM)+1;
?>

<div class="navy">Home &gt; 검색</div>
<div class="space20"></div>
<table>
<?php
$sqlstr = "SELECT * FROM wizMall $WHEREIS ORDER BY $sort DESC LIMIT $START_NUM,$RECNUM";
$TABLE_DATA = $dbcon->_query($sqlstr);
while( $list = $dbcon->_fetch_array( $TABLE_DATA ) ) :

$link_url = "'./wizmart.php?query=view&code=$list[Category]&no=$list[UID]'";
$Picture = explode("|", $list[Picture]);
$Multi_Disabled = "";
if (($Stock && $Stock <= $Output) || $None == 'checked' ) {
	$link_url = "'#' onclick=\"javascript:alert('제품이 품절되었습니다. 관리자에게 문의하세요.')\"";
	$Multi_Disabled = " disabled";
}
?>
	<tr>
		<td><a href=<?php echo $link_url?>><img src='./wizstock/<?php echo $Picture[0]?>' WIDTH='88'></a> </td>
		<td><table>
				<tr>
					<td> 도서명</td>
					<td> 발행국</td>
					<td> 판매가격</td>
				</tr>
				<tr>
					<td><div>
							<?php echo $list["Name"]?>
						</div></td>
					<td><div>
							<?php echo $list["Brand"]?>
						</div></td>
					<td><div>
							<?php echo number_format($list["Price"])?>
						</div></td>
				</tr>
			</table>
			<a href=<?php echo $link_url?>><img src="img/seebutton.gif" width="87"></a> </td>
	</tr>
	<?php endwhile;?>
</table>
<div class="paging_box">
	<?php
	if ($p == 1) {
		echo "◁";
	}
	else {
		$PrevPage = $p-1;
		echo "<a href='$PHP_SELF?query=$query&cat=$cat&Target=$Target&keyword=$keyword&price1=$price1&price2=$price2&compname=$compname&sort=$sort&andor=$andor&p=$PrevPage'>◀</a>";
	}
	echo "&nbsp;";
/*****************************************************************************/
	$term = $LISTNUM;
	$f = 1;
	$l = $term;

	while ($f <= $TOTAL_PAGE) {
		if (($f <= $p) && ($p <= $l)) {
			if ($l <= $TOTAL_PAGE) {
				for ($page = $f; $page <= $l; $page++) {
					if ($page == $p) {
						echo "$page&nbsp;";
					}
					else {
						echo "<a href='$PHP_SELF?query=$query&cat=$cat&Target=$Target&keyword=$keyword&price1=$price1&price2=$price2&compname=$compname&sort=$sort&andor=$andor&p=$page'>$page</a>&nbsp;";
					}
				}
			}
			else {
				for ($page = $f; $page <= $TOTAL_PAGE; $page++) {
					if ($page == $p) {
						echo "$page&nbsp;";
					}
					else {
						echo "<a href='$PHP_SELF?query=$query&cat=$cat&Target=$Target&keyword=$keyword&price1=$price1&price2=$price2&compname=$compname&sort=$sort&andor=$andor&p=$page'>$page</a>&nbsp;";
					}
				}
			}
		}
		
		$f = $f + $term;
		$l = $l + $term;
	}
/*****************************************************************************/

	if($p == $TOTAL_PAGE) {
		echo "▷";
	}
	else {
		$NextPage = $p+1;
		echo "<a href='$PHP_SELF?query=$query&cat=$cat&Target=$Target&keyword=$keyword&price1=$price1&price2=$price2&compname=$compname&sort=$sort&andor=$andor&p=$NextPage'>▶</a>";
	}
?>
</div>
