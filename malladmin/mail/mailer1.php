<?php
/************************************************/
/**                                            **/
/**    프로그래명 : wizMailer For wizMall      **/
/**                                            **/
/**    수정자 : 폰돌                           **/
/**                                            **/
/**    수정일 : 2002.8.20                      **/
/**    두번째 수정일 : 2003. 05.13             **/
/************************************************/
/* 위즈몰용으로 기존 프로그램을 수정보완하였습니다.
 현재 프로그램을 wizMember의 wizMembers DB와 호환되게 다시 수정 보완 배포합니다.
 E-mail : master@shop-wiz.com
 Url : http://www.shop-wiz.com
 상업적 목적이 없는 한 수정 및 재 배포가 자유롭습니다.
 단, 수정시 상기를 표시해 주시면 감솨여....^^
 Upgrade 2003.08.20 wizmall에 맞게 재구성
 2003.10.10  성별 에러 발생되던 것을 수정 및 등급별 발송 선택
 2004. 05. 12 스킨선택기능 삽입
 2004. 06 30 개인Address에서 가져오기 기능 추가
 2004. 07 9  텍스트로 된 대량 메일 발송 기능 추가
 */
?>
<script>
	$(function() {
		$(".sel_tb").click(function() {
			var sel_val = parseInt($(this).val()) - 1;
			//	alert(sel_val);
			$(".optiontable").hide();
			$(".optiontable").eq(sel_val).show();
			// 메서드
		});
	});
	function display(flag) {
		var f = document.messageform;
		optionTable1.style.display = 'none';
		optionTable2.style.display = 'none';
		optionTable3.style.display = 'none';
		optionTable4.style.display = 'none';
		optionTable5.style.display = 'none';
		if (flag == '1') {//회원테이블로 부터 메일 보내기
			optionTable1.style.display = 'block';
			f.theme.value = "mail/mailer2";
		} else if (flag == '2') {//주소록 Table로 부터 메일 보내기
			optionTable2.style.display = 'block';
			f.theme.value = "mail/mailer2_1";
		} else if (flag == '3') {//단체개별메일보내기
			optionTable3.style.display = 'block';
			f.theme.value = "mail/mailer2_2";
		} else if (flag == '4') {//csv파일로 부터 메일보내기
			optionTable4.style.display = 'block';
			f.theme.value = "mail/mailer2_3";
		} else if (flag == '5') {//뉴스레터로 부터 메일보내기
			optionTable5.style.display = 'block';
			f.theme.value = "mail/mailer2_4";
		}
	}

	//-->
