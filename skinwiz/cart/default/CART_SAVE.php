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
	function Cartfun(flag, code){
		var f = document.cart_list_form;//CART_VEIW.php에 있는 form 
		switch(flag){
			case (1)://장바구니 비우기
				if (confirm('\n\n정말로 장바구니를 모두 비우시겠습니까?\n\n')){
					location.href = "./wizbag.php?query=trash&op=<?=$op?>";
				}else return;
			break;
			case (2)://쇼핑계속하기
					if (code) location.href = "./wizmart.php?code="+code+"&op=<?=$op?>";
					else location.href = "./?op=<?=$op?>";
			break;	
			case (3)://회원구매
				location.href = "./wizbag.php?query=step1&op=<?=$op?>";
			break;	
			case (4)://비회원구매
				location.href = "./wizbag.php?query=step2&op=<?=$op?>";
			break;									
		}
	
	}

	function alertcheck(f){
		if(getcheckcnt(f) < 1){//wizmall.js에 있는 공통 함수
			alert('구매하실 상품을 하나 이상 선택해 주세요');
			return false;
		}else return true;
	} 	
</script>
<ul class="breadcrumb">
  <li><a href="./">Home</a></li>
  <li class="active">주문 장바구니</li>
</ul>
<div class="panel">
	장바구니
  
	<div class="panel-footer">
		상품 수량을 조정하시면 각 상품별 소계 금액과 총액 금액이 자동으로 계산됩니다.<br />
			모드 선택이 끝나셨으면 &quot;바로 
			구매하기&quot;를 클릭해 주세요.<br />
			다른 상품을 더 구매하시려면 &quot;쇼핑 
			계속하기&quot;를 클릭해 주세요
	</div>
</div>

<?php
// 장바구니 보기
include "./skinwiz/cart/".$cfg["skin"]["CartSkin"]."/CART_VIEW.php";

?>
<div class="space15"></div>
	<div class="btn_box"><?php if ($TOTAL_MONEY) :?>
			<a href='javascript:Cartfun(1)'><img src='./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]?>/images/but_draw.gif' alt="장바구니 비우기"></a>
			<?php endif;?>
			<a href="javascript:Cartfun(2,'<?php echo $Category?>')"><img src='./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]?>/images/but_shopping.gif' alt="쇼핑계속하기"></a>
			<?php if ($TOTAL_MONEY) :?>
			<a href='javascript:Cartfun(3)'><img src='./skinwiz/cart/<?php echo $cfg["skin"]["CartSkin"]?>/images/but_member.gif' alt="구매하기"></a>
			<!-- <a href='javascript:Cartfun(4)'><img src='./skinwiz/cart/<?=$cfg["skin"]["CartSkin"]?>/images/but_customer.gif' alt="비회원구매"></a>-->
			<?php endif;?>
		</div>
