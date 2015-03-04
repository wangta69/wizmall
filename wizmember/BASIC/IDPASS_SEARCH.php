<?
/*
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/

/********************************** id search 인 경우 아래를 실행한다. **************************/
include_once "./lib/class.mail.php";//메일관련 클라스 인클루드
$mail		= new classMail();

if($action == 'idsearch'){
	if(!strcmp($PasswordHintEnable,"checked")){
		$sqlstr = "select i.email, m.mname, m.mid, m.mpasswd, m.mgrantsta from wizMembers m left join wizMembers_ind i on m.mid=i.id where m.mname='$name' AND i.pwdhint='$pwdhint' AND i.pwdanswer='$pwdanswer'";
	}else{
		$sqlstr = "select i.email, m.mname, m.mid, m.mpasswd, m.mgrantsta from wizMembers m left join wizMembers_ind i on m.mid=i.id where m.mname='$name' AND i.jumin1='".$common->mksqlpwd($juminno1, "memjumin")."' AND i.jumin2='".$common->mksqlpwd($juminno2, "memjumin")."'";
	}
	//echo $sqlstr;
	$dbcon->_query($sqlstr );
	$result = $dbcon->_fetch_array(); 

	
	$email=$result["email"];	
	if ( !$result ) {
		$result_code = "0001";
		$message_idsearch = "일치하는 데이터를 찾지 못했습니다. <br /> 새로 검색해 주시기 바랍니다.";
	}else if($result[mgrantsta] == "00"){
		$result_code = "0002";
		$message_idsearch = "이미 탈퇴된 회원입니다.";
	}else if($mode == "mail"){//아이디 찾기에서 메일발송은 추후 삭제
		$result_code = "0000";
		include ("./wizmember/".$cfg["skin"]["MemberSkin"]."/IDPASS_MAIL.php");
		$message_idsearch = " 아이디와 패스워드를 ".$result["email"]."로 발송하여 드렸습니다.";
	}else if($mode == "print"){
		$result_code = "0000";
		$message_idsearch = "고객님의 아이디는 <font color='#0092B6'>".$result[mid]." 입니다";
	}
/********************************** pass search 인 경우 아래를 실행한다. **************************/

}else if($action == 'passsearch'){
	if(!strcmp($PasswordHintEnable,"checked")){
		$sqlstr = "select i.email, m.mname, m.mid, m.mpasswd, m.mgrantsta from wizMembers m left join wizMembers_ind i on m.mid=i.id where m.mid='$id' AND i.pwdhint='$pwdhint' AND i.pwdanswer='$pwdanswer'";
	}else{
		$sqlstr = "select i.email, m.mname, m.mid, m.mpasswd, m.mgrantsta from wizMembers m left join wizMembers_ind i on m.mid=i.id where m.mid='$id' AND i.jumin1='".$common->mksqlpwd($juminno1, "memjumin")."' AND i.jumin2='".$common->mksqlpwd($juminno2, "memjumin")."'";
	}

	//echo $sqlstr;
	$result = $dbcon->get_row($sqlstr);

	$email=$result["email"];
		
	if ( !$result ) {
		$result_code = "1001";
		$message_passsearch = "일치하는 데이터를 찾지 못했습니다. <br /> 새로 검색해 주시기 바랍니다.";
	}else if($mode == "mail"){
		$result_code = "1000";
		
		extract($result);
		$tmpemail			= explode("@", $email);
		
		##난수를 발생시킨다.
		list($usec, $sec)	= explode(' ', microtime()); 
		$seed				=  (float)$sec + ((float)$usec * 100000); 
		srand($seed);
		$newpwd = base64_encode(substr($seed, -5));
		
		##현재 패스워드 업데이트
		$sqlstr = "update wizMembers m set mpasswd='".$common->mksqlpwd($newpwd)."' where m.mid='$id'"; 
		$dbcon->_query($sqlstr);
		
		
		//include "../../config/cfg.core.php";
		$mailformfile = file("./skinwiz/mailform/default/IDPASS_MAIL.php");
		$mailform = "";
		for($i=0;$i<=sizeof($mailformfile); $i++){
			$mailform .= $mailformfile[$i];
			
		}
		$mailform  = chform($mailform);

	
		if ( $email) {
			//$mail->charset = 'EUC-KR';//한국어
			$mail->From ($cfg["admin"]["ADMIN_EMAIL"], $common->conv_euckr($cfg["admin"]["ADMIN_TITLE"]));
			$mail->To ($email);
			$mail->Organization ($common->conv_euckr($cfg["admin"]["ADMIN_TITLE"]));
			$mail->Subject ($common->conv_euckr("개인정보 안내입니다. - ".$cfg["admin"]["ADMIN_TITLE"]));
			$mail->Body ($common->conv_euckr($mailform));
			$mail->Priority (3);
			//$mail->debug	= true;
			$ret = $mail->Send();
		}
		
		//include ("./wizmember/".$cfg["skin"]["MemberSkin"]."/IDPASS_MAIL.php");
		$message_passsearch = " 아이디와 패스워드를 ".$result[email]."로 발송하여 드렸습니다.";
	}else if($mode == "print"){
		$result_code = "1000";
		$message_passsearch = "고객님의 패스워드는 <font color='#0092B6'>".$result[mpasswd]." 입니다";
	}
}

	function chform($str){
		global $cfg, $mname, $mid, $newpwd;
		$str = str_replace("{url}", $cfg["admin"]["MART_BASEDIR"]."/skinwiz/mailform/default", $str);
		$str = str_replace("{homeurl}", $cfg["admin"]["MART_BASEDIR"], $str);
		$str = str_replace("{username}", $mname, $str);
		$str = str_replace("{userid}", $mid, $str);
		$str = str_replace("{userpwd}", $newpwd, $str);
		$str = str_replace("{admin.title}", $cfg["admin"]["ADMIN_TITLE"], $str);
		$str = str_replace("{admin.name}", $cfg["admin"]["ADMIN_NAME"], $str);
		$str = str_replace("{admin.companynum}", $cfg["admin"]["COMPANY_NUM"], $str);
		$str = str_replace("{admin.companyaddress}", $cfg["admin"]["COMPANY_ADD"], $str);
		$str = str_replace("{admin.companyname}", $cfg["admin"]["COMPANY_NAME"], $str);
		$str = str_replace("{admin.companyceo}", $cfg["admin"]["PRESIDENT"], $str);
		$str = str_replace("{admin.companytel}", $cfg["admin"]["CUSTOMER_TEL"], $str);
		$str = str_replace("{admin.companyfax}", $cfg["admin"]["CUSTOMER_FAX"], $str);
		return $str;
	}
