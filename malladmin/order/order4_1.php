<?php
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/
if ($common -> checsrfkey($csrf)) {
	if ($action == 'send_modify') { // 배송상태 변경
	        if ($OrderStatus) {
	                if ($OrderStatus < 50) {   // 배송완료가 아니면
	                        $QUERY1 = "UPDATE wizEstim SET OrderStatus = '$OrderStatus' WHERE UID='$uid'";
	                }
	                else {
	                        $Cart_Data = explode("\n", $value);
	                        for($i = 0; $i < sizeof($Cart_Data) && chop($Cart_Data[$i]); $i++) {
	                                $C_dat = explode("|", chop($Cart_Data[$i]));
	                                $QUERY3 = "SELECT Output,Point FROM wizMall WHERE UID='$C_dat[0]'";
	                                $QUERY3_RESULT = $dbcon->_fetch_array($dbcon->_query($QUERY3, $DB_CONNECT));
	                                $UPDATE_PUT = $QUERY3_RESULT["PUT"] + $C_dat[1];
	                                $QUERY2 = "UPDATE wizMall SET Output='$UPDATE_PUT' WHERE UID='$C_dat[0]'";
	                                $QUERY2_RESULT = $dbcon->_query($QUERY2);
	                        }
	                        $QUERY1 = "UPDATE wizEstim SET OrderStatus = '$OrderStatus' WHERE UID='$uid'";
	                        if ($member_id) {
	                        $QUERY4 = "SELECT Point,Pointinfo FROM wizMembers WHERE ID='$member_id'";
	                        $QUERY4_RESULT = $dbcon->_fetch_array($dbcon->_query($QUERY4, $DB_CONNECT));
	
	                        if ($howbuy == 'point') {
	                        $UPDATE_POINT = $QUERY4_RESULT["Point"] - $totalmoney;
	                        $UPDATE_POINT_INFO = "-$totalmoney|".date("Y-m-d")."|주문번호:$member_code (포인트구매)|\n";
	
	                        }
	
	                        elseif($howbuy == 'all' && $pointmoney) {
	
	                        $UPDATE_POINT = $QUERY4_RESULT["Point"] - $pointmoney;
	
	                        $UPDATE_POINT_INFO = "-$pointmoney|".date("Y-m-d")."|주문번호:$member_code (다중구매시포인트사용)|\n";
	
	                        }
	
	                        else {
	
	                        $UPDATE_POINT = $QUERY4_RESULT["Point"] + $member_point;
	
	                        $UPDATE_POINT_INFO = "$member_point|".date("Y-m-d")."|주문번호:$member_code|\n";
	
	                        }
	
	
	
	                        $QUERY5 = "UPDATE wizMembers SET Point='$UPDATE_POINT', Pointinfo='$QUERY4_RESULT[Pointinfo]$UPDATE_POINT_INFO' WHERE ID='$member_id'";
	
	                        $QUERY5_RESULT = $dbcon->_query($QUERY5);
	
	                        }
	
	                }
	
	                $dbcon->_query($QUERY1);
	
	        }
	
	        if ($Co_Now1) {          // 배송완료상태에서 재변경
	
	                $Cart_Data = explode("\n", $value);
	
	                for($i = 0; $i < sizeof($Cart_Data) && chop($Cart_Data[$i]); $i++) {
	
	                        $C_dat = explode("|", chop($Cart_Data[$i]));
	
	                        $QUERY3 = "SELECT Output FROM wizMall WHERE UID='$C_dat[0]'";
	
	                        $QUERY3_RESULT = $dbcon->_fetch_array($dbcon->_query($QUERY3, $DB_CONNECT));
	
	                        $UPDATE_PUT = $QUERY3_RESULT["PUT"] - $C_dat[1];
	
	                        $QUERY2 = "UPDATE wizMall SET Output='$UPDATE_PUT' WHERE UID='$C_dat[0]'";
	
	                        $QUERY2_RESULT = $dbcon->_query($QUERY2);
	
	                }
	
	                $QUERY1 = "UPDATE wizEstim SET OrderStatus = '$Co_Now1' WHERE UID='$uid'";
	
	                $dbcon->_query($QUERY1);
	
	
	
	                if ($member_id) {
	
	                $QUERY4 = "SELECT Point,Pointinfo FROM wizMembers WHERE ID='$member_id'";
	
	                $QUERY4_RESULT = $dbcon->_fetch_array($dbcon->_query($QUERY4, $DB_CONNECT));
	
	
	
	                if ($howbuy == 'point') {
	
	                $UPDATE_POINT = $QUERY4_RESULT["Point"] + $totalmoney;
	
	                $UPDATE_POINT_INFO = "$totalmoney|".date("Y-m-d")."|주문번호:$member_code (포인트구매취소)|\n";
	
	                }
	
	                elseif($howbuy == 'all' && $pointmoney) {
	
	                $UPDATE_POINT = $QUERY4_RESULT["Point"] + $pointmoney;
	
	                $UPDATE_POINT_INFO = "$pointmoney|".date("Y-m-d")."|주문번호:$member_code (다중구매시포인트구매취소)|\n";
	
	                }
	
	                else {
	
	                $UPDATE_POINT = $QUERY4_RESULT["Point"] - $member_point;
	
	                $UPDATE_POINT_INFO = "-$member_point|".date("Y-m-d")."|주문번호:$member_code|\n";
	
	                }
	
	
	
	                $QUERY5 = "UPDATE wizMembers SET Point='$UPDATE_POINT', Pointinfo='$QUERY4_RESULT[Pointinfo]$UPDATE_POINT_INFO' WHERE ID='$member_id'";
	
	                $QUERY5_RESULT = $dbcon->_query($QUERY5);
	
	                }
	
	        }
	
	        if ($Co_Now2 == 'BACK') { //반품 처리된 경우
	
	                $QUERY1 = "UPDATE wizEstim SET OrderStatus='$co_now' WHERE UID='$uid'";
	
	                $dbcon->_query($QUERY1);
	
	        }
	}
	
	if ($action == 'qde') {  // 주문데이터삭제
	
	        $dbcon->_query("DELETE FROM wizEstim WHERE UID=$uid");
	
	        echo "<script  language='javascript'>
	
	        window.alert('\\n\\n주문데이터가 삭제되었습니다.\\n\\n');
	
	        window.opener.location.href='./main.php?menushow=$menushow&theme=order1';
	
	        self.close();
	
	        </script>";
	
	        exit;
	}
	
	if ($action == 'none') {  // 반품처리
	
	        $QUERY1 = "UPDATE wizEstim SET Co_Del='checked' WHERE UID='$uid'";
	
	        $dbcon->_query($QUERY1);
	
	
	
	        echo "<html>
	
	        <META http-equiv=\"refresh\" content =\"0;url=order1_1.php?uid=$uid\">
	
	        </html>";
	
	        exit;
	
	}
	
	if($action == "trans_message"){
	    if ($sms_send == 'Y' && $sms_tel) { // sms 전송
	        if ($sms_message) {
				$BeforTime = time() - 5*60;
				$now_time = date("Y-m-d H:i:s");
	?>
				<form name="SMS" action="http://www.myhomesms.co.kr/gateway/remoteinsert_cp.asp" method="post">
				<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
				<input type="hidden" name=tmrTime value="<?=$now_time ?>">
				<input type="hidden" name=strSdMbno value="<?=$sms_tel ?>">
				<input type="hidden" name=strRvMbno value="025471514 ">
				<input type="hidden" name=strMsg value="<?=$sms_message ?>">
				<input type="hidden" name=strID value="애니잉크">
				<input type="hidden" name=strCoID value="Xylink">
				<input type="hidden" name="Opt01" value="옵션1">
				<input type="hidden" name="Opt02" value="옵션2">
				<input type="hidden" name="Opt03" value="옵션3">
				<input type="hidden" name=rUrl value="메세지 전송 후 돌아갈 페이지">
				<input type="submit" value="전송">
				</form>
				<script >document.SMS.submit();</script>
	<?php
			}//if ($sms_message) {
		}// if ($sms_send == 'Y' && $sms_tel) { // sms 전송
	
	
	
		if ($email_send == 'Y' && $sender_email) { // 이메일 전송
		
			if($OrderStatus==20 && file_exists("../config/mall_info/sms_msg/MSG1_email.cgi")){
				$subject="주문번호[$member_code]접수후 입금확인중입니다. [".$cfg["admin"]["ADMIN_TITLE"]."]";
				$email_msg = file("../config/mall_info/sms_msg/MSG1_email.cgi");
			}
		
			if($OrderStatus==30 && file_exists("../config/mall_info/sms_msg/MSG2_email.cgi")){
				$subject="주문번호[$member_code] 입금확인되었습니다. [".$cfg["admin"]["ADMIN_TITLE"]."]";
				$email_msg = file("../config/mall_info/sms_msg/MSG2_email.cgi");
			}
		
			if($OrderStatus==40 && file_exists("../config/mall_info/sms_msg/MSG3_email.cgi")){
				$subject="주문번호[$member_code] 배송준비중입니다. [".$cfg["admin"]["ADMIN_TITLE"]."]";
				$email_msg = file("../config/mall_info/sms_msg/MSG3_email.cgi");
			}
		
			if($OrderStatus==50 && file_exists("../config/mall_info/sms_msg/MSG4_email.cgi")){
				$subject="주문번호[$member_code] 배송완료되었습니다. [".$cfg["admin"]["ADMIN_TITLE"]."]";
				$email_msg = file("../config/mall_info/sms_msg/MSG4_email.cgi");
			}
		
			if ($email_msg) {
			
				while($dat = each($email_msg)) {
					$CONTENT_MODIFY_MSG .= nl2br(htmlspecialchars($dat[1]));
				}
			
				include $order_mod_memo;
				$tomail = $sender_email;
				$from = $cfg["admin"]["ADMIN_EMAIL"];
				$from = "From:$from\nContent-Type:text/html";
				mail ($tomail, $subject, $SEND_CONTENT, $from);
			}
		}//if ($email_send == 'Y' && $sender_email) { // 이메일 전송
	
	}//if($action == "trans_message"){
}//if ($common -> checsrfkey($csrf)) {
?>

