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

include ("../../lib/class.wizmall.php");
$mall = new mall;
$mall->db_connect($dbcon);

include ("../../lib/class.cart.php");
$cart = new cart();
$cart->get_object($dbcon);

include "../../lib/class.mail.php";


###################################################
##################### 배송상태 변경 시작 ##########
###################################################
if($common->checsrfkey($csrf)){
	switch($mode){
		case "chg_deliveryStatus": // 배송상태 변경
		
		// config/common_array.php 에서 설정 $DeliveryStatusArr = array("10"=>"주문접수", "20"=>"입금대기", "30"=>"입금확인", "40"=>"배송준비", "50"=>"배송완료", "60"=>"물품반송", "70"=>"주문삭제");
			$c_orderstatus	= intval($c_orderstatus);
			$OrderStatus	= intval($OrderStatus);
			
			if (!$OrderStatus || !$c_orderstatus || !$uid) $common->js_alert("잘못된 경로 접근(변수누락)","$PHP_SELF?uid=".$uid);
			
			if ($OrderStatus == $c_orderstatus) $common->js_alert("잘못된 경로 접근(배송상태변경없음)","$PHP_SELF?uid=".$uid);
			
			
			if($c_orderstatus){//무통장입금일경우 입금확인일 입력
				if(($c_orderstatus <= 20) && ($OrderStatus >= 30 || $OrderStatus <= 50)){
					$PayDate=time();
					$sqlstr = "update wizBuyers SET PayDate = '".$PayDate."' WHERE UID=".$uid;
					$dbcon->_query($sqlstr);				
				}		
			}
		
			## 현재의 OrderID 를 구한다.
			$oid	= $cart->get_order_id($uid);
			$cart->ch_buyer_sta($uid, $OrderStatus);## wizBuyers table 상태값 변경
			$cart->ch_cart_sta($oid, $OrderStatus);## wizCart table 에서의 개개항목에 대한 상태값 변경
		
			if ($OrderStatus == 50) {   // 배송완료이면 재고 및 기타 부분 수정
				$sqlstr = "select MemberID, AmountPoint from wizBuyers where OrderID = ".$oid;
				$list			= $dbcon->get_row($sqlstr);
				$MemberID		= $list["MemberID"]; 
				$AmountPoint	= $list["AmountPoint"];
		//print_r($list);		 
				## 재고갯수 차감
				$sqlstr = "select uid, pid, qty, point from wizCart where oid = ".$oid;
				$qry = $dbcon->_query($sqlstr);
		
				while($list =$dbcon->_fetch_array($qry)):
					$cuid	= $list["uid"];
					$pid	= $list["pid"];
					$qty	= $list["qty"];
					$point	= $list["point"];
					
					## 재고 갯수 변경
					$cart->stock("cuid",$cuid,50,40);
					
					##주문완료에 따른 포인트 입력(포인트 결제일경우 포인트를 생성하지 않음)
					if($MemberID && !$AmountPoint){
						$point = $point * $qty;
						$common->point_fnc($MemberID, $point, 21, $cuid);
					}
				
				endwhile;
				
				## 포인트 결제시 포인트 차감(
				if ($MemberID && $AmountPoint) {
					$point = -$AmountPoint;
					$common->point_fnc($MemberID, $point, 23, $oid);
				}
		
				## 메일을 발송한다.
		
			}//if ($OrderStatus == 50 ) { 
		
			if ($c_orderstatus == 50) {  //배송완료에서 기타 단계로 이동시
			
				$sqlstr = "select MemberID, AmountPoint from wizBuyers where OrderID = ".$oid;
				$dbcon->_query($sqlstr);
				$MemberID		= $list["MemberID"]; 
				$AmountPoint	= $list["AmountPoint"];
				 
				$sqlstr = "select uid, pid, qty, point from wizCart where oid = ".$oid;
				$qry = $dbcon->_query($sqlstr);
		
				while($list =$dbcon->_fetch_array($qry)):
					$cuid	= $list["uid"];
					$pid	= $list["pid"];
					$qty	= $list["qty"];
					$point	= $list["point"];
					
					## 재고 갯수 변경
					$cart->stock("cuid",$cuid,10,50);
					
					//주문완료에서 일반변경에 따른 포인트 제거
					if($MemberID && !$AmountPoint){
						$point = $point * $qty;
						$common->point_fnc($MemberID, $point, 22, $oid);
					}
				endwhile;
				
				// 포인트 결제시 포인트 복귀
				if ($MemberID && $AmountPoint) {
					$content = "주문번호:".$member_code;
					$point = +$AmountPoint;
					$common->point_fnc($MemberID, $point, 24, $oid);
				}
				
			}//if ($c_orderstatus == 50) {  
		
			##################### 문자 전송 시작 ##########
			if ($sms_send == 'Y' && $sms_tel && $sms_message) { /////////////////////////////// SMS 전송
			// 사용되는 변수
			// $sms_tel : 수신자 번호
			//$sms_message =  : 발신내용
			// $sms_sender_tel : 발신자 번호
			// $sms_sender_name : 발신자명
			// $sms_sender_id : 발신자 아이디
			//$sms_sender_pwd : 발신자 패스워드	
			//include "./skin_sms/ANYSMS/smsindex.php"; //이곳에 수정된 모듈이 들어간다.
			include "./skin_sms/ICODE/smsindex.php"; //이곳에 수정된 모듈이 들어간다.
			}
		
			##################### 이메일 전송 시작 ##########
		
			$msglist = $admin->getmessage_cont($OrderStatus, "mail");
			//print_r($msglist);
			if($msglist["enable"]){
				## 주문자 이메일 가져오기
				$substr = "select SEmail, InvoiceNo from wizBuyers where UID = ".$uid;
				//$subqry = $dbcon->_query($substr);
				$sublist = $dbcon->get_row($substr);
				//$sender_email = $sublist["SEmail"];
				$skinfile = file_get_contents("../mailskin/".$msglist["skin"]."/mailform.php");
		
				$msglist["message"] = str_replace("{주문번호}", $oid, $msglist["message"]);
				$msglist["message"] = str_replace("{송장번호}", $sublist["InvoiceNo"], $msglist["message"]);
				$skinfile = str_replace("{CONTENTS}", $msglist["message"], $skinfile);
				$skinfile = str_replace("{MART_BASEDIR}", $cfg["admin"]["MART_BASEDIR"], $skinfile);
				
		
				$mail		= new classMail();
				$mail->From ($cfg["admin"]["ADMIN_EMAIL"], $common->conv_euckr($cfg["admin"]["ADMIN_TITLE"]));
				$mail->To ($sublist["SEmail"]);
				$mail->Organization ($common->conv_euckr($cfg["admin"]["ADMIN_TITLE"]));
				$mail->Subject ($common->conv_euckr($msglist["subject"]));
				$mail->Body ($common->conv_euckr($skinfile));
				$mail->Priority (3);
				//$mail->debug	= true;
				$ret = $mail->Send();
		
			}
		
			# 이메일 및 sms 문자 메시지 전송 끝 ##########
		
			$common->js_location("$PHP_SELF?uid=".$uid);
		break;
		case "qde":##################### 주문데이터삭제 ##########
			$sqlstr = "select OrderID from wizBuyers where UID=".$uid;
			$oid= $dbcon->get_one($sqlstr);
				
			$sqlstr = "select uid, pid, qty, point from wizCart where oid = ".$oid;
			$qry = $dbcon->_query($sqlstr);
		
			while($list =$dbcon->_fetch_array($qry)):
				$cuid = $list["uid"];
				$pid = $list["pid"];
				$qty = $list["qty"];
				$point = $list["point"];
				## 재고 갯수 변경
				$cart->stock("cuid",$cuid,0,10);
			endwhile;
				
			$dbcon->_query("DELETE FROM wizBuyers WHERE UID=$uid");
			$dbcon->_query("DELETE FROM wizCart WHERE oid='$oid'");
			echo "<script >window.alert('\\n\\n주문데이터가 삭제되었습니다.\\n\\n');window.opener.location.reload();self.close();</script>";
			exit;
		break;
		case "delever_update":/* 택배사 및 택배번호 입력 */
			$sqlstr = "update wizBuyers SET Deliverer = '$Deliverer', InvoiceNo = '$InvoiceNo' WHERE UID='$uid'";
			$dbcon->_query($sqlstr);
			//추후 다중배송을 위해 (개별일경우 별도의 값을 전송, 현재는 이렇게 처리
			$sqlstr = "update wizCart SET deliverer = '$Deliverer', invoiceno = '$InvoiceNo' WHERE oid='$oid'";
			$dbcon->_query($sqlstr);
		break;
		case "chg_address": /* 택배사 및 택배번호 입력 */
			$RZip = $RZip1."-".$RZip2;
			$Message	 = addslashes($_POST["Message"]);
			$sqlstr = "update wizBuyers set RZip='$RZip', RAddress1='$RAddress1', RAddress2='$RAddress2', RTel1='$RTel1', Message='$Message' WHERE UID='$uid'";
			$result = $dbcon->_query($sqlstr);
		break;
	
	}
}//if($common->checsrfkey($csrf)){

