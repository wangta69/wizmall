function xmlHttpPost(actionUrl, submitParameter, resultFunction)
{
	var xmlHttpRequest = false;
	xmlHttpRequest = newXMLHttpRequest();
	xmlHttpRequest.open('POST', actionUrl, true);
	xmlHttpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlHttpRequest.onreadystatechange = function()
	{
		if(xmlHttpRequest.readyState == 4)
		{
			switch (xmlHttpRequest.status)
			{
				case 404: alert('오류: ' + actionUrl + '이 존재하지 않음'); break;
				case 500: alert('오류: ' + xmlHttpRequest.responseText); break;
				default: eval(resultFunction + '(xmlHttpRequest.responseText);'); break;
			}
		}
	}
	xmlHttpRequest.send(submitParameter);
}

function newXMLHttpRequest()
{
	var xmlreq = false;
	if (window.XMLHttpRequest)
	{
		// Create XMLHttpRequest object in non-Microsoft browsers
		xmlreq = new XMLHttpRequest();
	}
	else if (window.ActiveXObject)
	{
		// Create XMLHttpRequest via MS ActiveX
		try {
			// Try to create XMLHttpRequest in later versions
			// of Internet Explorer
			xmlreq = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e1) {
			// Failed to create required ActiveXObject
			try {
				// Try version supported by older versions
				// of Internet Explorer
				xmlreq = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e2) {
				// Unable to create an XMLHttpRequest with ActiveX
			}
		}
	}
	return xmlreq;
}