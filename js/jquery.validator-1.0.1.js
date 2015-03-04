/*     
	2010.04
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

	Copyright(C) 2010 pondol
	url : http://www.shop-wiz.com
*/
(function($) {
	$.fn.formvalidate = function() {
		var result = true;
		var msg		= "";
		var input_attr	= "";
		$(':input', this).each(function (index) {
			
			input_attr = $(this).attr('type');
			input_tag = $(this).get(0).tagName;

			if($(this).hasClass('required')){
				// alert($(this).val());
				// alert(input_attr)
				
				switch(input_attr){
					case "checkbox":
						try {
							result =  $.validate.checkbox($(this));
							return result;
							
						} catch(exception) {}
					break;
					case "radio":
						try {
							//alert(input_attr);
							result =  $.validate.radio($(this));
							return result;
							
						} catch(exception) {}
					break;					
					case "text":
					case "textarea":
					case "password":
						//$.validate.text($(this));
						try {
							result =  $.validate.text($(this));
							return result;
							
						} catch(exception) {alert('occur error')}
					break;							
				}
				if($(this).val() == "") {
					msg = $(this).attr("msg");
					return false;
				}
			}
		});//$(':input', this).each(function (index) {
		if(msg != "") alert(msg);
		return result;
	};

	
	$.validate = {
		checkbox : function($f) { 
			var group_class	= $f.attr('group');
			var group_cnt	= eval("$('."+group_class+"').length");//체크 박스 그룹 수
			var chk_cnt		= eval("$('."+group_class+":checkbox:checked').length");//체크된 체크 박스수
			var is_checked	= $f.is(':checked')//현재것이 체크되어 있는지 체크
			//alert(is_checked);
			var min_len		= $.validate.getclass($f.attr('class'),'min');
			var max_len		= $.validate.getclass($f.attr('class'),'max');
			if(min_len && chk_cnt < min_len){
				alert('최소 '+min_len+' 이상 선택해주세요');
				return false;
			}else if(max_len && chk_cnt > max_len){
				alert('최대 '+max_len+' 이하로 선택해주세요');
				return false;
			}else if(is_checked==false){
				//alert(chk_cnt);
				alert($f.attr('msg'));
				return false;
			}else return true;
		},
		radio : function($f) { 
			var group_class	= $f.attr('group');
			var group_cnt	= eval("$('."+group_class+"').length");//체크 박스 그룹 수
			var chk_cnt		= eval("$('."+group_class+":radio:checked').length");//체크된 체크 박스수
			//var is_checked	= $f.is(':checked')//현재것이 체크되어 있는지 체크
			//alert(group_cnt);
			//alert(chk_cnt);
			//if($("input[name=telcom]:radio:checked").length == 0){
			if(chk_cnt==0){
				//alert(chk_cnt);
				alert($f.attr('msg'));
				return false;
			}else return true;
		},		
		text : function($f) { 
			var group_class	= $f.attr('group');
			var min_len		= $.validate.getclass($f.attr('class'),'min');
			var max_len		= $.validate.getclass($f.attr('class'),'max');
			var str_len		= $f.val().length;
			var result;
			//alert(min_len);
			//alert(max_len);
			//alert(str_len);
			if(min_len && str_len < min_len){
				alert('최소 '+min_len+'자 이상 입력해주세요');
				$f.focus();
				return false;
			}else if(max_len && str_len > max_len){
				alert('최대 '+max_len+'자 이하로 입력해주세요');
				$f.focus();
				return false;
			}else if(str_len == 0){
					alert($f.attr('msg'));
					$f.focus();
				return false;
			}else if($f.hasClass('check_email')){//이메일 체크 인경우
				if(!$.validate.email($f.val())){
					alert('유효하지 않은 이메일 입니다.');
					$f.focus();
					return false;
				}
			}else if($f.hasClass('check_jumin1') || $f.hasClass('check_jumin2')){//주민등록번호인경우
				eval("$('."+group_class+"')").each(function (index) {
					tmp[index] = $(this).val();					 
				});
				var jumin1 = $('.check_jumin1').val();
				var jumin2 = $('.check_jumin2').val();
				//alert(jumin1);
				
				if(!$.validate.jumin(jumin1, jumin2)){
					alert('유효하지 않은 주민등록번호 입니다.');
					$f.focus();
					return false;
				}
			}else if($f.hasClass('check_eng')){//영문 only
				if(!$.validate.alpha($f.val())){
					alert('영문만 가능합니다.');
					$f.focus();
					return false;
				}	
			}else if($f.hasClass('check_num')){//숫자 only
				if(!$.validate.num($f.val())){
					alert('숫자만 가능합니다.');
					$f.focus();
					return false;
				}	
			}else if($f.hasClass('check_kor')){//한글 only
				if(!$.validate.kor($f.val())){
					alert('한글만 가능합니다.');
					$f.focus();
					return false;
				}	
			}else if($f.hasClass('check_engnum')){//숫자영문 only
				if(!$.validate.alphanum($f.val())){
					alert('영숫자만 가능합니다.');
					$f.focus();
					return false;
				}	
			}else if($f.hasClass('check_nospecial')){//no special char
				if(!$.validate.special($f.val())){
					alert('특수문자는 사용불가능합니다.');
					$f.focus();
					return false;
				}				
			}else if(group_class){//두개의 텍스트 필드 비교하기
				var tmp	= new Array();
				eval("$('."+group_class+"')").each(function (index) {
					tmp[index] = $(this).val();					 
				});
				
				var comparestr = new RegExp(tmp[0]); 
				if(comparestr.test(tmp[1]) && tmp[0].length == tmp[1].length){ //
					return true;
				}else{
					alert('문자열이 일치하지 않습니다.');
					$f.focus();
					return false;
				}
			}else return true;
		},		
		getclass : function(strClass, strClassName) {
			var arr = strClass.split(' ');
			var i;
			var regex = new RegExp('^'+strClassName, 'g');
			for (i=0; i < arr.length; i++)
				if(regex.test(arr[i])) {
					if(arr[i].replace(strClassName,'').length != 0)
						return arr[i].replace(strClassName,'');
				}
			
			return null;
		},		
		email : function(email) {
			var reg_email = /[-!#$%&'*+\/^_~{}|0-9a-zA-Z]+(\.[-!#$%&'*+\/^_~{}|0-9a-zA-Z]+)*@[-!#$%&'*+\/^_~{}|0-9a-zA-Z]+(\.[-!#$%&'*+\/^_~{}|0-9a-zA-Z]+)*/;
			if( !reg_email.test(email) ) {
				return false;
			}else return true;
		},	
		jumin : function(jumin1, jumin2) {
			if(jumin1.length != 6 || jumin2.length != 7) {
				return false;
			}else if(!$.validate.num(jumin1) || !$.validate.num(jumin2) ){
				return false;
			}else{
				var i;
				chk = 0;
				for (i=0; i<6; i++) chk += ( (i+2) * parseInt( jumin1.substring( i, i+1) ));
				for (i=6; i<12; i++) chk += ( (i%8+2) * parseInt( jumin2.substring( i-6, i-5) ));         
	
				chk = 11 - (chk%11);
				chk %= 10;
				if (chk != parseInt( jumin2.substring(6,7))) {
						//alert ("정확하지 않은 주민등록 번호입니다.");
						return false;
				}else return true;
			}
		},			
		num : function(str) {
			if(str.length != 0 && !str.match(/^[0-9]+$/)) {
				return false;
			}else return true;
		},		
		alpha : function(str) {
			if(str.length != 0 && !str.match(/^[a-zA-Z]+$/)) {
				return false;
			}else return true;
		},		
		kor : function(str) {
			if(str.length != 0 && !str.match(/^[가-힣]+$/)) {
				return false;
			}else return true;
		},		
		alphanum : function(str) {
			if(str.length != 0 && !str.match(/^[0-9a-zA-Z]+$/)) {
				return false;
			}else return true;
		},		
		special : function(str) {
			if(str.length != 0 && !str.match(/^[가-힣a-zA-Z0-9]+$/)) {
				return false;
			}else return true;
		}
	};
	
})(jQuery);