include "../common/header_html.php";
?>
<script>
$(function(){
	//메시지 관리
	$(".btn_manage_message").click(function(){
		window.open("./order1_2.php?what=sms", "SMSMessageManagerWindow","width=470,height=500,statusbar=no,scrollbars=yes,toolbar=no");
	});
});

function down_excel(id){
	location.href = './order1_3.php?DownForExel=yes&uid='+id;
}

function really() {
	if (confirm('\n\n이미 거래가 완료된 상태입니다.  \n\n거래가 완료된 상태에서 변경할 경우 \n\n회원에게 부여되었던 포인트 및 \n\n제품판매 정보가 거래완료이전 상태로 되돌려 집니다.\n\n정말로 변경하시겠습니까?  \n\n')) return true;
	return false;
}

function change_flag(flag){
	if(flag == "reorder"){ //재주문처리
	}else if(flag == "2"){
	}else if(flag == "reset"){ //초기상태로 변경
	}

}

function openwindow(uid){
	window.open('./order1_1_1.php?uid='+uid,'AddressChangeForm','width=600,0');
}

function changeDeliveryInfo(flag){
	var f = document.OrderinfoForm;
	if(flag == "chg_deliveryStatus"){//거래상태변경
		if(f.c_orderstatus.value != f.OrderStatus.value){
			f.mode.value = flag;
			f.submit();
		}
	}else if(flag == "qde"){//주문삭제
		if (!confirm('\n\n삭제된 주문데이터는 복구가 불가능합니다.  \n\n정말로 삭제하시겠습니까?  \n\n'))return false;
		else {
			f.mode.value = flag;
			f.submit();
		}
	}else if(flag == "delever_update"){//송장번호 입력
		f.mode.value = flag;
		f.submit();
	}else if(flag == "chg_address"){//주소변경(기타 정보도 이것으로 처리)
		f.mode.value = flag;
		f.submit();
	}
}

