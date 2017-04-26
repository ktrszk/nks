/**---------------------------------
 * @use jQuery 1.7 later
 ---------------------------------*/
;(function($){
	$(document).ready(function(){

		//rollover	
		$("a img[src*='_on']").addClass("current");
		
		$("a img,:image").mouseover(function(){
			if($(this).hasClass('current')) return;
			if ($(this).attr("src").match(/_off./)){
				$(this).attr("src",$(this).attr("src").replace("_off.", "_on."));
				return;
			}
		}).mouseout(function(){
			if($(this).hasClass('current')) return;
			if ($(this).attr("src").match(/_on./)){
				$(this).attr("src",$(this).attr("src").replace("_on.", "_off."));
				return;
			}
		}).click(function(){
			if($(this).hasClass('current')) return;
			if ($(this).attr("src").match(/_on./)){
				$(this).attr("src",$(this).attr("src").replace("_on.", "_off."));
				return;
			}
		});
		
		$("a").each(function(){
			if($(this).css("background-image").match(/_off./)){
				$(this).mouseover(function(){
					$(this).css("background-image", $(this).css("background-image").replace("_off.", "_on."));
					$(this).find("img").attr("src",$(this).find("img").attr("src").replace("_off.", "_on."));
				});
				$(this).mouseout(function(){
					$(this).css("background-image", $(this).css("background-image").replace("_on.", "_off."));
					$(this).find("img").attr("src",$(this).find("img").attr("src").replace("_on.", "_off."));
				});
				$(this).click(function(){
					$(this).css("background-image", $(this).css("background-image").replace("_on.", "_off."));
					$(this).find("img").attr("src",$(this).find("img").attr("src").replace("_on.", "_off."));
				});
			}
		});
		
		$("area").mouseover(function(){
			var mapname = $(this).parent().attr("name");
			var img = $("img[usemap=#"+mapname+"]");
			if (img.attr("src").match(/_off./)){
				img.attr("src",img.attr("src").replace("_off.", "_on."));
			}
			return;
		});
		$("area").mouseout(function(){
			var mapname = $(this).parent().attr("name");
			var img = $("img[usemap=#"+mapname+"]");
			if (img.attr("src").match(/_on./)){
				img.attr("src",img.attr("src").replace("_on.", "_off."));
			}
			return;
		});

		//preload images
		var images = [];
		$("a img,:image").each(function(index){
				if($(this).attr("src").match(/_off./)){
					 images[index]= new Image();
					 images[index].src = $(this).attr("src").replace("_off.", "_on.");
				}
				if($(this).attr("src").match(/_on./)){
					 images[index]= new Image();
					 images[index].src = $(this).attr("src").replace("_on.", "_off.");
				}
		});

		// popup
		// class="popup400x600" -> window.open(this.href,"popup","width=400,height=600,...)
		$("a[class^='popup']").click(function(){
			if($.browser.safari ){
				window.open(this.href,"_blank");
				return false;
			}
			var className = $(this).attr("class").match(/^popup([0-9]{1,})x([0-9]{1,})/) ;	
			var width = RegExp.$1;
			var height = RegExp.$2;
			var state = "";
			var notHasSize = "yes"
			if(width!=null && height !=null){
				state += "width="+width+",height="+height+",";
				notHasSize = "no"
			}
			state += "location="+notHasSize+",toolbar="+notHasSize+",directories="+notHasSize+",";
			state += "status=yes,menubar=no,scrollbars=yes,resizable=yes,alwaysRaised=yes";
			window.name = document.domain + "root";
			window.open(this.href,"popup"+(new Date()).getTime().toString(),state);
			return false;
		});
		// open in popup parent window.
		// add class="openParentWin" on a-tag in a popup window.
		$("a.openParentWin").click(function(){
			window.open(this.href,document.domain + "root");
			return false;
		});

		// external
		function windowOpen(){
			window.open(this.href,"_blank");
			return false;
		}
		var domains = [document.domain, "groupsitedomains"];
		$("a:not([class^=popup]), area:not([class^=popup]").each(function(){
			var url = $(this).attr("href");
			if(url.match(/^https?:/)){
				var aurl = url.split("/");
				var str = aurl[2];
				var flg=true;
				for(i=0;i<domains.length;i++){
					if(str == domains[i]) flg = false;
				}
				if(flg && !$(this).attr("target")){
					$(this).addClass("external");
				}
			}
			if($(this).attr("target") == "_blank"){
				$(this).addClass("external");
			}
		});

		//Smooth Scroll
		function smoothScroll() { 
			var target = $(this.hash);
			if(target.size()) { 
				var top = target.offset().top;
				$($.browser.safari ? 'body' : 'html').animate({scrollTop:top}, 800, 'swing'); 
			} 
			return false; 
		} 

		$("a.external").bind("click",windowOpen);
		$('a[href^=#]').each(function(){
			if(!$(this).attr("target")) $(this).bind("click",smoothScroll);
		});
		$('a[href^=mailto]').each(function(){
			var url = $(this).attr("href");
			url = url.replace(/\(dot\)/g,".");
			url = url.replace(/\(at\)/,"@");
			$(this).attr("href",url);
		});
		
		//Colorbox
		if($.colorbox){
			$('a[rel=colorboxIframe]').colorbox({iframe:true, innerWidth:960, innerHeight:470});
		}
	});
	
		$(window).load(function() {
			if(location.hash != "") {
				var target = $(location.hash);
				if(target.size()) { 
					var top = target.offset().top;
					$($.browser.safari ? 'body' : 'html').animate({scrollTop:top}, 800, 'swing'); 
				}
			}
		});
})(jQuery);

