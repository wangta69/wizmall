<?php
/*
 powered by 폰돌
 Reference URL : http://www.shop-wiz.com
 Contact Email : master@shop-wiz.com
 Free Distributer :

 Copyright shop-wiz.com
 *** Updating List ***
 */

$CAT_IMG_ATTACHED = "enable";
if (!$cat_flag)
	$cat_flag = "wizmall";
$cat_depth = 3;
$new_category_name = addslashes(trim($new_category_name));
$cat_img_path = "../config/uploadfolder/categoryimg";
/*********************************************************************************************************************************/
if ($common -> checsrfkey($csrf)) {
	switch($action) {
		case "in" :
			if ($new_category_name) {
				$lv = strlen($ccode) / 3 + 1;
				//현재 카테고리의 레벨을 구한다.
				$cat_no = $admin -> getcatno($lv, $ccode);
				$cat_order = $admin -> getcatorder($lv, $ccode);
				/* 파일 업로딩 시작 */

				/* 파일 업로딩 시작 */
				$common -> upload_path = $cat_img_path;
				$common -> uploadmode = "insert";
				$common -> uploadfile("file");
				$cat_img = $common -> returnfile[0];
				/* 파일 업로딩 끝 */

				$sqlstr = "INSERT INTO wizCategory (cat_order,cat_no,cat_name,cat_flag,cat_img) VALUES('$cat_order','$cat_no','$new_category_name','$cat_flag','$cat_img')";
				//echo "\$sqlstr = $sqlstr <br />";
				$dbcon -> _query($sqlstr);
			}
			break;
		case "up" :
			## 카테고리로 등록된 이미지를 구한다.
			$sqlstr = "select cat_img FROM wizCategory WHERE cat_no = '$ccode' and cat_flag='$cat_flag'";
			$cat_img = $dbcon -> get_one($sqlstr);

			## 현재 카테고리 정보를 변경한다.
			$sqlstr = "update wizCategory set cat_name = '$new_category_name' WHERE cat_no = '$ccode' and cat_flag='$cat_flag'";
			$dbcon -> _query($sqlstr);

			## 파일 업로딩 시작
			##database 연결
			//$common->db_connect();
			$common -> oldfilename = $cat_img;
			$common -> upload_path = $cat_img_path;
			$common -> uploadmode = "update";
			$common -> uploadfile("file");
			$cat_img = $common -> returnfile[0];
			## 파일 업로딩 끝
			$common -> js_location("$PHP_SELF?menushow=$menushow&theme=$theme&cat_flag=$cat_flag&where=$where&ccode=$ccode");
			break;
		case "de" :
			## 하위 카테고리 존재시 삭제를 cancel
			$sqlstr = "select count(1) from wizCategory where cat_no like '%$ccode' and cat_flag='$cat_flag'";
			$cnt = $dbcon -> get_one($sqlstr);
			if ($cnt > 1) {## 자신을 폼함하여 1개 이상 존재시
				$common -> js_alert("하위 카테고리가 존재 합니다.\\n\\n먼저 하위 카테고리를 삭제해 주시기 바랍니다.");
			}

			## 현카테고리에 상품이 존재하면 삭제를 cancel
			$sqlstr = "select count(1) from wizMall where Category = '$ccode'";
			$cnt = $dbcon -> get_one($sqlstr);
			if ($cnt > 0) {## 제품이 한개 이상 존재시
				$common -> js_alert("현재 카테고리에 제품(다중혹은 단일)이 등록되어있습니다..\\n\\n먼저 해당카테고리의 상품을 삭제하거나 변경해 주시기 바랍니다.");
			}

			/* 카테고리 DB에서 지우기 START */
			#첨부된 이미지 삭제하기
			$sqlstr = "select cat_img from wizCategory WHERE cat_no = '$ccode' and cat_flag='$cat_flag'";
			$dbcon -> _query($sqlstr);
			$list = $dbcon -> _fetch_array();
			if (file_exists($cat_img_path . "/" . $list["cat_img"]) && $list["cat_img"])
				unlink($cat_img_path . "/" . $list["cat_img"]);

			# 카테고리 삭제
			$sqlstr = "DELETE FROM wizCategory WHERE cat_no = '$ccode' and cat_flag='$cat_flag'";
			$dbcon -> _query($sqlstr);

			$common -> js_location("$PHP_SELF?menushow=$menushow&theme=$theme&cat_flag=$cat_flag&ccode=$ccode");
			break;
		case "in_desc" :
			$sqlstr = "update wizCategory set cat_top = '$cat_top', cat_bottom = '$cat_bottom' where cat_no = '$cat_no' and cat_flag='$cat_flag'";
			$dbcon -> _query($sqlstr);
			$common -> js_location("$PHP_SELF?menushow=$menushow&theme=$theme&cat_flag=$cat_flag&where=$where&ccode=$ccode&code=$cat_no");
			break;
	}
}//if($common->checsrfkey($csrf)){
?>
<script>
function actionqry(f,val){
    f.action.value = val;
    f.submit();
}

