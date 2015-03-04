<?
//------------------------------------------------------------------------------
// 오미 가격 비교 사이트
//								
//------------------------------------------------------------------------------
$pageIndex4Query = $pageIndex4Query . " GROUP BY good.goodcd ORDER BY regdt DESC";

$dataQuery = Getinfo($pageIndex4Query,"handle");
$totProduct = $dbcon->_num_rows($dataQuery);

$datas=$HTTP_HOST."입니다. 총 (".$totProduct.")건 입니다.\r\n";

while($pData=$dbcon->_fetch_array($dataQuery)){
	
	$rcategory=reverseCategory($pData['goodcd']);
	
	$gCodes=getinfo("SELECT catnm,virtureCode FROM tb_category WHERE catcd='$rcategory[refcd]' AND catcd=refcd");
	
	if($rcategory[catcd]==$rcategory[refcd]){
		$gCodes[catnm]=$rcategory[catnm];
		$rcategory[catnm]="";
	}
	
	if($virtureconfirm == "y"){
		$vCodes=getinfo("SELECT codename FROM tb_virtureCode WHERE refcd='$rcategory[refcd]' GROUP BY code");
		$CategoryStr = $vCodes[codename] . "^" . $gCodes[catnm]. "^" .$rcategory[catnm];
	}else{
		$CategoryStr = $gCodes[catnm]. "^" .$rcategory[catnm]. "^";
	}
	
	$datas.="<P>goodcd=".$pData[goodcd]."^".$CategoryStr."^".$pData[goodbrand]."^".$pData[goodnm]."^".
		"http://".$_SERVER[HTTP_HOST]."/shop/goodalign/good_detail.php?goodcd=".$pData[goodcd]."^".
		$pData[nomalprice]."\r\n";
}
?>
<html>
<head><title>오미엔진페이지</title>
<meta http-equiv="Cache-Control" content="no-cache"/> 
<meta http-equiv="Expires" content="0"/> 
<meta http-equiv="Pragma" content="no-cache"/> 
<style>body {font-size:8pt; font-family:"tahoma"; text-decoration: none; line-height: 13pt; color:#333333}</style>
</head>
<body topmargin="0" leftmargin="0">
<pre>
<?=$datas?>
</pre>
</body>
</html>