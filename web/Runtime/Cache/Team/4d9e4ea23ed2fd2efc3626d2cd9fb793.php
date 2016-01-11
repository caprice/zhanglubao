<?php if (!defined('THINK_PATH')) exit();?>
<div class="row">
	<div class="col-xs-12  column-content">
		<div class="column-content-title">
			<i class="title-tip-box"></i> <span class="title-tip">最近比赛</span>
		</div>
		<div class="matches column-content">
			<ul>
				<?php if(is_array($matches)): $i = 0; $__LIST__ = $matches;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$match): $mod = ($i % 2 );++$i;?><li>
					<div class="match-team">
						<div class="col-xs-4">
							<?php if($match['blue_team']): ?><a
								href="<?php echo U('/matchgame/'.$match['id']);?>"> <img
								src="/Public/Core/images/placeholder.png"
								lazy-src="<?php echo query_team('cover',$match['blue_team']);?>"
								alt="<?php echo ($live['title']); ?>" width="50" height="50">
							</a> <?php else: ?>
							<div class="vs">弃权</div><?php endif; ?>
						</div>
						<div class="col-xs-4 vs">VS</div>
						<div class="col-xs-4">
							<?php if($match['red_team']): ?><a
								href="<?php echo U('/matchgame/'.$match['id']);?>"> <img
								src="/Public/Core/images/placeholder.png"
								lazy-src="<?php echo query_team('cover',$match['red_team']);?>"
								alt="<?php echo ($live['title']); ?>" width="50" height="50">
							</a> <?php else: ?>
							<div class="vs">弃权</div><?php endif; ?>
						</div>
					</div>
					<div class="match-team-name">
						<ul>
							<li><?php if($match['blue_team']): ?><a
									href="<?php echo U('/team/'.$match['blue_team']);?>"><?php echo query_team('name',$match['blue_team']);?></a>
								<?php else: ?> 弃权<?php endif; ?></li>
							<li></li>
							<li><?php if($match['red_team']): ?><a
									href="<?php echo U('/team/'.$match['red_team']);?>"><?php echo query_team('name',$match['red_team']);?></a>
								<?php else: ?> 弃权<?php endif; ?></li>
						</ul>
					</div>
					<div class="match-item-des">
						<ul>
							<li><span class="pull-left"><a
									href="<?php echo U('/matchgame/'.$match['id']);?>"><?php echo get_game($match['game_id'],'title');?></a></span>
								<span class="pull-right"> <?php switch($match['game_status']): case "0": ?>未开始<?php break;?> <?php case "1": ?>正在进行<?php break;?> <?php case "2": ?>已结束<?php break; endswitch;?>
							</span></li>

							<li><span class="match-item-des-left"><a
									href="<?php echo U('/matchgame/'.$match['id']);?>"><?php echo query_match('title',$match['match_id']);?></a></span>

								<span class="match-item-des-right"><?php echo date('m-d
									H:i',$match['start_time']);?></span></li>
						</ul>
					</div>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
	</div>
	</div>