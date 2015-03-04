/*
출처 : http://www.zemy.net/jquery/money/
사용법
<script type="text/javascript"> 
$(function() { 
	$('#price').keyup(function(event) {
		$(this).toPrice();//콤마가 들어간 금액
		var strText = $(this).getOnlyNumeric();
		$('#number').text(strText);//원 금액
	})
});

insert price : <input type="text" id="price" maxlength="30" name="price" style="text-align: right;" /><br><br> 
get Original price value : <div id="number"></div> 

*/
(function($) {
/**********************************************************/
	$.fn.toPrice = function(cipher) {
		var strb, len, revslice;

		strb = $(this).val().toString();
		strb = strb.replace(/,/g, '');
		strb = $(this).getOnlyNumeric();
		strb = parseInt(strb, 10);
		if(isNaN(strb))
		return $(this).val('');

		strb = strb.toString();
		len = strb.length;

		//if(len < 4) return $(this).val(strb);
		if(len < 4) return strb;

		if(cipher == undefined || !isNumeric(cipher))
		cipher = 3;

		count = len/cipher;
		slice = new Array();

		for(var i=0; i<count; ++i) {
			if(i*cipher >= len)
		break;

		slice[i] = strb.slice((i+1) * -cipher, len - (i*cipher));
		}

		revslice = slice.reverse();
		//return $(this).val(revslice.join(','));
		return revslice.join(',');
	}
 

 /**********************************************************/
	$.fn.getOnlyNumeric = function(data) {
		var chrTmp, strTmp;
		var len, str;

		if(data == undefined) {
			str = $(this).val();
			if(str == "") str = $(this).html();
		}else {
			str = data;
		}

		len = str.length;
		strTmp = '';

		for(var i=0; i<len; ++i) {
			chrTmp = str.charCodeAt(i);
			if((chrTmp > 47 || chrTmp <= 31) && chrTmp < 58) {
				strTmp = strTmp + String.fromCharCode(chrTmp);
			}
		}

			if(data == undefined)
				return parseInt(strTmp);
			else 
			return parseInt($(this).val(strTmp));
		}

		var isNumeric = function(data) {
		var len, chrTmp;

		len = data.length;
		for(var i=0; i<len; ++i) {
			chrTmp = str.charCodeAt(i);
			if((chrTmp <= 47 && chrTmp > 31) || chrTmp >= 58) {
				return false;
			}
		}

		return true;
	}
})(jQuery);