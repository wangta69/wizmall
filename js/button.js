function onBtnClick( link, strTarget )
{
  if ( strTarget && strTarget.length > 0 ) window.open( link, strTarget );
  else document.location = link;
}

function forceQuote( str )
{
  var nDouble = 0;
  var ch;
  var i;

  ch = str.charCodeAt( 0 );
  if ( ( ch == 34 ) || ( ch == 39 ) ) return str;

  for ( i = 1 ; i < str.length - 1 ; i++ )
  {
    ch = str.charCodeAt( i );
    if ( ch == 39 )
    {
      nDouble = 1;
      break;
    }
  }

  if ( nDouble ) strQuote = "\"";
  else strQuote = "'";

  return ( strQuote + str + strQuote );
}

function getRealLink( link )
{
  var strOnBtnClick = "";
  var nPos = -1;
  var strHREF = "";
  var strTarget = "";
  var strLow;

  strLow = link;
  strLow.toLowerCase();
  nPos = strLow.indexOf( "javascript:" );
  if ( nPos >= 0 ) return forceQuote( link );

  nPos = link.indexOf( " " );
  if ( nPos > 0 ) strHREF = link.substring( 0, nPos );
  else strHREF = link;

  nPos = link.indexOf( "target=" );
  if ( nPos > 0 ) strTarget = link.substr( nPos + 7 );

  strHREF = forceQuote( strHREF );
  strTarget = forceQuote( strTarget );
  strOnBtnClick = "javascript:onBtnClick( " + strHREF + " , " + strTarget + " )";
  strOnBtnClick = forceQuote( strOnBtnClick );

  return strOnBtnClick;
}


function changeC(currentBtnID, lightC, midC, darkC)
{
  var colLiteCR = document.getElementsByName("lightArea_"+currentBtnID);
  var colMidCR = document.getElementsByName("midArea_"+currentBtnID);
  var colDarkCR = document.getElementsByName("darkArea_"+currentBtnID);

  for (var i=0; i<colLiteCR.length; i++)
    colLiteCR[i].bgColor = lightC;
  for (var i=0; i<colMidCR.length; i++)
    colMidCR[i].bgColor = midC;
  for (var i=0; i<colDarkCR.length; i++)
    colDarkCR[i].bgColor = darkC;
}


