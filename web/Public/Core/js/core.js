 
/**
 * 应用初始化
 */

var atwho_config;
$(function () {
    $('.open-popup-link').magnificPopup({
        type: 'inline',
        midClick: true,
        closeOnBgClick: false
    });// 绑定发微博弹窗
    ucard();// 绑定用户小名片
    bindGoTop();// 回到顶部

    $('input,area').placeholder();// 修复ieplace holder
    if (is_login()) {
        bindMessageChecker();// 绑定用户消息
    }
    checkMessage();// 检查一次消息

    bindLogout();
    $('.scroller').slimScroll({
        height: '150px'
    });

    $('#scrollArea_chat').slimScroll({
        height: '320px',
        alwaysVisible: true,
        start: 'bottom'
    });
    atwho_config = {
        at: "@",
        data: U('Weibo/Index/atWhoJson'),
        tpl: "<li data-value='@${username}'><img class='avatar-img' style='width:2em;margin-right: 0.6em' src='${avatar32}'/>${username}</li>",
        show_the_at: true,
        search_key: 'search_key',
        start_with_space: false
    };
    var $inputor = $('#weibo_content').atwho(atwho_config);

});
$(function () {
    /**
	 * ajax-post 将链接转换为ajax请求，并交给handleAjax处理 参数： data-confirm：如果存在，则点击后发出提示。
	 * 示例：<a href="xxx" class="ajax-post">Test</a>
	 */
    $(document).on('click', '.ajax-post', function (e) {
        // 取消默认动作，防止跳转页面
        e.preventDefault();

        // 获取参数（属性）
        var url = $(this).attr('href');
        var confirmText = $(this).attr('data-confirm');

        // 如果需要的话，发出确认提示信息
        if (confirmText) {
            var result = confirm(confirmText);
            if (!result) {
                return false;
            }
        }

        // 发送AJAX请求
        $.post(url, {}, function (a, b, c) {
            handleAjax(a);
        });
    });

    /**
	 * ajax-form 通过ajax提交表单，通过oneplus提示消息 示例：<form class="ajax-form"
	 * method="post" action="xxx">
	 */
    $(document).on('submit', 'form.ajax-form', function (e) {
        // 取消默认动作，防止表单两次提交
        e.preventDefault();

        // 禁用提交按钮，防止重复提交
        var form = $(this);
        $('[type=submit]', form).addClass('disabled');

        // 获取提交地址，方式
        var action = $(this).attr('action');
        var method = $(this).attr('method');

        // 检测提交地址
        if (!action) {
            return false;
        }

        // 默认提交方式为get
        if (!method) {
            method = 'get';
        }

        // 获取表单内容
        var formContent = $(this).serialize();

        // 发送提交请求
        var callable;
        if (method == 'post') {
            callable = $.post;
        } else {
            callable = $.get;
        }
        callable(action, formContent, function (a) {
            handleAjax(a);
            $('[type=submit]', form).removeClass('disabled');
        });

        // 返回
        return false;
    });
});

function is_login() {
    return parseInt(MID);
}

/**
 * 模拟U函数
 * 
 * @param url
 * @param params
 * @returns {string}
 * @constructor
 */
function U(url, params, rewrite) {


  
        var website = _ROOT_ + '/index.php';
        url = url.split('/');
//        if (url[0] == '' || url[0] == '@')
//            url[0] = APPNAME;
        if (!url[1])
            url[1] = 'Index';
        if (!url[2])
            url[2] = 'index';
        website = website + '?s=/' + url[0] + '/' + url[1] + '/' + url[2];
        if (params) {
            params = params.join('/');
            website = website + '/' + params;
        }
        if (!rewrite) {
            website = website + '.html';
        }

    return website;
}

/**
 * 绑定用户小名片
 */
