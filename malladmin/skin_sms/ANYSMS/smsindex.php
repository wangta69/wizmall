<?
		$BeforTime = time() - 5*60;
		$now_time = date("Y-m-d H:i:s");
?>	
<form name=SMS action="http://www.myhomesms.co.kr/gateway/별도코딩" method=post> 
<!-- tmrTime 은 발송 시간을 보내는 것이다. -->
<input type="hidden" name="hpCode" value="1111">
<input type=hidden name=strRvMbno value="<?=$sms_sender_tel?>"><!-- 발신자전화번호 -->
<input type=hidden name=strSdMbno value="<?=$sms_tel?>">
<input type=hidden name=strMsg value="<?=$sms_message?>">
<input type=hidden name=strID value="<?=$sms_sender_id?>"><!-- 발신자아이디 -->
<input type=hidden name=strCoID value="<?=$sms_sender_id?>"><!-- 발신자코드아이디 -->
<input type="hidden" name="iMsgCnt" value="1">
<input type=hidden name=rUrl value="위즈몰경로/malladmin/order1_1.php?uid=<?=$uid?>">
<input type=hidden name=tmrTime value="<?=$now_time?>">
<input type="hidden" name="strSdName" value="<?=$sms_sender_name?>"><!-- 발신자명 --> 
<input type=hidden name="Opt01" value="옵션1">

<input type=hidden name="Opt02" value="옵션2">
<input type=hidden name="Opt03" value="옵션3">
<input type=hidden name="Opt04" value="옵션3">
<input type=hidden name="Opt05" value="옵션3">
  <!-- <input type=submit value="전송"> -->
</form>
<script>
document.SMS.submit();
</script>