<?php if (!defined('THINK_PATH')) exit();?><div class="row">
	<div class="col-xs-12  column-content">
		<div class="column-content-title">
			<i class="title-tip-box"></i> <span class="title-tip"><a
				href="<?php echo U('/live/list');?>">新来主播</a></span> <span class="pull-right"> <a href="<?php echo U('/live/list');?>">更多主播</a></span>
		</div>
		<div class="anchors">
			<ul>
				<?php if(is_array($newanchors)): $i = 0; $__LIST__ = $newanchors;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$newanchor): $mod = ($i % 2 );++$i;?><li><?php $user = query_user(array('avatar','username'),$newanchor['uid']); ?>

					<div class="anchors-thumb">
						<a href="<?php echo U('/live/'.$newanchor['id']);?>"><img
							src="/Public/Core/images/placeholder.png"
							lazy-src="<?php echo ($user["avatar"]); ?>" height="84" width="84" /> </a>
					</div>
					<div class="anchors-des"><?php echo ($user["username"]); ?></div></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
	</div>
</div>