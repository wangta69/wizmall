<link rel="stylesheet" type="text/css" href="./js/jquery.plugins/tree/tree.css"/>
<script type="text/javascript" src="./js/jquery.plugins/tree/tree.js"></script>


<script language="javascript" type="text/javascript">
<!--
$(function(){
	$(".menu_click").click(function(){
		var code = $(this).parent().attr("code");
		$(".tree li").removeClass("active");
		//if(code == undefined){
			//code = $(this).parent().parent().attr("code");
			//$(this).parent().parent().addClass("active");
		//}else{
			$(this).parent().addClass("active");
		//}
		//$("#sub_reg_form").show();
		location.href= "/wizmart.php?code="+code;
		//alert(code);

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



//-->
</script>

<div id="sub">
	<div id="left_member_box">
	<?
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
		<span class="orange"><?=$cfg["member"]["mname"]?></span>
		님이 로그인 중입니다. </p>
	<p class="agn_l">포인트 :
		<?=number_format($cfg["member"]["mpoint"])?>
		<br />
		최근방문일 :
		<? if($cfg["member"]["mlogindate"]) echo date("Y.m.d", $cfg["member"]["mlogindate"]); else echo 0; ?>
	</p>
	<span class="button bull"><a href="wizmember/LOG_OUT.php">로그아웃</a></span> <span class="button bull"><a href="wizmember.php?query=info">정보변경</a></span>
	<?
else : // 로그인안된상태이면
?>
	<form action='./wizmember/LOG_CHECK.php' method="post" id="sub_login_form">
		<input type="hidden" name=action value=login_check>
		<input type="hidden" name=log_from value=<?=$_SERVER["REQUEST_URI"];?>>
		<dl class="left_login">
			<dt> <img src="./skinwiz/layout/<? echo $cfg["skin"]["LayoutSkin"];?>/images/id_txt.gif" width="32"></dt>
			<dd>
				<input name="wizmemberID" type="text" id="sub_login_id" tabindex="1" autocomplete="off" class="w100">
			</dd>
			<dt> <img src="./skinwiz/layout/<? echo $cfg["skin"]["LayoutSkin"];?>/images/pwd_txt.gif" width="32"></dt>
			<dd>
				<input name="wizmemberPWD" type="password" id="sub_login_pwd" tabindex="2"  autocomplete="off" class="w100">
			</dd>
		</dl>
		<input type="image" src="./skinwiz/layout/<? echo $cfg["skin"]["LayoutSkin"];?>/images/login_btn.gif">
		<div class="space10"></div>
		<span class="button bull"><a href="wizmember.php?query=regis_step1">회원가입</a></span> <span class="button bull"><a href="wizmember.php?query=idpasssearch">id/pwd 찾기</a></span>
		<div class="space20"></div>
	</form>
	<? endif; ?>
	</div>
	<div class="space20"></div>
	<img src="./skinwiz/layout/<? echo $cfg["skin"]["LayoutSkin"];?>/images/product_cat_btn.gif" width="160" height="33">


<div id="left_category_list">
	<div class="tree">
		<ul>
<?
$sqlstr = "select cat_no, cat_name, pcnt from wizCategory where LENGTH(cat_no) = 3 and cat_flag = 'wizmall' order by cat_order asc, cat_no asc";							
$result = $dbcon->_query($sqlstr);
while($list = $dbcon->_fetch_array($result)):
	$bigcode = $list["cat_no"];
	$big_code = substr($code, -3); /* wizmart에서 넘어온 코드값의 대분류 코드값을 구한다 */

	/* 하위 카테고리 유무 책크 */
	$sqlcount1str = "select count(1) from wizCategory where LENGTH(cat_no) = 6 and RIGHT(cat_no, 3) = '".$list["cat_no"]."' and cat_flag = 'wizmall'";
	$sqlsubcount = $dbcon->get_one($sqlcount1str);

	 $activateClas = $list["cat_no"] == $code ? " class=\"active\"":"";
?>
			<!-- step 1 start -->
			<li code="<?=$list["cat_no"]?>"<?=$activateClas?>>
				<span class="menu_click"><?=$list["cat_name"]?></span>
				<? if($sqlsubcount >= 1): ?>
				<!-- step 2 start -->
				<ul>
				<?
				$sqlsubstr = "select cat_no, cat_name, pcnt from wizCategory where LENGTH(cat_no) = 6 and RIGHT(cat_no, 3) = '$bigcode' and cat_flag = 'wizmall' order by cat_order asc, cat_no asc";
				$sqlsubqry = $dbcon->_query($sqlsubstr);
				while($sublist = $dbcon->_fetch_array($sqlsubqry)):

					/* 하위 카테고리 유무 책크 */
					$sql3countstr = "select count(1) from wizCategory where LENGTH(cat_no) = 9 and RIGHT(cat_no, 6) = '".$sublist["cat_no"]."' and cat_flag = 'wizmall'";
					$sql3count = $dbcon->get_one($sql3countstr);

					$activateClas = $sublist["cat_no"] == $code ? " class=\"active\"":"";
				?>
					<li code="<?=$sublist["cat_no"]?>"<?=$activateClas?>>
					<span class="menu_click"><?=$sublist["cat_name"]?></span>
					<? if($sql3count >= 1): ?>
					<!-- step 3 start -->
						<ul>
						<?
						$sql3str = "select cat_no, cat_name, pcnt from wizCategory where LENGTH(cat_no) = 9 and RIGHT(cat_no, 6) = '".$sublist["cat_no"]."' and cat_flag = 'wizmall' order by cat_order asc, cat_no asc";
						$sql3qry = $dbcon->_query($sql3str);
						while($sub3list = $dbcon->_fetch_array($sql3qry)):
						$activateClas = $sub3list["cat_no"] == $code ? " class=\"active\"":"";
						?>
							<li code="<?=$sub3list["cat_no"]?>"<?=$activateClas?>>
							<span class="menu_click"><?=$sub3list["cat_name"]?></span>
							</li>
						<?
							endwhile;
						?>
						</ul>
	


					<!-- step 3 end -->
					<? endif; ?>
					</li>
				<?
				endwhile;
				?>
				</ul>
				<!-- step 2 end -->
				<? endif;?>
			</li>
			<!-- step 1 end -->
<?
endwhile;//대분류
?>
		</ul>
	</div>



</div>
	<?
$banner = $common->getbanner(5, 160);
$cnt=0;
foreach($banner as $key=>$value){
	echo "<p>".$banner[$cnt]."</p>\n";
	$cnt++;
}
 ?>
</div>
<!--#sub close -->
