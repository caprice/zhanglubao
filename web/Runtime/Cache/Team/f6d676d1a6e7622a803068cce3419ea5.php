<?php if (!defined('THINK_PATH')) exit();?><ul>
    <?php if(is_array($lzlList)): $k = 0; $__LIST__ = $lzlList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li id="forum_lzl_reply_<?php echo ($vo["id"]); ?>" class="show_<?php echo ($to_f_reply_id); ?> lzl_reply_list" style="<?php if( $nowPage == 1 and $k > 3 and $k <= $limit): ?>display:none;<?php endif; ?>">

		<div class="XT_list_avatar">
			<a href="<?php echo ($vo["userInfo"]["space_url"]); ?>" ucard="<?php echo ($vo["userInfo"]["uid"]); ?>"> <img
				src="<?php echo ($vo["userInfo"]["avatar"]); ?>" width="40px" height="40px"
				class="avatar-img" /></a>
		</div>
		<div class="XT_list_content">
			<p>
				<a href="<?php echo ($vo["userInfo"]["space_url"]); ?>" ucard="<?php echo ($vo["userInfo"]["uid"]); ?>">
					<?php echo ($vo["userInfo"]["username"]); ?></a>
			</p>

			<p><?php echo (parse_at_users($vo["content"])); ?></p>

			<p style="color: #ccc;">
				<?php echo (time_format($vo["ctime"])); ?>  

				<?php if(CheckPermission(array($vo['uid']))): ?><a href="javascript:"
					class="del_lzl_reply pull-right"
					args="lzl_reply_id=<?php echo ($vo["id"]); ?>&to_f_reply_id=<?php echo ($to_f_reply_id); ?>">删除</a><?php endif; ?>

			</p>


		</div>
		<div class="clearfix"></div>

	</li><?php endforeach; endif; else: echo "" ;endif; ?>

</ul>

<script type="text/javascript">

$(function () {

$('.del_lzl_reply').click(function (event) {
    if(confirm('确定要删除该回复么？')){
        var args = getArgs($(this).attr('args'));
        var to_f_reply_id = args['to_f_reply_id'];
        var url =U('Team/LZL/delLZLReply');
        $.post(url, {id: args['lzl_reply_id']}, function (msg) {
            if (msg.status) {
                op_success('删除成功', '温馨提示');
                 $('#forum_lzl_reply_'+args['lzl_reply_id']).hide();
                $('#reply_' + to_f_reply_id).val('');
                $('#reply_btn_'+msg.post_reply_id).html('回复('+msg.lzl_reply_count+')');
            } else {
                op_error('删除失败', '温馨提示');
            }
        });
    }
    event.preventDefault();
});
});
</script>


<?php if($nowPage == 1 and $count > 3): ?><span class="pull-left XT_reply_count" id="show_<?php echo ($to_f_reply_id); ?>">
     还有<?php echo ($totalCount-3); ?>条回复，<a href="javascript:"
                             onclick="$('.show_<?php echo ($to_f_reply_id); ?>').slideDown('normal');$('#show_<?php echo ($to_f_reply_id); ?>').hide();$('#pagination_<?php echo ($to_f_reply_id); ?>').show();">点击查看</a>
    </span><?php endif; ?>
<div class="pagination" id="pagination_<?php echo ($to_f_reply_id); ?>"
     style="margin-left: 40px;<?php if($nowPage == 1): ?>display:none;<?php endif; ?>">
    <?php echo ($html); ?>
</div>

<script>
    function changePage(id, p) {
        $('#lzl_reply_list_' + id).load(U('Team/LZL/lzllist',['to_f_reply_id',id,'page',p], true), function () {
            ucard();
        })
    }
</script>