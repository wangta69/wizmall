<script>
$(function(){
	$(".menu_click").click(function(i){
		$(".submenu").hide();
		$(".submenu").eq($(".menu_click").index(this)).show(); //메서드
	});	
	
	//로그인 처리
	$("#sub_login_form").submit(function(){
		if($("#sub_login_id").val() == ''){
			alert('ID를 입력해주세요');
			$("#sub_login_id").focus();
			return false;
		} else if($("#sub_login_pwd").val() == ''){
			alert('패스워드를 입력하세요');
			$("#sub_login_pwd").focus();
			return false;
		} else{//ajax 처리
			var userid		= $("#sub_login_id").val();
			var userpwd		= $("#sub_login_pwd").val();
			var saveflag	= $("#sub_login_pwd").val();
			if(saveflag == undefined) saveflag = "";
			
			$.post("../lib/ajax.member.php", {smode:"login_check",wizmemberID:userid,wizmemberPWD:userpwd,saveflag:saveflag}, function (data){
				eval("var obj = "+ data);
				if(obj["result"] != 0){
					alert(obj["msg"]);
				}else location.reload();
			});
			return false;
		}
	});
	

});
</script>


	<div class="well well-sm"><!--  로그인 정보  시작 -->
<?php
if ($cfg["member"]) : //로그인상태이면
//$cfg["member"]["mid"]
//$cfg["member"]["mpasswd"]
//$cfg["member"]["mname"]
//$cfg["member"]["mgrade"]
//$cfg["member"]["mgrantsta"]
//$cfg["member"]["mlogindate"]
//$cfg["member"]["mpoint"]
//$cfg["member"]["mpointlogindate"]
//$cfg["member"]["adult"]
//$cfg["member"]["gender"]
?>
		<p class="agn_l">
			<span class="orange"><?php echo $cfg["member"]["mname"]?></span>
			님이 로그인 중입니다. </p>
		<p class="agn_l">포인트 :
			<?php echo number_format($cfg["member"]["mpoint"])?>
			<br />
			최근방문일 :
			<?php if($cfg["member"]["mlogindate"]) echo date("Y.m.d", $cfg["member"]["mlogindate"]); else echo 0; ?>
		</p>
		<span class="button bull"><a href="wizmember.php?query=logout">로그아웃</a></span> <span class="button bull"><a href="wizmember.php?query=info">정보변경</a></span>
<?php
else : // 로그인안된상태이면
?>
		<form action='./wizmember/LOG_CHECK.php' method="post" id="sub_login_form" class="form-horizontal">
			<input type="hidden" name="action" value="login_check">
			<input type="hidden" name="log_from" value="<?php echo $_SERVER["REQUEST_URI"];?>">
			<div class="form-group">
				<label for="sub_login_id" class="col-lg-3 control-label">ID</label>
				<div class="col-lg-9">
					<input type="text" class="form-control" name="wizmemberID" id="sub_login_id" tabindex="1" autocomplete="off" placeholder="아이디">
				</div>
			</div>
			<div class="form-group">
				<label for="sub_login_pwd" class="col-lg-3 control-label">PWD</label>
				<div class="col-lg-9">
					<input type="password" class="form-control" name="wizmemberPWD" id="sub_login_pwd" tabindex="2"  autocomplete="off" placeholder="패스워드">
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-8 col-lg-offset-4">
					<button type="submit" class="btn btn-default">로그인</button>
				</div>
			</div>
	
			<p>
			<a href="wizmember.php?query=regis_step1" class="btn btn-primary btn-xs">회원가입</a>
			<a href="wizmember.php?query=idpasssearch" class="btn btn-primary btn-xs">id/pwd 찾기</a>
			</p>
		</form>
	
<?php endif; ?>
	</div><!-- well well-sm 로그인 정보  끝 -->
	
	
	
	<div class="well well-sm"><!--  카테고리 시작 -->
		<h4 class="text-center"><b>제품 카테고리</b></h4>
		<ul class="nav nav-pills nav-stacked">
<?php
$sqlstr = "select cat_no, cat_name, pcnt from wizCategory where LENGTH(cat_no) = 3 and cat_flag = 'wizmall' order by cat_order asc, cat_no asc";							
$result = $dbcon->_query($sqlstr);
while($list = $dbcon->_fetch_array($result)):
$bigcode = $list["cat_no"];
$big_code = substr($code, -3); /* wizmart에서 넘어온 코드값의 대분류 코드값을 구한다 */

/* 하위 카테고리 유무 책크 */
$sqlsubcountstr = "select count(1) from wizCategory where LENGTH(cat_no) = 6 and RIGHT(cat_no, 3) = '".$bigcode."' and cat_flag = 'wizmall'";
$sqlsubcount = $dbcon->get_one($sqlsubcountstr);

/* 카테고리별 등록 상품수를 구한다. */
if ($cfg["skin"]["GoodsNoShow"]  == 'checked')  $TotalGoodsNo = "(".$list["pcnt"].")";
	if (preg_match('/$bigcode/',$big_code)) {$show_hidden = "show";}else{$show_hidden = "none";}/* wizmart에서 넘어온 대분류 코드값과 현대 wizCategory의 대분류 코드값을 비교해 토글 display 유무를 결정한다.*/
	
	/* 하위 카테고리 유무 책크 및 토글을 입력한다 */
	//if($sqlsubcount >= 1) $ahref = "<a class='menu_click'>";
	//else $ahref = "<a href='./wizmart.php?code=$list[cat_no]'>";
	$toggle = $sqlsubcount >= 1 ? " data-toggle=\"dropdown\"":"";
	# 대분류 리스트
	$lnbActivate = $big_code == substr($list["cat_no"], 0, 3) ? " class='active'":"";
	echo "<li".$lnbActivate."><a ".$toggle." href=\"./wizmart.php?code=".$list["cat_no"]."\" >".$list["cat_name"]."</a>".$FMENU_NUM;
	/*
	echo "<ul class='dropdown-menu  rightMenu'>  
           <li><a href='#'>Twitter Bootstrap</a></li>  
           <li><a href='#'>Google Plus API</a></li>  
           <li><a href='#'>HTML5</a></li>  
           <li class='divider'></li>  
           <li><a href='#'>Examples</a></li>  
         </ul>";	
	*/

	if($sqlsubcount >= 1):
		echo "<ul class='dropdown-menu  rightMenu'>\n";//중분류 ul 시작
		//echo "<div class='submenu' style='display:$show_hidden;margin-left:15px'>";
		$sqlsubstr = "select cat_no, cat_name, pcnt from wizCategory where LENGTH(cat_no) = 6 and RIGHT(cat_no, 3) = '".$bigcode."' and cat_flag = 'wizmall' order by cat_order asc, cat_no asc";
		$sqlsubqry = $dbcon->_query($sqlsubstr);
		while($sublist = $dbcon->_fetch_array($sqlsubqry)):
		echo "<li>\n<a href='./wizmart.php?code=".$sublist["cat_no"]."'>".$sublist["cat_name"]."</a></li>\n";
		endwhile;
		//echo "</div>";
		echo "</ul>\n";//중분류 ul 끝
	endif;

	echo "</li>\n";
endwhile;
?>
		</ul><!-- nav nav-pills -->
		
		
	</div> <!-- well well-sm 카테고리 끝 -->
	<div class="well well-sm"><!-- 베너시작 -->
<?php
	$banner = $common->getbanner(5, 160);
	$cnt=0;
	foreach($banner as $key=>$value){
		echo "<p>".$banner[$cnt]."</p>\n";
		$cnt++;
	}
?>
</div><!-- well well-sm 베너 끝-->