function cat_manage(code,flag){
    if(typeof(flag) =="undefined") flag = "";
    var csrf = "<?php echo $common->getcsrfkey()?>";
	location.href = "<?php echo $PHP_SELF?>?menushow=<?php echo $menushow?>&theme=<?php echo $theme?>&cat_flag=<?php echo $cat_flag?>&ccode="+code+"&action="+flag+"&csrf="+csrf;
}
</script>
<script type="text/javascript" src="../js/Smart/js/HuskyEZCreator.js" charset="utf-8"></script>
<!-- body start -->
<div class="table_outline">
	<div class="panel panel-success">
		<div class="panel-heading">
			카테고리 메니저
		</div>
		<div class="panel-body">
			상품카테고리를 등록, 수정, 변경 삭제 하는 곳입니다. 또한 카테고리별로 별도의 코딩을
			하실 수 도 있습니다.
			<br />
			( <span class="glyphicon glyphicon-home"></span> 매장보기, <span class="glyphicon glyphicon-list-alt"></span> 카테고리등록 및 수정, <span class="glyphicon glyphicon-pencil"></span> 카테고리별 상,하단 코딩, <span class="glyphicon glyphicon-trash"></span>카테고리 삭제 )
		</div>
	</div>

	<form action='<?php echo $PHP_SELF?>' method="post" enctype="multipart/form-data">
		<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
		<input type='hidden' name='menushow' value='<?php echo $menushow?>'>
		<input type="hidden" name="theme" value='<?php echo $theme?>'>
		<input type="hidden" name="action" value='in'>
		<input type="hidden" name="cat_flag" value='<?php echo $cat_flag; ?>'>

		<input name="new_category_name" class="form-control w100"  placeholder="대분류 입력" style="display:inline"/>
		<input name="file[]" type="file" id="file[]" class="form-control w300" style="display:inline"/>
		<button type="submit" class="btn btn-primary">
			대분류등록
		</button>
		<a href="./catmanager/shopmanager1_1.php?DownForExel=yes" class="btn btn-info">전체리스트출력</a>
	</form>
	<br />
	<table class="table">
		<tr>
<?php
$width = (int)(100/$cat_depth);
for($i=0; $i<$cat_depth; $i++){

//echo "1번";
$j = $i+1;
$bgcolor = $i%2 ? "bgcolor='#B9C2CC'":"bgcolor='#E0E4E8'";
$c_len = $j*3;
$p_len = $c_len-3;
$ccode_len = strlen($ccode);
?>
<td style="vertical-align:top"><!-- 분류 테이블 시작 -->
<?php echo $j; ?>
			차카테고리<br />
			<table class="table">
<?php
//echo "$ccode_len >= ".$i*3;
if ($ccode_len >= $i*3){
    $orderby = "order by cat_order asc ";
if ($i > 0){
    $whereis1 = "WHERE LENGTH(cat_no) = ".$c_len." and RIGHT(cat_no, $p_len) = '".substr($ccode, -$p_len)."' and cat_flag='$cat_flag' ";
}else{
    $whereis1 = "WHERE LENGTH(cat_no) = ".$c_len." and cat_flag='$cat_flag' ";
}
    $sqlstr1 = "SELECT * FROM wizCategory $whereis1 ".$orderby;
    $sqlqry1 = $dbcon->_query($sqlstr1);
    while($list1=$dbcon->_fetch_array($sqlqry1)):
    $tccode = $list1["cat_no"];
?>

			<tr>
			<td style="cursor:pointer" onClick="cat_manage('<?php echo $tccode?>');" width="100px"><?php
			if (substr($ccode, -$c_len) == $tccode)
				echo $list1["cat_name"] . "\n";
			else
				echo $list1["cat_name"] . "\n";
			?>
			</td>
			<td>
			<a href='../wizmart.php?code=<?php echo $tccode?>' target='_blank'><span class="glyphicon glyphicon-home"></span></a>
			<a href="javascript:cat_manage('<?php echo $tccode?>');"><span class="glyphicon glyphicon-list-alt"></span></a>
			<a href="javascript:cat_manage('<?php echo $tccode?>', 'coding');"><span class="glyphicon glyphicon-pencil"></span></a>
			<a href="javascript:cat_manage('<?php echo $tccode?>', 'de');"><span class="glyphicon glyphicon-trash"></span></a>
			</td>
			</tr>

			<?php
			endwhile;

			}//if ($i < 1 ){
			?>						</table>
			<!-- 분류 테이블 끝 -->
			</td>
			<?php
			}
			?>
		</tr>
	</table>

	<!-- 서브(2차, 3차) 카테고리 수정/변경 및 1차 카테고리 변경 -->

	<?php
	if($ccode):
	?>
	<form action='<?php echo $PHP_SELF?>' method="post" enctype="multipart/form-data" name="catfrm">
		<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
		<input type='hidden' name='menushow' value='<?php echo $menushow?>'>
		<input type="hidden" name="theme" value='<?php echo $theme?>'>
		<input type="hidden" name="action" value=''>
		<input type="hidden" name="ccode" value='<?php echo $ccode?>'>
		<input type="hidden" name="cat_flag" value='<?php echo $cat_flag; ?>'>
		<input type="text" name="new_category_name" class="form-control w100" style="display:inline">

		<?php
