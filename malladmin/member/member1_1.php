<?php
/*
 powered by 폰돌
 Reference URL : http://www.shop-wiz.com
 Contact Email : master@shop-wiz.com
 Free Distributer :

 Copyright shop-wiz.com
 *** Updating List ***
 */
include "../common/header_pop.php";
include "../../config/common_array.php";

if (!strcmp($smode, "qup") && $common->checsrfkey($csrf)) :
	/* 회원기본정보 변경 시작 */
	$birthdate = $birthy . "/" . $birthm . "/" . $birthd;
	$zip1 = $zip1_1 . "-" . $zip1_2;
	$Zip2 = $zip2_1 . "-" . $zip2_2;
    
    unset($ups);
    if ($ini_pwd == "1") $ups["mpasswd"]   = $common -> mksqlpwd($passwd);
    $ups["mid"]         = $id;
    $ups["mname"]       = $name;
    $ups["mgrade"]      = $mgrade;
    $ups["mailreceive"] = $mailreceive;
    $dbcon ->updateData("wizMembers", $ups, "mid='".$oldid."'");
	/* 회원기본정보 변경 끝 */

	/* 회원 기타 정보 변경 시작 */
	unset($ups);
    if ($ini_jumin == "1"){
        $ups["jumin1"]    = $common -> mksqlpwd($jumin1, "memjumin");
        $ups["jumin2"]    = $common -> mksqlpwd($jumin2, "memjumin");
        
    }
    $ups["id"]          = $id;
    $ups["nickname"]    = $nickname;
    $ups["pwdhint"]     = $pwdhint;
    $ups["pwdanswer"]   = $pwdanswer;
    $ups["gender"]      = $gender;
    $ups["birthdate"]   = $birthdate;
    $ups["birthtype"]   = $birthtype;
    $ups["marrdate"]    = $marrdate;
    $ups["marrstatus"]  = $marrstatus;
    $ups["email"]       = $email;
    $ups["mailreceive"] = $mailreceive;
    $ups["scholarship"] = $scholarship;
    $ups["company"]     = $company;
    $ups["companynum"]  = $companynum;
    $ups["tel1"]        = $tel1;
    $ups["tel2"]        = $tel2;
    $ups["tel3"]        = $tel3;
    $ups["fax"]         = $fax;
    $ups["zip1"]        = $zip1;
    $ups["address1"]    = $address1;
    $ups["address2"]    = $address2;
    $ups["zip2"]        = $zip2;
    $ups["address3"]    = $address3;
    $ups["address4"]    = $address4;
    $ups["url"]         = $url;
    $ups["recid"]       = $recid;

    $dbcon ->updateData("wizMembers_ind", $ups, "id='".$oldid."'");

	/* 회원 기타 정보 변경 끝 */
	echo "<script'>window.alert('\\n\\n ".$name." 님의 회원가입 정보가 변경되었습니다.\\n\\n');location.replace('".$PHP_SELF."?id=".$oldid."');</script>";
	exit ;
endif;

