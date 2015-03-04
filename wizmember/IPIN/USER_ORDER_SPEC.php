<?php
/*
 제작자 : 폰돌                     
 URL : http://www.shop-wiz.com      
 Email : master@shop-wiz.com       
 Copyright (C) 2003  shop-wiz.com 
*/

if(!$OrderID && !$cfg["member"]) $common->js_alert("잘못된 접근입니다.","./");
 
if($d_mode == "receiptUpdate"){## 세금계산서 발행요청시
	if($ptype == "2") $cname = $cname1;
    unset($ins);
    $ins["mid"] = $mid;
    $ins["oid"] = $OrderID;
    $ins["ptype"] = $ptype;
    $ins["cnum"] = $cnum;
    $ins["cname"] = $cname;
    $ins["ceoname"] = $ceoname;
    $ins["cuptae"] = $cuptae;
    $ins["cupjong"] = $cupjong;
    $ins["cachreceipt"] = $cachreceipt;
    $ins["caddress1"] = $caddress1;
    $ins["presult"] = 1;
    $ins["rdate"] = time();
    
    $result = $dbcon->insertData("wizBillcheck", $ins);
	echo "<script>location.href='$PHP_SELF?query=".$query."&OrderID=".$OrderID."';</script>";
    exit;
}

if($query == "non_member_order"){//non_member_order 일경우  SName 과 같이 비교
    $sqlstr = "
                SELECT 
                    b.*, d.d_name, d.d_code, d.d_url, d.d_inquire_url, d.d_method 
                FROM 
                    wizBuyers b 
                LEFT JOIN
                    wizdeliver d 
                ON 
                    b.Deliverer = d.uid
                WHERE 
                    b.OrderID='".$OrderID."' and b.SName='".$SName."'";
    
}else{//회원가입정보에서  MemberID를 참조하여 추출
    $sqlstr = "
                SELECT 
                    b.*, d.d_name, d.d_code, d.d_url, d.d_inquire_url, d.d_method 
                FROM 
                    wizBuyers b 
                LEFT JOIN
                    wizdeliver d 
                ON 
                    b.Deliverer = d.uid
                WHERE 
                    b.OrderID='".$OrderID."' and b.MemberID='".$cfg["member"]["mid"]."'";
    
}

	$List = $dbcon->_fetch_array($dbcon->_query($sqlstr));

	/*회원으로 로긴 했을 경우 끝*/
	if (!$List) {
		echo "<script>
		window.alert('\\n\\n주문번호 : ".$uid.$OrderID." 에 대한 데이터가  존재하지 않습니다.    \\n\\n관리자에게 문의하십시오.\\n\\n');
		//self.close();
		</script>";
		exit;
	}
	$List["Message"]   = nl2br(stripslashes($List["Message"]));
	$OrderStatus       = $List["OrderStatus"];
	if (!$List["MemberID"]) {$List["MemberID"] = "비회원";}
	$Deliverer		   = $List["Deliverer"];
	$PayMethod		   = $List["PayMethod"];
	$InvoiceNo		   = $List["InvoiceNo"];
	$d_name            = $List["d_name"];
	$d_code            = $List["d_code"];
	$d_url             = $List["d_url"];
	$d_inquire_url     = $List["d_inquire_url"];
	$d_method          = $List["d_method"];
