<?php
/* 
제작자 : 폰돌
제작자 URL : http://www.shop-wiz.com
제작자 Email : master@shop-wiz.com
Free Distributer 

*** Updating List ***
*/
include_once ("../lib/inc.depth1.php"); //1debp에 사용할 공동 인자값

if(!strcmp($smode,"qin")):
   	$maxvalue = $dbcon->get_one("select max(uid) from wizInquire");
	$uid = $maxvalue ?  $maxvalue+1 : 1;
    
    ## 파일 업로드 시작
    $rtnfile = $common->image_up("insert", "../config/uploadfolder/etc", "file", "wizInquire", $uid);

    if($tel1) $tel="${tel1}-${tel2}-${tel3}";
    if($hand1) $hand="${hand1}-${hand2}-${hand3}";
    if($fax1) $fax="${fax1}-${fax2}-${fax3}";
    $juminno = $juminno1."-".$juminno2;
    $zip="${zip1}-${zip2}";
    if($email1) $email = $email1."@".$email2;
    $sqlstr = "INSERT INTO wizInquire (uid,iid,userid,compname,name,juminno,tel,hand,fax,email,url,zip,address1,address2,subject,contents,contents1,contents2,option1,option2,option3,attached,wdate)
    VALUES('$uid', '$iid','".$cfg["member"]["mid"]."','$compname','$name','$juminno','$tel','$hand','$fax','$email','$url','$zip','$address1','$address2','$subject','$contents','$contents1','$contents2','$option1','$option2','$option3','".$rtnfile[0]."',".time().")"; 
    $dbcon->_query($sqlstr);
	
	//include "./wizinquiry_mail_form.php";
	
	
	if ($sendmail) {
		$file = './skinwiz/inquire/wizinquiry_mail_form.php';
		ob_start();
		readfile($file);
		$body_txt = ob_get_clean();
		$body_txt = eregi_replace("{compname}", $compname, $body_txt);
		$body_txt = eregi_replace("{name}", $name, $body_txt);
		$body_txt = eregi_replace("{juminno1}", $juminno1, $body_txt);
		$body_txt = eregi_replace("{juminno2}", $juminno2, $body_txt);
		$body_txt = eregi_replace("{tel1}", $tel1, $body_txt);
		$body_txt = eregi_replace("{tel2}", $tel2, $body_txt);
		$body_txt = eregi_replace("{tel3}", $tel3, $body_txt);
		$body_txt = eregi_replace("{hand1}", $hand1, $body_txt);
		$body_txt = eregi_replace("{hand2}", $hand2, $body_txt);
		$body_txt = eregi_replace("{hand3}", $hand3, $body_txt);
		$body_txt = eregi_replace("{fax1}", $fax1, $body_txt);
		$body_txt = eregi_replace("{fax2}", $fax2, $body_txt);
		$body_txt = eregi_replace("{fax3}", $fax3, $body_txt);
		$body_txt = eregi_replace("{email}", $email, $body_txt);
		$body_txt = eregi_replace("{url}", $url, $body_txt);
		$body_txt = eregi_replace("{zip1}", $zip1, $body_txt);
		$body_txt = eregi_replace("{zip2}", $zip2, $body_txt);
		$body_txt = eregi_replace("{address1}", $address1, $body_txt);
		$body_txt = eregi_replace("{address2}", $address2, $body_txt);
		$body_txt = eregi_replace("{contents}", nl2br($contents), $body_txt);
		
		include_once "../lib/class.mail.php";
		$class_mail		= new classMail();	
		
		$class_mail->From ($email, $common->conv_euckr($name));
		//$class_mail->To ("preclear@naver.com");
		//$class_mail->charset	= "UTF-8";
		$class_mail->To ("wangta69@naver.com");//
		$class_mail->Organization ("SHOP-WIZ MAILER");//
		$class_mail->Subject ($common->conv_euckr("온라인 상담"));
		$class_mail->Body ($common->conv_euckr($body_txt));
		$class_mail->Priority (3);
		$ret = $class_mail->Send();
			
	}


    $common->js_alert('성공적으로 접수되었습니다.', '../');
	
	
	
    //include "./util/formmail/dongha/mail.php";
    //include "./cgi/formail.php"
