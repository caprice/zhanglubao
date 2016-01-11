<?php if (!defined('THINK_PATH')) exit();?><div class="commentators">
	<ul>
		<?php if(is_array($commentators)): $i = 0; $__LIST__ = $commentators;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$commentator): $mod = ($i % 2 );++$i;?><li><?php $user = query_user(array('avatar','username'),$commentator['uid']); ?>

			<div class="commentators-thumb">
				<a href="<?php echo U('/commentator/'.$commentator['id']);?>"><img
					src="/Public/Core/images/placeholder.png"
					lazy-src="<?php echo ($user["avatar"]); ?>" height="84" width="84" /> </a>
			</div>
			<div class="commentators-des"><?php echo ($user["username"]); ?></div></li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>