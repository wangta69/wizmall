/*
How to use


jquery-ui-1.7.2.custom.min.js �� �Բ� ���
$(".popup").click(function(){
	$(this).popup();
	return false;
});

	$(".direct").click(function(){
		var url = "/test.php";
		$(this).popup({url:url});
	});
	
�˾��� ������ close â�� ������
	$(".btn_close").click(function(){
		var i = $(".btn_close").index(this);
		$(this).parents().find(".dynamicPop").eq(i).remove();
	});
	
*/

(function($) {
	$.fn.popup = function(options) {
		var url = $(this).attr("href");
		var title = $(this).attr("title");
		var opt = {
			backlayer:false,
			url:false,
			title:false,
			duplicate:true
		};
		
		$.extend(opt, options);
		
		if(opt.url) url = opt.url;
		if(opt.title) title = opt.title;

		var win = $(window);
		
		var x = win.width();
		var y = win.height();

		//duplicate Ȱ��ȭ �Ǿ� ������ ������ â�� ����� 
		// �ƴϸ� ����â�� ������ �� â�� �̿��Ѵ�.
		if(opt.duplicate) $("body").append('<div class="dynamicPop"><div class="popHead"><h3>'+title+'</h3><a class="pop_close"></a></div><div class="popMessage"></div></div>');
		else{
			//alert($("body .dynamicPop").length);
			if(	!$("body .dynamicPop").length)  $("body").append('<div class="dynamicPop"><div class="popHead"><h3>'+title+'</h3><a class="pop_close"></a></div><div class="popMessage"></div></div>');
			
		}

		var element = $(".dynamicPop").last();
		element.hide().draggable();		
		element.find(".popMessage").load(url, function(){
			element.css({"position":"absolute","z-index":"2000"});
			element.css("left", win.scrollLeft() + x/2 - element.width()/2);
			element.css("top", win.scrollTop() + y/2 - element.height()/2);	
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