function OpenZipcode(){
	wizwindow("../../util/zipcode/zipcode.php?form=OrderinfoForm&zip1=RZip1&zip2=RZip2&firstaddress=RAddress1&secondaddress=RAddress2","ZipWin","width=490,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no");
}

</script>
<?php
$LIST_QUERY = "select * FROM wizBuyers WHERE UID=".$uid;//주문자 정보가져오기
//echo "\$LIST_QUERY = $LIST_QUERY <br />";
$List = $dbcon->_fetch_array($dbcon->_query($LIST_QUERY));
$List["Message"]	= nl2br(stripslashes($List["Message"]));
$OrderID			= $List["OrderID"];
$ExpressDeliverFee	= $List["ExpressDeliverFee"];
$RZip				= explode("-", $List["RZip"]);
if (!$List["MemberID"]) {$List["MemberID"] = "비회원";}

?>
<form action='<?php echo $PHP_SELF?>' name="OrderinfoForm" method="post">
	<input type="hidden" name="csrf" value="<?=$common->getcsrfkey()?>">
	<input type="hidden" name="uid" value='<?php echo $uid?>'>
	<input type="hidden" name="mode" value=''>
	<input type="hidden" name="c_orderstatus" value='<?php echo $List["OrderStatus"]?>'>
	<input type="hidden" name="oid" value='<?php echo $List["OrderID"]?>'>
