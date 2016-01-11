/**
 * 成功提示
 * 
 * @param text
 *            内容
 * @param title
 *            标题
 */
function op_success(text, title) {
	toastr.options = {
		"closeButton" : true,
		"debug" : false,
		"positionClass" : "toast-center",
		"onclick" : null,
		"showDuration" : "1000",
		"hideDuration" : "1000",
		"timeOut" : "5000",
		"extendedTimeOut" : "1000",
		"showEasing" : "swing",
		"hideEasing" : "linear",
		"showMethod" : "fadeIn",
		"hideMethod" : "fadeOut"
	}
	toastr.success(text, title);
}
/**
 * 失败提示
 * 
 * @param text
 *            内容
 * @param title
 *            标题
 */
function op_error(text, title) {
	toastr.options = {
		"closeButton" : true,
		"debug" : false,
		"positionClass" : "toast-center",
		"onclick" : null,
		"showDuration" : "1000",
		"hideDuration" : "1000",
		"timeOut" : "5000",
		"extendedTimeOut" : "1000",
		"showEasing" : "swing",
		"hideEasing" : "linear",
		"showMethod" : "fadeIn",
		"hideMethod" : "fadeOut"
	}
	toastr.error(text, title);
}

/**
 * 信息提示
 * 
 * @param text
 *            内容
 * @param title
 *            标题
 */
function op_info(text, title) {
	toastr.options = {
		"closeButton" : false,
		"debug" : false,
		"positionClass" : "toast-center",
		"onclick" : null,
		"showDuration" : "1000",
		"hideDuration" : "1000",
		"timeOut" : "5000",
		"extendedTimeOut" : "1000",
		"showEasing" : "swing",
		"hideEasing" : "linear",
		"showMethod" : "fadeIn",
		"hideMethod" : "fadeOut"
	}
	toastr.info(text, title);
}
/**
 * 警告提示
 * 
 * @param text
 *            内容
 * @param title
 *            标题
 */
function op_warning(text, title) {
	toastr.options = {
		"closeButton" : false,
		"debug" : false,
		"positionClass" : "toast-center",
		"onclick" : null,
		"showDuration" : "1000",
		"hideDuration" : "1000",
		"timeOut" : "5000",
		"extendedTimeOut" : "1000",
		"showEasing" : "swing",
		"hideEasing" : "linear",
		"showMethod" : "fadeIn",
		"hideMethod" : "fadeOut"
	}
	toastr.warning(text, title);
}

$('.ajax-get').click(function() {
	var target;
	var that = this;
	if ($(this).hasClass('confirm')) {
		if (!confirm('确认要执行该操作吗?')) {
			return false;
		}
	}
	if ((target = $(this).attr('href')) || (target = $(this).attr('url'))) {
		$.get(target).success(function(data) {
			if (data.status == 1) {
				if (data.url) {
					op_success(data.info + ' 页面即将自动跳转~');
				} else {
					op_success(data.info);
				}
				setTimeout(function() {
					if (data.url) {
						location.href = data.url;
					} else if ($(that).hasClass('no-refresh')) {
						$('#top-alert').find('button').click();
					} else {
						location.reload();
					}
				}, 1500);
			} else {
				op_error(data.info);
				setTimeout(function() {
					if (data.url) {
						location.href = data.url;
					} else {
						$('#top-alert').find('button').click();
					}
				}, 1500);
			}
		});

	}
	return false;
});

$('.ajax-post').click(
		function() {
			var target, query, form;
			var target_form = $(this).attr('target-form');
			var that = this;
			var nead_confirm = false;
			if (($(this).attr('type') == 'submit' || ($(this).html() == '完成')
					|| (target = $(this).attr('href')) || (target = $(this)
					.attr('url')))) {
				form = $('.' + target_form);

				if ($(this).attr('hide-data') === 'true') {
					form = $('.hide-data');
					query = form.serialize();
				} else if (form.get(0) == undefined) {
					return false;
				} else if (form.get(0).nodeName == 'FORM') {
					if ($(this).hasClass('confirm')) {
						if (!confirm('确认要执行该操作吗?')) {
							return false;
						}
					}
					if ($(this).attr('url') !== undefined) {
						target = $(this).attr('url');
					} else {
						target = form.get(0).action;
					}
					query = form.serialize();
				} else if (form.get(0).nodeName == 'INPUT'
						|| form.get(0).nodeName == 'SELECT'
						|| form.get(0).nodeName == 'TEXTAREA') {
					form.each(function(k, v) {
						if (v.type == 'checkbox' && v.checked == true) {
							nead_confirm = true;
						}
					})
					if (nead_confirm && $(this).hasClass('confirm')) {
						if (!confirm('确认要执行该操作吗?')) {
							return false;
						}
					}
					query = form.serialize();
				} else {
					if ($(this).hasClass('confirm')) {
						if (!confirm('确认要执行该操作吗?')) {
							return false;
						}
					}
					query = form.find('input,select,textarea').serialize();
				}
				$(that).addClass('disabled').attr('autocomplete', 'off').prop(
						'disabled', true);

				$.post(target, query).success(
						function(data) {

							if (data.status == 1) {
								if (data.url) {
									op_success(data.info + ' 页面即将自动跳转~');
								} else {
									op_success(data.info);
								}
								setTimeout(function() {
									if (data.url) {
										location.href = data.url;
									} else if ($(that).hasClass('no-refresh')) {
										$('#top-alert').find('button').click();
										$(that).removeClass('disabled').prop(
												'disabled', false);
									} else {
										location.reload();
									}
								}, 1500);
							} else {
								op_error(data.info);
								setTimeout(function() {
									if (data.url) {
										location.href = data.url;
									} else {
										$('#top-alert').find('button').click();
										$(that).removeClass('disabled').prop(
												'disabled', false);
									}
								}, 1500);
							}
						});
			}
			return false;
		});