<html>

	<head>

		<title>WIzMall 관리자</title>

	</head>

	<style>
		<!--

		A:link {text-decoration:none; color:black;}

		A:visited {text-decoration:none; color:black;}

		A:hover {   color:brown;}

		p,br,body,td,table,tr {color:black; font-size:9pt;}

		-->
	</style>

	<body>
		<table >
			<tr>
				<td>견적상세정보</td>
			</tr>
			<?

$LIST_QUERY = "SELECT * FROM wizEstim WHERE UID='$uid'";
$List = $dbcon->_fetch_array($dbcon->_query($LIST_QUERY, $DB_CONNECT));

$UID = $List[UID];
$SName = $List[SName];
$SEmail = $List[SEmail];
$STel1 = $List[STel1];
$STel2 = $List[STel2];
$RName = $List[RName];
$RTel1 = $List[RTel1];
$RZip = $List[RZip];
$Address = $List[RAddress1];
$ExpectDate = $List[ExpectDate];
$Message = nl2br(stripslashes($List[Message]));
$PayMethod = $List[PayMethod];
$BankInfo = $List[BankInfo];
$AmountPoint = $List[AmountPoint];
$AmountOline = $List[AmountOline];
$AmountPg = $List[AmountPg];
$TotalAmount = $List[TotalAmount];
$Co_Uid = $List[OrderID];
$OrderStatus = $List[OrderStatus];
$MemberID = $List[MemberID];
$BuyDate = $List[BuyDate];
if (!$MemberID) {$MemberID = "비회원";}
$Cart_Data = explode("n", $Cart_Info);
for($i = 0; $i < sizeof($Cart_Data) && chop($Cart_Data[$i]); $i++) {
$C_dat = explode("|", chop($Cart_Data[$i]));
$VIEW_QUERY = "SELECT * FROM wizMall WHERE UID='$C_dat[0]'";
$VIEW_DATA = $dbcon->_fetch_array($dbcon->_query($VIEW_QUERY));
$UID = $VIEW_DATA[UID];
$VIEW_DATA[Name] = stripslashes($VIEW_DATA[Name]);
$Price = number_format($VIEW_DATA[Price]);
$Point = number_format($VIEW_DATA[Point] * $C_dat[1]);
$Category = $VIEW_DATA[Category];
$SUM_MONEY = number_format($VIEW_DATA[Price] * $C_dat[1]);
$TOTAL_MONEY = $TOTAL_MONEY + ($VIEW_DATA[Price] * $C_dat[1]);
$TOTAL_POINT = $TOTAL_POINT + ($VIEW_DATA[Price] * $C_dat[1]);
			?>

			<?

			}   // for

			$Tack_Money = $TotalAmount - $TOTAL_MONEY;
			?>
		</table>
		<table>

		<tr>

		<th>주문상품</th>

		<th>제품거래처</th>

		<th>가격</th>

		<th>수량</th>

		<th>합계/포인트</th>

		</tr>

		<?

