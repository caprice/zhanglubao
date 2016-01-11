<?php if (!defined('THINK_PATH')) exit();?><div class="live-list">
	<ul>
		<?php if(is_array($lives)): $i = 0; $__LIST__ = $lives;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$live): $mod = ($i % 2 );++$i;?><li>
			<div class="live-thumb">
				<a href="<?php echo U('/live/'.$live['id']);?>"> <img
					src="/Public/Core/images/placeholder.png"
					lazy-src="<?php echo query_picture('url',$live['cover']);?>"
					alt="<?php echo ($live['title']); ?>" width="216px" height="120px">
				</a>
				<div class="live-name">
					<span><?php echo get_username($live['uid']);?></span>
				</div>
			</div>
			<div class="live-des">
				<span class="pull-left"> <span
					class="glyphicon glyphicon-user "></span> <span
					class="game-des-online"><?php echo ($live['online_membes']); ?>人</span></span> <span
					class="pull-right "> <?php echo get_game($live['game_id'],'title');?> </span>
			</div>
		</li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>