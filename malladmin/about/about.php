<?
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/

include "../common/header_pop.php";
$title = "About WIZMALL";
include "../common/header_html.php";
?>
<script language="javascript" type="text/javascript">
<!--
$(function(){
	$(".btn_close").click(function(){
		self.close();
	});
});
//-->
</script>
<style type="text/css">
<!--
body{background:#39780C; padding:5px;}
.about{color:#FFFFFF; font-weight:bold; font-size:12px}
.about li {padding:5px; border-bottom:solid #5A9D28 1px}
.top{padding:5px;margin-bottom:20px; background-color:#333333}
.bottom {padding:5px;margin-top:70px; background-color:#333333; font-size:10px; font-weight:normal;}
.top:after{ content:""; clear:both; display:block;}

a:link		{color:#FF6600; text-decoration:none;}
a:visited	{color:#FF6600; text-decoration:none;}
a:hover		{color:#FFFFFF; text-decoration:none;}
a:active		{color:#FFFFFF; text-decoration:none;}

-->
</style>

<div class="top about"><div class="fleft white">WIZMALL FOR PHP</div><div class="btn_close fright white"> [x닫기]</div></span></div>
<ul class="about">
<li>version : <?=$cfg["common"]["ver"]?></li>
<li>Powered by : 폰돌(Shop-wiz.com)</li>
<li>Vistit For more Info : <a href="http://www.shop-wiz.com" target="_blank">http://www.shop-wiz.com</a></li>
<li>제휴문의 : master@shop-wiz.com</li>
</ul>
<div class="bottom about">Copyright ⓒ 2005 숍위즈 . All rights reserved. Powered by <a href="http://www.shop-wiz.com" target="_blank">shop-wiz.com</a></div>

</body>
</html>