/* wizMembers 에서 정보 가져 옮 */
$sqlstr = "select m.*, i.* from wizMembers m left join wizMembers_ind i on m.mid=i.id where m.mid = '".$id."'";
$sqlqry = $dbcon -> _query($sqlstr);
$list = $dbcon -> _fetch_array();
$tel1 = explode("-", $list["tel1"]);
$tel2 = explode("-", $list["tel2"]);
$tel3 = explode("-", $list["tel3"]);
$fax = explode("-", $list["fax"]);
$zip1 = explode("-", $list["zip1"]);
$Zip2 = explode("-", $list["Zip2"]);
$birthdate = explode("/", $list["birthdate"]);
if (!$list["gender"]) {
	//echo "genderno = $genderno <br />";
	$genderno = substr($list["jumin2"], 0, 1);
	if ($genderno == 1 || $genderno == 3)
		$list["gender"] = "남";
	else if ($genderno == 2 || $genderno == 4)
		$list["gender"] = "여";
}
if (!$birthdate[0]) {
	//echo "genderno = $genderno <br />";
	if (substr($list["jumin2"], 0, 1) == 1 || substr($list["jumin2"], 0, 1) == 2)
		$BirthCentury = 19;
	else
		$BirthCentury = 20;
	
	$birthdate[0] = $BirthCentury . substr($list["jumin1"], 0, 2);
	$birthdate[1] = substr($list["jumin1"], 2, 2);
	$birthdate[2] = substr($list["jumin1"], 4, 2);
}
include "../common/header_html.php";
?>
<script>
	var _csrf = "<?php echo $common->getcsrfkey();?>";
	var _userid = '<?php echo $list["mid"]?>';
	$(function(){
		$(".btn_save").click(function(){
			$("#s_form").submit();
		});
	});

    function insertpoint(type){
    //id, point, 41, $content
		if(type == "exp"){
			var point = document.getElementById("exp_value").value;
			var content = document.getElementById("exp_cont").value;
		}else if(type == "point"){
			var point = document.getElementById("point_value").value;
			var content = document.getElementById("point_cont").value;
		}

		$.post("../../lib/ajax.admin.php", {smode:"in_point",userid:_userid,point:point,content:content,type:type,csrf:_csrf}, function (data){
			eval("var obj="+data);
			if(obj[0] == "exp"){
				document.getElementById("exp_str").innerHTML = SetComma1(parseInt(RemoveComma(document.getElementById("exp_str").innerHTML)) + parseInt(obj[1]));
			}else if(obj[0] == "point"){
				document.getElementById("point_str").innerHTML = SetComma1(parseInt(RemoveComma(document.getElementById("point_str").innerHTML)) + parseInt(obj[1]));
			}
			
			
		});
    }
