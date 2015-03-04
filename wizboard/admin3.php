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
<div class="pop_menu"> <a href="./admin1.php?BID=<?=$BID?>&GID=<?=$GID?>">LayOut</a>
<a href="./admin2.php?BID=<?=$BID?>&GID=<?=$GID?>">ListPage</a>
<a class="on">ViewPage</a>
<a href="./admin4.php?BID=<?=$BID?>&GID=<?=$GID?>">WritePage</a>
<a href="./admin5.php?BID=<?=$BID?>&GID=<?=$GID?>">Option</a> </div>
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
			<th>제목 글자 자르기</th>
			<td><input type="text" name="VSubjectLength" value="<?=$cfg["wizboard"]["VSubjectLength"]?>" class="w30">
				자</td>
			<th> 이름 글자 자르기</th>
			<td><input type="text" name="VNameLength" value="<?=$cfg["wizboard"]["VNameLength"]?>" class="w30">
				자</td>
		</tr>
		<tr>
			<th>리플라이</th>
			<td colspan="3"><input type="radio" name="ReplyBtn" value="yes" <? if($cfg["wizboard"]["ReplyBtn"]=="yes") ECHO"checked";?>>
				yes
				<input type="radio" name="ReplyBtn" value="no" <?if($cfg["wizboard"]["ReplyBtn"]=="no") ECHO"checked";?>>
				no (yes선택시 리플라이가능)</td>
		</tr>
		<tr>
			<th>자동링크</th>
			<td colspan="3"><input type="radio" name="AutoLink" value="yes" <?if($cfg["wizboard"]["AutoLink"]=="yes") ECHO"checked";?>>
				yes
				<input type="radio" name="AutoLink" value="no" <?if($cfg["wizboard"]["AutoLink"]=="no") ECHO"checked";?>>
				no (yes선택시 자동링크 가능)</td>
		</tr>
		<tr>
			<th>코멘트</th>
			<td colspan="3"><input type="radio" name="CommentEnable" value="yes" <?if($cfg["wizboard"]["CommentEnable"]=="yes") ECHO"checked";?>>
				yes
				<input type="radio" name="CommentEnable" value="no" <?if($cfg["wizboard"]["CommentEnable"]=="no") ECHO"checked";?>>
				no (yes선택시 코멘트(하단글달기)가능)</td>
		</tr>
		<tr>
			<th>리스트페이지삽입</th>
			<td colspan="3"><input type="radio" name="ListEnable" value="yes" <?if($cfg["wizboard"]["ListEnable"]=="yes") ECHO"checked";?>>
				yes
				<input type="radio" name="ListEnable" value="no" <?if($cfg["wizboard"]["ListEnable"]=="no") ECHO"checked";?>>
				no (yes선택시 view페이지에 리스트페이지삽입)</td>
		</tr>
	</tbody>
</table>
<div class="btn_box">
	<input type="button" name="Button" value="수정" onClick="javascript:submit()"; style="cursor:pointer;">
	<input type="button" name="Submit" value="닫기" onClick="javascript:window.close()"; style="cursor:pointer;">
</div>
<?
include "./admin_pop_bottom.php";
?>
