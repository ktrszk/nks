;(function($){
	$(document).ready(function(){
		$("#wrapper").smoothScroller({fps:60, speed:0.1});
		$(window).bind("scrollSmooth",onScroll);
		onScroll();
		$("#outline_scoll_box").mCustomScrollbar("vertical",300,"easeOutCirc",1,"auto","yes","no",15); 
	});
	
	$(window).load(function() {
	});
	
	function onScroll(){
		var y = $(window).data("scrollSmoothY")
		var h = $("#wrapper").outerHeight(true);
		var wh = getWindowHeight();
		//var subnavi_y = Math.max(70, y);
		var subnavi_y = y + $("#header").outerHeight(true);
		$("#header").css("top", y + "px");
		$("#subnavi").css("top", subnavi_y + "px");
		//
		//var greeting_y = y*0.6-(70+34+100);
		var greeting_y = y-(70+34+100);
		$("#greeting_area").css({backgroundPosition: "50% " + greeting_y +"px"});
		//
		var philosophy_y = y-(70+34+800);
		$("#philosophy_area").css({backgroundPosition: "50% " + philosophy_y +"px"});
		//
		var outline_min_y = 70+34+800;
		var outline_max_y = outline_min_y+800+800+wh;
		var outline_y = Math.max(outline_min_y, Math.min(outline_max_y, y))-outline_min_y;
		var outline_ratio = (970-800)/800;
		outline_y = outline_y * outline_ratio*-0.5;
		outline_y = y- (70+34+800+800);
		$("#outline_area").css({backgroundPosition: "50% " + outline_y +"px"});
		//
		var csr_y = (y-(70+34+800+800+1000));
		$("#csr_area").css({backgroundPosition: "50% " + csr_y +"px"});
		
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

})(jQuery);
