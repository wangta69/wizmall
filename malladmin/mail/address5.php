<?php
/*
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Copyright shop-wiz.com
*** Updating List ***
*/
include ("../config/cfg.core.php");
$user_id = "admin";
if($query == "save"){
		$date = time();
		$post = $post1."-".$post2;
$hphone = $hphone1."-".$hphone2."-".$hphone3;/* 집 전화번호 조합 */
$cphone = $cphone1."-".$cphone2."-".$cphone3;/* 회사 전화번호 조합 */
$hand = $hand1."-".$hand2."-".$hand3;/* 핸드폰 번호 조합 */
$fax = $fax1."-".$fax2."-".$fax3;/* 팩스 번호 조합 */

/* 쿼리문 조합 */
$sqlstr = "insert into wizMailAddressBook values ('','$user_id ','$name','$grp','$email',
'$company','$buseo','$work','$hphone','$cphone','$hand','$fax','$post','$addr1','$addr2','$memo','$date','0','$phone')";

$dbcon->_query($sqlstr);
echo "<script >window.alert('성공적으로 저장되었습니다.');location.replace('$PHP_SELF?menushow=$menushow&theme=$theme');</script>";

}

if($query == "modify"){
$post = $post1."-".$post2;

$hphone = $hphone1."-".$hphone2."-".$hphone3;/* 집 전화번호 조합 */
$cphone = $cphone1."-".$cphone2."-".$cphone3;/* 회사 전화번호 조합 */
$hand = $hand1."-".$hand2."-".$hand3;/* 핸드폰 번호 조합 */
$fax = $fax1."-".$fax2."-".$fax3;/* 팩스 번호 조합 */

/* 쿼리문 조합 */
$sqlstr = "update wizMailAddressBook set
name='$name',grp='$grp',email='$email',company='$company',buseo='$buseo',work='$work',
hphone='$hphone',cphone='$cphone',hand='$hand',fax='$fax',post='$post',addr1='$addr1',addr2='$addr2',memo='$memo',phone='$phone'
 where idx = '$idx'";
 //echo "\$sqlstr = $sqlstr <br />";
$dbcon->_query($sqlstr);
echo "<script >window.alert('성공적으로 저장되었습니다.');location.replace('$PHP_SELF?menushow=$menushow&theme=$theme&mode=modify&idx=$idx');</script>";
}

/*
CREATE TABLE wizMailAddressBook (
  idx,userid,name,grp,email,company,buseo,work,hphone,cphone,hand,fax,post,addr1,addr2,memo,date,shard,phone

*/

if($idx):
	$sqlstr = "select * from wizMailAddressBook where idx = '$idx' and userid='".$user_id."'";
	$dbcon->_query($sqlstr);
	$list = $dbcon->_fetch_array();
	$zip	= explode("-", $list["post"]);
	$hphone	= explode("-", $list["hphone"]);
	$cphone	= explode("-", $list["cphone"]);
	$hand	= explode("-", $list["hand"]);
	$fax	= explode("-", $list["fax"]);
endif;
?>
<script>
function sendit() 
{
var f = document.WizMailFrm;
        if (f.name.value == '') {
            alert('\n이름을 입력해 주세요!\n\n');
			f.name.focus();
            return;
        }
		f.submit();
        
}

function OpenZipcode(){
	window.open("../util/zipcode/zipcode.php?form=WizMailFrm&zip1=post1&zip2=post2&firstaddress=addr1&secondaddress=addr2","ZipWin","width=490,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no");
}
</script>
<div class="table_outline">
	<div class="panel panel-success">
	  <div class="panel-heading">
<?php		  
switch($LB){
	case "group":echo("그룹 관리");break;
	default:echo("주소록 관리");break;
}
?></div>
	  <div class="panel-body">
		 
	  </div>
	</div>
	
	<form action='<?=$PHP_SELF?>' name='WizMailFrm' method='post'>
		<input type='hidden' name='menushow' value='<?=$menushow?>'>
		<input type='hidden' name='theme' value='<?=$theme?>'>
		<? if(!isset($mode)) $mode = "save"; ?>
		<input type='hidden' name='query' value='<?=$mode?>'>
		<input type='hidden' name='idx' value='<?=$idx?>'>
		주소추가(*)는 필수 입력 사항입니다.
		<table class="table">
			<tr>
				<th>이름 *</th>
				<td><input name="name" type='text' value="<?=$list["name"]?>" size='25' maxlength='10'></td>
			</tr>

        <tr> 
			<th>그룹</td>
			<td><select name='grp' class='select'>
