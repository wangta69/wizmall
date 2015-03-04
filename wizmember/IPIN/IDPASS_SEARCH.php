<?php
/*
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/

/********************************** id search 인 경우 아래를 실행한다. **************************/
include_once "./lib/class.mail.php";//메일관련 클라스 인클루드
$mail		= new classMail();
$_SESSION['realName']="findIdPwd"; 

if($action == 'idsearch'){
	$name = $_POST["name"];
	$email	= $_POST["email"];

	$realname	= $_POST["realname"];//실명인증을 통한 체크
	$hidden_ci	= $_POST["ci"];
	

	if($realname == "true"){
		$sqlstr = "select i.email, m.mname, m.mid, m.mpasswd, m.mgrantsta from wizMembers m left join wizMembers_ind i on m.mid=i.id where i.ci='".$hidden_ci."'";
	}else{
		$sqlstr = "select i.email, m.mname, m.mid, m.mpasswd, m.mgrantsta from wizMembers m left join wizMembers_ind i on m.mid=i.id where m.mname='".$name."' AND i.email='".$email."'";
	}
	
	$dbcon->_query($sqlstr );
	$result = $dbcon->_fetch_array(); 

	//$email=$result["email"];	
	if ( !$result ) {
		$result_code = "0001";
		$message_idsearch = "<div class=\"alert alert-danger\">일치하는 데이터를 찾지 못했습니다. <br /> 새로 검색해 주시기 바랍니다.</div>";
	}else if($result["mgrantsta"] == "00"){
		$result_code = "0002";
		$message_idsearch = "<div class=\"alert alert-danger\">이미 탈퇴된 회원입니다.</div>";
	}else if($mode == "mail"){//아이디 찾기에서 메일발송은 추후 삭제
		$result_code = "0000";
		include ("./wizmember/".$cfg["skin"]["MemberSkin"]."/IDPASS_MAIL.php");
		$message_idsearch = " <div class=\"alert alert-success\">아이디와 패스워드를 ".$result["email"]."로 발송하여 드렸습니다.</div>";
	}else if($mode == "print"){
		$result_code = "0000";
		$message_idsearch = "<div class=\"alert alert-success\">고객님의 아이디는 <font color='#0092B6'>".$result["mid"]." 입니다</div>";
	}
/********************************** pass search 인 경우 아래를 실행한다. **************************/

}else if($action == 'passsearch'){
	$name	= $_POST["name"];
	$id		= $_POST["id"];
	$email	= $_POST["email"];
	
	$realname	= $_POST["realname"];//실명인증을 통한 체크
	$hidden_ci	= $_POST["ci"];
	

	if($realname == "true"){
		$sqlstr = "select i.email, m.mname, m.mid, m.mpasswd, m.mgrantsta from wizMembers m left join wizMembers_ind i on m.mid=i.id where i.ci='".$hidden_ci."'";
		$result = $dbcon->get_row($sqlstr);
		
		if($result["mid"]){
			$newpwd = setNewPassword();//신규 패스워드를 업데이트 하고 
			$sqlstr = "update wizMembers m set mpasswd='".$common->mksqlpwd($newpwd)."' where m.mid='".$result["mid"]."'"; 
			$dbcon->_query($sqlstr);
		}
		
	}else{
		$sqlstr = "select i.email, m.mname, m.mid, m.mpasswd, m.mgrantsta from wizMembers m left join wizMembers_ind i on m.mid=i.id where m.mname='".$name."' AND m.mid='".$id."' AND i.email='".$email."'";
		$result = $dbcon->get_row($sqlstr);
	}

	

	//$email=$result["email"];
		
	if ( !$result ) {
		$result_code = "1001";
		$message_passsearch = "<div class=\"alert alert-danger\">일치하는 데이터를 찾지 못했습니다. <br /> 새로 검색해 주시기 바랍니다.</div>";
	}else if($mode == "mail"){
		$result_code = "1000";
		
		extract($result);
		$tmpemail			= explode("@", $email);
		
		$newpwd = setNewPassword();//신규 패스워드를 업데이트 하고 
		##현재 패스워드 업데이트
		$sqlstr = "update wizMembers m set mpasswd='".$common->mksqlpwd($newpwd)."' where m.mid='".$id."'"; 
		$dbcon->_query($sqlstr);
		
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
		$message_passsearch = "<div class=\"alert alert-success\">패스워드를 ".$result["email"]."로 발송하여 드렸습니다.</div>";
	}else if($mode == "print"){
		$result_code = "1000";
		$message_passsearch = "<div class=\"alert alert-success\">고객님의 패스워드는 <font color='#0092B6'>".$newpwd."</font> 로 신규 발급되었습니다.</br> 로그인후 패스워드를 변경해 주세요</div>";
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

	function setNewPassword(){
		##난수를 발생시킨다.
		list($usec, $sec)	= explode(' ', microtime()); 
		$seed				=  (float)$sec + ((float)$usec * 100000); 
		srand($seed);
		$newpwd = base64_encode(substr($seed, -5));
		return $newpwd;
	}
?>
<script language=javascript src="./js/jquery.plugins/jquery.validator-1.0.1.js"></script>
<script>
	var realnameModule = "<?php echo $cfg["mem"]["realnameModule"]; ?>";
	var findKind = "";//idsearch or passsearch
	var findMethod	= "";//mobile or ipin
	
$(function(){

	//user-data-namecheck
	$("#idsearch_form").submit(function(){
		return $('#idsearch_form').formvalidate();
	});

	$("#passsearch_form").submit(function(){
		return $("#passsearch_form").submit();
	});
	
	$(".btn_getAuth").click(function(){
		var namecheck = $(this).attr("user-data-namecheck");
		var namecheckSplit = namecheck.split("|");
		findKind	= namecheckSplit[0];
		findMethod	= namecheckSplit[1];
		//alert(findKind + "," + findMethod);
		switch(realnameModule){
			case "KCB":
				switch(findMethod){
					case "mobile":
						alert('준비중입니다.');
					break;
					case "ipin":
						jsSubmit("./skinwiz/nameservice/"+realnameModule+"/IPIN/ipin2.php");
					break;
				}
			break;
		}
	});
	
	
});

function jsSubmit(url){	
	var popupWindow = window.open(url, "realNameModule", "left=200, top=100, status=0, width=450, height=550");
	popupWindow.focus()	;
}

function parentCheckResultFunction(flag, params){
	if(flag == true){
		$("#hidden_action").val(findKind);
		//$("#hidden_mode").val(findMethod);
		$("#hidden_ci").val(params.result_ci);
		$("#hidden_di").val(params.result_di);
		$("#idpasssearch_form").submit();
		alert('submited');
	}else{
		alert('인증에 실패하였습니다.');
	}
}
</script>
<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active">아이디 및 비밀번호 찾기</li>
</ul>

<div class="panel">
	아이디 찾기
  
	<div class="panel-footer">
		ID(아이디)를 잊으셨나요?<br />
	</div>
</div>
<!-- 실명인증을 통한  id / pwd 찾기 -->
<form name="idpasssearch_form" id="idpasssearch_form" action='<?=$PHP_SELF?>' method="post">
	<input type="hidden" name="query" value="idpasssearch">
	<input type="hidden" name="action" id="hidden_action" value="">
	<input type="hidden" name="mode" value="print">
	<input type="hidden" name="realname" value="true">
	<input type="hidden" name="ci" id="hidden_ci"  value="">
	<input type="hidden" name="di" id="hidden_di"  value="">
</form>

<?php if($message_idsearch) echo $message_idsearch; ?>
                          	
	<div class="row">
		<div class="col-lg-6"> 
			<div class="panel">
				<b>이메일 정보</b>
		  
				<div class="panel-footer">
					<form name="idsearch_form" id="idsearch_form" action='<?=$PHP_SELF?>' method="post" class="form-horizontal" role="form">
					<input type="hidden" name="query" value="idpasssearch">
					<input type="hidden" name="action" value="idsearch">
					<input type="hidden" name="mode" value="print">
						<div class="form-group">
							<label for="inputName" class="col-lg-2 control-label">이름</label>
							<div class="col-lg-10">
								<input name="name" type="text" id="inputName" class="required form-control" msg="이름을 입력하세요" placeholder="이름을 입력해주세요" />
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail" class="col-lg-2 control-label">이메일</label>
							<div class="col-lg-10">
								<input name="email" type="text" id="inputEmail" class="required form-control" msg="이메일을 입력하세요" placeholder="이메일을 입력하세요" />
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12 col-lg-offset-4">
								<button type="submit" class="btn btn-default">아이디 찾기</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-6"> 
			<div class="panel">
				<b>실명인증정보</b>
				<div class="panel-footer" style="height:170px">
					<button type="button" class="btn btn-default btn_getAuth" user-data-namecheck="idsearch|mobile">휴대폰 인증</button>
					<button type="button" class="btn btn-default btn_getAuth" user-data-namecheck="idsearch|ipin">아이핀 인증</button>
				</div>
			</div>
		</div> <!-- col-lg-12 text-center -->
	</div><!-- row -->
	
	

	


<div class="panel">
	비밀번호 찾기
  
	<div class="panel-footer">
		회원님의 비밀번호를 잊으셨나요?<br />아이디와 주민등록번호를 입력하신 후 &quot;찾기&quot;버튼을 눌러주세요
	</div>
</div>
<?php if($message_passsearch) echo $message_passsearch;?>

	<div class="row">
		<div class="col-lg-6"> 
			<div class="panel">
				<b>이메일 정보</b>
				<div class="panel-footer">
					<form name="idsearch_form" id="idsearch_form" action='<?=$PHP_SELF?>' method="post" class="form-horizontal" role="form">
					<input type="hidden" name="query" value="idpasssearch">
					<input type="hidden" name="action" value="passsearch">
					<input type="hidden" name="mode" value="mail">
						<div class="form-group">
							<label for="inputName" class="col-lg-2 control-label">이름</label>
							<div class="col-lg-10">
								<input name="name" type="text" id="inputName" class="required form-control" msg="이름을 입력하세요" placeholder="이름을 입력해주세요" />
							</div>
						</div>
						<div class="form-group">
							<label for="inputId" class="col-lg-2 control-label">아이디</label>
							<div class="col-lg-10">
								<input name="id" type="text" id="inputId" class="required form-control" msg="아이디를 입력하세요" placeholder="아이디를 입력해주세요" />
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail" class="col-lg-2 control-label">이메일</label>
							<div class="col-lg-10">
								<input name="email" type="text" id="inputEmail" class="required form-control" msg="이메일을 입력하세요" placeholder="이메일을 입력하세요" />
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12 col-lg-offset-4">
								<button type="submit" class="btn btn-default">패스워드 찾기</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-6"> 
			<div class="panel">
				<b>실명인증정보</b>
				<div class="panel-footer" style="height:215px">
					<button type="button" class="btn btn-default btn_getAuth" user-data-namecheck="passsearch|mobile">휴대폰 인증</button>
					<button type="button" class="btn btn-default btn_getAuth" user-data-namecheck="passsearch|ipin">아이핀 인증</button>
				</div>
			</div>
		</div> <!-- col-lg-12 text-center -->
	</div><!-- row -->
	

<!--
<form name="passsearch_form" id="passsearch_form" action='<?=$PHP_SELF?>' method="post" class="form-horizontal" role="form">
	<input type="hidden" name="query" value="idpasssearch">
	<input type="hidden" name="action" value="passsearch">
	<input type="hidden" name="mode" value="mail">

	<div class="form-group">
		<label for="inputId" class="col-lg-2 control-label">아이디</label>
		<div class="col-lg-10">
			<input name="id" type="text" tabindex="11" id="inputId" class="required form-control" msg="아이디를 입력하세요" placeholder="아이디를 입력하세요" />
		</div>
	</div>
	<div class="form-group">
		<label for="inputName" class="col-lg-2 control-label">주민등록번호</label>
		<div class="col-lg-4">
			<input name="juminno1" type="text" tabindex="12" maxlength="6" onkeyup="moveFocus(6,this,document.idsearch_form.juminno2)" class="form-control required" msg="주민번호를 입력하세요"  placeholder="주민번호를 입력하세요" />
		</div>
		<label class="col-lg-2 control-label">-</label>
		<div class="col-lg-4">
						<input name="juminno2" type="text" tabindex="13" maxlength="7" class="form-control required" msg="주민번호를 입력하세요" placeholder="주민번호를 입력하세요" />
		</div>
	</div>

	<div class="form-group">
		<div class="col-lg-6 col-lg-offset-6">
			<button type="submit" class="btn btn-default">패스워드 찾기</button>
		</div>
	</div>
</form>-->