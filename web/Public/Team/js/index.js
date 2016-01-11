$(document).ready(function(e) {
	var sWidth = $("#focus").width();
	var len = $("#focus ul li").length; 
	var index = 0;
	var picTimer;
	var focusbtn = "<div class='focusbtn'>";
	for(var i=0; i < len; i++) {
		focusbtn += "<span>"+(i+1)+"</span>";
	}
    focusbtn += "</div>";
	$("#focus").append(focusbtn);
	$("#focus .focusbtn span").mouseover(function() {
		index = $("#focus .focusbtn span").index(this);
		showPics(index);
	}).eq(0).trigger("mouseover");
	$("#focus ul").css("width",sWidth * (len));
	$("#focus").hover(function() {
		clearInterval(picTimer);
	},function() {
		picTimer = setInterval(function() {
			showPics(index);
			index++;
			if(index == len) {index = 0;}
		},4000); 
	}).trigger("mouseleave");
	function showPics(index) {
		var nowLeft = -index*sWidth;
		$("#focus ul").stop(true,false).animate({"left":nowLeft},300);
		$("#focus .focusbtn span").removeClass("on").eq(index).addClass("on");
	}
});