<?
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
- http://www.shop-wiz.com
Copyright shop-wiz.com
*** Updating List ***
*/
$all	= $cfg["admin"]["MART_BASEDIR"]."/skinwiz/inshop/naver/all.php";
$brief	= $cfg["admin"]["MART_BASEDIR"]."/skinwiz/inshop/naver/brief.php";
$new	= $cfg["admin"]["MART_BASEDIR"]."/skinwiz/inshop/naver/new.php";
?>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">네이버 입점</div>
	  <div class="panel-body">
		 네이버 입점시 경로입니다.
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
						<p></p>	
      <table class="table">
       
          <tr>
            <td colspan=2>네이버 입점 경로</td>
          </tr>
          <tr>
            <td>전체상품리스트</td>
            <td>&nbsp;<a  href="<?=$all?>" target="_blank"><?=$all?></a></td>
          </tr>
          <tr>
            <td>상품상세보기</td>
            <td>&nbsp;<a  href="<?=$brief?>" target="_blank"><?=$brief?></a></td>
          </tr>
          <tr>
            <td>신규제품보기</td>
            <td>&nbsp;<a  href="<?=$new?>" target="_blank"><?=$new?></a></td>
          </tr>          			    
      </table>
      <br />
    </td>
  </tr>
</table>
