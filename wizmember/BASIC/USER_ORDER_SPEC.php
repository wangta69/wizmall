<?php
/*
 제작자 : 폰돌                     
 URL : http://www.shop-wiz.com      
 Email : master@shop-wiz.com       
 Copyright (C) 2003  shop-wiz.com 
*/
?>
<?
if(!$OrderID && !$cfg["member"]) $common->js_alert("잘못된 접근입니다.","./");
 
if($d_mode == "receiptUpdate"){## 세금계산서 발행요청시
	if($ptype == "2") $cname = $cname1;
	$sqlstr = "insert into wizBillcheck (mid,oid,ptype,cnum,cname,ceoname,cuptae,cupjong,cachreceipt,caddress1,presult,rdate)
				values
				('$mid','$OrderID','$ptype','$cnum','$cname','$ceoname','$cuptae','$cupjong','$cachreceipt','$caddress1',1,".time().")";
	$result = $dbcon->_query($sqlstr);
	if($result){
		echo "<script>location.href='$PHP_SELF?query=$query&OrderID=$OrderID';</script>";
	}
}
//if($uid){ 
//	$sqlstr = "SELECT * FROM wizBuyers WHERE OrderID='$uid'";
//	$List = $dbcon->_fetch_array($dbcon->_query($sqlstr));
//}else if($OrderID){ 
	$sqlstr = "SELECT b.*, d.d_name, d.d_code, d.d_url, d.d_inquire_url, d.d_method FROM wizBuyers b 
				left join wizdeliver d on b.Deliverer = d.uid
				WHERE b.OrderID='$OrderID'";
	$List = $dbcon->_fetch_array($dbcon->_query($sqlstr));
//}
	/*회원으로 로긴 했을 경우 끝*/
	if (!$List) {
		ECHO "<script language=javascript>
		window.alert('\\n\\n주문번호 : ${uid}$OrderID 에 대한 데이터가 삭제되었습니다.    \\n\\n관리자에게 문의하십시오.\\n\\n');
		self.close();
		</script>";
		exit;
	}
	$List[Message]		= nl2br(stripslashes($List["Message"]));
	$OrderStatus		= $List["OrderStatus"];
	if (!$List[MemberID]) {$List[MemberID] = "비회원";}
	$Deliverer		=$List["Deliverer"];
	$PayMethod		= $List["PayMethod"];
	$InvoiceNo		= $List["InvoiceNo"];
	
	$d_name			= $List["d_name"];
	$d_code			= $List["d_code"];
	$d_url			= $List["d_url"];
	$d_inquire_url	= $List["d_inquire_url"];
	$d_method		= $List["d_method"];
?>
<script language="javascript">
<!--
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
		//사용법 <a href="getDeliveryStatus('<?=$d_inquire_url?>','<?=$d_code?>', '<?=$InvoiceNo?>', '<?=$d_method?>')">배송조회</a>
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
//-->
</script>

<div class="navy">Home &gt; 주문 조회</div>
- 고객님께서 주문하신 상품의 상세 내역입니다. <img src="<?=$mem_skin_path?>/images/point_cart_01.gif" height="11">고객님께서 
                  선택하신 상품내역입니다.
<?
$CART_CODE = $OrderID;
$carttype = "orderinfo";

## 관리자와 동일한 부분을 사용함으로 아래와 같이 처리
$basename = basename(__FILE__); // get the file name
$path = str_replace($basename,"",__FILE__);   // get the directory path
include $path."../../skinwiz/cart/".$cfg["skin"]["CartSkin"]."/CART_VIEW.php";
?>
<div class="space15"></div>
<img src="<?=$mem_skin_path?>/images/title_orderinfo02.gif" width="114">
<table class="table_main w100p">
	<col width="130" />
	<col width="*" />
	<tbody>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">입금인</th>
		<td><? ECHO "$List[Inputer]";?></td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">보내는
			분</th>
		<td><? ECHO "$List[SName]";?></td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">보내는
			분 E-mail</th>
		<td><?ECHO "<a href='mailto:$List[SEmail]'>$List[SEmail]</a>";?></td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">보내는
			분 전화번호</th>
		<td><? ECHO"$List[STel2]";?></td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">보내는
			분 휴대폰번호</th>
		<td><? ECHO"$List[STel2]";?></td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">수령인</th>
		<td><? ECHO $List[RName];?></td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">수령인주소</th>
		<td>(<? ECHO"$List[RZip]";?>) <? ECHO $List[RAddress1]." ".$List[RAddress2] ;?></td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">수령인
			전화번호</th>
		<td><? ECHO"$List[RTel2]";?></td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">수령인
			휴대폰번호</th>
		<td><? ECHO"$List[RTel1]";?></td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">희망배송일</th>
		<td><? ECHO number_format($List[ExpectDate]);?></td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">배송안내글</th>
		<td><?ECHO "$List[Message]";?></td>
	</tr>
	</tbody>
</table>
<img src="<?=$mem_skin_path?>/images/title_ing.gif" width="83">
<table class="table_main w100p">
	<col width="130" />
	<col width="*" />
	<tbody>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">주문번호</th>
		<td><?ECHO "$List[OrderID]";?></td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">주문일자</th>
		<td><?=date("Y.m.d",$List[BuyDate])?></td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">거래상태</th>
		<td><?=$DeliveryStatusArr[$OrderStatus];?>
		</td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">택배사</th>
		<td><a href="javascript:getDeliveryStatus('<?=$d_inquire_url?>','<?=$d_code?>', '<?=$InvoiceNo?>', '<?=$d_method?>')">
			<?=$Deliverer?>
			</a> </td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">송장번호</th>
		<td><a href="javascript:getDeliveryStatus('<?=$d_inquire_url?>','<?=$d_code?>', '<?=$InvoiceNo?>', '<?=$d_method?>')">
			<?=$List[InvoiceNo]?>
			</a> </td>
	</tr>
	</tbody>
