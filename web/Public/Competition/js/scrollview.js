$(document).ready(function(e) {
	var sWidth = $("#inner ul li").width() + 13;
	var len = $("#inner ul li").length;
	var index = 0;
	var picTimer;
	$("#inner ul").css("width", sWidth * (len));
	$("#inner").hover(function() {
		clearInterval(picTimer);
	}, function() {
		if (len > 5) {
			picTimer = setInterval(function() {

				showPics(index);
				index++;
				if ((index + 5) >= len) {
					index = 0;
				}
			}, 4000);
		}

	}).trigger("mouseleave");
	$("#next_btn").click(function() {
		index++;
		if ((index + 5) >= len) {
			index = 0;
		}
		showPics(index);
	});
	$("#prev_btn").click(function() {
		index--;
		if (index<=0) {
			index = 0;
		}
		showPics(index);
	});
	function showPics(index) {
		var nowLeft = -index * sWidth;
		$("#inner ul").stop(true, false).animate({
			"left" : nowLeft
		}, 300);

	}
});