/*****************************************************************************
(int) roundType: 모서리 rounding type (0~6)
(string) edgePos: 모서리 위치 ('UL', 'UR', 'LL', 'LR')
(string) borderC: 버튼 경계 색깔
(string) lightC: 버튼 바탕중 왼쪽과 위쪽의 밝은 부분 색깔
(string) midC: 버튼 바탕 색깔
(string) darkC: 버튼 바탕중 오른쪽과 아래쪽의 어두운 부분 색깔
(bool) border: 경계 유무 ('0' or '1') => Tab에만 사용
(bool) iduse: color 변화를 위한 id 사용 유무 ('0' or '1')
*****************************************************************************/
function getEdgeTag (roundType, edgePos, borderC, lightC, darkC, midC, border, iduse) {
  if (!border) border = '1';
  if (!iduse) iduse = '1';

  /* shape for "LL (Lower Left)" */
  shape0 = new Array (5);
  shape0[0] = new Array (1,2,4,4,4);
  shape0[1] = new Array (1,2,4,4,4);
  shape0[2] = new Array (1,2,4,4,4);
  shape0[3] = new Array (1,3,3,3,3);
  shape0[4] = new Array (1,1,1,1,1);
  shape1 = new Array (5);
  shape1[0] = new Array (1,2,4,4,4);
  shape1[1] = new Array (1,2,4,4,4);
  shape1[2] = new Array (1,2,4,4,4);
  shape1[3] = new Array (1,3,3,3,3);
  shape1[4] = new Array (0,1,1,1,1);
  shape2 = new Array (5);
  shape2[0] = new Array (1,2,4,4,4);
  shape2[1] = new Array (1,2,4,4,4);
  shape2[2] = new Array (1,2,4,4,4);
  shape2[3] = new Array (0,1,3,3,3);
  shape2[4] = new Array (0,0,1,1,1);
  shape3 = new Array (5);
  shape3[0] = new Array (1,2,4,4,4);
  shape3[1] = new Array (1,2,4,4,4);
  shape3[2] = new Array (0,1,3,4,4);
  shape3[3] = new Array (0,0,1,3,3);
  shape3[4] = new Array (0,0,0,1,1);
  shape4 = new Array (5);
  shape4[0] = new Array (1,2,4,4,4);
  shape4[1] = new Array (1,2,4,4,4);
  shape4[2] = new Array (0,1,3,4,4);
  shape4[3] = new Array (0,1,1,3,3);
  shape4[4] = new Array (0,0,0,1,1);
  shape5 = new Array (5);
  shape5[0] = new Array (1,2,4,4,4);
  shape5[1] = new Array (0,1,3,4,4);
  shape5[2] = new Array (0,1,3,3,4);
  shape5[3] = new Array (0,0,1,1,3);
  shape5[4] = new Array (0,0,0,0,1);
  shape6 = new Array (5);
  shape6[0] = new Array (0,1,2,4,4);
  shape6[1] = new Array (0,1,2,4,4);
  shape6[2] = new Array (0,0,1,3,3);
  shape6[3] = new Array (0,0,0,1,1);
  shape6[4] = new Array (0,0,0,0,0);

  shape = eval ('shape'+roundType);
  cv0 = ''; cv1 = borderC; cv2 = lightC; cv3 = darkC; cv4 = midC;
  xbegin = 0; xend = 5; xinc= 1;
  ybegin = 0; yend = 5; yinc= 1;

  if (edgePos == "UL") {
    cv3 = lightC;
    xbegin = 4; xend = -1; xinc = -1;
  }
  else if (edgePos == "UR") {
    cv2 = darkC; cv3 = lightC;
    xbegin = 4; xend = -1; xinc = -1;
    ybegin = 4; yend = -1; yinc = -1;
  }
  else if (edgePos == "LR") {
    cv2 = darkC;
    ybegin = 4; yend = -1; yinc = -1;
  }

  str = "<table border=0 cellpadding=0 cellspacing=0>\n";
  for (x = xbegin; x != xend; x += xinc) {
    str += "<tr>";
    for (y = ybegin; y != yend; y += yinc) {
      if (border == '0' && y == 0) continue;

      bgtag = '';
      color = eval ('cv'+shape[x][y]);
      if (color != '') bgtag = " bgcolor="+color;

      idtag = '';
      if (iduse == '1') {
        if (color == lightC && color != darkC) idtag = " id=lightArea_"+btnID;
        else if (color == darkC && color != lightC) idtag = " id=darkArea_"+btnID;
        else if (color == midC) idtag = " id=midArea_"+btnID;
      }

      wtag = ''; htag = '';
      if (x == xbegin) wtag = " width=1"; 
      if (y == ybegin || y == ybegin+yinc) htag = " height=1"; 

      str += "<td" + wtag + htag + idtag + bgtag + ">"
    }
    str += "</tr>\n";
  }
  str += "</table>";

  return str;
}

function docWrite (strFormat, codeOnly) {
  if (codeOnly){
    strFormat = strFormat.replace (/</g,"&lt;");
    strFormat = strFormat.replace (/>/g,"&gt;");
    document.write (strFormat);
  }
  else
    document.write (strFormat);
}

var btnID = 0;

