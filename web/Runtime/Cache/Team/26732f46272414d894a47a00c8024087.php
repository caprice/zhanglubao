<?php if (!defined('THINK_PATH')) exit();?><div class="triangle"></div>
<div class="triangle_up"></div>
<div class="lzl">
    <div class="lzl_Reply" id="lzl_reply_list_<?php echo ($to_f_reply_id); ?>">

    </div>

<div class="clearfix"></div>
    <div>
    <a href="javascript:" class="pull-right show_textarea" args="<?php echo ($to_f_reply_id); ?>" >我也说几句</a>
    </div>
    <div id="show_textarea_<?php echo ($to_f_reply_id); ?>" <?php if(($count) != "0"): ?>style="display: none"<?php endif; ?>>
    <div id="myavatar_<?php echo ($to_f_reply_id); ?>"  class="XT_my_avatar">
        <a href="<?php echo ($myInfo["space_url"]); ?>" ucard="<?php echo ($myInfo["uid"]); ?>"> <img src="<?php echo ($myInfo["avatar"]); ?>" class="avatar-img" style="width:100%;"/></a>
    </div>
    <div id="textarea_<?php echo ($to_f_reply_id); ?>" style="margin-left: 50px;">
        <textarea  id="reply_<?php echo ($to_f_reply_id); ?>" tip="1" args="<?php echo ($to_f_reply_id); ?>"  class="input_tips" style="overflow-y: hidden;"></textarea>
    </div>
    <div class="XT_submit"><a id="submit_<?php echo ($to_f_reply_id); ?>" href="javascript:" post_id="<?php echo ($post_id); ?>" args="to_f_reply_id=<?php echo ($to_f_reply_id); ?>&to_reply_id=0&to_uid=<?php echo ($reply_uid); ?>&p=<?php echo ($p); ?>" class="submitReply pull-right btn btn-primary">提交 Ctrl+Enter</a></div>
</div>
</div>

<script>
$(function(){
    $('#lzl_reply_list_<?php echo ($to_f_reply_id); ?>').load(U('Team/LZL/lzllist',['to_f_reply_id',"<?php echo ($to_f_reply_id); ?>"], true),function(){
        ucard()
    });
    //var $inputor = $('#reply_<?php echo ($to_f_reply_id); ?>').atwho(atwho_config);
})

</script>