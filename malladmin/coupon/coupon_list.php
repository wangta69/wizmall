<?
/*
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***

*/

if ($query == "qde") {// 삭제하기
	//이미 발급된 쿠폰에 대해 삭제하기를 할 경우 문제가 발생 
	// 발급수 조회후 절차에 따라서 해야 한다.
	//따라서 이후는 업데이트 형식으로 해야 한다.
	// 현재는 걍 ...
	$sqlstr = "delete from wizCoupon where uid = '$uid'";
	$dbcon->_query($sqlstr);
	
	$sqlstr = "delete from wizCouponapply where couponid = '$uid'"; 
	$dbcon->_query($sqlstr);
}


$whereis = "WHERE 1";
$orderby = " order by uid desc";


if($searchEnable){//검색절 시작
	if($sword){
		if($skey) $whereis .= " and $skey like '%$sword%'";
		else $whereis .= " and cname like '%$sword%' or cdesc like '%$sword%' ";
	}
	
	if(is_array($s_ctype)){
		$whereis .= " and (";
		$cnt=0;
		foreach($s_ctype as $key => $value){
			if($cnt) $whereis.= " or ";
			$whereis .= " ctype = '$value'";
			$cnt++;
		}
		$whereis .= ")";
	}
	
	if(is_array($s_cpubtype)){
		$whereis .= " and (";
		$cnt=0;	
		foreach($s_cpubtype as $key => $value){
			if($cnt) $whereis.= " or ";
			$whereis .= " cpubtype = '$value'";
			$cnt++;
		}
		$whereis .= ")";
	}	
}

/* 페이징과 관련된 수식 구하기 */
if(empty($ListNo)) $ListNo = "15";
$PageNo = "20";
if(empty($CP) || $CP <= 0) $CP = 1;
$START_NO = ($CP - 1) * $ListNo;
$TOTAL_STR = "SELECT count(*) FROM wizCoupon ";
$REALTOTAL = $dbcon->get_one($TOTAL_STR);

$sqlstr = "SELECT count(*) FROM wizCoupon $whereis";
$TOTAL = $dbcon->get_one($sqlstr);

//--페이지 나타내기--
$TP = ceil($TOTAL / $ListNo) ; /* 페이지 하단의 총 페이지수 */
$CB = ceil($CP / $PageNo);
$SP = ($CB - 1) * $PageNo + 1;
$EP = ($CB * $PageNo);
$TB = ceil($TP / $PageNo);

//--페이지링크를 작성하기--
$sqlstr = "SELECT * FROM wizCoupon $whereis $orderby LIMIT $START_NO,$ListNo";
//echo "sqlstr = $sqlstr <br />";
$dbcon->_query($sqlstr) or(mysql_error()."<br />".$sqlstr);
?>
<script>
$(function(){
	$(".btn_write").click(function(){
		var uid = $(this).attr("uid");
		if(uid == undefined) uid = "";
		location.href = "main.asp?menushow=<%=menushow%>&theme=coupon/coupon_write&uid="+uid;
	});
});

function gotoWrite(uid){
	if(uid == undefined){
		var uid = "";
	}
	location.href = "<?=$PHP_SELF;?>?menushow=<?=$menushow;?>&theme=coupon/coupon_write&uid="+uid;
}

function gotocoponManage(uid){
	if(uid == undefined){
		var uid = "";
	}
	location.href = "<?=$PHP_SELF;?>?menushow=<?=$menushow;?>&theme=coupon/coupon_write_manage&uid="+uid;
}

function gotocoponview(uid){
	if(uid == undefined){
		var uid = "";
	}
	location.href = "<?=$PHP_SELF;?>?menushow=<?=$menushow;?>&theme=coupon/coupon_view&uid="+uid;
}

function delCoupon(uid){
	if(confirm('삭제된 데이타타는 복구되지 않습니다.\n정말로 삭제하시겠습니까?')){
		location.href = "<?=$PHP_SELF;?>?query=qde&menushow=<?=$menushow;?>&theme=<?=$theme;?>&uid="+uid;
	}else{
	
	}
}

function searchthis(f){
	f.searchEnable.value = "1";
	f.submit();
}

function gotoList(){
	location.href = "<?=$PHP_SELF;?>?menushow=<?=$menushow;?>&theme=<?=$theme;?>";
}

function gotoPage(cp){
	$("#cp").val(cp);
	$("#sform").submit();
}
</script>

<form id="sform">
	<input type='hidden' name='menushow' value='<?=$menushow?>'>
	<input type="hidden" name="theme"  value='<?=$theme?>'>
	<input type="hidden" name="cp" id="cp"  value='<? echo $cp?>' >
</form>

<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">쿠폰리스트</div>
	  <div class="panel-body">
		 즉시발급쿠폰의 경우는 '발급하기'를 클릭하여 직접 회원에게 발급해야 합니다.<br />
                  자동으로 발급되는 쿠폰들은 '조회하기'를 누르면 쿠폰발급내용과 발급받은 회원을 조회할 수 있습니다.
	  </div>
	</div>
