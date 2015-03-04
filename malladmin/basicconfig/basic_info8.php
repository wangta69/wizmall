<?php
/*
 powered by 폰돌
 Reference URL : http://www.shop-wiz.com
 Contact Email : master@shop-wiz.com
 Free Distributer :
 - http://www.shop-wiz.com
 Copyright shop-wiz.com
 *** Updating List ***
 */
include "./basicconfig/common.php";
?>
<script>
	$(function() {

		$("#btn_save").click(function() {
			if (confirm('\n입력하신 모든 값들이 정말로 정확합니까?\n')) {
				$("#regForm").submit();
			}
		});

	})
</script>
<div class="table_outline">
	<div class="panel panel-success">
		<div class="panel-heading">
			회원가입 옵션 관리
		</div>
		<div class="panel-body">
			회원가입시 다양한 기능들을 적용하실 수 있습니다.
			<br />
			아래 스킨들은 default 스킨일 경우 100% 활용가능하며 기타 스킨은 프로그램에 따라
			적용되지 않을 수도 있습니다.
		</div>
	</div>

	<form id="regForm" action='<?php echo $PHP_SELF?>' method='post'>
		<input type="hidden" name="csrf" value="<?php echo $common->getcsrfkey() ?>">
		<input type='hidden' name='menushow' value='<?php echo $menushow?>'>
		<input type="hidden" name="theme" value=<?php echo $theme; ?>>
		<input type="hidden" name=action value='mem_save'>

		<div class="panel panel-default">
			<!-- Default panel contents -->
			<div class="panel-heading">
				회원가입옵션
			</div>

			<table class="table">

				<tr>
					<th class="active">필수</th>
					<td>
					<input disabled type="checkbox" CHECKED value="checkbox" name="checkbox">
					회원아이디
					<input disabled type="checkbox" CHECKED value="checkbox" name="checkbox2">
					비밀번호
					<input disabled type="checkbox" CHECKED value="checkbox" name="checkbox3">
					이름
					<input disabled type="checkbox" CHECKED value="checkbox" name="checkbox4">
					전화번호
					<input disabled type="checkbox" CHECKED value="checkbox" name="checkbox6">
					전자우편 </td>
				</tr>
				<tr>
					<th class="active">선택</th>
					<td>
					<input
					type="checkbox" value="checked" name="ESex" <?php echo $cfg["mem"]["ESex"]?>>
					성별(
					<input
					type="checkbox" value="checked" name="CSex" <?php echo $cfg["mem"]["CSex"]?>>
					)
					<input type="checkbox" value="checked" name="ECompany" <?php echo $cfg["mem"]["ECompany"]?>>
					회사명(
					<input
					type="checkbox" value="checked" name="CCompany" <?php echo $cfg["mem"]["CCompany"]?>>
					)
					<input
					type="checkbox" value="checked" name="ECompnum" <?php echo $cfg["mem"]["ECompnum"]?>>
					사업자등록번호(
					<input type="checkbox" value="checked" name="CCompnum" <?php echo $cfg["mem"]["CCompnum"]?>>
					)
					<input type="checkbox" value="checked" name="ETel2" <?php echo $cfg["mem"]["ETel2"]?>>
					이동전화(
					<input type="checkbox" value="checked" name="CTel2" <?php echo $cfg["mem"]["CTel2"]?>>
					)
					<br />
					<input
					type="checkbox" value="checked" name="EMailReceive" <?php echo $cfg["mem"]["EMailReceive"]?>>
					메일수신(
					<input type="checkbox" value="checked" name="CMailReceive" <?php echo $cfg["mem"]["CMailReceive"]?>>
					)
					<br />
					<input type="checkbox" value="checked" name="EBirthDay" <?php echo $cfg["mem"]["EBirthDay"]?>>
					생년월일(
					<input type="checkbox" value="checked"
					name="CBirthDay" <?php echo $cfg["mem"]["CBirthDay"]?>>
					)
					<input type="checkbox" value="checked"
					name="EMarrStatus" <?php echo $cfg["mem"]["EMarrStatus"]?>>
					결혼여부(
					<input type="checkbox"
					value="checked" name="CMarrStatus" <?php echo $cfg["mem"]["CMarrStatus"]?>>
					)
					<input type="checkbox"
					value="checked" name="EJob" <?php echo $cfg["mem"]["EJob"]?>>
					직업(
					<input type="checkbox"
					value="checked" name="CJob" <?php echo $cfg["mem"]["CJob"]?>>
					)
					<input type="checkbox"
					value="checked" name="EScholarship" <?php echo $cfg["mem"]["EScholarship"]?>>
					학력(
					<input
					type="checkbox" value="checked" name="CScholarship" <?php echo $cfg["mem"]["CScholarship"]?>>
					)
					<input
					type="checkbox" value="checked" name="EAddress3" <?php echo $cfg["mem"]["EAddress3"]?>>
					직장주소(
					<input
					type="checkbox" value="checked" name="CAddress3" <?php echo $cfg["mem"]["CAddress3"]?>>
					)
					<br />
					<input
					type="checkbox" value="checked" name="ERecID" <?php echo $cfg["mem"]["ERecID"]?>>
					추천인(
					<input
					type="checkbox" value="checked" name="CRecID" <?php echo $cfg["mem"]["CRecID"]?>>
					)
					<br />
					<span class="orange">* (
						<input type="checkbox" CHECKED
						value="checked" name="checkbox7">
						) 책크박스 책크시 필수 입력으로 전환됩니다.</span></td>
				</tr>
				<tr>
					<th class="active">실명인증서비스</th>
					<td>
					<select name="realnameModule" id="realnameModule">
						<?php
						$admin -> select = $cfg["mem"]["realnameModule"];
						$admin -> dirSelect("../skinwiz/nameservice");
						?>
					</select> 
					<br/>
					실명인증 : 회원사코드 :
					<input name="realnameID" id="realnameID" value="<?php echo $cfg["mem"]["realnameID"]?>" class="w100 agn_r" />
					,회원사패스워드 :
					<input name="realnamePWD" id="realnamePWD" value="<?php echo $cfg["mem"]["realnamePWD"]?>" class="w100 agn_r" />
					<br/>
					IPIN : 회원사코드 :
					<input name="realnameIpinID" id="realnameIpinID" value="<?php echo $cfg["mem"]["realnameIpinID"]?>" class="w100 agn_r" />
					,회원사패스워드 :
					<input name="realnameIpinPWD" id="realnameIpinPWD" value="<?php echo $cfg["mem"]["realnameIpinPWD"]?>" class="w100 agn_r" />
					</td>
				</tr>
				<tr>
					<th class="active">상세설정1</th>
					<td>
					<input name="EGrantSta" type="radio" value="03" <?php
						if ($cfg["mem"]["EGrantSta"] == "03")
							echo "checked";
					?>>
					회원가입시 인증
					<input type="radio" name="EGrantSta" value="04" <?php
						if (!$cfg["mem"]["EGrantSta"] || $cfg["mem"]["EGrantSta"] == "04")
							echo "checked";
					?>>
					회원가입 후 관리자 인증 </td>
				</tr>
				<tr>
					<th class="active">상세설정2</th>
					<td>
					<input name="INCLUDE_MALL_SKIN" type="radio" value="yes" <?php
						if ($cfg["mem"]["INCLUDE_MALL_SKIN"] == "yes")
							echo "checked";
					?>>
					몰인클루드
					<input type="radio" name="INCLUDE_MALL_SKIN" value="no" <?php
						if ($cfg["mem"]["INCLUDE_MALL_SKIN"] == "no")
							echo "checked";
					?>>
					몰인클루드 하지 않음</td>
				</tr>
				<tr>
					<th class="active">상세설정3</th>
					<td>
					<input name="SendMail" type="radio" value="yes" <?php
						if ($cfg["mem"]["SendMail"] == "yes")
							echo "checked";
					?>>
					회원가입메일발송
					<input type="radio" name="SendMail" value="no" <?php
						if ($cfg["mem"]["SendMail"] == "no")
							echo "checked";
					?>>
					회원가입시 메일발송안함</td>
				</tr>
				<tr>
					<th class="active">포인트설정1</th>
					<td>회원가입시 포인트 설정 :
					<input value="<?php echo $cfg["mem"]["EPoint"]?>" name="EPoint" class="w50 agn_r" />
					포인트 </td>
				</tr>
				<tr>
					<th class="active">포인트설정2</th>
					<td>회원추천시 포인트 설정 :
					<input name="RPoint" value="<?php echo $cfg["mem"]["RPoint"]?>" class="w50 agn_r" />
					포인트</td>
				</tr>
				<tr>
					<th class="active">포인트설정3</th>
					<td>로그인 포인트
					설정 :
					<input name=LPoint value="<?php echo $cfg["mem"]["LPoint"]?>" class="w50 agn_r" />
					포인트(1일 1회) </td>
				</tr>
			</table>
		</div>

		<div class="panel panel-default">
			<!-- Default panel contents -->
			<div class="panel-heading">
				약관설정
			</div>
			<?php
			if (is_file("../config/memberaggrement_info.php")) {
				$DATA1 = file("../config/memberaggrement_info.php");
				while ($dat1 = each($DATA1)) {
					//$dat1[1] = nl2br(htmlspecialchars($dat1[1]));
					$dat1[1] = stripslashes($dat1[1]);
					$CONTENT .= $dat1[1];
				}
			}
			?>
			<textarea name="MEMBER_AGGREMENT" rows=8 class="w100p"><?php echo $CONTENT?>
