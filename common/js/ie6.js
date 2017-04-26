/**---------------------------------
 * ie6.js
 * 
 * ...
 * author	: takaaki koyama
 *
 * @use jQuery 1.2.6 later
 * @use DD_belatedPNG 0.0.8a later
 ---------------------------------------*/
 document.writeln('<style type="text/css">body{visibility:hidden;}</style>');

 ;(function($){
	$(window).load(function() {
		//png fix
		if(DD_belatedPNG){
// add mouse hover
			var oldFixPng = DD_belatedPNG.fixPng;
			DD_belatedPNG.fixPng = function (el) {
				oldFixPng(el);
				if (el.vml && el.vml.image.fill.getAttribute("src").match(/_off\./)) {
					el.vml.image.shape.attachEvent('onmouseenter', function() {
						var image = el.vml.image.fill;
						image.setAttribute("src", image.getAttribute("src").replace("_off.", "_on."));
					});
					el.vml.image.shape.attachEvent('onmouseleave', function() {
						var image = el.vml.image.fill;
						image.setAttribute("src", image.getAttribute("src").replace("_on.", "_off."));
					});
				}
			};
// /add mouse hover
			$("img[src$='png']").addClass("pngfix");
			$("*").each(function(index,elem){
				var $elem = $(elem);
				if($elem.css("background-image") && $elem.css("background-image").indexOf("png") > -1){
					$elem.addClass("pngfix");
				}
			})
			DD_belatedPNG.fix('.pngfix');
		}
		$('body').css("visibility","visible");
	})
})(jQuery);