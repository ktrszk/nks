var _gaq_param = (function() {
	var d = document;
	var scripts = [];;
	if (d.getElementsByTagName)
		scripts = d.getElementsByTagName("script");
	else if (d.scripts)
		scripts = d.scripts;
	else if (d.all && d.all.tags)
		scripts = d.all.tags("script");
	
	var pears = [];
	
	if (scripts) {
		for(i=0;i<scripts.length;i++){
			if(scripts[i].src.indexOf('galoader.js')!=-1){
				var src = scripts[i].src
				var query = new Object();
				if (src && src.indexOf("?") != -1) {
					src = src.substring(src.indexOf("?") +1);
					pears = src.split(":");
				}
				break;
			}
		}
	}
	return pears;
})();

if(_gaq_param[0]){
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', _gaq_param[0]]);
	_gaq.push(['_trackPageview']);
	(function() {
		var gajsurl = '.google-analytics.com/ga.js';
		if(_gaq_param.length>1){
			if(location.hostname.indexOf(_gaq_param[1]) == -1) {
				gajsurl = '.google-analytics.com/u/ga_debug.js';
			}
		}
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + gajsurl;
		(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ga);
	})();
}
