<?
//------------------------------------------------------------------------------
// 나와요 가격 비교 사이트
//								
//------------------------------------------------------------------------------
$pageIndex4Query = $pageIndex4Query . " GROUP BY good.goodcd ORDER BY regdt DESC";

$dataQuery = Getinfo($pageIndex4Query,"handle");
$totProduct = $dbcon->_num_rows($dataQuery);

while($pData=$dbcon->_fetch_array($dataQuery)){
	
	$rcategory=reverseCategory($pData['goodcd']);
	
	$gCodes=getinfo("SELECT catnm,virtureCode FROM tb_category WHERE catcd='$rcategory[refcd]' AND catcd=refcd");
	
	if($rcategory[catcd]==$rcategory[refcd]){
		$gCodes[catnm]=$rcategory[catnm];
		$rcategory[catnm]="";
	}
	
	if($virtureconfirm == "y"){
		$vCodes=getinfo("SELECT codename FROM tb_virtureCode WHERE refcd='$rcategory[refcd]' GROUP BY code");
		$CategoryStr = $vCodes[codename] . "^" . $gCodes[catnm]. "^" .$rcategory[catnm]. "^";
	}else{
		$CategoryStr = $gCodes[catnm]. "^" .$rcategory[catnm]. "^^";
	}
	
	// 상품 기본 형식
	// 상품코드(고유코드)^대분류^중분류^소분류^최하위분류^모델명^제조사^브랜드^상품주소^가격^상품이미지URL^배송료^적립금^이벤트
	// 상품 구분은 <br>, 상품 구분을 위한 <br>태그 외의 모든 <br>태그는 삭제해 주십시요.
	
	$datas.=$pData[goodcd]."^".$CategoryStr."^".$pData[goodnm]."^".$pData[goodbrand]."^".$pData[goodmaker]."^".
		"http://".$_SERVER[HTTP_HOST]."/shop/goodalign/good_detail.php?goodcd=".$pData[goodcd]."^".
		$pData[nomalprice]."^".
		"http://".$_SERVER[HTTP_HOST]."/images/userdif/goods/".$pData[goodimg4]."^".
		$transPay[0]."^".$pData[reserveprice]."^<br>\r\n";
}
?>
<HTML>
<BODY>
총 <?=$totProduct?>개의 상품<br>
<?=$datas?>
</BODY>
</HTML>