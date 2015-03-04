/*
ver 1.2.0 

How to use
jquery-ui-1.7.2.custom.min.js 와 함께 사용
$(".popup").click(function(){
	$(this).popup();
	return false;
});

	$(".direct").click(function(){
		var url = "/test.php";
		$(this).popup({url:url});
	});
	
팝업에 별도의 close 창을 만들경우
	$(".btn_close").click(function(){
		var i = $(".btn_close").index(this);
		$(this).parents().find(".dynamicPop").eq(i).remove();
	});
	
*/

(function($) {
	$.fn.popup = function(options) {
		var url		= $(this).attr("href");
		var title	= $(this).attr("title");
		var top		= 0;
		var left	= 0;
		var width	= 0;
		var height	= 0;
		
		var opt = {
			backlayer:false,
			url:false,
			title:false,
			duplicate:true,
			left:false,
			top:false,
			width:false,
			height:false
		};
		
		$.extend(opt, options);
		
		if(opt.url) url			= opt.url;
		if(opt.title) title		= opt.title;
		if(opt.left) left		= opt.left;
		if(opt.top) top			= opt.top;
		if(opt.width) width		= opt.width;
		if(opt.height) height	= opt.height;
		title = "";
		var win = $(window);
		
		var x = win.width();
		var y = win.height();

		//duplicate 활성화 되어 있으면 새로이 창을 만들고 
		// 아니면 기존창이 있으면 그 창을 이용한다.
		if(opt.duplicate) $("body").append('<div class="dynamicPop"><div class="popHead">'+title+'<a class="pop_close"></a></div><div class="popMessage"></div></div>');
		else{
			//alert($("body .dynamicPop").length);
			if(	!$("body .dynamicPop").length)  $("body").append('<div class="dynamicPop"><div class="popHead">'+title+'<a class="pop_close"></a></div><div class="popMessage"></div></div>');
			
		}

		var element = $(".dynamicPop").last();
		//console.log("element:"+element.hide());
		element.hide().draggable();		
		element.find(".popMessage").load(url, function(){
			element.css({"position":"absolute","z-index":"2000"});
			
			if(opt.left == false) element.css("left", win.scrollLeft() + x/2 - element.width()/2);
			else element.css("left", left);
			
			if(opt.top == false) element.css("top", win.scrollTop() + y/2 - element.height()/2);	
			else element.css("top", top);
			
			element.show();
			//element.css({width:'300px', border:'1px solid #cccccc', backgroundColor:'white', padding:'5px'});
		});

		if(opt.backlayer){
			$("body").append('<div id="layerBack" style="display:none"></div>');
			$("#layerBack").css({
				opacity: (30 / 100),
				filter: 'alpha(opacity=' + 30 + ')', 
				position: 'absolute',
				zIndex: 1000,
				top: '0px',
				left: '0px',
				width: '100%',
				height: $(document).height(),
				background: "#000"
			}).show();
	
	
			$("#layerBack").live("click", function(){
				$("#layerBack").hide();
				element.remove();
			});
		}
		
		element.find(".pop_close").click(function(){
			$("#layerBack").hide();
			element.remove();
		});			
		return this;
		
	};
})(jQuery);