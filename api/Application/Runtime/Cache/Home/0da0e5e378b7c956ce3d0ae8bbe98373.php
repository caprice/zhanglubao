<?php if (!defined('THINK_PATH')) exit();?><div class="h">
	<h2>热门解说</h2>
</div>
<div class="sline"></div>
<div class="cmts">
	<ul>
		<?php if(is_array($users)): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('/'.$user['uid'].'@u');?>" target="_blank"
			class="mavatar"><img src="/Public/Static/images/placeholder.png"
				lazy-src="<?php echo ($user["avatar_mid_url"]); ?>"></a><a
			href="<?php echo U('/'.$user['uid'].'@u');?>" target="_blank" class="t"><?php echo ($user["nickname"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>