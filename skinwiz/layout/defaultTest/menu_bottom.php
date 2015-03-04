<div id="foot">
	<div id="foot_menu"> <a href="wizhtml.php?html=company">회사소개</a> | <a href="wizhtml.php?html=privacy">개인정보보호정책</a> | <a href="wizhtml.php?html=agreement">이용약관</a> | <a href="wizhtml.php?html=customercenter">고객센터</a>
<a href="#topAnchor"><img src="./skinwiz/layout/<? echo $cfg["skin"]["LayoutSkin"];?>/images/icon_top.gif" width="44" height="17"></a> 
	</div>
	<div id="foot_main">
		<div id="foot_logo">
			<?
$banner = $common->getbanner(2);
echo $banner[0];
?>
		</div>
		<div id="foot_desc">상호 : <?=$cfg["admin"]["ADMIN_TITLE"]?> | 대표 : <?=$cfg["admin"]["PRESIDENT"]?> | 사업자등록번호 : <?=$cfg["admin"]["COMPANY_NUM"]?> | 통신판매업신고 : <?=$cfg["admin"]["COMPLICENCE_NUM"]?><br />
			주소 : <?=$cfg["admin"]["COMPANY_ADD"]?><br />
			대표전화 : <?=$cfg["admin"]["CUSTOMER_TEL"]?> | 팩스 : <?=$cfg["admin"]["CUSTOMER_FAX"]?> | E-mail : <?=$cfg["admin"]["ADMIN_EMAIL"]?><br />
			<a href="http://www.shop-wiz.com" target="_blank">Copyright ⓒ 2005 shop-wiz.com All Rights Reserved. Powered by 
			Shop-Wiz.Com</a> </div>
	</div>
</div>
<!--#foot close -->
