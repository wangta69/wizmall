<?php
$tmp_PayMethod = $list["PayMethod"];
$PayMethod = $PaySortArr[$tmp_PayMethod];

	$mailformfile = file("./skinwiz/mailform/default/ORDER_MAIL.php");
	$mailform = "";
	for($i=0;$i<=sizeof($mailformfile); $i++){
		$mailform .= $mailformfile[$i];
	}



	$mailform  = chform($mailform);

	if ( $list["SEmail"]) {
		include_once "./lib/class.mail.php";//메일관련 클라스 인클루드
		$mail		= new classMail();

		$mail->From ($cfg["admin"]["ADMIN_EMAIL"], $common->conv_euckr($cfg["admin"]["ADMIN_TITLE"]));
		$mail->To ($list["SEmail"]);
		$mail->Organization ($common->conv_euckr($cfg["admin"]["ADMIN_TITLE"]));
		$mail->Subject ($common->conv_euckr("고객님의 주문내역입니다. - ".$cfg["admin"]["ADMIN_TITLE"]." -"));
		$mail->Body ($common->conv_euckr($mailform));
		$mail->Priority (3);
		//$mail->debug	= true;
		$ret = $mail->Send();
	}

	//print_r($list);

	function chform($str){
		global $cfg, $list, $PayMethod ;

		$vieworderlist = "no";
		$ORDERLIST = "";
		if ($vieworderlist == "yes"){ 
			include "./skinwiz/cart/".$cfg["skin"]["CartSkin"]."/CART_MAIL_VIEW.php";
		}

		$str = str_replace("{url}", $cfg["admin"]["MART_BASEDIR"]."/skinwiz/mailform/default", $str);
		$str = str_replace("{homeurl}", $cfg["admin"]["MART_BASEDIR"], $str);
		$str = str_replace("{ORDERLIST}", $ORDERLIST, $str);
		$str = str_replace("{username}", $list["SName"], $str);
		

		$str = str_replace("{orderid}", $list["OrderID"], $str);
		$str = str_replace("{rname}", $list["RName"], $str);
		$str = str_replace("{rtel1}", $list["RTel1"], $str);
		$str = str_replace("{raddress}", "(".$list["RZip"].") ".$list["RAddress1"]." ".$list["RAddress2"], $str);
		$str = str_replace("{paymethod}", $PayMethod, $str);
		$str = str_replace("{buydate}", date("Y.m.d", $list["BuyDate"]), $str);

		$str = str_replace("{admin.title}", $cfg["admin"]["ADMIN_TITLE"], $str);
		//$str = str_replace("{admin.name}", $cfg["admin"]["ADMIN_NAME"], $str);
		$str = str_replace("{admin.companynum}", $cfg["admin"]["COMPANY_NUM"], $str);
		$str = str_replace("{admin.companyaddress}", $cfg["admin"]["COMPANY_ADD"], $str);
		$str = str_replace("{admin.companyname}", $cfg["admin"]["COMPANY_NAME"], $str);
		$str = str_replace("{admin.companyceo}", $cfg["admin"]["PRESIDENT"], $str);
		$str = str_replace("{admin.companytel}", $cfg["admin"]["CUSTOMER_TEL"], $str);
		$str = str_replace("{admin.companyfax}", $cfg["admin"]["CUSTOMER_FAX"], $str);
		return $str;	
	}