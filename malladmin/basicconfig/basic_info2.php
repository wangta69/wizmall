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

$sqlstr	= "select AdminName, Pass from wizTable_Main where Grade = 'A'";
$dbcon->_query($sqlstr);
$list	= $dbcon->_fetch_array();
?>
<script language="javascript" type="text/javascript" src="../js/jquery.plugins/jquery.validator-1.0.1.js"></script>
<script>

$(function(){
	//메일스킨 설정
	$("#btn_mainskin").click(function(){
		window.open('../util/wizmail/adminforwiz.php','WizMailSkinSelectWindow','')
	});
	
	//저장
	$(".btn_save").click(function(){
		if($('#s_form').formvalidate()){
			$("#s_form").submit();
		}
	});
	
});
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">몰 기본환경 설정</div>
	  <div class="panel-body">
		기본정보 및 환경을 설정하실 수 있습니다.<br />
	이 곳에 설정된 내용은 각종 메일의 기본 정보 및 결제단의 중요정보가 됩니다.<br />
	특히 쇼핑몰명은 <span class="orange">반드시 특수문자나 공백이 없어야합니다.(결제단의 에러요인이
	될 수있습니다.)</span>
	  </div>
	</div>
	
	

<form name="s_form" id="s_form" action='<?php echo $PHP_SELF?>' method='post'>
	<input type="hidden" name="csrf" value="<?php echo $common->getcsrfkey() ?>">
	<input type='hidden' name='menushow' value='<?php echo $menushow?>'>
	<input type="hidden" name="theme" value="<?php echo $theme?>">
	<input type="hidden" name="action" value='admin_save'>
	관리자정보 및 환경을 변경합니다.
	<table class="table table-hover">
		<col width="120px" />
		<col width="*" />
		<col width="120px" />
		<col width="*" />
		<tr>
			<th>관리자아이디</th>
			<td><input type="text" value="<?php echo $list[AdminName];?>" name="ID" id="ID" class="required min4 max12" msg="관리자 아이디를 입력하세요" />
			</td>
			<th>관리자 성명</th>
			<td><input type="text" value="<?php echo $cfg["admin"]["ADMIN_NAME"]?>" name="ADMIN_NAME" class="required" msg="관리자 이름을 입력하세요" />
			</td>
		</tr>
		<tr>
			<th>현재관리패스워드</th>
			<td><input type="password" value="" name="C_PASS" class="required" msg="현재 패스워드를 입력하세요"  />
			</td>
			<th>로그인fail제한횟수</th>
			<td>
			<? $login_op	= array("0"=>"무한정", "5"=>"5회", "10"=>"10회", "20"=>"20회", "50"=>"50회", "100"=>"100회"); ?>
			<select name="LoginLimitCnt" id="LoginLimitCnt">
			<? foreach($login_op as $key => $val){
				$selected	= $cfg["admin"]["LoginLimitCnt"] == $key ? " selected":"";
				echo "<option value=\"$key\" $selected>$val</option>\n";
				}
			?>
				</select>
		
			</td>
		</tr>
		<tr>
			<th>관리패스워드</th>
			<td><input type="password" value="" name="PASS" class="required text_grp" msg="패스워드를 입력하세요"  group="text_grp" />
			</td>
			<th>패스워드확인</th>
			<td><input type="password" value="" name="PASS1" class="text_grp" />
			</td>
		</tr>
	</table>
	<span class="orange">* 관리패스워드는 쇼핑몰
	관리자화면으로 입장시 필요한 것입니다.<br />
	* 패스워드는 중요하므로 타인에게 노출되지 않도록 해주시기 바랍니다.</span>
	<table class="table table-hover">
		<col width="120px" />
		<col width="*" />
		<col width="120px" />
		<col width="*" />
		<tr>
			<th>쇼핑몰명</th>
			<td colspan="3"> (한글)
				<input type="text" name="ADMIN_TITLE" value="<?php echo $cfg["admin"]["ADMIN_TITLE"]?>" size="18">
				, (영문)
				<input type="text" name="ADMIN_TITLE_E" value="<?php echo $cfg["admin"]["ADMIN_TITLE_E"]?>" size="18">
		(<span class="orange">특수문자나 공백이 없어야합니다</span>.)		</tr>
		<tr>
			<th>회사도메인</th>
			<td colspan="3"><input type="text" name="COMPANY_DOMAIN" value="<?php echo $cfg["admin"]["COMPANY_DOMAIN"]?>" class="w300">
				(&quot;http://&quot;를 포함해서 입력 - 결제단용) </td>
		</tr>
		<tr>
			<th>WaterMark용</th>
			<td colspan="3">문자:
				<input type="text" name="str_watermark" value="<?php echo $cfg["admin"]["str_watermark"]?>">
				, 
				이미지:
				<input type="text" name="img_watermark" value="<?php echo $cfg["admin"]["img_watermark"]?>" />
				(절대경로사용) </td>
		</tr>
		<tr>
			<th>홈페이지 주소</th>
			<td colspan=3><input type="text" name="HOME_URL" value="<?php echo $cfg["admin"]["HOME_URL"]?>" class="w300">			</td>
		</tr>
		<tr>
			<th>이메일 주소</th>
			<td><input type="text" value="<?php echo $cfg["admin"]["ADMIN_EMAIL"]?>" name="ADMIN_EMAIL">
				<span class="button bull" id="btn_mainskin"><a>이메일 스킨 설정</a></span></td>
			<th>대표전화번호</th>
			<td><input type="text" value="<?php echo $cfg["admin"]["ADMIN_TEL"]?>" name="ADMIN_TEL" /></td>
		</tr>
		<tr>
			<th>상호명</th>
			<td><input type="text" value="<?php echo $cfg["admin"]["COMPANY_NAME"]?>" name="COMPANY_NAME" /></td>
			<th>대표자성함</th>
			<td><input type="text" value="<?php echo $cfg["admin"]["PRESIDENT"]?>" name="PRESIDENT" /></td>
		</tr>			
		<tr>
			<th>사업자등록번호</th>
			<td><input type="text" value="<?php echo $cfg["admin"]["COMPANY_NUM"]?>" name="COMPANY_NUM"></td>
			<th> 통신판매업신고 </th>
			<td><input type="text" value="<?php echo $cfg["admin"]["COMPLICENCE_NUM"]?>" name="COMPLICENCE_NUM"></td>
		</tr>
	
		<tr>
			<th>고객상담전화</th>
			<td><input type="text" value="<?php echo $cfg["admin"]["CUSTOMER_TEL"]?>" name="CUSTOMER_TEL"></td>
			<th>팩스번호</th>
			<td><input type="text" value="<?php echo $cfg["admin"]["CUSTOMER_FAX"]?>" name="CUSTOMER_FAX"></td>
		</tr>
		<tr>
			<th>사업장주소</th>
			<td colspan=3><input type="text" value="<?php echo $cfg["admin"]["COMPANY_ADD"]?>" name="COMPANY_ADD" class="w500">			</td>
		</tr>
		<tr>
			<th>절대경로(url)</th>
			<td colspan=3><input type="text" value="<?php echo $cfg["admin"]["MART_BASEDIR"]?>" name="MART_BASEDIR" class="w300" />
				<br />
				SHOPWIZ 파일들이 위치한 폴더의경로를 절대경로로 적어주시기 바랍니다.<br />
				(보기 : http://mall.shop-wiz.com)</td>
		</tr>
		<tr>
			<th>절대경로(url)</th>
			<td colspan=3><input type="text" value="<?php echo $cfg["admin"]["SYSTEM_BASEDIR"]?>" name="SYSTEM_BASEDIR" class="w500" />
				<br />
				SHOPWIZ 파일들이 위치한 폴더의경로를 절대경로로 적어주시기 바랍니다.<br />
				(보기 : /home/www/shopwiz/public_html/mall)</td>
		</tr>
	</table>
	<span  class="orange">SMS 관리</span>
	<table class="table table-hover">
		<col width="120px" />
		<col width="*" />
		<col width="120px" />
		<col width="*" />
		<tr>
			<th>SMS 업체</th>
			<td><select name=smsModule id="smsModule">
					<?php
$targetdir = "./skin_sms";
$common->showFolderList($targetdir, $cfg["sms"]["smsModule"]);
?>
				</select>
				<input type="checkbox" name="sms_rec_enable" value="1" <?php if($cfg["sms"]["sms_rec_enable"] == "1") echo "checked";?>>
				주문접수시 관리자 문자수신 </td>
			<th>Mobil No.</th>
			<td><input type="text" name="sms_mobil" id="sms_mobil" value="<?php echo $cfg["sms"]["sms_mobil"]?>" />
			</td>
		</tr>
		<tr>
			<th>SMS ID </th>
			<td><input type="text" name="sms_id" id="sms_id" value="<?php echo $cfg["sms"]["sms_id"]?>">
			</td>
			<th>SMS PWD</th>
			<td><input name="sms_pwd" type="password" id="sms_pwd" value="<?php echo $cfg["sms"]["sms_pwd"]?>" />
			</td>
		</tr>
	</table>
	<div class="text-center">
		<button type="button" class="btn btn-primary btn_save">설정완료</button>
	</div>
</form>
	
</div>