function ucard() {
    $('[ucard]').qtip({ // Grab some elements to apply the tooltip to
        suppress: true,
        content: {
            text: function (event, api) {
                var uid = $(this).attr('ucard');
                $.get(U('UserCenter/Public/getProfile'), {uid: uid}, function (userProfile) {
                    var follow = '';
                    if ((MID != uid) && (MID != 0)) {
                        follow = '<button type="button" class="btn btn-default" onclick="start_talk(' + userProfile.uid + ')" style="float: right;margin: 5px 0;padding: 2px 12px;margin-left: 8px;">私&nbsp;信</button>';
                        if (userProfile.followed == 1) {
                            follow += '<button type="button" class="btn btn-default" onclick="ufollow(this,' + userProfile.uid + ')" style="float: right;margin: 5px 0;padding: 2px 12px;"><font title="取消关注">已关注</font></button>';
                        } else {
                            follow += '<button type="button" class="btn btn-primary" onclick="ufollow(this,' + userProfile.uid + ')" style="float: right;margin: 5px 0;padding: 2px 12px;">关&nbsp;注</button>';
                        }
                    }
                    var html = '<div class="row" style="width: 350px;width: 350px;font-size: 13px;line-height: 23px;">' +
                        '<div class="col-xs-12" style="padding: 2px;">' +
                        '<img class="img-responsive" src="' + window.Think.ROOT + '/Public/Core/images/qtip_bg.png">' +
                        '</div>' +
                        '<div class="col-xs-12" style="padding: 2px;margin-top: -25px;">' +
                        '<div class="col-xs-3">' +
                        '<img src="{$userProfile.avatar}" width="64px" height="64px" class="avatar-img img-responsive" style="-webkit-box-shadow: 0 3px 4px rgba(11, 2, 5, 0.54);-moz-box-shadow: 0 3px 4px rgba(11, 2, 5, 0.54);box-shadow: 0 3px 4px rgba(173, 173, 173, 0.54);border: solid 2px #fff;"/>' +
                        '</div>' +
                        '<div class="col-xs-9" style="padding-top: 25px;padding-right:0px;font-size: 12px;">' +
                        '<div style="font-size: 16px;font-weight: bold;"><a href="{$userProfile.space_url}" title="">{$userProfile.username}</a>{$userProfile.rank_link}' +
                        '</div>' +
                        '<div>' +
                        '<a href="{$userProfile.following_url}" title="我的关注" target="_black">关注：{$userProfile.following}</a>&nbsp;&nbsp;&nbsp;&nbsp;' +
                        '<a href="{$userProfile.fans_url}" title="我的关注" target="_black">粉丝：{$userProfile.fans}</a>&nbsp;&nbsp;&nbsp;&nbsp;' +
                        '<a href="{$userProfile.weibo_url}" title="我的关注" target="_black">微博：{$userProfile.weibocount}</a>' +
                        '</div>' +
                        '<div style="margin-bottom: 15px;color: #848484">' +
                        '个性签名：' +
                        '<span>' +
                        '{$userProfile.signature}' +
                        '</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-xs-12" style="background: #f1f1f1;">' +
                        follow +
                        '</div>' +
                        '</div>';

                    userProfile.signature = userProfile.signature === '' ? '还没想好O(∩_∩)O' : userProfile.signature;
                    for (var key in userProfile) {
                        html = html.replace('{$userProfile.' + key + '}', userProfile[key]);
                    }
                    // alert(html);
                    var tpl = $(html);
                    api.set('content.text', tpl.html());


                }, 'json');
                return '获取数据中...'
            }

        }, position: {
            viewport: $(window)
        }, show: {solo: true,
            delay: 500}, style: {
            classes: 'qtip-bootstrap'

        }, hide: {delay: 500, fixed: true
        }
    })
}
function ufollow(obj, uid) {
    objt = obj;
    obj = $(obj);
    if ($(obj).text().trim() == '已关注') {
        $.post(U('UserCenter/Public/unfollow'), {uid: uid}, function (msg) {
            if (msg.status) {
                obj.removeClass('btn-default');
                obj.addClass('btn-primary');
                op_success('取消关注成功。', '温馨提示');
                obj.text('关注');
            } else {
                op_error('取消关注失败。', '温馨提示');
            }
        }, 'json');
    } else {
        $.post(U('UserCenter/Public/follow'), {uid: uid}, function (msg) {
            if (msg.status) {
                obj.removeClass('btn-primary');
                obj.addClass('btn-default');
                op_success('关注成功。', '温馨提示');
                objt.innerHTML = "<font title='取消关注'>已关注</font>";
            } else {
                op_error('关注失败。', '温馨提示');
            }
        }, 'json');
    }

}
/**
 * 绑定回到顶部
 */
