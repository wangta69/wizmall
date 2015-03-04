<?
/* 

제작자 : 폰돌
스킨 : wizboard list skin 
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
$orderby	= $sel_orderby;
if(!$orderby)  $orderby = "m1.UID@DESC";
//일반검색
if ($query == 'search') {
	$keyword = trim($keyword);
	$whereis = "WHERE m2.UID=m2.PID";
	if ($Category) { $whereis .= " AND m1.Category LIKE '%$Category'";}
	if ($price1) {$whereis .= " AND m2.Price >= $price1";}
	if ($price2) {$whereis .= " AND m2.Price <= $price2";}
	if ($Brand) {$whereis .= " AND m2.Brand LIKE '%$Brand%'";}
	if ($keyword && $Target) {
	//$upperkeyword = strtoupper ($keyword);
	//$lowerkeyword = strtolower ($keyword);
		$targetAllow = array("all", "m2.Description1", "m2.Name", "m2.Model");
		if(in_array($Target, $targetAllow)){
			if ($Target == 'all') {
				$whereis .= " AND (
					m2.Name LIKE '%$keyword%'
					OR m2.Description1 LIKE '%$keyword%'
					OR m2.Model LIKE '%$keyword%')";}
			else $whereis .= " AND $Target LIKE '%$keyword%'";
		}
	}
}
//다중검색
if ($query == 'natural') {
	if (!$keyword) {
		ECHO "<script language=javascript>
		window.alert('\\n자연에 검색에 필요한 문장을 입력해 주세요.\\n');
		history.go(-1);
		</script>";
		exit;
	}

	$Natural_Key_Spl = explode(" ", $keyword);
	$targetAllow = array("all", "m2.Description1", "m2.Name", "m2.Model");
	if(in_array($Target, $targetAllow)){
		$whereis = "WHERE $Target LIKE '%$Natural_Key_Spl[0]%'";
		
		for ($i = 1; $i < sizeof($Natural_Key_Spl) && $i <= 100; $i++) {
			$whereis .= " $andor $Target LIKE '%$Natural_Key_Spl[$i]%'";
		}
	}
}


/* 페이징과 관련된 수식 구하기 */
$ListNo = "15";
$PageNo = "20";
if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $ListNo;
$TOTAL_STR = "SELECT count(*) FROM wizMall";
$REALTOTAL = $dbcon->get_one($TOTAL_STR);

$sqlstr = "SELECT count(1) FROM wizMall m1 left join wizMall m2 on m1.PID = m2.UID $whereis";
$TOTAL = $dbcon->get_one($sqlstr);
?>
<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active">검색결과</li>
</ul>


<img src="./skinwiz/search/<?=$cfg["skin"]["SearchSkin"]?>/images/img_serach01.gif" width="86" height="32">
<?=$keyword?>
검색어로 총
<?=number_format($TOTAL)?>
개의 상품들을 검색하였습니다. <br />
<form  action="./wizsearch.php">
	<input type="hidden" name="query" value="search">
	<input type="hidden" name="Target" value="all">
	<img src="./skinwiz/search/<?=$cfg["skin"]["SearchSkin"]?>/images/img_dbo.gif">
	<input name="keyword" type="text" class="formline" size="23">
	<input name="image" type="image" src="./skinwiz/search/<?=$cfg["skin"]["SearchSkin"]?>/images/but_serach.gif" width="77">

<img src="./skinwiz/search/<?=$cfg["skin"]["SearchSkin"]?>/images/img_detail.gif"><a href='./wizsearch.php'><img src="./skinwiz/search/<?=$cfg["skin"]["SearchSkin"]?>/images/but_detail.gif"></a></form>
<p>&nbsp;</p>

	검색된 제품 :
	<?=number_format($TOTAL)?>
	개
	<?=$mall->sel_pd_order($sel_orderby)?>

<form action='./wizmall.php' name='mall_list' onsubmit='return cmp()'>
	<input type="hidden" name="query" VALUE='cmp'>
	<table class="table table-striped table-hover">
		<tr>
			<th>상품정보</th>
			<th>제조사</th>
			<th>가격/포인트</th>
		</tr>
<?php
$sqlqry = $dbcon->get_select('m1.UID, m1.PID, m1.Category, m2.Picture, m2.None, m2.Regoption, m2.Model, m2.Name, m2.Price, m2.Category as pcategory','wizMall m1 left join wizMall m2 on m1.PID = m2.UID',$whereis, $orderby, $START_NO, $ListNo);
while( $list = $dbcon->_fetch_array($sqlqry)) :

    $Picture	= explode("|", $list[Picture]);
	$Regoption	= $list["Regoption"];
	$Category	= $list["Category"];
	$UID		= $list["UID"];
	$None		= $list["None"];
	$big_code	= substr($Category, -3);
	$link_url 	= "'./wizmart.php?query=view&code=$list[Category]&no=$list[UID]'";
	$Picture 	= explode("|", $list[Picture]);
	$Multi_Disabled = "";
	
	if (($Stock && $Stock <= $Output) || $None == '1' ) {
		$link_url = "'#' onclick=\"javascript:alert('제품이 품절되었습니다. 관리자에게 문의하세요.')\"";
		$Multi_Disabled = " disabled";
	}
	
	$img_folder		= substr($list["pcategory"], -3);
    $View_Pic_Size	= $common->TrimImageSize("./config/uploadfolder/productimg/".$img_folder."/".$Picture[0], 50);
	$categoryName	= $mall->getCategoryFullPath($Category);//카테고리 표시시 사용
?>
		<tr>
			<td>
				<p><a href=<?=$link_url?>><img src="./config/uploadfolder/productimg/<?=$img_folder?>/<?=$Picture[0]?>" <?=$View_Pic_Size?>></a></p>
				<p><a href=<?=$link_url?>><?=$list[Name]?></a></p>
			</td>
			<td><?=$list[Brand]?>
			</td>
			<td><?=number_format($list[Price])?>
				원<br />
				<?=number_format($list[Point])?>
				포인트</td>
		</tr>
		<?endwhile;?>
	</table>
<div class="paging_box"><?
/* 페이지 번호 리스트 부분 */
/* PREVIOUS or First 부분 */
$page_arg1 = $PHP_SELF."?query=$query&cat=$cat&Target=$Target&keyword=".urlencode($keyword)."&price1=$price1&price2=$price2&Brand=$Brand&sel_orderby=$sel_orderby&andor=$andor";
$page_arg2 = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL); 
//$page_arg3 = array("pre"=>"./img/pre.gif","next"=>"./img/next.gif");
echo $common->paging($page_arg1,$page_arg2,$page_arg3);
?></div>
</form>
