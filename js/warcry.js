$(function() {
	// colorbox
	$('.colorbox').colorbox({rel:'colorbox', transition:'none', maxWidth: '90%', scalePhotos: 'true'});
	
	$('.embed-responsive').parent().removeClass('center');
});

$(window).on("load", function() {
	//$("div.center").each(function() {
	/*$("#main").each(function() {
		var imgs = $(this).find("img.img-responsive");
		//if (imgs.length > 1) {
			var narrow = imgs.filter(function() {
    			return $(this).width() < 400;
			});
			
			//narrow.removeClass("img-responsive");
		//}
	});*/

	// evening block heights
	// deprecated -> use flexbox
	var evenHeights = function(style) {
	    var heights = $(style).map(function() {
	        return $(this).height();
	    }).get();
	
	    maxHeight = Math.max.apply(null, heights);
	
	    $(style).height(maxHeight);
	};
});

function search(curobj) {
	curobj.q.value="site:warcry.ru " + curobj.qfront.value;
}

function loadScript(url, callback) {
	var script = document.createElement("script");
	script.type = "text/javascript";
	
	if (script.readyState) {  //IE
		script.onreadystatechange = function() {
			if (script.readyState === "loaded" || script.readyState === "complete") {
				script.onreadystatechange = null;
				callback();
			}
		};
	}
	else {  //Others
		script.onload = function() {
			callback();
		};
	}

	script.src = url;
	document.getElementsByTagName("head")[0].appendChild(script);
}
