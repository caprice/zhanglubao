<?php if (!defined('THINK_PATH')) exit();?><div class="team-list">
	<ul>
		<?php if(is_array($teams)): $i = 0; $__LIST__ = $teams;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$team): $mod = ($i % 2 );++$i;?><li>
			<div class="team-thumb">
				<a href="<?php echo U('/team/'.$team['id']);?>"> <img
					src="/Public/Core/images/placeholder.png"
					lazy-src="<?php echo query_picture('url',$team['cover']);?>"
					alt="<?php echo ($team['name']); ?>" width="140" height="140">
				</a>
			</div>
			<div class="team-name">
				<span><?php echo ($team['name']); ?></span>
			</div>
		</li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>