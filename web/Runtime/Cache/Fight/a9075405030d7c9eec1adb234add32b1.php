<?php if (!defined('THINK_PATH')) exit();?>
<div class="col-xs-12  column-content">
	<div class="column-content-title">
		<i class="title-tip-box"></i> <span class="title-tip"><a
			href="<?php echo U('/fight/games');?>">热门游戏</a></span> <span class="pull-right"> <a
			href="<?php echo U('/fight/games');?>">更多游戏</a></span>
	</div>

</div>

<div class="col-xs-12  column-content">
	<div class="game-list">
		<ul>
			<?php if(is_array($games)): $i = 0; $__LIST__ = $games;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$game): $mod = ($i % 2 );++$i;?><li>
				<div>
					<a href="<?php echo U('/fight/list/'.$game['id']);?>"> <img
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
</div>