var isDOM = (document.getElementById ? true : false);  
var isIE4 = ((document.all && !isDOM) ? true : false); 
var isNS4 = (document.layers ? true : false);  

function getRef(id) { 
	if (isDOM) return document.getElementById(id); 
	if (isIE4) return document.all[id]; 
	if (isNS4) return document.layers[id]; 
}  

var isNS = navigator.appName == "Netscape";  

function moveRightEdge() { 
	var yMenuFrom, yMenuTo, yOffset, timeoutNextCheck;  

	if (isNS4) { 
		yMenuFrom   = sidebar.top; 
		yMenuTo     = windows.pageYOffset + 200; 
	} else if (isDOM) { 
		yMenuFrom   = parseInt (sidebar.style.top, 10); 
		yMenuTo     = (isNS ? window.pageYOffset : document.body.scrollTop) + 120; 
	} 
	timeoutNextCheck = 30;  

	if (yMenuFrom != yMenuTo) { 
		yOffset = Math.ceil(Math.abs(yMenuTo - yMenuFrom) / 20); 
		if (yMenuTo < yMenuFrom) 
			yOffset = -yOffset; 
		if (isNS4) 
			sidebar.top += yOffset; 
		else if (isDOM) 
			sidebar.style.top = parseInt (sidebar.style.top, 10) + yOffset; 
			timeoutNextCheck = 5; 
	} 
	setTimeout ("moveRightEdge()", timeoutNextCheck); 
} 


if (isNS4) { 
	var sidebar = document["sidebar"]; 
	sidebar.top = top.pageYOffset + 400; 
	sidebar.visibility = "visible"; 
	moveRightEdge(); 
} else if (isDOM) { 
	var sidebar = getRef('sidebar'); 
	sidebar.style.top = (isNS ? window.pageYOffset : document.body.scrollTop) + 150; 
	sidebar.style.visibility = "visible"; 
	moveRightEdge(); 
} else if (isIE4) { 
	var sidebar = getRef('sidebar'); 
	sidebar.style.top = (isNS ? window.pageYOffset : document.body.scrollTop) + 150; 
	sidebar.style.visibility = "visible"; 
	moveRightEdge(); 
} 