<?
/*
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***

*/

if($query == "qin"){
	##기존 모든 정보 삭제
	$sqlstr = "delete from wizUsercoupon where couponid='$uid' and useflag=0";
	$dbcon->_query($sqlstr);
	
	#현재 정보를 입력한다.
	if(is_array($m_ids)){
		foreach($m_ids as $key => $value){
			$sqlstr = "insert into wizUsercoupon (userid,couponid,gdate) values ('$value','$uid',".time().")";
			$dbcon->_query($sqlstr);
		}
	}
}else if($query == "qde"){
	$sqlstr = "delete from wizUsercoupon where uid='$cuid'";
	$dbcon->_query($sqlstr);
	echo "<script>location.href='$PHP_SELF?menushow=$menushow&theme=coupon/coupon_list'</script>";
}
?>
<script language="javascript">
<!--
function del_cp(uid){
	if(confirm('삭제된 데이타는 복구되지 않습니다.\n\n정말로 삭제하시겠습니까?')){
		location.href = "<?=$PHP_SELF;?>?menushow=<?=$menushow?>&theme=<?=$theme;?>&query=qde&cuid="+uid;
	}else return;
}

function gotoList(){
	location.href = "<?=$PHP_SELF;?>?menushow=<?=$menushow?>&theme=coupon/coupon_list";
}

function del_options(el)
{
	idx = el.rowIndex;
	var obj = document.getElementById('m_ids');
	obj.deleteRow(idx);
}

function checkform1(f){

	calSmsCnt();

	if(f.membertype[1].checked == true){
		if(!document.getElementsByName('m_ids[]').length){
			alert('회원을 선택해주세요!!');
			return false;
		}
	}
	return true;
}


var sgrp = new Array();
sgrp[1] = 0;
sgrp[2] = 1;
var tot_mem = 1;
function calSmsCnt(){
	var f = document.MemberSelectForm;
	if(f.membertype[0].checked)	var tt = tot_mem;

	if(f.membertype[1].checked) var tt = document.getElementsByName('m_ids[]').length;
}

function delApply(sno){
	var f = document.hiddenform;
	f.mode.value = "delApply";
	f.action = "indb.coupon.php?couponcd=3&sno="+sno;
	f.submit();
}
//-->
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">회원발급하기</div>
	  <div class="panel-body">
		 삭제버튼을 클릭하면 해당 회원에게 발급된쿠폰이 취소됩니다.<br />
                  '쿠폰사용완료'란 해당 회원이 이미 쿠폰을 사용하여 완료됨을 의미합니다.
	  </div>
	</div>
</div>tline">
  <tr>
    <td>
						<p></p>	
      쿠폰발급/조회<span>쿠폰을 직접 발급하고 관리할 수 있습니다.<br />
      <div style="padding:3 0 5 8">쿠폰발급내용</div>
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
      <p> 이 쿠폰을 발급받은 회원리스트 (삭제버튼을 클릭하면 해당 회원에게 발급된 쿠폰이 취소됩니다)<br />
      <table>
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
      </table>
      <p> 이 쿠폰을 제공할 회원선택 (쿠폰을 지급할 회원을 추가하려면 아래에서 회원을 선택하세요)<br />
      <table class="table">
        <form name="MemberSelectForm">
          <input type="hidden" name="uid" value="<?=$uid;?>" />
          <input type="hidden" name="menushow" value="<?=$menushow;?>" />
          <input type="hidden" name="theme" value="<?=$theme;?>" />
          <input type="hidden" name="query" value="qin" />
          <tr>
            <td><input type="radio" name=membertype value=0 checked onclick='calSmsCnt();'>
              전체회원발급</td>
            <td>전체회원에게 쿠폰을 발급합니다.</td>
          </tr>
          <tr>
            <td><input type="radio" name=membertype value=2 onclick='calSmsCnt();' >
              회원개별발급</td>
            <td><div style="padding-top:4"><a href="javascript:memberSearch()">[회원검색]</a></div>
              <div class="box" style="padding:10 0 0 10">
                <table  cellpadding=8 id=m_ids style="border-collapse:collapse">
                </table>
              </div></td>
          </tr>
          <tr>
            <td colspan="2" ><input type="submit" name="button2" id="button2" value="등록" />
              <input type="button" name="Button" id="button3" value="이전" onclick="gotoList()" style="cursor:pointer" /></td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
