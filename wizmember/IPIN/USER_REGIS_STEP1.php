<script>
$(function(){
	var realnameModule = "<?php echo $cfg["mem"]["realnameModule"]; ?>";
	var reg_type = "ipin";
	$(".reg_type").click(function(){
		reg_type = $(this).val();
		$(".reg_type_desc").addClass("none");
		switch(reg_type){
			case "mobile":
				$(".reg_type_desc").eq(0).removeClass("none");
			break;
			case "ipin":
				$(".reg_type_desc").eq(1).removeClass("none");
			break;
			case "email":
				$(".reg_type_desc").eq(2).removeClass("none");
			break;
		}
	});
	
	$(".btn_getAuth").click(function(){
		if(!$(".agree_check").eq(0).is(':checked')){
			alert("약관에 동의해 주세요")
		}else{
			switch(realnameModule){
				case "KCB":
					switch(reg_type){
						case "mobile":
							alert('준비중입니다.');
						break;
						case "ipin":
							jsSubmit("./skinwiz/nameservice/"+realnameModule+"/IPIN/ipin2.php");
						break;
						case "email":
							location.href="./wizmember.php?query=regis_step2";
						break;
					}
				case "NICE":
					switch(reg_type){
						case "mobile":
							jsSubmit("./skinwiz/nameservice/"+realnameModule+"/MOBILE/checkplus_main.php");
						break;
						case "ipin":
							jsSubmit("./skinwiz/nameservice/"+realnameModule+"/IPIN/ipin_main.php");
						break;
						case "email":
							location.href="./wizmember.php?query=regis_step2";
						break;
					}
				break;
			}
		}
	});
	
	
});

function jsSubmit(url){	
	var popupWindow = window.open(url, "realNameModule", "left=200, top=100, status=0, width=450, height=550");
	popupWindow.focus()	;
}
	
</script>

<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active">회원가입</li>
</ul>

<div class="panel">
	회원가입
	<div class="panel-footer">
		아래 약관을 읽으시고 동의를 누르시면 다음 단계로 진행됩니다.
	</div>
</div>

<?			
if(is_file("./config/memberaggrement_info.php")){
	$DATA1 = file("./config/memberaggrement_info.php");
	while($dat1 = each($DATA1)) {
		//$dat1[1] = nl2br(htmlspecialchars($dat1[1]));
		$dat1[1] = stripslashes($dat1[1]);
		$aggrement .= $dat1[1];
	}
}
?>
<textarea name="yakkwan" rows="15" readonly="readonly" class="w100p">
<?=$aggrement?>
</textarea>

<form class="form-horizontal" role="form">
	<div class="checkbox">
		<label>
			<input type="checkbox" class="agree_check" value="1">
	회원약관과 개인정보보호정책에 동의합니다.
		</label>
	</div>
	<p>
		가입확인 : 
		<input name="reg_type" class="reg_type" type="radio" value="mobile" />실명확인  
		<input name="reg_type" class="reg_type" type="radio" value="ipin" checked="checked" />아이핀(I-Pin)
		<input name="reg_type" class="reg_type" type="radio" value="email" />인증없이 가입
	</p>
	<div class="well none reg_type_desc">
		<p>휴대폰 보인 인증을 통한 가입을 원하시면 아이핀 인증 버튼을 눌러 주세요</p>
		<button type="button" class="btn btn-success btn_getAuth">인증하기</button>
	</div>
	<div class="well reg_type_desc">
		<p>아이핀 인증을 통한 가입을 원하시면 아이핀 인증 버튼을 눌러 주세요</p>
		<button type="button" class="btn btn-success btn_getAuth">인증하기</button>
	</div>
	<div class="well none reg_type_desc">
		<p>바로 가입할 경우 정보찾기시 이메일로 정보가 전달되므로 이메일을 정확히 기입해 주세요</p>
		<button type="button" class="btn btn-success btn_getAuth">바로가입하기</button>
	</div>
</form>

<?php
	switch($cfg["mem"]["realnameModule"]){
		case "KCB":
?>
	<form name="kcbOutForm" method="post">
		<input type="hidden" name="encPsnlInfo" />
		<input type="hidden" name="virtualno" />
		<input type="hidden" name="dupinfo" />
		<input type="hidden" name="realname" />
		<input type="hidden" name="cprequestnumber" />
		<input type="hidden" name="age" />
		<input type="hidden" name="sex" />
		<input type="hidden" name="nationalinfo" />
		<input type="hidden" name="birthdate" />
		<input type="hidden" name="coinfo1" />
		<input type="hidden" name="coinfo2" />
		<input type="hidden" name="ciupdate" />
		<input type="hidden" name="cpcode" />
		<input type="hidden" name="authinfo" />
	</form>
<?php
			break;
		case "NICE":
		break;
	}
?>
<!--
<div class="agn_c">
	<form name="RegisForm" action="./skinwiz/nameservice/<?=$cfg["mem"]["realnameModule"]?>/index.php" method="post" onSubmit="return check_form(this)">
		<input type="hidden" name="next" value="regis_step2">
		<div id="mem_agree"> 실명 :
			<input name="UserName" type="text" id="UserName" autocomplete="off" />
			주민번호 :
			<input name="UserJumin1" type="text" id="UserJumin1" size="6" maxlength="6" onkeyup="moveFocus(6,this,document.RegisForm.UserJumin2)" autocomplete="off" />
			-
			<input name="UserJumin2" type="password" id="UserJumin2" size="7" maxlength="7" autocomplete="off" />
		</div>
		<div class="space10"></div>
		<input type="image" src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_ok.gif">
		<img src="wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_cancle.gif" ONCLICK="javascript:history.go(-1)"; style="cursor:pointer">
	</form>
</div>
-->