function bindGoTop() {
    $(window).scroll(function () {
        var sc = $(window).scrollTop();
        // var rwidth=$(window).width()
        if (sc > 0) {
            $("#goTopBtn").css("display", "block");
            $("#goTopBtn").css("right", "50px")
        } else {
            $("#goTopBtn").css("display", "none");
        }
    })

    $("#goTopBtn").click(function () {
        var sc = $(window).scrollTop();
        $('body,html').animate({scrollTop: 0}, 500);
    });
}
/**
 * 播放背景音乐
 * 
 * @param file
 *            文件路径
 */
function playsound(file) {
    if (window.Think.ROOT == '') {
        file = '/' + file;
    } else {
        file = window.Think.ROOT + '/' + file;
    }
    $('embed').remove();
    $('body').append('<embed src="' + file + '" autostart="true" hidden="true" loop="false">');
    var div = document.getElementById('music');
    div.src = file;
}
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
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-center",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
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
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-center",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
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
        "closeButton": false,
        "debug": false,
        "positionClass": "toast-center",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
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
        "closeButton": false,
        "debug": false,
        "positionClass": "toast-center",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.warning(text, title);
}


/**
 * 绑定消息检查
 */
function bindMessageChecker() {
    $hint_count = $('#nav_hint_count');
    $nav_bandage_count = $('#nav_bandage_count');

    setInterval(function () {
        checkMessage();
    }, 600000);
}

/**
 * 检查是否有新的消息
 */
function checkMessage() {
	
	
    $.get(U('Usercenter/Public/getInformation'), {}, function (msg) {
        if (msg.messages) {
            var count = parseInt($hint_count.text());
            if (count == 0) {
                $('#nav_message').html('');
            }
            playsound('Public/Core/js/ext/toastr/tip.mp3');
            for (var index in msg.messages) {

                tip_message(msg['messages'][index]['content'] + '<div style="text-align: right"> ' + msg['messages'][index]['ctime'] + '</div>', msg['messages'][index]['title']);
                // var url=msg[index]['url']===''?U('') //设置默认跳转到消息中心


                var new_html = $('<span><li><a data-url="' + msg['messages'][index]['url'] + '"' + 'onclick="readMessage(this,' + msg['messages'][index]['id'] + ')"><i class="glyphicon glyphicon-bell"></i>' +
                    msg['messages'][index]['title'] + '<br/><span class="time">' + msg['messages'][index]['ctime'] +
                    '</span> </a></li></span>');
                $('#nav_message').prepend(new_html.html());


            }

            $hint_count.text(count + msg.messages.length);
            $nav_bandage_count.show();
            $nav_bandage_count.text(count + msg.messages.length);
        }

        if (msg.new_talks) {
            playsound('Public/Core/js/ext/toastr/message.wav');
            // 发现有新的会话
            $.each(msg.new_talks, function (index, talk) {
                    prependSession(talk.talk);
                }
            );
        }


        if (msg.new_talk_messages) {
            playsound('Public/Core/js/ext/toastr/message.wav');
            // 发现有新的会话
            $.each(msg.new_talk_messages, function (index, talk_message) {
                    if (($('#chat_id').val() == talk_message.talk_id) && ($('#chat_box').is(":visible"))) {
                        chat_appendMessage(chat_fetchMessageTpl(talk_message, MID));
                        $.get(U('Usercenter/Session/getSession'), {id: talk_message.talk_id}, function () {

                        }, 'json');

                    }
                    else {
                        setSessionUnread(talk_message.talk_id);
                    }
                }
            );
        }


    }, 'json');

}
function readMessage(obj, message_id) {
    var url = $(obj).attr('data-url');
    $.post(U('Usercenter/Public/readMessage'), {message_id: message_id}, function (msg) {
        if (msg.status) {
            location.href = url;
        }
    }, 'json');
}

/**
 * 将所有的消息设为已读
 */
function setAllReaded() {
    $.post(U('Usercenter/Public/setAllMessageReaded'), function () {
        $hint_count.text(0);
        $('#nav_message').html('<div style="font-size: 18px;color: #ccc;font-weight: normal;text-align: center;line-height: 150px">暂无任何消息!</div>');
        $nav_bandage_count.hide();
        $nav_bandage_count.text(0);

    });
}


/**
 * 消息中心提示有新的消息
 * 
 * @param text
 * @param title
 */
function tip_message(text, title) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.info(text, title);
}
/**
 * 友好时间
 * 
 * @param sTime
 * @param cTime
 * @returns {string}
 */