?>
<script>
	function check_bil(v){
		if(v.value == "2"){//현금영수증 신청
			check_comp.style.display = "none";
			check_ind.style.display = "block";
		}else{
			check_comp.style.display = "block";
			check_ind.style.display = "none";
		}
	}
	
	function getDeliveryStatus(targeturl, arg, argvalue, method){//리스트에서 주문조회용
		var url = "./skinwiz/common/delivery.php?targeturl="+targeturl+"&arg="+arg+"&argvalue="+argvalue+"&method="+method;
		wizwindow(url,'DeliveryCheckWindow','');
		//사용법 <a href="getDeliveryStatus('<?php echo $d_inquire_url?>','<?php echo $d_code?>', '<?php echo $InvoiceNo?>', '<?php echo $d_method?>')">배송조회</a>
	}
		
	function checkField(f){//세금계산서 신청관련
		if(f.ptype[0].checked){
			if(f.cnum.value == ""){
				alert('사업자 번호를 입력해 주세요');
				f.cnum.focus();
				//return false;
			}else if(f.cname.value == ""){
				alert('회사명을 입력해 주세요');
				f.cname.focus();
				//return false;
			}else if(f.ceoname.value == ""){
				alert('대표자명을 입력해 주세요');
				f.ceoname.focus();
				//return false;
			}else if(f.cuptae.value == ""){
				alert('업태를 입력해 주세요');
				f.cuptae.focus();
				//return false;
			}else if(f.cupjong.value == ""){
				alert('업종을 입력해 주세요');
				f.cupjong.focus();
				//return false;
			}else if(f.caddress1.value == ""){
				alert('사업장주소를 입력해 주세요');
				f.caddress1.focus();
			//	return false;
			}else f.submit();
		}else if(f.ptype[1].checked){//현금영수증 발행신청
			if(f.cname1.value == ""){
				alert('요청자명을 입력해 주세요');
				f.cname1.focus();
				//return false;
			}else if(f.cachreceipt.value == ""){
				alert('현금영수증 번호를 입력해 주세요');
				f.cachreceipt.focus();
				//return false;
			}else f.submit();
		}else{
			alert('발행방식을 선택해 주세요');
			//return false;
		}
	
	
	}
</script>
<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active">주문 상세 조회</li>
</ul>
<div class="panel">
	주문 상세 조회
	<div class="panel-footer">
		- 고객님께서 주문하신 상품의 상세 내역입니다. <img src="<?php echo $mem_skin_path?>/images/point_cart_01.gif" height="11">고객님께서 
                  선택하신 상품내역입니다.
	</div>
</div>

<?php
$CART_CODE = $OrderID;
$carttype = "orderinfo";

## 관리자와 동일한 부분을 사용함으로 아래와 같이 처리
$basename = basename(__FILE__); // get the file name
$path = str_replace($basename,"",__FILE__);   // get the directory path
include $path."../../skinwiz/cart/".$cfg["skin"]["CartSkin"]."/CART_VIEW.php";
?>
<div class="space15"></div>

<div class="panel panel-default">
  <div class="panel-heading">주문자 정보</div>
  <div class="panel-body">
    <table class="table">
	<col width="200" />
	<col width="*" />
	<tbody>
	<tr>
		<th>입금인</th>
		<td><?php echo $List["Inputer"];?></td>
	</tr>
	<tr>
		<th>보내는
			분</th>
		<td><?php echo $List["SName"];?></td>
	</tr>
	<tr>
		<th>보내는
			분 E-mail</th>
		<td><?php echo "<a href='mailto:".$List["SEmail"]."'>".$List["SEmail"]."</a>";?></td>
	</tr>
	<tr>
		<th>보내는
			분 전화번호</th>
		<td><?php echo $List["STel2"];?></td>
	</tr>
	<tr>
		<th>보내는
			분 휴대폰번호</th>
		<td><?php echo $List["STel2"];?></td>
	</tr>
	<tr>
		<th>수령인</th>
		<td><?php echo $List["RName"];?></td>
	</tr>
	<tr>
		<th>수령인주소</th>
		<td>(<?php echo $List["RZip"];?>) <?php echo $List["RAddress1"]." ".$List["RAddress2"] ;?></td>
	</tr>
	<tr>
		<th>수령인
			전화번호</th>
		<td><?php echo $List["RTel2"];?></td>
	</tr>
	<tr>
		<th>수령인
			휴대폰번호</th>
		<td><?php echo $List["RTel1"];?></td>
	</tr>
	<tr>
		<th>희망배송일</th>
		<td><?php echo number_format($List["ExpectDate"]);?></td>
	</tr>
	<tr>
		<th>배송안내글</th>
		<td><?php echo $List["Message"];?></td>
	</tr>
	</tbody>
