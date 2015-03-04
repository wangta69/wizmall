<?
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/
include "../common/header_pop.php";

include ("../../config/common_array.php");


$flag = "mail";
if($query == "qin" && $common -> checsrfkey($csrf)){
	foreach($message as $key=>$value){
		//내용이 있으면 update  아니면 insert
		$sqlstr = "select count(1) from ".$WIZTABLE["MESSAGE"]."  where delivery_status = '$key' and flag='$flag'";
		$dbcon->_query($sqlstr);
		$list = $dbcon->_fetch_array() ;
		if($list[0]){//update
			$sqlstr = "update ".$WIZTABLE["MESSAGE"]." set message = '".$message[$key]."', subject = '".$subject[$key]."', enable='".$enable[$key]."' where delivery_status = '$key' and flag='$flag'";
			$dbcon->_query($sqlstr);
		}else{//insert
			$sqlstr = "insert into ".$WIZTABLE["MESSAGE"]." (flag, delivery_status, message, subject, enable) values('$flag','$key','".$message[$key]."','".$subject[$key]."', '".$enable[$key]."')";
			$dbcon->_query($sqlstr);
		}
	
	}
	//스킨을 일괄적으로 업데이트 한다.
	$sqlstr = "update ".$WIZTABLE["MESSAGE"]." set skin = '$MailSkin' where flag = 'mail'";
	$dbcon->_query($sqlstr);	
}

$title = "위즈몰 - 주문 관리 모드";
include "../common/header_html.php";
?>
<body>
<table>
	<tr>
		<td colspan="5">주문번호나 송장번호는 원하시는 위치에 아래와 같이 코딩하시면 입력됩니다.<br />
			주문번호 : {주문번호}<br />
			송장번호 : {송장번호}</td>
	</tr>
</table>
<form action='<?=$PHP_SELF?>' name=msg method="post">
	<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
	<input type="hidden" name="query" value='qin'>
	<table class="table_main w100p">
		<?
$enableMail = array("20","30","40","50");//필요한 주문단계에 따른 메시지창 디스플레이
foreach($enableMail as $key=>$value){
$list = $admin->getmessage_cont($value, $flag);
?>
		<tr>
			<td colspan="2"><?=$DeliveryStatusArr[$value]?>
				(
				<input type="checkbox" name="enable[<?=$value?>]" value="1" <? echo ($list["enable"])?"checked":"";?>> 사용) </td>
		</tr>
		<tr>
			<th>메일제목</th>
			<td><input name="subject[<?=$value?>]" type="text" id="Bsubject" value="<?=$list["subject"];?>" size="40"></td>
		</tr>
		<tr>
			<th>메일내용</th>
			<td><textarea name="message[<?=$value?>]" cols=40 rows=5 id="Bmessage"><?=$list["message"];?></textarea></td>
		</tr>
		<?
}//foreach($enableMail as $key=>$value){
?>
		<tr>
			<th>스킨</th>
			<td><select style="width: 160px" name=MailSkin>
					<?
$MailSkin = $list[skin];
$vardir = "../mailskin";
$open_dir = opendir($vardir);
        while($opendir = readdir($open_dir)) {
                if(($opendir != ".") && ($opendir != "..") && is_dir("$vardir/$opendir")) {
                        if($MailSkin == "$opendir") {
                                echo "<option value=\"$opendir\" selected>$opendir 스킨</option>\n";
                        }
                        else {
                                echo "<option value=\"$opendir\">$opendir 스킨</option>\n";
                        }
                }
        }
closedir($open_dir);
?>
				</select></td>
		</tr>
	</table>
	<br />
	<table 
>
		<tr>
			<td><table>
					<tr>
						<td><input type="image" src="../img/ju.gif" width="75"></td>
					</tr>
				</table></td>
		</tr>
	</table>
</form>
</body>
</html>