function friendlyDate(sTime, cTime) {
    var formatTime = function (num) {
        return (num < 10) ? '0' + num : num;
    };

    if (!sTime) {
        return '';
    }

    var cDate = new Date(cTime * 1000);
    var sDate = new Date(sTime * 1000);
    var dTime = cTime - sTime;
    var dDay = parseInt(cDate.getDate()) - parseInt(sDate.getDate());
    var dMonth = parseInt(cDate.getMonth() + 1) - parseInt(sDate.getMonth() + 1);
    var dYear = parseInt(cDate.getFullYear()) - parseInt(sDate.getFullYear());

    if (dTime < 60) {
        if (dTime < 10) {
            return '刚刚';
        } else {
            return parseInt(Math.floor(dTime / 10) * 10) + '秒前';
        }
    } else if (dTime < 3600) {
        return parseInt(Math.floor(dTime / 60)) + '分钟前';
    } else if (dYear === 0 && dMonth === 0 && dDay === 0) {
        return '今天' + formatTime(sDate.getHours()) + ':' + formatTime(sDate.getMinutes());
    } else if (dYear === 0) {
        return formatTime(sDate.getMonth() + 1) + '月' + formatTime(sDate.getDate()) + '日 ' + formatTime(sDate.getHours()) + ':' + formatTime(sDate.getMinutes());
    } else {
        return sDate.getFullYear() + '-' + formatTime(sDate.getMonth() + 1) + '-' + formatTime(sDate.getDate()) + ' ' + formatTime(sDate.getHours()) + ':' + formatTime(sDate.getMinutes());
    }
}

/**
 * Ajax系列
 */

/**
 * 处理ajax返回结果
 */
function handleAjax(a) {
    // 如果需要跳转的话，消息的末尾附上即将跳转字样
    if (a.url) {
        a.info += '，页面即将跳转～';
    }

    // 弹出提示消息
    if (a.status) {
        op_success(a.info, '温馨提示');
    } else {
        op_error(a.info, '温馨提示');
    }

    // 需要跳转的话就跳转
    var interval = 1500;
    if (a.url == "refresh") {
        setTimeout(function () {
            location.href = location.href;
        }, interval);
    } else if (a.url) {
        setTimeout(function () {
            location.href = a.url;
        }, interval);
    }
}


/**
 * 初始化聊天框
 */
function op_initTalkBox() {
    $('#scrollArea').slimScroll({
        height: '400px',
        alwaysVisible: true,
        start: 'bottom'
    });
}
/**
 * 向聊天窗添加一条消息
 * 
 * @param html
 *            消息内容
 */
function op_appendMessage(html) {
    $('#scrollContainer').append(html);
    $('#scrollArea').slimScroll({scrollTo: $('#scrollContainer').height()});
    ucard();
}


/**
 * 渲染消息模板
 * 
 * @param message
 *            消息体
 * @param mid
 *            当前用户ID
 * @returns {string}
 */
function op_fetchMessageTpl(message, mid) {
    var tpl_right = '<div class="row talk_right">' +
        '<div class="time"><span class="timespan">{ctime}</span></div>' +
        '<div class="row">' +
        '<div class="col-md-10 bubble_outter">' +
        '<h3>我</h3>' +
        '<i class="bubble_sharp"></i>' +
        '<div class="talk_bubble">{content}' +
        '</div>' +
        '</div>' +
        ' <div class="col-md-2 "><img ucard="{uid}" class="avatar-img talk-avatar"' +
        'src="{avatar}"/>' +
        '</div> </div> </div>';

    var tpl_left = '<div class="row">' +
        '<div class="time"><span class="timespan">{ctime}</span></div>' +
        '<div class="row">' +
        '<div class="col-md-2 "><img ucard="{uid}" class="avatar-img talk-avatar"' +
        'src="{avatar}"/>' +
        '</div><div class="col-md-10 bubble_outter">' +
        '<h3>{username}</h3>' +
        '<i class="bubble_sharp"></i>' +
        '<div class="talk_bubble">{content}' +
        '</div></div></div></div>';
    var tpl = message.uid == mid ? tpl_right : tpl_left;
    $.each(message, function (index, value) {
        tpl = tpl.replace('{' + index + '}', value);
    });
    return tpl;
}


/**
 * 向聊天窗添加一条消息
 * 
 * @param html
 *            消息内容
 */
