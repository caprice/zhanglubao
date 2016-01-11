var sync_callback;
var sync_total;
var sync_finish;
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
if (!get_cookie("nickname")) {
	setCookie("auth", "", -1);
	setCookie("auth_wl", "", -1);
	setCookie("uid", "", -1);
	setCookie("nickname", "", -1);
	setCookie("username", "", -1);
	setCookie("own_room", "", -1);
	setCookie("groupid", "", -1)
}
$SYS.uid = get_cookie("uid");
$SYS.username = get_cookie("username");
$SYS.nickname = get_cookie("nickname");
$SYS.own_room = get_cookie("own_room");
$SYS.groupid = get_cookie("groupid");
function sync_login(d, f) {
	if (!document.getElementById("sync_login")) {
		var a = document.createElement("div");
		a.id = "sync_login";
		a.style.display = "none";
		document.body.appendChild(a)
	}
	sync_callback = f;
	setTimeout(sync_callback, 2000);
	$("#sync_login").html(d);
	var e = $("#sync_login").children();
	sync_total = e.length;
	sync_finish = 0;
	for (var b = 0; b < e.length; b++) {
		e[b].onload = function() {
			sync_finish++;
			if (sync_finish === sync_total) {
				setTimeout(sync_callback, 1)
			}
		}
	}
}
function timetodate(f) {
	var e = new Date(f * 1000);
	var d = e.getHours();
	d = d < 10 ? "0" + d: d;
	var a = e.getMinutes();
	a = a < 10 ? "0" + a: a;
	var b = e.getSeconds();
	b = b < 10 ? "0" + b: b;
	return d + ":" + a + ":" + b
}
function is_email(a) {
	var b = /^([a-zA-Z0-9]+[_|_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|_|\.]?)*[a-zA-Z0-9\-]+\.[a-zA-Z]{2,4}$/;
	return b.test(a)
}
function close_open(a) {
	$.dialog.list.REG001.close();
	if (a) {
		window.location.reload()
	}
}
function open_reg() {
	user_dialog.open_reg();
	return false
}
var login_jump = "";
function open_login() {
	if (typeof(arguments[0]) !== "undefined") {
		login_jump = arguments[0]
	}
	user_dialog.open_login();
	return false
}
function check_message() {
	if ($SYS.uid) {
		window.location.href = "/member/message/release"
	} else {
		open_login("/member/message/release")
	}
	return false
}
var logout = function() {
	$.post("/member/logout/ajax",
	function(a) {
		var b = "";
		sync_login(a.sync_login_html + b, "window.location.reload();");
		try {
			thisMovie("WebRoom").js_userlogout()
		} catch(d) {}
		$.dialog.tips_black("退出成功！", 1.5)
	},
	"json")
};
function logout_submit() {
	$.dialog.confirm("确认退出吗？", logout)
}
function reg_success(a, b) {
	if ($.dialog.list.REG001) {
		$.dialog.list.REG001.close()
	}
	if (b !== "") {
		$.dialog({
			icon: "succeed",
			content: "注册成功，正在登录……请稍候!",
			lock: true
		});
		sync_login(b, "window.location.reload();")
	} else {
		window.location.reload()
	}
}
function search_submit() {
	var a = $("#search_word").val();
	a = $.trim(a);
	if (a === "") {
		alert_msg("搜索关键词还没有填写", "$('#search_word').focus();");
		return false
	}
	window.location.href = "/search/" + encodeURIComponent(a)
}
function alert_msg(f, b, a) {
	try {
		switch (a) {
		case 4:
		case "succeed":
			var g = "succeed";
			break;
		case 3:
			var g = "error";
			break;
		case 2:
			var g = "question";
			break;
		default:
			var g = "warning"
		}
		$.dialog({
			lock: true,
			content: f,
			icon: g,
			ok: function() {
				b && setTimeout(b, 100);
				return true
			}
		})
	} catch(d) {
		$.dialog.tips_black(f);
		b && setTimeout(b, 100)
	}
}
function confirm_msg(d, f, a) {
	try {
		$.dialog.confirm(d,
		function() {
			f && setTimeout(f, 100)
		},
		function() {
			a && setTimeout(a, 100)
		})
	} catch(b) {
		if (confirm(d)) {
			f && setTimeout(f, 100)
		} else {
			a && setTimeout(a, 100)
		}
	}
}
function getByteLen(d) {
	var a = d.length;
	if (d.match(/[^\x00-\xff]/ig) !== null) {
		var b = d.match(/[^\x00-\xff]/ig).length;
		a = a + b * 2
	}
	return a
}
function tbox_move() {
	var a = parseInt($(window).width() - 142);
	$("#tbox").css({
		left: a + "px"
	})
}
var bottom_tips = {
	pos: function(a, b) {
		c = $(".content").eq(0);
		l = c.offset().left;
		w = c.width();
		$("#tbox").css("left", (l + w + a) + "px");
		$("#tbox").css("bottom", b + "px")
	},
	move: function() {
		h = $(window).height() / 4;
		t = $(document).scrollTop();
		if (t > h) {
			$("#gotop").fadeIn("slow")
		} else {
			$("#gotop").fadeOut("slow")
		}
	},
	init: function() {
		$("body").append('<div id="tbox" style="left: 1461px; bottom: 10px;"><a id="gotop" href="javascript:void(0)"></a><a id="dj" href="/cms/zhibo/201407/07/281.shtml"  target="_blank"></a><a id="want" href="/cms/zhibo/list_16.shtml" target="_blank"></a><a id="jianyi"  href="javascript:void(0)" onclick="return check_message()"></a></div>');
		this.pos(10, 10);
		this.move();
		$("#gotop").click(function() {
			$(document).scrollTop(0);
			return false
		});
		$(window).resize(function() {
			bottom_tips.pos(10, 10)
		});
		$(window).scroll(function(a) {
			bottom_tips.move()
		})
	}
};
function number_format(g, d, j, f) {
	g = (g + "").replace(/[^0-9+\-Ee.]/g, "");
	var b = !isFinite( + g) ? 0 : +g,
	a = !isFinite( + d) ? 0 : Math.abs(d),
	m = (typeof f === "undefined") ? ",": f,
	e = (typeof j === "undefined") ? ".": j,
	k = "",
	i = function(q, p) {
		var o = Math.pow(10, p);
		return "" + (Math.round(q * o) / o).toFixed(p)
	};
	k = (a ? i(b, a) : "" + Math.round(b)).split(".");
	if (k[0].length > 3) {
		k[0] = k[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, m)
	}
	if ((k[1] || "").length < a) {
		k[1] = k[1] || "";
		k[1] += new Array(a - k[1].length + 1).join("0")
	}
	return k.join(e)
}
function get_avatar(a, b) {
	if (typeof($SYS.avatar_url) === "undefined") {
		return ""
	}
	if (!b) {
		b = "small"
	}
	return $SYS.avatar_url + "avatar.php?uid=" + a + "&size=" + b
}
var loading = {
	dialog: null,
	show: function(a) {
		if (!a) {
			a = "正在提交……"
		}
		if (loading.dialog) {
			loading.close()
		}
		loading.dialog = $.dialog({
			title: false,
			cancel: false,
			content: '<div class="infodrmation"><img src="' + $SYS.res_url + 'douyu/images/loading.gif" style="vertical-align: middle;" >&nbsp;' + a + "</div>"
		})
	},
	close: function() {
		if (loading.dialog) {
			loading.dialog.close()
		}
	}
};
var user_dialog = {
	_dialog: null,
	chg_tab: function(a) {
		$("#js_login_tab a").removeClass("current");
		$("#js_" + a).addClass("current");
		$("#js_login_dialog .inputBox").hide();
		$("#js_" + a + "_cont").show()
	},
	open_login: function() {
		this.chg_tab("login");
		if ($("#js_login_dialog").is(":hidden")) {
			this.show()
		}
		$("#login-form").find("input[name='username']").focus()
	},
	open_reg: function() {
		this.chg_tab("reg");
		if ($("#js_login_dialog").is(":hidden")) {
			this.show()
		}
		$("#reg_form").find("input[name='nickname']").focus()
	},
	show: function() {
		user_dialog._dialog = $.dialog({
			content: document.getElementById("js_login_dialog"),
			title: false,
			cancel: false,
			padding: 0,
			margin: 0,
			fixed: true,
			lock: true
		});
		return false
	},
	hide: function() {
		if (user_dialog._dialog) {
			user_dialog._dialog.close()
		}
		return false
	},
	logout: function() {
		$.dialog.confirm("确认退出吗？",
		function() {
			$.post("/member/logout/ajax",
			function(a) {
				try {
					thisMovie("WebRoom").js_userlogout()
				} catch(b) {}
				$.dialog.tips_black("退出成功！", 1.5);
				window.location.reload()
			},
			"json")
		})
	}
};
var user_form = {
	check: function(d) {
		var b = $(d);
		var e = b.val();
		e = $.trim(e);
		b.val(e);
		if (e == "") {
			inputError(b);
			return false
		}
		switch (b.attr("name")) {
		case "nickname":
		case "username":
			if (e == "") {
				this.error("用户账号不能为空", b);
				return false
			}
			if (e.indexOf("_") === 0) {
				this.error("用户账号不能以下划线开头", b);
				return false
			}
			var a = this.get_byte_len(e);
			if (a < 5 || a > 30 || e.length > 15) {
				this.error("用户账号长度只能5~10个字符", b);
				return false
			}
			break;
		case "password":
			if (e.length < 5 || e.length > 25) {
				this.error("密码长度不正确，仅限5~25个字符", b);
				return false
			}
			break;
		case "password2":
			if (b.parents("form").find("input[name='password']").val() != e) {
				this.error("两次密码输入不一致", b);
				return false
			}
			break;
		case "email":
			var f = /^([a-zA-Z0-9]+[_|_|.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|_|.]?)*[a-zA-Z0-9]+.[a-zA-Z]{2,4}$/;
			if (!f.test(e)) {
				this.error("邮箱地址格式不正确", b);
				return false
			}
			break;
		case "captcha_word":
			if (e.length != 4) {
				this.error("验证码不正确", b);
				return false
			}
			break
		}
		this.success(b);
		return true
	},
	error: function(b, a) {
		$.dialog.tips_black(b, 2);
		inputError(a)
	},
	success: function(a) {
		if (inputError.timer) {
			clearTimeout(inputError.timer)
		}
		a.removeClass("login-form-error")
	},
	get_byte_len: function(d) {
		var a = d.length;
		if (d.match(/[^\x00-\xff]/ig) != null) {
			var b = d.match(/[^\x00-\xff]/ig).length;
			a = a + b * 2
		}
		return a
	},
	update_vcode: function(b) {
		var a = $("#" + b).data("src") + "?_t=" + Math.random(1);
		$("#" + b).attr("src", a);
		$("#" + b + "_val").val("")
	}
};
var inputError = function(a) {
	clearTimeout(inputError.timer);
	var b = 0;
	var d = function() {
		inputError.timer = setTimeout(function() {
			if (!a.hasClass("login-form-error")) {
				a.addClass("login-form-error")
			}
			if (b >= 5) {} else {
				d(b++)
			}
		},
		300)
	};
	d()
};
var doing = 0;
function reg_ajaxSubmit() {
	if (doing == 1) {
		return false
	}
	var a = true;
	$("#reg_form input").each(function() {
		var b = $(this).attr("type");
		if (b != "submit" && b != "hidden" && user_form.check(this) == false) {
			a = false;
			return false
		}
	});
	if (!a) {
		return false
	}
	doing = 1;
	$("#js_reg_submit").val("提交中…");
	$.ajax({
		type: "POST",
		url: "/member/register/ajax",
		data: $("#reg_form").serialize(),
		dataType: "json",
		error: function(b, e, d) {
			$.dialog.tips_black("注册过程中发生错误，请稍候再试！")
		},
		success: function(b) {
			doing = 0;
			$("#js_reg_submit").val("注册");
			if (b.result == 0) {
				$("#culp a").trigger("click");
				$.dialog.tips_black("注册成功，正在登录…", 1.5);
				window.location.reload()
			} else {
				user_form.update_vcode("reg_captcha");
				$.dialog.tips_black("注册失败：" + b.error)
			}
		}
	})
}
function login_ajaxSubmit(a) {
	if (doing == 1) {
		return false
	}
	var b = true;
	$("#login-form input").each(function() {
		var d = $(this).attr("type");
		if (d != "submit" && d != "hidden" && user_form.check(this) == false) {
			b = false;
			return false
		}
	});
	if (!b) {
		return false
	}
	doing = 1;
	$("#js_login_submit").val("提交中…");
	$.post("/member/login/ajax", $("#login-form").serialize(),
	function(d) {
		doing = 0;
		$("#js_login_submit").val("登录");
		if (d.result == 0) {
			$("#culp a").trigger("click");
			if (a) {
				a()
			} else {
				$.dialog.tips_black("登录成功！", 1.5);
				if (typeof(login_jump) != "undefined" && login_jump) {
					window.location.href = login_jump
				} else {
					window.location.reload()
				}
			}
		} else {
			switch (d.result) {
			case - 1 : var e = "请把表单填写完整";
				break;
			case - 2 : var e = "请填写密码";
				break;
			case - 3 : var e = "密码错误";
				break;
			case - 5 : var e = "该用户未注册，请检查";
				break;
			case - 4 : if (d.ban_time == 0) {
					var e = "您的账户目前已经被永久封禁"
				} else {
					var e = "您的账户目前已经被封禁，有效期截止：" + d.ban_time
				}
				break;
			case - 99 : var e = "验证码错误";
				break;
			default:
				var e = d.result
			}
			user_form.update_vcode("login_captcha");
			$.dialog.tips_black(e)
		}
	},
	"json")
}
$(document).ready(function(b) {
	if (typeof(is_index) !== "undefined") {
		bottom_tips.init()
	}
	if ($SYS.uid) {
		$(".js_login_no").hide();
		$(".js_nickname").html($SYS.nickname);
		$(".js_avatar").attr("src", get_avatar($SYS.uid));
		$("#left_big_show").css({
			top: 185
		});
		if ($SYS.own_room === "1") {
			$(".js_member_url").attr("href", "/room/my");
			$(".js_login_room").show()
		} else {
			$(".js_login_member").show()
		}
		$(".js_login_yes").show();
		if ($SYS.groupid === "5") {
			$(".js_login_sa").show()
		}
	} else {
		$(".js_login_yes, .js_login_member, js_login_room, .js_login_sa").hide();
		var a = window.location.hash;
		if (a && a.substr(1) === "dy_tool_reg") {
			user_dialog.open_reg()
		}
	}
	$("#culp a").click(user_dialog.hide);
	$("#login_captcha, #reg_captcha").click(function() {
		user_form.update_vcode($(this).attr("id"))
	});
	$("#login_captcha_val, #reg_captcha_val").focus(function() {
		var d = $(this).next();
		if (d.attr("src").indexOf("captcha") == -1) {
			d.trigger("click")
		}
	});
	$("#js_login, #js_reg").click(function() {
		if ($(this).attr("id") == "js_login") {
			user_dialog.open_login()
		} else {
			user_dialog.open_reg()
		}
		return false
	});
	$("#reg_form input").each(function() {
		if ($(this).attr("type") != "submit") {
			$(this).blur(function() {
				if (user_form.check(this)) {
					var d = $(this).attr("name");
					var e = $(this);
					if (d == "nickname") {
						doing = 1;
						$.post("/member/register/validate/nickname", "data=" + encodeURIComponent(e.val()),
						function(f) {
							doing = 0;
							if (f.result == 0) {
								user_form.success(e)
							} else {
								if (f.result == -2) {
									user_form.error("用户账号含有敏感字符", e)
								} else {
									user_form.error("用户账号不合法或已被占用", e)
								}
							}
						},
						"json")
					} else {
						if (d == "email") {
							doing = 1;
							$.post("/member/register/check_email", "email=" + encodeURIComponent(e.val()),
							function(f) {
								doing = 0;
								if (f.result == 0) {
									user_form.success(e)
								} else {
									user_form.error("邮箱地址已被使用", e)
								}
							},
							"json")
						}
					}
				}
			})
		}
	});
	$("#login-form input").each(function() {
		if ($(this).attr("type") != "submit") {
			$(this).blur(function() {
				user_form.check(this)
			})
		}
	})
});