<div class="orange b">배송상세정보</div>
<?php
$CART_CODE = $OrderID;
$carttype = "orderinfo";
include "../../skinwiz/cart/".$cfg["skin"]["CartSkin"]."/CART_VIEW.php";
if($ExpressDeliverFee){
	echo "<div class='msgBox'>특송료 : ".number_format($ExpressDeliverFee)."</div>";
}
?>
<div class="orange b">[ 주문자 정보 ]</div>
<table class="table">
	<col width="120" />
	<col width="*" />
	<col width="120" />
	<col width="120" />
	<tr>
		<th>주문자</th>
		<td><a  href='mailto:$List[SEmail]'>
			<?php echo $List["SName"]?>
			</a> (
			<?php echo $List["MemberID"]?>
			)</td>
		<th>상호명</th>
		<td><?php echo $List["RCompany"]?>
		</td>
	</tr>
	<tr>
		<th>E-mail</th>
		<td><a  href='mailto:<?php echo $List["SEmail"]?>'>
			<?php echo $List["SEmail"]?>
			</a> </td>
		<th>전화번호</th>
		<td><?php echo $List["STel1"]?>
		</td>
	</tr>
	<tr>
		<th>휴대폰</th>
		<td><a  href='mailto:<?php echo $List["SEmail"]?>'> </a>
			<?php echo $List["STel2"]?>
		</td>
		<th>수령인</th>
		<td><?php echo $List["RName"]?>
		</td>
	</tr>
	<tr>
		<th>우편번호</th>
		<td colspan="3"><input name="RZip1" type="text"  value="<?php echo $RZip[0]?>" class="w30">
						-
						<input name="RZip2" type="text"  value="<?php echo $RZip[1]?>" class="w30"><button type="button" onClick='OpenZipcode()'>우편번호검색</button><button name="주소변경" onClick="changeDeliveryInfo('chg_address');" title="주소변경">주소변경</button>
				</td>
	</tr>
	<tr>
		<th>배송지주소</th>
		<td colspan="3"><input name="RAddress1" type="text" id="RAddress1" value="<?php echo $List["RAddress1"]?>"  class="w300"></td>
	</tr>
	<tr>
		<th>상세주소</th>
		<td colspan="3"><input name="RAddress2" type="text" id="RAddress2" value="<?php echo $List["RAddress2"]?>"  class="w300"></td>
	</tr>
	<tr>
		<th>배송지전화 </th>
		<td><input name="RTel1" type="text" id="RTel1" value="<?php echo $List["RTel1"]?>"  class="w100"><button name="변경" onClick="changeDeliveryInfo('chg_address');" title="변경">변경</button>
		</td>
		<th>희망배송일</th>
		<td><?php echo $List["ExpectDate"]?>
		</td>
	</tr>
	<tr>
		<th>배송안내글</th>
		<td colspan="3"><textarea name="Message" rows="5" id="ir1" style="width:98%"><?php echo $List["Message"]?></textarea>
		<button name="변경" onClick="changeDeliveryInfo('chg_address');" title="변경">변경</button>
		</td>
	</tr>
</table>
<div class="orange b">[ 주문상태 ]</div>
<table class="table">
	<col width="120" />
	<col width="*" />
	<col width="120" />
	<col width="120" />
	<tr>
		<th>메일내용변경</th>
		<td colspan="3"><span class="button bull"><a href='javascript:window.open("./order1_2_mail.php","","width=450, height=600, scrollbars=1")'>메일내용변경</a></span> </td>
	</tr>
	<tr>
		<th>주문번호 </th>
		<td><?php echo $List["OrderID"]?>
		</td>
		<th>주문일자</th>
		<td><?php echo date("Y.m.d", $List["BuyDate"])?>
		</td>
	</tr>
	<tr>
		<th>거래상태</th>
		<td colspan="3"><?php            
//$DeliveryStatusArr = array("10"=>"주문접수", "20"=>"입금대기", "30"=>"입금확인", "40"=>"배송준비", "50"=>"배송완료", "60"=>"물품반송", "70"=>"주문삭제");

// case 1. 물품반송->재주문처리
// case 2. 일반
//case 3. 배송완료->초기상태
//case 배송완료상태에서는 주문삭제 불가 
?>
			 <select name='OrderStatus'>
							<?
reset($DeliveryStatusArr);
while(list($key, $value) = each($DeliveryStatusArr)):
 				if($List["OrderStatus"] == $key) $selected = "selected";
				else unset($selected);
				echo "<option value='".$key."' ".$selected.">".$value."</option>\n";

endwhile;
?>
							<?
