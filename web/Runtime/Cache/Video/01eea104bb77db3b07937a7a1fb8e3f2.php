<?php if (!defined('THINK_PATH')) exit();?><div class="video-list">
	<ul>
		<?php if(is_array($dotas)): $i = 0; $__LIST__ = $dotas;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dota): $mod = ($i % 2 );++$i;?><li>
			<div class="video-thumb">
				<a href="<?php echo U('/video/'.$dota['id']);?>"> <img
					src="/Public/Core/images/placeholder.png"
					lazy-src="<?php echo query_picture('url',$dota['cover']);?>"
					alt="<?php echo ($dota['title']); ?>" width="216px" height="120px">
				</a>
				<div class="video-name">
					<span><?php echo ($dota['title']); ?></span>
				</div>
			</div>
			<div class="video-des">
				<span class="pull-left"> <span
					class="glyphicon glyphicon-user "></span> <span
					class="game-des-online"><?php echo ($dota['views']); ?>人</span></span> <span
					class="pull-right "> <?php echo get_game($dota['game_id'],'title');?> </span>
			</div>
		</li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>