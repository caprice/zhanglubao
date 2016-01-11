<?php if (!defined('THINK_PATH')) exit();?>
<div class="col-xs-12  column-content">
	<div class="column-content-title">
		<i class="title-tip-box"></i> <span class="title-tip">热门讨论</span> </span>
	</div>

</div>

<div class="col-xs-12  column-content">
	<div class="forum-list">
		<ul>
			<?php if(is_array($posts)): $i = 0; $__LIST__ = $posts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$post): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('/Team/Forum/detail/id/'.$post['id']);?>"> <span
					class="pull-left"><?php echo ($post["title"]); ?></span><span class="pull-right"><?php echo ($post["forum_name"]); ?></span>
			</a></li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
</div>