?>
<script language=javascript src="./js/jquery.plugins/jquery.validator-1.0.1.js"></script>
<script>
$(function(){
	$(".btn_find_id").click(function(){
		if($('#idsearch_form').formvalidate()){
			$("#idsearch_form").submit();
		}
	});

	$(".btn_find_pass").click(function(){
		if($('#passsearch_form').formvalidate()){
			$("#passsearch_form").submit();
		}
	});
});
</script>
<div class="navy">Home &gt; 아이디 및 비밀번호 찾기</div>
<div class="space15"></div>
- 회원님!! 아이디 또는 비밀번호를 
            잊으셨나요? 입력하신 후 [확인]단추를 누르세요
<? if($message_idsearch) echo $message_idsearch; else echo "ID(아이디)를 잊으셨나요?<br />
                          <font color='#FF9900'>이름과 <font color='#FF9900'>주민등록번호를 
                          입력하신 후 <font color='#FF9900'>&quot;찾기&quot;버튼을 눌러주세요"; ?>
<form action='<?=$PHP_SELF?>' method=post name="idsearch_form" id="idsearch_form">
	<input type="hidden" name="query" value="idpasssearch">
	<input type="hidden" name="action" value="idsearch">
	<input type="hidden" name="mode" value="print">
	<dl class="dl_gen">
		<dt>
			<table class="table_main" style="width:400px">
			<col width="120px" />
			<col width="*" />
				<tr>
					<th>이름</th>
					<td><input name="name" type="text" tabindex="11" class="required" msg="이름을 입력하세요" />
					</td>
				</tr>
				<? if(!strcmp($PasswordHintEnable,"checked")):?>
				<tr>
					<th>비밀번호 힌트질문</th>
					<td><select name=pwdhint class="select required" id="pwdhint" msg="비밀번호 힌트질문을 선택하세요">
							<option value=''>선택하십시오.</option>
							<?
