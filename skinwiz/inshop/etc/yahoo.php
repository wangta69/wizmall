<?
//------------------------------------------------------------------------------
// 야후 가격 비교 사이트
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
	
	$datas.=$pData[goodcd]."^".$CategoryStr."^".$pData[goodnm]."^".$pData[goodbrand]."^".
		"http://".$_SERVER[HTTP_HOST]."/=".$pData[goodcd]."^".
		$pData[nomalprice]."^".
		"http://".$_SERVER[HTTP_HOST]."/images/".$pData[goodimg4]."<br>\r\n";
}
?>
<HTML>
<BODY>
총 <?=$totProduct?>개의 상품<br>
<?=$datas?>
</BODY>
</HTML>