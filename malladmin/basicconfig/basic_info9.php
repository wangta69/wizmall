<?php
/*
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 

Copyright shop-wiz.com
수정일 및 수정 내용
*/
?>
<script language='javascript' type="text/javascript">
<!--
$(function(){
	//카테고리별 상품수 초기화
	$("#btn_reset_category").click(function(){
		$.post("./basicconfig/basic_dynamic.php?flag=1", {}, function(data){
			eval("var obj="+data);
			if(obj.result == "0"){
				jAlert("초기화 되었습니다.");
			}
		});
	});
	
	$("#btn_open_devery").click(function(){
		wizwindow("./basicconfig/basic_info_delivery.php", 'DeliveryWindow', 'width=600, height=500');
	});

	$("#btn_open_product_option").click(function(){
		wizwindow("./basicconfig/basic_info_option.php", 'OptionWindow', 'width=600, height=500');
	});
});	
	//-->
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">위즈몰설정초기화</div>
	  <div class="panel-body">
		 다양한 db의 설정을 초기화 하실 수 있습니다.
	  </div>
	</div>
	
	<form name=install action='<? ECHO "$PHP_SELF";?>' method='post' onSubmit='return install_check();'>
				<input type='hidden' name='menushow' value='<?=$menushow?>'>
				<input type="hidden" name="theme" value=<?=$theme;?>>
				<input type="hidden" name=action value='write'>
				<table class="table">
					<!-------------- 메인화면 스킨 시작 ----------------------------------------------------------------------------------->
					<tr>
						<th class="active">카테고리별상품수초기화</th>
						<td>
							<button type="button" class="btn btn-default" id="btn_reset_category">초기화</button>
					
							카테고리당 상품의 수를 초기화 매칭시켜줍니다.
						</td>
					</tr>
					<tr>
						<th class="active">택배사관리</th>
						<td>
							<button type="button" class="btn btn-default" id="btn_open_devery">관리</button>
						</td>
					</tr>
					<tr>
						<th class="active">옵션관리</th>
						<td>
							<button type="button" class="btn btn-default" id="btn_open_product_option">관리</button>
						</td>
					</tr>
				</table>
			</form>
</div>
