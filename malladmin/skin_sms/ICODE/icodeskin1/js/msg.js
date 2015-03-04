function IsInteger(contents)   {
	for (j=0; (j<contents.length); j++) {
        if ((contents.substring(j,j+1) < "0")||(contents.substring(j,j+1) > "9")) {
        	return false;
        }
	}
	return true;
}

function add(str) {
	document.MsgForm.MSG_TXT.focus();
	document.MsgForm.MSG_TXT.value+=str; 
	ChkLen();
	return;
}
function ChkLen() {
	var pos;
	var msglen = 0;
	var len = MsgForm.MSG_TXT.value.length;
	for(i=0;i<len;i++){
		pos = MsgForm.MSG_TXT.value.charAt(i);
		if (escape(pos).length > 4)
			msglen += 2;
		else
			msglen++;
	}
    MsgForm.MSG_TXT_CNT.value = msglen;
	if(msglen > 70 )
		alert('문자메시지는 70바이트를 넘을 수 없습니다.');
   // MsgForm.MSG_TXT_CNT.value = msglen;

}

function CWCheck(form) {
    dest = document.all["sDest"]
	if (document.MsgForm.SendFlag[0].checked) { //바로보내기를 선택했을 경우
		sDest.style.display = "none";
	}
	else //예약전송일 경우
	{
		sDest.style.display = "block";	
	}
} 


function varcheck(){
	var content = document.MsgForm.MSG_TXT.value;
	var callback = document.MsgForm.callback.value;
    var sendphone = document.MsgForm.addcall.value;

	if(content == ""){
		alert("메시지를 입력해 주세요");
		document.MsgForm.MSG_TXT.focus();
		return false;
	}
	if(sendphone  == null || sendphone == "")
	{
		alert("수신자 번호를 입력해 주세요");
		document.MsgForm.addcall.focus();
		return false;
	}
	if(!IsInteger(sendphone))
	{
		alert('수신자 번호는 숫자만 가능합니다.');
		document.MsgForm.addcall.focus();
		return false;
	}
//	if(callback  == null || callback == "")
	//{
	//	alert("회신번호를 입력하세요");
	//	document.MsgForm.callback.focus();
	//	return false;
	//}
	if(!IsInteger(callback))
	{
		alert('발신번호는 숫자만 가능합니다.');
		document.MsgForm.callback.focus();
		return false;
	}

	//if(document.MsgForm.SendFlag[1].checked && document.MsgForm.R_YEAR.value.length!=4)
	//{
	//	alert("년도가 정확하지 않습니다.");
	//	document.MsgForm.R_YEAR.focus();
	//	return false;
	//}
	
	//if(document.MsgForm.SendFlag[1].checked && document.MsgForm.R_MONTH.value.length!=2)
	//{
	//	alert("월이 정확하지 않습니다.");
	//	document.MsgForm.R_MONTH.focus();
	//	return false;
	//}

	//if(document.MsgForm.SendFlag[1].checked && document.MsgForm.R_DAY.value.length!=2)
	//{
	//	alert("일이 정확하지 않습니다.");
	//	document.MsgForm.R_DAY.focus();
	//	return false;
	//}

}