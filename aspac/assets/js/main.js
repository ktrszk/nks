;(function($){
	$(document).ready(function(){
		$("#wrapper").smoothScroller({fps:60, speed:0.1});
		$(window).bind("scrollSmooth",onScroll);
		onScroll();
		//
		$("#recommend_slidearea").slideContents({
			left: $("#recommend_slide_btn_left"),
			right: $("#recommend_slide_btn_right")
		});
	});
	
	$(window).load(function() {
	});
	
	function onScroll(){
		var y = $(window).data("scrollSmoothY")
		var h = $("#wrapper").outerHeight(true);
		var wh = getWindowHeight();
		var subnavi_y = Math.max(70,y);
		$("#header").css("top", y + "px");
		//
		var order_made_y = y-(43);
		$("#order_made_area").css({backgroundPosition: "50% " + order_made_y +"px"});
		//
		var try_y = y-(43+750);
		$("#try_area").css({backgroundPosition: "50% " + try_y +"px"});
		//
		var contact_y = y-(43+750+810+750);
		$("#contact_area").css({backgroundPosition: "50% " + contact_y +"px"});
		//
		var ww = Math.min(514, Math.max(480, getWindowWidth() * 0.5));
		var lx = 478 - ww;
		var rx = ww - 34 + 480;
		$(".slide_btn_left").css("left", lx + "px");
		$(".slide_btn_right").css("left", rx + "px");
	
	}
	
	function getWindowHeight() {
		var windowsize;
		if(document.documentElement.clientHeight){
			windowsize = document.documentElement.clientHeight;
		}else if(document.body.clientHeight){
			windowsize = document.body.clientHeight;
		}else if(window.innerHeight){
			windowsize = window.innerHeight;
		}
		return windowsize;
	}
	
	function getWindowWidth() {
		var windowsize;
		if(document.documentElement.clientWidth){
			windowsize = document.documentElement.clientWidth;
		}else if(document.body.clientWidth){
			windowsize = document.body.clientWidth;
		}else if(window.innerWidth){
			windowsize = window.innerWidth;
		}
		return windowsize;
	}

})(jQuery);
