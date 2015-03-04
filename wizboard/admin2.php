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

if(!strcmp($MODE,"ViewPageChange")){
	include ("./configwrite.php");
} 

include "../config/wizboard/table/$GID/$BID/config.php";
include "./admin_pop_top.php";
?>

<div id="table_pop_layout">
	<div class="pop_menu"> <a href="./admin1.php?BID=<?=$BID?>&GID=<?=$GID?>">LayOut</a> <a class="on">ListPage</a> <a href="./admin3.php?BID=<?=$BID?>&GID=<?=$GID?>">ViewPage</a> <a href="./admin4.php?BID=<?=$BID?>&GID=<?=$GID?>">WritePage</a> <a href="./admin5.php?BID=<?=$BID?>&GID=<?=$GID?>">Option</a> </div>
	<form action="<?=$PHP_SELF?>" method="POST" name="BasicInfo">
		<input type="hidden" name="MODE" value="ViewPageChange">
		<input type="hidden" name="BID" value="<?=$BID?>">
		<input type="hidden" name="GID" value="<?=$GID?>">
		<table class="table_main list">
			<col width="130" />
			<col width="*" />
			<col width="130" />
			<col width="*" />
			<tbody>
				<?  foreach($cfg["wizboard"] as $key=>$value)  echo "<input type='hidden' name='".$key."' value='".$value."'>\n"; ?>
				<tr>
					<th>제목글자 자르기
						</td>
					<td><input type="text" name="SubjectLength" value="<?=$cfg["wizboard"]["SubjectLength"]?>" class="w30">
						자</td>
					<th>글쓴이 이름 자르기</th>
					<td><input type="text" name="NameLength" value="<?=$cfg["wizboard"]["NameLength"]?>" class="w30">
						자</td>
				</tr>
				<tr>
					<th>리스트수</th>
					<td><input type="text" name="ListNo" value="<?=$cfg["wizboard"]["ListNo"]?>" class="w30">
						개 </td>
					<th>페이지표시수</th>
					<td><input type="text" name="PageNo" value="<?=$cfg["wizboard"]["PageNo"]?>" class="w30">
					</td>
				</tr>
				<tr>
					<th>정렬방식</th>
					<td><?
$selArr = array("UID@desc"=>"등록날자순","SDATE@desc"=>"변경날짜순", "COUNT@desc"=>"히트(조회)순","DOWNCOUNT@desc"=>"다운로드순","RECCOUNT@desc"=>"추천순","NAME@asc"=>"작성자순","SUBJECT@asc"=>"제목순");
$common->mkselectmenu("AdminAlign", $selArr, $cfg["wizboard"]["AdminAlign"]);
?>
					</td>
					<th>&quot;new&quot;아이콘 표시일</th>
					<td><input type="text" name="NewTime" value="<?=$cfg["wizboard"]["NewTime"]?>" class="w30">
						일 </td>
				</tr>
			</tbody>
		</table>
		<div class="btn_box">
			<input type="button" name="Button" value="수정" onClick="javascript:submit()"; style="cursor:pointer;">
			<input type="button" name="Submit" value="닫기" onClick="javascript:window.close()"; style="cursor:pointer;">
		</div>
	</form>
</div>
<?
include "./admin_pop_bottom.php";
?>
