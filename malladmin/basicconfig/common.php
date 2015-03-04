<?php
function mkinit($val){
	global $cfg, $fp;
	foreach($cfg[$val] as $key=>$value){
		fwrite($fp,"\$cfg[\"$val\"][\"".$key."\"] = \"".$value."\";\n");
	}
}
if ($common -> checsrfkey($csrf)) {
	if (!strcmp($action,"admin_save")) {
	
		//현재 관리자 패스워드를 확인후 이후 단을 처리한다.
		$sqlstr = "select count(UID) from wizTable_Main where Grade = 'A' and Pass='$C_PASS'";
		$result = $dbcon->get_one($sqlstr);
		if($result){
			/* 관리자 아이디와 패스워드를 저장한다 */
			$Sqlstr = "UPDATE wizTable_Main SET AdminName = '$ID', Pass = '$PASS' WHERE Grade = 'A'";
			$Sqlqry = $dbcon->_query($Sqlstr);
			
	
			/* 기타 관리자 기초 사항을 입력한다. */
			$fp = fopen("../config/cfg.core.php", "w");
			fwrite($fp,"<?\n");
			//print_r($_POST);
			foreach($cfg["admin"] as $key=>$value){
				$value = $_POST[$key];
				fwrite($fp,"\$cfg[\"admin\"][\"".$key."\"] = \"".$value."\";\n");
				$cfg["admin"][$key]=$value;
			}
			foreach($cfg["sms"] as $key=>$value){
				$value = $_POST[$key];
				fwrite($fp,"\$cfg[\"sms\"][\"".$key."\"] = \"".$value."\";\n");
				$cfg["sms"][$key]=$value;
			}
			mkinit("pay");
			mkinit("skin");
			mkinit("mem");	
			fwrite($fp,"?>"); 
			fclose($fp);
		}else{
			$common->js_alert("비밀번호가 맞지 않습니다.");
		}
	}else if($action == 'pay_save') {
		$fp = fopen("../config/cfg.core.php", "w");
		fwrite($fp,"<?\n");
		mkinit("admin");
		mkinit("sms");
		foreach($cfg["pay"] as $key=>$value){
			$value = $_POST[$key];
			fwrite($fp,"\$cfg[\"pay\"][\"".$key."\"] = \"".$value."\";\n");
			$cfg["pay"][$key]=$value;
		}
		mkinit("skin");
		mkinit("mem");	
		fwrite($fp,"?>"); 
		fclose($fp); 
		
	
		if ($ZIRO_LIST) {
			$ZIRO_LIST = str_replace("\r\n", "\n", $ZIRO_LIST);
			$fp = fopen("../config/bank_info.php", "w");
			fwrite($fp, stripslashes($ZIRO_LIST));
			fclose($fp);
		}
		
		if($cfg["pay"]["CARDCHECK_ENABLE"] == "DIRNOTSAME"){
			$sqlstr = "UPDATE wizCategory SET cat_price =''";
			$dbcon->_query($sqlstr);
			if(is_array($cat_price)){
				while(list($key, $value) = each($cat_price)): 
					$sqlstr = "UPDATE wizCategory SET cat_price ='$value' WHERE cat_no ='$key'"; 
					$dbcon->_query($sqlstr);
				endwhile;
			}
		}
	}else if (!strcmp($action,"skin_save")) { 
		$fp = fopen("../config/cfg.core.php", "w");
		fwrite($fp,"<?\n");
		mkinit("admin");
		mkinit("sms");
		mkinit("pay");
		
		foreach($cfg["skin"] as $key=>$value){
			$value = $_POST[$key];
			fwrite($fp,"\$cfg[\"skin\"][\"".$key."\"] = \"".$value."\";\n");
			$cfg["skin"][$key]=$value;
		}
		
		mkinit("mem");
		fwrite($fp,"?>"); 
		fclose($fp); 
	/*}else if (!strcmp($action,"cat_skin_save")) {
		$sqlstr = "UPDATE wizCategory SET cat_skin='$CAT_SKIN', cat_skin_viewer='$CAT_SKIN_VIEWER' WHERE UID = '$UID'";
		$dbcon->_query($sqlstr);
	*/
	}else if (!strcmp($action,"mem_save")) { 
		$fp = fopen("../config/cfg.core.php", "w");
		fwrite($fp,"<?\n");
		mkinit("admin");
		mkinit("sms");
		mkinit("pay");
		mkinit("skin");
		foreach($cfg["mem"] as $key=>$value){
			$value = $_POST[$key];
			fwrite($fp,"\$cfg[\"mem\"][\"".$key."\"] = \"".$value."\";\n");
			$cfg["mem"][$key]=$value;
		} 
	
		$fp = fopen("../config/memberaggrement_info.php", "w");
		fwrite($fp,$MEMBER_AGGREMENT); 
		fclose($fp); 
		
		$STRING = $MemberSkinTop;
		$fp = fopen("../config/MemberSkinTop.php", "w"); 
		$STRING=stripslashes($STRING);
		fwrite($fp,"$STRING"); 
		fclose($fp); 
		
		$STRING = $MemberSkinBottom;
		$fp = fopen("../config/MemberSkinBottom.php", "w"); 
		$STRING=stripslashes($STRING);
		fwrite($fp,"$STRING"); 
		fclose($fp); 
		
		$fp = fopen("../config/regismail_info.php", "w");
		fwrite($fp,$WELCOM_MESSAGE); 
		fclose($fp); 
	}
}//if ($common -> checsrfkey($csrf)) {