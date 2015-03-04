<?
/* 
powered by 폰돌
Reference URL : http://www.shop-wiz.com
Contact Email : master@shop-wiz.com
Free Distributer : 
Copyright shop-wiz.com
*** Updating List ***
*/
include ("./USER_CHECK.php");

$ctrn = "\n";

$SQL = "select * from wizMailAddressBook where userid='$HTTP_COOKIE_VARS[WIZMAIL_USER_ID]' order by binary name";
$dbcon->_query($SQL);
$Total = $dbcon->_num_rows();

/* 다운로드 해더 출력 */
if(strstr($HTTP_USER_AGENT, "MSIE 5.5")) 
{ 
	header("Content-Type: doesn/matter"); 
	header("Content-Disposition: filename=addrbook.csv"); 
	header("Content-Transfer-Encoding: binary"); 
	header("Pragma: no-cache"); 
	header("Expires: 0"); 
} 
else 
{ 
	Header("Content-type: file/unknown"); 
	Header("Content-Disposition: attachment; filename=addrbook.csv"); 
	Header("Content-Description: PHP4 Generated Data"); 
	header("Pragma: no-cache"); 
	header("Expires: 0"); 
} 

echo("이름, 그룹, 전자우편, 회사, 부서, 직책, 집전화번호, 사무실전화번호, 핸드폰번호, 팩스번호, 대표번호, 우편번호, 주소, 나머지주소$ctrn");

if($Total)
{
	$cnts = 0;
	while($list = $dbcon->get_rows())
	{
		$name		= $list["name"];
		$grp		= $list["grp"];
		$email		= $list["email"];
		$company	= $list["company"];
		$buseo		= $list["buseo"];
		$work		= $list["work"];
		$hphone		= $list["hphone"];
		$cphone		= $list["cphone"];
		$hand		= $list["hand"];
		$fax		= $list["fax"];
		$post		= $list["post"];
		$addr1		= $list["addr1"];
		$addr2		= $list["addr2"];
		$phone		= $list["phone"];
		
		echo("$name, $grp, $email, $company, $buseo, $work, $hphone, $cphone, $hand, $fax, $phone, $ppost, $addr1, $addr2 $ctrn");
		
		$cnts = $cnts + 1;
	}
}