function chat_appendMessage(html) {
    $('#scrollContainer_chat').append(html);
    $('#scrollArea_chat').slimScroll({scrollTo: $('#scrollContainer_chat').height()});
    ucard();
}
/**
 * 渲染消息模板
 * 
 * @param message
 *            消息体
 * @param mid
 *            当前用户ID
 * @returns {string}
 */
function chat_fetchMessageTpl(message, mid) {
    var tpl_right = '<div class="row talk_right">' +
        '<div class="time"><span class="timespan">{ctime}</span></div>' +
        '<div class="row">' +
        '<div class="col-md-9 bubble_outter">' +
        '<h3>&nbsp;</h3><i class="bubble_sharp"></i>' +
        '<div class="talk_bubble">{content}' +
        '</div>' +
        '</div>' +
        ' <div class="col-md-3 "><img ucard="{uid}" class="avatar-img talk-avatar"' +
        'src="{avatar}"/>' +
        '</div> </div> </div>';

    var tpl_left = '<div class="row">' +
        '<div class="time"><span class="timespan">{ctime}</span></div>' +
        '<div class="row">' +
        '<div class="col-md-3 "><img ucard="{uid}" class="avatar-img talk-avatar"' +
        'src="{avatar}"/>' +
        '</div><div class="col-md-9 bubble_outter chat_bubble">' +
        '<h3>&nbsp;</h3><i class="bubble_sharp"></i>' +
        '<div class="talk_bubble">{content}' +
        '</div></div></div></div>';
    var tpl = message.uid == mid ? tpl_right : tpl_left;
    $.each(message, function (index, value) {
        tpl = tpl.replace('{' + index + '}', value);
    });
    return tpl;
}
function chat_clear_box() {
    $('#scrollContainer_chat').html('');
}
$(function () {
    $('#chat_content').keypress(function (e) {
        if (e.ctrlKey && e.which == 13 || e.which == 10) {
            chat_postMessage();
        }
    });
});
function chat_postMessage() {

    var myDate = new Date();
    $.post(U('Usercenter/Message/postMessage'), {talk_id: $('#chat_id').val(), content: $('#chat_content').val()}, function (msg) {
        chat_appendMessage(op_fetchMessageTpl({uid: MID, content: msg.content,
            avatar: myhead,
            ctime: myDate.toLocaleTimeString()}, MID));
        $('#chat_content').val('');
        $('#chat_content').focus();
    }, 'json');
}
function chat_exit(id) {
    if (confirm('确定退出该会话？退出后无法再主动加入。')) {
        if (typeof (id) == 'undefined') {
            id = $('#chat_id').val();
        } else {
        }
        $.post(U('Usercenter/Message/doDeleteTalk'), {talk_id: id}, function (msg) {
            if (msg.status) {
                $('#chat_box').hide();
                $('#chat_li_' + id).remove();
                op_success('成功退出会话。', '会话助手');
            }

        }, 'json');
    }

}

function open_chat_box(id) {
    $.get(U('Usercenter/Session/getSession'), {id: id}, function (data) {
        chat_clear_box();
        $('li', '#session_panel_main').removeClass();
        $('.badge_new', '#chat_li_' + id).remove();
        $('#chat_li_' + id).addClass('active');
        $('#chat_box').show();
        set_current_chat(data);
    }, 'json');
}

function prependSession(data) {
    var tpl = '<li id="chat_li_' +
        data.id + '"><div class="row"><div class="col-md-6"><a class="session_ico" title="' +
        data.title + '" onclick="open_chat_box(' + data.id + ')"><img src="' +
        data.ico + '" class="avatar-img" style="width: 45px;"><span class="badge_new">&nbsp;</span></a></div><div class="col-md-6"><div><a class="text-more" style="width: 100%" target="_blank" title="' +
        data.title + '">' +
        data.title + '</a></div><div><a onclick="' +
        "chat_exit(" + data.id + ")" +
        '"><i style="color: red" title="退出会话" class="glyphicon glyphicon-off"></i></a></div></div></div></li>';
    $('#session_panel_main .friend_list').prepend(tpl);
}
/**
 * 设置某个消息为未读
 * 
 * @param talk_id
 */
