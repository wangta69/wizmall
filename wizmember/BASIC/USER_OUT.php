<?
/*
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/
$mid = $cfg["member"]["mid"];
if($mode=="ok"){
	$sqlstr="SELECT mpasswd, jumin1, jumin2 FROM wizMembers m left join wizMembers_ind i on m.mid = i.id WHERE mid='".$mid."'";
	$dbcon->_query($sqlstr);
	$list = $dbcon->_fetch_array();
	$mpasswd	= $list["mpasswd"];
	$jumin1		= $list["jumin1"];
	$jumin2		= $list["jumin2"];
	
	if(trim($mpasswd) != $common->mksqlpwd(trim($userPass))){
		$common->js_alert("\\n\\n패스워드가 일치하지 않습니다.\\n\\n 다시 한 번 책크해주세요\\n", "./wizmember.php?query=out");
	}else if(trim($jumin1) != trim($userJumin1) || trim($jumin2) != trim($userJumin2)){
		$common->js_alert("\\n\\n주민등록번호가 일치하지 않습니다.\\n\\n 다시 한 번 책크해주세요\\n", "./wizmember.php?query=out");
	}else{
		$sqlstr = "UPDATE wizMembers SET mgrantsta ='00' WHERE mid ='".$mid."' "; 
		$dbcon->_query($sqlstr);
		
		$sqlstr = "insert into wizMembers_withdrawal (wid,wname,wtype,wgrade,wreason,wdate,content) 
		values 
		('$mid','$wname','$wtype','$wgrade','$wreason',".time().",'$content')"; 
		$dbcon->_query($sqlstr);	
		
		if (is_file("../config/wizmember_tmp/login_user/".$_COOKIE["usersession"])){
			unlink("../config/wizmember_tmp/login_user/".$_COOKIE["usersession"]);
		}
		if (is_file("../config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE"])){
			unlink("../config/wizmember_tmp/mall_buyers/".$_COOKIE["CART_CODE"]);
		}
		setcookie("usersession", "", 0, "/");
		$common->js_alert("\\n 탈퇴가 정상적으로 처리 되었습니다.\\n그동안 이용해 주셨어 감사합니다.", "./");
	}
}
?>
<script language="javascript" src="./js/wizmall.js"></script>
<script language = "javascript">
<!--
function MemberCheckField(f){
	var cnt = getcheckcnt(f);
	if(f.userPass.value.length ==""){
		alert("패스워드를 입력해주세요");
		f.userPass.focus();
		return false;
	}else if(f.userJumin1.value == ""){
		alert("주민번호를 입력해 주세요");
		f.userJumin1.focus();
		return false;
	}else if(f.userJumin2.value == ""){
		alert("주민번호를 입력해 주세요");
		f.userJumin2.focus();
		return false;
	}else if(cnt>3){
		alert("최대 3개까지 책크가능합니다.");
		f.userPass.focus();
		return false;
	}else if (confirm('\n입력하신 모든 값들이 정말로 정확합니까?\n')) return true;
	return false;
}

//-->
</script>

<div class="navy">Home &gt; 회원탈퇴</div>
<fieldset class="desc">
<legend>[안내]</legend>
<div class="notice">회원탈퇴</div>
<div class="comment">
회원님꼐서 탈퇴하시더라도 회원님의 개인정보는 안전하게 처리됩니다.<br />
탈퇴후 아이디는 재 사용될 수 없으므로, 동일 아이디로 재 가입하실 수 없습니다.<br />
기 등록된 물건에 대한 회원님의 정보가 사라집니다.</div>
</fieldset>
<img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/dot.gif" height="17"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/text.gif" width="308" height="17">
<form method="post" name="FrmUserInfo" action="<?=$PHP_SELF?>" OnSubmit="javascript:return MemberCheckField(this);">
	<input type="hidden" name="query" value="out">
	<input type="hidden" name="mode" value="ok">
	<table class="table_main w100p">
			<col width="120" />
		<col width="*" />
		<tr>
			<th>고객명</th>
			<td><?=$cfg["member"]["mname"]?></td>
		</tr>
		<tr>
			<th>주민등록번호</th>
			<td><input name="userJumin1" type="text" id="userJumin1" class="w50" maxlength="6">
				-
				<input name="userJumin2" type="text" id="userJumin2" class="w50" maxlength="7">
			</td>
		</tr>
		<tr>
			<th>회원아이디</th>
			<td><?=$cfg["member"]["mid"]?></td>
		</tr>
		<tr>
			<th>비밀번호</th>
			<td><input name="userPass" type="text" id="userPass" maxlength="12"></td>
		</tr>
		<tr>
			<th>탈퇴사유</th>
			<td>
				<ol class="list_3">
					<li>
						<input name="outreason[]" type="checkbox" id="outreasonid" value="개인정보유출우려" style="width:14px; height:14px; vertical-align:middle; margin-bottom:2px;">
						개인정보유출우려
					</li>
					<li>
						<input name="outreason[]" type="checkbox" id="outreasonid" value="상품구비부족">
						상품구비부족
					</li>
					<li>
						<input name="outreason[]" type="checkbox" id="outreasonid" value="복잡한 구매절차">
						복잡한 구매절차
					</li>
					<li>
						<input name="outreason[]" type="checkbox" id="outreasonid" value="교환 및 반품관련">
						교환 및 반품관련
					</li>
					<li>
						<input name="outreason[]" type="checkbox" id="outreasonid" value="가격불만족">
						가격불만족
					</li>
					<li>
						<input name="outreason[]" type="checkbox" id="outreasonid" value="고객상담원불친절">
						고객상담원불친절
					</li>
					<li>
						<input name="outreason[]" type="checkbox" id="outreasonid" value="잦은 시스템 에러">
						잦은 시스템 에러
					</li>
					<li>
						<input name="outreason[]" type="checkbox" id="outreasonid" value="회원혜택없음">
						회원혜택없음
					</li>
					<li>
						<input name="outreason[]" type="checkbox" id="outreasonid" value="배송사고 및 지연">
						배송사고 및 지연
					</li>
				</ol>
			</td>
		</tr>
		<tr>
			<th>남기고 싶은 말</th>
			<td><textarea name="content" rows="5" id="content" class="w100p"></textarea></td>
		</tr>
	</table>
	<div class="btn_box">
		<input type="image" src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/bu_ok.gif">
		<a href="javascript:history.go(-1);"><img src="./wizmember/<?=$cfg["skin"]["MemberSkin"]?>/images/bu_cancle.gif"></a></div>
</form>