$LIST_QUERY = "SELECT * FROM wizEstim WHERE UID='$uid'";

$List = $dbcon->_fetch_array($dbcon->_query($LIST_QUERY, $DB_CONNECT));

$UID = $List[UID];
$SName = $List[SName];
$SEmail = $List[SEmail];
$STel1 = $List[STel1];
$STel2 = $List[STel2];
$RName = $List[RName];
$RTel1 = $List[RTel1];
$RZip = $List[RZip];
$RAddress1 = $List[RAddress1];
$ExpectDate = $List[ExpectDate];
$List[Message] = nl2br(stripslashes($List[Message]));
$PayMethod = $List[PayMethod];
$BankInfo = $List[BankInfo];
$AmountPoint = $List[AmountPoint];
$AmountOline = $List[AmountOline];
$AmountPg = $List[AmountPg];
$TotalAmount = $List[TotalAmount];
$Co_Uid = $List[OrderID];
$OrderStatus = $List[OrderStatus];
$MemberID = $List[MemberID];
$BuyDate = $List[BuyDate];
if (!$MemberID) {$MemberID = "비회원";}
$Cart_Data = explode("\n", $Cart_Info);
for($i = 0; $i < sizeof($Cart_Data) && chop($Cart_Data[$i]); $i++) {
$C_dat = explode("|", chop($Cart_Data[$i]));
$VIEW_QUERY = "SELECT * FROM wizMall WHERE UID='$C_dat[0]'";
$VIEW_DATA = $dbcon->_fetch_array($dbcon->_query($VIEW_QUERY));
$UID = $VIEW_DATA[UID];
$VIEW_DATA[Name] = stripslashes($VIEW_DATA[Name]);
$Price = number_format($VIEW_DATA[Price]);
$Point = number_format($VIEW_DATA[Point] * $C_dat[1]);
$Category = $VIEW_DATA[Category];
$SUM_MONEY = number_format($VIEW_DATA[Price] * $C_dat[1]);
$TOTAL_MONEY = $TOTAL_MONEY + ($VIEW_DATA[Price] * $C_dat[1]);
$TOTAL_POINT = $TOTAL_POINT + ($VIEW_DATA[Price] * $C_dat[1]);
		?>

		<tr>

		<td> <a  href='../wizmart.php?code=<?ECHO "$CATEGORY"; ?>&query=view&no=<?ECHO "$UID"; ?>' target=_blank><U>
		<?=$VIEW_DATA[Name] ?>
		<?if($VIEW_DATA[Model]):
		?>
		(
		<?=$VIEW_DATA[Model] ?>
		)<? endif; ?>
		</U></a><br />

		<?

		if ($C_dat[2]) {

			if (eregi("=", $C_dat[2])) {

				$SIZE_OPTION_SPL = explode("=", $C_dat[2]);

				ECHO "<FONT COLOR=#CE6500>$SIZE_OPTION_SPL[0](" . number_format(chop($SIZE_OPTION_SPL[1])) . "원추가) ";

				$CHECK = number_format(str_replace(",", "", $CHECK) + chop($SIZE_OPTION_SPL[1]));

				$SUM_MONEY = number_format(str_replace(",", "", $SUM_MONEY) + (chop($SIZE_OPTION_SPL[1]) * $C_dat[1]));

				$TOTAL_MONEY = $TOTAL_MONEY + (chop($SIZE_OPTION_SPL[1]) * $C_dat[1]);

			} else {

				ECHO "<FONT COLOR=#CE6500>$C_dat[2] ";

			}

		}

		if ($C_dat[3]) {

			ECHO " <FONT COLOR=#CE6500>$C_dat[3]";

		}
	?>
		</td>

		<td>

		<?=$VIEW_DATA[CompName] ?>

		</td>

		<td>
		<?=$Price ?>
		원</td>

		<td>

		<input type=text name='BUYNUM' maxlength=5 value='<?ECHO "$C_dat[1]"; ?>'>

		EA</td>

		<td> <?ECHO "$SUM_MONEY"; ?>
		원</td>
		</tr>

		> <?

		}   // for

		$Tack_Money = $TotalAmount - $TOTAL_MONEY;
	?>
		</table><table>

		<tr>
		<td>견적상품 가격합계 :
		<?=number_format($TotalAmount) ?>
		원</td>
		</tr> <tr>

		<td background='../mall_image/list_line.gif' height=1> </td></tr> </table>
		<table>
		<tr>
		<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
		<td colspan="3"><table>
		<tr>
		<td><table>
		<tr>
		<td>[
		견적인 정보 ]</td>
		</tr>

		</table></td>
		</tr>
		<tr>
		<td> <table>
		<tr>
		<td>&nbsp;견적번호</td>
		<td>
		<?=$Co_Uid ?>
		</td>
		</tr>
		<tr>
		<td>&nbsp;견적일자</td>
		<td>
		<?=date("Y.m.d", $List[BuyDate]) ?>
		</td>
		</tr>
		<tr>
		<td>&nbsp;견적인</td>
		<td> <a  href='mailto:$SEmail'>
		<?=$List[SName] ?>
		</a> </td>
		</tr>
		<tr>
		<td>&nbsp;E-mail</td>
		<td><a  href='mailto:<?=$List[SEmail] ?>'>
		<?=$List[SEmail] ?>
		</a></td>
		</tr>
		<tr>
		<td>&nbsp;전화번호</td>
		<td>
		<?=$List[STel1] ?>
		</td>
		</tr>
		<tr>
		<td>&nbsp;휴대폰</td>
		<td>
		<?=$List[STel2] ?>
		</td>
		</tr>
		<tr>
		<td>&nbsp;주소</td>
		<td>
		<?=$List[RAddress1] ?>
		</td>
		</tr>
		</table></td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		</table></td>
		</tr>
		<tr>
		<td><table>
		<tr>
		<td>
		<p>
		<?if($OrderStatus == 50) :
		?>
		<a  href='#' onClick="javascript:alert('\n\n거래가 완료된 상태에서 삭제가 불가능합니다. \n\n거래상태를 주문접수됨으로 변경후  \n\n삭제 처리하십시오.\n\n')">[견적데이터삭제]</a>
		<?else: ?>
		<script  language="javascript">
			function really1() {

				if (confirm('\n\n삭제된 주문데이터는 복구가 불가능합니다.  \n\n정말로 삭제하시겠습니까?  \n\n'))
					return true;

				return false;

			}

		</script>
		<a  href='./order1_1.php?uid=<?ECHO "$uid"; ?>&action=qde' onClick='return really1();'>[견적데이터삭제]</a>
		<?endif; ?>
		<a  href='#' onClick='jvascript:self.close()'>[창닫기]</a> </p>

		</td>
		</tr>
		</table> </tr>
		<tr>
		<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
		<td>&nbsp; </td>
		</tr>
		</table>
		<table>

		<tr> <td background='../mall_image/list_line.gif' height=1> </td></tr> </table>
	</body>
</html>