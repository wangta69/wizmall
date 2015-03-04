 function setWindowResize(thisX, thisY) {
	 var maxThisX = screen.width - 50;
	 var maxThisY = screen.height - 50;
	 var marginY = 0;
	// alert(thisX + "===" + thisY);
	 //alert!("임시 브라우저 확인 : " + navigator.userAgent);
	 // 브라우저별 높이 조절. (표준 창 하에서 조절해 주십시오.)
	// alert(navigator.userAgent);
	 if (navigator.userAgent.indexOf("MSIE 6") > 0) marginY = 45;        // IE 6.x
	 else if(navigator.userAgent.indexOf("MSIE 7") > 0) marginY = 75;    // IE 7.x
	 else if(navigator.userAgent.indexOf("MSIE 8") > 0) marginY = 85;    // IE 8.x
	 else if(navigator.userAgent.indexOf("MSIE 9") > 0) marginY = 73;    // IE 9.x
	 else if(navigator.userAgent.indexOf("MSIE 10") > 0) marginY = 73;    // IE 9.x
	 else if(navigator.userAgent.indexOf("Firefox") > 0) marginY = 80;   // FF     => 원래는 50 이었는데 해보니 안돼서 임의로 변경해보았다 ㅡㅡ;;
	 else if(navigator.userAgent.indexOf("Opera") > 0) marginY = 30;     // Opera
	 else if(navigator.userAgent.indexOf("Chrome") > 0) marginY = 70;     // Chrome
	 else if(navigator.userAgent.indexOf("Netscape") > 0) marginY = -2;  // Netscape
	 else marginY = 73;

	 if (thisX > maxThisX) {
	  window.document.body.scroll = "yes";
	  thisX = maxThisX;
	 }
	 if (thisY > maxThisY - marginY) {
	  window.document.body.scroll = "yes";
	  thisX += 19;
	  thisY = maxThisY - marginY;
	 }
	 window.resizeTo(thisX+10, thisY+marginY);

	 var windowX = (screen.width - (thisX+10))/2;
	 var windowY = (screen.height - (thisY+marginY))/2 - 20;
	 window.moveTo(windowX,windowY);
}