</div>
<table class="table_outline">
  <tr>
    <td>
						<p></p>	
      <table>
        <tr>
          <td style="padding-left:12px"> 쿠폰리스트<span>고객에게 발급된 쿠폰을 관리하거나 쿠폰을 발급합니다.
            <table class="table">
              <form method="post" action="<?=$PHP_SELF;?>" name="searchForm">
                <input type="hidden" name="menushow" value="<?=$menushow;?>" />
                <input type="hidden" name="theme" value="<?=$theme;?>" />
                <input type="hidden" name="CP" value="<?=$CP;?>" />
                <input type="hidden" name="searchEnable" value="" />
                <tr>
                  <td>쿠폰검색</td>
                  <td><select name=skey>
                      <option value="">전체검색</option>
                      <option value="cname"<? if($skey == "cname") echo " selected";?>> 쿠폰명</option>
                      <option value="cdesc"<? if($cdesc == "cname") echo " selected";?>> 쿠폰설명</option>
                    </select>
                    <input type=text name=sword value="<?=$sword;?>">
                  </td>
                  <td>쿠폰기능</td>
                  <td><input type="checkbox" name='s_ctype[]' value='1'<? if($common->checkStatus("1", $s_ctype)) echo " checked";?>>
                    할인
                    <input type="checkbox" name='s_ctype[]' value='2'<? if($common->checkStatus("2", $s_ctype)) echo " checked";?>>
                    적립 </td>
                </tr>
                <tr>
                  <td>쿠폰발급방식</td>
                  <td colspan=3><input type="checkbox" name='s_cpubtype[]' value='1'<? if($common->checkStatus("1", $s_cpubtype)) echo " checked";?>>
                    운영자발급
                    <input type="checkbox" name='s_cpubtype[]' value='2'<? if($common->checkStatus("2", $s_cpubtype)) echo " checked";?>>
                    회원직접다운로드
                    <input type="checkbox" name='s_cpubtype[]' value='3'<? if($common->checkStatus("3", $s_cpubtype)) echo " checked";?>>
                    회원가입자동발급
                    <input type="checkbox" name='s_cpubtype[]' value='4'<? if($common->checkStatus("4", $s_cpubtype)) echo " checked";?>>
                    구매후 자동발급 </td>
                </tr>
                <tr>
                  <td colspan="4"><input type="button" name="button2" id="button2" value="검색" onclick="searchthis(document.searchForm)" style="cursor:pointer">
                   &nbsp; 
                  <input type="button" name="button4" id="button4" value="리스트" onclick="gotoList()" style="cursor:pointer" /></td>
                </tr>
              </form>
            </table>
            <br />
            <table>
              <tr>
                <td><input type="button" name="button3" id="button3" value="쿠폰만들기" onclick="gotoWrite()" /></td>
              </tr>
            </table>
            <table class="table table-hover table-striped">
              <tr class="success">
                <th>번호</th>
                <th>쿠폰명</th>
                <th>쿠폰종류</th>
                <th>쿠폰생성일</th>
                <th>기능</th>
                <th>할인금액(율)</th>
                <th>적용기간</th>
                <th>발급/조회(발급수)</th>
                <th>수정/삭제</th>
              </tr>
              <?
$NO = $TOTAL-($ListNo*($CP-1));	
while( $list = $dbcon->_fetch_array( ) ) :
$uid				= $list["uid"];
$cname				= $list["cname"];
//$cdesc				= $list[""];
$cpubtype			= $list["cpubtype"];
//$cpubdowncnt		= $list[""];
//$cpubapplyall		= $list[""];
//$cpubapplycontinue	= $list[""];
$ctype				= $list["ctype"];
$csaleprice			= $list["csaleprice"];
$csaletype			= $list["csaletype"];
//$capplytype			= $list[""];
//$capplycategory		= $list[""];
//$capplyproduct		= $list[""];
//$cimg				= $list[""];
$ctermtype			= $list["ctermtype"];
$cterm				= $list["cterm"];
$ctermf				= $list["ctermf"];
$cterme				= $list["cterme"];
$crestric			= $list[""];
$wdate				= $list["wdate"];

switch($cpubtype){
	case "1"://운영자발급
		$btn_str = "<input type='button' name='button' id='button' value='회원발급하기' onClick='gotocoponManage(".$uid.")'>";
	break;
	default:
		$btn_str = "<input type='button' name='button' id='button' value='발급내용보기' onClick='gotocoponview(".$uid.")'>";
	break;
}


switch($ctermtype){
	case "1"://시작일, 종료일
		$ctermstr = date("Y.m.d H:i", $ctermf)."<br />~".date("Y.m.d H:i", $cterme);
	break;
	case "2"://기간설정
		$ctermstr = "발급 후 ".$cterm."일";
	break;
}


?>
              <tr>
                <td><?=$NO?></td>
                <td><?=$cname?></td>
                <td><?=$cpubtypeArr[$cpubtype]?></td>
                <td><?=date("Y.m.d H:i:s", $wdate)?></td>
                <td><?=$ctypeArr[$ctype]?></td>
                <td><?=$csaleprice?>
                <?=$csaletypeArr[$csaletype]?></td>
                <td style="word-break:break-all;"><?=$ctermstr?></td>
                <td><?=$btn_str?>
                  (
                  <?=$mall->getCouponCnt($uid);?>
                  )</td>
                <td><input type="button" name="button" id="button" value="수정" onclick="gotoWrite(<?=$uid?>)" style="cursor:pointer">
                  <input type="button" name="button" id="button" value="삭제" onclick="delCoupon(<?=$uid?>)" style="cursor:pointer">
                </td>
              </tr>
              <?
$NO--; 
endwhile;
?>
            </table>

            </form>
            
	<div class="text-center">
<?php
$params = array("listno"=>$ListNo,"pageno"=>$PageNo,"cp"=>$cp,"total"=>$TOTAL, "type"=>"bootstrappost"); 
echo $common->paging($params);
?>
	</div>
	            </td>
        </tr>
      </table>
      <br />
       </td>
  </tr>
</table>
