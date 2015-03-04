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

$filepath = "../config/wizboard/table/".$GID."/".$BID."/";
$LayOutTypeGID = $LayOutTypeGID ? $LayOutTypeGID : $GID;

function readdirsort($dirpath, $samevalue){ /* $dirpath에 있는 파일들을 읽어 오는 함수*/
	$open_dir = opendir("./".$dirpath);
		$i=0;
		while($opendir = readdir($open_dir)){
		$FileArr[$i] = $opendir;
		$i++;
		}
		asort ($FileArr);
		reset ($FileArr);
		while (list ($key, $val) = each ($FileArr)) {
			if(($val != ".") && ($val != "..")){
				if($samevalue == $val){
				echo "<option value=\"".$val."\" selected>".$val."스킨</option>\n";
				}
				else{
				echo "<option value=\"".$val."\">".$val."스킨</option>\n";
				}			
			}
		}
	closedir($open_dir);
}

function getHtml($path){
//echo $path;
	if(is_file($path)){
		$fp = file($path);
		for($i=0; $i<sizeof($fp); $i++){
			$String=stripslashes($fp[$i]);
			$String=str_replace("&nbsp;","&amp;nbsp;",$String);
			echo $String;
		}
	}
}
/******************** 가져오기 실행 **********************************/
if(!strcmp($mode,"OverWrite") && strcmp($CONFIRM,"OK")){
    echo "<script>
    con =  confirm(\"가져오시기를 할경우 현재 테이블의 모든 속성이 변경됩니다. \\n 가져오시겠습니까?\");
        if (con==true){
        location.href='$PHP_SELF?mode=".$mode."&BID=".$BID."&GID=".$GID."&LayOutType=".$LayOutType."&LayOutTypeGID=".$LayOutTypeGID."&CONFIRM=OK';
        }else{location.href='$PHP_SELF?BID=".$BID."&GID=".$GID."';}
    </script>";
}elseif(!strcmp($mode,"OverWrite") && !strcmp($CONFIRM,"OK")){
	copy("../config/wizboard/table/".$LayOutTypeGID."/".$LayOutType."/top.php","../config/wizboard/table/".$GID."/".$BID."/top.php"); 
	copy("../config/wizboard/table/".$LayOutTypeGID."/".$LayOutType."/bottom.php","../config/wizboard/table/".$GID."/".$BID."/bottom.php"); 
	copy("../config/wizboard/table/".$LayOutTypeGID."/".$LayOutType."/config.php","../config/wizboard/table/".$GID."/".$BID."/config.php"); 
}
  
if(!strcmp($mode, "writeit")):
	include ("./configwrite.php");

	/**** 두번째 ***************/
	//$STRING=addslashes($TableTop);
	$STRING = $TableTop;
	$fp = fopen("../config/wizboard/table/".$GID."/".$BID."/top.php", "w"); 
	$STRING=stripslashes($STRING);
	fwrite($fp, $STRING); 
	fclose($fp);

	/**** 두번째 ***************/
	//$STRING=addslashes($TableTop);
	$STRING = $TableinnerTop1;
	$fp = fopen("../config/wizboard/table/".$GID."/".$BID."/innertop1.php", "w"); 
	$STRING=stripslashes($STRING);
	fwrite($fp, $STRING); 
	fclose($fp);
	
	/**** 두번째 ***************/
	//$STRING=addslashes($TableTop);
	$STRING = $TableinnerTop2;
	$fp = fopen("../config/wizboard/table/".$GID."/".$BID."/innertop2.php", "w"); 
	$STRING=stripslashes($STRING);
	fwrite($fp, $STRING); 
	fclose($fp);
	
	/**** 두번째 ***************/
	//$STRING=addslashes($TableTop);
	$STRING = $TableinnerBottom;
	$fp = fopen("../config/wizboard/table/".$GID."/".$BID."/innerbottom1.php", "w"); 
	$STRING=stripslashes($STRING);
	fwrite($fp, $STRING); 
	fclose($fp);
			
	/**** 세번째 ***************/
	//$STRING=addslashes($TableBottom);
	$STRING = $TableBottom;
	$fp = fopen("../config/wizboard/table/".$GID."/".$BID."/bottom.php", "w"); 
	$STRING=stripslashes($STRING);
	fwrite($fp, $STRING); 
	fclose($fp);
	$common->js_location("$PHP_SELF?BID=".$BID."&GID=".$GID);
endif;

include "../config/wizboard/table/".$GID."/".$BID."/config.php";

include "./admin_pop_top.php";
?>
<script>
$(function(){
	$("#LayOutTypeGID").change(function(){
		$("#mode").val("");
		$("#sform").submit();
	});
});

</script>
<div id="table_pop_layout">
	<div class="pop_menu"> <a class="on">LayOut</a> <a href="./admin2.php?BID=<?php echo $BID?>&GID=<?php echo $GID?>">ListPage</a> <a href="./admin3.php?BID=<?php echo $BID?>&GID=<?php echo $GID?>">ViewPage</a> <a href="./admin4.php?BID=<?php echo $BID?>&GID=<?php echo $GID?>">WritePage</a> <a href="./admin5.php?BID=<?php echo $BID?>&GID=<?php echo $GID?>">Option</a> </div>
	<form action="<?php echo $PHP_SELF?>" method="POST" id="sform">
		<input type="hidden" name="mode" value="OverWrite" id="mode">
		<input type="hidden" name="BID" value="<?php echo $BID?>">
		<input type="hidden" name="GID" value="<?php echo $GID?>">
		<table class="table_pop_main">
			<tr>
				<td>LayOut 가져오기</td>
				<td>GID : 
<select name="LayOutTypeGID" id="LayOutTypeGID">
<?php
$open_dir = opendir("../config/wizboard/table");
$i=0;
while($opendir = readdir($open_dir)){
	$FileArr[$i] = $opendir;
	$i++;
}
asort ($FileArr);
reset ($FileArr);
while (list ($key, $val) = each ($FileArr)) {
if(($val != ".") && ($val != "..") && ($val != "config.php") && ($val != "prohibit_ip_list.php")){
	$selected = $val == $LayOutTypeGID ? " selected":"";
echo "<option value=\"".$val."\"".$selected.">".$val."</option>\n";

}
}
closedir($open_dir);
unset($FileArr);
?>
</select>
				BID : <select name="LayOutType">
<?php
$open_dir = opendir("../config/wizboard/table/".$LayOutTypeGID);
$i=0;
while($opendir = readdir($open_dir)){
$FileArr[$i] = $opendir;
$i++;
}
asort ($FileArr);
reset ($FileArr);
while (list ($key, $val) = each ($FileArr)) {
if(($val != ".") && ($val != "..")){
echo "<option value=\"".$val."\">".$val."</option>\n";

}
}
closedir($open_dir);
unset($FileArr);
?>
					</select>
					<input type="submit" name="Submit3" value="가져오기">
				</td>
			</tr>
		</table>
	</form>
	<form action="<?php echo $PHP_SELF?>" method="POST" name="BasicInfo">
		<input type="hidden" name="mode" value="writeit">
		<input type="hidden" name="BID" value="<?php echo $BID?>">
		<input type="hidden" name="GID" value="<?php echo $GID?>">
<?php
		$nodp = array("ExtendDBUse","editorenable","UpLoadingOverWriteEnable");

		  foreach($cfg["wizboard"] as $key=>$value)  
		  if (!in_array($key, $nodp)) 
		  echo "<input type='hidden' name='".$key."' value='".$value."'>\n"; 
		  ?>
		<table class="table_main list">
			<col width="130" />
			<col width="*" />
			<tbody>
				<tr>
					<th>동일 DB사용하기</th>
					<td><select name="SameDB">
							<option value="">선택하기</option>
<?php
$sqlstr = "select BID from wizTable_Main where BID is not null and BID <> '' order by BID asc";	
$dbcon->_query($sqlstr);			
while($slist = $dbcon->_fetch_array()):
$selected = $cfg["wizboard"]["SameDB"] == $slist["BID"] ? "selected":"";
echo "<option value='".$slist["BID"]."' ".$selected.">".$slist["BID"]." 보드</option>\n";
endwhile;	
?>
						</select>
						동일한 DB에서 데이타를 가져온다.</td>
				</tr>
				<tr>
					<th>확장 DB사용하기
						<input type="checkbox" name="ExtendDBUse" value="checked" <?php echo $cfg["wizboard"]["ExtendDBUse"]?>></th>
					<td><input name="ExtendDB" type="text" value="<?php echo $cfg["wizboard"]["ExtendDB"]?>">
						<br>
						확장 DB(현재 wizboard외의 DB를 wizBoard DB처럼 사용코져 할때).</td>
				</tr>
				<tr>
					<th>아이콘 스킨타입</th>
					<td><select name="ICON_SKIN_TYPE">
<?php
readdirsort("./icon",$cfg["wizboard"]["ICON_SKIN_TYPE"]);
?>
						</select>
					</td>
				</tr>
				<tr>
					<th>보드 스킨타입</th>
					<td><select name="BOARD_SKIN_TYPE">
<?php
readdirsort("./skin",$cfg["wizboard"]["BOARD_SKIN_TYPE"]);
?>
						</select>
					</td>
				</tr>
				<tr>
					<th>페이지표시 스킨타입</th>
					<td><select name="BOTTOM_SKIN_TYPE">
<?php
readdirsort("./skin_btnm",$cfg["wizboard"]["BOTTOM_SKIN_TYPE"]);
?>
						</select>
					</td>
				</tr>
				<tr>
					<th>코멘트 스킨타입</th>
					<td><select name="REPLE_SKIN_TYPE">
							<?php readdirsort("./skin_reple",$cfg["wizboard"]["REPLE_SKIN_TYPE"]); ?>
						</select>
					</td>
				</tr>
				<tr>
					<th>테이블폭(WIDTH)</th>
					<td><input type="text" name="TABLE_WIDTH" value="<?php echo $cfg["wizboard"]["TABLE_WIDTH"]?>" class="w30">
						<select name="TABLE_WIDTH_UNIT">
							<option value="%"<?php if($cfg["wizboard"]["TABLE_WIDTH_UNIT"] =="%") echo " selected";?>>%</option>
							<option value="px"<?php if($cfg["wizboard"]["TABLE_WIDTH_UNIT"] =="px") echo " selected";?>>pixels</option>
						</select>
						(테이블 폭은 px로 잡아 주는 것이  좋습니다.) </td>
				</tr>
				<tr>
					<th>테이블 정렬(ALIGN)</th>
					<td><select name="TABLE_ALIGN">
							<option value="default" <?php if(!strcmp($cfg["wizboard"]["TABLE_ALIGN"],"default")) ECHO"selected";?>>Default</option>
							<option value="left" <?php if(!strcmp($cfg["wizboard"]["TABLE_ALIGN"],"left")) ECHO"selected";?>>Left</option>
							<option value="right" <?php if(!strcmp($cfg["wizboard"]["TABLE_ALIGN"],"right")) ECHO"selected";?>>Right</option>
							<option value="center" <?php if(!strcmp($cfg["wizboard"]["TABLE_ALIGN"],"center")) ECHO"selected";?>>Center</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>파일첨부갯수</th>
					<td><select name="ATTACHEDCOUNT">
<?php
for($i=0; $i<=10; $i++){
	$selected = $cfg["wizboard"]["ATTACHEDCOUNT"] == $i?"selected":"";
	echo "<option value='".$i."' ".$selected." >".$i."개</option>\n";
}
?>
						</select>
						동일파일 덮어씌움
						<input name="UpLoadingOverWriteEnable" type="checkbox" id="UpLoadingOverWriteEnable" value="checked" <?php echo $cfg["wizboard"]["UpLoadingOverWriteEnable"]?>></td>
				</tr>
				<tr>
					<th>html편집기 사용</th>
					<td><input name="editorenable" type="checkbox" id="editorenable" value="1"<?php echo $cfg["wizboard"]["editorenable"] == "1"?" checked":""?>  /></td>
				</tr>
				<tr>
					<th>관리자전용</th>
					<td colspan="3"><input type="radio" name="AdminOnly" value="yes" <?php if($cfg["wizboard"]["AdminOnly"]=="yes") ECHO"checked";?>>
						yes
						<input type="radio" name="AdminOnly" value="no" <?php if($cfg["wizboard"]["AdminOnly"]=="no") ECHO"checked";?>>
						no (yes선택시 write버튼이 표시되지않음) </td>
				</tr>
				<tr>
					<th>1:1상담게시판</th>
					<td colspan="3"><input type="radio" name="qnaboard" value="1" <?php if($cfg["wizboard"]["qnaboard"]=="1") ECHO"checked";?>>
						yes
						<input type="radio" name="qnaboard" value="0" <?php if($cfg["wizboard"]["qnaboard"]=="0") ECHO"checked";?>>
						no(1대1상담용-타인의글은 리스트되지 않음)<br />
						view 메뉴에서 리플라이:no, 코멘트:yes<br />
						option메뉴에서 쓰기:회원전용 으로 각각 설정요망</td>
				</tr>
				<tr>
					<th>인클루드 몰 스킨</th>
					<td><input type="radio" name="INCLUDE_MALL_SKIN" value="yes" <?php if(!strcmp($cfg["wizboard"]["INCLUDE_MALL_SKIN"],"yes")) ECHO"checked";?>>
						yes &nbsp;&nbsp;
						<input type="radio" name="INCLUDE_MALL_SKIN" value="no" <?php if(!strcmp($cfg["wizboard"]["INCLUDE_MALL_SKIN"],"no")) ECHO"checked";?>>
						no (위즈몰과 연동시 yes를 책크해 주세요)</td>
				</tr>
				<tr>
					<th>보안관련</th>
					<td><input name="setsecurityiframe" type="checkbox" id="setsecurityiframe" value="checked" <?php echo $cfg["wizboard"]["setsecurityiframe"]?>>
						iframe 금지
						<input name="setsecurityscript" type="checkbox" id="setsecurityscript" value="checked" <?php echo $cfg["wizboard"]["setsecurityscript"]?>>
						스크립트 금지(관리자 전용이 아니면 반드시 체크하세요)</td>
				</tr>
			</tbody>
		</table>
		<div class="space10"></div>
		<div id="designcoding">
			<div id="designpart">
				<div id="title"> 테이블상단레이아웃
					<input type="checkbox" name="checkbox" id="checkbox" onClick="showhidden(TableTop)" />
					펼침 </div>
				<textarea name="TableTop" rows="15" id="TableTop" style="width:100%;word-break:break-all;display:none">
<?php
$path = $filepath."top.php";
getHtml($path);
?>
</textarea>
			</div>
			<div class="space10"></div>
			<div id="designpart">
				<div id="title">테이블하단레이아웃
					<input type="checkbox" name="checkbox" id="checkbox" onClick="showhidden(TableBottom)" />
					펼침 </div>
				<textarea name="TableBottom" rows="15" id="TableBottom" style="width:100%;word-break:break-all;display:none";>
<?php
$path = $filepath."bottom.php";
getHtml($path);
?>
</textarea>
			</div>
		</div>
		<div class="space10"></div>
		<div class="btn_box">
			<input type="submit" name="Button" value="수정" onClick="javascript:submit()"; style="cursor:pointer;">
			<input type="button" name="Submit" value="닫기" onClick="javascript:window.close()"; style="cursor:pointer;">
		</div>
	</form>
</div>
<?php
include "./admin_pop_bottom.php";
?>
