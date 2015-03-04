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
<link rel="stylesheet" type="text/css" href="../css/tree.css"/>
<script>
	$(function() {
		loadbankList();

		$(".btn_save").click(function() {
			$("#s_form").submit();
		});
	});

	function loadbankList() {
		$("#bankListHtml").load("./basicconfig/basic_info3.bank.php", function() {

		});
	}

</script>
<div class="table_outline">
	<div class="panel panel-success">
		<div class="panel-heading">
			몰 결제환경 설정
		</div>
		<div class="panel-body">
			몰의 결제 환경설정을 하실 수 있습니다. 결제방법을 원하시면 각각의 결제방법 앞에 책크해 주시면됩니다.
			<br />
			결제종류 : 온라인무통장, 신용카드, 포인트(적립금), 다중결제(온라인+신용카드+포인트)
			<br />
			배송비선택 및 VAT. 설정 그리고 카테고리별 카드가 차등적용등이 가능합니다.
			<br />
			기본제공외의 결제모듈에 관해서는 업체와 상담하시기 바랍니다.
		</div>
	</div>

	<form action='<?php echo $PHP_SELF ?>' method="post" id="s_form">
		<input type="hidden" name="csrf" value="<?php echo $common->getcsrfkey() ?>">
		<input type='hidden' name='menushow' value='<?php echo $menushow ?>'>
		<input type="hidden" name="theme" value=<?php echo $theme; ?>>
		<input type="hidden" name="action" value='pay_save'>
		다음의 결제관련 설정을 정확히 지정하여 주십시오.

		<div class="panel">
			<div class="panel-heading">
				<input type="checkbox" value="checked" name="ONLINE_ENABLE"  <?php echo $cfg["pay"]["ONLINE_ENABLE"] ?> />
				온라인무통장 결제(기본)
			</div>
			<div class="panel-body" id="bankListHtml">
				<!-- 온라인 무통장 결제  불러옮  ./basicconfig/basic_info3.bank.php-->
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">
				<input type="checkbox" value="checked" name="CARD_ENABLE"  <?php echo $cfg["pay"]["CARD_ENABLE"] ?>>
				신용카드 결제(* 신용카드 결제를 사용할 시)
				<br />
			</div>
			<div class="panel-body">
				<table class="table table-hover">
					<tr>
						<th class="active">결제시스템 업체</th>
						<td>
						<SELECT name="CARD_PACK">
							<?php
							$skskin_dir = opendir("../skinwiz/cardmodule");
							while ($skskdir = readdir($skskin_dir)) {
								if (($skskdir != ".") && ($skskdir != "..")) {
									if ($cfg["pay"]["CARD_PACK"] == "$skskdir") {
										echo "<option value=\"$skskdir\" selected>$skskdir</option>\n";
									} else {
										echo "<option value=\"$skskdir\">$skskdir</option>\n";
									}
								}
							}
							closedir($skskin_dir);
							?>
						</SELECT></td>
					</tr>
					<tr>
						<th class="active">상점아이디</th>
						<td>
						<input value="<?php echo $cfg["pay"]["CARD_ID"] ?>" name="CARD_ID">
						</td>
					</tr>
					<tr>
						<th class="active">상점패스워드</th>
						<td>
						<input value="<?php echo $cfg["pay"]["CARD_PASS"] ?>" name="CARD_PASS">
						(KICC Only)
						<br />
						</td>
					</tr>
					<tr>
						<th class="active">신용카드
						최소 제품구매액</th>
						<td>
						<input value="<?php echo $cfg["pay"]["CARD_ENABLE_MONEY"] ?>" name="CARD_ENABLE_MONEY" class="w50 agn_r">
						원 이상</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">
				타 결제 수단
			</div>
			<div class="panel-body">
				<table class="table table-hover">
					<tr>
						<th>
						<input type="checkbox" value="checked" name=PHONE_ENABLE  <?php echo $cfg["pay"]["PHONE_ENABLE"] ?>>
						핸드폰결제</th>
					</tr>
					<tr>
						<th>
						<input type="checkbox" value="checked" name="AUTOBANKING_ENABLE"  <?php echo $cfg["pay"]["AUTOBANKING_ENABLE"] ?>>
						실시간자동이체</th>
					</tr>
					<tr>
						<th>
						<input type="checkbox" value="checked" name="POINT_ENABLE" <?php echo $cfg["pay"]["POINT_ENABLE"] ?>>
						포인트 결제 </th>
					</tr>
					<tr>
						<td height=59>&nbsp;*
						최소 구매 허용 포인트 &nbsp;
						<input name="POINT_ENABLE_MONEY" value="<?php echo $cfg["pay"]["POINT_ENABLE_MONEY"] ?>" class="w50 agn_r">
						포인트 이상
						<br />
						&nbsp;* , (컴마) 표시 없이 숫자로만 입력해 주시기 바랍니다. </td>
					</tr>
				</table>
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">
				상세 결제 옵션
			</div>
			<div class="panel-body">
				배송비
				<input type="text" name="TACKBAE_MONEY" value='<?php echo $cfg["pay"]["TACKBAE_MONEY"] ?>' class="w50 agn_r">
				원(,(컴마)없이 숫자로만 입력)
				<br />
				<input type="radio" name="TACKBAE_ALL" value="DISABLE" <?php
					if ($cfg["pay"]["TACKBAE_ALL"] == "DISABLE")
						echo "checked";
				?>>
				배송비 미 적용.
				<br />
				<input type="radio" name="TACKBAE_ALL" value="ENABLE" <?php
					if ($cfg["pay"]["TACKBAE_ALL"] == "ENABLE")
						echo "checked";
				?>>
				상품구매액이
				<input type="text" name="TACKBAE_CUTLINE" value='<?php echo $cfg["pay"]["TACKBAE_CUTLINE"] ?>'  class="w50 agn_r">
				미만일 경우 배송비 적용.
				<br />
				<input type="radio" name="TACKBAE_ALL" value="ALL" <?php
					if ($cfg["pay"]["TACKBAE_ALL"] == "ALL")
						echo "checked";
				?>>
				구매액에 관계없이 배송비적용
				<br />
				<input type="radio" name="TACKBAE_ALL" value="PER" <?php
					if ($cfg["pay"]["TACKBAE_ALL"] == "PER")
						echo "checked";
				?>>
				제품(수)당 배송비적용(
				<input type="checkbox" name="ENABLE_ADD_TACKBAE_MONEY" value='checked' <?php echo $cfg["pay"]["ENABLE_ADD_TACKBAE_MONEY"] ?>>
				기본배송료+추가 수량당
				<input type="text" name="ADD_TACKBAE_MONEY" value='<?php echo $cfg["pay"]["ADD_TACKBAE_MONEY"] ?>' class="w50 agn_r">
				원 추가)
				<br />

				<input type="checkbox" name="ENABLE_EXPRESS_TACKBAE_MONEY" value='checked' <?php echo $cfg["pay"]["ENABLE_EXPRESS_TACKBAE_MONEY"] ?>>
				추가배송료
				<input type="text" name="EXPRESS_TACKBAE_MONEY" value='<?php echo $cfg["pay"]["EXPRESS_TACKBAE_MONEY"] ?>'  class="w50 agn_r">
				(기본배송료에 추가배송료(장바구니에서 사용자 체크시 적용))
				<br />

				<input type="checkbox" name="VAT_ENABLE" value='checked' <?php echo $cfg["pay"]["VAT_ENABLE"] ?>>
				VAT.
				<input type="text" name="VAT_MONEY" value='<?php echo $cfg["pay"]["VAT_MONEY"] ?>'  class="w50 agn_r">
				%포함
				<br />
				VAT.(부가가치세)를
				상품가격과는 별도로 책정하시고 싶으실 경우 상기 박스란에 책크하세요
				<br />
				카드결제가
				및 현금결제가 적용
				<br />
				<input type="radio" name="CARDCHECK_ENABLE" value="SAME" <?php
					if (!strcmp($cfg["pay"]["CARDCHECK_ENABLE"], "SAME"))
						echo "checked";
				?>>
				카드결제가 및 현금결제가 동일적용&nbsp;
				<br />
				<input type="radio" name="CARDCHECK_ENABLE" value="NOTSAME" <?php
					if (!strcmp($cfg["pay"]["CARDCHECK_ENABLE"], "NOTSAME"))
						echo "checked";
				?>>
				카드결제가 및 현금결제가 차등적용&nbsp;

				<br />
				-
				<input type="radio" name="CARDCHECK_RATE" value="CARDCHECK_PER" <?php
					if (!strcmp($cfg["pay"]["CARDCHECK_RATE"], "CARDCHECK_PER"))
						echo "checked";
				?>>
				차등적용시 현금가의
				<input type="text" name="CARDCHECK_RATE_VALUE1" value="<?php echo $cfg["pay"]["CARDCHECK_RATE_VALUE1"] ?>" class="w50 agn_r">
				%적용(소수점사용가능) ( 예)3.5)
				<br />
				-
				<input type="radio" name="CARDCHECK_RATE" value="CARDCHECK_VALUE" <?php
					if (!strcmp($cfg["pay"]["CARDCHECK_RATE"], "CARDCHECK_VALUE"))
						echo "checked";
				?>>
				차등적용시 현금가의
				<input type="text" name="CARDCHECK_RATE_VALUE2" value="<?php echo $cfg["pay"]["CARDCHECK_RATE_VALUE2"] ?>" class="w50 agn_r">
				원적용(",(콤머)"없이, 예)3000)
				<input type="radio" name="CARDCHECK_ENABLE" value="DIRNOTSAME" <?php
					if (!strcmp($cfg["pay"]["CARDCHECK_ENABLE"], "DIRNOTSAME"))
						echo "checked";
				?> />
				분류별 카드결제가 및 현금결제가 차등적용
				<br />
				<input type='radio' name='DIRNOTSAME_METHOD' value='CARDCHECK_RATE' <?php
					if ($cfg["pay"]["DIRNOTSAME_METHOD"] == "CARDCHECK_RATE")
						echo "checked";
				?>>
				현금가의
				<input type='text' name='DIFF_CARD_RATE' value='<?php echo $cfg["pay"]["DIFF_CARD_RATE"] ?>' class="w50 agn_r">
				% 차등적용
				<br />
				<input type='radio' name='DIRNOTSAME_METHOD' value='CARDCHECK_VALUE' <?php
					if ($cfg["pay"]["DIRNOTSAME_METHOD"] == "CARDCHECK_VALUE")
						echo "checked";
				?>>
				현금가의
				<input type='text' name='DIFF_CARD_VALUE'  value='<?php echo $cfg["pay"]["DIFF_CARD_VALUE"] ?>' class="w50 agn_r">
				원 차등적용
				<br />
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">
				카테고리별 결제 옵션
			</div>
			<div class="panel-body">
				<div class="tree">
					<ul>
						<!-- 대분류 리스트 Start -->
						<?php
						/* wizCategory db에 있는 모든 내용을 가져와서 배열처리한다. */
						$sqlstr = "select cat_no, cat_name, cat_price from wizCategory where  cat_flag='wizmall' order by cat_no asc";
						$dbcon -> _query($sqlstr);
						while ($list = $dbcon -> _fetch_array()) :
							$cat_no = "000000000" . $list[cat_no];
							$big_cat = substr($cat_no, -3);
							$mid_cat = substr($cat_no, -6, 3);
							$small_cat = substr($cat_no, -9, 3);
							$cat_name = $list[cat_name];
							$cat_price = $list[cat_price];

							$catArr[$big_cat][$mid_cat][$small_cat][cat_name] = $cat_name;
							$catArr[$big_cat][$mid_cat][$small_cat][cat_price] = $cat_price;
						endwhile;

						if (is_array($catArr)) :
							reset($catArr);

							while (list($key, $value) = each($catArr)) :
								echo "<li>";
								echo "<input type='checkbox' name='cat_price[000000{$key}]' value='checked' " . $catArr[$key]["000"]["000"]["cat_price"] . ">" . $catArr[$key]["000"]["000"]["cat_name"];
								echo "<ul>";
								while (list($key1, $value1) = each($catArr[$key])) :
									if ($key1 != "000") :
										echo "<li>";
										echo "<input type='checkbox' name='cat_price[000{$key1}{$key}]' value='checked' " . $catArr[$key][$key1]["000"]["cat_price"] . ">" . $catArr[$key][$key1]["000"]["cat_name"];
										echo "<ul>";
										while (list($key2, $value2) = each($catArr[$key][$key1])) :
											if ($key2 != "000") :
												echo "<li>";
												echo "<input type='checkbox' name='cat_price[{$key2}{$key1}{$key}]' value='checked' " . $catArr[$key][$key1][$key2]["cat_price"] . ">" . $catArr[$key][$key1][$key2]["cat_name"];
												echo "</li>";
											endif;
										endwhile;
										echo "</ul>";
										echo "</li>";
									endif;
								endwhile;
								echo "</ul>";
								echo "</li>";
							endwhile;
						endif;
						?>
						<!-- 대분류 리스트 End -->
					</ul>
				</div><!-- tree -->
			</div>
		</div>

	</form>
	<div class="text-center">
		<button type="button" class="btn btn-primary btn_save">
			변경
		</button>
	</div>
</div>
