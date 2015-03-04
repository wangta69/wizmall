<?
include "../../../lib/cfg.common.php";
include "../../../config/db_info.php";
include "../../../lib/class.database.php";
$dbcon	= new database($cfg["sql"]);

include "../../../lib/class.common.php";
$common = new common();

include "../../../lib/class.member.php";
$member = new member();
$member->get_object($dbcon, $common);

if($UserName && $UserJumin1 && $UserJumin2){
	$result = $member->isjumin($UserJumin1, $UserJumin2); //result 가 true 일경우 return $mid."|".$mname."|".$mgrantsta;
	
	if($result){
		$str="이미 가입된 주민 등록번호입니다.\\n패스워드 찾기를 이용해 주시기 바랍니다.\\n";
		$goto="../../../wizmember.php?query=idpasssearch";
		$common->js_alert($str, $goto);
	}else{
	
		$arr["UserJumin1"] = $UserJumin1;
		$arr["UserJumin2"] = $UserJumin2;
		$arr["UserName"] = $UserName;
		$arr["query"] = $next;
		$common->form_submit("../../../wizmember.php", $arr);

		//$goto = "../../../wizmember.php?UserJumin1=$UserJumin1&UserJumin2=$UserJumin2&UserName=".urlencode($UserName)."&query=".$next;
		//$common->js_location($goto);
	}
}else{
		$arr["query"] = $next;
		$common->form_submit("../../../wizmember.php", $arr);
}
//step3  값전송
?>