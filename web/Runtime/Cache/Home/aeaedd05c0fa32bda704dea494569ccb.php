<?php if (!defined('THINK_PATH')) exit();?><div class="guess-list">
	<ul>
		<?php if(is_array($guesses)): $i = 0; $__LIST__ = $guesses;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$guess): $mod = ($i % 2 );++$i;?><li class="guess-item">
			<div class="guess-item-content">
				<div class="col-xs-4">
					<?php if($guess['blue_team']): ?><a
						href="<?php echo U('/matchgame/'.$guess['id']);?>"> <img
						src="/Public/Core/images/placeholder.png"
						lazy-src="<?php echo query_team('cover',$guess['blue_team']);?>"
						alt="<?php echo ($live['title']); ?>" width="50" height="50">
					</a> <?php else: ?>
					<div class="vs">弃权</div><?php endif; ?>
				</div>
				<div class="col-xs-4 vs">VS</div>
				<div class="col-xs-4">
					<?php if($guess['red_team']): ?><a
						href="<?php echo U('/matchgame/'.$guess['id']);?>"> <img
						src="/Public/Core/images/placeholder.png"
						lazy-src="<?php echo query_team('cover',$guess['red_team']);?>"
						alt="<?php echo ($live['title']); ?>" width="50" height="50">
					</a> <?php else: ?>
					<div class="vs">弃权</div><?php endif; ?>
				</div>
			</div>
			<div class="guess-team-name">
				<ul>
					<li><?php if($guess['blue_team']): ?><a
							href="<?php echo U('/team/'.$guess['blue_team']);?>"><?php echo query_team('name',$guess['blue_team']);?></a>
						<?php else: ?> 弃权<?php endif; ?></li>
					<li></li>
					<li><?php if($guess['red_team']): ?><a
							href="<?php echo U('/team/'.$guess['red_team']);?>"><?php echo query_team('name',$guess['red_team']);?></a>
						<?php else: ?> 弃权<?php endif; ?></li>
				</ul>
			</div>
			<div class="guess-item-des">
				<ul>
					<li><span class="pull-left"><a
							href="<?php echo U('/matchgame/'.$guess['id']);?>"><?php echo get_game($guess['game_id'],'title');?></a></span>
						<span class="pull-right"><?php echo date('m-d
							H:i',$guess['start_time']);?></span></li>
					<li><span class="pull-left"><a
							href="<?php echo U('/matchgame/'.$guess['id']);?>"><?php echo query_match('title',$guess['match_id']);?></a></span>
						<span class="pull-right"><a class="submit-guess"
							href="<?php echo U('/matchgame/'.$guess['id']);?>">竞猜</a></span></li>
				</ul>
			</div>
		</li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>