<?php if (!defined('THINK_PATH')) exit();?><div class="h">
	<h2>推荐视频</h2>
</div>
<div class="sline"></div>
<div class="recs">
	<ul>

		<?php if(is_array($siderecs)): $k = 0; $__LIST__ = $siderecs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$recvideo): $mod = ($k % 2 );++$k;?><li><label class="hot"><?php echo ($k); ?></label> <span class="name"><a
				target="_blank" href="<?php echo ($recvideo['rec_url']); ?>"><?php echo ($recvideo["rec_title"]); ?></a></span></li><?php endforeach; endif; else: echo "" ;endif; ?>

	</ul>

</div>