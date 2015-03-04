<?php
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
?>

<?php echo $mall->getNavy($code, $optionvalue);//상단 navy 가져오기?>

 
<table class="m_cat">
  <tr>
    <td><?php echo $mall->Regoption?> 상품</td>
    <td></td>
  </tr>
</table>
<?php
include ("./skinwiz/shop/".$cfg["skin"]["ShopSkin"]."/list_product.php");
?>