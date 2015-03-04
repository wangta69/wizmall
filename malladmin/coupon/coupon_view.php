<?
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***

*/

if($query == "qde"){
	$sqlstr = "delete from wizUsercoupon where uid='$cuid'";
	$dbcon->_query($sqlstr);
	echo "<script>location.href='$PHP_SELF?menushow=$menushow&theme=coupon/coupon_list'</script>";
}
?>
<script language=JavaScript>
<!--
function del_cp(uid){
	if(confirm('삭제된 데이타는 복구되지 않습니다.\n\n정말로 삭제하시겠습니까?')){
		location.href = "<?=$PHP_SELF;?>?menushow=<?=$menushow?>&theme=<?=$theme;?>&query=qde&cuid="+uid;
	}else return;
}
//-->	
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">발급내용보기</div>
	  <div class="panel-body">
		 삭제버튼을 클릭하면 해당 회원에게 발급된쿠폰이 취소됩니다.<br />
                  '쿠폰사용완료'란 해당 회원이 이미 쿠폰을 사용하여 완료됨을 의미합니다.
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
						<p></p>	
      쿠폰발급/조회 쿠폰을 직접 발급하고 관리할 수 있습니다.<br />
      쿠폰발급내용
      <?      
$whereis = "WHERE uid = $uid";
$orderby = " order by uid desc";

$sqlstr = "SELECT * FROM wizCoupon $whereis";
$dbcon->_query($sqlstr);      

$list = $dbcon->_fetch_array( );
$uid				= $list["uid"];
$cname				= $list["cname"];
$cpubtype			= $list["cpubtype"];
$ctype				= $list["ctype"];
$csaleprice			= $list["csaleprice"];
$csaletype			= $list["csaletype"];
$ctermtype			= $list["ctermtype"];
$cterm				= $list["cterm"];
$ctermf				= $list["ctermf"];
$cterme				= $list["cterme"];
$crestric			= $list[""];
$wdate				= $list["wdate"];

switch($ctermtype){
	case "1"://시작일, 종료일
		$ctermstr = date("Y.m.d H:i", $ctermf)."<br />~".date("Y.m.d H:i", $cterme);
	break;
	case "2"://기간설정
		$ctermstr = "발급 후 ".$cterm."일";
	break;
}
?>
      <table class="table">
        <tr>
          <td>쿠폰명</td>
          <td>쿠폰발급방식</td>
          <td>생성일</td>
          <td>할인금액(율)</td>
          <td>사용기간</td>
          <td>기능</td>
        </tr>
        <tr>
          <td><a href="<?=$PHP_SELF?>?menushow=<?=$menushow;?>&theme=coupon/coupon_write&uid=<?=$uid?>">
            <?=$cname?>
            </a> </td>
          <td><?=$cpubtypeArr[$cpubtype]?></td>
          <td><?=date("Y.m.d H:i:s", $wdate)?></td>
          <td><?=$csaleprice?>
            <?=$csaletypeArr[$csaletype]?></td>
          <td><?=$ctermstr?></td>
          <td><?=$ctypeArr[$ctype]?></td>
        </tr>
      </table>
      <p> 이 쿠폰을 발급받은 회원리스트 (삭제버튼을 클릭하면 해당 회원에게 발급된 쿠폰이 취소됩니다)<br /><table class="table">
        <tr>
          <td>순번</td>
          <td>발급 상품</td>
          <td>발급받은 회원</td>
          <td>발급일/사용일</td>
          <td>삭제</td>
        </tr>
        <?
$sqlstr = "select * from wizUsercoupon where couponid = '$uid'";
$dbcon->_query($sqlstr);
$cnt = 1;
while($list = $dbcon->_fetch_array()):		
		?>
        <tr>
          <td><?=$cnt;?></td>
          <td><?=$cname?></td>
          <td><?=$list["userid"];?></td>
          <td><? if($list["gdate"]) echo date("Y.m.d H:i", $list["gdate"]);?>
            /
            <? if($list["udate"]) echo date("Y.m.d H:i", $list["udate"]);?></td>
          <td><input type="button" name="button" id="button" value="삭제" onclick="del_cp(<?=$list["uid"];?>)"></td>
        </tr>
        <?
$cnt++;		
endwhile;		
		?>
      </table></td>
  </tr>
</table>
