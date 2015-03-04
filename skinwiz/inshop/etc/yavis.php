<?
//------------------------------------------------------------------------------
// 야비스 가격 비교 사이트
// 수정일자 : 2005-04-17 신동규
//								
//------------------------------------------------------------------------------
$pageIndex4Query = $pageIndex4Query . " GROUP BY good.goodcd ORDER BY regdt DESC";

if(!$page) $page=1;
$num_per_page   = 100;   // 한 페이지당 출력할 레코드(게시물)의 개수를 정합니다.
$page_per_block = 10;   // 한 페이지에 출력되는 직접 이동 링크 개수를 정합니다.

$gettotl=getinfo($pageIndex4Querycnt);
$row_cnt=$gettotl[0];
$total_record = $row_cnt;   // 테이블에서 총 레코드의 갯수를 얻어 변수에 저장한다.

if ( $total_record == 0 ){
	$first = 1;
	$last  = 0;
}else{
	$first = $num_per_page * ($page - 1);
	$last  = $num_per_page * $page;
}

if ($last>$total_record)$last = $total_record - 1;

// 전체 페이지 계산
$total_page = ceil( $total_record / $num_per_page );
$ntotpage = $total_page;   // 전체 페이지수를 변수에 저장합니다.	
$pageIndex4Query =  $pageIndex4Query." LIMIT $first,$num_per_page";

$getpointslistq=dynGetinfo($pageIndex4Query);
$jj=1;
?>
<html>
<head><title>야비스엔진페이지</title>
<meta http-equiv="Cache-Control" content="no-cache"/> 
<meta http-equiv="Expires" content="0"/> 
<meta http-equiv="Pragma" content="no-cache"/> 
<style>td {font-size:10pt; font-family:"굴림"; text-decoration: none; line-height: 13pt; color:#333333}</style> 	
</head>
<body topmargin="0" leftmargin="0">
<table width="100%" border=1>
  <tr>
    <td>상품명</td>
    <td>상품URL</td>
    <td>상품이미지URL</td>
    <td>가격</td>
    <td>분류</td>
    <td>제조사</td>
    <td>브랜드</td>
    <td>모델명</td>
    <td>상품코드</td>
  </tr>
<?
while($pData=moveArray($getpointslistq)){
	$num = $row_cnt - intval(($page-1)*$num_per_page) - ($jj-1);   // 페이지 값 계산
	
	$rcategory=reverseCategory($pData['goodcd']);
	
	$gCodes=getinfo("SELECT catnm,virtureCode FROM tb_category WHERE catcd='$rcategory[refcd]' AND catcd=refcd");
	
	if($rcategory[catcd]==$rcategory[refcd]){
		$gCodes[catnm]=$rcategory[catnm];
		$rcategory[catnm]="";
	}
	
	if($virtureconfirm == "y"){
		$vCodes=getinfo("SELECT codename FROM tb_virtureCode WHERE refcd='$rcategory[refcd]' GROUP BY code");
		$CategoryStr = $vCodes[codename] . "&gt;" . $gCodes[catnm]. "&gt;" .$rcategory[catnm];
	}else{
		$CategoryStr = $gCodes[catnm]. "&gt;" .$rcategory[catnm];
	}
?>
  <tr>
    <td name=PRODUCTNAME><?=$pData[goodnm]?></td>
    <td name=PRODUCTUTL>http://<?=$_SERVER[HTTP_HOST]?>/shop/goodalign/good_detail.php?goodcd=<?=$pData[goodcd]?></td>
    <td name=IMAGEURL>http://<?=$_SERVER[HTTP_HOST]?>/images/userdif/goods/<?=$pData[goodimg1]?></td>
    <td name=PRICE><?=$pData[nomalprice]?></td>
    <td name=CATEGORY><?=$CategoryStr?></td>
    <td name=MANUFACTURE><?=$pData[goodbrand]?></td>    
    <td><?=$pData[goodmaker]?></td>
    <td><?=$pData[tmpgoodcd]?></td>
    <td><?=$pData[goodcd]?></td>
  </tr>
<?
	++$jj;
}
?>
</table>
<table border=0 cellpadding=0 cellspacing=0 align=center>
  <TR> 
    <TD align="center">
<?
	for($i=1;$i<=$total_page;++$i)
		$pageindex.="[<a href='http://".$_SERVER[HTTP_HOST]."/shop/compare/compare_list.php?pKey=".$pKey."&engine=yavis&page=".$i."'>".$i."</a>]&nbsp;";
	echo $pageindex;
?>
    </TD>
  </TR>
</table>
</body>
</html>