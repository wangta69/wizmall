/*
How to use

$(div).locationcenter();
*/

(function($) {
	$.fn.locationcenter = function() {
		this.each(function(){
			var element = $(this);
			var win = $(window);
			
			var x = win.width();
			var y = win.height();
	 		element.css("position", "absolute");
			element.css("left", win.scrollLeft() + x/2 - element.width()/2);
			element.css("top", win.scrollTop() + y/2 - element.height()/2);	
		});
		return this;
	};
})(jQuery);