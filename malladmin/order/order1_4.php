<?
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/

include "../common/header_pop.php";

/* 엑셀로 출력하기 */ 

if($DownForExel=="yes"){
$Thistime = date("Y-m-d");

header( "Content-type: application/vnd.ms-excel" ); 
header( "Content-Disposition: attachment; filename=${Thistime}.xls" ); 
header( "Content-Description: PHP4 Generated Data" ); 
}
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=euc-kr">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 9">
<style>
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.font519662
	{color:windowtext;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:돋움, monospace;
	mso-font-charset:129;}
.font10pt
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:돋움, monospace;
	mso-font-charset:129;
	mso-number-format:"0_ ";
	text-align:general;
	vertical-align:top;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.font10pt1
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:돋움, monospace;
	mso-font-charset:129;
	mso-number-format:"0_ ";
	text-align:general;
	vertical-align:top;
	border-top:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}		
.xl1519662
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:돋움;
	mso-generic-font-family:auto;
	mso-font-charset:129;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl2419662
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:돋움, monospace;
	mso-font-charset:129;
	mso-number-format:General;
	text-align:general;
	vertical-align:top;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl2519662
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:돋움, monospace;
	mso-font-charset:129;
	mso-number-format:General;
	text-align:general;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl2619662
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:돋움, monospace;
	mso-font-charset:129;
	mso-number-format:"\#\,\#\#0";
	text-align:general;
	vertical-align:top;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl2719662
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:돋움;
	mso-generic-font-family:auto;
	mso-font-charset:129;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl2819662
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:돋움, monospace;
	mso-font-charset:129;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	background:silver;
	mso-pattern:auto none;
	white-space:normal;}
.xl3430225
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:돋움, monospace;
	mso-font-charset:129;
	mso-number-format:"0_ ";
	text-align:general;
	vertical-align:top;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}	
ruby
	{ruby-align:left;}
rt
	{color:windowtext;
	font-size:8.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:돋움, monospace;
	mso-font-charset:129;
	mso-char-type:none;}
-->
</style>
</head>

<body>

  
<table>
  <tr height=53> 
    <td height=53 class=xl2819662 style='height:39.75pt;width:36pt'>연번</td>
    <td class=xl2819662 style='border-left:none;width:80pt'>주문번호</td>
    <td class=xl2819662 style='border-left:none;width:62pt'>제조사<br />
      (브랜드)</td>
    <td class=xl2819662 style='border-left:none;width:41pt'>상품명</td>
    <td class=xl2819662 style='border-left:none;width:36pt'>수량</td>
    <td class=xl2819662 style='border-left:none;width:52pt'>구매금액</td>
    <td class=xl2819662 style='border-left:none;width:48pt'>수령인</td>
    <td class=xl2819662 style='border-left:none;width:110pt'>수령인주소</td>
    <td class=xl2819662 style='border-left:none;width:58pt'>수령인전화</td>
    <td class=xl2819662 style='border-left:none;width:68pt'>수령인핸드폰</td>
    <td class=xl2819662 style='border-left:none;width:48pt'>주문자명</td>
    <td class=xl2819662 style='border-left:none;width:82pt'>주문자 전화번호</td>
    <td class=xl2819662 style='border-left:none;width:101pt'>요구사항</td>
  </tr>
  <?
/* 페이징과 관련된 수식 구하기 */
//$ListNo = "15";
//$PageNo = "20";
//if(empty($cp) || $cp <= 0) $cp = 1;
$START_NO = ($cp - 1) * $ListNo;
if ($WHERE && $keyword) {$WHEREIS = "WHERE $WHERE LIKE '%$keyword%' AND OrderStatus < 50 ";}
else {
if (!$sort) {$sort = "UID";}
if ($sorting) {$WHEREIS = "WHERE OrderStatus='$sorting'";} else {$WHEREIS = "WHERE OrderStatus < 50 ";}
}

$sqlstr = "SELECT count(*) FROM wizBuyers $WHEREIS";
$TOTAL = $dbcon->get_one($sqlstr);
//--페이지 나타내기--
$TP = ceil($TOTAL / $ListNo) ; /* 페이지 하단의 총 페이지수 */
$CB = ceil($cp / $PageNo);
$SP = ($CB - 1) * $PageNo + 1;
$EP = ($CB * $PageNo);
$TB = ceil($TP / $PageNo);
//echo "\$TP = $TP, \$CB = $CB, \$SP = $SP, \$EP = $EP, \$TB = $TB <br />";
//--페이지링크를 작성하기--


$sqlstr = "SELECT SUM(TotalAmount) FROM wizBuyers WHERE OrderStatus < 50";
$TOTAL_SMONEY = $dbcon->get_one($sqlstr);


