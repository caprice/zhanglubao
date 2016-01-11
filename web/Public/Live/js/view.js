

if (typeof($SYS) === "undefined") {
	var $SYS = {}
}
function get_cookie(b) {
	if (typeof($SYS.cookie_pre) !== "undefined") {
		b = $SYS.cookie_pre + b
	}
	var a = document.cookie.match(new RegExp("(^| )" + b + "=([^;]*)(;|$)"));
	if (a !== null) {
		return decodeURIComponent(a[2])
	}
	return null
}
function setCookie(d, e, f) {
	f = f || 0;
	var a = "";
	if (f !== 0) {
		var b = new Date();
		b.setTime(b.getTime() + (f * 1000));
		a = "; expires=" + b.toGMTString()
	}
	if (typeof($SYS.cookie_pre) !== "undefined") {
		d = $SYS.cookie_pre + d
	}
	document.cookie = d + "=" + escape(e) + a + "; path=/"
}


function updateScroller() {
	var scrollheight = $(window).height() - 270;
	$('#game_scroll').height(scrollheight);
	$('#game_scroll').slimScroll({
		height : scrollheight
	});
}


function set_room_title_width() {
	 
}


function call_resize(d, c) {
	try {
		var f = d + "|" + c;
		thisMovie("WebRoom").js_sendsize(f)
	} catch (g) {
		setTimeout("call_resize(" + d + ", " + c + ")", 5000)
	}
}


function thisMovie(c) {
	if (navigator.appName.indexOf("Microsoft") != -1) {
		return window[c]
	} else {
		return document[c]
	}
}



function set_live_height() {
	var g = $(window).height() || $(document).height();
	var d = $(window).width() || $(document).width();
	
	$("#live_main").height(g);
	
	if ($("#live_player").hasClass("alls")) {
		if ($("#playLeft").length) {
			$("#PlayArea").height(g)
		}
		$("#live_player .swf_container").height(g);
		//call_resize(d, g);
		return false
	}
	if ($("#playLeft").length) {
		var e = function() {
			var j = $("#playLeft");
			var k = $("#playRight");
			var h = d - (j.is(":hidden") ? 0 : j.width())
					- (k.is(":hidden") ? 0 : k.width());
			$("#chatArea").height(g);
			$("#chatContent").height(g - 117)
		}();
		var c = $("#live_player").width();
		var f = c / 1262 * 710;
		var i = 0;
		$("#live_switch").each(function() {
			if ($(this).hasClass("host")) {
				i += $(this).outerHeight(false)
			} else {
				i += $(this).outerHeight(true)
			}
		});
		if (g - i < f) {
			f = g - i
		}
		$("#live_player").height(f);
		$(".swf_container").height(f);
		$("#PlayArea").height(g);
		call_resize(c, f);
		set_room_title_width()
	} else {
		$("#live_player .swf_container").height($("#live_player").height());
		call_resize($("#live_player").width(), $("#live_player").height())
	}
}


function set_window_width() {
	if ($("#live_player").hasClass("alls")) {
		return false
	}
	var c = $(window).width() || $(document).width();
	var d = $("#playLeft");
	if (d.length === 0) {
		return false
	}
	var e = $("#playRight");
	var g = $("#leftNav");
	var f = $("#leftSmallNav");
	var h = $("#PlayArea");
	if (c <= 1024 && g.is(":visible")) {
		g.hide();
		f.show();
		d.css("width", "49px");
		h.css("margin-left", "49px");
		$("#left_close").addClass("left_open")
	}
	if (c > 1024 && get_cookie("left_menu") != "1") {
		h.css("margin-left", "240px");
		d.css("width", "240px");
		f.hide();
		g.show();
		$("#left_close").removeClass("left_open");
		updateScroller();
		
	}
	if (c <= 920 && e.is(":visible")) {
		e.hide();
		h.css("margin-right", 0);
		$("#right_close").addClass("right_open")
	}
	if (c > 920 && get_cookie("right_menu") != "1") {
		h.css("margin-right", "325px");
		e.show();
		$("#right_close").removeClass("right_open")
	}
}


$(function() {
	$("#playLeft").height($(window).height());
	$("#playRight").height($(window).height());
	updateScroller();
	var $PlayArea = $("#PlayArea");
 
	$(window).resize(function() {
		$("#playLeft").height($(window).height());
		$("#playRight").height($(window).height());
		updateScroller();
	});
	
	
	if ($("#playLeft").length) {
		$("#PlayArea").height($(window).height())
	}
 
	set_window_width();
	set_live_height();
	$(window).resize(function() {
		set_window_width();
		set_live_height();
		 
	});

	

});




