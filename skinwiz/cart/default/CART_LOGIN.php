<script>
$(function(){
	$("#s_form").submit(function(){
		if($("#inner_id").val() == ""){
			alert('아이디를 입력하세요');
			$("#inner_id").focus();
			return false;
		}else if($("#inner_pwd").val() == ""){
			alert('패스워드를 입력하세요');
			$("#inner_pwd").focus();
			return false;
		}
	});
});
</script>
<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active">주문서 작성</li>
</ul>

<dl class="ment">
	<dt>회원구매 :</dt>
	<dd>온라인 회원으로 가입하시면 회원들간 정부 공유는 물론, 각종 이벤트 참여 및 정보를 제공받으실 수 있습니다.</dd>
</dl>
<form method="post" action='./wizmember/LOG_CHECK.php' id="s_form">
	<input type="hidden" name=file value='wizbag'>
	<!-- 파일명 : 일반적으로 뒤의 확장자 생략 -->
	<input type="hidden" name="goto" value='step2'>
	<input type="hidden" name="op" value='<?php echo $op?>'>
	<dl class="dl_gen">
		<dt style="width:140px"><img src="./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]?>/images/img_logins.gif" width="146" height="119"></dt>
		<dd> <br />
			<img src="./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]?>/images/img_id.gif" width="76">
			<input name="wizmemberID" type="text" id="inner_id" tabindex="10" class="w100">
			<br />
			<img src="./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]?>/images/img_pass.gif" width="76">
			<input name="wizmemberPWD" type="password" id="inner_pwd" class="w100" tabindex="11">
			<input type="image" src="./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]?>/images/but_login.gif" width="77" tabindex="12" />	</dd>
	</dl>
</form>
<dl class="ment">
	<dt>비회원구매 : </dt>
	<dd>비회원으로 구입하실 수 있습니다.<br />
		온라인 회원으로 가입하시면 각종 정보를 제공받으실 수 있습니다.</dd>
</dl>
<dl class="dl_gen" style="padding:50px">
	<dt style="width:380px">▣ 비회원으로 구매하시려면 아래의 확인 버튼을 눌러주세요.</dt>
	<dd><a href='./wizbag.php?query=step2&check=<?php echo $check?>'><img src="./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]?>/images/but_ok2.gif" width="68"></a></dd>
	<dt style="width:380px">▣ 회원으로 가입하신 후 주문하시면 다양한 혜택을 누릴 수 있습니다.</dt>
	<dd><a href='./wizmember.php?query=regis_step1'><img src="./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]?>/images/but_members.gif" width="87"></a></dd>
</dl>
