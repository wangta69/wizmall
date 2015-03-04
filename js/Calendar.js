

var gNow = new Date();
var ggWinCal;

Calendar.Months = ["1","2","3","4","5","6","7","8","9","10","11","12"];

// 비윤년 Month days..
Calendar.DOMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
// 윤년 Month days..
Calendar.lDOMonth= [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

// 달력 클래스 정의
function Calendar(pItem, pWinCal, pMonth, pYear, pFormat)
{
	if ((pMonth == null) && (pYear == null))	return;

	if (pWinCal == null)
		this.gWinCal = ggWinCal;
	else
		this.gWinCal = pWinCal;

	if (pMonth == null) {
		this.gMonthName = null;
		this.gMonth = null;
	} else {
		this.gMonthName = Calendar.getMonth(pMonth);
		this.gMonth = new Number(pMonth);
	}

	this.gYear = pYear;
	this.gFormat = pFormat;
	this.gReturnItem = pItem;
}

Calendar.getMonth = CalendarGetMonth;
Calendar.getDaysofmonth = CalendarGetDaysofmonth;
Calendar.calcMonthYear = CalendarCalcMonthYear;
Calendar.print = CalendarPrint;

//월
function CalendarGetMonth(monthNo)
{
	return Calendar.Months[monthNo];
}

//월의 일수
function CalendarGetDaysofmonth(monthNo, pYear)
{
	//윤년 Check
	if ((pYear % 4) == 0) {								//년을 4로 나눈 나머지가 0이면 윤년
		if ((pYear % 100) == 0 && (pYear % 400) != 0)	//년을 100으로 나눈 나머지가 0이고 년을 400으로 나눈나머지가 0이 아니면 평년
			return Calendar.DOMonth[monthNo];

		return Calendar.lDOMonth[monthNo];
	} else
		return Calendar.DOMonth[monthNo];
}

//년월 가감 계산
function CalendarCalcMonthYear(pMonth, pYear, incr)
{
	var retArr = new Array();

	if (incr == -1) {
		// 이전년/월
		if (pMonth == 0) {
			retArr[0] = 11;
			retArr[1] = parseInt(pYear) - 1;
		}
		else {
			retArr[0] = parseInt(pMonth) - 1;
			retArr[1] = parseInt(pYear);
		}
	} else if (incr == 1) {
		// 다음년/월
		if (pMonth == 11) {
			retArr[0] = 0;
			retArr[1] = parseInt(pYear) + 1;
		}
		else {
			retArr[0] = parseInt(pMonth) + 1;
			retArr[1] = parseInt(pYear);
		}
	}

	return retArr;
}

//달력인쇄
function CalendarPrint()
{
	ggWinCal.print();
}

//new Calendar();

//달력 HTML 코드 생성
Calendar.prototype.getMonthlyCalendarCode = function()
{
	var vCode = "";
	var vHeader_Code = "";
	var vData_Code = "";

	// 달력 테이블
	vCode = vCode + "<table border=1 bordercolor='#FFFFFF' cellpadding=0 cellspacing=0 bordercolorlight='#72B6CB' width=227>";
	vHeader_Code = this.calHeader();
	vData_Code = this.calData();
	vCode = vCode + vHeader_Code + vData_Code;
	vCode = vCode + "</table>";

	return vCode;
}

//달력을 보여준다.
Calendar.prototype.show = function()
{
	var vCode = "";

	this.gWinCal.document.open();

	// 이전년/월
	var prevMMYYYY = Calendar.calcMonthYear(this.gMonth, this.gYear, -1);
	var prevMM = prevMMYYYY[0];
	var prevYYYY = prevMMYYYY[1];
	//다음년/월
	var nextMMYYYY = Calendar.calcMonthYear(this.gMonth, this.gYear, 1);
	var nextMM = nextMMYYYY[0];
	var nextYYYY = nextMMYYYY[1];

	var head = "<b>"+this.gYear + "년&nbsp;" + this.gMonthName+"</b>";

	var prevYear = "\"window.opener.Build(" +
	"'" + this.gReturnItem+"','"+this.gMonth+"','"+(parseInt(this.gYear)-1)+"','"+this.gFormat+"'"+")\" ";

	var prevMonth = "\"window.opener.Build(" +
	"'" + this.gReturnItem + "', '" + prevMM + "', '" + prevYYYY + "', '" + this.gFormat + "'" + ")\" ";

	var nextYear = "\"window.opener.Build(" +
	"'" + this.gReturnItem+"','"+this.gMonth+"','"+(parseInt(this.gYear)+1)+"','"+this.gFormat+"'"+")\" ";

	var nextMonth = "\"window.opener.Build(" +
	"'"+this.gReturnItem+"','"+nextMM+"','"+nextYYYY+"','"+this.gFormat+"'"+")\" ";


	// Setup the page...
	this.wwrite("<html>"+"\n"+
	"<head><title>달력</title>" +"\n"+
	"<style type='text/css'>\n<!--"+"\n"+
	"BODY{FONT-SIZE: 10pt; font-family:돋움;leftmargin=0 ;topmargin=0}"+"\n"+
	".datacenter{ TEXT-ALIGN: center;font-size:9pt;}"+"\n"+
	".center{	TEXT-ALIGN: center;}"+"\n"+
    ".searchin {  font-family: 굴림; font-size: 9pt; border-style: none}"+"\n"+
    ".font2 {  font-family: 굴림; font-size: 9pt}"+"\n"+
	".font {  font-family: 굴림; font-size: 9pt;color:#004F62}"+"\n"+
	" td#sun {font-size:10pt; color:#CC0000; background-color:#FFF7F7; height:26}"+"\n"+
	" td#sat {font-size:10pt; color:#0033CC; background-color:#EFFDFF; height:26}"+"\n"+
	" td#gen {font-size:10pt; background-color:#FFFFFF; height:26}"+"\n"+
	" td#hsun {cursor:hand; font-size:10pt; color:#CC0000; background-color:#FFF7F7; height:26;}"+"\n"+
	" td#hsat {cursor:hand; font-size:10pt; color:#0033CC; background-color:#EFFDFF; height:26;}"+"\n"+
	" td#hgen {cursor:hand; font-size:10pt; background-color:#FFFFFF; height:26;}"+"\n"+
	"-->\n</style>"+"\n"+
	this.getScriptCode()+"\n"+
	"</head>"+"\n"+
	"<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=#ffffff  onLoad=\"MM_preloadImages('images/button/buttonCalendarPrev2.gif','images/button/buttonCalendarNext2.gif','images/button/buttonCalendarEnd2.gif','images/button/buttonCalendarHome2.gif')\">"+"\n"+
	"<table width=252 width=227 border=0 cellspacing=0  cellpadding=0 bgcolor=#F2FDFF>"+"\n"+
	"  <tr>"+"\n"+
	"    <td colspan=3  class=font2 ><img src=\"img_Calendar/cal04.gif\" width=252 heignt=9></td>"+"\n"+
	"  </tr>"+"\n"+
	"  <tr height=100%>"+"\n"+
	"    <td width=7 background=\"img_Calendar/cal01.gif\">&nbsp;</td>"+"\n"+
	"    <td height=28 class=center>"+"\n"+
	"    <span style='cursor:hand' onclick="+prevYear+" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image10','','img_Calendar/cal_btn01_over.gif',1)\">"+"\n"+
	"    <img name=Image10 border=0 src=\"img_Calendar/cal_btn01.gif\"  align=absmiddle></span>"+"\n"+
	"    <span style='cursor:hand'onclick="+prevMonth+" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image11','','img_Calendar/cal_btn02_over.gif',1)\">"+"\n"+
	"      <img name=Image11 border=0 src=\"img_Calendar/cal_btn02.gif\" align=absmiddle></span>"+"\n"+
	"    <b><font color=#00578E class=font2>"+this.gYear+"</font><font class=font2>년</font>&nbsp;<font color=#FF9600 class=font2>"+this.gMonthName+"</font><font class=font2>월</font></b>"+"\n"+
	"    <span style='cursor:hand'onclick="+nextMonth+" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image12','','img_Calendar/cal_btn03_over.gif',1)\">"+"\n"+
	"    <img name=Image12 border=0 src=\"img_Calendar/cal_btn03.gif\"  align=absmiddle></span>"+"\n"+
	"    <span style='cursor:hand'onclick="+nextYear+" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image9','','img_Calendar/cal_btn04_over.gif',1)\">"+"\n"+
	"    <img name=Image9 border=0 src=\"img_Calendar/cal_btn04.gif\" align=absmiddle></span>"+"\n"+
	"    </td>"+"\n"+
	"    <td width=7 background=\"img_Calendar/cal02.gif\">&nbsp;</td>"+"\n"+
	"  </tr>"+"\n"+
	"  <tr>"+"\n"+
	"    <td width=7 background=\"img_Calendar/cal01.gif\">&nbsp;</td>"+"\n"+
	"    <td align=center height=195  valign=top><div style=margin-top:7>"+"\n"+
	this.getMonthlyCalendarCode()+"\n"+	// 달력표시
	"    </div></td>"+"\n"+
	"    <td width=7 background=\"img_Calendar/cal02.gif\">&nbsp;</td>"+"\n"+
	"  </tr>"+"\n"+
	"  <tr>"+"\n"+
	"    <td colspan=3 class=font2 ><img src=\"img_Calendar/cal05.gif\"></td>"+"\n"+
	"  </tr>"+"\n"+
	"</table>"+"\n"+
	"</body></html>");
	this.gWinCal.document.close();
}

//document 객체에 문자열 출력
Calendar.prototype.wwrite = function(wtext)
{
	this.gWinCal.document.write(wtext);
}

//스크립트 코드 생성
Calendar.prototype.getScriptCode = function()
{
	//"self.opener.document." + this.gReturnItem + ".onchange() ; " +
	var vCode = "<script language=javascript><!--" +"\n"+
	"function ReturnDate(vDay) {" +"\n"+
	"self.opener.document." + this.gReturnItem + ".focus(); " +
	"self.opener.document." + this.gReturnItem + ".value=vDay ; " +
	"window.close();" +"\n"+
	"}" +"\n"+
	"function SetTdColor(bgcolor) {" +"\n"+
	"window.event.srcElement.style.backgroundColor=bgcolor;"+"\n"+
	"}" +"\n"+
	"function MM_swapImgRestore() { //v3.0" +"\n"+
	"  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc; " +"\n"+
	"}" +"\n"+
	"function MM_preloadImages() { //v3.0" +"\n"+
	"  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();" +"\n"+
	"    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)" +"\n"+
	"    if (a[i].indexOf(\"#\")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}" +"\n"+
	"}" +"\n"+
	"function MM_findObj(n, d) { //v4.0" +"\n"+
	"  var p,i,x;  if(!d) d=document; if((p=n.indexOf(\"?\"))>0&&parent.frames.length) {" +"\n"+
	"    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}" +"\n"+
	"  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];" +"\n"+
	"  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);" +"\n"+
	"  if(!x && document.getElementById) x=document.getElementById(n); return x;" +"\n"+
	"}" +"\n"+
	"function MM_swapImage() { //v3.0" +"\n"+
	"  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)" +"\n"+
	"   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}" +"\n"+
	"}" +"\n"+
	"//--></script>"+ "\n"

	return vCode;
}

//달력해더 HTML코드 생성
Calendar.prototype.calHeader = function()
{
	var vCode = "<tr bgcolor='#E0F4E8' class=datacenter>"+"\n"+
	"<td width=31 height=26 class=font><b>일</b></td>"+"\n"+
	"<td width=31 height=26 class=font><b>월</b></td>"+"\n"+
	"<td width=31 height=26 class=font><b>화</b></td>"+"\n"+
	"<td width=31 height=26 class=font><b>수</b></td>"+"\n"+
	"<td width=31 height=26 class=font><b>목</b></td>"+"\n"+
	"<td width=31 height=26 class=font><b>금</b></td>"+"\n"+
	"<td width=31 height=26 class=font><b>토</b></td>"+"\n"+
	"</tr>"+"\n";
	return vCode;
}

//달력 본문 HTML코드 생성
Calendar.prototype.calData = function()
{
	var vDate = new Date();
	vDate.setDate(1);
	vDate.setMonth(this.gMonth);
	vDate.setFullYear(this.gYear);

	var vFirstDay=vDate.getDay();
	var vDay=1;
	var vLastDay=Calendar.getDaysofmonth(this.gMonth, this.gYear);
	var vOnLastDay=0;
	var vCode = "";

	//첫번째 주내에서 시작요일 전까 공백으로 채운다.
	vCode = vCode + "<tr class=datacenter>";
	for (i=0; i<vFirstDay; i++)
		vCode = vCode + "<TD " + this.writeWeekendString(i, false) + ">&nbsp; </TD>"+"\n";

	// 첫번째주의 일자를 표시
	for (j=vFirstDay; j<7; j++)
	{
		vCode = vCode + "<TD " + this.writeWeekendString(j, true) + this.formatDay(vDay) +
		    "onclick=\"ReturnDate('"+this.formatData(vDay)+"')\">" +vDay+"</TD>\n";
		vDay=vDay + 1;
	}
	vCode = vCode + "</TR>\n";

	// 나머지주의 일자를 표시
	for (k=2; k<7; k++) {
		vCode = vCode + "<TR class=datacenter>\n";

		for (j=0; j<7; j++) {
			vCode = vCode + "<TD " + this.writeWeekendString(j,true) + this.formatDay(vDay) +
			"onclick=\"ReturnDate('"+this.formatData(vDay)+"')\" >"+vDay+"</TD>\n";
			vDay=vDay + 1;

			if (vDay > vLastDay) {
				vOnLastDay = 1;
				break;
			}
		}

		if (j == 6)
			vCode = vCode + "</TR>\n";
		if (vOnLastDay == 1)
			break;
	}

	// 마지막주의 남은 요일을 공백으로 표시
	for (m=1; m<(7-j); m++) {
		vCode = vCode + "<TD " + this.writeWeekendString(j+m, false) + ">&nbsp;</TD>\n";
	}

	return vCode;
}

//현재날짜에 대한 Bold 표시 처리
Calendar.prototype.formatDay = function(vday)
{
	var vNowDay = gNow.getDate();
	var vNowMonth = gNow.getMonth();
	var vNowYear = gNow.getFullYear();

	if (vday == vNowDay && this.gMonth == vNowMonth && this.gYear == vNowYear)
		return (" style='font-weight:bold' ");
	else
		return ("");
}


// 요일 바탕색 구분.
Calendar.prototype.writeWeekendString = function(vday, bhand)
{
	var ret= "";
	var id = "gen"; //평일
	var overcolor = "#E1FFC1";
	var outcolor  = "#FFFFFF";

	if (vday == 0){
		id = "sun"; //일
		outcolor = "FFF7F7";
	}
	else if(vday == 6){
		id = "sat"; //토
		outcolor = "#EFFDFF";
	}

	if(bhand){
		ret = "id=h" + id;
		ret = ret + " onmouseover=SetTdColor('"+overcolor+"')"+
				    " onmouseout=SetTdColor('"+outcolor+"') ";
	}
	else
		ret = " id="+ id + " ";

	return ret;
}

//날짜 포맷 처리
Calendar.prototype.formatData = function(p_day)
{
	var vData;
	var vMonth = 1 + this.gMonth;
	vMonth = (vMonth.toString().length < 2) ? "0" + vMonth : vMonth;
	var vMon = Calendar.getMonth(this.gMonth).substr(0,3).toUpperCase();
	var vFMon = Calendar.getMonth(this.gMonth).toUpperCase();
	var vY4 = new String(this.gYear);
	var vY2 = new String(this.gYear.substr(2,2));
	var vDD = (p_day.toString().length < 2) ? "0" + p_day : p_day;

	switch (this.gFormat) {
		case "YYYY\/MM\/DD" :
			vData = vY4 + "\/" + vMonth + "\/" + vDD;
			break;
		case "YY\/MM\/DD" :
			vData = vY2 + "\/" + vMonth + "\/" + vDD;
			break;
		case "YYYY-MM-DD" :
			vData = vY4 + "-" + vMonth + "-" + vDD;
			break;
		case "YY-MM-DD" :
			vData = vY2 + "-" + vMonth + "-" + vDD;
			break;

		case "YYYY\/MON\/DD" :
			vData = vY4 + "\/" + vMon + "\/" + vDD;
			break;
		case "YY\/MON\/DD" :
			vData = vY2 + "\/" + vMon + "\/" + vDD;
			break;
		case "YYYY-MON-DD" :
			vData = vY4 + "-" + vMon + "-" + vDD;
			break;
		case "YY-MON-DD" :
			vData = vY2 + "-" + vMon + "-" + vDD;
			break;

		case "YYYY\/MONTH\/DD" :
			vData = vY4 + "\/" + vFMon + "\/" + vDD;
			break;
		case "YY\/MONTH\/DD" :
			vData = vY2 + "\/" + vFMon + "\/" + vDD;
			break;
		case "YYYY-MONTH-DD" :
			vData = vY4 + "-" + vFMon + "-" + vDD;
			break;
		case "YY-MONTH-DD" :
			vData = vY2 + "-" + vFMon + "-" + vDD;
			break;

		case "YYYY\/MM\/DD" :
			vData = vY4 + "\/" + vMonth + "\/" + vDD;
			break;
		case "YY\/MM\/DD\/" :
			vData = vY2 + "\/" + vMonth + "\/" + vDD;
			break;
		case "YYYY-DD-MM" :
			vData = vY4 + "-" + vMonth + "-" + vDD;
			break;
		case "YY-MM-DD" :
			vData = vY2 + "-" + vMonth + "-" + vDD;
			break;
		default :
			vData = vY4 + "." + vMonth + "." + vDD;
	}

	return vData;
}
//달력생성
function Build(pItem, pMonth, pYear, pFormat)
{
	var pWinCal = ggWinCal;
	gCal = new Calendar(pItem, pWinCal, pMonth, pYear, pFormat);

	gCal.show();
}


function ShowCalendar()
{
	alert( "test") ;
}

//달력생성
function Build(pItem, pMonth, pYear, pFormat)
{
	var pWinCal = ggWinCal;
	gCal = new Calendar(pItem, pWinCal, pMonth, pYear, pFormat);

	gCal.show();
}

// 달력화면을 보여준다.
function ShowCalendar()
{
	/*
	  parameters:
		pMonth : 0-11 for Jan-Dec; 12 for All Months.
		pYear	: 4-digit year
		pFormat: Date format (yyy/mm/dd/, yy/dd/mm/, ...)
		pItem	: Return Item.
	*/

	pItem = arguments[0];

	if (arguments[1] == "" || arguments[1] == null)
		pYear = new String(gNow.getFullYear().toString());
	else
		pYear = arguments[1];

	if (arguments[2] == null)
		pMonth = new String(gNow.getMonth());
	else {
		pMonth = parseInt(arguments[2])-1;
	}

	if (arguments[3] == null)
		pFormat = "YYYY.MM.DD";
	else
		pFormat = arguments[3];

	if(parent == null)
		vWinCal = window.open("", "달력", "width=252,height=227,status=no,resizable=no,top=200,left=200");
	else
		vWinCal = parent.window.open("", "달력", "width=252,height=227,status=no,resizable=no,top=200,left=200");

	vWinCal.opener = self;
	ggWinCal = vWinCal;

	Build(pItem, pMonth, pYear, pFormat);
}


//- 이하 날짜 계산 함수
var MinMilli = 1000 * 60;         	//Initialize variables.
var HrMilli = MinMilli * 60;
var DyMilli = HrMilli * 24;

//From 날짜 To 날짜 일수계산(날짜포맷은 '/')
function CountIntervalDays(/* fromDate, toDate */)
{
	var fromDate = arguments[0];
	var toDate = arguments[1];

	var interT, fromT, toT;          	//Declare variables.

	fromT = Date.parse(FormatDate(fromDate));    	//Parse fromDate.

	if(toDate == null)					//toDate이 null일 경우 현재시점사이에 일수계산
	{
		d = new Date();
		toT = (new Date(d.getYear(), d.getMonth(), d.getDate())).getTime();
   	}
	else
		toT = Date.parse(FormatDate(toDate));     //Parse toDate.

	if (toT >= fromT)
	  interT = toT - fromT;
	else
	  interT = fromT - toT;

	r = Math.round(interT / DyMilli) + 1;

	return(r);                       	//Return difference.
}

//날짜간에 기간을 년월일로 계산
function CountIntervalDate(/* fromDate, toDate */)
{
	var fromDate = arguments[0];
	var toDate = arguments[1];

	var fromT, toT, fromY, fromM, fromD, toY, toM, toD;	//Declare variables.

	fromT = Date.parse(FormatDate(fromDate)); 	//Parse fromDate.

	if(toDate == null)						//toDate이 null일 경우 현재시점사이에 일수계산
	{
		d = new Date();
		toT = (new Date(d.getYear(), d.getMonth(), d.getDate())).getTime();
   	}
	else
		toT = Date.parse(FormatDate(toDate));     		//Parse toDate.

	if (toT >= fromT)
	{
		d = new Date();
		d.setTime(toT);
		toY = d.getFullYear();
		toM = d.getMonth()+1;
		toD = d.getDate();
		d.setTime(fromT);
		fromY = d.getFullYear();
		fromM = d.getMonth()+1;
		fromD = d.getDate();
	}
	else
	{
		d = new Date();
		d.setTime(fromT);
		toY = d.getFullYear();
		toM = d.getMonth()+1;
		toD = d.getDate();
		d.setTime(toT);
		fromY = d.getFullYear();
		fromM = d.getMonth()+1;
		fromD = d.getDate();
	}

	return GetIntervalDate(fromY, fromM, fromD, toY, toM, toD);
}

// 년월수 계산
function GetIntervalDate(fromY, fromM, fromD, toY, toM, toD)
{
/* [ From year/month/date To year/month/date ( From 1999/12/31 To 2001/03/20 ) ]

년수 : 년 - 년 > 2001 - 1999 = 2
월수 : 월 - 월 > 음수일경우( 3-12 = -9 ) 년수에서 -1을 하고(2-1=1) 12에서 뺀다(12-9=3)

일수 : 일 - 일 > 양수일 경우 일수+1
               > 음수일경우( 20-31= -11) 월수에서 -1을 하고(3-1=2)
                 (To month 전월일수-From date 일수) + To date 일수 + 1 [ {28(29)-31 = 0} + 20 +1 = 21 ]
                  --------------------------------
                              |
                               ---> 음수일경우 0 으로 처리
               > 월수 1증가, 일수 0처리후 월수증가시 12 이면 년수 증가후 월수 0 처리
                  - From date일 그달의 첫째날 또는 마지막 일자이고, 일수가 To month의 일수와 같은경우
                  - From date - To date = 1 인경우

계산값 > 1년 2개월 21일 */

    var y, m, d, ret = "";
    var bIncrease = false;

	fromY = parseInt(fromY);
	fromM = parseInt(fromM);
	fromD = parseInt(fromD);
	toY	  = parseInt(toY);
	toM   = parseInt(toM);
	toD   = parseInt(toD);

    y = toY - fromY;
    m = toM - fromM;
    d = toD - fromD;

    if (m < 0) {
    	y = y - 1;
    	m = 12 + m;
    }

    if (d < 0) {
		m = m - 1;
		prevD = GetPreviousDaysofmonth(toY, toM) - fromD;
		if (prevD < 0)	prevD = 0;
		d = prevD + toD + 1;
    }
    else
		d = d + 1;

	if ( fromD == 1 || fromD == parseInt(CalendarGetDaysofmonth(fromM-1, fromY)) ) //from month 일수
	{
		if ( d == parseInt(CalendarGetDaysofmonth(toM-1, toY))) //To month 일수와 계산된일수 비교
			bIncrease = true;
	}

	if (fromD - toD == 1)	//
		bIncrease = true;

	if (bIncrease) {		//개월수 증가
		m += 1;
		if ( m == 12) {
			y += 1;
			m = 0;
		}
		d = 0;
	}

	if (y > 0)	ret =  ""+y+"년";
	if (m > 0)	ret += " "+m+"개월";
	if (d > 0)	ret += " "+d+"일"

    return ret;
}

//월일수 계산
function GetPreviousDaysofmonth(y, m)
{
	m = m - 1;
	if (m == 0) {
	   m = 12;
	   y = y - 1;
	}
	var days = parseInt(CalendarGetDaysofmonth(m-1, y));
	if(days < 0)	days = 0;

	return days;
}

// 날짜에 일수를 가감처리(날짜포맷은 '.')
function AddDays(/* days, fromDate */)
{
	var days = arguments[0];			//가감일수
	var fromDate = arguments[1];

	var curTime;  	    	//Declare variables

	if(days == null)	days = 0;
	else				days = parseInt(days);

	if(fromDate == null)					//fromDate이 null일 경우 현재날짜에서 가감
		curTime = (new Date()).getTime();
	else
		curTime = Date.parse(FormatDate(fromDate));     //Parse toDate.

	var newTime = curTime + (days * DyMilli);
	var newDate = new Date();
	newDate.setTime(newTime);

	var formatDate = ""+newDate.getYear()+'.'+(newDate.getMonth()+1)+'.'+newDate.getDate();

	return(formatDate);                    //Return date
}

// 날짜에 월수를 가감처리(날짜포맷은 '.')
function AddMonths(/* months, fromDate */)
{
	var months   = arguments[0];			//가감일수
	var fromDate = arguments[1];

	var yy = arguments[1].substring(0,4);
	var mm = arguments[1].substring(5,7);
	var dd = arguments[1].substring(8,10);

	mm = eval(mm) + eval(months);
	if (mm > 13) { 
		yy = eval(yy) + (eval(mm)-eval(mm)%12)/12	
		mm = eval(mm) % 12;
		if (mm == 0) {
			mm = 12;
			yy = yy - 1;
		}
	}

	var sd = CalendarGetDaysofmonth(mm-1,yy);
	if (sd < dd) dd = sd;
	if (mm < 10) mm = "0" + mm;
			
	var formatDate = yy+'.'+mm+'.'+dd;
	return(formatDate);                    //Return date
}

//세자리 구분 콤마 Format(통화문자열로 변환)
function FormatCurrency(pstr)
{
	var formatStr = "";
	var str = pstr.toString();

	if(str != null && str.length > 0)
	{
		iLen = str.length;
		iMod = iLen % 3;

		if(iMod > 0)
		{
			formatStr = str.substring(0, iMod);
			if(iLen > 3) formatStr += ",";
		}

		for(i=iMod; i<str.length; i+=3)
		{
			formatStr += str.substring(i, i+3);
			if (i+3 < iLen) formatStr += ",";
		}
	}

	return(formatStr);	//return comma distribute
}

//날짜 포맷 체크후 "YYYY/MM/DD"형식으로 변환하여 리턴
function FormatDate(sDate)
{
	sDate = sDate.replace(/\./g, "/");// YYYY.MM.DD 형식을 YYYY/MM/DD로 변환
	sDate = sDate.replace(/-/g, "/");	// YYYY-MM-DD 형식을 YYYY/MM/DD로 변환

	if(sDate.length == 8 && !isNaN(sDate))	//YYYYMMDD 형식을 YYYY/MM/DD로 변환
	{
		sDate = sDate.substring(0, 4) +"/"+ sDate.substring(4, 6) +"/"+ sDate.substring(6, 8);
	}
	return sDate;
}