//ArraytoSelect($DeliveryStatusArr,$List[OrderStatus],$flag=1)
?>
						</select>
					 <span class="button bull"><a href="javascript:changeDeliveryInfo('chg_deliveryStatus')">변경</a></span> </td>
	</tr>
</table>
<div class="orange b">[ 택배사 및 송장번호]</div>
<table class="table">
	<col width="120" />
	<col width="*" />
	<col width="120" />
	<col width="120" />
	<tr>
		<th>택배사</th>
		<td><select name="Deliverer" id="Deliverer">
				<option value="">선택</option>
<?php
$substr = "select uid, d_name from wizdeliver";
$subqry = $dbcon->_query($substr);
while($sublist = $dbcon->_fetch_array()):
	$selected = $List["Deliverer"] == $sublist["uid"] ? "selected":"";
	echo "<option value='".$sublist["uid"]."' $selected>".$sublist["d_name"]."</option>\n";
endwhile;
?>
			</select>
		</td>
		<th>송장번호</th>
		<td>
			<input name="InvoiceNo" value="<?php echo $List["InvoiceNo"]?>">
			<button type="button" onClick="changeDeliveryInfo('delever_update')">송장번호변경</button>
		</td>
	</tr>
</table>
<div class="orange b">[ SMS 발송 및 관리]
<table class="table">
	<col width="120" />
	<col width="*" />
	<tr>
		<th>SMS발송</th>
		<td><table>
<?php
$MobilNoSplit = explode("-",$List["STel2"]);
for($i=0; $i < sizeof($MobilNoSplit); $i++){
$MobilNo .= $MobilNoSplit[$i];
}
                if($List["OrderStatus"]==20 && file_exists("../config/MSG1_sms.cgi")){
                        $sms_msgdata = file("../config/MSG1_sms.cgi");
                        for($x=0;$x<sizeof($sms_msgdata[$x]);$x++){
                                $sms_msg .= $sms_msgdata[$x];
                        }
                }
                if($List["OrderStatus"]==30 && file_exists("../config/MSG2_sms.cgi")){
                        $sms_msgdata = file("../config/MSG2_sms.cgi");
                        for($x=0;$x<sizeof($sms_msgdata[$x]);$x++){
                                $sms_msg .= $sms_msgdata[$x];
                        }
                }
                if($List["OrderStatus"]==40 && file_exists("../config/MSG3_sms.cgi")){
                        $sms_msgdata = file("../config/MSG3_sms.cgi");
                        for($x=0;$x<sizeof($sms_msgdata[$x]);$x++){
                                $sms_msg .= $sms_msgdata[$x];
                        }
                }
                if($List["OrderStatus"]==50 && file_exists("../config/MSG4_sms.cgi")){
                        $sms_msgdata = file("../config/MSG4_sms.cgi");
                        for($x=0;$x<sizeof($sms_msgdata[$x]);$x++){
                                $sms_msg .= $sms_msgdata[$x];
                        }
                }
?>
				<tr>
					<td><a  href='#' onClick="javascript:window.open('./order1_2.php?what=sms', 'SMSMessageManagerWindow','width=470,height=407,statusbar=no,scrollbars=yes,toolbar=no')">전화번호 </a></td>
					<td colspan="2"><input name="sms_tel" value="<?php echo $MobilNo?>">					</td>
				</tr>
				<tr>
					<td><a  href='#' onClick="javascript:window.open('./order1_2.php?what=sms', 'SMSMessageManagerWindow','width=470,height=407,statusbar=no,scrollbars=yes,toolbar=no')">메세지</a></td>
					<td width="185"><textarea name="sms_message"><?php echo $sms_msg?></textarea></td>
					<td><!--<button type="submit" >변경</button>--><span class="btn_manage_message button bull"><a>메세지관리</a></span> </td>
				</tr>
				<tr>
					<td colspan="3">sms업체선택은 기본환경&gt;기본환경설정에서 선택해 주세요</td>
				</tr>
			</table></td>
	</tr>
</table>
<div class="orange b">[ 결제방식 선택 ]</div>
<table class="table">
	<col width="120" />
	<col width="*" />
