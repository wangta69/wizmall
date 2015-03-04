<?php
/*
 powered by 폰돌
 Reference URL : http://www.shop-wiz.com
 Contact Email : master@shop-wiz.com
 Free Distributer :
 - http://www.shop-wiz.com
 Copyright shop-wiz.com
 *** Updating List ***
 */
include "./basicconfig/common.php";
?>
<script>
	$(function() {
		$("#btn_save").click(function() {
			$("#s_form").submit();
		});

		$(".category_click").click(function() {
			$(".subcat").hide();
			$(".subcat").eq($(".category_click").index(this)).show();
			//메서드
		});

		$(".btn_catskin_save").click(function() {
			var i = $(".btn_catskin_save").index(this);
			var uid = $(this).attr("uid");
			var cat_skin = $(".cat_skin").eq(i).val();
			var cat_skin_view = $(".cat_skin_view").eq(i).val();
			//alert(uid+", "+cat_skin+", "+cat_skin_view);
			$.post("./proc/proc.php", {
				uid : uid,
				cat_skin : cat_skin,
				cat_skin_view : cat_skin_view,
				t_page : "ch_shop_cat_skin"
			}, function(data) {
				//alert(data);
			});
		});
	});

</script>
<style>
	.categoryList li {
		float: left;
	}
	.categoryList:after {
		content: "";
		clear: both;
		display: block
	}
	.title {
		width: 100px;
	}
	.subcatList li {
		float: left;
	}
	.subcatList:after {
		content: "";
		clear: both;
		display: block
	}
