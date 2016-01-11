<?php if (!defined('THINK_PATH')) exit();?><div class="hots">
	<ul>
		<?php if(is_array($hotusers)): $i = 0; $__LIST__ = $hotusers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hotuser): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('/'.$hotuser['uid'].'@u');?>" target="_blank" class="mavatar"><img
				src="/Public/Static/images/placeholder.png"
				lazy-src="<?php echo ($hotuser["avatar_mid_url"]); ?>"></a><a href="<?php echo U('/'.$hotuser['uid'].'@u');?>"
			target="_blank" class="t"><?php echo ($hotuser["nickname"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>