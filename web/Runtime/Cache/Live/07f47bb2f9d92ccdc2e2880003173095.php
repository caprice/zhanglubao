<?php if (!defined('THINK_PATH')) exit();?><div class="game-list">

	<ul>

		<?php if(is_array($games)): $i = 0; $__LIST__ = $games;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$game): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('/game/'.$game['id']);?>"><?php echo ($game["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
		<li><a href="<?php echo U('/live/list');?>">所有游戏</a></li>
	</ul>

</div>