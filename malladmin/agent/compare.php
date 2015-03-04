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
$compare	= $cfg["admin"]["MART_BASEDIR"]."/skinwiz/inshop/etc/list.php";
?>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">가격비교사이트</div>
	  <div class="panel-body">
		 가격비교사이트 경로입니다.
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
						<p></p>	
      <table class="table">
       
          <tr>
            <td colspan=2>가격비교사이트 경로</td>
          </tr>
          <tr>
            <th>베스트바이어</th>
            <td><a  href="<?=$compare?>?com=bestbuyer" target="_blank"><?=$compare?>?com=bestbuyer</a></td>
          </tr>
          <tr>
            <th>다나와</th>
            <td><a  href="<?=$compare?>?com=danawa" target="_blank"><?=$compare?>?com=danawa</a></td>
          </tr>
          <tr>
            <th>엠파스</th>
            <td><a  href="<?=$compare?>?com=empas" target="_blank"><?=$compare?>?com=empas</a></td>
          </tr>          			    
      </table>
      <br />
    </td>
  </tr>
</table>
