<?php if (!defined('THINK_PATH')) exit();?>
<div class="col-xs-12  column-content">
	<div class="column-content-title">
		<i class="title-tip-box"></i> <span class="title-tip"><a
			href="<?php echo U('/live/hot');?>">热门直播</a></span> <span class="pull-right"> <a
			href="<?php echo U('/live/hot');?>">更多直播</a></span>
	</div>

</div>

<div class="col-xs-12  column-content">
<div class="live-list">
	<ul>
		<?php if(is_array($lives)): $i = 0; $__LIST__ = $lives;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$live): $mod = ($i % 2 );++$i;?><li>
			<div class="live-thumb">
				<a href="<?php echo U('/live/'.$live['id']);?>"> <img
					src="/Public/Core/images/placeholder.png"
					lazy-src="<?php echo query_picture('url',$live['cover']);?>"
					alt="<?php echo ($live['title']); ?>" width="216px" height="120px">
				</a>
				<div class="live-name">
					<span><?php echo ($live["title"]); ?></span>
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
</div>