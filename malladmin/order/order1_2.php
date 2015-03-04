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

include ("../../config/common_array.php");


$flag = "sms";
if($query == "qin" && $common -> checsrfkey($csrf)){
	foreach($message as $key=>$value){
		//내용이 있으면 update  아니면 insert
		$sqlstr = "select count(1) from ".$WIZTABLE["MESSAGE"]."  where delivery_status = '$key' and flag='$flag'";
		$result=$dbcon->get_one($sqlstr);
		if($result){//update
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

include "../common/header_html.php";
?>

<script>
var limitlen = 50;//제한글자수

function cutText(v) {
	var tmpStr = v.value;
	var szComplete = "";
	var tcount = 0;
	var onechar;
	
	for (k=0;k<tmpStr.length;k++) {
		onechar = tmpStr.charAt(k);
		
		if (escape(onechar).length > 4) {
			tcount += 2;
		}else if (onechar!='\r') {
			tcount++;
		}
	
		if (tcount > limitlen) {
			tmpStr = szComplete;
			v.value = tmpStr;
			eval("document."+v.form.name+".cbyte.value = limitlen");
			break;
		} else {
			szComplete = szComplete + onechar;
		}
	}
}

function cal_byte(v){
    var tmpStr;
    var temp=0;
    var onechar;
    var tcount;
    tcount = 0;

    tmpStr = new String(v.value);
    temp = tmpStr.length;

    for (k=0;k<temp;k++){
        onechar = tmpStr.charAt(k);

        if (escape(onechar).length > 4) {
            tcount += 2;
        }else if (onechar!='\r') {
            tcount++;
        }
    }

	$("#cbyte").val(tcount);

    if(tcount>limitlen) {
        reserve = tcount-limitlen;
        alert("메시지 내용은 "+limitlen+"바이트 이상은 전송하실수 없습니다.\r\n 쓰신 메세지는 "+reserve+"바이트가 초과되었습니다.\r\n초과된 부분은 자동으로 삭제됩니다.");
        cutText(v);
        return;
    }
}
</script>
<body>
<span><br />
SHOPWIZ 메세지 전송 서비스 - 휴대폰 문자전송 </span> 
<p class="orange">무선메시지</p>
<input name="cbyte" id="cbyte" class="w30">/50 bytes
<form action='<?=$PHP_SELF?>' name="msg" method="post">
	<input type="hidden" name="csrf" value="<?php echo $common -> getcsrfkey() ?>">
	<input type="hidden" name="query" value='qin'>
	<table class="table">
		<col width="120" />
		<col width="*" />
<?php
$enableMail = array("20","30","40","50");//필요한 주문단계에 따른 메시지창 디스플레이
foreach($enableMail as $key=>$value){
$list = $admin->getmessage_cont($value, $flag);
?>
    <tr> 
      <th><?=$DeliveryStatusArr[$value]?></th>
      <td> <textarea name="message[<?=$value?>]" cols=40 rows=3 id="MSG1" onKeyUp="javascript:cal_byte(this);" onFocus="javascript:cal_byte(this);"><?=$list["message"];?></textarea></td>
    </tr>
<?php
}//foreach($enableMail as $key=>$value){
?>    
  </table>

  <br />
	<div class="btn_box">
		<button type="button" onClick="javascript:document.forms[0].reset()">리셑</button>
		<button type="submit">저장</button>
	</div>
</form>
<br />
<span>※ 무선메시지는 구매자의 휴대폰으로 문자메시지를 보내는 기능입니다.<br />
※ 문자는 최대 50바이트 이하이어야 합니다.<br />
※ 발송된 문자메세지는 수신까지 대략 10초~2분 정도가 걸립니다.</span> 
</body>
</html>