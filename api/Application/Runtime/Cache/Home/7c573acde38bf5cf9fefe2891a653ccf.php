<?php if (!defined('THINK_PATH')) exit();?><div class="h">
	<h2>热门比赛</h2>
</div>
<div class="sline"></div>
<div class="matches">
	<ul>
		<?php if(is_array($matches)): $i = 0; $__LIST__ = $matches;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$match): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('/'.$match['uid'].'@u');?>" target="_blank"
			class="mavatar"><img src="/Public/Static/images/placeholder.png"
				lazy-src="<?php echo ($match["avatar_mid_url"]); ?>"></a><a
			href="<?php echo U('/'.$match['uid'].'@u');?>" target="_blank" class="t"><?php echo ($match["nickname"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>