</style>
<div class="table_outline">
	<div class="panel panel-success">
		<div class="panel-heading">
			몰스킨 설정
		</div>
		<div class="panel-body">
			위즈몰의 각종 몰스킨을 설정하실 수 있습니다.
			<br />
			숍디스프레이에서는 상품 출력 갯수를 설정하실 수 있습니다.
			<br />
			카테고리별 스킨설정이 가능하므로 상품특성에 맞는 다양한 스킨설정이 가능합니다.
		</div>
	</div>

	사용하고자 하시는 스킨을 지정하여 주십시오.
	<form action='<?php echo $PHP_SELF?>' method="post" id="s_form">
		<input type="hidden" name="csrf" value="<?php echo $common->getcsrfkey() ?>">
		<input type='hidden' name='menushow' value='<?php echo $menushow?>'>
		<input type="hidden" name="theme" value=<?php echo $theme; ?>>
		<input type="hidden" name=action value='skin_save'>
		<table class="table table-hover">
			<tr>
				<th> 레이아웃 </th>
				<td>
				<select name="LayoutSkin" style="width: 160px">
					<?php
					$targetdir = "../skinwiz/layout";
					$common -> showFolderList($targetdir, $cfg["skin"]["LayoutSkin"]);
					?>
				</select> 쇼핑몰의 레이아웃스킨</td>
			</tr>
			<!-------------- 메인화면 스킨 시작 ----------------------------------------------------------------------------------->
			<tr>
				<th> 메인화면스킨
				<br />
				<input id="box" type="checkbox" value="checked" name=MainSkin_Inc <?php echo $cfg["skin"]["MainSkin_Inc"]?>>
				스킨사용</th>
				<td>
				<select style="width: 160px" name=MainSkin>
					<?php
					$targetdir = "../skinwiz/index";
					$common -> showFolderList($targetdir, $cfg["skin"]["MainSkin"]);
					?>
				</select> 쇼핑몰 첫화면</td>
			</tr>
			<tr>
				<th> 메뉴옵션 </th>
				<td>
				<input id=MenuSkin_Inc type="checkbox" value="checked" name=MenuSkin_Inc <?php echo $cfg["skin"]["MenuSkin_Inc"]?>>
				스킨사용
				<input id="MenuSkin_Inc" type="checkbox" value="checked" name=GoodsNoShow <?php echo $cfg["skin"]["GoodsNoShow"]?>>
				상품수표시</td>
			</tr>
			<!-------------- 메뉴화면 스킨 끝 ----------------------------------------------------------------------------------->
			<!-------------- 기본매장화면 스킨 시작 ----------------------------------------------------------------------------------->
			<tr>
				<th> 상품 리스트스킨 </th>
				<td>
				<select style="width: 160px" name="ShopSkin">
					<?php
					$targetdir = "../skinwiz/shop";
					$common -> showFolderList($targetdir, $cfg["skin"]["ShopSkin"]);
					?>
				</select> 쇼핑몰의상품 디스플레이 스킨
				<br />
				</td>
			</tr>
			<tr>
				<th>상품 리스트스킨 상세옵션</th>
				<td> 페이지당상품 리스수 :
				<input name="ListNo" value="<?php echo $cfg["skin"]["ListNo"]?>" class="w50 agn_r">
				<br/>
				개 페이지별 이동번호 수 :
				<input name="PageNo" value="<?php echo $cfg["skin"]["PageNo"]?>" class="w50 agn_r">
				개
				<br/>
				<input name="stockoutDisplay" type="checkbox" id="stockoutDisplay" value="1" <?php
					if ($cfg["skin"]["stockoutDisplay"] == "1")
						echo "checked";
				?> />
				품절상품표시
				<br />
				1차카테고리 첫화면 모양
				<select size=1 name="SubListSubject">
					<?php
					reset($RegOptionArr);
					while (list($key, $value) = each($RegOptionArr)) :
						if ($cfg["skin"]["SubListSubject"] == "$value")
							$selected = "selected";
						else
							unset($selected);
						echo "<OPTION value='$value' $selected >$value</OPTION>\n";
					endwhile;
					?>
				</select> 을
				<input name="SubListNo" value="<?php echo $cfg["skin"]["SubListNo"]?>">
				개 출력</td>
			</tr>
			<!-------------- 기본배장화면 스킨 끝 ----------------------------------------------------------------------------------->
			<!-------------- 기본매장화면 스킨 시작 ----------------------------------------------------------------------------------->
			<tr>
				<th> 상품 상세보기스킨</th>
				<td>
				<select style="width: 160px" name="ViewerSkin">
					<?php
					$targetdir = "../skinwiz/viewer";
					$common -> showFolderList($targetdir, $cfg["skin"]["ViewerSkin"]);
					?>
				</select> 쇼핑몰의상품 디스플레이 스킨
				<br />
				</td>
			</tr>
			<tr>
				<td colspan="2">
				<input type="checkbox" name="GoodsDisplayEstim" value="checked" <?php echo $cfg["skin"]["GoodsDisplayEstim"]?>>
				상세보기페이지에 상품평표시하기
				<input type="checkbox" name="GoodsDisplayPid" value="checked" <?php echo $cfg["skin"]["GoodsDisplayPid"]?>>
				상세보기페이지에 관련상품 표시하기 </p></td>
			</tr>
			<!-------------- 기본배장화면 스킨 끝 ----------------------------------------------------------------------------------->
			<!-------------- 옵션등록 아이콘 시작 ----------------------------------------------------------------------------------->
			<tr>
				<th> 옵션아이콘스킨</th>
				<td>
				<p>
					<select name="ShopIconSkin" style="width: 160px">
						<?php
						$targetdir = "../skinwiz/common_icon";
						$common -> showFolderList($targetdir, $cfg["skin"]["ShopIconSkin"]);
						?>
					</select>
				</p></td>
			</tr>
			<!-------------- 옵션등록 아이콘 시끝 ----------------------------------------------------------------------------------->
			<!--------------상품결제화면 스킨 시작 ----------------------------------------------------------------------------------->
			<tr>
				<th> 장바구니스킨
				<br />
				<input id="NoneDouble" type="checkbox" value="checked" name="NoneDouble" <?php echo $cfg["skin"]["NoneDouble"]?>>
				중복담기금지 </th>
				<td>
				<select style="width: 160px" name="CartSkin">
					<?php
					$targetdir = "../skinwiz/cart";
					$common -> showFolderList($targetdir, $cfg["skin"]["CartSkin"]);
					?>
				</select> 일련의 장바구니 스킨</td>
			</tr>
			<!-------------- 상품결제화면 스킨 끝 ----------------------------------------------------------------------------------->
			<!--------------공동구매 스킨 시작 ----------------------------------------------------------------------------------->
			<tr>
				<th> 공동구매스킨</th>
				<td>
				<select style="width: 160px" name="CoorBuySkin">
					<?php
					$targetdir = "../skinwiz/wizcoorbuy";
					$common -> showFolderList($targetdir, $cfg["skin"]["CoorBuySkin"]);
					?>
				</select> 일련의 장바구니 스킨</td>
			</tr>
			<tr>
				<td colspan="2">
				<input name="co_nonmember" type="checkbox" id="co_nonmember" value="checked" <?php echo $cfg["skin"]["co_nonmember"]?>>
				공동구매비회원구매
				<input name="co_cardenable" type="checkbox" id="co_cardenable" value="checked" <?php echo $cfg["skin"]["co_cardenable"]?>>
				공동구매카드가능</td>
			</tr>
			<!-------------- 공동구매 스킨 끝 ----------------------------------------------------------------------------------->
			<!--------------회원가입관련스킨 시작 ----------------------------------------------------------------------------------->
			<tr>
				<th class="active">회원관련스킨
				<br />
				<input id=box type="checkbox" value="checked" name="NoneMemOnly" <?php echo $cfg["skin"]["NoneMemOnly"]?>>
				비회원전용 </th>
				<td>
				<select style="width: 160px" name="MemberSkin">
					<?php
					$targetdir = "../wizmember";
					$common -> showFolderList($targetdir, $cfg["skin"]["MemberSkin"]);
					?>
				</select> 회원가입,수정,탈퇴에 관한 스킨</td>
			</tr>
			<!-------------- 회원가입관련 스킨 끝----------------------------------------------------------------------------------->
			<tr>
				<th> 검색스킨</th>
				<td>
				<select style="width: 160px" name="SearchSkin">
					<?php
					$targetdir = "../skinwiz/search";
					$common -> showFolderList($targetdir, $cfg["skin"]["SearchSkin"]);
					?>
				</select> 검색 디스플레이 스킨</td>
			</tr>
			<!-------------- [위시리스트 스킨]----------------------------------------------------------------------------------->
			<tr>
				<th> 위시리스트스킨</th>
				<td>
				<select style="width: 160px" name="WishSkin">
					<?php
					$targetdir = "../skinwiz/wizwish";
					$common -> showFolderList($targetdir, $cfg["skin"]["WishSkin"]);
					?>
				</select> 위시리스트 디스플레이 스킨</td>
			</tr>
			<!-------------- [zipcode pop skin 선택 start] ----------------------------------------------------------------------------------->
			<tr>
				<th> 우편번호찾기스킨</th>
				<td>
				<select style="width: 160px" name="ZipCodeSkin">
					<?php
					$targetdir = "../util/zipcode";
					$common -> showFolderList($targetdir, $cfg["skin"]["ZipCodeSkin"]);
					?>
				</select> 우편번호찾기 디스플레이 스킨</td>
			</tr>
		</table>
		<div class="text-center">
			<button type="button" class="btn btn-primary" id="btn_save">
				설정
			</button>
		</div>
	</form>

	<table class="table table-hover">
		<tr>
			<th class="active">매장스킨 확장</th>
			<td colspan=3>
			<br />
			매장스킨 확장기능은 매장별로 스킨을 구분하여 지정할 수 있는 기능입니다..
			<br />
			성격이 다른 매장인 관계로, 스킨을 다르게 지정하고자 할 경우 해당매장만 스킨을 변경하여 주시면 됩니다.
			<br />
			매장 확장스킨을 지정하지 않으시면 기본매장스킨으로 적용됩니다.
			<br />
			<br />
			<span class="orange">| 적 용 스 킨 |</span> <?php
			$displayID = 1;
			$sqlstr = "select * from wizCategory where length(cat_no) = 3 and cat_flag='wizmall' order by cat_no asc";
			$sqlqry = $dbcon->_query($sqlstr);
			while($list = $dbcon->_fetch_array($sqlqry)):
			$bigcode = $list["cat_no"];
			?>
			<ul class="categoryList">
				<li class="category_click title">
					<?php echo $list[cat_name]?>
				</li>
				<li>
					<select class="cat_skin">
						<option value="" selected>기본 리스트 스킨 적용</option>
						<?php
						$targetdir = "../skinwiz/shop";
						$common -> showFolderList($targetdir, $list[cat_skin]);
						?>
					</select>
				</li>
				<li>
					<select class="cat_skin_view">
						<option value="" selected>기본 상세보기 스킨 적용</option>
						<?php
						$targetdir = "../skinwiz/viewer";
						$common -> showFolderList($targetdir, $list[cat_skin_viewer]);
						?>
					</select>
				</li>
				<li>
					<button type="button" class="btn btn-xs btn_catskin_save" uid="<?php echo $sublist["UID"]?>">
						적용
					</button>
				</li>

			</ul>
			<div class="subcat none" style="padding-left:50px;">
				<?php
				/* 중분류 카테고리를 리스트 한다.*/

				$sqlsubstr = "select * from wizCategory where length(cat_no) = 6 and cat_no LIKE '%$bigcode' order by cat_no asc";
				$sqlsubqry = $dbcon->_query($sqlsubstr);
				while($sublist = $dbcon->_fetch_array($sqlsubqry)):
				?>
				<ul class="subcatList">
					<li class="title">
						<?php echo $sublist[cat_name]?>
					</li>
					<li>
						<select class="cat_skin">
							<option value="" selected>기본 리스트 스킨 적용</option>
							<?php
							$targetdir = "../skinwiz/shop";
							$common -> showFolderList($targetdir, $sublist[cat_skin]);
							?>
						</select>
					</li>
					<li>
						<select  class="cat_skin_view">
							<option value="" selected>기본 상세보기 스킨 적용</option>
							<?php
							$targetdir = "../skinwiz/viewer";
							$common -> showFolderList($targetdir, $sublist[cat_skin_viewer]);
							?>
						</select>
					</li>
					<li>
						<button type="button" class="btn btn-xs btn_catskin_save" uid="<?php echo $sublist["UID"]?>">
							적용
						</button>
					</li>
				</ul>
				<?php
				endwhile;
				?>
			</div> <?php
			endwhile;
			?> </td>
		</tr>
	</table>
</div>