if($CAT_IMG_ATTACHED == "enable"):
		?>

		<input name="file[]" type="file" id="file[]" class="form-control w300" style="display:inline">
		<?php
		endif;
		?>

		<?php
if($where != 'sub_regis3'):
		?>
		<button type="button" class="btn btn-primary" onclick="actionqry(document.catfrm,'in')">
			등록
		</button>

		<?php
		endif;
		?>
		<button type="button" class="btn btn-primary" onclick="actionqry(document.catfrm,'up')">
			변경
		</button>
	</form>
	<?php
	endif;
	?>

	<!-- 상단 / 하단 코딩 파트 시작 -->
	<form name = "SaveCatCoding" action="<?php echo $PHP_SELF?>" method="post">
		<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
		<input type="hidden" name="cat_no" value = "<?php echo $code?>">
		<input type="hidden" name="theme" value = "<?php echo $theme?>">
		<input type='hidden' name='menushow' value='<?php echo $menushow?>'>
		<input type="hidden" name="action" value = "in_desc">
		<input type="hidden" name="where" value = "<?php echo $where?>">
		<input type="hidden" name="ccode" value="<?php echo $ccode?>">
		<input type="hidden" name="cat_flag" value='<?php echo $cat_flag; ?>'>

		<?php
		if($action == "coding" && $ccode):
		$sqlstr = "SELECT * FROM wizCategory WHERE  cat_no = '$code' and cat_flag='$cat_flag'";
		$sqlqry = $dbcon->_query($sqlstr);
		$list = $dbcon->_fetch_array($sqlqry);
		?>
		페이지 html 삽입 : html로 등록해 주시고 등록시 &lt;table&gt;테크를 만들어 넣어 주시기를 추천합니다
		<br />
		<span>상단코딩</span>
		<br />
		<textarea name="cat_top" rows=5 class="w100p" id="ir1"><?php echo $list["cat_top"]?></textarea>
		<br />
		<span>하단코딩</span>
		<br />
		<textarea name="cat_bottom" rows=5  class="w100p" id="ir2"><?php echo $list["cat_bottom"]?></textarea>
	</form>
	<script >
		var oEditors = [];
		nhn.husky.EZCreator.createInIFrame({
			oAppRef : oEditors,
			elPlaceHolder : "ir1",
			sSkinURI : "../js/Smart/SmartEditor2Skin.html",
			fCreator : "createSEditor2"
		});

		nhn.husky.EZCreator.createInIFrame({
			oAppRef : oEditors,
			elPlaceHolder : "ir2",
			sSkinURI : "../js/Smart/SmartEditor2Skin.html",
			fCreator : "createSEditor2"
		});

		function _onSubmit(elClicked) {
			//oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);
			// 에디터의 내용을 에디터 생성시에 사용했던 textarea에 넣어 줍니다.
			oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);
			oEditors.getById["ir2"].exec("UPDATE_CONTENTS_FIELD", []);

			// 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.

			try {
				elClicked.form.submit();
			} catch(e) {
			}
		}
	</script>
	<!--매장 카테고리 코딩 끝 -->
	<p class="text-center">
		<a href="javascript:_onSubmit(this)"class="btn btn-primary">코딩 적용</a>
	</p>

	<?php
	endif;
	?>

</div>