/*****************************************************************************
(string) title: 버튼 제목
(string) cssName: cascading style sheet 이름
(string) link: 버튼 link
(int) roundType: round type (0~6)
(boolean) disable: 버튼 비활성화 flag
(string) borderC: 버튼 경계 색깔
(string) lightC: 버튼 바탕중 왼쪽과 위쪽의 밝은 부분 색깔
(string) midC: 버튼 바탕 색깔
(string) darkC: 버튼 바탕중 오른쪽과 아래쪽의 어두운 부분 색깔
(string) moMidC: mouse over 시에 버튼 바탕 색깔
(string) mcMidC: mouse click 시에 버튼 바탕 색깔
(int) width: 버튼 너비
(int) height: 버튼 높이 
(string) iconURL: image icon URL
(string) iconPos: image icon position ('top', 'left', 'right', 'bottom');
(int) codeOnly: code return for debugging(default 0)
*****************************************************************************/
function nhnButton(title, cssName, link, roundType, disable, borderC, lightC, darkC, midC, moMidC, mcMidC, width, height, iconURL, iconPos, codeOnly)
{
  var strFormat;

  btnID++;
//if (!title) title = "확 인";
  if (!title) return; 
  if (!cssName) cssName = "gulim9";
  if (!link) link = "#";
  if (!borderC) borderC = "#000000";
  if (!lightC) lightC = "#FFFFFF";
  if (!darkC) darkC = "#777777";
  if (!midC) midC = "#DEDEDE";
  if (!moMidC) moMidC = midC;
  if (!mcMidC) mcMidC = midC;
  if (!height) height = 22;
  if (!codeOnly) codeOnly = 0;

  imgGap = 4;
  leftGap = 5;
  rightGap = 5;
  topGap = 2;
  bottomGap = 0;

  link = getRealLink( link );

  if (!width || (width <= 0)) widthTag = "";
  else widthTag = " width="+width;
  if (!height || (height <= 0)) heightTag = "";
  else heightTag = " height="+height;

  // Get round tag
  ULEdgeTag = getEdgeTag (roundType, "UL", borderC, lightC, darkC, midC);
  UREdgeTag = getEdgeTag (roundType, "UR", borderC, lightC, darkC, midC);
  LLEdgeTag = getEdgeTag (roundType, "LL", borderC, lightC, darkC, midC);
  LREdgeTag = getEdgeTag (roundType, "LR", borderC, lightC, darkC, midC);

  aTagB = ""; aTagE = "";
  mouseAction = " onmouseover=\"this.style.cursor='default'\"";
  if (!disable) {
    onmouseoverTag = "onmouseover=\"this.style.cursor='hand';changeC("+btnID+", '"+lightC+"', '"+moMidC+"', '"+darkC+"')\"";
    aTagB = "<a href="+link+" onclick='window.event.returnValue=false' "+onmouseoverTag+" onfocus='this.blur()'>";
    aTagE = "</a>";
    mouseAction = " onclick="+link+" onmousedown=\"changeC("+btnID+", '"+darkC+"', '"+mcMidC+"', '"+lightC+"')\" onmouseup=\"changeC("+btnID+", '"+lightC+"', '"+moMidC+"', '"+darkC+"')\" "+onmouseoverTag+" onmouseout=\"changeC("+btnID+", '"+lightC+"', '"+midC+"', '"+darkC+"')\"";
  }

  strFormat = "<table id=nhnButton border=0"+widthTag+heightTag+" cellpadding=0 cellspacing=0"+mouseAction+"><tr>";
  docWrite (strFormat, codeOnly);

  ///////////////////////////////////////////////////////////////////////////
  // Make 1st column (left)
  strFormat = ""+
  "<td width=5 height=100%>"+
    "<table width=5 height=100% border=0 cellpadding=0 cellspacing=0>"+
      "<tr><td width=5 height=5>"+ULEdgeTag+"</td>"+
      "<tr><td width=5 height=100%>"+
        "<table border=0 cellpadding=0 cellspacing=0 height=100%><tr>"+
          "<td width=1 height=100% bgcolor="+borderC+"></td>"+
          "<td width=1 id=lightArea_"+btnID+" bgcolor="+lightC+"></td>"+
          "<td width=3 id=midArea_"+btnID+" bgcolor="+midC+"></td>"+
        "</tr></table>"+
      "</td></tr>"+
      "<tr><td width=5 height=5>"+LLEdgeTag+"</td>"+
    "</table>"+
  "</td>";
  docWrite (strFormat, codeOnly);

  ///////////////////////////////////////////////////////////////////////////
  // Make 2nd column (center)
  strFormat = ""+
  "<td height=100%><table width=100% height=100% border=0 cellpadding=0 cellspacing=0>"+
    "<tr><td height=1 bgcolor="+borderC+"></td></tr>"+
    "<tr><td height=1 id=lightArea_"+btnID+" bgcolor="+lightC+"></td></tr>";
  if (topGap) strFormat += "<tr><td height=topGap id=midArea_"+btnID+" bgcolor="+midC+"></td></tr>";
  strFormat += 
    "<tr><td id=midArea_"+btnID+" bgcolor="+midC+" align=center><table border=0 cellpadding=0 cellspacing=0>";

  // Show top icon image if it exists
  if (iconURL && iconPos == "top") {
    strFormat += "<tr><td colspan=3 align=center>"+aTagB+"<img src='"+iconURL+"' border=0>"+aTagE+"</td></tr>";
    strFormat += "<tr><td colspan=3 height="+imgGap+"></td></tr>";
  }

  strFormat += "<tr>";
  strFormat += "<td width="+leftGap+"></td>";

  // Set left, right icon image tags if they exist
  lIconTag = ''; rIconTag = '';
  if (iconURL && iconPos == "left")
    lIconTag = "<img src='"+iconURL+"' border=0 align=absmiddle>&nbsp;";
  else if (iconURL && iconPos == "right")
    rIconTag = "&nbsp;<img src='"+iconURL+"' border=0 align=absmiddle>";

  strFormat += "<td align=center nowrap>"+lIconTag+aTagB+"<font id="+cssName+">"+title+"</font>"+aTagE+rIconTag+"</td>";

  // Show left icon image if it exists
  //if (iconURL && iconPos == "left") {
  //  strFormat += "<td>"+aTagB+"<img src='"+iconURL+"' border=0>"+aTagE+"</td>";
  //  strFormat += "<td width="+imgGap+"></td>";
  //}

  //strFormat += "<td align=center class='"+cssName+"' nowrap>"+aTagB+title+aTagE+"</td>";

  // Show right icon image if it exists
  //if (iconURL && iconPos == 'right') {
  //  strFormat += "<td width="+imgGap+"></td>";
  //  strFormat += "<td>"+aTagB+"<img src='"+iconURL+"' border=0>"+aTagE+"</td>";
  //}

  strFormat += "<td width="+rightGap+"></td>";
  strFormat += "</tr>";

  // Show bottom icon image if it exists
  if (iconURL && iconPos == "bottom") {
    strFormat += "<tr><td colspan=3 height="+imgGap+"></td></tr>";
    strFormat += "<tr><td colspan=3 align=center>"+aTagB+"<img src='"+iconURL+"' border=0>"+aTagE+"</td></tr>";
  }

  strFormat += "</table></td></tr>";
  if (bottomGap) strFormat += "<tr><td height=bottomGap id=midArea_"+btnID+" bgcolor="+midC+"></td></tr>";
  strFormat += 
    "<tr><td height=1 id=darkArea_"+btnID+" bgcolor="+darkC+"></td></tr>"+
    "<tr><td height=1 bgcolor="+borderC+"></td></tr>"+
  "</table></td>";
  docWrite (strFormat, codeOnly);

  ///////////////////////////////////////////////////////////////////////////
  // Make 3nd column (right)
  strFormat = ""+
  "<td width=5>"+
    "<table width=5 height=100% border=0 cellpadding=0 cellspacing=0>"+
      "<tr><td width=5 height=5>"+UREdgeTag+"</td>"+
      "<tr><td width=5 height=100%>"+
        "<table border=0 cellpadding=0 cellspacing=0 height=100%><tr>"+
          "<td width=3 height=100% id=midArea_"+btnID+" bgcolor="+midC+"></td>"+
          "<td width=1 id=darkArea_"+btnID+" bgcolor="+darkC+"></td>"+
          "<td width=1 bgcolor="+borderC+"></td>"+
        "</tr></table>"+
      "</td></tr>"+
      "<tr><td width=5 height=5>"+LREdgeTag+"</td>"+
    "</table>"+
  "</td>";
  docWrite (strFormat, codeOnly);

  strFormat = "</tr></table>";
  docWrite (strFormat, codeOnly);
}


