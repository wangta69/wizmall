<?php
/* 
제작자 : 폰돌
스킨 : wizboard list skin 
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/

//현재 동일 데이타가 있는지 책크
$mid = $cfg["member"]["mid"];

$sqlstr = "select count(UID) from wizBuyers where OrderID = '".$mid."'";
$result = $dbcon->get_one($sqlstr);

#포인트가져오기
$sqlstr = "select mpoint from wizMembers WHERE mid='".$mid."'";
$UserPoint = $dbcon->get_one($sqlstr);

#결제진행중인 포인트가져오기
$sqlstr = "SELECT count(*) as count, sum(AmountPoint) as sum FROM wizBuyers WHERE MemberID='".$mid."'  AND OrderStatus<>'50' AND AmountPoint > 0";
$dbcon->_query($sqlstr);
$list = $dbcon->_fetch_array();
$HoldPoint = $list["sum"];


if($result){//현재 주문번호가 존재하면
	$sqlstr = "SELECT * FROM wizBuyers WHERE OrderID = '".$_COOKIE["CART_CODE"]."'";
	$dbcon->_query($sqlstr);
	$olist = $dbcon->_fetch_array();
	$STel1				= explode("-",$olist["STel1"]); 
	$STel2				= explode("-",$olist["STel2"]);
	$RTel1				= explode("-",$olist["RTel1"]); 
	$RTel2				= explode("-",$olist["RTel2"]);
	$RCompany			= $olist["RCompany"];	
	$BankInfo			= $olist["BankInfo"];
	$Inputer			= $olist["Inputer"];
	$SName				= $olist["SName"];
	$SEmail				= explode("@",$olist["SEmail"]);
	$RName				= $olist["RName"];
	$Message			= $olist["Message"];
	$SZip				= explode("-",$olist["SZip"]);	
	$SAddress1			= $olist["SAddress1"];
	$SAddress2			= $olist["SAddress2"];	
	$RZip				= explode("-",$olist["RZip"]);	
	$RAddress1			= $olist["RAddress1"];
	$RAddress2			= $olist["RAddress2"];		
	$ExpressDeliverFee	= $olist[ "ExpressDeliverFee"];	
}else if ($cfg["member"]) {
	//$cfg = $common->getLogininfo();	
	$sqlstr = "SELECT m.mname, i.* FROM wizMembers m 
	left join wizMembers_ind i on m.mid = i.id 
	WHERE m.mid='".$mid."'";
	$dbcon->_query($sqlstr);
	$olist = $dbcon->_fetch_array();
	
	
	$STel1		= explode("-",$olist["tel1"]); 
	$STel2		= explode("-",$olist["tel2"]);
	$Inputer	= $olist["mname"];
	$SName		= $olist["mname"];
	$SEmail		= explode("@",$olist["email"]);
	$SZip		= explode("-",$olist["zip1"]);
	$SAddress1	= $olist["address1"];
	$SAddress2	= $olist["address2"];
	//$RZip = explode("-",$olist[zip1]);
	//$RAddress1 = $olist[address1];
	//$RAddress2 = $olist[address2];		
}


?>
<script language=javascript src="./js/jquery.plugins/jquery.validator-1.0.1.js"></script>
<script language=javascript>
$(function(){
	
	$("#enable_express_tackbae_money").click(function(){
		cal_express_tackbae_money();
	});


});

	//토탈 금액계산하기
	var cal_express_tackbae_money = function(){
		var total_check_hidden = parseInt(RemoveComma($("#total_check_hidden").val()));
		var enable_express_tackbae_money	= parseInt(RemoveComma($("#enable_express_tackbae_money").val()));
		if($('#enable_express_tackbae_money').is(':checked')){
			$("#total_check").val(SetComma1(total_check_hidden + enable_express_tackbae_money));
		}else{
			$("#total_check").val(SetComma1(total_check_hidden));
		}
	}


function FilluserName(){
	var f=document.FrmUserInfo;
	if (!f.SName.value) {
		alert("주문자 성명을 정확히 적어주십시오.");
		f.SName.focus();
		return false;
	}
	num = f.SName.value;
	f.RName.value = num;
	f.RName.focus();
}

function FilluserTel(){
	var f=document.FrmUserInfo;
	if ((!f.UserTel1.value) || (!f.UserTel1.value)) {
		alert("전화번호를 정확히 입력해 주세요. ");
		return false;
	}
	num = f.UserTel1.value;
	f.UserTel3.value = num;
	f.UserTel3.focus();
}


function CheckField(f){
	if(f.paytype != "undefined") var paytype = getRadiovalue(f.paytype)

	if (!f.SName.value) {
		alert("주문자 성명을 정확히 적어주십시오.");
		f.SName.focus();
		return false;
	}else if (f.SEmail.value.length < 3) {
		alert("E-mail 주소가 부정확합니다. 확인해 주십시오");
		f.SEmail.focus();
		return false;
	}else if(f.RAddress2.value.length < 2) {
		alert("번지수/통/반을 정확히 입력해 주세요.[예:123번지] ");
		f.RAddress2.focus();
		return false;
	}else if (f.RTel1_1.value.length < 1 && f.RTel2_1.value.length < 1) {
		alert("전화번호는 반드시 1개 이상 입력되어야 합니다.");
		f.RTel1_1.focus();
		return false;
	}else if (paytype == "online" && f.BankInfo.value == "") {
		alert("입금은행을 선택해 주세요");
		f.BankInfo.focus();
		return false;
	}else if (paytype == "online" && f.Inputer.value == "") {
		alert("입금인 성명을 정확히 적어주십시오.");
		f.Inputer.focus();
		return false;
	}else if(f.pointamount){
		f.pointamount.value = RemoveComma(f.pointamount.value)
	}else return true;
		
}

function OpenZipcode(flag){
	if(flag == "1"){//보내는분 주소찾기
		var zip1 = "SZip1";
		var zip2 = "SZip2";
		var firstaddress = "SAddress1";
		var secondaddress = "SAddress2";
	}else{//받는분 주소찾기
		var zip1 = "RZip1";
		var zip2 = "RZip2";
		var firstaddress = "RAddress1";
		var secondaddress = "RAddress2";	
	}
	window.open("./util/zipcode/zipcode.php?form=FrmUserInfo&zip1="+zip1+"&zip2="+zip2+"&firstaddress="+firstaddress+"&secondaddress="+secondaddress,"ZipWin","width=490,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no");	
}


function copyvalue(v){
	var f = document.FrmUserInfo;
	//alert(v.vlaue);
	if(f.copybtn[0].checked == true){
		f.RName.value = f.SName.value;
		f.RTel1_1.value = f.STel1_1.value;
		f.RTel1_2.value = f.STel1_2.value;
		f.RTel1_3.value = f.STel1_3.value;
		f.RTel2_1.value = f.STel2_1.value;
		f.RTel2_2.value = f.STel2_2.value;
		f.RTel2_3.value = f.STel2_3.value;
		f.RZip1.value = f.SZip1.value;
		f.RZip2.value = f.SZip2.value;
		f.RAddress1.value = f.SAddress1.value;
		f.RAddress2.value = f.SAddress2.value;	

		return;
	}else{
		f.RName.value = "";
		f.RTel1_1.value = "";
		f.RTel1_2.value = "";
		f.RTel1_3.value = "";
		f.RTel2_1.value = "";
		f.RTel2_2.value = "";
		f.RTel2_3.value = "";
		f.RZip1.value = "";
		f.RZip2.value = "";
		f.RAddress1.value = "";
		f.RAddress2.value = "";			
		return;
	}
}



function SelectPayType(v){

	var f = eval("document."+v.form.name);
	totalpay = RemoveComma(f.total_check.value);
	if(v.value == "online"){
		$(".onlinepaytype").show();
	}else if(v.value == "card"){
		if(totalpay < <?php echo intval($cfg["pay"]["CARD_ENABLE_MONEY"])?> ){
			window.alert('신용카드구매는 구매액이 <? echo number_format($cfg["pay"]["CARD_ENABLE_MONEY"]);?>원 이상만 가능합니다.');
			v.checked = false;
			return;
		}
		$(".onlinepaytype").hide();
	}else if(v.value == "hand"){
		if(totalpay < <?php echo intval($PHONE_ENABLE_MONEY)?> ){
			window.alert('신용카드구매는 구매액이 <? echo number_format($PHONE_ENABLE_MONEY);?>원 이상만 가능합니다.');
			v.checked = false;
			return;
		}
		$(".onlinepaytype").hide();	
	}
}

function paycalculate() {
var f = document.FrmUserInfo;
	num1 = filterNum(f.pointamount.value);
	num2 = filterNum(f.TOTAL_MONEY.value);
	if (!TypeCheck(f.pointamount.value, NUM+COMMA)) {
			alert('숫자와 콤마만 입력가능합니다.');
			resetPaymoney(f)
			return;
	}
	if (num1 > <? echo intval($UserPoint  - $HoldPoint);?>) {
			alert('고객님께서 사용가능한 <?php echo number_format($UserPoint  - $HoldPoint);?>포인트 이내에서만 구매가능합니다.');
			resetPaymoney(f)
			return;
	}
	if (num1 > num2) {
			alert('포인트 결제금액이 제품 구매액보다 많게 입력되었습니다');
	}
	
	f.pointamount.value = SetComma1(f.pointamount.value);
	f.total_check.value = SetComma1(num2 - num1);
}

function resetPaymoney(f){
	f.pointamount.value = '0';
	//f.total_check.value = SetComma1(f.TOTAL_MONEY.value);
	cal_express_tackbae_money();//특송추가로 인해 이부분을 사용
	f.pointamount.focus();
	event.returnValue=false;
}
</script>
<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active">주문서 작성</li>
</ul>

<div><img src="<?php echo $cart_skin_path?>/images/cart_out_tit.gif" height="77">
<img src="<?php echo $cart_skin_path?>/images/cart_img.gif" />
<img src="<?php echo $cart_skin_path?>/images/cart_on_tit02.gif" height="77">
<img src="<?php echo $cart_skin_path?>/images/cart_img.gif">
<img src="<?php echo $cart_skin_path?>/images/cart_out_tit03.gif" height="77">
<img src="<?php echo $cart_skin_path?>/images/cart_img.gif">
<img src="<?php echo $cart_skin_path?>/images/cart_out_tit04.gif" height="77">
</div>
<?php
// 장바구니 보기
include $cart_skin_path."/CART_VIEW.php";
?>
<div class="space15"></div>
<form action='<? echo $PHP_SELF; ?>?query=cardchecking' name='FrmUserInfo' method="post" OnSubmit='javascript:return CheckField(this)'  class="form-horizontal" role="form">
	<input type="hidden" name="cod" value="<?php echo $cod?>">
	<input type="hidden" id="total_check_hidden" name="TOTAL_MONEY" value='<?php echo $TOTAL_MONEY?>'>
	<input type="hidden" name="goods_name" value='<?php echo $NAME?>'>
	<input type="hidden" name="op" value='<?php echo $op?>'>
	<img src="<?php echo $cart_skin_path?>/images/tit_01.gif">
	
	
	
	<div class="form-group">
		<label for="name" class="col-lg-2 control-label">이름</label>
		<div class="col-lg-10">
			<input name="SName" type="text" id="SName" value="<?php echo $SName?>" class="w200 form-control">
		</div>
	</div>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">배송지주소</label>
		<div class="col-lg-10">
			<div class="col-lg-2 padlzero">
				<input name="SZip1" type="text" id="SZip1" maxlength="3" value="<?php echo $SZip[0]?>"  readonly="readonly" class="form-control">
			</div>
            <div style="display: inline-block; float:left">-</div>
            <div class="col-lg-2">
            	<input name="SZip2" type="text" id="SZip2" maxlength="3" value="<?php echo $SZip[1]?>" readonly="readonly" class="form-control">
            </div>
            <button type="button" class="btn btn-default" onClick="javascript:OpenZipcode('1')">우편번호찾기</button>
            <p><br/><input name="SAddress1" type="text" id="SAddress1" value="<?php echo $SAddress1?>" readonly="readonly" class="w500 form-control"></p>
            <p><input name="SAddress2" type="text" id="SAddress2" value="<?php echo $SAddress2?>" class="w500 form-control" placeholder="상세주소"></p>
 		</div>
	</div>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">자택전화</label>
		<div class="col-lg-10">
			<div class="col-lg-2 padlzero">
				<input type="text" name="STel1_1" id="STel1_1" value="<?php echo $STel1[0];?>" class="form-control">
			</div>
			<div style="display: inline-block; float:left">-</div>
			<div class="col-lg-2">
				<input type="text" name="STel1_2" id="STel1_2" value="<?php echo $STel1[1];?>" class="form-control">
			</div> 
			<div style="display: inline-block; float:left">-</div>
			<div class="col-lg-2">
				<input type="text" name="STel1_3" id="STel1_3" value="<?php echo $STel1[2];?>" class="form-control">
			</div>
                    
		</div>
	</div>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">휴대전화</label>
		<div class="col-lg-10">
			<div class="col-lg-2 padlzero">
				<input type="text" name="STel2_1" id="STel2_1" value="<?php echo $STel2[0];?>" class="form-control">
			</div>
			<div style="display: inline-block; float:left">-</div>
			<div class="col-lg-2">
				<input type="text"  name="STel2_2"id="STel2_2" value="<?php echo $STel2[1];?>" class="form-control">
			</div> 
			<div style="display: inline-block; float:left">-</div>
			<div class="col-lg-2">
				<input type="text" name="STel2_3" id="STel2_3" value="<?php echo $STel2[2];?>" class="form-control">
			</div>
                    
		</div>
	</div>
	
	
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">* 
                    전자우편</label>
		<div class="col-lg-10">
			<div class="col-lg-3 padlzero">
				<input name="SEmail_1" type="text" id="SEmail_1" value="<?php echo $SEmail[0]?>" class="form-control">
			</div>
			<div style="display: inline-block; float:left">@</div>
			<div class="col-lg-3">
				<input name="SEmail_2" type="text" id="email_2" value="<?php echo $SEmail[0]?>" class="form-control" />
			</div>
			<div class="col-lg-3">
				<select name="tmpmail" onChange="email_chk(this)" class="form-control">
					<option value=''>선택해주세요</option>
<?php 
	reset($MailArr);
	foreach($MailArr as $key=>$value){
		echo "<option value='$value'>$value</option>\n";
	}
?>
				<option value='etc'>기타</option>
			</select>
		</div>
		</div>
	</div>
	

	<table class="table">
		<tr>
			<td><img src="<?php echo $cart_skin_path?>/images/tit_02.gif"></td>
			<td width="348">배송지 정보가 주문자 정보와 동일 합니까?
				<input type="radio" name="copybtn" value="1" onclick="javascript:copyvalue(this)"; style="cursor:pointer">
				예
				<input type="radio" name="copybtn" value="0" onclick="javascript:copyvalue(this)"; style="cursor:pointer">
				아니오</td>
		</tr>
	</table>
	
	
	<div class="form-group">
		<label for="name" class="col-lg-2 control-label">이름</label>
		<div class="col-lg-10">
			<input name="RName" type="text" id="RName" value="<?php echo $RName?>" class="w200 form-control">
		</div>
	</div>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">배송지주소</label>
		<div class="col-lg-10">
			<div class="col-lg-2 padlzero">
				<input name="RZip1" type="text" id="RZip1" maxlength="3" value="<?php echo $RZip[0]?>"  readonly="readonly" class="form-control">
			</div>
            <div style="display: inline-block; float:left">-</div>
            <div class="col-lg-2">
            	<input name="RZip2" type="text" id="RZip2" maxlength="3" value="<?php echo $RZip[1]?>" readonly="readonly" class="form-control">
            </div>
            <button type="button" class="btn btn-default" onClick="javascript:OpenZipcode('2')">우편번호찾기</button>
            <p><br/><input name="RAddress1" type="text" id="RAddress1" value="<?php echo $RAddress1?>" readonly="readonly" class="w500 form-control"></p>
            <p><input name="RAddress2" type="text" id="RAddress2" value="<?php echo $RAddress2?>" class="w500 form-control" placeholder="상세주소"></p>
 		</div>
	</div>
	
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">자택전화</label>
		<div class="col-lg-10">
			<div class="col-lg-2 padlzero">
				<input type="text" name="RTel1_1" id="RTel1_1" value="<?php echo $RTel1[0];?>" class="form-control">
			</div>
			<div style="display: inline-block; float:left">-</div>
			<div class="col-lg-2">
				<input type="text" name="RTel1_2" id="RTel1_2" value="<?php echo $RTel1[1];?>" class="form-control">
			</div> 
			<div style="display: inline-block; float:left">-</div>
			<div class="col-lg-2">
				<input type="text" name="RTel1_3" id="RTel1_3" value="<?php echo $RTel1[2];?>" class="form-control">
			</div>
                    
		</div>
	</div>
	<div class="form-group">
		<label for="" class="col-lg-2 control-label">휴대전화</label>
		<div class="col-lg-10">
			<div class="col-lg-2 padlzero">
				<input type="text" name="RTel2_1" id="RTel2_1" value="<?php echo $RTel2[0];?>" class="form-control">
			</div>
			<div style="display: inline-block; float:left">-</div>
			<div class="col-lg-2">
				<input type="text"  name="RTel2_2" id="RTel2_2" value="<?php echo $RTel2[1];?>" class="form-control">
			</div> 
			<div style="display: inline-block; float:left">-</div>
			<div class="col-lg-2">
				<input type="text" name="RTel2_3" id="RTel2_3" value="<?php echo $RTel2[2];?>" class="form-control">
			</div>
                    
		</div>
	</div>
	<div class="form-group">
		<label for="name" class="col-lg-2 control-label">배송메세지</label>
		<div class="col-lg-10">

			<textarea name="Message" id="Message"  class="form-control" placeholder="배송메세지란에는 배송시 참고할 사항이 있으면 적어주세요"><?php echo $Message?></textarea>

		</div>
	</div>
	
	<img src="<?php echo $cart_skin_path?>/images/tit_03.gif" width="114">
	<div class="form-group">
		<label for="name" class="col-lg-2 control-label">물품금액</label>
		<div class="col-lg-10">
			 <p class="form-control-static"><?php echo number_format($TOTAL_PRODUCT_MONEY);?>원</p>
		</div>
	</div>
	<div class="form-group">
		<label for="name" class="col-lg-2 control-label">배송비</label>
		<div class="col-lg-10">
			 <p class="form-control-static"><?php echo number_format($TOTAL_MONEY - $TOTAL_PRODUCT_MONEY);?>원
			 	
			 	<?php
if($cfg["pay"]["ENABLE_EXPRESS_TACKBAE_MONEY"] == "checked"){
	$checked = $ExpressDeliverFee ? " checked":"";
	echo "<input type='checkbox' id = 'enable_express_tackbae_money' value='".$cfg["pay"]["EXPRESS_TACKBAE_MONEY"]."' name='ExpressDeliverFee'".$checked."/>특급 배송 사용(+".number_format($cfg["pay"]["EXPRESS_TACKBAE_MONEY"]).")";
//$cfg["pay"]["EXPRESS_TACKBAE_MONEY"] = "100000";
}
				?>
			 	</p>
		</div>
	</div>
	
	
			<? if(!strcmp($cfg["pay"]["POINT_ENABLE"], "checked")):?>
			<!-- 포인트 결재 시작 -->
	<div class="form-group">
		<label for="name" class="col-lg-2 control-label">포인트사용금액</label>
		<div class="col-lg-2">
			 <input value='0' type="text" name='pointamount' size=10 onkeyup='paycalculate();'  class="form-control"/>
		</div>
		<div style="display: inline-block; float:left">원</div>
		<label for="name" class="col-lg-2 control-label">가용포인트/총포인트</label>
		<div class="col-lg-5">
			 <?php echo number_format($UserPoint - $HoldPoint)?>/<?php echo number_format($UserPoint)?>원
		</div>
	</div>

			<? endif; ?>
	<div class="form-group">
		<label for="name" class="col-lg-2 control-label">최종결제 금액</label>
		<div class="col-lg-2">
			 <input type="text" id="total_check" name='total_check' readonly value='<?php echo number_format($TOTAL_MONEY);?>' class="form-control"> 
		</div>
		<div style="display: inline-block; float:left">원</div>
	</div>
				


	<img src="<?php echo $cart_skin_path?>/images/tit_04.gif">
	
	<div class="form-group">
		<label for="name" class="col-lg-2 control-label">결제방식</label>
		<div class="col-lg-10">
			 <input name="paytype" type="radio" value="online" checked="checked" onClick="SelectPayType(this)"/>
					무통장 입금
					<!-- 무통장 입금 끝 -->
					<!-- 신용카드 시작 -->
					<? if(!strcmp($cfg["pay"]["CARD_ENABLE"], "checked")):?>
					<input name="paytype" type="radio" value="card" onClick="SelectPayType(this)"/>
					신용카드
					<? endif;?>
					<!-- 신용카드 끝 -->
					<!-- 핸드폰 결재 시작 -->
					<? if(!strcmp($cfg["pay"]["PHONE_ENABLE"], "checked")):?>
					<input name="paytype" type="radio" value="hand" onClick="SelectPayType(this)"/>
					핸드폰 결제
					<? endif;?>
					<!-- 핸드폰 결재 끝 -->
					<!-- 실시간 계좌이체 시작 -->
					<? if(!strcmp($cfg["pay"]["AUTOBANKING_ENABLE"], "checked")):?>
					<input name="paytype" type="radio" value="autobank"  onClick="SelectPayType(this)"/>
					실시간 계좌 이체
					<? endif;?>
					<!-- 실시간 계좌이체 끝 -->
		</div>
	</div>
	
	<div class="form-group onlinepaytype">
		<label for="name" class="col-lg-2 control-label">입금은행</label>
		<div class="col-lg-10">
			 <select name='BankInfo' class="form-control">
				<option value="">입금계좌선택</option>
				<?php
					$sqlstr = "select * from wizaccount order by uid asc";
					$dbcon->_query($sqlstr);
					$cnt=0;
					while($list =$dbcon->_fetch_array()):
						$bankname		= $list["bankname"];
						$account_no		= $list["account_no"];
						$account_owner	= $list["account_owner"];
						$key = $bankname."|".$account_no."|".$account_owner;
						$value = $bankname." " .$account_no." (예금주:".$account_owner.")";
						$selected = ($BankInfo == $key)?" selected":"";
						echo "<option value='".$key."'$selected>".$value."</option>\n";	
					$cnt++;
					endwhile;
					if(!$cnt){
						echo "<option>무통장 입금 계좌가 등록되지 않았습니다.</option>\n";
					}
				?>
			</select>
		</div>
	</div>
	<div class="form-group onlinepaytype">
		<label for="name" class="col-lg-2 control-label">입금자명</label>
		<div class="col-lg-10">
			 <input name="Inputer" type="text" id="Inputer" value="<?php echo $Inputer?>" class="w200 form-control">
		</div>
	</div>
	<div class="form-group onlinepaytype">
		<label for="name" class="col-lg-2 control-label">입금예정일</label>
		<div class="col-lg-10">
		<?php
			$year = date("Y");
			$month = date("m");
			$day = date("j");
			$Hour = date("H");
			$Minute = date("i");
			echo "<div class='col-lg-2 padlzero'><select name='OYear' class='form-control'>"; 
			for($i=$year;$i<=$year+5;$i++) {
			if($regyear == $i) {
			echo "<option value='$i' selected>$i 년</option>\n";
			}
			else {
			echo "<option value='$i'>$i 년</option>\n";
			}
			}
			echo "</select> </div><div class='col-lg-2'><select name='OMonth' class='form-control'>";
			for($i="01";$i<=12;$i++) {
			if($month == $i) {
			echo "<option value='$i' selected>$i 월</option>\n";
			}
			else {
			echo "<option value='$i'>$i 월</option>\n";
			}
			}
			echo "
			</select> </div><div class='col-lg-2'><select name='ODay' class='form-control'>";
			for($i="01";$i<=31;$i++) {
			if($day == $i) {
			echo "<option value='$i' selected>$i 일</option>\n";
			}
			else {
			echo "<option value='$i'>$i 일</option>\n";
			}
			}
			echo "</select></div><div class='col-lg-2'><select name='OHour' class='form-control'>";
			for($i="0";$i< 24;$i++) {
			if($Hour == $i) {
			echo "<option value='$i' selected>$i 시</option>\n";
			}
			else {
			echo "<option value='$i'>$i 시</option>\n";
			}
			}
			echo "</select></div>";
		?>
		</div>
	</div>
			
	<button type="button" class="btn btn-default" onClick="javascript:history.go(-1);">다시작성</button>
	<button type="submit" class="btn btn-default" >결제하기</button>		

</form>
