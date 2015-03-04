<script language="javascript">
<!--

	$(function(){
	
	});


function check_form(f){
	var af = document.agree_form;
	if(af.agree_check.checked == false){
		alert('이용약관에 동의하셔야 회원가입을 계속하실 수 있습니다.');
		return false;		
	}else if(f.UserName.value == ""){
		alert('성명을 입력해 주세요');
		return false;		
	}else if(!IsJuminChk(f.UserJumin1.value, f.UserJumin2.value)){
		f.UserJumin1.focus();
		return false;
	}else return true;
}
//-->
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
<textarea name="yakkwan" rows="40" READONLY class="w100p">
<?=$aggrement?>
</textarea>
<p></p>
<form name="agree_form">
	<input type="checkbox" name="agree_check" value="1">
	회원약관과 개인정보보호정책에 동의합니다.
</form>
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
