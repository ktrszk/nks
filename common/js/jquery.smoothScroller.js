/**---------------------------------
 * @use jQuery 1.7 later
 * @ver 0.0.3
 ---------------------------------*/
;(function($) {
	var name_space = 'smoothScroller';

	$.fn[name_space] = function(options) {
		var defaults = {
			fps: 60,
			speed:0.1,
			maxspeed:false
		}
		var s = $.extend(defaults, options);
		var scrollTimer;
		var obj;

		return this.each(function(i){
			if($.support.fixedPosition) {
				scrollTo(0,0);
				obj = $(this);
				$(window).data("scrollSmoothY",0);
				obj.parent().prepend('<div id="smoothScroller_page_height"></div>');
				obj.wrap('<div id="smoothScroller_page_wrap"></div>');
				obj = $("#smoothScroller_page_wrap");
				obj.css({
					position: "fixed",
					top: "0px",
					width: "100%"
				});
				if(jQuery.browser.msie && parseInt(jQuery.browser.version) == 7){
					var l = $("#smoothScroller_page_wrap").outerWidth()*0.5;
					obj.css("left", l);
				}
				$("#smoothScroller_page_height").height(obj.outerHeight(true));
				scrollSmooth();
				$(window).bind('resize scroll', function(e) {
					var l = $(window).scrollLeft() * -1;
					if(jQuery.browser.msie && parseInt(jQuery.browser.version) == 7){
						//l -= $("#smoothScroller_page_wrap").outerWidth()*0.5;
						//l -= $(window).width()*0.5;
					}
					obj.css("left",l);
					$("#smoothScroller_page_height").height(obj.outerHeight(true));
					scrollSmooth();
				});
			}else{
				$(window).bind('resize scroll', function(e) {
					scrollNormal();
				});
			}
		});

		function scrollSmooth() {
			if(scrollTimer) clearInterval(scrollTimer);
			var t = $(window).scrollTop();
			var p = obj.css("top").replace("px", "") * 1;
			var v = (t*-1 - p);
			var vv = v * s.speed;
			if(s.maxspeed){
				var mv = (vv > 0)? Math.abs(s.maxspeed) : Math.abs(s.maxspeed)*-1;
				vv = (Math.abs(vv) < Math.abs(s.maxspeed))? vv : mv;
			}
			if(vv < 0 && vv > -1) vv = -1;
			if(vv > 0 && vv < 1) vv = 1;
			var m = p + vv;
			var value = (Math.abs(v) < 1)? t*-1 : m*1;
			if(value<0){
				value = Math.floor(value);
			}else{
				value = Math.ceil(value);
			}
			obj.css("top",value);
			if(Math.abs(v) >= 1){
				scrollTimer = setInterval(scrollSmooth,1000/s.fps);
			}
			$(window).data("scrollSmoothY", value * -1);
			$(window).trigger("scrollSmooth");
		}

		function scrollNormal() {
			var value = $(window).scrollTop();
			$(window).data("scrollSmoothY", value);
			$(window).trigger("scrollSmooth");
		}

		function isPositionFixedSupported() {
			var container = document.body;
			if (document.createElement &&
				container && container.appendChild && container.removeChild) {
				var el = document.createElement("div");
				if (!el.getBoundingClientRect) {
				    return null;
				}
				el.innerHTML = "x";
				el.style.cssText = "position:fixed;top:100px;";
				container.appendChild(el);
				var originalHeight = container.style.height, originalScrollTop = container.scrollTop;
				container.style.height = "3000px";
				container.scrollTop = 500;
				var elementTop = el.getBoundingClientRect().top;
				container.style.height = originalHeight;
				var isSupported = elementTop === 100;
				container.removeChild(el);
				container.scrollTop = originalScrollTop;
				return isSupported;
			}
			return null;
		}
	};
})(jQuery);