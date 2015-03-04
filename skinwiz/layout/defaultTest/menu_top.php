<div id="head">
<div id="logo">
<?
$banner = $common->getbanner(1);
echo $banner[0];
?>
</div>
<div id="top_menu">
<div id="topmenutext">
<a href="/">홈</a>
<a href="wizbag.php">장바구니</a>
<a href="wizmember.php?query=order">주문내역보기</a>
<a href="wizmember.php?query=order">배송정보</a>
<a href="wizmember.php?query=mypage">마이페이지</a>
<a href="wizmart.php?query=co_list">공동구매</a>
<a href="wizboard.php?BID=board01&GID=root">고객게시판</a>
</div>

<div id="topmenusearch">
<script language="JavaScript">
<!--
function SearchCheckForm(f){
	if(f.keyword.value == ''){
		alert('검색어를 입력해주세요');
		f.keyword.focus();
		return false;
	}
}
//-->
</script>
<form action="wizsearch.php" name="SearchCheck" onsubmit='return SearchCheckForm(this);'>
<input type="hidden" name="query" value="search">
<input type="hidden" name="Target" value="all">
<img src="./skinwiz/layout/<? echo $cfg["skin"]["LayoutSkin"];?>/images/search_icon.gif" width="61">
<input type="text" name="keyword" class="input">
<input type="image" src="./skinwiz/layout/<? echo $cfg["skin"]["LayoutSkin"];?>/images/search_btn1.gif" width="35" hspace="2">
<a href="wizsearch.php"><img src="./skinwiz/layout/<? echo $cfg["skin"]["LayoutSkin"];?>/images/search_btn.gif" width="55" hspace="2"></a>
</form>
</div>
</div>
</div><!--#head close -->