</textarea>			
					
					

		</div>

		<div class="panel panel-default">
		<!-- Default panel contents -->
		<div class="panel-heading">스킨입력(몰스킨외에
		스킨을 사용하실려면 &quot;몰인크루드 하지않음&quot;을 선택후 코딩하세요</div>
		<table class="table">
		<tr>
		<th class="active">회원스킨 Top</th>
		<td><textarea name="MemberSkinTop" rows="8" id="MemberSkinTop" class="w100p"><?php
		$fp = file("../config/MemberSkinTop.php");
		for ($i = 0; $i < sizeof($fp); $i++) {
			$String = stripslashes($fp[$i]);
			echo $String;
		}
	?>
</textarea></td>
</tr>
<tr>
<th class="active">회원스킨 Bottom</th>
<td><textarea name="MemberSkinBottom" rows="8" id="MemberSkinBottom" class="w100p"><?php
$fp = file("../config/MemberSkinBottom.php");
for ($i = 0; $i < sizeof($fp); $i++) {
	$String = stripslashes($fp[$i]);
	echo $String;
}
?>
</textarea></td>
</tr>
</table>
<!-- Table -->

</div>

<div class="panel panel-default">
<!-- Default panel contents -->
<div class="panel-heading">회원가입축하메일 내용</div>
<?php
if (is_file("../config/regismail_info.php")) {
	$DATA1 = file("../config/regismail_info.php");
	while ($dat1 = each($DATA1)) {
		//$dat1[1] = nl2br(htmlspecialchars($dat1[1]));
		$dat1[1] = stripslashes($dat1[1]);
		$WELCOM_MESSAGE .= $dat1[1];
	}
}
		?>
		<textarea name="WELCOM_MESSAGE" rows=8 class="w100p"><?php echo $WELCOM_MESSAGE
		?>
		</textarea>

		</div>
	</form>
	<div class="text-center">
		<button type="button" class="btn btn-primary" id="btn_save">
			적용
		</button>
	</div>
</div>