$sqlstr = "SELECT OrderID, TotalAmount, RName, RTel1, RTel2, RZip, RAddress1, RAddress2, SName, STel1, STel2, Message, OrderStatus, MemberID FROM wizBuyers $WHEREIS ORDER BY $sort DESC LIMIT $START_NO,$ListNo";
$sqlqry = $dbcon->_query($sqlstr);
$NO = $TOTAL-($ListNo*($cp-1));
while( $list = $dbcon->_fetch_array($sqlqry) ) :
		$Message		= iconv("UTF-8", "EUC-KR", nl2br($list["Message"]));
        $RAddress		= iconv("UTF-8", "EUC-KR", "(".$list["RZip"].")".$list["RAddress1"]." ".$list["RAddress2"]);
		$RName			= iconv("UTF-8", "EUC-KR", $list["RName"]);
		$SName			= iconv("UTF-8", "EUC-KR", $list["SName"]);
		$SName			= iconv("UTF-8", "EUC-KR", $list["SName"]);
        $OrderID		= $list["OrderID"];
        //------------------------------------------[결제방식]
        if ($list[PayMethod] == 'card') {$PayWay = "신용카드";}
        else if ($list[PayMethod] == 'point') {$PayWay = "포인트";}
        else if ($list[PayMethod] == 'all') {$PayWay = "다중결제";}
		else if ($list[PayMethod] == 'hand') {$PayWay = "핸드폰";}
        else {$PayWay = "온라인";}
        //--------------------------------------------------
        if (!$list["MemberID"]) {$list["MemberID"] = "비회원";}

if($list[OrderStatus]==10) $DeveryStatus = "<font color='blue'>주문접수됨";
else if($list[OrderStatus]==20) $DeveryStatus = "<font color='green'>입금기다림";
else if($list[OrderStatus]==30) $DeveryStatus = "<font color='orange'>입금확인됨";
else if($list[OrderStatus]==40) $DeveryStatus = "<font color='brown'>배송준비중";
else if($list[OrderStatus]==50) $DeveryStatus = "배송완료됨";
if($PayWay == "신용카드" && $list[OrderStatus] == 10) $DeveryStatus = "결제실패";
?>
  <tr height=32> 
    <td height=32 class=xl2419662 style='height:24.0pt;
  border-top:none;width:36pt' x:num> 
      <?=$NO?>
    </td>
    <td class=xl3430225 style='border-top:none;border-left:
  none;' x:num> 
      <?=$OrderID?>
    </td>
    <td colspan="3" class=xl2419662 style='border-top:none;border-left:none;
  width:62pt'><table width="192">
<?

$substr = "select c.qty, c.price, c.tprice, m.Name, m.Brand from wizCart c left join wizMall m on c.pid = m.uid where c.oid = '$OrderID'";

$subqry = $dbcon->_query($substr);
while($sublist = $dbcon->_fetch_array()){
	$qty	= $sublist["qty"];
	$price	= $sublist["price"];
	$tprice	= $sublist["tprice"];
	$Name	= iconv("UTF-8", "EUC-KR", $sublist["Name"]);
	$Brand	= iconv("UTF-8", "EUC-KR", $sublist["Brand"]);
?>  
        <tr>
          <td width="64" class=font10pt style='border-left:none;width:62pt'><?=$Brand?></td>
          <td width="64" class=font10pt style='border-left:none;width:41pt'><?=$Name?></td>
          <td width="64" class=font10pt1 style='border-left:none;width:36pt'><?=$qty?></td>
        </tr>
<?
}
?>		
      </table></td>
    <td class=xl2619662 style='border-top:none;border-left:
  none;width:52pt' x:num="<?=$list["TotalAmount"]?>"> <?=$list["TotalAmount"]?>
      
    </td>
    <td class=xl2419662 style='border-top:none;border-left:none;
  width:48pt'> 
      <?=$RName?>
    </td>
    <td class=xl2419662 style='border-top:none;border-left:none;
  width:110pt'>
        <?=$RAddress?></td>
    <td class=xl2419662 style='border-top:none;border-left:none;
  width:58pt'> 
      <?=$list[RTel1]?>
    </td>
    <td class=xl2419662 style='border-top:none;border-left:none;
  width:68pt'> 
      <?=$list[RTel2]?>
    </td>
    <td class=xl2419662 style='border-top:none;border-left:none;
  width:48pt'> 
      <?=$SName?>
    </td>
    <td class=xl2419662 style='border-top:none;border-left:none;
  width:82pt'> 
      <?=$list[STel1]?>
    </td>
    <td class=xl2419662 style='border-top:none;border-left:none;
  width:101pt'> 
      <?=$Message?>
    </td>
  </tr>
  <?
$NO--; 
endwhile;
?>
  <tr height=0 style='display:none'> 
    <td width=48 style='width:36pt'></td>
    <td width=63 style='width:47pt'></td>
    <td width=82 style='width:62pt'></td>
    <td width=54 style='width:41pt'></td>
    <td width=48 style='width:36pt'></td>
    <td width=69 style='width:52pt'></td>
    <td style='width:48pt'></td>
    <td width=146 style='width:110pt'></td>
    <td width=77 style='width:58pt'></td>
    <td style='width:68pt'></td>
    <td style='width:48pt'></td>
    <td style='width:82pt'></td>
    <td width=134 style='width:101pt'></td>
  </tr>
</table>

</body>

</html>