</script>
<div class="table_outline">
	<div class="panel panel-success">
		<div class="panel-heading">
			메일발송하기
		</div>
		<div class="panel-body">
			메일발송옵션에서 선택된 회원에게 메일이 발송됩니다.
			<br />
			메일발송은 서버에 부하가 주어지므로 만단위 이상의 메일은 자제해 주시기 바랍니다.
		</div>
	</div>

	<form name="messageform" method="post" action="<?php echo $PHP_SELF?>" enctype='multipart/form-data'>
		<input type='hidden' name='menushow' value='<?php echo $menushow?>'>
		<input type="hidden" name="theme" value="mail/mailer2">
		<table class="table">
			<col width=" 120px" />
			<col width="*" />
			<tr>
				<th class="active">보내는 분</th>
				<td>
				<input type="text" size="50" name="FromName" value="<?php echo $cfg["admin"]["ADMIN_TITLE"]?>" />
				(예)<?php echo $cfg["admin"]["ADMIN_TITLE"]?></td>
			</tr>
			<tr>
				<th class="active">Email</th>
				<td>
				<input type="text" name="FromEmail" value="<?php echo $cfg["admin"]["ADMIN_EMAIL"]?>" size="50">
				(예)<?php echo $cfg["admin"]["ADMIN_EMAIL"]?>
				</td>
			</tr>
			<tr>
				<th class="active">Reply-To </th>
				<td>
				<input type="text" name="reply" value="<?php echo $cfg["admin"]["ADMIN_EMAIL"]?>" size="50">
				(예)<?php echo $cfg["admin"]["ADMIN_EMAIL"]?></td>
			</tr>
			<tr>
				<th class="active">제목</th>
				<td>
				<input type="text" size="81" name="subject">
				</td>
			</tr>
			<tr>
				<th class="active">텍스트타입</th>
				<td>
				<input type="radio" checked value="0" name="contenttype">
				HTML 로 보내기
				<input type="radio" value="1" name="contenttype">
				TXT 로 보내기 </td>
			</tr>
			<tr>
				<th class="active">스킨선택</th>
				<td>
				<select style="width: 160px" name="MailSkin">
					<option value="">스킨없슴</option>
					<?php
					$vardir = "./mailskin";
					$open_dir = opendir($vardir);
					while ($opendir = readdir($open_dir)) {
						if (($opendir != ".") && ($opendir != "..") && is_dir("$vardir/$opendir")) {
							echo "<option value=\"$opendir\">$opendir 스킨</option>\n";
						}
					}
					closedir($open_dir);
					?>
				</select></td>
			</tr>
			<tr>
				<th class="active">내용</th>
				<td>				<textarea name="body_txt" rows=15 class="w100p"></textarea></td>
			</tr>
			<tr>
				<th class="active">파일첨부 </th>
				<td>
				<input type="file" name="userfile" id="userfile">
				</td>
			</tr>
			<tr>
				<th class="active">메일Table선택</th>
				<td>
				<input type="radio" name="addsource" value="1" checked="checked" class="sel_tb">
				회원Table
				<input type="radio" name="addsource" value="2" class="sel_tb">
				주소록Table
				<input type="radio" name="addsource" value="3" class="sel_tb">
				단체개별메일
				<input type="radio" name="addsource" value="4" class="sel_tb">
				csv파일
				<input type="radio" name="addsource" value="5" class="sel_tb">
				뉴스레터신청 </td>
			</tr>
			<tr>
				<th class="active">메일발송옵션</th>
				<td>
				<table class="table optiontable">
					<tbody>
						<tr>
							<td>
							<input type="radio" value="all" name="soption">
							전체 &nbsp;&nbsp;&nbsp;
							<input type="checkbox" checked value="1" name="mailreject">
							수신거부회원은 메일 발송안함</td>
						</tr>
						<tr>
							<td>
							<input type="radio" value="seq" name="soption">
							번호순
							<input type="text" size="10" value="1" name="startseq">
							-
							<?php
							$query = "select max(UID) from wizMembers order by UID desc";
							$maxseq = $dbcon -> get_one($query);
							?>
							<input type="text" name="stopseq" value="<?php echo $maxseq?>" size=10>
							</td>
						</tr>
						<tr>
							<td>
							<input type="radio" value="gender" name="soption">
							성별
							<select size=1 name="genderSelect">
								<option value="1" selected>남자</option>
								<option value="2">여자</option>
							</select></td>
						</tr>
						<tr>
							<td>
							<input type="radio" value="grade" name="soption">
							등급별메일보내기
							<select size=1 name="gradeSelect">
								<?php
								foreach ($gradetostr_info as $key => $value) {
									$selected = $key == $list["mgrade"] ? "selected" : "";
									echo "<option value='$key' $selected>" . $value . "</option>";
								}
								?>
							</select></td>
						</tr>
						<tr>
							<td>
							<input type="radio" checked value="testMail" name="soption">
							개인멜
							<input type="text" name="testMailAddress">
							(하나의 이멜을 적어주세요 - 테스트용)</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</tbody>
				</table>
				<table class="table optiontable" style="display:none">
					<tr>
						<td>
						<input type="radio" value="all" name="queryind">
						전체 </td>
					</tr>
					<tr>
						<td>
						<input type="radio" checked value="amail" name="queryind">
						개인멜
						<input type="text" name="personalind">
						(하나의 이멜을 적어주세요 - 테스트용)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table class="table optiontable" style="display:none">
					<tr>
						<td>
						<input type="radio" value="all" name="querymass">
						전체 </td>
					</tr>
					<tr>
						<td>
						<input type="radio" checked value="amail" name="querymass">
						개인멜
						<input type="text" name="personalmass">
						(하나의 이멜을 적어주세요 - 테스트용)</td>
					</tr>
					<tr>
						<td>&nbsp;
						<table>
							<tr>
								<td><textarea name="userMailList" rows="20" id="userMailList"></textarea></td>
								<td width="15">&nbsp;</td>
								<td><textarea name="textarea2" cols="50" rows="20" wrap="PHYSICAL" disabled>사용예
이메일주소를 아래와 같이 일련으로 카피합니다.

abc@abc.co.kr
xxx@ac.com
kor@korea.com
yyy@check.co.kr</textarea></td>
							</tr>
						</table></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table class="table optiontable" style="display:none">
					<tr>
						<td>
						<input type="radio" value="all" name="mail4_target">
						전체 </td>
					</tr>
					<tr>
						<td>
						<input type="radio" checked value="amail" name="mail4_target">
						개인멜
						<input type="text" name="personalmass">
						(하나의 이멜을 적어주세요 - 테스트용)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
				<table class="table optiontable" style="display:none">
					<tr>
						<td>
						<input type="radio" value="all" name="mail5_target">
						전체 </td>
					</tr>
					<tr>
						<td>
						<input type="radio" checked value="amail" name="mail5_target">
						개인멜
						<input type="text" name="personalmail5">
						(하나의 이멜을 적어주세요 - 테스트용)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table></td>
			</tr>

		</table>
		<p class="text-center">
			<button type="submit" class="btn btn-default">
				메일발송
			</button>
		</p>
	</form>
</div>