</script>
<body>
<form action='<?php echo $PHP_SELF; ?>' method="post" id="s_form">
	<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
	<input type="hidden" name="smode" value="qup" />
	<input type="hidden" name='oldid' value='<?php echo $list["mid"]?>' />
	회원가입 상세정보입니다.
	<table class="table">
		<col width="120" />
		<col width="*" />
		<col width="120" />
		<col width="*" />
		<tr>
			<th>* 아이디</th>
			<td colspan="3"><input name="id" type="text"  id="id" value="<?php echo $list["mid"]?>" readonly></td>
		</tr>
		<tr>
			<th>* 패스워드</th>
			<td colspan="3"><input name="passwd" type="text" id="passwd" value="<?php echo $list["mpasswd"]?>">
				<input name="ini_pwd" type="checkbox" id="ini_pwd" value="1">
				패스워드 초기화</td>
		</tr>
		<tr>
			<th>* 이 름</th>
			<td><input name="name" type="text" id="name" value="<?php echo $list["mname"]?>"></td>
			<th>* 메일수신여부</th>
			<td><input type="radio" name="mailreceive" value="1"<?php echo $list["mailreceive"] == "1" ? " checked":""; ?>>
				받음
				<input type="radio" name="mailreceive" value="0"<?php echo $list["mailreceive"] == "0" ? " checked":""; ?>>
				받지않음 </td>
		</tr>
		<tr>
			<th>* 생년월일</th>
			<td><input type="text" name="birthy" value="<?php echo $birthdate[0]?>" class="w30">
				년
				<input type="text" name="birthm" value="<?php echo $birthdate[1]?>" class="w30">
				월
				<input type="text" name="birthd" value="<?php echo $birthdate[2]?>" class="w30">
				일
				<select name="birthtype" size="1">
					<option value="0"<?php echo $list["birthtype"] == "0" ? " selected":""; ?>>양력</option>
					<option value="1"<?php echo $list["birthtype"] == "1" ? " selected":""; ?>>음력</option>
				</select>
			</td>
			<th>* 성별구분</th>
			<td><input type="radio" name='gender' value='1'<?php echo $list["gender"] == "1" ? " checked":""; ?>>
				남자
				<input type="radio" name='gender' value='2'<?php echo $list["gender"] == "2" ? " checked":""; ?>>
				여자 </td>
		</tr>
		<tr>
			<th>* E-mail</th>
			<td colspan="3"><input name="email" type="text" id="email" value='<?php echo $list["email"]?>'>
				<span class="button bull"><a href="mailto:<?php echo $list["Email"]?>">메일보내기</a></span></td>
		</tr>
		<tr>
			<th>홈페이지</th>
			<td colspan="3"><input name="url" type="text" value='<?php echo $list["url"]?>'></td>
		</tr>
		<tr>
			<th>* 자택 전화번호</th>
			<td colspan="3"><input name="tel1" type="text" value='<?php echo $list["tel1"]?>'>
				&quot;-&quot;포함 입력 </td>
		</tr>
		<tr>
			<th>핸드폰</th>
			<td colspan="3"><input name="tel2" type="text" value='<?php echo $list["tel2"]?>'>
				&quot;-&quot;포함 입력 </td>
		</tr>
		<tr>
			<th>* 자택 
				우편번호</th>
			<td colspan="3"><input name="zip1_1" value='<?php echo $zip1[0]?>' class="w30">
				-
				<input name="zip1_2" value='<?php echo $zip1[1]?>' class="w30">
			</td>
		</tr>
		<tr>
			<th>* 동(면)이상주소</th>
			<td colspan="3"><input name="address1" type="text" id="address1" value='<?php echo $list["address1"]?>' class="w300"></td>
		</tr>
		<tr>
			<th>* 나머지 
				주소</th>
			<td colspan="3"><input name="address2" type="text" id="address2" value='<?php echo $list["address2"]?>' class="w300"></td>
		</tr>
		<tr>
			<th>(직장)학교명</th>
			<td colspan="3"><input type="text" name="company" value="<?php echo $list["company"]?>">
			</td>
		</tr>
		<tr>
			<th>사업자등록번호</th>
			<td colspan="3"><input name="companynum" type="text" id="companynum" value="<?php echo $list["companynum"]?>">
			</td>
		</tr>
		<tr>
			<th>* 회원등급</th>
			<td><select name='mgrade'>
					<?php
					foreach ($gradetostr_info as $key => $value) {
						$selected = $key == $list["mgrade"] ? "selected" : "";
						echo "<option value='$key' $selected>" . $value . "</option>";
					}
				?>
				</select></td>
			<th>회원레벨</th>
			<td><?php echo $member->getLevel($list["mexp"])?></td>
		</tr>
		<tr>
			<th>로그인</th>
			<td colspan="3"><?php echo $list["mloginnum"]; ?>
				회 </td>
		</tr>
	</table>
	<table class="table">
		<col width="120" />
		<col width="*" />
		<col width="120" />
		<col width="*" />
		<tr>
			<th>경험치</th>
			<td><a href="javascript:getpointInfo('<?php echo $id?>', 1)">
				<?php echo number_format($list["mexp"])?>
				</a></td>
			<th>머니</th>
			<td><a href="javascript:getpointInfo('<?php echo $id?>', 1)"><span id="point_str">
				<?php echo number_format($list["mpoint"])?>
				</span> POINT</a></td>
		</tr>
		<tr>
			<th>사유</th>
			<td><input type="text" name="exp_cont" id="exp_cont"></td>
			<th>사유</th>
			<td><input type="text" name="point_cont" id="point_cont"></td>
		</tr>
		<tr>
			<th>경험치추가</th>
			<td><input name="exp_value" type="text" id="exp_value" class="w30 agn_r">
				<input type="button" name="button" id="button" value="확인" onClick="insertpoint('exp')"></td>
			<th>머니추가</th>
			<td><input name="point_value" type="text" id="point_value" class="w30 agn_r">
				<input type="button" name="button" id="button" value="확인" onClick="insertpoint('point')"></td>
		</tr>
	</table>
	<br />
	<div class="btn_box">
		<span class="btn_save button bull"><a>수정</a></span>
		<span class="button bull"><a href="javascript:window.print()">출력</a></span>
		<span class="button bull"><a href="javascript:top.close();">창닫기</a></span>
	</div>
</form>
</body>
</html>