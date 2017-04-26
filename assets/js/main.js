;(function($){
	$(document).ready(function(){
		$("#wrapper").smoothScroller({fps:60, speed:0.1});
		$(window).bind("scrollSmooth",onScroll);
		 onScroll();
	});
	
	function onScroll(){
		var h = $("#wrapper").outerHeight(true);
		var r = (h-4000) / h;
		var hy = $(window).data("scrollSmoothY")
		var y = hy * r - 50;
		//
		$("#header").css("top", hy + "px");
		//
		$("#contents").css({backgroundPosition: "50% " + y +"px"});
		$("#top_bg_item3").css("top", y +"px");
		//
		var y1 =y * -2;
		$("#top_bg_item1").css("top", y1 +"px");
		//
		var x2 = y * 3;
		var y2 = y * -1;
		$("#top_bg_item2").css("left",x2 +"px");
		$("#top_bg_item2").css("top", y2 +"px");
		//
		var y4 = y * 0.5;
		$("#top_bg_item4").css("top", y4 +"px");
		//
		var y5 = y * -1.5;
		$("#top_bg_item5").css("top", y5 +"px");
		//
		var y6 = y * -0.5;
		$("#top_bg_item6").css("top", y6 +"px");
		//
		var y7 = y * 0.5;
		$("#top_bg_item7").css("top", y7 +"px");
		//
		var x8 = y * 2;
		$("#top_bg_item8").css("left", x8 +"px");
		//
		var y9 = y * 0.75;
		$("#top_bg_item9").css("top", y9 +"px");
		//
		var y10 = y * -0.5;
		$("#top_bg_item10").css("top", y10 +"px");
	}
})(jQuery);
