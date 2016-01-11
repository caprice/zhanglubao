<?php if (!defined('THINK_PATH')) exit();?><div class="game-list">
	<ul>
		<?php if(is_array($games)): $i = 0; $__LIST__ = $games;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$game): $mod = ($i % 2 );++$i;?><li>
			<div>
				<a href="<?php echo U('/game/'.$game['name']);?>"> <img
					src="/Public/Core/images/placeholder.png"
					lazy-src="<?php echo query_picture('url',$game['cover']);?>"
					alt="<?php echo ($game['title']); ?>" width="170" height="220">
				</a>
			</div>
			<div class="game-des">
				<span class="pull-left"><?php echo ($game['title']); ?></span> <span
					class="pull-right"> <span
					class="glyphicon glyphicon-user clo"></span> <span
					class="game-des-online"><?php echo ($game['online_member']); ?>人</span>
				</span>
			</div>
		</li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>