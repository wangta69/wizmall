<?php
/*
 powered by 폰돌
 Reference URL : http://www.shop-wiz.com
 Contact Email : master@shop-wiz.com
 Free Distributer :

 Copyright shop-wiz.com
 *** Updating List ***
 */
include "../common/header_pop.php";

include ("../../config/common_array.php");

if ($query == "d_update") {
	$sqlstr = "update wizBillcheck set presult = '$presult' where uid = '$uid'";
	$dbcon -> _query($sqlstr);
	echo "<script >opener.location.reload();self.close();</script>";
	exit ;
}

$sqlstr = "SELECT b.*, bu.uid as buuid, bu.AmountOline, bu.PayMethod, bu.OrderStatus  FROM wizBillcheck b
			left join wizBuyers bu on b.oid = bu.OrderID 
 			where b.uid = '$uid'";
$dbcon -> _query($sqlstr);
$list = $dbcon -> _fetch_array();
$uid = $list["uid"];
$oid = $list["oid"];
$mid = $list["mid"];
$buuid = $list["buuid"];
$AmountOline = $list["AmountOline"];
$cnum = $list["cnum"];
$cname = $list["cname"];
$ceoname = $list["ceoname"];
$cuptae = $list["cuptae"];
$cupjong = $list["cupjong"];
$caddress1 = $list["caddress1"];
$cachreceipt = $list["cachreceipt"];
$presult = $list["presult"];
$ptype = $list["ptype"];
switch($ptype) {
	case "1" :
		$ptypestr = "세금계산서";
		break;
	case "2" :
		$ptypestr = "현금영수증";
		break;
}
$presult = $list["presult"];
switch($presult) {
	case "1" :
		$presultstr = "신청";
		break;
	case "2" :
		$presultstr = "완료";
		break;
	case "3" :
		$presultstr = "취소";
		break;
}
$rdate = $list["rdate"];
$PayMethod = $list["PayMethod"];
$PayWay = trim($PayMethod) ? $PaySortArr[$PayMethod] : "온라인";
$OrderStatus = $list["OrderStatus"];
?>
<html>
<head>
<title>위즈몰 관리자 모드 - [세금계산서/현금영수증]</title>
<meta http-equiv="Content-Type" content="text/html; charset==<?=$cfg["common"]["lan"] ?>">
<link rel="stylesheet" href="../common/admin.css" type="text/css">
<script  language="JavaScript" src="../../js/button.js"></script>
<script  language="JavaScript" src="../../js/wizmall.js"></script>
<script>
	function updateStatus(v) {
		var f = document.PublicForm;
		f.presult.value = v.value;
		f.submit();
	}
</script>
</head>
<body>
        <form action='<?=$PHP_SELF ?>' name="PublicForm" method="post">
        	<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
        <input type="hidden" name="uid" value="<?=$uid ?>">
        <input type="hidden" name="query" value="d_update">
        <input type="hidden" name="presult" value="">
        </form>
<table class="table_pop">
  <tr> 
    <td>
<?
if($ptype == "1"){
?>    
      <table>

        <tr> 
          <td colspan="4">세금계산서 발행정보
              <select name="select" id="select" onChange="updateStatus(this);">
                <option value="">선택</option>
<?
foreach ($BillCheckResultArr as $key => $value) {
	$selected = $key == $presult ? "selected" : "";
	echo "<option value='$key' $selected>$value</option>\n";
}
?>                
              </select>
          </td>
        </tr>
        <tr> 
          <th>사업자번호</th>
          <td colspan="3">
          <?=$cnum ?></td>
          </tr>
        <tr> 
          <th>회사명</th>
          <td>
          <?=$cname ?></td>
          <th>대표자명</th>
          <td> 
            <?=$ceoname ?>          </td>
        </tr>
        <tr> 
          <th>업태명</th>
          <td>
          <?=$cuptae ?>          </td>
          <th>종목명</th>
          <td> 
            <?=$cupjong ?>          </td>
        </tr>
        <tr> 
          <th>사업장주소</th>
          <td colspan="3"><?=$caddress1 ?></td>
        </tr>
      </table>  
<?
}else if($ptype == "2"){
?>        
      <table>
        <tr> 
          <td colspan="2">현금영수증 발행정보 <select name="select" id="select" onChange="updateStatus(this);">
                <option value="">선택</option>
<?
foreach ($BillCheckResultArr as $key => $value) {
	$selected = $key == $presult ? "selected" : "";
	echo "<option value='$key' $selected>$value</option>\n";
}
?>                
              </select></td>
        </tr>
  
        <tr> 
          <th>신청자명</th>
          <td>
            <?=$cname ?></td>
          </tr>
        <tr> 
          <th>현금영수증 번호</th>
          <td>
            <?=$cachreceipt ?></td>
          </tr>
      </table>   
<?
}
?>  <table>

        <tr> 
          <td><input type="button" name="button" id="button" value="닫기" style="cursor:pointer" onClick="self.close();"></td>
        </tr>       
    </table></td>
  </tr>
</table>
</body>
</html>