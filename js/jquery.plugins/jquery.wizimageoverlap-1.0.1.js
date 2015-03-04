/* 
usage sampel
ver 1.0.5

$(function(){
	var iniImg = $(".thumimg:first").attr("src")
	$("#bigImg img").attr("src", iniImg) ; 
	
	$(".thumimg").mouseover(function(){
		$(this).wizimagech();
	});
});

<style type="text/css">
ul li{display:inline;}
</style>

<div id="bigImg" style="position:relative"><img src="" width="500" height="500" class='curImage' /></div>

<ul>
<li><img src="../actionsc/images/benz.png" width="100" height="100" class="thumimg"/></li>
<li><img src="../actionsc/images/bmw.png" width="100" height="100" class="thumimg"/></li>
<li><img src="../actionsc/images/infiniti.png" width="100" height="100" class="thumimg"/></li>
</ul>

별도의 이미지를 보여주고싶을 경우 ref="이미지 위치" 를 추가한다.
<div id="bigImg" style="position:relative"><img src="" width="500" height="500" class='curImage' ref="이미지 위치" /></div>
*/
(function($) {

	$.fn.wizimagech = function(options) {
		wizgallery_defaults = {  
			fadeout:	500,
			fadein:		1000
		};
		
		var options = $.extend(wizgallery_defaults, options); 

		var el = this; 
		var img_src = el.attr('ref') ? el.attr('ref'):el.attr('src'); 
		$('.nextImage').remove();
		$('.curImage').animate({'opacity':'0'}, 'slow');
		//var img_width = $('.curImage').css("width");
		//var img_height = $('.curImage').css("height");
		var img_width = $('#bigImg').css("width");
		var img_height = $('#bigImg').css("height");
		$('#bigImg').append('<img src="'+img_src+'" alt="" class="nextImage" style="position:absolute; top:0; left:0; " />');
		$("#bigImg > img").css({"width":img_width,"height":img_height });
		$('.nextImage').hide().fadeIn(options.fadein);
		$('.nextImage').animate({'opacity':'1'}, {'duraion':'fast','queue':false }, function(){
			$('.curImage').remove().hide();
			$('.nextImage').removeClass("nextImage").addClass("curImage").removeAttr("style").css({"width":img_width,"height":img_height });
		});

	};

})(jQuery);