</table>
  </div>
</div>




<div class="panel panel-default">
  <div class="panel-heading">배송지정보</div>
  <div class="panel-body">
<table class="table">
	<col width="200" />
	<col width="*" />
	<tbody>
	<tr>
		<th>주문번호</th>
		<td><?php echo $List["OrderID"];?></td>
	</tr>
	<tr>
		<th>주문일자</th>
		<td><?php echo date("Y.m.d",$List["BuyDate"])?></td>
	</tr>
	<tr>
		<th>거래상태</th>
		<td><?php echo $DeliveryStatusArr[$OrderStatus];?>
		</td>
	</tr>
	<tr>
		<th>택배사</th>
		<td><a href="javascript:getDeliveryStatus('<?php echo $d_inquire_url?>','<?php echo $d_code?>', '<?php echo $InvoiceNo?>', '<?php echo $d_method?>')">
			<?php echo $Deliverer?>
			</a> </td>
	</tr>
	<tr>
		<th>송장번호</th>
		<td><a href="javascript:getDeliveryStatus('<?php echo $d_inquire_url?>','<?php echo $d_code?>', '<?php echo $InvoiceNo?>', '<?php echo $d_method?>')">
			<?php echo $List["InvoiceNo"]?>
			</a> </td>
	</tr>
	</tbody>
</table>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">결제정보</div>
  <div class="panel-body">
<table class="table">
	<col width="200" />
	<col width="*" />
	<tbody>
	<tr>
		<th>결제방식</th>
		<td>
<?php 
    if($PayMethod)   {
        echo $PaySortArr[$PayMethod];
	}else {
	    echo "무통장입금";
	}
?></td>
	</tr>
<?php
if ($List["PayMethod"] == 'all') {//다중결제일경우
?>
	<tr>
		<th>온라인입금</th>
		<td><?php echo number_format($List["AmountOline"]);?>원</td>
	</tr>
	<tr>
		<th>입금계좌</th>
		<td><?php echo $List["BankInfo"]?>
		</td>
	</tr>
	<tr>
		<th>신용카드</th>
		<td><?php echo number_format($List["AmountPg"]);?>원</td>
	</tr>
	<tr>
		<th>포인트</th>
		<td><?php echo number_format($List["AmountPoint"]);?>원</td>
	</tr>
<?php
}else if ($List["PayMethod"] == 'online'){//무통장입금일경우
?>
	<tr>
		<th>임금계좌</th>
		<td><?php echo $List["BankInfo"]?>
		</td>
	</tr>
<?php
}
//--------------------------------------------------
?>
</tbody>
</table>
  </div>
</div>

