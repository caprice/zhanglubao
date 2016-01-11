$(document).ajaxStart(function() {
	$("button:submit").addClass("log-in").attr("disabled", true);
}).ajaxStop(function() {
	$("button:submit").removeClass("log-in").attr("disabled", false);
});

$("form").submit(function() {
	var self = $(this);
	$.post(self.attr("action"), self.serialize(), success, "json");
	return false;

	function success(data) {
		if (data.status) {
			window.location.href = data.url;
		} else {
			self.find(".check-tips").text(data.info);
		}
	}
});