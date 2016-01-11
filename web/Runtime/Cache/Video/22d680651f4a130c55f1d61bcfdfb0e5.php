<?php if (!defined('THINK_PATH')) exit();?><div class="lol-row">
	<div class="lol-left">
		<?php if(is_array($reclols)): $i = 0; $__LIST__ = $reclols;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$reclol): $mod = ($i % 2 );++$i;?><div class="lol-rec-row">
			<div class="lol-big-thumb">
				<a class="mod_poster" href="<?php echo U('/video/'.$reclol['id']);?>"> <img
					src="/Public/Core/images/placeholder.png"
					lazy-src="<?php echo query_picture('url',$reclol['cover']);?>"
					alt="<?php echo ($reclol['title']); ?>" width="350px" />
				</a>
				<div class="lol-name">
					<span><?php echo ($reclol['title']); ?> </span>
				</div>
			</div>
			<div class="lol-des">
				<span class="pull-left"> <span
					class="glyphicon glyphicon-facetime-video "></span> <span
					class="game-des-online"><?php echo ($reclol['views']); ?>人</span></span> <span
					class="pull-right ">
					<?php echo get_game($reclol['game_id'],'title');?> </span>
			</div>
		</div><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
	<div class="lol-right">
		<div class="lol-list">
			<ul>
				<?php if(is_array($lols)): $i = 0; $__LIST__ = $lols;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lol): $mod = ($i % 2 );++$i;?><li>
					<div class="lol-thumb">
						<a href="<?php echo U('/video/'.$lol['id']);?>"> <img
							src="/Public/Core/images/placeholder.png"
							lazy-src="<?php echo query_picture('url',$lol['cover']);?>"
							alt="<?php echo ($lol['title']); ?>" width="160px" height="90px">
						</a>
						<div class="lol-name">
							<span><a href="<?php echo U('/video/'.$lol['id']);?>"><?php echo ($lol['title']); ?></a></span>
						</div>
					</div>
					<div class="lol-des">
						<span class="pull-left"> <span
							class="glyphicon glyphicon-facetime-video  "></span> <span
							class="game-des-online"><?php echo ($lol['views']); ?>人</span></span> <span
							class="pull-right ">
							<?php echo get_game($lol['game_id'],'title');?></span>
					</div>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
	</div>
</div>