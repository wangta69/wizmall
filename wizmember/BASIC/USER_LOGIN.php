<?
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
?>
<script language=javascript src="./js/jquery.plugins/jquery.validator-1.0.1.js"></script>
<script language=javascript>
$(function(){
	$('#wizmemberPWD').keyup(function(e) {
		if(e.keyCode == 13) {
			loginProcess();
		}
	});

	$(".btn_confirm").click(function(){
		loginProcess();
	});	

	var loginProcess = function(){
		if($('#LoginForm').formvalidate()){
			$("#LoginForm").submit();
		}
	};
});
//-->
</script>

<div class="navy">Home &gt; 로그인</div>
<?php if($pt != 'adult'):?>
<!-- 로그인(성인인증제외)-->
<fieldset class="desc">
<legend>[안내]</legend>
<div class="notice">로그인</div>
<div class="comment">
온라인 1회원으로 가입하시면 회원들간 정보 공유는 물론, 각종 이벤트 참여 및 정보제공을 받으실 수 있습니다.
</div>
</fieldset>
<form method="post" action='./wizmember/LOG_CHECK.php' name="LoginForm" id="LoginForm">
	<input type="hidden" name=file value='<?=$file?>'>
	<!-- 강제적으로 파일을 base64_encode 로 파일을 처리하여 넘김 앞으로 이변수와 아래 log_from 변수만을 사용하여 처리예정-->
	<input type="hidden" name="rtnurl" value='<?=$rtnurl?>'>
	<!-- 파일명 : 일반적으로 뒤의 확장자 생략 -->
	<input type="hidden" name="goto" value='<?=$goto?>'>
	<!-- major 쿼리값 : 예, BID, -->
	<input type="hidden" name="goto1" value='<?=$goto1?>'>
	<!-- major 쿼리값 : 예, GID, -->
	<input type="hidden" name="hiddenvalue1" value='<?=$hiddenvalue1?>'>
	<!-- 기타쿼리값 : 예, mode, query, -->
	<input type="hidden" name="hiddenvalue2" value='<?=$hiddenvalue2?>'>
	<!-- 기타쿼리값 : 예, mode, query, -->
	<input type="hidden" name="log_from" value='<?=$HTTP_REFERER;?>'>

	<input type="hidden" name="op" value='<?=$op;?>'>
	<dl class="dl_gen">
		<dt></dt>
		<dd>
			<dl class="main_login">
				<dt><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_id.gif" width="76"></dt>
				<dd>
					<input name="wizmemberID" id="wizmemberID"  type="text" msg="아이디를 입력하세요"  autocomplete="off" class="w150 required">
					<input name="saveflag" type="checkbox" id="saveflag" value="1"<? if($_COOKIE["saveflag"] == "1") echo " checked"; ?> />
					아이디저장</dd>
				<dt><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/img_pass.gif" width="76"></dt>
				<dd>
					<input name="wizmemberPWD" id="wizmemberPWD" type="password" msg="패스워드를 입력하세요"  autocomplete="off" class="w150 required">
					<img tabindex=3 src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_login.gif" width="77">
				</dd>
				<dt>&nbsp;</dt>
				<dd style="padding-top:20px"><span class="button bull"><a href="./wizmember.php?query=idpasssearch">아이디/패스워드 찾기</a></span> <span class="button bull"><a href="./wizmember.php?query=regis_step1">회원가입</a></span></dd>
			</dl>
		</dd>
	</dl>
</form>
<!-- 로그인(성인인증제외)끝 -->
<?else:?>
<!-- 비회원 성인인증  -->
<!-- 비회원 성인인증 끝  -->
<?endif;?>
<?php
if ($query == 'order'): // 비회원 주문배송조회
?>
<fieldset class="desc">
<legend>[안내]</legend>
<div class="notice">로그인</div>
<div class="comment">
비회원으로 주문하신 고객께서는 주문번호를 입력하시면 주문/배송조회를 하실 수 있습니다
</div>
</fieldset>
<form action='./wizmember.php'>
	<input type="hidden" name="query" VALUE='non_member_order'>
	▣ 주문번호 :
	<input name="OrderID" type="text" class="form" size="20">
	▣ 주문자명 :
    <input name="SName" type="text" class="form" size="20">
	<input name="image2" type=image src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/but_ok2.gif" width="68">
</form>

<?endif;?>
