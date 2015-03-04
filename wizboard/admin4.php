<?php
/* 
제작자 : 폰돌
제작자 URL : http://www.shop-wiz.com
제작자 Email : master@shop-wiz.com
Free Distributer 

*** Updating List ***
*/

include "../lib/inc.depth1.php";
include("./admin_check.php");


if(!strcmp($MODE,"WritePageChange")){
	$Write_prohibition_Word = ereg_replace("\n", "", $Write_prohibition_Word);
	$Write_prohibition_Word = ereg_replace("\r", " ", $Write_prohibition_Word);
	$Write_prohibition_Word = ereg_replace("\"", "", $Write_prohibition_Word);
	$Write_prohibition_Word = ereg_replace("\'", "", $Write_prohibition_Word);
	include ("./configwrite.php");
} 
include "../config/wizboard/table/".$GID."/".$BID."/config.php";
include "./admin_pop_top.php";
?>

<div id="table_pop_layout">
	<div class="pop_menu"> 
	<a href="./admin1.php?BID=<?php echo $BID?>&GID=<?php echo $GID?>">LayOut</a>
	<a href="./admin2.php?BID=<?php echo $BID?>&GID=<?php echo $GID?>">ListPage</a>
	<a href="./admin3.php?BID=<?php echo $BID?>&GID=<?php echo $GID?>">ViewPage</a>
	<a class="on">WritePage</a>
	<a href="./admin5.php?BID=<?php echo $BID?>&GID=<?php echo $GID?>">Option</a> 
	</div>
	<form action="<?php echo $PHP_SELF?>" method="POST" name="BasicInfo">
		<input type="hidden" name="MODE" value="WritePageChange">
		<input type="hidden" name="BID" value="<?php echo $BID?>">
		<input type="hidden" name="GID" value="<?php echo $GID?>">
		<?php  foreach($cfg["wizboard"] as $key=>$value)  echo "<input type='hidden' name='".$key."' value='".$value."'>\n"; ?>
		금지단어설정(본문) - 예) 섹스,광고,야동(&quot;,&quot;로 분리) <br />
		<?php
		if(is_file("../config/wizboard/table/".$GID."/".$BID."/config7.php")){
			$DATA1 = file("../config/wizboard/table/".$GID."/".$BID."/config7.php");
			for($i=0; $i < sizeof($DATA1); $i++){
			$Contents .= $DATA1[$i];
			}
		}
		?>
		<textarea name="Write_prohibition_Word" rows="5" id="Write_prohibition_Word" style="width:99%";><?php echo $cfg["wizboard"]["Write_prohibition_Word"]?>
</textarea>
		<div class="btn_box">
			<input type="button" name="Button" value="수정" onClick="javascript:submit()"; style="cursor:pointer;">
			<input type="button" name="Submit" value="닫기" onClick="javascript:window.close()"; style="cursor:pointer;">
		</div>
	</form>
</div>
<?php
include "./admin_pop_bottom.php";
?>