<?php
//------------------------------------------[결제방식]
if ($List["PayMethod"] == 'card') {
?>
	<tr>
		<th>결제방식</th>
		<td>신용카드 결제</td>
	</tr>
<?php
}
else if ($List["PayMethod"] == 'point') {
?>
	<tr>
		<th>결제방식</th>
		<td>포인트 결제</td>
	</tr>
<?php
}
else if ($List["PayMethod"] == 'hand') {
?>
	<tr>
		<th>결제방식</th>
		<td>핸드폰 결제</td>
	</tr>
<?php
}
else if ($List["PayMethod"] == 'all') {
?>
	<tr>
		<th>결제방식</th>
		<td>다중결제(온라인+신용카드+포인트)</td>
	</tr>
	<tr>
		<th>온라인입금</th>
		<td><?php echo number_format($List["AmountOline"]);?>
			원</td>
	</tr>
	<tr>
		<th>입금계좌</th>
		<td><?php echo $List["BankInfo"]?>
			&nbsp;</td>
	</tr>
	<tr>
		<th>입금예정일</th>
		<td><?php echo date("Y 년 m 월 d 일 H 시","$List[PayDate]"); ?>&nbsp;</td>
	</tr>
	<tr>
		<th>신용카드</th>
		<td><?php echo number_format($List["AmountPg"]);?>
			원</td>
	</tr>
	<tr>
		<th>포인트</th>
		<td><?php echo number_format($List["AmountPoint"]);?>
			포인트</td>
	</tr>
<?php
}
else {  //온라인 입금일 경우
?>
	<tr>
		<th>결제방식</th>
		<td>온라인입금</td>
	</tr>
	<tr>
		<th>입금계좌</th>
		<td><?php echo $List["BankInfo"]?>
			&nbsp;</td>
	</tr>
	<tr>
		<th> 입금인 </th>
		<td><?php echo $List["Inputer"]; ?> &nbsp;</td>
	</tr>
	<tr>
		<th>입금예정일</th>
		<td><?php if($List["PayDate"] >= mktime(0,0,0,0,0,2000)) echo date("Y 년 m 월 d 일 H 시","$List[PayDate]"); ?>
			&nbsp;</td>
	</tr>
<?php
}
//--------------------------------------------------
?>
</table>
<?php if($cfg["pay"]["CARD_PACK"] == "KICC" && ($List["PayMethod"] == 'all' || $List["PayMethod"] == 'card')):?>
[ KICC ADMIN MODE ]
<table class="table">
	<col width="120" />
	<col width="*" />
<?php 
if($List["CardStatus"] == "0000"){
	if($List["Reserved2"] == "S1") $CardStatus = "신용결제매입 상태"; 
	else if($List["Reserved2"] == "D2") $CardStatus = "신용결제승인취소 상태"; 
	else if($List["Reserved2"] == "S2") $CardStatus = "신용결제매입취소 상태";
	else if($List["Reserved2"] == "DD") $CardStatus = "신용결제즉시취소 상태";
	else $CardStatus = "승인 상태";
}
?>
	<tr>
		<th> 거래상태</th>
		<td><a  href="javascript:void(window.open('../skinwiz/cardmodule/KICC/mainAdmin.php?OrderID=<?php echo $List["OrderID"]?>','KICCADMINWINDOW','width=600,0'));">
			<?php echo $CardStatus?>
			</a></td>
	</tr>
</table>
<?php endif;?>
<div class="btn_box" style="padding-bottom: 30px;">
	<!-- "\n\n거래가 완료된 상태에서 삭제가 불가능합니다. \n\n거래상태를 주문접수됨으로 변경후  \n\n삭제 처리하십시오.\n\n" -->
	<!-- "\n\n거래가 완료된 상태에서 반품처리할 경우 \n\n거래상태를 주문접수됨으로 변경후  \n\n처리하십시오.\n\n" -->
	<?php if($List["OrderStatus"] <> 10) :?>
	<span class="button bull"><a href='javascript:alert("재고통계 및 포인트 적용을 위해\n거래상태를 주문접수됨으로 변경후  \n삭제 처리하십시오.")'>주문삭제</a></span>
	<?php else:?>
	<span class="button bull"><a href='javascript:changeDeliveryInfo("qde");'>주문삭제</a></span>
	<?php endif;?>
	<span class="button bull"><a href="javascript:self.print()">프린트</a></span> <span class="button bull"><a href="javascript:self.close()">창닫기</a></span> 
	<span class="button bull"><a href='javascript:down_excel("<?php echo $uid?>");'>엑셀출력</a></span> 
</div>
</body>
</html>
