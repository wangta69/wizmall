/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                                         JAVASCRIPT CODE                                          
  ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  function name                                                                           | description                                                                         | use process
  ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  moveFocus(num,fromform,toform)                                      | 주민번호, 사업자번호작성 후 자동 다음 폼 이동    onkeyup="moveFocus(6,this,document.UserRegisForm.juminno2)"        by Phondol 2003.08.13
  IsIntChk(strTmp)                                                                      |  정수검사
  filterNum(str)                                                      | str중 ^\$|, 글자를 빼기  new_num = filterNum(document.test.old_num.value);
  TypeCheck (s, spc)                                                  |  타입책크(영문자 및 숫자로만 사용책크)T ypeCheck(f.ID.value, ALPHA+NUM)
  commaSplit(srcNumber)                                               | 숫자에서 컴마를 제거
  SetComma(frm)														  | 필드에 값을 넣을 때 자동으로 comma책크 onkeyup=setComma(this)
  SpaceChk( str )					                                       | 공백책크
  IsEmailChk( str )					                               |  유효이메일검사
  IsJuminChk(jumin1, jumin2)                                                 | 유효주민번호 책크
    function FillBirth(jumin1, birthyear, birthmonth, birthday) | 생년월일 자동으로 채우기 사용법 onBlur=FillBirth()
  function chkWorkNum(reg_no1,reg_no2,reg_no3)          | 유효 사업자등록번호 책크

  function enter(field)									/Enter key 입력시 다음 필드로 넘기기  사용법 : onKeyPress="enter(this)"
  function option(maxvalue,num)                         /select button으로 날짜리스트 생성   <select><script>document.write(option(3,0));</script></select>
  function cal_round(num, roundval)                     | 소수자리를 반올림   cal_round(30,23456, 100) = 30,23 
  -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
var NUM = "0123456789"; 
var SALPHA = "abcdefghijklmnopqrstuvwxyz";
var ALPHA = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"+SALPHA;
var COMMA = ",";
var NUMALPHA = new RegExp('[^a-zA-Z0-9]'); //영문자와 숫자 책크
//regExp =/[^0-9]/gi;숫자만 입력



function moveFocus(num,fromform,toform){
    var str = fromform.value.length;
    if(str == num)
       toform.focus();
}

function IsIntChk(strTmp){
    var len, i, imsi;
    strTmp = "" + strTmp;
    len = strTmp.length;
    for(i=0; i<len; i++){
        imsi = strTmp.charAt(i);
        if(imsi<"0" || imsi>"9"){
        return false;
        }
    }
return true;
}

function filterNum(str)
{
    re = /^\$|,/g;
    str = String(str);
	replaceStr = str.replace(re, "");
    return parseInt(replaceStr);
} 

function TypeCheck (s, spc) {
var i;
	for(i=0; i< s.length; i++) {
		if (spc.indexOf(s.substring(i, i+1)) < 0) {
		return false;
		}
	}        
return true;
}


//컴마삭제하기
function RemoveComma(str){
	var rtnstr="";
	if (str){
		for (var i=0; i<str.length; i++){
			if (str.charAt(i)!=","){
				rtnstr += str.charAt(i);
			}
		}
	}
	return parseInt(rtnstr);
}

function commaSplit(srcNumber) { 
var txtNumber = '' + srcNumber; 
var rxSplit = new RegExp('([0-9])([0-9][0-9][0-9][,.])'); 
var arrNumber = txtNumber.split('.'); 
arrNumber[0] += '.'; 
	do { 
	arrNumber[0] = arrNumber[0].replace(rxSplit, '$1,$2'); 
	} 
	while (rxSplit.test(arrNumber[0])); 
	if (arrNumber.length > 1) { 
	return arrNumber.join(''); 
	} 
	else { 
	return arrNumber[0].split('.')[0]; 
	} 
}


function SetComma(frm) {
	var rtn = "";
	var val = "";
	var j = 0;
	x = frm.value.length;
	
		for(i=x; i>0; i--) {
		if(frm.value.substring(i,i-1) != ",") {
		val = frm.value.substring(i,i-1)+val;
		}
		}
	x = val.length;
		for(i=x; i>0; i--) {
		if(j%3 == 0 && j!=0) {
		rtn = val.substring(i,i-1)+","+rtn; 
		}else {
		rtn = val.substring(i,i-1)+rtn;
		}
		j++;
		}
	frm.value = rtn;
}