/*****************************************************************************
(string) title: 탭 제목
(string) cssName: cascading style sheet 이름
(string) link: link
(string) align: 제목 align ('left', 'center', 'right')
(int) roundType: round type (0~6)
(string) rountPos: round 위치 ('1100'=>상단, '0011'=>하단, '1000'=> 상단왼쪽)
(string) lrBorder: 좌우 경계선 여부 ('10', '01', '11')
(boolean) disable: 탭 비활성화 flag
(string) borderC: 탭 경계 색깔
(string) lightC: 탭 바탕중 왼쪽과 위쪽의 밝은 부분 색깔
(string) midC: 탭 바탕 색깔
(string) darkC: 탭 바탕중 오른쪽과 아래쪽의 어두운 부분 색깔
(int) width: 탭 너비
(int) height: 탭 높이 
(string) iconURL: image icon URL
(string) iconPos: image icon position ('left', 'right');
(int) codeOnly: code return for debugging(default 0)
*****************************************************************************/
function nhnTab(title, cssName, link, align, roundType, roundPos, lrBorder, disable, borderC, lightC, darkC, midC, width, height, iconURL, iconPos, codeOnly)
{
  var strFormat;

  if (!cssName) cssName = "gulim9";
  if (!link) link = "#";
  if (!align) align = "center";
  if (!borderC) borderC = "#000000";
  if (!lightC) lightC = "#FFFFFF";
  if (!darkC) darkC = "#777777";
  if (!midC) midC = "#DEDEDE";
  
  imgGap = 4;
  leftGap = 5; rightGap = 5;
  topGap = 2; bottomGap = 0;

  link = getRealLink( link );

  if (!width || (width <= 0)) widthTag = "";
  else widthTag = " width="+width;
  if (!height || (height <= 0)) heightTag = "";
  else heightTag = " height="+height;

  lwidth = 5; rwidth = 5;
  lb = lrBorder.charAt(0);
  rb = lrBorder.charAt(1);
  if (lb == '0') lwidth=4;
  if (rb == '0') rwidth=4;

  // Get round tag
  lRowHead = "<tr><td width="+lwidth+" height=5>";
  rRowHead = "<tr><td width="+rwidth+" height=5>";
  rowTail = "</td></tr>";
  ULEdgeRow = ''; UREdgeRow = ''; LLEdgeRow = ''; LREdgeRow = '';
  
  if (roundPos.charAt(0) == '1')
    ULEdgeRow = lRowHead + getEdgeTag (roundType, "UL", borderC, lightC, darkC, midC, lb, '0') + rowTail;
  else if (roundPos.charAt(1) == '1')
    ULEdgeRow = lRowHead + getEdgeTag (0, "UL", borderC, lightC, darkC, midC, lb, '0') + rowTail;

  if (roundPos.charAt(1) == '1')
    UREdgeRow = rRowHead + getEdgeTag (roundType, "UR", borderC, lightC, darkC, midC, rb, '0') + rowTail;
  else if (roundPos.charAt(0) == '1')
    UREdgeRow = rRowHead + getEdgeTag (0, "UR", borderC, lightC, darkC, midC, rb, '0') + rowTail;

  if (roundPos.charAt(2) == '1')
    LLEdgeRow = lRowHead + getEdgeTag (roundType, "LL", borderC, lightC, darkC, midC, lb, '0') + rowTail;
  else if (roundPos.charAt(3) == '1')
    LLEdgeRow = lRowHead + getEdgeTag (0, "LL", borderC, lightC, darkC, midC, lb, '0') + rowTail;

  if (roundPos.charAt(3) == '1')
    LREdgeRow = rRowHead + getEdgeTag (roundType, "LR", borderC, lightC, darkC, midC, rb, '0') + rowTail;
  else if (roundPos.charAt(2) == '1')
    LREdgeRow = rRowHead + getEdgeTag (0, "LR", borderC, lightC, darkC, midC, rb, '0') + rowTail;

  aTagB = ""; aTagE = "";
  if (!disable && link != "#") {
    aTagB = "<a href="+link+" onfocus='this.blur()'>";
    aTagE = "</a>";
  }

  strFormat = "<table id=nhnTab border=0"+widthTag+heightTag+" cellpadding=0 cellspacing=0><tr>";
  docWrite (strFormat, codeOnly);

  ///////////////////////////////////////////////////////////////////////////
  // Make 1st column (left)
  strFormat = ""+
  "<td width="+lwidth+" height=100%>"+
    "<table width="+lwidth+" height=100% border=0 cellpadding=0 cellspacing=0>"+
      ULEdgeRow +
      "<tr><td width="+lwidth+" height=100%>"+
        "<table border=0 cellpadding=0 cellspacing=0 height=100%><tr>";
  if (lb == '1')
   strFormat += "<td width=1 height=100% bgcolor="+borderC+"></td>";
  strFormat += "<td width=1 bgcolor="+lightC+"></td>"+
          "<td width=3 bgcolor="+midC+"></td>"+
        "</tr></table>"+
      "</td></tr>"+
      LLEdgeRow+
    "</table>"+
  "</td>";
  docWrite (strFormat, codeOnly);

  ///////////////////////////////////////////////////////////////////////////
  // Make 2nd column (center)
  if (roundPos.charAt(0) == '0' && roundPos.charAt(1) == '0') {
    borderC2 = midC; lightC2 = midC;
  }
  else {
    borderC2 = borderC; lightC2 = lightC;
  }
    
  strFormat = ""+
  "<td height=100%><table width=100% height=100% border=0 cellpadding=0 cellspacing=0>"+
    "<tr><td height=1 bgcolor="+borderC2+"></td></tr>"+
    "<tr><td height=1 bgcolor="+lightC2+"></td></tr>";
  if (topGap) strFormat += "<tr><td height=topGap bgcolor="+midC+"></td></tr>";
  strFormat += 
    "<tr><td bgcolor="+midC+" align="+align+"><table border=0 cellpadding=0 cellspacing=0>";

  strFormat += "<tr>";
  strFormat += "<td width="+leftGap+"></td>";

  // Set left, right icon image tags if they exist
  lIconTag = ''; rIconTag = '';
  if (iconURL && iconPos == "left")
    lIconTag = "<img src='"+iconURL+"' border=0 align=absmiddle>&nbsp;";
  else if (iconURL && iconPos == "right")
    rIconTag = "&nbsp;<img src='"+iconURL+"' border=0 align=absmiddle>";

  strFormat += "<td align=center nowrap>"+lIconTag+aTagB+"<font id="+cssName+">"+title+"</font>"+aTagE+rIconTag+"</td>";

  strFormat += "<td width="+rightGap+"></td>";
  strFormat += "</tr>";

  if (roundPos.charAt(2) == '0' && roundPos.charAt(3) == '0') {
    borderC2 = midC; darkC2 = midC;
  }
  else {
    borderC2 = borderC; darkC2 = darkC;
  }

  strFormat += "</table></td></tr>";
  if (bottomGap) strFormat += "<tr><td height=bottomGap bgcolor="+midC+"></td></tr>";
  strFormat += 
    "<tr><td height=1 bgcolor="+darkC2+"></td></tr>"+
    "<tr><td height=1 bgcolor="+borderC2+"></td></tr>"+
  "</table></td>";
  docWrite (strFormat, codeOnly);

  ///////////////////////////////////////////////////////////////////////////
  // Make 3nd column (right)
  strFormat = ""+
  "<td width="+rwidth+">"+
    "<table width="+rwidth+" height=100% border=0 cellpadding=0 cellspacing=0>"+
      UREdgeRow+
      "<tr><td width="+rwidth+" height=100%>"+
        "<table border=0 cellpadding=0 cellspacing=0 height=100%><tr>"+
          "<td width=3 height=100% bgcolor="+midC+"></td>"+
          "<td width=1 bgcolor="+darkC+"></td>";
  if (rb == '1')
   strFormat += "<td width=1 bgcolor="+borderC+"></td>";
  strFormat += "</tr></table>"+
      "</td></tr>"+
      LREdgeRow+
    "</table>"+
  "</td>";
  docWrite (strFormat, codeOnly);

  strFormat = "</tr></table>";
  docWrite (strFormat, codeOnly);
}


