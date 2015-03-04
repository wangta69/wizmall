<?php
if($dp_mode == "pop"){
?>

총 등록상품 :
<?=$REALTOTAL ?>
개 | 선택상품수 :
<?=$TOTAL ?>
<br />
<form action='<?=$PHP_SELF ?>' method="post" name="SortForm" id="sform">
	<input type="hidden" name="csrf" value="<?=$common->getcsrfkey()?>">
	<input type="hidden" name="cp" id="cp" value='1'>
	<input type="hidden" name="category" value="<?=$category ?>">
	<input type="hidden" name="stitle" value="">
	<input name="keyword" value="<?=$keyword ?>" size=12>
	<input type="image" src="../img/gum.gif" width="44">
	<select style="width: 100px" onChange="SortbyCat(this)">
		<option value="">대분류</option>
		<option value="">-----------</option>
<?php
$mall -> getSelectCategory(1, $category);
?>
	</select>
	<select style="width: 100px"  onChange="SortbyCat(this)">
		<option value="">중분류</option>
		<option value="">-----------</option>
<?php
$mall -> getSelectCategory(2, $category);
?>
	</select>
	<select style="width: 100px"  onChange="SortbyCat(this)">
		<option value="">소분류</option>
		<option value="">-----------</option>
<?php
$mall -> getSelectCategory(3, $category);
?>
	</select>
</form>
<?php
}else{
?>
총 등록상품 :
<?=$REALTOTAL ?>
개 | 선택상품수 :
<?=$TOTAL ?>
<form action='<?=$PHP_SELF ?>' method="post" name="SortForm" id="sform">
	<input type="hidden" name="csrf" value="<?=$common->getcsrfkey()?>">
	<input type="hidden" name="menushow" value=<?=$menushow ?>>
	<input type="hidden" name="theme"  value=<?=$theme ?>>
	<input type="hidden" name="cp" id="cp" value='1'>
	<input type="hidden" name="category" value="<?=$category ?>">
	<input type="hidden" name="uid" value="">
	<input name="keyword" value="<?=$keyword ?>" size=12>
	<button type="submit" class="btn btn-primary btn-xs">
		검색
	</button>
<? 
$admin -> sel_pd_opt($OptionList);	//옵션별
?>
	<select style="width: 100px" onChange="SortbyCat(this)">
		<option value="">대분류</option>
		<option value="">-----------</option>
<?php
$mall -> getSelectCategory(1, $category);
?>
	</select>
	<select style="width: 100px"  onChange="SortbyCat(this)">
		<option value="">중분류</option>
		<option value="">-----------</option>
<?php
$mall -> getSelectCategory(2, $category);
?>
	</select>
	<select style="width: 100px"  onChange="SortbyCat(this)">
		<option value="">소분류</option>
		<option value="">-----------</option>
<?php
$mall -> getSelectCategory(3, $category);
?>
	</select>
<? 
$admin -> sel_pd_order($orderby);//정렬
?>
</form>
<?php
}
?>