function SetComma1(value) {//","컴마를 붙이기
	str = value.toString();
	var rtn = "";
	var val = "";
	var j = 0;
	x = str.length;
	
	for(i=x; i>0; i--) {
		if(str.substring(i,i-1) != ",") {
			val = str.substring(i,i-1)+val;
		}
	}
	x = val.length;
	for(i=x; i>0; i--) {
		if(j%3 == 0 && j!=0) {
			rtn = val.substring(i,i-1)+","+rtn; 
		}else {
			rtn = val.substring(i,i-1)+rtn;
		}
	j++;
	}
	return rtn;
}

function SpaceChk( str )
{
     if(str.search(/\s/) != -1){
         return true;
     }else {
         return "";
     }
}

function IsEmailChk( str )
{
     /* check whether input value is included space or not  */
     if(str == ""){
         alert("이메일 주소를 입력하세요.");
         return false;
     }
     var retVal = SpaceChk( str );
     if( retVal != "") {
         alert("이메일 주소를 빈공간 없이 넣으세요.");
         return false;
     }
          
     /* checkFormat */
     var isEmail = /[-!#$%&'*+\/^_~{}|0-9a-zA-Z]+(\.[-!#$%&'*+\/^_~{}|0-9a-zA-Z]+)*@[-!#$%&'*+\/^_~{}|0-9a-zA-Z]+(\.[-!#$%&'*+\/^_~{}|0-9a-zA-Z]+)*/;
     if( !isEmail.test(str) ) {
         alert("이메일 형식이 잘못 되었습니다.");
         return 0;
     }
     if( str.length > 60 ) {
         alert("이메일 주소는 60자까지 유효합니다.");
         return false;
     }
/*
     if( str.lastIndexOf("daum.net") >= 0 || str.lastIndexOf("hanmail.net") >= 0 ) {
          alert("다음 메일 계정은 사용하실 수 없습니다.");
         document.forms[0].email.focus();  
         return 0;
     }
*/

     return true;
}


function IsJuminChk(jumin1, jumin2){
	if(jumin1 == "" || jumin2 == ""){
	alert("주민번호를 넣어주세요");
	return false;
	}
	if ((!TypeCheck(jumin1, NUM)) || (!TypeCheck(jumin2, NUM)) ) {
	alert("주민등록번호에 잘못된 문자가 있습니다. ");
	return false;
	}
	var i;
	chk = 0;
	for (i=0; i<6; i++) {
	chk += ( (i+2) * parseInt( jumin1.substring( i, i+1) ));
	}
	for (i=6; i<12; i++) {
	chk += ( (i%8+2) * parseInt( jumin2.substring( i-6, i-5) ));         
	}
	chk = 11 - (chk%11);
	chk %= 10;
	if (chk != parseInt( jumin2.substring(6,7))) {
	alert ("정확하지 않은 주민등록 번호입니다.");
	return false;
	}    

	if ((jumin1.length < 6) || (jumin2.length < 7)) {
	alert("입력하신 주민등록 번호가 정확하지 않습니다. ");
	return false;
	}
	return true;
}	

function FillBirth(jumin1, birthyear, birthmonth, birthday){
	birthY = jumin1.value.substr(0, 2);
	birthM = jumin1.value.substr(2, 2);
	birthD = jumin1.value.substr(4, 2);
	birthyear.value = "19"+birthY;
	birthmonth.value = birthM;
	birthday.value = birthD;
}

function chkWorkNum(reg_no1,reg_no2,reg_no3) { //사업자 등록 번호 구하는 자바 스크립트
    reg_no=reg_no1 + reg_no2 + reg_no3
        strNumb = reg_no; 
        
        sumMod        =        0; 
        sumMod        +=        parseInt(strNumb.substring(0,1)); 
        sumMod        +=        parseInt(strNumb.substring(1,2)) * 3 % 10; 
        sumMod        +=        parseInt(strNumb.substring(2,3)) * 7 % 10; 
        sumMod        +=        parseInt(strNumb.substring(3,4)) * 1 % 10; 
        sumMod        +=        parseInt(strNumb.substring(4,5)) * 3 % 10; 
        sumMod        +=        parseInt(strNumb.substring(5,6)) * 7 % 10; 
        sumMod        +=        parseInt(strNumb.substring(6,7)) * 1 % 10; 
        sumMod        +=        parseInt(strNumb.substring(7,8)) * 3 % 10; 
        sumMod        +=        Math.floor(parseInt(strNumb.substring(8,9)) * 5 / 10); 
        sumMod        +=        parseInt(strNumb.substring(8,9)) * 5 % 10; 
        sumMod        +=        parseInt(strNumb.substring(9,10)); 
         
        if (sumMod % 10 != 0) { 
                return false; 
        }
        return true; 
} 

function enter(field) {
  if (event.keyCode == 13) {
    var i;
    for (i = 0; i < field.form.elements.length; i++)
      if (field == field.form.elements[i])
        break;
	  i = (i + 1) % field.form.elements.length;
    field.form.elements[i].focus();
    return false;
  } else {
	  return true;
  }
}


function option(maxvalue,num){
	line = "";
	if (num==0)	{
		first = NowYear-maxvalue;
		last  = NowYear;
	}else{
		first = 1;
		last  = maxvalue;
	}
	for (i=first; i<last+1; i++)	{
		line += "<OPTION value="+i+">"+i;
	}
	return line;
}

function cal_round(num, roundval){
	var round_val = parseFloat(Math.round(num*roundval)/roundval);
	return round_val;
}

function getresizeTo(getwidth, getheight){//윈도우 리사이즈 보정하기
	var dH = 0;
	PL_pf=navigator.platform; 
	PL_av=navigator.appVersion; 
	if( PL_pf.indexOf('undefined') >= 0 || PL_pf == '' ) PL_os = 'UNKNOWN' ; 
	else PL_os = PL_pf ; 
	
	if( PL_os.indexOf('Win32') >= 0 ){ 
		if( PL_av.indexOf('98')>=0) PL_os = 'Windows 98' ; 
		else if( PL_av.indexOf('95')>=0 ) PL_os = 'Windows 95' ; 
		else if( PL_av.indexOf('Me')>=0 ) PL_os = 'Windows Me' ; 
		else if( PL_av.indexOf('NT')>=0 ) PL_os = 'Windows NT' ; 
		else PL_os = 'Windows' ; 
		
		if( PL_av.indexOf('NT 5.0')>=0) PL_os = 'Windows 2000' ; 
		if( PL_av.indexOf('NT 5.1')>=0) PL_os = 'Windows XP' ; 
		if( PL_av.indexOf('NT 5.2')>=0) PL_os = 'Windows Server 2003' ; 
	} 
		
	PL_pf_substr = PL_pf.substring(0,4); 
	
	if( PL_pf_substr == 'Wind'){ 
		if( PL_pf_substr == 'Win1') PL_os = 'Windows 3.1'; 
		else if( PL_pf_substr == 'Mac6' ) PL_os = 'Mac' ; 
		else if( PL_pf_substr == 'MacO' ) PL_os = 'Mac' ; 
		else if( PL_pf_substr == 'MacP' ) PL_os = 'Mac' ; 
		else if( PL_pf_substr == 'Linu' ) PL_os = 'Linux' ; 
		else if( PL_pf_substr == 'WebT' ) PL_os = 'WebTV' ; 
		else if( PL_pf_substr =='OSF1' ) PL_os = 'Compaq Open VMS' ; 
		else if( PL_pf_substr == 'HP-U' ) PL_os = 'HP Unix' ; 
		else if( PL_pf_substr == 'OS/2' ) PL_os = 'OS/2' ; 
		else if( PL_pf_substr == 'AIX4' ) PL_os = 'AIX'; 
		else if( PL_pf_substr == 'Free' ) PL_os = 'FreeBSD'; 
		else if( PL_pf_substr == 'SunO' ) PL_os = 'SunO'; 
		else if( PL_pf_substr == 'Drea' ) PL_os = 'Drea'; 
		else if( PL_pf_substr == 'Plan' ) PL_os = 'Plan'; 
		else PL_os = 'UNKNOWN'; 
	} 
	
	if(PL_os == "Windows XP")	dH = 20;
	window.resizeTo(parseInt(getwidth), parseInt(getheight) + parseInt(dH));	

}


function email_chk(v){
	var f=document.FrmUserInfo;
	if(v.value == "etc"){
		f.email_2.value = "";
		//f.email_2.style.display = "block"
	}else{
		f.email_2.value = v.value;
		//f.email_2.style.display = "none";
	}
}

function wizwindow(url,name,flag){
	var newwin = window.open(url,name,flag);
	if(newwin){
		newwin.focus();
	}else{
		alert('팝업창이 차단되어 있습니다.\n\n해제해 주세요');	
	}
}

// 유연한 책크폼 시작
/* <FORM name="form1" onSubmit="return chkForm(this)">
* input tag에 대한 설명 
* <input 
*    type="text" //체크할 형식 
*    name="id" //넘어갈이름 
*    msg="아이디" //경고창에 나타낼 문자열 
*    option="regId" //어떤 정규식으로 처리할지 선언 
*    checkenable //꼭 체크를 원하는 항목에 설정 
*    기존 name책크를 id 책크로 변경
* 동일 아이디 존재시 하나만 책크해도 됨
* 예 <input type="radio" name="chk[0]" id="check01" value="1" checkenable msg="갯수를 선택해주세요"> 
* -------------------
* <input type="radio" name="chk[1]" id="check01" value="2">
*<input type="checkbox" name="multichk[8][1]" id="multichk8" checkenable msg="Q9 : 선택해주세요">
* <input type="checkbox" name="multichk[8][2]" id="multichk8">
*<input type="text" name="desc[11]" id="desc11" checkenable msg="Q12 : 입력해주세요">
* <input name="semail" type="text" id="semail" checkenable msg="고객 이메일을 입력해 주세요" option="regMail">

* 바로 사용은 피하시고 다른 함수안에 넣어 처리해주세요
* function checkForm(){
*	var f=document.view_form;
*	if(autoCheckForm(f)) return true;
*	else return false;
}
***************************************/
function autoCheckForm(f)
{ 
    var i,currEl,currMsg;

    for(i = 0; i < f.elements.length; i++){ 
        currEl = f.elements[i]; 
        //필수 항목을 체크한다.  
        if (currEl.getAttribute("checkenable") != null) { 
			currMsg = currEl.getAttribute("msg");
            if(currEl.type == "TEXT" || currEl.type == "text" || 
               currEl.tagName == "SELECT" || currEl.tagName == "select" || 
               currEl.tagName == "TEXTAREA" || currEl.tagName == "textarea"){ 
                if(!chkText(currEl,currMsg)) return false; 

            } else if(currEl.type == "PASSWORD" || currEl.type == "password"){ 
                if(!chkText(currEl,currMsg)) return false; 

            } else if(currEl.type == "CHECKBOX" || currEl.type == "checkbox"){ 
                if(!chkCheckbox(f, currEl,currMsg)) return false; 

            } else if(currEl.type == "RADIO" || currEl.type == "radio"){ 
                if(!chkRadio(f, currEl,currMsg)) return false; 

            }
        }
        // 입력 페턴을 체크한다.
        if(currEl.getAttribute("option") != null && currEl.value.length > 0){ 
            if(!chkPatten(currEl,currEl.option,currMsg)) return false; 
        } 
    }

	return true;
}  

function chkPatten(field,patten,msg)
{ 
    var regNum =/^[0-9]+$/; 
    var regPhone =/^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$/; 
    var regMail =/^[_a-zA-Z0-9-]+@[._a-zA-Z0-9-]+.[a-zA-Z]+$/; 
    var regDomain =/^[.a-zA-Z0-9-]+.[a-zA-Z]+$/; 
    var regAlpha =/^[a-zA-Z]+$/; 
    var regHost =/^[a-zA-Z-]+$/; 
    var regHangul =/[가-힣]/; 
    var regHangulEng =/[가-힣a-zA-Z]/; 
    var regHangulOnly =/^[가-힣]*$/; 
    var regId = /^[a-zA-Z]{1}[a-zA-Z0-9_-]{4,15}$/; 
    var regDate =/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/; 

    patten = eval(patten); 
    if(!patten.test(field.value)){ 
        alert(msg + "\n항목의 형식이 올바르지 않습니다."); 
        field.focus(); 
        return false; 
    } 
    return true; 
} 

function chkText(field, msg)
{ 
    if(field.value.trim().length < 1){ 
        alert(msg); 
        field.focus(); 
        return false; 
    } 
    return true; 
}

function chkCheckbox(form, field, msg)
{
    fieldname = eval(form.name+'.'+field.id);
	if (fieldname.length == undefined) {//배열이 아니라 하나의 단일값 존재
		fieldname.length = 1;
		fieldname[0] = fieldname;
	}
	for( i = 0, nChecked = 0; i < fieldname.length; i++) if( fieldname[i].checked) nChecked++;
	if(!nChecked){
        alert(msg); 
        field.focus(); 
        return false; 
	}
	/*
    if (!fieldname.checked){
        alert(msg); 
        field.focus(); 
        return false; 
    }
	*/
    return true; 
}

function chkRadio(form, field, msg)
{
    fieldname = eval(form.name+'.'+field.id);
    for (i=0;i<fieldname.length;i++) {
        if (fieldname[i].checked)
            return true; 
    }
    alert(msg); 
    field.focus(); 
    return false; 
} 

function radiocheck(name){//name : documnet.Forms.name
var namelength = name.length
 for(i=0; i<namelength; i++){ 
 	if(name[i].checked==true) return true;
 }
}

function  checkboxcheck(name){
var i = 0;
var chked = 0;

	for(i = 0; i < name.length; i++ ) {
		if(name[i].checked) {
			chked++;
		}
	}
	if( chked < 1 ) {
		alert('한개이상 체크해주시기 바랍니다.');
		return false;
	}
}
// 유연한 책크폼 끝


// 주민번호를 이용한 성별책크
function setGender(f,jumin2,type){
	//type :select or text
	if(document.fm.sex!=null){
	var ngender=jumin2.charAt(0);
	if(ngender==1||ngender==3) f.gender[0].checked=true;
	else if(ngender==2||ngender==4) f.gender[1].checked=true;
	
	setBirthday(ngender);
	}
}

//주민번호를 이용한 생년월일 책크
function setBirthday(f,x){

	if(f.birthdayy!=null){
		var num =f.pubnum1.value;
		var xx=new String();
		if(x==1||x==2) xx="19";
		else if(x==3||x==4) xx="20";
		
		f.birthdayy.value = xx + num.substring(0,2);
		f.birthdaym.value = num.substring(2,4);
		f.birthdayd.value = num.substring(4,6);
	}
}

//숫자만 책크
function onlyNumber() {//onkeydown='onlyNumber();'
	if((event.keyCode<48)||(event.keyCode>57)){
		alert('숫자만 입력하세요');
		event.returnValue=false; 
	}
}

function is_number(){//상기 onlyNumber 로 통일
	 if ((event.keyCode<48)||(event.keyCode>57)){
		  alert("\n\n수량은 숫자만 입력하셔야 합니다.\n\n");
		  event.returnValue=false;
	 }
}



//영자만책크
function onlyAlpha(kcode) { 
	alert(kcode);
	alert(event.keyCode);
	if((event.keyCode<65)||(event.keyCode>90))
	if((event.keyCode<97)||(event.keyCode>122)){
		alert('영자만 입력하세요');
		event.returnValue=false;
	}
} 

function onlyAlphaNum(v) { 
  if (NUMALPHA.test(v.value)) {
	  alert('영자만 입력하세요');
	  v.value = returnlen(v.value);
  }
}

function returnlen(str){
	var len, tmp
	tmp = "";
    len = str.length;
    for(i=0; i<len-1; i++){
        tmp = tmp+str.charAt(i);
    }
	return tmp
}
/*
function onlyAlphaNum() { 
	var flag = false;
	
	if(event.keyCode>=65 && event.keyCode<=90) flag = true;
	if(event.keyCode>=97 && event.keyCode<=122) flag = true;
	if(event.keyCode>=48 && event.keyCode<=57) flag = true;
	alert(event.keyCode+","+flag)
	//event.returnValue= flag; 
} 
*/
//페이지이동스크립트
//이부분을 적용함으로서 기존 CURRENT_PAGE 변수를 CP로 일괄통일
/*function gotoPage(page,f){
	f.CP.value = page;
	f.submit();	
}
*/

//챜크박스 선택시 모든 책크박스 선택혹은 해제
// 사용예 onClick = setCheckboxes(this);
function setCheckboxes(v)
{    
	var do_check = v.checked
	var the_form = v.form.name; 
	// var elts      = document.forms[the_form].elements['selected_propose[]'];
	var elts      = document.forms[the_form].elements;
	var elts_cnt  = (typeof(elts.length) != 'undefined') ? elts.length : 0;
	
	if (elts_cnt) {
		for (var i = 0; i < elts_cnt; i++) {
			elts[i].checked = do_check;
		} // end for
	} else {
		elts.checked        = do_check;
	} // end if... else
	
	return true;
} 

//책크박스의 책크갯수 구하기
function getcheckcnt(f){
	var i = 0;
	var checkboxcnt = 0;
	var elts      = f.elements;
	var elts_cnt  = (typeof(elts.length) != 'undefined') ? elts.length : 0;	
	for(i = 0; i < elts_cnt; i++ ) {
		if(elts[i].type == 'checkbox' && elts[i].checked) {
			checkboxcnt++;
		}
	}
	return checkboxcnt;
}

function getRadiovalue(v)
{
	var radiovalue;
    for (i=0;i<v.length;i++) {
        if (v[i].checked) radiovalue = v[i].value;
    }
    return radiovalue; 
} 

function urlCopy(value,flag) { 
	window.clipboardData.setData('Text', value); 
	alert("게시물의 주소가 복사되었습니다.\n'CTRL+V' 를 이용하여 붙여넣기 하세요. "); 
} 


// 문자의 앞뒤 공백문자 제거
String.prototype.trim = function ()
{
    return this.replace(/^ *| *$/g, "");
}

String.prototype.ltrim = function() {
	return this.replace(/^\s+/,"");
}

String.prototype.rtrim = function() {
	return this.replace(/\s+$/,"");
}

//var str = 문자열.replaceAll("a", "1"); 
String.prototype.replaceAll = function(str1, str2)
{
	var temp_str = "";
	if (this.trim() != "" && str1 != str2)
	{
		temp_str = this.trim();
		while (temp_str.indexOf(str1) > -1)
		{
			temp_str = temp_str.replace(str1, str2);
		}
	}
	return temp_str;
}
//var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
//	document.getElementById('NAME').value = document.getElementById('NAME').value.replace(pattern, "");

	//미성년 여부 체크
	function birthday_chk(yyyymmdd)
	{
		alert("birthday_chk start : "+yyyymmdd);
		var adt = 19; // 성년 나이
		var adt_max = 100; // 100세
		var d = new Date();
		var y = d.getFullYear();
		var m = (d.getMonth() + 1);
		var d = d.getDate();

		// 날짜 포맷 맞추기
		if(m < 10) m = '0' + m;
		if(d < 10) d = '0' + d;
		var birthday_y	= parseInt(yyyymmdd.substr(0,4));
		var birthday_m	= yyyymmdd.substr(4,2);
		var birthday_d	= yyyymmdd.substr(6,2);
		var birthday_md	= yyyymmdd.substr(4,4);
		var age				= y - birthday_y;

		if(birthday_y < parseInt(y - adt_max) || (parseInt(birthday_m) < 1 || parseInt(birthday_m) > 12) || (parseInt(birthday_d) < 1 || parseInt(birthday_d) > 31))
		{
			return false;//생년월일이 맞지 않음
		}

		if(age < adt || (age == adt && parseInt(('1' + birthday_md)) > parseInt(('1' + m + d))))
		{
			return false;//미성년자
		}


		return true;//성인인증
	}



//포커싱이 발생할경우 blur 시키기(일부페이지에 문제점 발생)
function bluring(){ 
//alert(event.srcElement.tagName);
//if(event.srcElement.tagName=="a"||event.srcElement.tagName=="img") document.body.focus(); 
//if(event.srcElement.tagName=="input" && event.srcElement.tagName=="img") document.body.focus();
} 
//document.onfocusin=bluring; 