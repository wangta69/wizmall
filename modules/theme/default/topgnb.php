<?php
$file = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $file);
$pfile = $break[count($break) - 1];
switch($pfile){
	case "wizmember.php":
		switch($query){
			case "order":$selgnb="order";break;
			case "mypage":$selgnb="mypage";break;
		}
	break;
	case "wizmart.php":
		switch($query){
			case "co_list":$selgnb="co_list";break;
		}
	break;
	case "wizboard.php":
		switch($BID){
			case "board01":$selgnb="board01";break;
		}
	break;
	case "index.php":$selgnb="main";break;
	case "wizbag.php":$selgnb="bag";break;
}

?>
	<div class="navbar navbar-inverse"><!--  navbar-fixed-top -->
		<div class="container">
			<div class="navbar-header" style="padding:10px;">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!--<a class="navbar-brand" href='./lib/out.banner.php?uid=1' target='_self'><img src='./config/banner/dG9wbG9nby5naWY='   border='0' alt='베너이미지' class="img-thumbnail"></a> -->	
				<?php $banner = $common->getbanner(1);echo $banner[0];?>
			</div>
			<div class="navbar-collapse collapse" style="height: 1px;">
				<ul class="nav navbar-nav" style="padding-left: 10px; padding-top:15px">
					<!--
					<li<?php if($selgnb == "main") echo " class='active'"; ?>>
						<a href="/">홈</a>
					</li>
					-->
					<li<?php if($selgnb == "bag") echo " class='active'"; ?>>
						<a href="wizbag.php">장바구니</a>
					</li>
					<!--  <li<?php if($selgnb == "member") echo " class='active'"; ?>>
						<a href="wizmember.php?query=order">주문내역보기</a>
					</li>
				-->
					<li<?php if($selgnb == "order") echo " class='active'"; ?>>
						<a href="wizmember.php?query=order">배송정보</a>
					</li>
					<li<?php if($selgnb == "mypage") echo " class='active'"; ?>>
						<a href="wizmember.php?query=mypage">마이페이지</a>
					</li>
					<!--
					<li<?php if($selgnb == "co_list") echo " class='active'"; ?>>
						<a href="wizmart.php?query=co_list">공동구매</a>
					</li>
				-->
					<li<?php if($selgnb == "board01") echo " class='active'"; ?>>
						<a href="wizboard.php?BID=board01&GID=root">고객게시판</a>
					</li>
				</ul>
				<form action="wizsearch.php" name="SearchCheck" onsubmit='return SearchCheckForm(this);' class="navbar-form navbar-right" style="padding-top:15px">
					<input type="hidden" name="query" value="search">
					<input type="hidden" name="Target" value="all">
					<div class="form-group">
						<label for="inputKeyword">상세검색</label>
					</div>
					<div class="form-group">
						<input type="text" name="keyword" id="inputKeyword" class="form-control">
					</div>
					<div class="form-group">
							<button type="submit" class="btn btn-default btn-xs">검색</button>
							<a href="wizsearch.php" class="btn btn-default btn-xs">상세검색</a>
					</div>
				</form>
			</div><!--/.navbar-collapse -->
		</div><!--<div class="container"> -->
	</div><!--<div class="navbar"> -->
		
	<div class="row" style="padding:0px; position: relative;"><!-- top menu start row -->
	
		<div id="inside_box" style="position: absolute; right:-70px;top:30px;"><!-- 우측 스크롤 메뉴 시작 -->
				
<?php
	$sqlstr = "select c.pid, m.Picture, m.Category from wizCart c 
	left join wizMall m on c.pid = m.UID 
	where c.oid = '".$_COOKIE["CART_CODE"]."'";
	$dbcon->_query($sqlstr);
	while($list = $dbcon->_fetch_array()):
	$Picture = explode("|", $list["Picture"]);
	$cookie_cat = $list["Category"];
	$cookie_big_code = substr($cookie_cat, -3);
	$cookie_uid = $list["pid"];
?>					  
			<div>
				<a href="wizmart.php?query=view&code=<?=$cookie_cat?>&no=<?=$cookie_uid?>"><img src="./config/uploadfolder/productimg/<?=$cookie_big_code?>/<?=$Picture[0]?>"  width="50">1</a>
			</div>

<?php
	endwhile;
?>					  


			<!-- 현재 본 상품 -->			
			<div id="scrollupdown" style="overflow:hidden">
<?php
	$view_file = "./config/wizmember_tmp/view_product/".session_id().".php";
	if (is_file($view_file)) include $view_file;
	
	if(is_array($TODAY_PRODUCT)){
	
		$cnt=0;
		krsort($TODAY_PRODUCT[uid]);
		foreach($TODAY_PRODUCT[uid] as $key => $value){
			$cookie_uid = $value;
			$cookie_img = $TODAY_PRODUCT["img"][$key];
			$cookie_cat = $TODAY_PRODUCT["category"][$key];
			$cookie_imgcat = $TODAY_PRODUCT["imgcategory"][$key];
			//echo "cookie_cat=".$cookie_cat;
			$cookie_big_code = substr($cookie_imgcat, -3);
			if($cookie_uid){
//if($cnt) echo "<tr><td></td></tr>";
?>
				<div>
					<a href="wizmart.php?query=view&code=<?=$cookie_cat?>&no=<?=$cookie_uid?>"><img src="./config/uploadfolder/productimg/<?=$cookie_big_code?>/<?=$cookie_img?>"  width="50"></a>
				</div>
<?php

				$cnt++;
			}
//echo "cnt = $cnt <br />";
//if($cnt == 3) break;
		}
	}//if(is_array($TODAYPRODUCT)){
?>
			</div>				  
			<div>
				<a href="javascript:scrollupdown(65)" onfocus=blur()>▼</a>
			</div>

			<img src="./skinwiz/layout/<? echo $cfg["skin"]["LayoutSkin"];?>/images/right_quick.gif" height="254" usemap="#quickMap"> 
			<map name="quickMap" id="quickMap">
				<area shape="rect" coords="5,21,66,77" href="wizboard.php?BID=board04&GID=root">
				<area shape="rect" coords="5,79,66,135" href="wizboard.php?BID=board01&GID=root">
				<area shape="rect" coords="5,137,66,189" href="wizboard.php?BID=board03&GID=root">
				<area shape="rect" coords="5,195,65,250" href="wizhtml.php?html=guide">
			</map> 
		</div><!-- 우측 스크롤 메뉴 끝 id="inside_box" --> 
	</div><!-- top menu start end -->
  
<script>
	//우측 스크롤 메뉴 관련 스크립트 시작
	$(document).ready(function() {	 //따라다니는 배너
		var currentPosition = parseInt($('#inside_box').css('top')); 
		$(window).scroll(function() { 
			var position = $(window).scrollTop(); // 현재 스크롤바의 위치값을 반환
			//console.log(position);
			$('#inside_box').stop().animate({'top':position+currentPosition+'px'},500); //여기서 1000은 속도. 값이 작을수록 빨리.
		}); 
	});
	
	
	function scrollupdown(gap)
	{
		var scrollupdown = document.getElementById('scrollupdown');
		scrollupdown.scrollTop += gap;
	}
	//우측 스크롤 메뉴 관련 스크립트 끝
			
	// 검색 관련 자바스크립트			
	function SearchCheckForm(f){
		if(f.keyword.value == ''){
			alert('검색어를 입력해주세요');
			f.keyword.focus();
			return false;
		}
	}
</script>