<?php
$sqlstrg = "select * from wizMailAddressBookG where userid='".$user_id."' order by idx asc";
$sqlqryg = $dbcon->_query($sqlstrg);
while($listg = $dbcon->_fetch_array($sqlqryg)):
if($list["grp"] == $listg["idx"]) $selected = "selected";
else unset($selected);
echo "<option value='".$listg["idx"]."' $selected >".$listg["subject"]."</option>";

endwhile;
?>
            </select></td>
        </tr> 
			<tr>
				<th>전자우편</th>
				<td><input name='email' type='text' value="<?=$list["email"]?>" maxlength='60' class="w200"></td>
			</tr>
			<tr>
				<th>회사</th>
				<td><input name='company' type='text' value="<?=$list["company"]?>"></td>
			</tr>
			<tr>
				<th>부서</th>
				<td><input name='buseo' type='text' value="<?=$list["buseo"]?>"></td>
			</tr>
			<tr>
				<th>직책</th>
				<td><input name='work' type='text' value="<?=$list["work"]?>"></td>
			</tr>
			<tr>
				<th>집 전화번호</th>
				<td><input name='hphone1' type='text' value="<?=$hphone[0]?>" class="w30" maxlength='3'>
					-
					<input name='hphone2' type='text' value="<?=$hphone[1]?>" class="w30" maxlength='4'>
					-
					<input name='hphone3' type='text' value="<?=$hphone[2]?>" class="w30" maxlength='4'>
					<input name='phone' type='radio' value='1' checked>
					대표번호</td>
			</tr>
			<tr>
				<th>사무실 전화번호</th>
				<td><input name='cphone1' type='text' value="<?=$cphone[0]?>" class="w30" maxlength='3'>
					-
					<input name='cphone2' type='text' value="<?=$cphone[1]?>" class="w30" maxlength='4'>
					-
					<input name='cphone3' type='text' value="<?=$cphone[2]?>" class="w30" maxlength='4'>
					<input name='phone' type='radio' value='2'>
					대표번호</td>
			</tr>
			<tr>
				<th>핸드폰번호</th>
				<td><input name='hand1' type='text' value="<?=$hand[0]?>" class="w30" maxlength='3'>
					-
					<input name='hand2' type='text' value="<?=$hand[1]?>" class="w30" maxlength='4'>
					-
					<input name='hand3' type='text' value="<?=$hand[2]?>" class="w30" maxlength='4'>
					<input name='phone' type='radio' value='3'>
					대표번호</td>
			</tr>
			<tr>
				<th>팩스번호</th>
				<td><input name='fax1' type='text' value="<?=$fax[0]?>" class="w30" maxlength='3'>
					-
					<input name='fax2' type='text' value="<?=$fax[1]?>" class="w30" maxlength='4'>
					-
					<input name='fax3' type='text' value="<?=$fax[2]?>" class="w30" maxlength='4'>
					<input name='phone' type='radio' value='4'>
					대표번호
				</td>
			</tr>
			<tr>
				<th>주소</th>
				<td><input name='post1' type='text'  id="post1" value="<?=$zip[0]?>" class="w30" maxlength='3'>
					-
					<input name='post2' type='text'  id="post2" value="<?=$zip[1]?>" class="w30" maxlength='3'>
					<span class="button bull"><a href='javascript:OpenZipcode();'>우편번호검색</a></span><br />
					<input name='addr1' type='text'  id="addr1" value="<?=$list["addr1"]?>" class="w300">
					<br />
					<input name='addr2' type='text'  id="addr2" value="<?=$list["addr2"]?>" class="w300">
				</td>
			</tr>
			<tr>
				<th>기타</th>
				<td><textarea name='memo' rows='6' class="w100p"><?=$list["memo"]?></textarea></td>
			</tr>
		</table>
		<div class="btn_box"> <span class="button bull"><a href='javascript:sendit()'>확인</a></span> <span class="button bull"><a href='javascript:history.back()'>취소</a></span> </div>
	</form>
			
			
</div>