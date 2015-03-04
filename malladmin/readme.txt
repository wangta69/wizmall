## 일반적인 인크루드
include "./lib/inc.depth0.php";

## 방문자 통계 인크루드
include "./util/wizcount/counterinsert.php";

방문자수 가져오기
include "./util/wizcount/wizcounter.php";

## 팝업 인크루드
include "./util/wizpopup/popinsert.php";


## 공지사항
<?php
$bid = "board01";
$gid = "root";
$tb_name="wizTable_${gid}_${bid}";
$sqlstr = "select UID, SUBJECT, UPDIR1, W_DATE from $tb_name where THREAD = 'A' order by UID desc limit 0, 4";
$sqlqry = $dbcon->_query($sqlstr);
while($list = $dbcon->_fetch_array($sqlqry)):
extract($list);
$SUBJECT = $common->strCutting($SUBJECT, 25);
$newIcon = ($W_DATE > time()-60*60*24) ?'경로':'';

//$filepath = "./config/wizboard/table/".$UpdirPath."/updir/".$list["UID"]."/";

?>
<!-- 이미지 경로 가져올 경우 <img src="<?=$common->getthumbimg($filepath, $list["UPDIR1"], 86, 86) ?>" width="86" height="86"> //-->
<a href="wizboard.php?BID=<?=$bid?>&GID=<?=$gid;?>&UID=<?=$UID?>&mode=view"><?php echo $SUBJECT?></a><?=date("Y-m-d", $W_DATE)?>
<?php
endwhile;
?>



## 겔러리
<?php
$bid = "board04";
$gid = "root";
$tb_name="wizTable_${gid}_${bid}";
$sqlstr = "select UID, SUBJECT, UPDIR1, W_DATE from $tb_name where THREAD = 'A' order by UID desc limit 0, 6";
$sqlqry = $dbcon->_query($sqlstr);
$cnt = 0;
while($list = $dbcon->_fetch_array($sqlqry)):
extract($list);
$SUBJECT = $common->strCutting($SUBJECT, 25);
$newIcon = ($W_DATE > time()-60*60*24) ?"경로":"";

//$filepath = "./config/wizboard/table/".$gid."/".$bid."/updir/".$list["UID"]."/".$list["UPDIR1"];
$filepath = "./config/wizboard/table/".$gid."/".$bid."/updir/".$list["UID"]."/";
?>	  
	  <a href="wizboard.php?BID=<?=$bid?>&GID=<?=$gid;?>&UID=<?=$UID?>&mode=view"><img src="<?=$common->getthumbimg($filepath, $list["UPDIR1"], 116, 80) ?>" width="65" height="50"></a>
<?php
$cnt++;
if(!($cnt % 3)) echo "</div><div class='thumnail'>";
endwhile;
?>




category

솔루션이 아니라 일반적인 페이지에서 $cfg["member"]를 호출하기 위해서는 아래와 같은 선작업을 하여야 합니다.



<?php
include_once $DOCUMENT_ROOT."/lib/class.common.php";
$common = new common();
$common->cfg=$cfg;
$common->pub_path = $DOCUMENT_ROOT."/";
$cfg["member"] = $common->getLogininfo();//로그인 정보를 가져옮
?>


<?php
if ($cfg["member"]) : //로그인상태이면
//$cfg["member"]["mid"]
//$cfg["member"]["mpasswd"]
//$cfg["member"]["mname"]
//$cfg["member"]["mgrade"]
//$cfg["member"]["mgrantsta"]
//$cfg["member"]["mlogindate"]
//$cfg["member"]["mpoint"]
//$cfg["member"]["mpointlogindate"]
//$cfg["member"]["adult"]
//$cfg["member"]["gender"]
?>
   <p> <?=$cfg["member"]["mname"]?>
    님이 로그인 중입니다.    </p>
  <p>포인트 :
    <?=number_format($cfg["member"]["mpoint"])?>
    최근방문일 :
    <? if($cfg["member"]["mlogindate"]) echo date("Y.m.d", $cfg["member"]["mlogindate"]); else echo 0; ?>
  </p>
  <a href="wizmember.php?query=logout">로그아웃</a> <a href="wizmember.php?query=info">정보변경</a>
