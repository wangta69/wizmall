<?
//------------------------------------------------------------------------------
// 샵바인더 가격 비교 사이트
// 수정일자 : 2005-04-17 신동규
//								
//------------------------------------------------------------------------------
$pageIndex4Query = $pageIndex4Query . " GROUP BY good.goodcd ORDER BY regdt DESC";

if(!$page) $page=1;
$num_per_page   = 500;   // 한 페이지당 출력할 레코드(게시물)의 개수를 정합니다.
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
<HTML>
<HEAD>
<TITLE>샵바인더용 상품 DB리스트</TITLE>
<META content="text/html; charset=ks_c_5601-1987" http-equiv=Content-Type>
</HEAD>
<BODY>
<CENTER>
<br>
<H3><b>샵바인더용 상품 DB리스트</b></H3>
<table border="1" width="90%" align="center" cellspacing="2" cellpadding="3">
  <tr> 
    <td width="30">번호</td>
    <td width="65">쇼핑몰</td>
    <td width="65">대분류</td>
    <td width="45">중분류</td>
    <td width="70">소분류</td>
    <td width="70">제조회사</td>
    <td width="100">상품명</td>
    <td width="100">모델코드</td>
    <td width="100">상품코드</td>
    <td width="80">가격</td>
    <td width="80">이벤트</td>
    <td width="80">이미지URL</td>
    <td width="80">배송료</td>
    <td width="80">할인쿠폰</td>
    <td width="80">제조년월</td>
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
		$CategoryStr1 = $vCodes[codename];
		$CategoryStr2 = $gCodes[catnm];
		$CategoryStr3 = $rcategory[catnm];
	}else{
		$CategoryStr1 = $gCodes[catnm];
		$CategoryStr2 = $rcategory[catnm];
	}
	
	// 시간 맞추기
	$regdtstr = explode(" ",$pData[regdt]);
	$regdtStr = explode("-",$regdtstr[0]);
	$DateStr = $regdtStr[0].$regdtStr[1];
?>
  <tr>
    <td align="center"><?=$num?></td>
    <td><a href="http://<?=$_SERVER[HTTP_HOST]?>"><?=$_SERVER[HTTP_HOST]?></a></td>
    <td><?=$CategoryStr1?></td>
    <td><?=$CategoryStr2?></td>
    <td><?=$CategoryStr3?></td>
    <td><?=$pData[goodbrand]?></td>
    <td><a href="http://<?=$_SERVER[HTTP_HOST]?>/shop/goodalign/good_detail.php?goodcd=<?=$pData[goodcd]?>"><?=$pData[goodnm]?></a></td>
    <td><?=$pData[tmpgoodcd]?></td>
    <td><?=$pData[goodcd]?></td>
    <td><?=$pData[nomalprice]?></td>
    <td></td>
    <td>http://<?=$_SERVER[HTTP_HOST]?>/images/userdif/goods/<?=$pData[goodimg4]?></td>
    <td><?=$transPay[0]?></td>
    <td></td>
    <td><?=$DateStr?></td>
  </tr>
<?
	++$jj;
}
?>
</table>
<PAGES>
<DIV>
<?
for($i=1;$i<=$total_page;++$i)
$pageindex.="<a href='http://".$_SERVER[HTTP_HOST]."/shop/compare/compare_list.php?pKey=".$pKey."&engine=shopbinder&page=".$i."'>".$i."</a>&nbsp;";
echo $pageindex;
?>	
</DIV>
</PAGES>
</CENTER>
</BODY>
</HTML>