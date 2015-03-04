<SCRIPT LANGUAGE=javascript>
function num_plus(num){
	gnum = parseInt(num.BUYNUM.value);
	num.BUYNUM.value = gnum + 1;
	return;
}
function num_minus(num){

	gnum = parseInt(num.BUYNUM.value);
	if( gnum > 1 ){
		num.BUYNUM.value = gnum - 1;
	}	
	return;
}
function is_number(){
 	if ((event.keyCode<48)||(event.keyCode>57)){
  		alert("\n\n수량은 숫자만 입력하셔야 합니다.\n\n");
  		event.returnValue=false;
 	}
}
</script>
<div>
<table>
<tr>
<td background='./mall_skin/shop/<?ECHO"$SKIN";?>/image/cmp_ttbg.gif'><img src='./mall_skin/shop/<?ECHO"$SKIN";?>/image/cmp_tt.gif'></td>
<td background='./mall_skin/shop/<?ECHO"$SKIN";?>/image/cmp_ttbg.gif'>
<FONT COLOR='#081E8A'>다음은 고객님께서 선택하신 제품리스트입니다.
</td>
</tr>
</table>
<?

while (list($key,$no) = each($HTTP_GET_VARS)) :
	if(ereg("multi", $key)) :
		$VIEW_QUERY = "SELECT * FROM wizMall WHERE UID='$no'";
		$VIEW_DATA = $dbcon->_fetch_array($dbcon->_query($VIEW_QUERY));

		$UID = $VIEW_DATA[UID];
		$PID = $VIEW_DATA[PID];
		$NAME = stripslashes($VIEW_DATA[NAME]);
		$COMPNAME = stripslashes($VIEW_DATA[COMPNAME]);
		$CHECK = number_format($VIEW_DATA[CHECK]);
		//$SAIL = number_format($VIEW_DATA[SAIL]);
		$SIZE = $VIEW_DATA[SIZE];
		$COLOR = $VIEW_DATA[COLOR];
		$SMALLPIC = $VIEW_DATA[SMALLPIC];
		$BIGPIC = $VIEW_DATA[BIGPIC];
		$MOVIE = $VIEW_DATA[MOVIE];
		$POINT = number_format($VIEW_DATA[POINT]);
		$OPTI = $VIEW_DATA[OPTI];
		$NONE = $VIEW_DATA[NONE];
		$GET = $VIEW_DATA[GET];
		$PUT = $VIEW_DATA[PUT];
		$DATE = $VIEW_DATA[DATE];
		$CATEGORY = $VIEW_DATA[CATEGORY];
		$MODEL = stripslashes($VIEW_DATA[MODEL]);
		//$HIT = $VIEW_DATA[HIT];
		$CAT_SPL = explode(">", $CATEGORY);
		if (file_exists("./upload/$BIGPIC")) {
			$Vpic_size = GetImageSize("./upload/$BIGPIC");
			$VPIC_FILE = "../../../upload/$BIGPIC";
		}
