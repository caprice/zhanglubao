var clicknickuser;
var clickuid;
var sum_height = 383;
var min_y = 325;
var max_y = 580;
var touristuid = 0;
var sendtime = 0;
var interval = 3;
var saiduserlist = new Array();
var regintervalobj;
var sofa_info_arr = new Array();
var buglecursurposition = 0;
var cursurposition = 0;
var buglewidth = 0;
var buglesumwidth = 0;
var room_user_num = 0;
var send_interval_time = 1;
var intervaltime = 1;
var in_input = false;
var follow_stat = 0;
var sign_stat = 0;
var roomgrouplist = new Array();
var user_black_list = new Array();
var maxcontent = 50;
var rwbut_stat = 0;
var rwreturn_stat = 0;
if ($SYS.uid) {
	if ($SYS.uid == $ROOM.owner_uid) {
		roomgrouplist[$SYS.uid] = [];
		roomgrouplist[$SYS.uid]["roomgroup"] = 5
	} else {
		roomgrouplist[$SYS.uid] = [];
		roomgrouplist[$SYS.uid]["roomgroup"] = 1
	}
	$ROOM.room_url += "?fromuid=" + $SYS.uid
}
if (!$SYS.uid && !get_cookie("regpoint") && ($("#guide_login").length > 0)) {
	setCookie("regpoint", 1, 21600);
	setTimeout(
			'if(!$("#small_nav").is(":visible")){$("#guide_login,#back").show();}',
			10000)
}
function rwreturn_show() {
	if (rwreturn_stat == 0) {
		rwreturn_stat = 2;
		$.dialog.tips_black("任务列表加载失败，请手动点击任务按钮重新打开！", 3);
		$("#task_cont,#triangle_up,#taskmsg").hide()
	}
}
function rm_follow() {
	if (!$SYS.uid) {
		open_login();
		return false
	}
	$.dialog({
		content : "您是否取消关注？",
		icon : "question",
		okVal : "确定",
		ok : function() {
			$.get("/room/follow/cancel/" + $ROOM.room_id, function(d) {
				if (d == "ok") {
					$.dialog.tips_black("成功取消关注", 2);
					$(".follow_btn").hide();
					$(".follow_btn").eq(0).show();
					follow_stat = 0;
					var c = parseInt($("#followtit").html().replace(/,/g, ""));
					$("#followtit").html(number_format(c - 1));
					if ($("#leftfollow").length > 0) {
						$("#leftfollow").html(
								number_format(parseInt($("#leftfollow").html()
										.replace(/,/g, "")) - 1))
					}
				} else {
					if (d != "") {
						$.dialog.alert(d)
					} else {
						$.dialog.alert("发生错误，请重试")
					}
				}
			})
		},
		cancelVal : "取消",
		cancel : function() {
		}
	})
}
function follow_room() {
	if (!$SYS.uid) {
		open_login();
		return false
	}
	if ($SYS.uid == $ROOM.owner_uid) {
		$.dialog.tips_black("不能关注自己的房间", 2)
	}
	$.get("/room/follow/add/" + $ROOM.room_id, function(d) {
		if (d == "ok") {
			$(".follow_btn").hide();
			$(".follow_btn").eq(1).show();
			follow_stat = 1;
			var e;
			$.dialog({
				icon : "succeed",
				content : "成功加入您的关注列表",
				init : function() {
					var h = this, f = 3;
					var g = function() {
						h.title(f + "秒后关闭");
						!f && h.close();
						f--
					};
					e = setInterval(g, 1000);
					g()
				},
				close : function() {
					clearInterval(e)
				}
			}).show();
			var c = parseInt($("#followtit").html().replace(/,/g, ""));
			$("#followtit").html(number_format(c + 1));
			if ($("#leftfollow").length > 0) {
				$("#leftfollow").html(
						number_format(parseInt($("#leftfollow").html().replace(
								/,/g, "")) + 1))
			}
		} else {
			if (d != "") {
				$.dialog.alert(d)
			} else {
				$.dialog.alert("发生错误，请重试")
			}
		}
	})
}
var surplus_time_obj;
var is_barrage = true;
function display_barrage() {
	if (is_barrage) {
		$("#barrage_info").html("<span>开启弹幕</span>");
		is_barrage = false
	} else {
		$("#barrage_info").html("<span>关闭弹幕</span>");
		is_barrage = true
	}
	thisMovie("WebRoom").js_barrage(is_barrage)
}
function get_time_str(d) {
	var f = Math.floor(d / 3600);
	var c = Math.floor((d - f * 3600) / 60);
	var e = d - f * 3600 - c * 60;
	return f + "小时" + c + "分" + e + "秒"
}
function close_room_tips() {
	if ($SYS.uid == $ROOM.owner_uid) {
		var c = "您的房间已被关闭，详情请联系客服人员。"
	} else {
		var c = "您观看的房间已被关闭，请选择其他直播进行观看哦！"
	}
	$.dialog({
		title : "房间关闭提示",
		icon : "warning",
		content : '<p style="color:red">' + c + "</p>",
		init : function() {
			var f = this, d = 8;
			var e = function() {
				f.title(d + "秒后关闭");
				!d && f.close();
				d--
			};
			timer = setInterval(e, 1000);
			e()
		},
		ok : function() {
			this.close()
		},
		lock : true,
		close : function() {
			clearInterval(timer);
			window.location.href = $SYS.uid == $ROOM.owner_uid ? "/room/my"
					: "/"
		}
	})
}
function call_resize(d, c) {
	try {
		var f = d + "|" + c;
		thisMovie("WebRoom").js_sendsize(f)
	} catch (g) {
		setTimeout("call_resize(" + d + ", " + c + ")", 5000)
	}
}
function set_live_height() {
	var g = $(window).height() || $(document).height();
	var d = $(window).width() || $(document).width();
	if ($("#live_player").hasClass("alls")) {
		if ($("#left_col").length) {
			$("#main_col").height(g)
		}
		$("#live_player .swf_container").height(g);
		call_resize(d, g);
		return false
	}
	if ($("#left_col").length) {
		var e = function() {
			var j = $("#left_col");
			var k = $("#right_col");
			var h = d - (j.is(":hidden") ? 0 : j.width())
					- (k.is(":hidden") ? 0 : k.width());
			if (ie6) {
				j.css({
					height : g
				});
				k.css({
					height : g
				})
			}
			$("#chatdiv").height(g);
			$("#chat_lines").height(g - 117)
		}();
		var c = $("#live_player").width();
		var f = c / 1262 * 710;
		var i = 0;
		$("div.js_live_height").each(function() {
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
		$("#main_col").height(g);
		call_resize(c, f);
		set_room_title_width()
	} else {
		$("#live_player .swf_container").height($("#live_player").height());
		call_resize($("#live_player").width(), $("#live_player").height())
	}
}
function set_room_title_width() {
	var d = $("#room_title").width();
	$("#room_title > h1").width("auto");
	var c = $("#room_title > h1").width();
	if (d - c < 110) {
		$("#room_title > h1").width(d - 110)
	}
}
function set_window_width() {
	if ($("#live_player").hasClass("alls")) {
		return false
	}
	var c = $(window).width() || $(document).width();
	var d = $("#left_col");
	if (d.length === 0) {
		return false
	}
	var e = $("#right_col");
	var g = $("#large_nav");
	var f = $("#small_nav");
	var h = $("#main_col");
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
		setTimeout(left_scroll.update, 500)
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
function super_close_room() {
	$.dialog({
		id : "setcata",
		title : "关闭房间",
		content : document.getElementById("close_frm"),
		ok : function() {
			var c = $("#reason").val();
			if (c.length < 1) {
				$.dialog.tips_black("请输入关闭原因！");
				return false
			}
			$.dialog({
				content : "您确定此房间的要关闭直播吗",
				icon : "question",
				okVal : "确定",
				ok : function() {
					$.ajax({
						type : "POST",
						url : "/room/my_admin/super_close_room",
						data : $("#close_frm").serialize(),
						dataType : "json",
						success : function(d) {
							if (d.ret > 0) {
								$.dialog.tips_black(d.msg)
							} else {
								window.location.reload()
							}
						}
					})
				},
				cancelVal : "取消",
				cancel : function() {
				}
			})
		},
		cancelVal : "关闭",
		cancel : true
	})
}
function follow_change(c) {
	$(".follow_btn").hide();
	if (c == 1) {
		$(".follow_btn").eq(1).show();
		follow_stat = 1
	} else {
		$(".follow_btn").eq(0).show();
		follow_stat = 0
	}
}
function thisMovie(c) {
	if (navigator.appName.indexOf("Microsoft") != -1) {
		return window[c]
	} else {
		return document[c]
	}
}
function sendlog() {
	var d = "";
	var e = "";
	var c = check_user_login();
	if (c) {
		d = c.wl_username;
		e = c.wl_auth
	}
	var f = "type@=loginreq/username@=" + d + "/password@=" + e + "/roomid@="
			+ $ROOM.room_id + "/";
	thisMovie("WebRoom").js_userlogin(f)
}
function delCookie(d) {
	var c = new Date();
	c.setTime(c.getTime() - 10000);
	document.cookie = $SYS.cookie_pre + d + "=a; expires=" + c.toGMTString()
}
function server_error(e) {
	var c = Sttdecode(e);
	var d = c[1]["value"];
	var f = "";
	switch (d) {
	case "51":
		f = "数据传输出错!";
		break;
	case "52":
		f = "服务器关闭!";
		close_room_tips();
		break;
	case "53":
		f = "服务器繁忙!";
		break;
	case "54":
		f = "服务器维护中!";
		break;
	case "55":
		f = "用户满员!";
		break;
	case "56":
		f = "IP封禁!";
		window.location.reload();
		return;
	case "57":
		f = "帐号封禁!";
		window.location.reload();
		return;
	case "58":
		f = "用户名密码错误!";
		break;
	case "59":
		$.dialog.tips_black("您的账号已在其他地方登录，请注意账号安全！!");
		break;
	case "60":
		$.dialog.tips_black("聊天信息包含敏感词语！");
		break;
	case "252":
		$.dialog.tips_black("网络异常");
		break;
	case "203":
		$.dialog.tips_black("您的登录已过期请重新登录！");
		setTimeout(
				'if($("#js_login_dialog").is(":hidden")){user_dialog.open_reg()}',
				3500);
		break;
	default:
		return
	}
}
function tourist_login() {
	var c = check_user_login();
	if (!c) {
		setTimeout("user_dialog.open_reg()", 25000);
		regintervalobj = setInterval("check_tourist()", 120000)
	}
}
function check_tourist() {
	var c = check_user_login();
	if (!c) {
		user_dialog.open_reg()
	} else {
		clearInterval(regintervalobj)
	}
}
function return_tourist(e) {
	var d = Sttdecode(e);
	touristuid = d[0]["value"];
	sign_stat = d[2]["value"];
	var c = check_user_login();
	if (c) {
		setCookie("groupid", d[5]["value"], 2592000);
		$SYS.groupid = d[5]["value"];
		task_obj.get_task_stat();
		if (d[3]["value"] >= 3 && d[2]["value"] == 0) {
			$("#follow_sign").remove()
		}
		if (d[2]["value"] == 0) {
			$("#follow_sign,#signbut").show()
		} else {
			$("#follow_sign,#signbut2").show()
		}
		if ($SYS.uid == $ROOM.owner_uid) {
			$("#follow_sign").hide()
		}
	} else {
		$("#follow_sign").remove()
	}
	if (user_black_str != "") {
		black_obj.black_myblacklis_send(user_black_str)
	}
	roomgrouplist[d[0]["value"]] = new Array();
	roomgrouplist[d[0]["value"]]["roomgroup"] = d[4]["value"]
}
function get_show_status(d) {
	var c = 0;
	$.ajax({
		type : "POST",
		url : "tool/show_status/" + d,
		data : "",
		success : function(e) {
			c = e;
			if ($ROOM.show_status == 0 && c == 1) {
				$.dialog({
					content : "直播开始了！",
					icon : "information",
					okVal : "刷新页面",
					ok : function() {
						window.location.reload()
					},
					cancelVal : "确定",
					cancel : function() {
					}
				})
			}
		}
	})
}
var showintervalobj;
var task_show = 0;
function task_hide() {
	if (!task_show) {
		$("#triangle_up,#task_cont").hide()
	}
}
var signnum = 0;
var fxnum = 0;
var task_obj = {
	sign_send : function() {
		thisMovie("WebRoom").js_roomSignUp()
	},
	return_sign : function(d) {
		var c = Sttdecode(d);
		if (c[0]["value"] == 0) {
			$("#signbut").hide();
			$("#signbut2").show();
			sign_stat = 1;
			signnum++;
			if ($("#check_sign").attr("rel") != 1) {
				$(".js_task_psnum").html(
						parseInt($(".js_task_psnum").html()) + 1);
				$(".js_task_psnum").show()
			}
			$("#check_sign").addClass("get");
			$("#check_sign").html("领取");
			$("#sign_gold").html(
					"+" + (parseInt($("#check_sign").attr("goldnum")) + 50));
			$("#check_sign").attr("rel", 1)
		}
	},
	reward_send : function(d) {
		var c = [ {
			name : "type",
			value : "gftq"
		}, {
			name : "tid",
			value : d
		} ];
		var e = Sttencode(c);
		thisMovie("WebRoom").js_obtainTask(e)
	},
	return_reward : function(e) {
		var d = Sttdecode(e);
		if (d[0]["value"] == 0) {
			$("#ywtit").html(d[5]["value"]);
			switch (d[1]["value"]) {
			case "1":
				$("#t_email").remove();
				break;
			case "2":
				$("#t_pic").remove();
				break;
			case "3":
				if (fxnum >= 100) {
					$("#t_share").remove()
				} else {
					$("#check_share").removeClass("get");
					$("#check_share").html("分享");
					$("#share_gold").html("（" + fxnum + "/100）");
					$("#check_share").attr("rel", "")
				}
				break;
			case "4":
				$("#check_sign").removeClass("get");
				if (signnum >= 3) {
					$("#t_sign").remove()
				} else {
					$("#check_sign").html("去签到");
					$("#sign_gold").html("（" + signnum + "/3）");
					$("#check_sign").attr("rel", 2);
					$("#check_sign").attr("goldnum", 0)
				}
				break
			}
			$("#taskul").attr("rel", 0);
			$("#taskul").html(
					"<li><span><i>恭喜您，已成功领取" + d[3]["value"]
							+ "个鱼丸！</i></span></li>");
			$("#taskmsg").show();
			$("#taskmsg").css({
				bottom : "42px"
			});
			$("#taskmsg").animate({
				bottom : "110px"
			}, 1000, function() {
				setTimeout(function() {
					$("#taskmsg").fadeOut()
				}, 5000)
			});
			var c = parseInt($(".js_task_psnum").html()) - 1;
			$(".js_task_psnum").html(c);
			if (c < 1) {
				$(".js_task_psnum").hide()
			}
			if ($("#t_email").length <= 0 && $("#t_pic").length <= 0
					&& $("#t_share").length <= 0
					&& $("#check_sign").length <= 0) {
				$("#task_cont,#triangle_up").hide();
				$("#rwbut,#rwshow").remove()
			}
		}
	},
	get_task_stat : function() {
		thisMovie("WebRoom").js_queryTask()
	},
	return_task_list : function(g) {
		if (rwreturn_stat == 2) {
			return false
		}
		var h = Sttdecode(g);
		rwreturn_stat = 1;
		var k = h[0]["value"];
		k = k.replace(new RegExp("@A", "g"), "@");
		task_list = Sttdecode(k);
		$("#task_cont").find("a").removeClass("get");
		var l = 0;
		var j = 0;
		for ( var m = 0; m <= 3; m++) {
			var f = task_list[m * 6]["value"];
			var d = task_list[m * 6 + 1]["value"];
			var c = task_list[m * 6 + 2]["value"];
			var i = task_list[m * 6 + 3]["value"];
			var e = task_list[m * 6 + 4]["value"];
			if (c > 0) {
				l = l + 1
			}
			if (f == 1) {
				if (d == 1 && c == 0) {
					$("#t_email").remove();
					continue
				}
				j = 1;
				if (d == 1 && c == 1) {
					$("#check_email").addClass("get");
					$("#check_email").html("领取");
					$("#email_gold").html("+300");
					$("#check_email").attr("rel", 1)
				}
				if (d == 0) {
					$("#email_gold").html("（0/1）")
				}
			}
			if (f == 2) {
				if (d == 1 && c == 0) {
					$("#t_pic").remove();
					continue
				}
				j = 1;
				if (d == 1 && c == 1) {
					$("#check_pic").addClass("get");
					$("#check_pic").html("领取");
					$("#pic_gold").html("+100");
					$("#check_pic").attr("rel", 1)
				}
				if (d == 0) {
					$("#pic_gold").html("（0/1）")
				}
			}
			if (f == 3) {
				fxnum = d;
				if (d >= 100 && c == 0) {
					$("#t_share").remove();
					continue
				}
				j = 1;
				if (c > 0) {
					$("#check_share").addClass("get");
					$("#check_share").html("领取");
					$("#share_gold").html("+" + c * 10);
					$("#check_share").attr("rel", 1)
				} else {
					$("#check_share").html("分享");
					$("#share_gold").html("（" + d + "/100）");
					$("#check_share").attr("rel", "")
				}
			}
			if (f == 4) {
				signnum = d;
				if (d == 3 && c == 0) {
					$("#t_sign").remove();
					continue
				}
				j = 1;
				if (d > 0 && c > 0) {
					$("#check_sign").addClass("get");
					$("#check_sign").html("领取");
					$("#sign_gold").html("+" + c * 50);
					$("#check_sign").attr("rel", 1)
				}
				if (d < 3 && c == 0) {
					$("#check_sign").html("去签到");
					$("#sign_gold").html("（" + d + "/3）");
					$("#check_sign").attr("rel", 2)
				}
				$("#check_sign").attr("goldnum", parseInt(c) * 50)
			}
		}
		if (!j) {
			$("#rwbut,#rwshow").remove();
			return false
		}
		$(".js_task_psnum").hide();
		$(".js_task_psnum").html(l);
		if (l > 0) {
			$(".js_task_psnum").show()
		}
		if (rwbut_stat) {
			$("#triangle_up,#task_cont,#task_ul").show();
			$("#taskload").hide()
		}
	}
};
var black_obj = {
	black_show : function() {
		var c = !$SYS.uid ? touristuid : $SYS.uid;
		if ((roomgrouplist[c]["roomgroup"] < 4 && $SYS.groupid != 5)
				|| c == clickuid) {
			return false
		}
		$.dialog({
			title : "用户屏蔽",
			content : document.getElementById("blackshow"),
			id : "black900l",
			ok : function() {
				return black_obj.black_user_send("black_send")
			},
			cancelVal : "关闭",
			cancel : true
		});
		$("#blacktime").focus();
		return false
	},
	black_user_send : function(g) {
		var d = check_user_login();
		if (!d) {
			user_dialog.open_reg();
			return false
		}
		var f = 0;
		if (g == "black_send") {
			f = $("#blacktime").val();
			if (isNaN(f) || f <= 0) {
				$.dialog.tips_black("请重新输入!");
				return false
			}
			if (f > 10000) {
				$.dialog.tips_black("不能大于10000小时!");
				return false
			}
			var e = $('input[name="range"]:checked').val();
			var c = $('input[name="blacktype"]:checked').val();
			if (e == 2) {
				c = c == 2 ? 4 : 1;
				f = f > 72 ? 72 : f
			}
			f = f * 3600
		} else {
		}
		var h = [ {
			name : "type",
			value : "blackreq"
		}, {
			name : "userid",
			value : clickuid
		}, {
			name : "blacktype",
			value : c
		}, {
			name : "limittime",
			value : f
		} ];
		var i = Sttencode(h);
		$("#blacktime").val("0.1");
		thisMovie("WebRoom").js_blackuser(i)
	},
	black_myblacklis_add : function() {
		if (jQuery.inArray(parseInt(clickuid), user_black_list) > -1
				|| user_black_list.length >= 10) {
			return false
		}
		$.ajax({
			type : "POST",
			url : "/room/show/add_myblacklis/",
			data : "black_uid=" + clickuid + "&show_id=" + $ROOM.show_id,
			dataType : "json",
			success : function(c) {
				if (c.ret > 0) {
					$.dialog.tips_black(c.str)
				} else {
					$("#user_black").html("取消屏蔽");
					$("#user_black").attr("rel", 1);
					user_black_list.push(parseInt(clickuid));
					black_obj.black_myblacklis_send(user_black_list.join("|"))
				}
			}
		})
	},
	black_myblacklis_del : function() {
		if (jQuery.inArray(parseInt(clickuid), user_black_list) == -1) {
			return false
		}
		$
				.ajax({
					type : "POST",
					url : "/room/show/del_myblacklis/",
					data : "black_uid=" + clickuid + "&show_id="
							+ $ROOM.show_id,
					dataType : "json",
					success : function(c) {
						if (c.ret > 0) {
							$.dialog.tips_black(c.str)
						} else {
							$("#user_black").html("屏蔽该用户");
							$("#user_black").attr("rel", 0);
							var d = jQuery.inArray(parseInt(clickuid),
									user_black_list);
							user_black_list.splice(d, 1);
							black_obj.black_myblacklis_send(user_black_list
									.join("|"))
						}
					}
				})
	},
	black_myblacklis_send : function(c) {
		thisMovie("WebRoom").js_myblacklist(c)
	}
};
function weight_conversion(c) {
	if (c < 1000) {
		return c + "g"
	} else {
		if (c < 1000000) {
			return (c / 1000) + "kg"
		} else {
			return (Math.round(c / 10000) / 100) + "t"
		}
	}
}
function get_leve_info(c) {
	return_arr = new Array();
	$.each(room_args.leve_json, function(d, e) {
		e.score = parseInt(d);
		return_arr.next = e;
		if (c < parseInt(d)) {
			return false
		}
		return_arr.current = e
	});
	return return_arr
}
var gift_switch = 1;
var ywzy = 0;
var gift_obj = {
	retutn_gift : function(g) {
		var h = Sttdecode(g);
		var n = check_user_login();
		var c = Sttdecode(h[5]["value"]);
		if (c[0]["value"] == n.wl_uid) {
			gift_switch = 1
		}
		if (h[0]["value"] == 283 && (c[0]["value"] == n.wl_uid)) {
			if (ywzy == 0 && ($("#rwshow").length > 0)) {
				$("#rwshow,#back").show();
				$("#back").height($("#main_col").outerHeight(true));
				var m = $("#rwbut").offset();
				$("#rwshow").offset({
					top : m.top - 255,
					left : m.left - 6
				});
				$(window).resize(function() {
					var o = $("#rwbut").offset();
					$("#rwshow").offset({
						top : o.top - 255,
						left : o.left - 6
					});
					$("#back").height($("#main_col").outerHeight(true))
				});
				ywzy = 1
			} else {
				var d = document.createElement("p");
				$(d).html("鱼丸不足！");
				$("#ywbztit").append(d);
				setTimeout('$("#ywbztit").find("p").eq(0).remove()', 1000);
				ywzy++;
				if (ywzy >= 10) {
					ywzy = 0
				}
			}
			return false
		}
		if (h[0]["value"] == 0) {
			if (roomgrouplist[c[0]["value"]] == undefined) {
				roomgrouplist[c[0]["value"]] = new Array()
			}
			roomgrouplist[c[0]["value"]]["roomgroup"] = c[3]["value"];
			if (c[0]["value"] == n.wl_uid) {
				var d = document.createElement("p");
				$(d).html("战斗力+1！");
				$("#ywbztit").append(d);
				setTimeout('$("#ywbztit").find("p").eq(0).remove()', 1000);
				ywzy++;
				if (room_args.rpc_switch && typeof (h[6]) != "undefined"
						&& h[6]["value"] != "") {
					var f = get_leve_info(parseInt(h[6]["value"]));
					$("#leftlever")
							.html(return_img("classtype", f.current.pic));
					var j = parseInt(h[6]["value"] / 100);
					if (typeof (f.next) != "undefined") {
						var i = (f.next.score - h[6]["value"]) / 100;
						var k = '<div class="arrow"></div>还差<i>' + i
								+ "</i>个战斗力可以升为<i>[" + f.next.name
								+ "]</i><br />";
						$("#leverline").css(
								"width",
								parseInt((h[6]["value"] - f.current.score)
										/ (f.next.score - f.current.score)
										* 100)
										+ "%");
						$("#leverscore").html(
								j + "/" + parseInt(f.next.score / 100))
					} else {
						var k = '<div class="arrow"></div>哇靠，已经是<i>【最强王者】</i>了~^~';
						$("#leverline").css("width", "100%");
						$("#leverscore").html(j + "/" + j)
					}
					$("#bartit").html(k)
				}
			}
			if (room_args.rpc_switch && typeof (h[7]) != "undefined"
					&& h[7]["value"] != "") {
				$("#weighttit")
						.html(weight_conversion(parseInt(h[7]["value"])))
			}
			if (!$("#blackgift").is(":checked")) {
				var e = add_ttlist("chat_line_list");
				if (h[2]["value"] < 10 && (c[0]["value"] != n.wl_uid)) {
					return false
				}
				var l = '<a href="#" class="nick js_nick" rel=' + c[0]["value"]
						+ " >" + c[2]["value"] + "</a>赠送给主播<i>" + h[2]["value"]
						+ "</i>个鱼丸";
				l += return_img("coin", "yw.png");
				$(e).html(l);
				if ($("#commonscroll").attr("rel") == "scroll-on") {
					scrdown("chat_lines")
				}
			}
			var n = check_user_login();
			if (c[0]["value"] == n.wl_uid) {
				$("#ywtit").html(h[4]["value"])
			}
		}
	},
	send_gift : function() {
		if (!check_login()) {
			return false
		}
		if (gift_switch == 1) {
			var c = $("#giftnum").val();
			c = 100;
			var d = /^([1-9]\d*)$/;
			if (!d.test(c)) {
				$.dialog.tips_black("请输入整数");
				return false
			}
			var e = [ {
				name : "type",
				value : "donatereq"
			}, {
				name : "ms",
				value : c
			} ];
			var f = Sttencode(e);
			thisMovie("WebRoom").js_givePresent(f);
			gift_switch = 0
		}
	}
};
var tip_num = 0;
function tip_show(c) {
	if (tip_num <= 5) {
		if ($("#" + c).is(":hidden")) {
			$("#" + c).show()
		} else {
			$("#" + c).hide()
		}
		tip_num++;
		setTimeout('tip_show("' + c + '")', 500)
	} else {
		tip_num = 0;
		$("#" + c).hide()
	}
}
function htmlswitch(c) {
	if ($("#" + c).is(":hidden")) {
		$("#" + c).show()
	} else {
		$("#" + c).hide()
	}
}
function check_login() {
	var c = check_user_login();
	if (!c) {
		user_dialog.open_login();
		return false
	}
	return true
}
function check_user_login() {
	var c = new Array();
	c.wl_uid = $SYS.uid;
	c.wl_username = $SYS.username;
	c.wl_auth = get_cookie("auth_wl");
	if (!c.wl_username && !c.wl_auth) {
		return false
	} else {
		return c
	}
}
function return_img(e, d) {
	var c = "";
	switch (e) {
	case "coin":
		c = "<img  src=" + $SYS.res_url + "douyu/images/" + d + "  />";
		break;
	case "classtype":
		c = "<img  src=" + $SYS.res_url + "douyu/images/classimg/" + d + "  />";
		break;
	case "roomadmin":
		c = "<img  src=" + $SYS.res_url + "douyu/images/" + d
				+ ".gif?20140704  />";
		break;
	case "anchorimg":
		c = "<img  src=" + $SYS.res_url + "douyu/images/" + d
				+ ".gif?20140704  />";
		break;
	case "superadmin":
		c = "<img  src=" + $SYS.res_url
				+ "douyu/images/super_admin.gif?20140704  />";
		break
	}
	return c
}
function html_encode(d) {
	var c = "";
	if (d.length == 0) {
		return ""
	}
	c = d.replace(/&/g, "&amp;");
	c = c.replace(/</g, "&lt;");
	c = c.replace(/>/g, "&gt;");
	c = c.replace(/ /g, "&nbsp;");
	c = c.replace(/\'/g, "&#39;");
	c = c.replace(/\"/g, "&quot;");
	c = c.replace(/\s/g, " ");
	return c
}
function scrdown(c) {
	if ($("#chat_lines").data("hover") == 1) {
		return false
	}
	document.getElementById(c).scrollTop = document.getElementById(c).scrollHeight
}
function ctrlclear(c) {
	$("#" + c).find(".chartli").remove()
}
function facereplace(g) {
	var f = new Array("good", "kiss", "drop", "fil", "grief", "badluck",
			"indecent", "kiss", "laugh", "lovely", "rage", "scare", "sleep",
			"trick", "awesome", "snicker", "doubt", "guise", "sorry",
			"nosebleed", "moving", "grimace", "laughing", "revel", "excited",
			"dizzy", "bye", "up");
	var d = f.length;
	for (a = 0; a < d; a++) {
		var e = "\\[emot:" + f[a] + "\\]";
		var c = '<img rel="' + f[a] + '" src="' + $SYS.res_url + "images/face/"
				+ f[a] + '.gif" />';
		g = g.replace(new RegExp(e, "g"), c)
	}
	return g
}
function getValue(c, g, f) {
	var e = document.getElementById(c);
	var d = f == 1 ? cursurposition : buglecursurposition;
	e.value = e.value.substring(0, d) + g + e.value.substring(d);
	e.focus()
}
function getTxt1CursorPosition(d, e) {
	var f = document.getElementById(d);
	if (!document.selection) {
		if (e == 1) {
			cursurposition = f.selectionStart
		} else {
			buglecursurposition = f.selectionStart
		}
	} else {
		var c = document.selection.createRange();
		c.moveStart("character", -f.value.length);
		if (e == 1) {
			cursurposition = c.text.length
		} else {
			buglecursurposition = c.text.length
		}
	}
}
function proptitle_show(c) {
	$("#proptitle").html(c);
	$("#proptitle").show()
}
function htmldecode(f) {
	var d = "";
	var e = new Array();
	f = f.substr(0, f.length - 3);
	var c = f.split("/@/");
	$.each(c, function(j, k) {
		var i = k.split("/");
		var n = "";
		var g = "";
		var h = "";
		var m = "";
		var l = "";
		$.each(i, function(p, q) {
			var o = q.split("@=");
			switch (o[0]) {
			case "type":
				n = o[1];
				break;
			case "str":
				h = o[1];
				break;
			case "imgtype":
				m = o[1];
				break;
			case "src":
				l = o[1];
				break;
			default:
				g += " " + o[0] + '="' + o[1] + '"'
			}
		});
		if (m) {
			switch (m) {
			case "classtype":
				l = $SYS.res_url + "images/classimg/" + l + ".gif";
				break
			}
		}
		if (n == "str") {
			d += h
		} else {
			d += "<" + n + " " + g;
			if (l) {
				d += " src=" + l
			}
			d += ">";
			d += h
		}
		d += n != "img" && n != "str" ? "</" + n + ">" : "";
		d += " "
	});
	return d
}
function htmlshow(f) {
	var e = f.split("||");
	var d = e[0].split("@=")[1];
	switch (d) {
	case "public":
		var c = add_ttlist("chat_line_list");
		break
	}
	var g = e[1].split("/@/").length > 1 ? htmldecode(e[1]) : e[1];
	c.html(g)
}
function dialog_pay() {
	$.dialog({
		content : "账户鱼丸不足",
		icon : "warning",
		okVal : "去充值",
		ok : function() {
			window.open("/shop/pay")
		},
		cancelVal : "确定",
		cancel : function() {
		}
	})
}
function popUp(d, c) {
	$("#itemopen").show();
	$("#itemopen").css("top", c);
	$("#itemopen").css("left", d)
}
function menu_show(d) {
	var c = !$SYS.uid ? touristuid : $SYS.uid;
	clickuid = $(d).attr("rel");
	clicknickuser = $(d).html();
	if ((roomgrouplist[c]["roomgroup"] >= 4 && roomgrouplist[clickuid]["roomgroup"] < 4)
			|| (roomgrouplist[clickuid]["roomgroup"] < 4 && $SYS.groupid == 5)) {
		$("#black_img").show()
	} else {
		$("#black_img").hide()
	}
	if (roomgrouplist[clickuid]["pg"] == 5) {
		$("#black_img").hide()
	}
	$("#adminsetup").hide();
	if (roomgrouplist[c]["roomgroup"] == 5
			|| ($SYS.groupid == 5 && roomgrouplist[clickuid]["roomgroup"] < 5)) {
		$("#adminsetup").show();
		if (roomgrouplist[clickuid]["roomgroup"] == 4) {
			$("#adminsetup").html("解除管理员");
			$("#adminsetup").attr("rel", 1)
		} else {
			$("#adminsetup").html("任命管理员");
			$("#adminsetup").attr("rel", 4)
		}
	}
	if (jQuery.inArray(parseInt(clickuid), user_black_list) > -1) {
		$("#user_black").html("取消屏蔽");
		$("#user_black").attr("rel", 1)
	} else {
		if (user_black_list.length >= 10) {
			$("#user_black").html("屏蔽人数已满");
			$("#user_black").attr("rel", 3)
		} else {
			$("#user_black").html("屏蔽该用户");
			$("#user_black").attr("rel", 0)
		}
	}
}
function adminreg() {
	var c = [ {
		name : "type",
		value : "setadminreq"
	}, {
		name : "userid",
		value : clickuid
	}, {
		name : "group",
		value : $("#adminsetup").attr("rel")
	} ];
	var d = Sttencode(c);
	thisMovie("WebRoom").js_setadmin(d)
}
function return_setadmin(f) {
	var c = Sttdecode(f);
	var e = "";
	if (c[0]["value"] == 0) {
		e += ' <a class="js_nick"  rel=' + c[1]["value"]
				+ ' style="color:#FF0000" >' + c[4]["value"] + "</a>";
		e += c[2]["value"] > 1 ? '<span style="color:#FF0000">被任命管理员身份。</span>'
				: '<span style="color:#FF0000">被罢免管理员身份。</span>';
		if (roomgrouplist[c[1]["value"]] == undefined) {
			roomgrouplist[c[1]["value"]] = new Array()
		}
		roomgrouplist[c[1]["value"]]["roomgroup"] = c[2]["value"]
	} else {
		if (c[0]["value"] == 214) {
			e = '<span style="color:#FF0000">管理员数量以达上限。</span>'
		}
	}
	del_ttlist(100);
	var d = add_ttlist("chat_line_list");
	d.html(e);
	if ($("#commonscroll").attr("rel") == "scroll-on") {
		scrdown("chat_lines")
	}
}
function open_black() {
	$("#blacknick").html(clicknickuser);
	$.dialog({
		title : "用户屏蔽",
		content : document.getElementById("blackshow"),
		icon : "warning",
		id : "black900l",
		ok : function() {
			return black_user_send("black_send")
		},
		cancelVal : "关闭",
		cancel : true
	});
	$("#blacktime").focus();
	return false
}
function black_user_send(f) {
	if (!check_user_login()) {
		return false
	}
	var e = 0;
	if (f == "black_send") {
		e = $("#blacktime").val();
		if (isNaN(e) || e <= 0) {
			$.dialog.tips_black("请重新输入!");
			return false
		}
		var d = $('input[name="range"]:checked').val();
		var c = $('input[name="blacktype"]:checked').val();
		if (d == 2) {
			c = c == 2 ? 4 : 1;
			e = e > 72 ? 72 : e
		} else {
			if (roomgrouplist[clickuid]["roomgroup"] == 0) {
				return false
			}
		}
		e = e * 3600
	} else {
		var c = roomgrouplist[clickuid]["blackgroup"]
	}
	var g = [ {
		name : "type",
		value : "blackreq"
	}, {
		name : "userid",
		value : clickuid
	}, {
		name : "blacktype",
		value : c
	}, {
		name : "limittime",
		value : e
	} ];
	var h = Sttencode(g);
	$("#blacktime").val("");
	thisMovie("WebRoom").js_blackuser(h)
}
function saidhim() {
	var d = $SYS.uid;
	if (clickuid == d) {
		return false
	}
	if (jQuery.inArray(clickuid, saiduserlist) < 0
			&& roomgrouplist[clickuid]["roomgroup"] != 5) {
		if (saiduserlist.length == 10) {
			$("a[name='userchoice']").eq(2).remove();
			saiduserlist.splice(0, 1)
		}
		var c = jQuery("<li></li>");
		$("#userul").append(c);
		c.html('<a name="userchoice" rel="' + clickuid + '">' + clicknickuser
				+ "</a>");
		saiduserlist.push(clickuid)
	}
	$("#selectdel").show();
	$("#selectsb").html(clicknickuser);
	$("#privateuid").val(clickuid)
}
function privatecheck() {
	var c = check_user_login();
	if (c.wl_uid == clickuid) {
		return false
	}
	$("#privateuid").val(clickuid);
	$("#privatstate").val("private");
	$("#selectsb").html(clicknickuser);
	$("#selectdel").show();
	$("#in_check").removeClass("switch-off");
	$("#in_check").addClass("switch-on")
}
function broadcast_show(g) {
	var d = Sttdecode(g);
	var c = d[3]["value"];
	c = c.replace(new RegExp("@s", "g"), "/");
	c = c.replace(new RegExp("@a", "g"), "@");
	var f = d[4]["value"];
	f = f.replace(new RegExp("@s", "g"), "/");
	f = f.replace(new RegExp("@a", "g"), "@");
	var e = "";
	e += f ? '<a href="' + f + '"  target="_blank" >' + c + "</a>" : c;
	$("#broadcast_show").html(e);
	$("#broadcast_div").show()
}
function giveuser() {
	$("#givename").val(clicknickuser);
	$("#giveuid").val(clickuid)
}
function returnprop(K) {
	var H = Sttdecode(K);
	var k = H[1]["value"];
	switch (k) {
	case "281":
		$.dialog.tips_black("对方用户未找到");
		return false;
		break;
	case "282":
		$.dialog.tips_black("物品未找到");
		return false;
		break;
	case "283":
		dialog_pay();
		return false;
		break;
	case "284":
		$.dialog.tips_black("执行失败");
		return false;
		break
	}
	var N = H[2]["value"];
	var P = propname_list[N]["name"];
	var F = propname_list[N]["type"];
	var s = icon_list[N];
	del_ttlist(100);
	var f = add_ttlist("chat_line_list");
	var n = H[11]["value"];
	var L = n == 5 ? return_img("anchorimg", "anchor") + " " : "";
	var G = H[12]["value"];
	var E = H[7]["value"];
	var A = H[3]["value"];
	var p = H[4]["value"];
	var o = H[5]["value"];
	var M = H[6]["value"];
	L += return_img("classtype", G) + " ";
	L += n > 1 && n < 5 ? return_img("roomadmin", "roomadmin") + " " : "";
	var d = L + '<a class="js_nick" href="#" rel="' + A + '" >' + p
			+ '</a><a>:</a> 向 <a class="js_nick" href="#" rel="' + o + '" >'
			+ M + "</a> 送 [" + F + "]";
	var r = E > 150 ? 150 : E;
	for ( var O = 0; O < r; O++) {
		d += ' <img width="28" height="28" src=' + $SYS.res_url
				+ "images/item/" + s + " />"
	}
	d += P;
	d += E > 1 ? ", 共" + E + "个" : ", 共" + H[8]["value"] + "个";
	f.innerHTML = d;
	scrdown("chat_lines");
	if ($("#prop_check").attr("rel") == "prop_off") {
		return false
	}
	var F = 0;
	var J = fun_list[N];
	if (J !== "") {
		F = 2
	}
	switch (E) {
	case "50":
		F = 1;
		break;
	case "99":
		F = 1;
		break;
	case "100":
		F = 1;
		break;
	case "300":
		F = 1;
		break;
	case "520":
		F = 1;
		break;
	case "999":
		F = 1;
		break;
	case "1314":
		F = 1;
		break;
	case "3344":
		F = 1;
		break
	}
	var q = Date.parse(new Date()) / 1000;
	var Q = $SYS.uid;
	if (F > 0) {
		var x = H[4]["value"] + "向" + H[6]["value"] + "送" + P + "共" + E + "个";
		var z = document.createElement("div");
		var u = "flash" + Q + q;
		var D = "flashdiv" + Q + q;
		$(z).attr("id", D);
		$("#flashtt").append(z);
		var h = document.createElement("div");
		var j = "flashin" + Q + q;
		$(h).attr("id", j);
		$(z).append(h);
		var c = F == 1 ? 1000 : prop_json[N]["width"];
		var g = F == 1 ? 720 : prop_json[N]["height"];
		var y = $SYS.res_url + "simplayer/";
		y += F == 1 ? "flashprop1.swf" : "flashprop2.swf";
		y += "?v=" + $SYS.res_ver;
		var C = s.split(".");
		var v = C[0];
		$("#flashtt").addClass("flashtt");
		if (F == 1) {
			$(z).addClass("flashstyle")
		} else {
			$(z).addClass("flashstyle2")
		}
		var B = {};
		B.id = u;
		B.name = u;
		B.align = "middle";
		var e = {};
		e.flashstr = N + "@" + v + "@" + E + "@" + D + "@" + x;
		var t = {};
		t.quality = "high";
		t.bgcolor = "#ffffff";
		t.allowscriptaccess = "sameDomain";
		t.allowfullscreen = "false";
		t.wmode = "transparent";
		swfobject.embedSWF(y, j, c, g, swfVersionStr, xiSwfUrlStr, e, t, B);
		var I = J !== "" ? prop_json[N]["time"] : 20000;
		setTimeout("delprop('" + D + "')", I)
	} else {
		var l = E > 20 ? 20 : E;
		var i = document.createElement("div");
		$(i).addClass("basicprop");
		var m = "basicin" + Q + q;
		$(i).attr("id", m);
		$("#totalbasicprop").append(i);
		var w = "";
		for ( var O = 0; O < l; O++) {
			w += '<img width="42" height="42" src=' + $SYS.res_url
					+ "images/item/" + s + ' style="top:'
					+ Math.ceil(Math.random() * (550 - 45) + 45) + "px;left:"
					+ Math.ceil(Math.random() * 900) + 'px">'
		}
		$(i).html(w);
		setTimeout('$("#' + m + '").remove()', 5000)
	}
}
function delprop(c) {
	$("#" + c).remove();
	$("#flashtt").removeClass("flashtt")
}
function room_sofastates(f) {
	var i = Sttdecode(f);
	var h = "@A";
	var j = i[0]["value"].replace(new RegExp(h, "g"), "@");
	var c = new Array();
	c = j.split("//");
	for ( var d = 0; d < 5; d++) {
		var e = Sttdecode(c[d]);
		sofa_info_arr[d] = new Array();
		sofa_info_arr[d]["bid"] = parseInt(e[1]["value"]);
		sofa_info_arr[d]["uid"] = parseInt(e[2]["value"]);
		sofa_info_arr[d]["nick"] = e[3]["value"];
		if (e[2]["value"] > 0) {
			var g = d == 2 ? 48 : 36;
			$("[name='sofaimg']").eq(d).html(
					'<img src="' + get_avatar(e[2]["value"]) + '" width="' + g
							+ '" height="' + g + '">');
			$("[name='sofa_nick']").eq(d).html(e[3]["value"])
		} else {
			continue
		}
	}
}
function return_sofa(f) {
	var c = Sttdecode(f);
	if (parseInt(c[0]["value"]) == 283) {
		$.dialog.tips_black("鱼丸不足！");
		return false
	}
	del_ttlist(100);
	var d = add_ttlist("chat_line_list");
	var e = c[6]["value"] == 5 ? return_img("anchorimg", "anchor") + " " : "";
	e += return_img("classtype", c[5]["value"]) + " ";
	e += c[6]["value"] > 1 && c[6]["value"] < 5 ? return_img("roomadmin",
			"roomadmin") : "";
	var g = '<a style="color:#FF0000">恭喜</a>' + e
			+ '<a class="js_nick" href="#" rel=' + c[3]["value"] + " >"
			+ c[4]["value"] + "</a>";
	g += '<a style="color:#FF0000">以' + c[2]["value"] * 1000 + "金币的高价抢到了"
			+ (parseInt(c[1]["value"]) + 1) + "号沙发</a>";
	if (c[7]["value"] == 2) {
		g += '<a style="color:#FF0000">(</a><a class="js_nick" href="#" rel='
				+ c[8]["value"] + " >" + c[9]["value"]
				+ '</a><a style="color:#FF0000">被踢掉)</a>'
	}
	d.html(g);
	scrdown("chat_lines")
}
function sofaclosed() {
	$("#robberysofa").hide();
	$("#sofatitle").html("");
	$("#robberynum").val("");
	$("#sofanum").val("")
}
function chart_focus() {
	$("#chart_content").focus()
}
function get_interval_time(c) {
	if (c >= 3000) {
		return 480
	} else {
		if (c >= 2000) {
			return 240
		} else {
			if (c >= 1000) {
				return 60
			} else {
				if (c >= 501) {
					return 15
				} else {
					if (c >= 201) {
						return 8
					} else {
						return 3
					}
				}
			}
		}
	}
}
function get_send_length(c) {
	if (c <= 500) {
		return 50
	} else {
		if (c <= 1000) {
			return 40
		} else {
			if (c <= 2000) {
				return 30
			} else {
				return 20
			}
		}
	}
}
var lastcontent = "";
function sendmsg() {
	var f = Date.parse(new Date()) / 1000;
	if ((f - sendtime) <= send_interval_time) {
		return false
	}
	var g = $("#chart_content").val();
	if (g == "") {
		setTimeout("chart_focus()", 100);
		return false
	}
	var c = check_user_login();
	if (!c) {
		user_dialog.open_reg();
		return false
	}
	if (lastcontent == g) {
		$.dialog.tips_black("不能连续重复发送相同内容！");
		return false
	}
	var e = [ {
		name : "content",
		value : scan_str(g)
	}, {
		name : "scope",
		value : $("#privatstate").val()
	} ];
	lastcontent = g;
	var d = !c ? touristuid : c.wl_uid;
	e.push({
		name : "sender",
		value : d
	});
	if ($("#privateuid").val() > 0) {
		e.push({
			name : "receiver",
			value : $("#privateuid").val()
		})
	}
	var h = Sttencode(e);
	$("#chart_content").val("");
	thisMovie("WebRoom").js_sendmsg(h);
	sendtime = f;
	sendinterval();
	setTimeout("chart_focus()", 100)
}
var usercount = 0;
function room_usercount(d) {
	var c = parseInt(d);
	usercount = c;
	$("#ol_num").html(c)
}
var intervalobj;
function sendinterval() {
	if (send_interval_time > 0) {
		bttime()
	}
}
function bttime() {
	$("#sendmsg").addClass("dypicno");
	$("#sendmsg").attr("disbaled", true);
	$("#sendmsg").html(
			'<span style="color:#fff">&nbsp;&nbsp;' + intervaltime
					+ "&nbsp;&nbsp;</span>");
	if (intervaltime <= 0) {
		$("#sendmsg").removeClass("dypicno");
		$("#sendmsg").html("发送");
		$("#sendmsg").attr("disbaled", false);
		intervaltime = send_interval_time
	} else {
		intervaltime--;
		setTimeout("bttime()", 1000)
	}
}
function add_ttlist(d) {
	var c = document.createElement("li");
	$(c).addClass("chartli  ann_zs");
	c.innerHTML = ' <p class="text_cont"></p>';
	$("#" + d).append(c);
	return $(c).find("p")
}
function del_ttlist(d) {
	var c = $(".chartli").length;
	if (c >= d) {
		$(".chartli").eq(0).remove()
	}
}
function returnmsg(i) {
	var e = Sttdecode(i);
	if (e[1]["value"] > 0) {
		return false
	}
	if (($SYS.uid != $ROOM.owner_uid) && $SYS.groupid != 5) {
		document.getElementById("chart_content").maxLength = e[13]["value"];
		maxcontent = e[13]["value"]
	} else {
		maxcontent = 200
	}
	if (jQuery.inArray(parseInt(e[3]["value"]), user_black_list) != -1) {
		return false
	}
	var d = check_user_login();
	var g = !d ? touristuid : d.wl_uid;
	var c = document.createElement("li");
	$(c).addClass("chartli");
	if (e[3]["value"] == g) {
		$(c).addClass("myself clearfix")
	}
	var f = '<p class="tht_h"><span>';
	if (e[11]["value"] == 5) {
		f += return_img("superadmin", "") + "</span> "
	} else {
		switch (e[10]["value"]) {
		case "4":
			f += return_img("roomadmin", "roomadmin") + "</span> ";
			break;
		case "5":
			f += return_img("anchorimg", "anchor") + "</span> ";
			break;
		default:
			f += "<img  src=" + $SYS.res_url
					+ "douyu/images/spot.png  ></span>";
			break
		}
	}
	f += '<span class="name"><a href="#" class="nick js_nick" rel='
			+ e[3]["value"] + " >" + e[2]["value"]
			+ '</a></span><span class="time">(' + timetodate(e[12]["value"])
			+ ")</span></p>";
	str = e[6]["value"];
	str = html_encode(str);
	str = facereplace(str);
	if (e[3]["value"] == g) {
		f += '<div class="my_cont"><div class="m">' + str + "</div></div>"
	} else {
		f += '<p class="text_cont">' + str + "</p>"
	}
	$("#chat_line_list").append(c);
	$(c).html(f);
	del_ttlist(100);
	var j = e[8]["value"];
	var h = e[7]["value"];
	if (roomgrouplist[e[3]["value"]] == undefined) {
		roomgrouplist[e[3]["value"]] = new Array()
	}
	roomgrouplist[e[3]["value"]]["roomgroup"] = e[10]["value"];
	roomgrouplist[e[3]["value"]]["pg"] = e[11]["value"];
	if ((e[3]["value"] == g) && $SYS.groupid != 5
			&& ($SYS.uid != $ROOM.owner_uid)) {
		if (parseInt(e[9]["value"]) != send_interval_time) {
			if (e[9]["value"] > intervaltime) {
				intervaltime = parseInt(e[9]["value"])
			}
		}
		if (send_interval_time == 0) {
			bttime()
		}
		send_interval_time = parseInt(e[9]["value"])
	}
	if ($("#commonscroll").attr("rel") == "scroll-on") {
		scrdown("chat_lines")
	}
}
function return_pravite_msg(g) {
	var c = Sttdecode(g);
	if (c[1]["value"] > 0) {
		return false
	}
	str = c[6]["value"];
	str = html_encode(str);
	str = facereplace(str);
	var d = add_ttlist("privatechart");
	var h = c[8]["value"];
	var f = c[7]["value"];
	var e = "";
	d
			.html(e
					+ ' <a href="#" class="nick js_nick" rel='
					+ c[3]["value"]
					+ ">"
					+ c[2]["value"]
					+ '</a> <a style="color:#FF0000">对</a> <a class="js_nick" href="#" rel='
					+ c[4]["value"] + " >" + c[5]["value"] + "</a><a> 说:</a>"
					+ str);
	scrdown("privatechart")
}
function return_sys_msg(d) {
	var c = add_ttlist("chat_line_list");
	c.html('<a style="color:#FF0000">系统广播: ' + d + "</a>");
	scrdown("chat_lines")
}
function return_sys_pravite_msg(d) {
	d = html_encode(d);
	var c = add_ttlist("privatechart");
	c.html('<a style="color:#FF0000">提醒: ' + d + "</a>");
	scrdown("privatechart")
}
function logprompt(f) {
	var c = Sttdecode(f);
	if (c[3]["value"] == 0) {
		return false
	}
	var e = "";
	if (roomgrouplist[c[0]["value"]]["roomgroup"] <= 1) {
		return false
	}
	e += ' <a href="#" class="nick js_nick" rel=' + c[0]["value"] + " >"
			+ c[1]["value"] + "</a>进入房间";
	roomgrouplist[c[0]["value"]] = new Array();
	roomgrouplist[c[0]["value"]]["roomgroup"] = c[3]["value"];
	roomgrouplist[c[0]["value"]]["classtype"] = c[2]["value"];
	del_ttlist(100);
	var d = add_ttlist("chat_line_list");
	d.html(e);
	scrdown("chat_lines")
}
function cashgift_public(e) {
	var c = Sttdecode(e);
	var d = add_ttlist("chat_line_list");
	var f = '<a href="#" class="nick js_nick" rel=' + c[2]["value"] + " >"
			+ c[3]["value"] + '</a>:向主播赠送了 <img width="28" height="28" src='
			+ $SYS.res_url + "images/item/redbag.gif /> ";
	d.html(f);
	scrdown("chat_lines")
}
function online_userlist(e) {
	$("#user_list").html("");
	var h = Sttdecode(e);
	var f = 11;
	var k = (h.length - 1) / f;
	for ( var m = 0; m < k; m++) {
		var j = h[m * f + 1]["value"];
		var g = h[m * f + 3]["value"];
		var n = h[m * f + 8]["value"];
		roomgrouplist[j] = new Array();
		roomgrouplist[j]["roomgroup"] = h[m * f + 4]["value"];
		roomgrouplist[j]["classtype"] = h[m * f + 8]["value"];
		roomgrouplist[j]["blackgroup"] = h[m * f + 5]["value"];
		var i = "";
		if (h[m * f + 5]["value"] > 0) {
			i = '<span class="level_icon"><img src="' + $SYS.res_url
					+ 'new_style2/images/black.gif " class="black"></span>'
		}
		var d = h[m * f + 4]["value"] > 1 && h[m * f + 4]["value"] < 5 ? '<span class="level_icon">'
				+ return_img("roomadmin", "roomadmin") + "</span>"
				: "";
		d += h[m * f + 4]["value"] == 5 ? '<span class="level_icon">'
				+ return_img("anchorimg", "anchor") + "</span>" : "";
		d += '<span class="level_icon">' + return_img("classtype", n)
				+ "</span>";
		d = '<p class="fixed">' + i + d + "</p>";
		var l = '<p class="fixed"><a href="#" rel="' + j
				+ '" class="username js_nick" >' + g + "</a></p>";
		var c = document.createElement("li");
		if (m % 2 != 0) {
			$(c).addClass("b")
		}
		$("#user_list").append(c);
		$(c).html(d + l)
	}
}
function online_adminlist(e) {
	$("#admin_list").html("");
	var h = Sttdecode(e);
	var f = 11;
	var m = (h.length - 1) / f;
	for ( var k = 0; k < m; k++) {
		var i = h[k * f + 1]["value"];
		var g = h[k * f + 3]["value"];
		var l = h[k * f + 8]["value"];
		var d = h[k * f + 4]["value"] == 5 ? '<span class="level_icon">'
				+ return_img("anchorimg", "anchor") + "</span>"
				: '<span class="level_icon">'
						+ return_img("roomadmin", "roomadmin") + "</span>";
		d += '<span class="level_icon">' + return_img("classtype", l)
				+ "</span>";
		d = '<p class="fixed">' + d + "</p>";
		var j = '<p class="fixed"><a class="js_nick" href="#" rel="' + i + '">'
				+ g + "</a></p>";
		var c = document.createElement("li");
		if (k % 2 != 0) {
			$(c).addClass("b")
		}
		$("#admin_list").append(c);
		$(c).html(d + j)
	}
}
function room_cachedmsg(f) {
	var h = Sttdecode(f);
	var e = document.getElementById("giftlist");
	e.innerHTML = "";
	var g = (h.length - 1) / 7 > 10 ? 10 : (h.length - 1) / 7;
	for ( var m = 0; m < g; m++) {
		var d = h[m * 7 + 3]["value"];
		var l = h[m * 7 + 5]["value"];
		var i = h[m * 7 + 6]["value"];
		var j = document.createElement("li");
		e.appendChild(j);
		var c = propname_list[h[m * 7 + 1]["value"]]["name"];
		var k = icon_list[h[m * 7 + 1]["value"]];
		$(j).html(
				l + " 收到了 " + d + " 送来的 " + i + "个" + c
						+ ' <img width="28" height="28" src=' + $SYS.res_url
						+ "images/item/" + k + " />")
	}
}
function room_offerrank(j) {
	var k = Sttdecode(j);
	var q = "@A";
	var m = k[1]["value"].replace(new RegExp(q, "g"), "@");
	var h = new Array();
	h = m.split("//");
	var l = h.length - 1;
	var g = "";
	switch (k[0]["value"]) {
	case "weekofferrank":
		g = "week";
		break;
	case "monthofferrank":
		g = "month";
		break
	}
	var n = g + "fans_rank_top_ul";
	var i = g + "fans_rank_ul";
	var p = document.getElementById(n);
	var e = document.getElementById(i);
	p.innerHTML = "";
	e.innerHTML = "";
	for ( var o = 1; o <= l; o++) {
		var d = Sttdecode(h[o - 1]);
		var f = document.createElement("li");
		var c = o <= 3 ? p : e;
		c.appendChild(f);
		$(f).addClass("nub" + o);
		$(f).html(
				'<a class="fl">' + d[2]["value"]
						+ '</a><span class="credit fr">' + d[1]["value"]
						+ "</span>")
	}
}
function room_propstatist(f) {
	var d = f.split("type@=cashgift/");
	var g = new Array();
	g[0] = d[0].split("type@=prop/")[1];
	g[1] = d[1].split("type@=sofa/")[0];
	g[2] = d[1].split("type@=sofa/")[1];
	$("#liwu").html("");
	for (a = 0; a < 3; a++) {
		var j = Sttdecode(g[a]);
		var h = 4;
		var c = (j.length - 1) / h;
		for (b = 0; b < c; b++) {
			var i = document.createElement("li");
			var k = '<li><span class="nickname">' + j[b * h + 1]["value"]
					+ "</span>";
			switch (a) {
			case 0:
				var l = $SYS.res_url + "images/item/"
						+ icon_list[j[b * h + 2]["value"]];
				var e = propname_list[j[b * h + 2]["value"]]["name"];
				break;
			case 1:
				var l = $SYS.res_url + "new_style2/images/redbag.png";
				var e = "红包";
				break;
			case 2:
				var l = $SYS.res_url + "new_style2/images/sofa.gif";
				var e = "抢沙发";
				break
			}
			k += '<span class="gift">' + e
					+ '</span><span class="gift_pic"><img src="' + l
					+ '" width="24" height="24" /></span>';
			k += '<span class="num">' + j[b * h + 3]["value"] + "</span>";
			$("#liwu").append(i);
			$(i).html(k)
		}
	}
}
function room_giftrank(f) {
	var g = Sttdecode(f);
	var m = "@A";
	var i = g[1]["value"].replace(new RegExp(m, "g"), "@");
	var e = new Array();
	room_rank_list = i.split("//");
	var h = room_rank_list.length - 1;
	$("#roomrank").html("");
	var k = 1;
	var c = "";
	for ( var l = 0; l < h; l++) {
		c += k == 1 ? '<li class="line"><p>' : "";
		var e = Sttdecode(room_rank_list[l]);
		var j = icon_list[e[0]["value"]];
		var d = propname_list[e[0]["value"]]["name"];
		c += '<span><em><img src="' + $SYS.res_url + "images/item/" + j
				+ '" name="anchorgift" pname="' + d + '" rel="' + e[1]["value"]
				+ '" width="24" height="24"/></em>第' + e[2]["value"]
				+ "</span>";
		if (l == (h - 1) || k == 5) {
			c += "</p></li>"
		}
		k++;
		k = k > 5 ? 1 : k
	}
	$("#roomrank").html(c)
}
function room_bugle(g) {
	var c = Sttdecode(g);
	if (c[0]["value"] == 0) {
		$.dialog.tips_black("发送成功！");
		del_ttlist(100);
		var d = add_ttlist("chat_line_list");
		var e = c[4]["value"] == 5 ? return_img("anchorimg", "anchor") + " "
				: "";
		e += c[4]["value"] > 1 && c[4]["value"] < 5 ? return_img("roomadmin",
				"roomadmin")
				+ " " : "";
		e += return_img("classtype", c[3]["value"]);
		var h = "<img src="
				+ $SYS.res_url
				+ 'new_style2/images/lb.gif /> <span style="color:red;">大喇叭广播:</span> '
				+ e + ' <a class="js_nick" href="#" rel=' + c[1]["value"]
				+ " >" + c[2]["value"] + "</a>:";
		buglestr = html_encode(c[5]["value"]);
		var f = new RegExp("<br>", "g");
		buglestr = buglestr.replace(f, "");
		buglestr = facereplace(buglestr);
		h += buglestr;
		d.html(h);
		scrdown("chat_lines")
	} else {
		if (c[0]["value"] == 283) {
			dialog_pay()
		} else {
			$.dialog.tips_black("发送失败！")
		}
	}
}
function room_bugle_alluser(g) {
	var j = Sttdecode(g);
	var i = 6;
	var e = (j.length - 1) / i;
	for ( var l = 0; l < e; l++) {
		var m = document.createElement("span");
		$(m).addClass("tipItem");
		var h = j[parseInt(parseInt(l * i) + 5)]["value"];
		h = html_encode(h);
		var d = new RegExp("<br>", "g");
		h = h.replace(d, "");
		h = facereplace(h);
		var k = new Date(j[parseInt(parseInt(l * i) + 4)]["value"] * 1000);
		var f = !$.browser.safari ? k.toLocaleString().split(" ")[1] : k
				.toLocaleString().split(" ")[4];
		var c = "";
		c = '<a href="' + j[parseInt(parseInt(l * i) + 1)]["value"]
				+ '" target="_blank">';
		c += '<span class="tipIcon">'
				+ return_img("classtype",
						j[parseInt(parseInt(l * i) + 3)]["value"]) + "</span>";
		c += '<span class="tipName">'
				+ j[parseInt(parseInt(l * i) + 2)]["value"] + ":</span>";
		c += "<span>" + h + "</span>";
		c += '<span class="tipTime">(' + f + ")</span></a>";
		$("#bugle").append(m);
		$(m).html(c);
		buglesumwidth = $("#bugle").width();
		if (buglesumwidth > buglewidth) {
			document.getElementById("bugle").style.left = (buglewidth - buglesumwidth)
					+ "px"
		}
	}
}
function scan_str(e) {
	var c = "";
	for ( var d = 0; d < e.length; d++) {
		if (e.charAt(d) == "\\") {
			c += "\\\\"
		} else {
			c += e.charAt(d)
		}
	}
	return c
}
function page_scrn() {
	if ($("#live_player .swf_container").hasClass("page_scrn")) {
		$("#live_player").removeClass("alls");
		$("#live_player .swf_container").removeClass("page_scrn");
		if ($("#left_col").length) {
			$("#left_col").show();
			$("#main_col").css("overflow-y", "scroll");
			var f = $("#large_nav").is(":visible") ? "240px" : "49px";
			if (get_cookie("right_menu") == 1) {
				var g = 0
			} else {
				var g = "240px";
				$("#right_col").show()
			}
			$("#main_col").css({
				"margin-left" : f,
				"margin-right" : g
			})
		} else {
			$("#main_col").css({
				"overflow-y" : "auto",
				"overflow-x" : "auto"
			})
		}
		set_window_width();
		set_live_height()
	} else {
		if ($("#left_col").length) {
			$("#left_col").hide();
			$("#right_col").hide();
			$("#main_col").css({
				"margin-left" : 0,
				"margin-right" : 0,
				"overflow-y" : "hidden"
			})
		} else {
			$("#main_col").css({
				"overflow-y" : "hidden",
				"overflow-x" : "hidden"
			})
		}
		$("#live_player").addClass("alls");
		var d = $("#main_col").scrollTop() || $(window).scrollTop();
		$("#live_player").css("top", d);
		var c = window.innerWidth || document.documentElement.clientWidth
				|| document.body.clientWidth;
		var e = window.innerHeight || document.documentElement.clientHeight
				|| document.body.clientHeight;
		$("#live_player .swf_container").addClass("page_scrn").height(e);
		call_resize(c, e)
	}
}
$(document)
		.ready(
				function() {
					var e = "11.1.0";
					var d = {};
					d.LiveID = room_args.rtmp_view.rtmp_val;
					d.RtmpUrl = room_args.rtmp_view.rtmp_url;
					d.Servers = room_args.server_config;
					d.RoomId = $ROOM.room_id;
					d.cate_id = $ROOM.cate_id;
					d.cdn = room_args.rtmp_view.rtmp_cdn;
					d.OwnerId = $ROOM.owner_uid;
					d.Status = $ROOM.show_status === 1 ? true : false;
					d.closeFMS = $ROOM.show_status !== 1 || room_args.live_url ? true
							: false;
					d.DomainName = window.location.host;
					d.asset_url = $SYS.res_url;
					d.roompass = $ROOM.room_pwd;
					d.checkowne = $SYS.uid == $ROOM.owner_uid ? 1 : 0;
					d.usergroupid = $SYS.groupid;
					var g = {};
					g.quality = "high";
					g.bgcolor = "#ffffff";
					g.allowscriptaccess = "always";
					g.allowfullscreen = "true";
					g.wmode = "Opaque";
					g.allowFullScreenInteractive = "true";
					var f = {};
					f.id = "WebRoom";
					f.name = "WebRoom";
					f.align = "middle";
					f.allowscriptaccess = "always";
					f.allowfullscreen = "true";
					f.allowFullScreenInteractive = "true";
					swfobject.embedSWF(room_args.swf_url, "flashContent",
							room_args.live_url ? "0" : "100%",
							room_args.live_url ? "0" : "100%", e, "", d, g, f);
					swfobject.createCSS("#flashContent",
							"display:block;text-align:left;");
					$("#room_gg a")
							.click(
									function() {
										$(this).attr("target", "_blank");
										var h = $(this).attr("href");
										if (h.substr(0, 4) === "http"
												&& h
														.indexOf(window.location.host) !== 7) {
											return confirm("访问内容超出本站范围，不能确定是否安全，要继续访问吗？")
										}
										if (h.indexOf("javascript") === 0) {
											return false
										}
									});
					if ($("#left_col").length) {
						$("#main_col").height($(window).height())
					}
					$("input, textarea").placeholder();
					set_window_width();
					set_live_height();
					$(window).resize(function() {
						set_window_width();
						set_live_height();
						if ($("#small_nav").is(":visible")) {
							$("#guide_login,#back").hide()
						}
					});
					$("#js_page_url").val($ROOM.room_url);
					if ($SYS.uid && $SYS.uid == $ROOM.owner_uid) {
						$(".js_login_myroom").show();
						$(".js_room_user").hide()
					}
					$("#chart_content").on("keyup", function() {
						if ($(this).val().length >= maxcontent) {
							$(this).val($(this).val().substr(0, maxcontent))
						}
					});
					$("#roomadmin").bind("mouseover", function(h) {
						$("#roomadminul").show()
					});
					$("#select_box").bind("mouseleave", function(h) {
						$("#roomadminul").hide()
					});
					$("input").focus(function() {
						in_input = true
					});
					$("textarea").focus(function() {
						in_input = true
					});
					$("input").blur(function() {
						in_input = false
					});
					$("textarea").blur(function() {
						in_input = false
					});
					$("#right_close").click(function() {
						var h = $("#right_col");
						var i = $("#main_col");
						if (h.is(":visible")) {
							h.hide();
							i.css("margin-right", 0);
							$("#right_close").addClass("right_open");
							setCookie("right_menu", 1, 2592000)
						} else {
							i.css("margin-right", "325px");
							h.show();
							$("#right_close").removeClass("right_open");
							setCookie("right_menu", 0, 2592000)
						}
						set_live_height();
						return false
					});
					$("#js_switch_live")
							.click(
									function() {
										if ($(this).hasClass("switch_on")) {
											$
													.dialog({
														content : "您确定要关闭直播吗？",
														icon : "question",
														okVal : "确定",
														ok : function() {
															window.location.href = "/room/my/close_show"
														},
														cancelVal : "取消",
														cancel : function() {
														}
													})
										} else {
											var h = $(this);
											if (h.data("doing") == 1) {
												return false
											}
											h.data("doing", 1);
											$
													.getJSON(
															"/room/my/first_show",
															function(j) {
																h.data("doing",
																		0);
																if (j.error == 0) {
																	h
																			.addClass("switch_on");
																	var i = "succeed"
																} else {
																	var i = "warning"
																}
																$
																		.dialog({
																			icon : i,
																			content : j.msg,
																			lock : true,
																			okVal : "查看直播信息",
																			ok : function() {
																				if (i) {
																					window.location.href = "/"
																							+ $ROOM.room_id
																				}
																				return true
																			}
																		})
															})
										}
										return false
									});
					$("#js_no_home")
							.click(
									function() {
										if ($("#js_no_home").data("doing")) {
											$.dialog
													.alert("设置已提交，请等待1~2分钟服务器更新");
											return false
										}
										if (room_args.no_home) {
											$.dialog
													.confirm(
															"当前房间已被设置不推荐到首页，有效期至"
																	+ room_args.no_home_time
																	+ "。<br>请问是否需要取消限制？",
															function() {
																$
																		.get(
																				"/room/my_admin/no_home_cancel/"
																						+ $ROOM.room_id,
																				function(
																						h) {
																					$.dialog
																							.alert("设置已提交，请等待1~2分钟服务器更新，在此期间请勿对本房间反复提交");
																					$(
																							"#js_no_home")
																							.data(
																									"doing",
																									1)
																				})
															})
										} else {
											$.dialog
													.prompt(
															"不推荐到正在直播多少小时？",
															function(h) {
																h = parseInt(h,
																		10);
																if (h < 1) {
																	$.dialog
																			.alert("限制时间最少1小时");
																	return false
																}
																$
																		.get(
																				"/room/my_admin/no_home_set/"
																						+ $ROOM.room_id,
																				{
																					hour : h
																				},
																				function(
																						i) {
																					if (i == "error") {
																						$.dialog
																								.alert("设置失败，请确认房间当前状态")
																					} else {
																						$.dialog
																								.alert("设置已提交，请等待1~2分钟服务器更新，在此期间请勿对本房间反复提交");
																						$(
																								"#js_no_home")
																								.data(
																										"doing",
																										1)
																					}
																				})
															}, "24")
										}
										return false
									});
					$("#js_share a.share-btn, #js_share_more_ico a")
							.click(
									function() {
										var h = $(this).data("to");
										if (h) {
											if (h == "tsina") {
												var i = "&appkey=979098171&ralateuid=3982726153"
											} else {
												var i = ""
											}
											$(this)
													.attr(
															"href",
															"http://www.jiathis.com/send/?webid="
																	+ h
																	+ "&url="
																	+ encodeURIComponent($ROOM.room_url)
																	+ "&title=&summary="
																	+ encodeURIComponent("我正在 "
																			+ $ROOM.room_name
																			+ " 的房间观看直播 / 主播"
																			+ $ROOM.owner_name
																			+ "，欢迎大家前来围观 / 来自#斗鱼#游戏直播！")
																	+ "&uid=1896137&data_track_clickback=true&pic="
																	+ encodeURIComponent($ROOM.room_pic)
																	+ i).attr(
															"target", "_blank")
										} else {
											return false
										}
									});
					var c = null;
					$("#js_share .js_share_more")
							.click(
									function() {
										if ($("#js_share_more").is(":hidden")) {
											if (c) {
												clearTimeout(c)
											}
											$(".share_more").removeClass(
													"share_more_single");
											if ($(".js_live_height").width()
													- $(
															".js_live_height .h_action")
															.width()
													+ $("#js_share").width() < 600) {
												$(".share_more").addClass(
														"share_more_single")
											}
											$("#js_share_more").show();
											if ($("body").data("copy") == undefined) {
												$("#js_share_more a.s_copy")
														.each(
																function() {
																	$(this)
																			.zclip(
																					{
																						path : room_args.res_path
																								+ "images/ZeroClipboard.swf",
																						copy : $(
																								this)
																								.prev()
																								.val(),
																						afterCopy : function() {
																							$.dialog
																									.tips_black(
																											"已复制到您的剪切板",
																											1.5)
																						}
																					})
																});
												$("body").data("copy", 1)
											}
											$(".js_share_more").removeClass(
													"more01");
											$(".js_share_more")
													.addClass("more")
										} else {
											$("#js_share_more").hide();
											$(".js_share_more").removeClass(
													"more");
											$(".js_share_more")
													.addClass("more");
											$(".js_share_more").addClass(
													"more01")
										}
										return false
									});
					window.onUnload = function() {
						thisMovie("WebRoom").windowCloseHandler()
					};
					if ($ROOM.show_status == 0 && $SYS.uid == $ROOM.owner_uid) {
						showintervalobj = setInterval("get_show_status("
								+ $ROOM.show_id + ")", 30000)
					}
					if (($SYS.uid == $ROOM.owner_uid) || $SYS.groupid == 5) {
						document.getElementById("chart_content").maxLength = 200;
						maxcontent = 200;
						intervaltime = send_interval_time = 0
					}
					$("#switch").click(function() {
						htmlswitch("face_list");
						return false
					});
					$("#user_black").on("click", function() {
						if ($(this).attr("rel") == 0) {
							black_obj.black_myblacklis_add()
						} else {
							if ($(this).attr("rel") == 1) {
								black_obj.black_myblacklis_del()
							}
						}
						return false
					});
					$("#giftnum").bind("click", function(h) {
						$("#gnumlist").show();
						return false
					});
					$(".gnumbut").bind("click", function(h) {
						$("#giftnum").val($(this).html());
						$("#gnumlist").hide();
						return false
					});
					$("#gnumdiv").bind("mouseleave", function(h) {
						$("#gnumlist").hide()
					});
					$("#chat_line_list").delegate(
							"a.js_nick",
							"click",
							function(j) {
								clickuid = $(this).attr("rel");
								var i = !$SYS.uid ? touristuid : $SYS.uid;
								if (!$SYS.uid) {
									return false
								}
								if (i != clickuid) {
									var h = $(this).position();
									popUp(h.left, h.top
											+ $(this).outerHeight(true));
									menu_show(this)
								}
								return false
							});
					$(".user_wrap").on("mouseleave", function() {
						$("#itemopen").hide()
					});
					$("#adminsetup").on("click", function() {
						adminreg();
						$("#itemopen").hide();
						return false
					});
					$("#chat_lines").hover(function() {
						$(this).data("hover", 1)
					}, function() {
						$(this).data("hover", 0)
					});
					$("#chat_lines, #commonscrn").bind("mouseover",
							function(h) {
								$("#commonscrn").show()
							});
					$("#chat_lines").bind("mouseleave", function(h) {
						$("#commonscrn").hide()
					});
					$("#commonscroll,#privatescroll").on("click", function() {
						var h = "";
						if ($(this).attr("rel") == "scroll-off") {
							h = "scroll-on";
							$(this).removeClass("roll_icon");
							$(this).addClass("roll_icon_open")
						} else {
							h = "scroll-off";
							$(this).removeClass("roll_icon_open");
							$(this).addClass("roll_icon")
						}
						$(this).attr("rel", h);
						return false
					});
					$("#details_but").on("click", function() {
						$(this).removeClass("gboff");
						var h = parseInt($("#chat_lines").css("height"));
						var j = parseInt($("#commonscrn").css("top"));
						if ($("#details_show").is(":hidden")) {
							$("#details_show").show();
							var i = $("#details_show").outerHeight(true);
							$("#details_show").height(i > 115 ? 95 : (i - 20));
							$("#chat_lines").css({
								height : (h - i) + "px"
							});
							$("#commonscrn").css({
								top : (j + i) + "px"
							})
						} else {
							var i = $("#details_show").outerHeight(true);
							$("#details_show").hide();
							$(this).addClass("gboff");
							$("#chat_lines").css({
								height : (h + i) + "px"
							});
							$("#commonscrn").css({
								top : (j - i) + "px"
							})
						}
						return false
					});
					$("#chart_content").bind("keypress", function(h) {
						if (h.which == 13) {
							sendmsg();
							return false
						}
					});
					$("#chart_content").bind("keydown click focus keyup",
							function(h) {
								getTxt1CursorPosition("chart_content", 1)
							});
					$("#sendmsg").click(function() {
						sendmsg();
						return false
					});
					$("#face_list em")
							.on(
									"click",
									function() {
										if (document
												.getElementById("chart_content").value == "这里输入聊天内容") {
											document
													.getElementById("chart_content").value = ""
										}
										var i = $(this).attr("ftype");
										var j = "[emot:" + $(this).attr("rel")
												+ "]";
										if (i == "chat") {
											var h = $("#chart_content").val().length;
											var k = parseInt($("#chart_content")
													.attr("maxlength"));
											if (h < k) {
												getValue("chart_content", j, 1)
											}
											$("#face_list").hide()
										}
										return false
									});
					$(".js_tipsy").bind(
							"mousemove mouseleave",
							function(j) {
								if (j.type == "mouseleave") {
									$("#tipsy").hide()
								} else {
									var h = $(this).offset();
									$("#tipsy").css(
											"top",
											h.top + $(this).outerHeight(true)
													+ 6);
									var i = ($("#tipsy").outerWidth(true) - $(
											this).outerWidth(true)) / 2;
									$("#tipsy").css("left", h.left - i);
									$("#tiptit").html($(this).data("title"));
									$("#tipsy").show()
								}
							});
					$("#ng_qd").click(function() {
						$("#back,#fxshow,#qdshow").hide();
						return false
					});
					$("#signbut").click(function() {
						if (!check_login()) {
							return false
						}
						if (!$(this).hasClass("dypic_jd01")) {
							if (follow_stat == 0) {
								$.dialog({
									id : "followmsg",
									content : "关注之后才能签到，是否立即关注并签到？",
									icon : "warning",
									okVal : "关注并签到",
									ok : function() {
										follow_room();
										task_obj.sign_send()
									},
									cancelVal : "取消",
									cancel : function() {
									}
								})
							} else {
								task_obj.sign_send()
							}
						}
						return false
					});
					$("#check_email").click(function() {
						if (!check_login()) {
							return false
						}
						var h = $(this).attr("rel");
						if (!h) {
							$("#task_cont,#triangle_up,#taskmsg").hide();
							window.open("/member/cp")
						} else {
							task_obj.reward_send($(this).attr("tid"))
						}
						return false
					});
					$("#check_pic").click(function() {
						if (!check_login()) {
							return false
						}
						var h = $(this).attr("rel");
						if (!h) {
							$("#task_cont,#triangle_up,#taskmsg").hide();
							window.open("/member/cp#avatar")
						} else {
							task_obj.reward_send($(this).attr("tid"))
						}
						return false
					});
					$("#check_share")
							.click(
									function() {
										if (!check_login()) {
											return false
										}
										var h = $(this).attr("rel");
										if (h == 1) {
											task_obj.reward_send($(this).attr(
													"tid"))
										} else {
											$("#back,#fxshow,#fxzd").show();
											var i = $("#js_share").offset();
											$("#fxshow").offset({
												top : i.top - 102,
												left : i.left - 6
											});
											$("#back").height(
													$("#main_col").outerHeight(
															true));
											$(window)
													.resize(
															function() {
																var j = $(
																		"#js_share")
																		.offset();
																$("#fxshow")
																		.offset(
																				{
																					top : j.top - 102,
																					left : j.left - 6
																				});
																$("#back")
																		.height(
																				$(
																						"#main_col")
																						.outerHeight(
																								true))
															})
										}
										return false
									});
					$(".delshow,.is_ng_qd").click(function() {
						$("#back,.js_zy").hide();
						return false
					});
					$("#check_sign")
							.click(
									function() {
										if (!check_login()) {
											return false
										}
										var h = $(this).attr("rel");
										if (h == 1) {
											task_obj.reward_send($(this).attr(
													"tid"))
										} else {
											if (h == 2) {
												$("#taskul").attr("rel", 1);
												var i = check_user_login();
												$("#taskmsg").css({
													bottom : "42px"
												});
												if ($ROOM.owner_uid != i.wl_uid) {
													if (sign_stat == 0) {
														$("#back,#qdshow")
																.show();
														$("#back")
																.height(
																		$(
																				"#main_col")
																				.outerHeight(
																						true));
														var j = $("#signbut")
																.offset();
														$("#qdshow").offset({
															top : j.top - 107,
															left : j.left - 6
														});
														$(window)
																.resize(
																		function() {
																			var k = $(
																					"#signbut")
																					.offset();
																			$(
																					"#qdshow")
																					.offset(
																							{
																								top : k.top - 107,
																								left : k.left - 6
																							});
																			$(
																					"#back")
																					.height(
																							$(
																									"#main_col")
																									.outerHeight(
																											true))
																		})
													} else {
														$("#taskul")
																.html(
																		" <li><span>还可以签到<i>"
																				+ (3 - signnum)
																				+ "</i>个房间，可以去其它房间转转哦！</span></li>");
														$("#taskmsg").show()
													}
												} else {
													$("#taskul")
															.html(
																	"<li>主播不能在自己房间签到</li>");
													$("#taskmsg").show()
												}
											}
										}
										return false
									});
					$("#rwbut")
							.bind(
									"mouseover",
									function(h) {
										$("#rwbut").removeClass();
										if ($("#task_cont").is(":hidden")) {
											$("#rwbut")
													.addClass(
															"task task_hover task_expand task_expand_hover fl")
										} else {
											$("#rwbut")
													.addClass(
															"task task_hover task_expand_hover fl")
										}
									});
					$("#rwbut").bind("mouseleave", function(h) {
						$("#rwbut").removeClass();
						if ($("#task_cont").is(":hidden")) {
							$("#rwbut").addClass("task  task_expand fl")
						} else {
							$("#rwbut").addClass("task  task_expand_hover  fl")
						}
					});
					$("#rwbut")
							.click(
									function() {
										rwbut_stat = 1;
										var h = check_user_login();
										if (!h) {
											user_dialog.open_login();
											return false
										}
										if ($("#task_cont").is(":hidden")) {
											$("#task_ul").hide();
											$("#task_cont,#taskload").show();
											task_obj.get_task_stat();
											$("#rwbut").removeClass();
											$("#rwbut")
													.addClass(
															"task task_hover task_expand_hover fl");
											rwreturn_stat = 0;
											setTimeout("rwreturn_show()", 10000)
										} else {
											$(
													"#task_cont,#triangle_up,#taskmsg")
													.hide()
										}
										return false
									})
				});