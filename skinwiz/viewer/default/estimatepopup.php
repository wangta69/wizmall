<?
/* 
제작자 : 폰돌
URL : http://www.shop-wiz.com
Email : master@shop-wiz.com
*** Updating List ***
*/

include "../../../lib/cfg.common.php";
include "../../../config/db_info.php";

include "../../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);

include "../../../lib/class.common.php";
$common = new common();
$common->pub_path = "../../../";
$cfg["member"] = $common->getLogininfo();//로그인 정보를 가져옮

include ("../../../lib/class.wizmall.php");
$mall = new mall;
$mall->get_object($dbcon,$common);
$mall->cfg = $cfg;

	
if(!strcmp($mode,"write")) $mall->pd_write_estim($_POST,"pop");


// 상품정보 가져오기
$sqlstr = "select m.Name, m.Category, c.cat_name from wizMall m left join wizCategory c on m.Category = c.cat_no where m.UID = '$GID'";
$sqlqry = $dbcon->_query($sqlstr);
$list	= $dbcon->_fetch_array($sqlqry);
$Name		= $list["Name"];
$cat_name	= $list["cat_name"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>상품평 쓰기</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["common"]["lan"]?>">
<link rel="stylesheet" href="../../../css/base.css" type="text/css" />
<link rel="stylesheet" href="../../../css/common.css" type="text/css" />
<link rel="stylesheet" href="../../../css/mall.css" type="text/css" />
<script src="../../../js/AC_RunActiveContent.js" type="text/javascript"></script>
<script language=javascript src="../../../js/jquery.min.js"></script>
<script src="../../../js/wizmall.js" type="text/javascript"></script>
<script language="JavaScript">
<!--
function checkForm(f){
	if(f.ID.value == ''){
		alert('로그인후 이용해 주세요');
		return false;
	} else if(f.Subject.value == ''){
		alert('제목을 입력해주세요');
		f.Subject.focus();
		return false;
	} else if(!f.Grade[0].checked && !f.Grade[1].checked && !f.Grade[2].checked && !f.Grade[3].checked && !f.Grade[4].checked){
		alert('상품선호도를 입력해주세요');
		f.Grade[0].focus();
		return false;
	} else if(f.Contents.value == ''){
		alert('상품사용후기를 입력해주세요');
		f.Contents.focus();
		return false;
	}
}
//-->
</script>
</head>
<body>
<img src="./images/prdpop_h1.gif" width="554" height="89">
<form name="estimat" action="<?=$PHP_SELF?>" onsubmit='return checkForm(this);' method="post">
		<input type="hidden" name="mode" value="write">
		<input type="hidden" name="query" value="<?=$query?>">
		<input type="hidden" name="code" value="<?=$code?>">
		<input type="hidden" name="no" value="<?=$no?>">
		<input type="hidden" name="GID" value="<?=$GID?>">
		<input type="hidden" name="Name" value="<?=$cfg["member"]["mname"]?>">
		<input type="hidden" name="ID" value="<?=$cfg["member"]["mid"]?>">
	<table class="w100p">

		<tr>
			<td><img src="./images/prdpop_co1.gif" width="35"></td>
			<td> : <?=$cfg["member"]["mname"]?></td>
		</tr>
		<tr>
			<td background="./images/bg_w.gif" colspan="2"></td>
		</tr>
		<tr>
			<td><img src="./images/prdpop_co2.gif" width="35"></td>
			<td> : <input name="Subject" type="text" id="Subject"></td>
		</tr>
		<tr>
			<td background="./images/bg_w.gif" colspan="2"></td>
		</tr>
		<tr>
			<td><img src="./images/prdpop_co5.gif" width="74"></td>
			<td><table>
					<tr>
						<td><input type="radio" name="Grade" value="5"></td>
						<td><img src="images/star5.gif"></td>
						<td><input type="radio" name="Grade" value="4"></td>
						<td><img src="images/star4.gif"></td>
						<td><input type="radio" name="Grade" value="3"></td>
						<td><img src="images/star3.gif"></td>
					</tr>
					<tr>
						<td><input type="radio" name="Grade" value="2"></td>
						<td><img src="images/star2.gif"></td>
						<td><input type="radio" name="Grade" value="1"></td>
						<td><img src="images/star1.gif"></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table></td>
		</tr>
		<tr>
			<td background="./images/bg_w.gif" colspan="2"></td>
		</tr>
		<tr>
			<td><img src="./images/prdpop_co3.gif"></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2"><textarea name="Contents" rows="5" id="Contents" class="w100p"></textarea></td>
		</tr>
	</table>
	<div class="btn_box">
		<input type="submit" name="Submit" value="쓰기">
		<input type="button" name="Submit2" value="닫기" onClick="window.close()" style="cursor:pointer">
	</div>
</form>
</body>
</html>