<?php
else : // 로그인안된상태이면
?>
<script>

function LoginCheckForm(f){
	if(f.wizmemberID.value == ''){
		alert('ID를 입력해주세요');
		f.wizmemberID.focus();
		return false;
	} else if(f.wizmemberPWD.value == ''){
		alert('패스워드를 입력하세요');
		f.wizmemberPWD.focus();
		return false;
	} else{//ajax 처리
		var userid = f.wizmemberID.value;
		var userpwd = f.wizmemberPWD.value;
		if(f.saveflag != undefined) var saveflag = f.saveflag.value;
		$.post("../lib/ajax.member.php", {smode:"login_check",wizmemberID:userid,wizmemberPWD:userpwd,saveflag:saveflag}, function (data){
			eval("var obj = "+data);
			if(obj["result"] == "1"){
				alert(obj["msg"]);
			}else location.reload();
		});
		return false;
	}
}
</script>
  <form action='./wizmember/LOG_CHECK.php' method="post" name=LoginCheck onsubmit='return LoginCheckForm(this);'>
      <input type="hidden" name="action" value="login_check">
      <input type="hidden" name="log_from" value="<?php echo $_SERVER["REQUEST_URI"];?>">
      <p>
	  <img src="./skinwiz/layout/<? echo $cfg["skin"]["LayoutSkin"];?>/images/id_txt.gif" width="32" height="22">
      <input name="wizmemberID" type="text" id="wizmemberID" size="21" tabindex="1">
</p><p>
      <img src="./skinwiz/layout/<? echo $cfg["skin"]["LayoutSkin"];?>/images/pwd_txt.gif" width="32" height="22">
      <input name="wizmemberPWD" type="password" id="wizmemberPWD" size="21" tabindex="2"  autocomplete="off">
	  </p>
      <input type="image" src="./skinwiz/layout/<? echo $cfg["skin"]["LayoutSkin"];?>/images/login_btn.gif" width="137" height="18">
  
    <p><a href="wizmember.php?query=regis_step1"><img src="./skinwiz/layout/<? echo $cfg["skin"]["LayoutSkin"];?>/images/member_reg_btn.gif" width="69" height="18" hspace="3" border="0" align="absmiddle"></a><a href="wizmember.php?query=idsearch"><img src="./skinwiz/layout/<? echo $cfg["skin"]["LayoutSkin"];?>/images/idpasssearch_btn.gif" width="85" height="18" vspace="3" border="0" align="absmiddle"></a>
    </p>
  </form>
<?php endif; ?>
  
  
  각종 링크
unset($status); /* 로그인과 이후 혹은 query 값에 대한 다양한 결과가 요구되므로 $status의 상황에 따라 각각 행동 반경을 정한다. */

포인트 보기 : wizmember.php?query=point
주문정보보기 : wizmember.php?query=order'

회원정보수정시 먼저 패스워드 한번더 확인 : wizmember.php?query=infopass

회원정보보기 : wizmember.php?query=info
로그인 : wizmember.php?query=login
로그아웃  : wizmember.php?query=logout
혹은 직업링크 wizmember/LOG_OUT.php
위시리스트 : wizmember.php?query=wish
마이페이지 : wizmember.php?query=mypage

일정관리 view  : wizmember.php?query=logmanage
일정관리 리스트  : wizmember.php?query=logmanage_list
일정관리 기  : wizmember.php?query=logmanage_write

오늘본상품 : wizmember.php?query=clickpd
쿠폰페이지 : wizmember.php?query=mycoupon

회원탈퇴 : wizmember.php?query=out

회원가입추가입력 : wizmember.php?query=regismore
정보변경(패스워드만 변경) wizmember.php?query=chpass
패스워드 찾기 wizmember.php?query=passsearch
아이디찾기 : wizmember.php?query=idsearch
아이디패스워드찾기 : wizmember.php?query=idpasssearch

회원가입1단계 : wizmember.php?query=regis_step1
비회원 주문정보 : wizmember.php?query=non_member_order