function setSessionUnread(talk_id) {
    if (typeof ($('#chat_li_' + talk_id).html()) != 'undefined') {// 当会话面板已经载入了
        if (typeof ($('#chat_li_' + talk_id).find('.badge_new').html()) != 'undefined') {// 检测是否已经存在新标记
            // 如果已经存在新标记
            return true;
        } else {
            $('#chat_li_' + talk_id).find('.session_ico').append('<span class="badge_new">&nbsp;</span>');
        }

    }

    // TODO tox设置某个session未读
}

function start_talk(uid) {
    if (confirm('确定要和该用户发起会话？')) {
        $.post(U('Usercenter/Session/createTalk'), {uids: uid}, function (data) {
            op_success('会话发起成功。', '会话助手');
            $('#friend_panel_main').toggle();
            $('#session_panel_main').toggle();
            open_chat_box(data.id);
            /* 在面板中加入一个项目 */
            prependSession(data);
        }, 'json');
    }
}

function set_current_chat(chat) {
    $('#chat_ico').attr('src', chat.ico);
    $('#chat_title').text(chat.title);
    $('#chat_id').val(chat.id);
    $.each(chat.messages, function (i, item) {
        chat_appendMessage(chat_fetchMessageTpl(item, MID));
    });
    chat_appendMessage('<hr/>' +
        '<div style="text-align: center;color: #666">以上为历史聊天记录</div>', MID);
}


/**
 * 绑定登出事件
 */
function bindLogout() {
    $('[event-node=logout]').click(function () {
        $.get(U('Usercenter/System/logout'), function (msg) {
            op_success(msg.message + '。', '温馨提示');
            setTimeout(function () {
                location.href = msg.url;
            }, 1500);
        }, 'json')
    });
}
function bindSupport() {
    $('.support_btn').unbind('click');
    $('.support_btn').click(function () {
        // event.stopPropagation();
        var me = $(this);
        if (MID == 0) {
            op_error('请在登陆后再点赞。即将跳转到登陆页。', '温馨提示');
            setTimeout(function () {
                location.href = U('Home/User/Login');
            }, 1500);
            return;
        } else {
            var row = $(this).attr('row');
            var table = $(this).attr('table');
            var uid = $(this).attr('uid');
            var jump = $(this).attr('jump');
            $.post(SUPPORT_URL, {appname: MODULE_NAME, row: row, table: table, uid: uid, jump: jump}, function (msg) {
                if (msg.status) {
                    var num_tag = $('#support_' + MODULE_NAME + '_' + table + '_' + row);
                    var pos = $('#support_' + MODULE_NAME + '_' + table + '_' + row + '_pos');
                    if (pos.text() == '') {
                        var html = '<span id="' + '#support_' + MODULE_NAME + '_' + table + '_' + row + '">1</span>';
                        pos.html('&nbsp;( ' + html + '&nbsp;)');

                    } else {
                        var num = num_tag.text();
                        num++;
                        num_tag.text(num);
                    }
                    var ico = me.find('#ico_like');
                    ico.removeClass();
                    ico.addClass('support_like');
                    op_success(msg.info, '温馨提示');

                } else {
                    op_error(msg.info, '温馨提示');
                }

            }, 'json');
        }

    });
}


$(function () {
    $('.weibo_content_quick').keypress(function (e) {
        if (e.ctrlKey && e.which == 13 || e.which == 10) {
            $(this).parents('.weibo_post_box').find(".send_weibo_button").click();
        }
    });
    $('#weibo_content').keypress(function (e) {
        if (e.ctrlKey && e.which == 13 || e.which == 10) {
           $(this).parents('.weibo_post_box').find(".send_weibo_button").click();
        }
    });


    // 点击发表微博按钮之后
    $('.send_weibo_button').click(function () {
        // 获取参数
        var url = $(this).attr('data-url');
        var content = $(this).parents('.weibo_post_box').find('#weibo_content').val();
        var button = $(this);
        var originalButtonText = button.val();
        var feedType = 'feed';
        var attach_ids = '';
        var $attach_ids = $(this).parents('.weibo_post_box').find('#attach_ids');
        if (typeof($attach_ids) != 'undefined' && $attach_ids.length > 0) {
            var feedType = 'image';
            var attach_ids = $attach_ids.val();
        }

        // 发送到服务器
        $.post(url, {content: content, type: feedType, attach_ids: attach_ids}, function (a) {
            handleAjax(a);
            if (a.status) {
                button.attr('class', 'btn btn-primary send_weibo_button');
                button.val(originalButtonText);
                if (MODULE_NAME == 'Weibo' && ACTION_NAME == 'index') {
                    reloadWeiboList();
                }

                clearWeibo();
                $('.XT_face').remove();
                insert_image.close();
                $('.mfp-close').click();
            }
        });
    });
})

