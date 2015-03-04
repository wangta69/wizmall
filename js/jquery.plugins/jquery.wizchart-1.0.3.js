/*
*  url : http://www.shop-wiz.com 
*  usage : $(class).chart();
* $(".endbar").chart({	height:5,bgcolor:"red",addchar:"건"});	
* <div><ul><li ratio="{.s}" class="startbar" alt='시작건수 : {.s}' style="list-style:none"></li></ul></div>
*/
(function($) {
	$.fn.chart = function(options) {
		
		var opt = {
			height:10,
			bgcolor:"blue",
			addchar:"%"
		};
		
		$.extend(opt, options);

	this.each(function(){
			var el = $(this);	
			var ratio = el.attr("ratio");
			width = Math.round((ratio * el.width()) / 100);
			el.append('<span class="bar" style="float:left;background-color:'+opt.bgcolor+';width:0px;height:'+opt.height+'px"></span>');
			el.append('<span>'+ratio+opt.addchar+'</span>');
			var bar = $('.bar', this);
			bar.animate({
				'width' : width
			}, 1000);			
		});
		//return this;
	};
})(jQuery);
