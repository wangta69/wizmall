<?
include "../../lib/cfg.common.php";
if(!strcmp($mode,"saveThis")){
$STRING = "
<?
\$WizMailSkin = \"$wizskin\";
?>";

$fp = fopen("../../config/mailcfg.php", "w");
fwrite($fp, "$STRING"); 
fclose($fp);

}

include "../../config/mailcfg.php";
$title = "위즈폼메일 스킨선택";
$path = "../../";
include "../../skinwiz/common/header_html.php";
?>
<script language="javascript" type="text/javascript">
<!--
$(function(){
	$(".btn_close").click(function(){
		self.close();
	});
	
	$(".btn_save").click(function(){
		$("#s_form").submit();
	});
});
//-->
</script>
<style type="text/css">
<!--
.mailskin li{padding:20px; text-align:center}
.mailskin{ content:""; clear:both; display:block;}
-->
</style>

<div class="title b orange">WizFormMailer ver.1.01 For WizProducts</div>
<p>스킨선택하기</p>
<form name="s_form" id="s_form" action="<?=$PHP_SELF?>">
    <input type="hidden" name="mode" value="saveThis">
	<ul class="mailskin">
            <?
$skskin_dir = opendir("./skin");
$NO = 1;
        while($skskdir = readdir($skskin_dir)) :
		
                if(($skskdir != ".") && ($skskdir != "..")) {
//				echo "\$skskdir=$skskdir <br>";
?><li class="fleft"><img src="./skin/<?=$skskdir?>/index.gif" width="250" height="250">
<br>
<input type="radio" name="wizskin" value="<?=$skskdir?>" <?if(!strcmp($WizMailSkin,$skskdir)) echo"checked";?>> 
</li>
            <?			
                } // if(($skskdir != ".") && ($skskdir != ".."))
        endwhile;
closedir($skskin_dir);
?>	
</ul>
<div class="space30"></div>
<div class="btn_box"><span class="btn_save button bull"><a>적용하기</a></span> <span class="btn_close button bull"><a>창닫기</a></span></div> 
		</form>	
</body>
</html>
