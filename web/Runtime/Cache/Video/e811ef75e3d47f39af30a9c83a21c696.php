<?php if (!defined('THINK_PATH')) exit();?>
<div class="row">
	<div class="col-xs-12  column-content">
		<div class="column-content-title">
			<i class="title-tip-box"></i> <span class="title-tip"><a
				href="<?php echo U('/commentator/list');?>">热门解说</a></span> <span class="pull-right">
				<a href="<?php echo U('/commentator/list');?>">更多解说</a>
			</span>
		</div>

		<div class="commentators">
			<ul>
				<?php if(is_array($commentators)): $i = 0; $__LIST__ = $commentators;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$commentator): $mod = ($i % 2 );++$i;?><li><?php $user = query_user(array('avatar','username'),$commentator['uid']); ?>

					<div class="commentators-thumb">
						<a href="<?php echo U('/u/'.$commentator['uid']);?>"><img
							src="/Public/Core/images/placeholder.png"
							lazy-src="<?php echo ($user["avatar"]); ?>" height="84" width="84" /> </a>
					</div>
					<div class="commentators-des"><?php echo ($user["username"]); ?></div></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
	</div>
</div>