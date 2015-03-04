<?php
include "../../lib/cfg.common.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>">
<script language=javascript src="../../js/jquery.min.js"></script>
<script language=javascript src="../../js/jquery.plugins/jquery-ui-1.7.2.custom.min.js"></script>
<script language=javascript src="../../js/jquery.plugins/jqalerts/jquery.alerts.js"></script>
<link rel=StyleSheet href="../../css/base.css" type="text/css">
<link rel=StyleSheet href="../../css/admin.css" type="text/css">
<link rel=StyleSheet href="../../css/install.css" type="text/css">
<link rel="stylesheet" href="../../js/jquery.plugins/jqalerts/jquery.alerts.css" type="text/css" />
<title>▒▒ WizBoard For PHP Install ▒▒</title>
<script>
$(function(){
	$(".btn_reload").click(function(){
		document.reload();
	});
	
	$(".btn_submit").click(function(){
		if($("#agree_chk").is(':checked')){
			$("#s_form").attr("action", "install2.php");
			$("#s_form").submit();
		}else{
			jAlert('위즈몰를 설치하기 전에 동의하셔야 합니다.');
		}
	});
	
	$(".btn_cancel").click(function(){
		window.close();
	});		
});
</script>
</head>
<body>
<div id="layout">
<form name="s_form" id="s_form" method="post">
	<dl class="desc">
		<dt>WIZ_MALL INSTALL PAGE </dt>
		<dd> * install 전의 준비사항
			<ul>
				<li>webroot에 반드시 config 디렉토리가 생성되어있어야하고 퍼미션이 707 혹은 777 이어야합니다.</li>
				<li>자세한 사항은 <a href="http://www.shop-wiz.com " target="_parent">http://www.shop-wiz.com </a>의 숍위즈 게시판을 참조해 주세요.</li>
				<li>상기 퍼미션이 정상적으로 주어졌어면 아래의 설치 버튼을 눌러 주세요</li>
			</ul>
		</dd>
	</dl>
	<textarea name="formtextarea1" rows="18" READONLY class="w100p">

라이센스 

위즈몰에 대한 라이센스입니다. 

아래 라이센스에 동의하시는 분만 위즈몰를 사용할수 있습니다.
프로그램명 : wizboard (위즈몰)
개발환경 : PHP + MYSQL
개발자 : 폰돌
Homepage : http://shop-wiz.com 



* 본 프로그램은 대한민국 지적 재산권법 및 저작권법에 의해 보호되고 있습니다.

* 본 프로그램 소스를 이용한 2차적 저작물 제작은 금하여, 이를 위반시 지적재산권 보호법에 의한 조치가 취해지는 불이익을 받을 수 있습니다. 소스를 타 프로그램에서 무단 도용할 경우, 사전 통보 없이 법적 불이익을 받을 수 있습니다.

* 위즈몰 공개버전 사용권

  - 아무런 댓가 없이 무한정 무료로 사용할 수 있습니다.
  - 위즈몰 사용시 저작권 명시부분을 훼손하면 안됩니다. 프로그램 소스, ASP 소스상의 라이센스 및 웹상 출력물 하단에 있는 카피라이트와 링크를 수정하지 마십시요. (저작권 표시는 게시판 배포시 작성된 형식만을 허용합니다. 임의 수정은 금지합니다) 
  - 위즈몰의 재 배포는 shop-wiz.com과 shop-wiz.com에서 허용한 곳에서만 할 수 있습니다
  - 링크서비스등의 기본 용도에 맞지 않는 사용은 금지합니다. 
  - 원본형태로만 재 배포가 허용되며 수정한 소스는 재 배포할 수 없습니다.
  - 위즈몰에 쓰인 스킨의 저작권은 스킨 제작자에게 있으며 제작자의 동의하에 수정배포가 가능합니다.

* 위즈몰 정식버전 사용권

  - 정식으로 사용자등록을 하고 구입금액을 지불한 경우에만 사용이 허용되고, 사용기간 제한은 없습니다.
  - 정식 등록버젼은 저작권 표시를 삭제할수 있습니다. 
  - 정식 등록버젼에 대한 문의는 http://shop-wiz.com 에서 위즈몰 메뉴에서 찾아주시기 바랍니다. 
  - 1copy 지불금의 사용권한은 1개의 홈사이트(도메인기준)에 한정합니다.
  - 하나의 홈 사이트 내에서는 복사, 중복 설치에 제한을 두지 않습니다. 그러나 타인 또는 동일인 소유의 다른 홈사이트(도메인기준)에 추가 설치하고자 할 경우, 그에 따른 추가구입을 하여야 합니다. 서비스를 목적으로 한 2차 도메인의 홈 사이트의 경우도 각각의 도메인으로 간주합니다.
  - 타 홈페이지등에 링크를 해주는 링크 서비스는 불허입니다.
  - 정식등록 원본 소스는 http://shop-wiz.com 사이트에서 배포(판매) 됩니다.

* 제작사 책임및 의무

   - 본 프로그램 사용중 발생한 데이터 유실이나 기타 피해에 대해 제작사에서는 어떠한 책임도 지지 않습니다.
   - 위즈몰에 대해 위즈몰 개발자는 유지/ 보수의 의무가 없습니다.
   - 단 정식버전 판매이후에 프로그램 자체에서 치명적인 오류가 발견될 경우, 제작자 및 제작사는 이를 보완하여 다시 제공할 의무를 가집니다. 


※ 기타 의문사항은 http://shop-wiz.com의 위즈몰 메뉴를 이용해 주시기 바랍니다. (질문등에 대한 내용은 메일로 받지 않습니다) </textarea>
	<div class="step1_agree">
	
	<input type="checkbox" id="agree_chk" name="agree_chk">
	위 내용에 동의 합니다.
	</div>
	<div class="btn_box">
		<?
if(!is_dir("../../config")) ECHO"WebRoot에 config 디렉토리를 생성하시고 퍼미션을 707로 조절해 주세요";
else if(fileperms("../../config")!=16839 && fileperms("../../config")!=16895) ECHO "webroot/config 의 퍼미션을 707로 조절해 주세요. <span class='btn_reload button bull'><a>새로고침</a></span>";
else if(file_exists("../../config/db_info.php") && fileperms("../../config/db_info.php")!=33279 && fileperms("../../config/db_info.php")!=33223 && fileperms("../../config/db_info.php")!=33188) echo "webroot/config/db_info.php 의 퍼미션을 707로 조절해 주세요. <span class='btn_reload button bull'><a>새로고침</a></span>";
else{ 
?>
		<span class='btn_submit button bull'><a>설치</a></span> <span class='btn_cancel button bull'><a>취소</a></span>
		<?
}
?>
	</div>
</form>
</layout>
</body>
</html>
