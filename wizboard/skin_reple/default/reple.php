<?php
/* 
제작자 : 폰돌
스킨 : wizboard list skin 
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
?>
<script>
	function DELETE_REPLE(UID,cp,BID,GID,BUID,adminmode){
		window.open("<?php echo $folder_reple?>/delete.php?UID="+UID+"&cp="+cp+"&BID="+BID+"&GID="+GID+"&BUID="+BUID+"&adminmode="+adminmode,"","scrollbars=no, toolbar=no, width=320, height=220, top=220, left=350")
	}
	
	function showrepleList(flag){
		$("#repleList1").hide();
		$("#repleList2").hide();

		switch(flag){
			case 1:$("#repleList1").show();break;
			case 2:$("#repleList2").show();break;
		}
	}
</script>

<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="cursor:pointer" onclick="showrepleList(1)">[댓글보기]</td>
		<td>&nbsp;</td>
		<td style="cursor:pointer" onclick="showrepleList(2)">[엮인글보기]</td>
	</tr>
</table>

<table class="table" id="repleList1">
	<colgroup>
		<col width="120"/>
		<col width="*"/>
		<col width="120"/>
	</colgroup>
<?php
$sqlstr = "SELECT * FROM wizTable_".$GID."_".$BID."_reply WHERE MID=".$UID." and FLAG = 1 ORDER BY UID asc";
$dbcon->_query($sqlstr);
while($RepleList = $dbcon->_fetch_array()):
	$RepleList["W_DATE"]= str_replace("-",".",$RepleList["W_DATE"]);
	$RepleList["CONTENTS"] = stripslashes($RepleList["CONTENTS"]);
	$RepleList["CONTENTS"] = str_replace(" ", "&nbsp;", $RepleList["CONTENTS"]);
	$RepleList["CONTENTS"] = str_replace("	", "&nbsp;&nbsp;&nbsp;&nbsp;", $RepleList["CONTENTS"]);
	$RepleList["CONTENTS"] = nl2br($RepleList["CONTENTS"]);
?>
	<tr> 
		<td> 
			<div align="center" style="word-break:break-all;"><?php echo $RepleList["NAME"]?></div>
		</td>
		<td style="word-break:break-all;"> 
			<?php echo $RepleList["CONTENTS"]?>
		</td>
		<td> 
			<div> 
				<?php echo date("Y.m.d",$RepleList["W_DATE"])?>
				<img src="<?php echo $folder_reple?>/images/delete_btn.gif" onClick="javascript:DELETE_REPLE('<?php echo $RepleList["UID"]?>','<?php echo $cp;?>','<?php echo $BID;?>','<?php echo $GID;?>','<?php echo $UID?>','<?php echo $adminmode?>');" style="cursor:pointer";> 
			</div>
		</td>
	</tr>
<?php endwhile;?>
</table>

<table class="table" style="display:none" id="repleList2">
	<tr> 
		<td valign="top">
			<? $tb_url = $cfg["admin"]["MART_BASEDIR"]."/wizboard/tb/tb.php/".$GID."/".$BID."/".$UID; ?>
			<a href="javascript:urlCopy('<?php echo $tb_url?>')">트랙백주소 : <?php echo $tb_url?></a>
		</td>
	</tr>    
	<?php   
	$sqlstr = "SELECT * FROM wizTable_".$GID."_".$BID."_reply WHERE MID=".$UID."  and FLAG = 2 ORDER BY UID asc";
	$dbcon->_query($sqlstr);
	while($RepleList = $dbcon->_fetch_array()):
		$RepleList["W_DATE"]= str_replace("-",".",$RepleList["W_DATE"]);
		$RepleList["CONTENTS"] = stripslashes($RepleList["CONTENTS"]);
		$RepleList["CONTENTS"] = str_replace(" ", "&nbsp;", $RepleList["CONTENTS"]);
		$RepleList["CONTENTS"] = str_replace("	", "&nbsp;&nbsp;&nbsp;&nbsp;", $RepleList["CONTENTS"]);
		$RepleList["CONTENTS"] = nl2br($RepleList["CONTENTS"]);
	?>
	<tr>
		<td><b><a href="<?php echo $RepleList["URL"]?>" target="_blank"><?php echo $RepleList["SUBJECT"]?></a></b></td>
		<td>
			<a href="<?php echo $RepleList["URL"]?>" target="_blank"><font color="#339999"><?php echo $RepleList["NAME"]?></font></a>
			<?php echo date("Y.m.d",$RepleList["W_DATE"])?>
			<img src="./wizboard/skin_reple/<?php echo $cfg["wizboard"]["REPLE_SKIN_TYPE"];?>/images/delete_btn.gif" onClick="javascript:DELETE_REPLE('<?php echo $RepleList[UID]?>','<?php echo $cp;?>','<?php echo $BID;?>','<?php echo $GID;?>','<?php echo $UID?>','<?php echo $adminmode?>');" style="cursor:pointer";> <!-- <? if($board->is_admin() || $RepleList[ID] == $cfg["member"]["mid"]){ ?> <a href="javascript:repleMod(<?php echo $RepleList["UID"]?>)">[수정]</a> <a href="javascript:DELETE_REPLE('<?php echo $RepleList[UID]?>','<?php echo $cp;?>','<?php echo $BID;?>','<?php echo $GID;?>','<?php echo $board->uid?>','<?php echo $adminmode?>');">[삭제]</a><? } ?>--> 
		</td>
		<td>
			<?php echo $RepleList["CONTENTS"]?>
		</td>
	</tr>
<? endwhile;?>
</table>




<form name="COMMENT" method="post" action="<?php echo $PHP_SELF?>" onsubmit="return comment_write_fnc(this)" class="form-inline" role="form">
	<input type="hidden" name="REPLE_MODE" value="WRITE">
	<input type="hidden" name="UID" value="<?php echo $UID?>">
	<input type="hidden" name="BID" value="<?php echo $BID?>">
	<input type="hidden" name="GID" value="<?php echo $GID?>">
	<input type="hidden" name="mode" value="<?php echo $mode?>">
	<input type="hidden" name="adminmode" value="<?php echo $adminmode?>">
	<input type="hidden" name="cp" value="<?php echo $cp?>">
	<input type="hidden" name="BOARD_NO" value="<?php echo $BOARD_NO?>">
	<input type="hidden" name="ID" value="<?php echo $cfg["member"]["mid"]?>">
	<input type="hidden" name="RUID" value=""> 
	<input type="hidden" name="ismember" value="false"><!-- 자바스크립트 제어를 위해 회원전용:true, 일반 : false 로서 플래그 값변경-->
	<input type="hidden" name="spamfree" value=""> 
	<div class="row">
		<div class="col-lg-2"> 
			<input type="text" name="NAME" value="<?php echo $cfg["member"]["mname"]?>" class="form-control" placeholder="이름" checkenable msg="이름을 입력하세요">
		</div>
		<div class="col-lg-6"> 
			<textarea name="CONTENTS"  wrap="VIRTUAL"  class="form-control" placeholder="내용" checkenable msg="내용을 입력하세요" editable=0 ></textarea> 
		</div> <!-- col-lg-12 text-center -->
		<div class="col-lg-2"> 
			<input type="password" name="PASSWD" class="form-control" placeholder="비밀번호" value="" checkenable msg="비밀번호를 입력하세요">
		</div> 
		<div class="col-lg-2"> 
			<button type="submit" class="btn btn-default">저장</button>
		</div> 
	</div><!-- row -->
</form>


