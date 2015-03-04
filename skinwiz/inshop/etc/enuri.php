<?
//------------------------------------------------------------------------------
// 에누리 가격 비교 사이트
// 수정일자 : 2005-04-17 신동규
//								
//------------------------------------------------------------------------------
?>
<HTML>
<HEAD>
<TITLE>:::: 상품 목록(에누리용) ::::</TITLE>
<style type="text/css">
<!--
A:link		{text-decoration: underline; color:steelblue}
A:visited	{text-decoration: none; color:steelblue}
A:hover		{text-decoration: underline; color:RoyalBlue}   
font		{font-family:굴림; font-size:10pt}
th,td		{font-family:굴림; font-size:10pt ; height:15pt}
span		{text-decoration: none;color:red; font-weight:normal;}
//-->
</style>
</HEAD>
<BODY>
<div align='center'><strong><font size='5'>상품 목록(에누리용)</font></strong><P>
<?
	if($submode=="child"){
		
		if($vcode){
			
			$getVirCat=dyngetinfo("SELECT refcd FROM tb_virtureCode WHERE code='$vcode'");
			$ii = 0;
			while($getrefcd=moveArray($getVirCat)){
				if($ii == "0"){
					$codeStrr = mgCode($getrefcd[refcd]);
				}else{
					$codeStrr = $codeStrr . ", " . mgCode($getrefcd[refcd]);
				}
				$ii++;
			}
			$mgCode = $codeStrr;
			
		}else{
			$mgCode=mgCode($cate);
		}
		
		$pageIndex4Query = $pageIndex4Query . " AND good.catcd IN (".$mgCode.") GROUP BY good.goodcd ORDER BY regdt DESC";
		
		$dataQuery = Getinfo($pageIndex4Query,"handle");
		$totProduct = $dbcon->_num_rows($dataQuery);
?>
<center>상품수 : <?=$totProduct?> 개</center>
<table border="0" cellspacing="1" cellpadding="10" bgcolor="white" width="80%" align='center'>
  <TR>
    <TD>
      <table border="0" cellspacing="1" cellpadding="10" bgcolor="black" width="100%" align='center'>
        <tr bgcolor="#ededed">
          <td width='40'>번호</td>
          <td>제품명</td>
          <td>가격</td>
          <td>재고유무</td>
          <!--<td>소분류</td>-->
        </tr>
<?
$jj=1;
while($pData=$dbcon->_fetch_array($dataQuery)){
	$num = $totProduct - intval(($page-1)*$num_per_page) - ($jj-1);   // 페이지 값 계산
	
	$gCodes=getinfo("SELECT catnm FROM tb_category WHERE catcd='$pData[catcd]' AND catcd<>refcd");
	
	if($pData[warehousing] > 1){
		$warehousingStr = "재고있음";
	}else{
		$warehousingStr = "재고없음";
	}
	
	$pData_goodnm = $pData[goodmaker] . " " . $pData[goodnm];
?>
	<tr bgcolor="#ffffff">
		<td width='40'><?=$num?></td>
		<td><a href="http://<?=$_SERVER[HTTP_HOST]?>/shop/goodalign/good_detail.php?goodcd=<?=$pData[goodcd]?>"><?=$pData_goodnm?></a></td>
		<td><?=number_format($pData[nomalprice])?></td>
		<td><?=$warehousingStr?></td>
		<!--<td><?=$gCodes[catnm]?></td>-->
	</tr>
<?
	++$jj;
}
?>
      </table>
    </td>
  </tr>
</table>
<?	}else{	?>
<table border="0" cellspacing="1" cellpadding="10" bgcolor="white" width="80%" align='center'>
  <TR>
    <TD>
      <table border="0" cellspacing="1" cellpadding="5" bgcolor="black" width="100%" align='center'>
        <tr bgcolor="#ededed">
          <td>대분류</td>
          <td>중분류</td>
        </tr>
<?
		if($virtureconfirm == "y"){
			$vcodeQue=dynGetinfo("SELECT codename,code FROM tb_virtureCode GROUP BY code ORDER BY sortC DESC","totLayer");
			while($row=moveArray($vcodeQue)){ //-- 중복설정배제
				$subQuery=dyngetinfo("SELECT catcd,refcd,catnm FROM tb_category WHERE refcd=catcd AND hiddenyn='N' AND virtureCode='$row[code]' ORDER BY catseq, catcd DESC","scateNum");
?>
        <tr bgcolor="#ffffff">
          <td><a href="http://<?=$_SERVER[HTTP_HOST]?>/shop/compare/compare_list.php?pKey=<?=$pKey?>&engine=enuri&submode=child&vcode=<?=$row[code]?>"><?=$row[codename]?></a></td>
          <td>
<?				while($subL=moveArray($subQuery)){	?>
            <a href="http://<?=$_SERVER[HTTP_HOST]?>/shop/compare/compare_list.php?pKey=<?=$pKey?>&engine=enuri&submode=child&cate=<?=$subL[refcd]?>"><?=$subL[catnm]?></a> | 
<?				}	?>
          </td>
        </tr>
<?
			}
		}else{
			$vcodeQue=dynGetinfo("SELECT catcd,refcd,catnm FROM tb_category WHERE refcd=catcd AND hiddenyn='N' ORDER BY catseq, catcd DESC","totLayer");
			while($row=moveArray($vcodeQue)){ //-- 중복설정배제
				$subQuery=dyngetinfo("SELECT catcd,refcd,catnm FROM tb_category WHERE refcd<>catcd AND hiddenyn='N' AND refcd='$row[refcd]' ORDER BY catseq, catcd DESC","scateNum");
?>
       <tr bgcolor="#ffffff">
          <td><a href="http://<?=$_SERVER[HTTP_HOST]?>/shop/compare/compare_list.php?pKey=<?=$pKey?>&engine=enuri&submode=child&cate=<?=$row[catcd]?>"><?=$row[catnm]?></a></td>
          <td>
<?				while($subL=moveArray($subQuery)){	?>
            <a href="http://<?=$_SERVER[HTTP_HOST]?>/shop/compare/compare_list.php?pKey=<?=$pKey?>&engine=enuri&submode=child&cate=<?=$subL[catcd]?>"><?=$subL[catnm]?></a> | 
<?				}	?>
          </td>
        </tr>
<?
			}
		}
?>
      </table>
    </td>
  </tr>
</table>
<?	}	?>
</body>
</html>