reset($PasswordHintArr);
while(list($key, $value) = each($PasswordHintArr)):
	
	echo "<option value='$value'>$value</option>\n";
endwhile;
?>
						</select></td>
				</tr>
				<tr>
					<th>비밀번호 힌트답</th>
					<td><input name="pwdanswer" type="text" id="pwdanswer" maxlength="30" class="required" msg="비밀번호 힌트답을 입력하세요"  />
					</td>
				</tr>
				<?
else:
?>
				<tr>
					<th>주민등록번호</th>
					<td><input name="juminno1" type="text" tabindex="12" maxlength="6" onkeyup="moveFocus(6,this,document.idsearch_form.juminno2)" class="w50 required" msg="주민번호를 입력하세요">
						-
						<input name="juminno2" type="text" tabindex="13" maxlength="7" class="w50 required" msg="주민번호를 입력하세요"></td>
				</tr>
				<?
endif;
?>
			</table>
		</dt>
		<dd style="padding-left:20px">
			<img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_search.gif" class="btn_find_id" tabindex="4">
		</dd>
	</dl>
</form>
<div class="space20"></div>
<? if($message_passsearch) echo $message_passsearch; else echo "회원님의 비밀번호를 잊으셨나요?<br />
                          <font color='#FF9900'>아이디와 <font color='#FF9900'>주민등록번호를 
                          입력하신 후 <font color='#FF9900'>&quot;찾기&quot;버튼을 눌러주세요"; ?>
<form action='<?=$PHP_SELF?>' method=post name="passsearch_form" id="passsearch_form">
	<input type="hidden" name="query" value="idpasssearch">
	<input type="hidden" name="action" value="passsearch">
	<input type="hidden" name="mode" value="mail">
	<dl class="dl_gen">
		<dt>
			<table class="table_main" style="width:400px">
						<col width="120px" />
			<col width="*" />
				<tr>
					<th>아이디</th>
					<td><input name="id" type="text" tabindex="14" class="required" msg="아이디를 입력하세요"></td>
				</tr>
				<? if(!strcmp($PasswordHintEnable,"checked")):?>
				<tr>
					<th>비밀번호 힌트질문</th>
					<td><select name="pwdhint" class="required select" id="pwdhint" msg="비밀번호 힌트질문을 선택하세요">
							<option value=''>선택하십시오.</option>
							<?
reset($PasswordHintArr);
while(list($key, $value) = each($PasswordHintArr)):
	
	echo "<option value='$value'>$value</option>\n";
endwhile;
?>
						</select></td>
				</tr>
				<tr>
					<th>비밀번호 힌트답</th>
					<td><input name="pwdanswer" type="text" id="pwdanswer" maxlength="30" class="required" msg="비밀번호 힌트답을 입력하세요" />
					</td>
				</tr>
				<?
else:
?>
				<tr>
					<th>주민등록번호</th>
					<td><input name="juminno1" type="text" tabindex="15" maxlength="6" onkeyup="moveFocus(6,this,document.passsearch_form.juminno2)" class="w50 required" msg="주민번호를 입력하세요" >
						-
						<input name="juminno2" type="text" tabindex="16" maxlength="7" class="w50 required" msg="주민번호를 입력하세요" ></td>
				</tr>
				<?
endif;
?>
			</table>
		</dt>
		<dd style="padding-left:20px">
			<img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_search.gif" class="btn_find_pass" tabindex="8">
		</dd>
	</dl>
</form>
