					</div><!-- col-lg-9 -->
				</div><!-- row -->
			</div><!-- container bs-docs-container-->			
			<div class="row" style="padding:5px;margin:5px;background-color: gray; color:white">
				<div class="col-lg-12 text-center"> 
					<a href="wizhtml.php?html=company" class="white">회사소개</a> | 
					<a href="wizhtml.php?html=privacy" class="white">개인정보보호정책</a> | 
					<a href="wizhtml.php?html=agreement" class="white">이용약관</a> | 
					<a href="wizhtml.php?html=customercenter" class="white">고객센터</a>
			<a href="#topAnchor"><img src="./skinwiz/layout/<? echo $cfg["skin"]["LayoutSkin"];?>/images/icon_top.gif" width="44" height="17"></a> 
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3"> 
					<?php $banner = $common->getbanner(2);echo $banner[0];?>
				</div>
				<div class="col-lg-9"> 
					상호 : <?php echo $cfg["admin"]["ADMIN_TITLE"]?> | 대표 : <?php echo $cfg["admin"]["PRESIDENT"]?> | 사업자등록번호 : <?php echo $cfg["admin"]["COMPANY_NUM"]?> | 통신판매업신고 : <?php echo $cfg["admin"]["COMPLICENCE_NUM"]?><br />
						주소 : <?php echo $cfg["admin"]["COMPANY_ADD"]?>
						대표전화 : <?php echo $cfg["admin"]["CUSTOMER_TEL"]?> | 팩스 : <?php echo $cfg["admin"]["CUSTOMER_FAX"]?> | E-mail : <?php echo $cfg["admin"]["ADMIN_EMAIL"]?><br />
						<a href="http://www.shop-wiz.com" target="_blank">Copyright ⓒ 2005 shop-wiz.com All Rights Reserved. Powered by 
						Shop-Wiz.Com</a> 
				</div> <!-- col-lg-12 text-center -->
			</div><!-- row -->
<!--#foot close -->
		</div><!--container  전체 레이아웃 감쌈 -->
	</body>
</html>
