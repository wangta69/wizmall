<?php
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

	$("#LoginForm").submit(function(){
		return loginProcess();
	});	

	var loginProcess = function(){
		if($('#LoginForm').formvalidate()){
			return true;
		}else return false;
	};
	
	$("#noneMemberForm").submit(function(){
		return $('#noneMemberForm').formvalidate()
	});	
});
//-->
</script>

<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active">로그인</li>
</ul>
<?php if($pt != 'adult'):?>
<!-- 로그인(성인인증제외)-->
<div class="panel">
	로그인
	<div class="panel-footer">
		온라인 회원으로 가입하시면 회원들간 정보 공유는 물론, 각종 이벤트 참여 및 정보제공을 받으실 수 있습니다.
	</div>
</div>

<form role="form" class="form-horizontal" method="post" action='./wizmember/LOG_CHECK.php' name="LoginForm" id="LoginForm">
	<input type="hidden" name=file value='<?php echo $file?>'>
	<!-- 강제적으로 파일을 base64_encode 로 파일을 처리하여 넘김 앞으로 이변수와 아래 log_from 변수만을 사용하여 처리예정-->
	<input type="hidden" name="rtnurl" value='<?php echo $rtnurl?>'>
	<!-- 파일명 : 일반적으로 뒤의 확장자 생략 -->
	<input type="hidden" name="goto" value='<?php echo $goto?>'>
	<!-- major 쿼리값 : 예, BID, -->
	<input type="hidden" name="goto1" value='<?php echo $goto1?>'>
	<!-- major 쿼리값 : 예, GID, -->
	<input type="hidden" name="hiddenvalue1" value='<?php echo $hiddenvalue1?>'>
	<!-- 기타쿼리값 : 예, mode, query, -->
	<input type="hidden" name="hiddenvalue2" value='<?php echo $hiddenvalue2?>'>
	<!-- 기타쿼리값 : 예, mode, query, -->
	<input type="hidden" name="log_from" value='<?php echo $_SERVER["HTTP_REFERER"];?>'>
	<input type="hidden" name="op" value='<?php echo $op;?>'>

    <div class="form-group">
      <label for="wizmemberID" class="col-lg-2 control-label">아이디</label>
      <div class="col-lg-10">
      	<input type="text" class="form-control required" name="wizmemberID" id="wizmemberID" placeholder="아이디를 입력해주세요" msg="아이디를 입력하세요"  autocomplete="off">
      </div>
    </div>
    
    <div class="form-group">
      <label for="wizmemberPWD" class="col-lg-2 control-label">패스워드</label>
      <div class="col-lg-10">
      	<input type="password" name="wizmemberPWD" id="wizmemberPWD" class="form-control required" placeholder="패스워드를 입력해주세요" msg="패스워드를 입력해주세요">
      </div>
    </div>
    
    <div class="form-group">
    	<div class="col-lg-offset-2 col-lg-10">
		    <div class="checkbox">
		      <label>
		        <input name="saveflag" type="checkbox" id="saveflag" value="1"<?php if($_COOKIE["saveflag"] == "1") echo " checked"; ?> />아이디저장
		      </label>
		    </div>
		</div>
	</div>
    <div class="form-group">
	    <div class="col-lg-offset-2 col-lg-10">
	      <button type="submit" class="btn btn-default">로그인</button>
	    </div>
	</div>
	
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
	    	<a href="./wizmember.php?query=idpasssearch" class="btn btn-primary btn-xs">아이디/패스워드 찾기</a> <a href="./wizmember.php?query=regis_step1" class="btn btn-primary btn-xs">회원가입</a>
		</div>
	</div>
</form>
<!-- 로그인(성인 증제외)끝 -->
<?php else:?>
<!-- 비회원 성인인증  -->
<!-- 비회원 성인인증 끝  -->
<?php endif;?>
<?php  
if ($query == 'order'): // 비회원 주문배송조회
?>
<div class="panel">
	로그인
	<div class="panel-footer">
		비회원으로 주문하신 고객께서는 주문번호를 입력하시면 주문/배송조회를 하실 수 있습니다
	</div>
</div>

<form action='./wizmember.php' id="noneMemberForm" role="form" class="form-horizontal" method="post">
	<input type="hidden" name="query" value='non_member_order'>
	<div class="form-group">
      <label for="OrderID" class="col-lg-2 control-label">주문번호</label>
      <div class="col-lg-10">
      	<input type="text" name="OrderID" id="OrderID" class="form-control required" placeholder="주문번호를 입력해주세요" msg="주문번호를 입력해주세요">
      </div>
    </div>
    <div class="form-group">
      <label for="SName" class="col-lg-2 control-label">주문자명</label>
      <div class="col-lg-10">
        <input type="text" name="SName" id="SName" class="form-control required" placeholder="주문자명을 입력해주세요" msg="주문자명을 입력해주세요">
      </div>
    </div>
    <div class="form-group">
	    <div class="col-lg-offset-2 col-lg-10">
	      <button type="submit" class="btn btn-default">주문내역확인</button>
	    </div>
	</div>
</form>
<?php endif;?>