//////////////////////////////////////////////////////////////////////////////
// CSS definition for button text
//////////////////////////////////////////////////////////////////////////////
document.write ("\
<style type=text/css>\
#white9 { line-height: 11pt ; font-size: 9pt ; text-decoration: none ; color: #FFFFFF ;}\
#white9b { line-height: 11pt ; font-size: 9pt ; font-weight: bold ; text-decoration: none ; color: #FFFFFF ;}\
#black9 { line-height: 11pt ; font-size: 9pt ; text-decoration: none ; color: #000000 ;}\
#black9b { line-height: 11pt ; font-size: 9pt ; font-weight: bold ; text-decoration: none ; color: #000000 ;}\
#gulim9 { line-height: 11pt ; font-size: 9pt ; text-decoration: none ; color: #000000 ;}\
#gulim9b { line-height: 11pt ; font-size: 9pt ; font-weight: bold ; text-decoration: none ; color: #000000 ;}\
#gulim9W { line-height: 11pt ; font-size: 9pt ; text-decoration: none ; color: #FFFFFF ;}\
#gulim9Wb { line-height: 11pt ; font-size: 9pt ; font-weight: bold ; text-decoration: none ; color: #FFFFFF ;}\
#gulim10 { line-height: 11pt ; font-size: 10pt ; text-decoration: none ; color: #000000 ;}\
#gulim10b { line-height: 11pt ; font-size: 10pt ; font-weight: bold ; text-decoration: none ; color: #000000 ;}\
#gulim10W { line-height: 11pt ; font-size: 10pt ; text-decoration: none ; color: #FFFFFF ;}\
#gulim10Wb { line-height: 11pt ; font-size: 10pt ; font-weight: bold ; text-decoration: none ; color: #FFFFFF ;}\
\
</style>\
")