function clearWeibo() {
    $('.weibo_post_box #weibo_content').val('');
}
<!--新浪微博分享代码-->
function weiboShare() {
    var wb_shareBtn = document.getElementById("weibo_shareBtn")
    wb_url = document.URL, // 获取当前页面地址，也可自定义例：wb_url =
							// "http://www.bluesdream.com"
        wb_appkey = "",
        wb_title = document.title,
        wb_ralateUid = "{:C('SHARE_WEIBO_ID')}",
        wb_pic = "",
        wb_language = "zh_cn";
    wb_shareBtn.setAttribute("href", "http://service.weibo.com/share/share.php?url=" + wb_url + "&appkey=" + wb_appkey + "&title=" + wb_title + "&pic=" + wb_pic + "&ralateUid=" + wb_ralateUid + "&language=" + wb_language + "");
}
<!--新浪微博分享代码end-->




/* 导航栏 */

$(function () {
    var nav = $("#nav_bar");
    var topMain = $("#top_bar").height() + $('#logo_bar').height();// 是头部的高度加头部与nav导航之间的距离
    $(window).scroll(function () {
        var top = $(document).scrollTop();
        if (top > topMain) {
            nav.addClass("nav_scroll");
           /* $('#weibo_filter').addClass('filter_attach'); */
        } else {
            nav.removeClass("nav_scroll");
   /* $('#weibo_filter').removeClass('filter_attach'); */
        }
    });
});
// FIXME tox 修正短页面滚至底部弹回
/* 导航栏end */

/* 微博表情 */

var insertFace = function (obj) {
    $('.XT_insert').css('z-index', '1000');
    $('.XT_face').remove();
    var html = '<div class="XT_face  XT_insert"><div class="triangle sanjiao"></div><div class="triangle_up sanjiao"></div>' +
        '<div class="XT_face_main"><div class="XT_face_title"><span class="XT_face_bt" style="float: left">常用表情</span>' +
        '<a onclick="close_face()" class="XT_face_close">X</a></div><div id="face" style="padding: 10px;"></div></div></div>';
    obj.parents('.weibo_post_box').find('#emot_content').html(html);
    getFace(obj);
};

var face_chose = function (obj) {
    var textarea = obj.parents('.emot_content').prev().find('textarea');
    textarea.focus();
    // textarea.val(textarea.val()+'['+obj.attr('title')+']');

    pos = getCursortPosition(textarea[0]);
    s = textarea.val();
    textarea.val(s.substring(0, pos) + '[' + obj.attr('title') + ']' + s.substring(pos));
    setCaretPosition(textarea[0], pos + 2 + obj.attr('title').length);
}

var getFace = function (obj) {
    $.post(U('Weibo/Index/getSmile'), {}, function (data) {
        var _imgHtml = '';
        for (var k in data) {
            _imgHtml += '<a href="javascript:void(0)" title="' + data[k].title + '" onclick="face_chose($(this))";><img src="' + data[k].src + '" width="24" height="24" /></a>';
        }
        _imgHtml += '<div class="c"></div>';
        obj.parent().parent().next().find('#face').html(_imgHtml);

    }, 'json');
}

var close_face = function () {
    $('.XT_face').remove();
}


function getCursortPosition(ctrl) {// 获取光标位置函数

    var CaretPos = 0;	// IE Support
    if (document.selection) {
        ctrl.focus();
        var Sel = document.selection.createRange();
        Sel.moveStart('character', -ctrl.value.length);
        CaretPos = Sel.text.length;
    }
    // Firefox support
    else if (ctrl.selectionStart || ctrl.selectionStart == '0')
        CaretPos = ctrl.selectionStart;
    return (CaretPos);
}

function setCaretPosition(ctrl, pos) {// 设置光标位置函数
    if (ctrl.setSelectionRange) {
        ctrl.focus();
        ctrl.setSelectionRange(pos, pos);
    }
    else if (ctrl.createTextRange) {
        var range = ctrl.createTextRange();
        range.collapse(true);
        range.moveEnd('character', pos);
        range.moveStart('character', pos);
        range.select();
    }
}

/* 微博表情end */