?>

		<table>
		<form name='view_form<?ECHO"$no";?>' action='./wizbag.php'>
		<input type="hidden" name='query' VALUE='cart_save'>
		<input type="hidden" name='no' VALUE='<?ECHO"$no";?>'>
		<tr>
		<td>
		<a href='./wizmart.php?sort=<?ECHO"$CATEGORY";?>&query=view&no=<?ECHO"$UID";?>'><img src='./upload/<?ECHO"$SMALLPIC";?>'></a>
		<p>

		<a href='#' onclick="javascript:window.open('./mall_skin/shop/<?ECHO"$SKIN";?>/picview.php?file=<?ECHO"$VPIC_FILE";?>&subject=<?ECHO"$NAME";?>', 'kimsmall','width=<?ECHO"$Vpic_size[0]";?>,height=<?ECHO"$Vpic_size[1]";?>,statusbar=no,scrollbars=no,toolbar=no,resizable=no')"><img src='./mall_skin/shop/<?ECHO"$SKIN";?>/image/co_zoom.gif'></a>
		<?
		if ($MOVIE) {
			ECHO "<a href='./upload/$MOVIE'><img src='./mall_skin/shop/$SKIN/image/co_movie.gif'></a>";
		}
		?>

		</td>
		<td background='./mall_skin/shop/<?ECHO"$SKIN";?>/image/vline1.gif'><img src='./mall_image/blank.gif'></td>
		<td><img src='./mall_image/blank.gif'></td>
		<td>

		<table>
		<tr>
		<td colspan=2><?ECHO"$NAME $MODEL";?></td>
		</tr>

		<tr>
		<td colspan=2>판매가격 : <?ECHO"$CHECK";?>원</td>
		</tr>

		<tr>
		<td colspan=20>제품위치 : 
		<?
		for($i = 0; $i < sizeof($CAT_SPL); $i++) {

			if ($i == 0) {$CAT_STR = $CAT_SPL[0];} else {$CAT_STR = $CAT_STR.">".$CAT_SPL[$i];}
			ECHO "<a href='./wizmart.php?sort=$CAT_STR'><FONT COLOR='GRAY'>$CAT_SPL[$i]</a>";
			if ($i < sizeof($CAT_SPL)-1) {
				ECHO " > ";
			}
		}
		?>
		</td>
		</tr>

		<tr><td colspan=2>
		<?
		if ($OPTI) {
			if ($OPTI == '신규') {
				ECHO "<img src='./mall_skin/shop/$SKIN/image/new.gif'><br />";
			}
			elseif ($OPTI == '추천') {
				ECHO "<img src='./mall_skin/shop/$SKIN/image/req.gif'><br />";
			}
			elseif ($OPTI == '기획') {
				ECHO "<img src='./mall_skin/shop/$SKIN/image/plan.gif'><br />";
			}
			elseif ($OPTI == '히트') {
				ECHO "<img src='./mall_skin/shop/$SKIN/image/hit.gif'><br />";
			}
			else {
				ECHO "<img src='./mall_skin/shop/$SKIN/image/special.gif'><br />";
			}
		}
		?>
		</td></tr>
		<tr>
		<td colspan=2 background='./mall_skin/shop/<?ECHO"$SKIN";?>/image/list_line.gif'> </td>
		</tr>
		<tr>
		<td colspan=2> </td>
		</tr>

		<tr>
		<td>제조사</td><td>: <?ECHO"$COMPNAME";?></td>
		</tr>
		<tr>
		<td>적립금</td><td>: <?ECHO"$POINT";?>포인트</td>
		</tr>

		<?if ($SIZE) :?>
		<?$SIZE_DATA = explode("\n", $SIZE);?>
		<tr>
		<td>옵션</td><td>: <SELECT name=SIZE>
		<?
		if (eregi("=", $SIZE)) {

			ECHO "<OPTION VALUE=''>기본옵션 적용</OPTION>
			<OPTION VALUE=''>--------------</OPTION>";

			for($i = 0; $i < sizeof($SIZE_DATA) && chop($SIZE_DATA[$i]); $i++) {
				$SIZE_DATA_SPL = explode("=", chop($SIZE_DATA[$i]));
				ECHO "<OPTION VALUE='".chop($SIZE_DATA[$i])."'>".$SIZE_DATA_SPL[0]." (".number_format($SIZE_DATA_SPL[1])."원추가)</OPTION>";
			}
		}
		else {
			for($i = 0; $i < sizeof($SIZE_DATA) && chop($SIZE_DATA[$i]); $i++) {
				ECHO "<OPTION VALUE='".chop($SIZE_DATA[$i])."'>".chop($SIZE_DATA[$i])."</OPTION>";
			}
		}
		?>
		</SELECT>
		</td>
		</tr>
		<?endif;?>

		<?if ($COLOR) :?>
		<?$COLOR_DATA = explode("\n", $COLOR);?>
		<tr>
		<td>색상</td><td>: <SELECT name=COLOR>
		<?
		for($i = 0; $i < sizeof($COLOR_DATA) && chop($COLOR_DATA[$i]); $i++) {
			ECHO "<OPTION VALUE='".chop($COLOR_DATA[$i])."'>".chop($COLOR_DATA[$i])."</OPTION>";
		}
		?>
		</SELECT>
		</td>
		</tr>
		<?endif;?>

		<tr>
		<td>주문수량</td><td>

		<table>
		<tr>
		<td ROWSPAN=2>: <input type="text" SIZE=5 name="BUYNUM" MAXLENGTH=5 VALUE="1" onkeypress="is_number()"></td>
		<td><a href="javascript:num_plus(document.view_form<?ECHO"$no";?>);"><img src="./mall_image/num_plus.gif"></a></td>
		<td ROWSPAN=2>&nbsp;&nbsp;EA</td>
		</tr>
		<tr>
		<td><a href="javascript:num_minus(document.view_form<?ECHO"$no";?>);"><img src="./mall_image/num_minus.gif"></a></td>
		</tr>
		</table>

		</td>
		</tr>


		<tr>
		<td colspan=2 background='./mall_skin/shop/<?ECHO"$SKIN";?>/image/list_line.gif'> </td>
		</tr>
>

		<tr>
		<td colspan=2>
		<input type=IMAGE src='./mall_skin/shop/<?ECHO"$SKIN";?>/image/cart.gif'> 
		<a href='./mall_include/WISH_LIST.php?uid=<?ECHO$UID;?>'><img src='./mall_skin/shop/<?ECHO"$SKIN";?>/image/wish.gif'></a>
		<a href=''><img src='./mall_skin/shop/<?ECHO"$SKIN";?>/image/que.gif'></a>
		</td>
		</tr>
		</form>
		</table>
		
		</td>
		</tr>
		</table>

		<table>
>
		<tr>
		<td colspan=2 background='./mall_skin/shop/<?ECHO"$SKIN";?>/image/list_line.gif'> </td>
		</tr>
		</table>
<?
	endif;
endwhile;
?>
</DIV>