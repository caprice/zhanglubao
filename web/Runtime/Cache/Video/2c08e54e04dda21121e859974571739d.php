<?php if (!defined('THINK_PATH')) exit();?><div class="video-list">
	<ul>
		<?php if(is_array($hots)): $i = 0; $__LIST__ = $hots;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hot): $mod = ($i % 2 );++$i;?><li>
			<div class="video-thumb">
				<a href="<?php echo U('/video/'.$hot['id']);?>"> <img
					src="/Public/Core/images/placeholder.png"
					lazy-src="<?php echo query_picture('url',$hot['cover']);?>"
					alt="<?php echo ($hot['title']); ?>" width="216px" height="120px">
				</a>
				<div class="video-name">
					<span><?php echo ($hot['title']); ?></span>
				</div>
			</div>
			<div class="video-des">
				<span class="pull-left"> <span
					class="glyphicon glyphicon-user "></span> <span
					class="game-des-online"><?php echo ($hot['views']); ?>人</span></span> <span
					class="pull-right "> <?php echo get_game($hot['game_id'],'title');?> </span>
			</div>
		</li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>