<?php if (!defined('THINK_PATH')) exit();?>
<div class="col-xs-12  column-content">
	<div class="column-content-title">
		<i class="title-tip-box"></i> <span class="title-tip"><a
			href="<?php echo U('/fight/list/hot');?>">最新挑战</a></span> <span class="pull-right">
			<a href="<?php echo U('/fight/list/hot');?>">更多挑战</a>
		</span>
	</div>

</div>

<div class="col-xs-12  column-content">
	<div class="fight-list">
		<ul>
			<?php if(is_array($fights)): $i = 0; $__LIST__ = $fights;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fight): $mod = ($i % 2 );++$i;?><li>
				<div class="fight-info">

					<div class="fight-info-member">
						<a href="<?php echo U('/fight/'.$fight['id']);?>"><img
							src="/Public/Core/images/placeholder.png"
							lazy-src="<?php echo ($fight['host']['avatar']); ?>" width="69" height="69"></a>
					</div>
					<div class="fight-info-member vs">VS</div>
					<div class="fight-info-member">
						<?php if($fight['guest']): ?><a
							href="<?php echo U('/fight/'.$fight['id']);?>"><img
							src="/Public/Core/images/placeholder.png"
							lazy-src="<?php echo ($fight['guest']['avatar']); ?>" width="69" height="69"></a>
						<?php else: ?> 
						
						
						<span class="fight-invite"><a
							href="<?php echo U('/fight/'.$fight['id']);?>">战</a></span><?php endif; ?>



					</div>
				</div>
				
				<div class="fight-info-name">
				<div class="fight-member-name">
						<a href="<?php echo U('/fight/'.$fight['id']);?>"><?php echo ($fight['host']['username']); ?></a>
					</div>
						<div class="fight-member-name">
					</div>
						<div class="fight-member-name">
						
						<?php if($fight['guest']): ?><a href="<?php echo U('/fight/'.$fight['id']);?>"><?php echo ($fight['host']['username']); ?></a><?php endif; ?>
						
					</div>
				
				</div>
				<div class="fight-des">
				<span class="fight-coin">金币: <?php echo ($fight['fight_coins']); ?></span>
				<span class="fight-game"><?php echo get_game($fight['game_id'],'title');?></span>
				</div>

			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
</div>