<?php if (!defined('THINK_PATH')) exit();?><div class="fight-list">
	<ul>
		<?php if(is_array($fights)): $i = 0; $__LIST__ = $fights;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fight): $mod = ($i % 2 );++$i;?><li>
			<div class="fihght-thumb">
				<div>
					<a href="<?php echo U('/fight/'.$fight['id']);?>"><img
						src="/Public/Core/images/placeholder.png"
						lazy-src="<?php echo query_user('avatar',$fight['host_uid']);?>" height="83"
						width="83" /> </a>
					<div class="fihght-des"><?php echo get_username($fight['host_uid']);?></div>
				</div>
			</div>
			<div class="fight-info">
				<div class="fight-info-line">
					<span class="pull-left info-name"><a
						href="<?php echo U('/fight/'.$fight['id']);?>"><?php echo get_game($fight['game_id'],'title');?></a></span>
					<span class="pull-right"><?php echo ($fight['game_area']); ?></span>
				</div>
				<div class="fight-info-line">
					<span class="pull-left info-name"><?php echo get_username($fight['host_uid']);?></span>

					<span class="pull-right info-name "> <?php switch($fight['fight_type']): case "0": ?>单挑<?php break;?>
						<?php case "1": ?>群挑<?php break; endswitch;?>
					</span>
				</div>
				<div class="pull-all for fight-info-line">
					<span class="pull-left info-name">押币:<?php echo ($fight['fight_coins']); ?>金币</span>
					<span class="pull-right"><a
						href="<?php echo U('fight/'.$fight['id']);?>">竞猜</a></span>
				</div>
				<div class="fight-info-line">
					<span class="pull-left info-name"><?php echo date('m-d
						H:i',$fight['start_time']);?></span> <span class="pull-right"><a
						href="<?php echo U('fight/'.$fight['id']);?>">应战</a></span>
				</div>
			</div>
		</li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>