;(function($){
	$(document).ready(function(){
		$(window).bind('resize scroll', function(e) {
			onScroll();
		});
	});
	
	$(window).load(function() {
	});
	
	function onScroll(){
		var y = $(window).scrollTop();
		$("#header").css("top", y + "px");		
	}

})(jQuery);