endif;
?>
<script type="text/javascript"  src="../js/jquery.min.js"></script>
<script type="text/javascript"src="../js/jquery.plugins/jquery.validator.js" ></script>
<script type="text/javascript" src="../js/wizmall.js"></script>
<link type="text/css" rel="stylesheet" href="../css/base.css" />
<link type="text/css" rel="stylesheet" href="../css/common.css"/>
<link type="text/css" rel="stylesheet" href="../css/mall.css" />


<script>
$(function(){
	$("#btn_insert").click(function(){
		if($('#s_form').formvalidate()){
			$("#s_form").submit();
		}
	});

	$(".btn_find_zip").click(function(){
		SearchZipcode();
	});
});

function SearchZipcode(){
window.open("../util/zipcode/zipcode.php?form=s_form&zip1=zip1&zip2=zip2&firstaddress=address1&secondaddress=address2","ZipWin","width=490,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no");
}
</script>
<form name="s_form" id="s_form" method="POST" action="<?=$PHP_SELF?>" enctype="multipart/form-data">
<!--  onsubmit='return checkForm(this);'  -->
	<input type="hidden" name="smode" value="qin">
	<input type="hidden" name="iid" value="INQ1">
	<table class="table_main w100p">
	<col width="120px" />
	<col width="*" />	
		<tr>
			<th>회사명</th>
			<td><input type="text" name="compname" maxlength="30" >
			</td>
		</tr>
		<tr>
			<th>성명</th>
			<td><input type="text" name="name" maxlength="30" class="required"  msg="성명을 입력하세요" />
			</td>
		</tr>
		<tr>
			<th>주민번호</th>
			<td><input type="text" maxlength="6" name="juminno1" class="w50" />
				-
				<input type="text" maxlength="7" name="juminno2" class="w50" /></td>
		</tr>
		<tr>
			<th>전화번호</th>
			<td>
			<select name="tel1" class="w50 required" msg="전화번호를 입력하세요">
												<option selected value=''>지역별</option>
												<?
												foreach($PhoneArr2 as $key=>$val){
													echo "<option value='".$key."' >".$key."</option>\n";
												}
												?>
											</select>

				-
				<input type="text" maxlength="4" name="tel2" class="w50 required" msg="전화번호를 입력하세요" />
				-
				<input type="text" maxlength="4" name="tel3" class="w50 required" msg="전화번호를 입력하세요" />
			</td>
		</tr>
		<tr>
			<th>휴대폰</th>
			<td>
						<select name="hand1" class="w50 required" msg="전화번호를 입력하세요">
												<option selected value=''>모바일폰</option>
												<?
												foreach($PhoneArr1 as $key=>$val){
													echo "<option value='".$key."' >".$key."</option>\n";
												}
												?>
											</select>
				-
				<input type="text" maxlength=4 name="hand2" class="w50" />
				-
				<input type="text" maxlength=4 name="hand3" class="w50" />
			</td>
		</tr>
		<tr>
			<th>팩스</th>
			<td><input type="text" maxlength=4 name="fax1" class="w50" />
				-
				<input type="text" maxlength=4 name="fax2" class="w50" />
				-
				<input type="text" maxlength=4 name="fax3" class="w50" /></td>
		</tr>
		<tr>
			<th>email</th>
			<td><input type="text" name="email" maxlength="30" >
			</td>
		</tr>
		<tr>
			<th>url</th>
			<td><input type="text" name="url" maxlength="30" >
			</td>
		</tr>
		<tr>
			<th rowspan="3">주소</th>
			<td><input type="text" maxlength=3 name="zip1" id="zip1" class="w50" readonly />
				-
				<input type="text" maxlength=3 name="zip2" id="zip2" class="w50" readonly />
				<span class="button bull btn_find_zip"><a>주소찾기</a></span>		</tr>
		<tr>
			<td><input type="text" name="address1" id="address1" class="w200">
			</td>
		</tr>
		<tr>

			<td><input type="text" name="address2" id="address2" class="w200">
			</td>
		</tr>
		<tr>
			<th>contents</th>
			<td><textarea name="contents" cols="45" rows="10" class="required w100p" msg="내용을 입력하세요"></textarea></td>
		</tr>
		<tr>
			<th>첨부</th>
			<td><input type="file" name="file[0]"></td>
		</tr>
	</table>
	<br />
	<div> <span class="button bull" id="btn_insert"><a>확인</a></span> <span class="button bull"><a href="javascript:history.go(-1);">취소</a></span></div>
	<br />
</form>
