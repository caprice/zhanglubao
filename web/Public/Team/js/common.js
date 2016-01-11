$(function () {

    var reply_btn = $('.reply_btn');
    
    reply_btn.click(function () {

        var args = getArgs($(this).attr('args'));
        var to_f_reply_id = args['to_f_reply_id'];
        $('#show_textarea_' + to_f_reply_id).show();

        $('#reply_' + to_f_reply_id).val('回复@' + args['to_nickname'] + ' ：');
        $('#submit_' + to_f_reply_id).attr('args', $(this).attr('args'));

    });


    $('.input_tips').keypress(function (e) {
        if (e.ctrlKey && e.which == 13 || e.which == 10) {
            var re = $(this).attr('args');
            var args = getArgs($('#submit_' + re).attr('args'));

            var to_f_reply_id = args['to_f_reply_id'];
            var post_id = $('#submit_' + re).attr('post_id');
            var content = $('#reply_' + to_f_reply_id).val();
            var to_reply_id = args['to_reply_id'];
            var to_uid = args['to_uid'];
            submitLZLReply(post_id, to_f_reply_id, to_reply_id, to_uid, content);
        }
       // this.preventDefault();
    });

    var submitLZLReply = function (post_id, to_f_reply_id, to_reply_id, to_uid, content,p) {
        var url =U('Team/LZL/doSendLZLReply');

        $.post(url, {post_id: post_id, to_f_reply_id: to_f_reply_id, to_reply_id: to_reply_id, to_uid: to_uid, content: content,p:p}, function (msg) {
            if (msg.status) {
                op_success(msg.info, '温馨提示');
                $('#lzl_reply_list_' + to_f_reply_id).load(U('Team/LZL/lzlList',['to_f_reply_id',to_f_reply_id,'page',msg.url], true), function () {
                    ucard()
                })
                $('#reply_' + to_f_reply_id).val('');
            } else {
                op_error(msg.info, '温馨提示');
            }
        },'json');
    };
    
    
    $(".submitReply").click(function (event) {
        var args = getArgs($(this).attr('args'));
        var to_f_reply_id = args['to_f_reply_id'];
        var post_id = $(this).attr('post_id');
        var content = $('#reply_' + to_f_reply_id).val();
        var to_reply_id = args['to_reply_id'];
        var to_uid = args['to_uid'];
        var p = args['p'];
        submitLZLReply(post_id, to_f_reply_id, to_reply_id, to_uid, content,p);
        event.preventDefault();
    });
    
    
    

    $('.reply_btn').click(function (event) {
        var args = $(this).attr('args');
        $('#lzl_reply_div_' + args).toggle();
        //event.preventDefault();
        event.preventDefault();
    });

    $('.show_textarea').click(function (event) {
        var args = $(this).attr('args');
        $('#show_textarea_' + args).toggle();
        event.preventDefault();
    });


//    $('.del_lzl_reply').click(function (event) {
//        if(confirm('确定要删除该回复么？')){
//            var args = getArgs($(this).attr('args'));
//            var to_f_reply_id = args['to_f_reply_id'];
//            var url =U('Team/LZL/delLZLReply');
//            $.post(url, {id: args['lzl_reply_id']}, function (msg) {
//                if (msg.status) {
//                    op_success('删除成功', '温馨提示');
//                     $('#forum_lzl_reply_'+args['lzl_reply_id']).hide();
//                    $('#reply_' + to_f_reply_id).val('');
//                    $('#reply_btn_'+msg.post_reply_id).html('回复('+msg.lzl_reply_count+')');
//                } else {
//                    op_error('删除失败', '温馨提示');
//                }
//            });
//        }
//        event.preventDefault();
//    });

    $('.del_reply_btn').click(function (event) {
        if(confirm('确定要删除该回复么？')){
            var args = getArgs($(this).attr('args'));
            var url =U('Team/Index/delPostReply');
            $.post(url, {id: args['reply_id']}, function (msg) {
                if (msg.status) {
                    op_success('删除成功', '温馨提示');
                   location.reload();
                } else {
                    op_error('删除失败', '温馨提示');
                }
            });

        }
        event.preventDefault();
    });

});






var getArgs = function (uri) {
    if (!uri) return {};
    var obj = {},
        args = uri.split("&"),
        l, arg;
    l = args.length;
    while (l-- > 0) {
        arg = args[l];
        if (!arg) {
            continue;
        }
        arg = arg.split("=");
        obj[arg[0]] = arg[1];
    }
    return obj;
};