</table>
<img src="<?=$mem_skin_path?>/images/title_payment01.gif">
<table class="table_main w100p">
	<col width="130" />
	<col width="*" />
	<tbody>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">결제방식</th>
		<td><? if($PayMethod)   { echo "$PaySortArr[$PayMethod]";
					    }else {
						                echo "무통장입금";
						}
					?></td>
	</tr>
	<?
if ($List[PayMethod] == 'all') {//다중결제일경우
?>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">온라인입금</th>
		<td><?ECHO number_format($List[AmountOline]);?>원</td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">입금계좌</th>
		<td><?=$List[BankInfo]?>
		</td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">신용카드</th>
		<td><?ECHO number_format($List[AmountPg]);?>원</td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">포인트</th>
		<td><?ECHO number_format($List[AmountPoint]);?>원</td>
	</tr>
	<?
}else if ($List[PayMethod] == 'online'){//무통장입금일경우
?>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">임금계좌</th>
		<td><?=$List[BankInfo]?>
		</td>
	</tr>
	<?
}
//--------------------------------------------------
?>
</tbody>
</table>
<?
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
<img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9" />발행방식 :
<?=$ptypestr?>
<?
if($ptype == "1"){
?>
<img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">현재 발행이 신청되었습니다. 수정사항이 있을 경우 고객센터로 요청 바랍니다.
<table class="table_main w100p">
	<col width="130" />
	<col width="*" />
	<col width="130" />
	<col width="*" />
	<tbody>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">요청일</th>
		<td colspan="3"><?=date("Y.m.d", $rdate)?>
		</td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">사업자번호</th>
		<td colspan="3"><?=$cnum?>
		</td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">회사명</th>
		<td><?=$cname?></td>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9" />대표자명</th>
		<td><?=$ceoname?></td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">업태</th>
		<td><?=$cuptae?></td>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9" />종목</th>
		<td><?=$cupjong?></td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">사업장주소</th>
		<td colspan="3"><?=$caddress1?></td>
	</tr>
	</tbody>
</table>
<?
}else if($ptype == "2"){
?>
<img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">현재 발행이 신청되었습니다. 수정사항이 있을 경우 고객센터로 요청 바랍니다.
<table style="display:none" id="check_ind" class="table_main w100p">
	<col width="130" />
	<col width="*" />
	<col width="130" />
	<col width="*" />
	<tbody>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">요청일</th>
		<td colspan="3"><?=date("Y.m.d", $rdate)?></td>
	</tr>
	<tr>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">요청자명</th>
		<td><?=$cname?></td>
		<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9" />현금영수증번호</th>
		<td><?=$cachreceipt?></td>
	</tr>
	</tbody>
</table>
<?
}
?>
<?
	}else{//if($sublist){ 신청이 안된 상태이면
?>
세금계산서/현금영수증발행
<form id="form1" name="form1" method="post" action="" onsubmit="return checkField(this)">
	<input type="hidden" name="query" value="<?=$query?>" />
	<input type="hidden" name="OrderID" value="<?=$OrderID?>" />
	<input type="hidden" name="d_mode" value="receiptUpdate" />
	<img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9" />발행방식 :
	<input name="ptype" type="radio" id="radio" value="1" checked="checked" onclick="check_bil(this)">
	세금계산서
	<input type="radio" name="ptype" id="radio2" value="2" onclick="check_bil(this)">
	현금영수증
	<table style="display:block" id="check_comp" class="table_main w100p">
		<col width="130" />
		<col width="*" />
		<col width="130" />
		<col width="*" />
		<tbody>
		<tr>
			<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">사업자번호</th>
			<td colspan="3"><input type="text" name="cnum" id="cnum" />
			</td>
		</tr>
		<tr>
			<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">회사명</th>
			<td><input type="text" name="cname" id="cname" /></td>
			<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9" />대표자명</th>
			<td><input type="text" name="ceoname" id="ceoname" /></td>
		</tr>
		<tr>
			<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">업태</th>
			<td><input type="text" name="cuptae" id="cuptae" /></td>
			<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9" />종목</th>
			<td><input type="text" name="cupjong" id="cupjong" /></td>
		</tr>
		<tr>
			<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">사업장주소</th>
			<td colspan="3"><input name="caddress1" type="text" id="caddress1" /></td>
		</tr>
		</tbody>
	</table>
	<table style="display:none" id="check_ind" class="table_main w100p">
		<col width="130" />
		<col width="*" />
		<col width="130" />
		<col width="*" />
		<tbody>
		<tr>
			<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9">요청자명</th>
			<td><input type="text" name="cname1" id="cname1" /></td>
			<th><img src="<?=$mem_skin_path?>/images/point_list_01.gif" width="21" height="9" />현금영수증번호</th>
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
	<!-- <a href='#' onclick='jvascript:self.close()'><img src="<?=$mem_skin_path?>/images/but_close.gif"></a> -->
	<a href='#' onclick='jvascript:self.print()'><img src="<?=$mem_skin_path?>/images/but_print.gif"></a></div>
<br />
