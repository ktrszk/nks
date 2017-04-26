/**---------------------------------
 * @use jQuery 1.7 later
 * @ver 0.0.3
 ---------------------------------*/
;(function($) {
	var name_space = 'slideContents';

	$.fn[name_space] = function(options) {
		var defaults = {
			pagewidth:"auto",
			duration: 500,
			easing:"easeOutQuart"
		}
		var s = $.extend(defaults, options);
		var obj;
		
		return this.each(function(i){
			obj = $(this);
			s.totalPages = obj.find(".slidepage").size();
			if(s.pagewidth=="auto"){
				s.pagewidth = obj.find(".slidepage").outerWidth(true);
			}
			s.currentPage = 0;
			s.left.click(function(){pageSlide(-1); return false;});
			s.right.click(function(){pageSlide(1); return false;});
			setNavi();
			
			
			
		});
		function pageSlide(n) {
		//console.log(s.easing);
			s.currentPage += n;
			if(s.currentPage<0) s.currentPage = 0;
			if(s.currentPage>=s.totalPages) s.currentPage = s.totalPages - 1;
			var x = s.currentPage * s.pagewidth * -1;
			obj.find(".slidearea_inner").queue([]).animate({marginLeft: x + "px"}, s.duration, s.easing);
			setNavi();

		}
			
		function setNavi() {
			if(s.currentPage>0){
				s.left.css("visibility","visible");
			}else{
				s.left.css("visibility","hidden");
			}
			if(s.currentPage<s.totalPages-1){
				s.right.css("visibility","visible");
			}else{
				s.right.css("visibility","hidden");
			}
		}
	};
})(jQuery);