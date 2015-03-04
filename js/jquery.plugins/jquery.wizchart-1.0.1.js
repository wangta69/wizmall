/*
*  url : http://www.shop-wiz.com 
*  usage : $(class).chart(); $(".pageviewbar").chart({	height:5,bgcolor:"red"});
* realver : 1.0.2
*/

(function($) {
	$.fn.chart = function(options) {
		
		var opt = {
			height:10,
			bgcolor:"blue",
			show_ratio:false
		};
		
		$.extend(opt, options);

	this.each(function(){
			var el = $(this);	
			var ratio = el.attr("ratio");
			width = Math.round((ratio * el.width()) / 100);
			el.append('<span class="bar" style="float:left;background-color:'+opt.bgcolor+';width:0px;height:'+opt.height+'px"></span>');
			if(opt.show_ratio) el.append('<span>'+ratio+'%</span>');
			var bar = $('.bar', this);
			bar.animate({
				'width' : width
			}, 1000);			
		});
		//return this;
	};
})(jQuery);
