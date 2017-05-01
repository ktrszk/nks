;(function($){
	$(document).ready(function(){
		$("#wrapper").smoothScroller({fps:60, speed:0.1});
		$(window).bind("scrollSmooth",onScroll);
		onScroll();
		//
		$(".building_management_menu").click(function(){
			set_building_management_more($(this).attr("rel"));
		});
		set_building_management_more(0);
		$("#building_management_more3_slidearea").slideContents({
			left: $("#building_management_more3_slide_btn_left"),
			right: $("#building_management_more3_slide_btn_right")
		});
		$("#building_management_more6_slidearea").slideContents({
			left: $("#building_management_more6_slide_btn_left"),
			right: $("#building_management_more6_slide_btn_right")
		});
		$("#designated_manager_more_slidearea").slideContents({
			left: $("#designated_manager_more_slide_btn_left"),
			right: $("#designated_manager_more_slide_btn_right")
		});
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
		var building_management_y = y-(70+34);
		$("#building_management_area").css({backgroundPosition: "50% " + building_management_y +"px"});
		//
		var designated_manager_y = y-(70+34+600+535);
		$("#designated_manager_area").css({backgroundPosition: "50% " + designated_manager_y +"px"});
		//
		var enegy_conservation_y = y-(70+34+600+535+600+660);
		$("#enegy_conservation_area").css({backgroundPosition: "50% " + enegy_conservation_y +"px"});
		//
		var management_products_y = y-(70+34+600+535+600+660+535+600);
		$("#management_products_area").css({backgroundPosition: "50% " + management_products_y +"px"});
		//
		var ww = Math.min(580, Math.max(480, getWindowWidth() * 0.5));
		var lx = 478 - ww;
		var rx = ww - 59 + 480;
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
	
	function set_building_management_more(id) {
		$("a.building_management_menu").each(function(i){
			if($(this).attr("rel")==id){
				$(this).find("img").mouseover();
				$(this).find("img").addClass("current");
			}else{
				$(this).find("img").removeClass("current");
				$(this).find("img").mouseout();
			}
		});
		$(".building_management_more").each(function(i){
			var backgrounds=[
				{"background-color":"#1b7a09", "background-image":"url('assets/img/light_green_bg.gif')"},
				{"background-color":"#1b7a09", "background-image":"url('assets/img/light_green_bg.gif')"},
				{"background-color":"#1b7a09", "background-image":"url('assets/img/light_green_bg.gif')"},
				{"background-color":"#770000", "background-image":"url('assets/img/red_bg.gif')"},
				{"background-color":"#062666", "background-image":"url('assets/img/blue_bg.gif')"},
				{"background-color":"#c36508", "background-image":"url('assets/img/orange_bg.gif')"},
				{"background-color":"#159fff", "background-image":"url('assets/img/lightblue_bg.gif')"}
			]
			if(i == id){
				$(this).css("display","block");
				$(this).stop().queue([]);
				$(this).fadeTo(0, 0, function(){
					$(this).fadeTo(300, 1);
				});
				$("#building_management_more_area").css(backgrounds[i]);
			}else{
				$(this).css("display","none");
			}
		});
	}

})(jQuery);