<?php
if($OrderStatus >= 30 && $OrderStatus < 60 && $PayMethod == "online"){
//신청여부 확인
	$substr = "select * from wizBillcheck where oid = '$OrderID'";
	$subqry = $dbcon->_query($substr);
	$sublist = $dbcon->_fetch_array($subqry);
	if($sublist[0]){//이미 신청이 된 상태이면
	$uid		= $sublist["uid"];
	$mid		= $sublist["mid"];
	$oid		= $sublist["oid"];
	$ptype		= $sublist["ptype"];
	$cnum		= $sublist["cnum"];
	$cname		= $sublist["cname"];
	$ceoname	= $sublist["ceoname"];
	$cuptae		= $sublist["cuptae"];
	$cupjong	= $sublist["cupjong"];
	$cachreceipt= $sublist["cachreceipt"];
	$caddress1	= $sublist["caddress1"];
	$presult	= $sublist["presult"];
	$rdate		= $sublist["rdate"];
	$pdate		= $sublist["pdate"];
	switch($ptype){
		case "1":$ptypestr = "세금계산서";break;
		case "2":$ptypestr = "현금영수증";break;
	}
?>
세금계산서/현금영수증발행<br />
발행방식 :
<?php echo $ptypestr?>
<?php
if($ptype == "1"){
?>
현재 발행이 신청되었습니다. 수정사항이 있을 경우 고객센터로 요청 바랍니다.
<table class="table">
	<col width="130" />
	<col width="*" />
	<col width="130" />
	<col width="*" />
	<tbody>
	<tr>
		<th>요청일</th>
		<td colspan="3"><?php echo date("Y.m.d", $rdate)?>
		</td>
	</tr>
	<tr>
		<th>사업자번호</th>
		<td colspan="3"><?php echo $cnum?>
		</td>
	</tr>
	<tr>
		<th>회사명</th>
		<td><?php echo $cname?></td>
		<th>대표자명</th>
		<td><?php echo $ceoname?></td>
	</tr>
	<tr>
		<th>업태</th>
		<td><?php echo $cuptae?></td>
		<th>종목</th>
		<td><?php echo $cupjong?></td>
	</tr>
	<tr>
		<th>사업장주소</th>
		<td colspan="3"><?php echo $caddress1?></td>
	</tr>
	</tbody>
</table>
<?php
}else if($ptype == "2"){
?>
현재 발행이 신청되었습니다. 수정사항이 있을 경우 고객센터로 요청 바랍니다.
<table style="display:none" id="check_ind" class="table">
	<col width="130" />
	<col width="*" />
	<col width="130" />
	<col width="*" />
	<tbody>
	<tr>
		<th>요청일</th>
		<td colspan="3"><?php echo date("Y.m.d", $rdate)?></td>
	</tr>
	<tr>
		<th>요청자명</th>
		<td><?php echo $cname?></td>
		<th>현금영수증번호</th>
		<td><?php echo $cachreceipt?></td>
	</tr>
	</tbody>
</table>
<?php
}//}else if($ptype == "2"){

	}else{//if($sublist){ 신청이 안된 상태이면
?>
세금계산서/현금영수증발행
<form id="form1" name="form1" method="post" action="" onsubmit="return checkField(this)">
	<input type="hidden" name="query" value="<?php echo $query?>" />
	<input type="hidden" name="OrderID" value="<?php echo $OrderID?>" />
	<input type="hidden" name="d_mode" value="receiptUpdate" />
	발행방식 :
	<input name="ptype" type="radio" id="radio" value="1" checked="checked" onclick="check_bil(this)">
	세금계산서
	<input type="radio" name="ptype" id="radio2" value="2" onclick="check_bil(this)">
	현금영수증
	<table style="display:block" id="check_comp" class="table">
		<col width="130" />
		<col width="*" />
		<col width="130" />
		<col width="*" />
		<tbody>
		<tr>
			<th>사업자번호</th>
			<td colspan="3"><input type="text" name="cnum" id="cnum" />
			</td>
		</tr>
		<tr>
			<th>회사명</th>
			<td><input type="text" name="cname" id="cname" /></td>
			<th>대표자명</th>
			<td><input type="text" name="ceoname" id="ceoname" /></td>
		</tr>
		<tr>
			<th>업태</th>
			<td><input type="text" name="cuptae" id="cuptae" /></td>
			<th>종목</th>
			<td><input type="text" name="cupjong" id="cupjong" /></td>
		</tr>
		<tr>
			<th>사업장주소</th>
			<td colspan="3"><input name="caddress1" type="text" id="caddress1" /></td>
		</tr>
		</tbody>
	</table>
	<table style="display:none" id="check_ind" class="table">
		<col width="130" />
		<col width="*" />
		<col width="130" />
		<col width="*" />
		<tbody>
		<tr>
			<th>요청자명</th>
			<td><input type="text" name="cname1" id="cname1" /></td>
			<th>현금영수증번호</th>
			<td><input type="text" name="cachreceipt" id="cachreceipt" /></td>
		</tr>
		</tbody>
	</table>
	<div class="btn_box">
		<input type="submit" name="button" id="button" value="요청" />
	</div>
</form>
<?
	}//if($sublist){//이미 신청이 된 상태이면
}
?>
<div class="btn_box">


	<span class="btn_confirm btn btn-success"><a href='#' onclick='jvascript:self.print()'>출력하기</a></span>
<br />
