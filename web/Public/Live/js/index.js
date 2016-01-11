function change_channel(room_id) {
	
	var url="";
	$("#flash_slide > ul > li").each(function(i) {
		if ($(this).attr("rel") == "channel_" + room_id) {
			$(this).find("a").addClass("current");
			url=$(this).attr("data-url");
		} else {
			$(this).find("a").removeClass("current");
		}
	});

	$("#enter_room").attr('href','/live/'+room_id+'.html')
	
	$('#livePlayer > embed').remove();
	var str = '<embed width="690px" height="450px" allownetworking="internal" allowscriptaccess="always" src="'+url+'" quality="high" bgcolor="#000" wmode="transparent" allowfullscreen="true" allowFullScreenInteractive="true" type="application/x-shockwave-flash">';
	$('#livePlayer').html(str);
}