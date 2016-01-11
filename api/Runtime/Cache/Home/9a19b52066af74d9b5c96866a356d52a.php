<?php if (!defined('THINK_PATH')) exit();?><div class="h">
	<h2>热门战队</h2>
</div>
<div class="sline"></div>
<div class="teams">
	<ul>
		<?php if(is_array($teams)): $i = 0; $__LIST__ = $teams;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$team): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('/'.$team['uid'].'@u');?>" target="_blank"
			class="mavatar"><img src="/Public/Static/images/placeholder.png"
				lazy-src="<?php echo ($team["avatar_mid_url"]); ?>"></a><a
			href="<?php echo U('/'.$team['uid'].'@u');?>" target="_blank" class="t"><?php echo ($team["nickname"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>