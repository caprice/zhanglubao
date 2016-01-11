<?php if (!defined('THINK_PATH')) exit();?><div class="hot-matches">

<ul>

	<?php if(is_array($hotmatches)): $i = 0; $__LIST__ = $hotmatches;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hotmatch): $mod = ($i % 2 );++$i;?><li>
	<div class="hot-match-team">
	<div class="col-xs-4">
	<?php if($hotmatch['blue_team']): ?><a
		href="<?php echo U('/matchgame/'.$hotmatch['id']);?>"> <img
		src="/Public/Core/images/placeholder.png"
		lazy-src="<?php echo query_team('cover',$hotmatch['blue_team']);?>"
		  width="50" height="50"> </a>
		<?php else: ?>
		<div class="vs">弃权</div><?php endif; ?>
		
		</div>
	<div class="col-xs-4 vs">VS</div>
	<div class="col-xs-4">
	<?php if($hotmatch['red_team']): ?><a
		href="<?php echo U('/matchgame/'.$hotmatch['id']);?>"> <img
		src="/Public/Core/images/placeholder.png"
		lazy-src="<?php echo query_team('cover',$hotmatch['red_team']);?>"
		  width="50" height="50"> </a>
			<?php else: ?>
		<div class="vs">弃权</div><?php endif; ?>
		
		</div>

	</div>
	<div class="hot-match-team-name">

	<ul>
	 <li>
	 
 
			
			
				<?php if($hotmatch['blue_team']): ?><a
		href="<?php echo U('/matchgame/'.$hotmatch['id']);?>"><?php echo query_team('name',$hotmatch['blue_team']);?></a>
		<?php else: ?>
		 弃权<?php endif; ?>
		
			
			</li>
			<li></li>
		 <li>
		 
		
			
			
				<?php if($hotmatch['red_team']): ?><a
		href="<?php echo U('/matchgame/'.$hotmatch['id']);?>"><?php echo query_team('name',$hotmatch['red_team']);?></a>
			<?php else: ?>
		弃权<?php endif; ?>
		
			</li>

	</ul>
	</div>
	<div class="hot-match-item-des">
	<ul>


		<li><span class="pull-left">	<a
		href="<?php echo U('/matchgame/'.$hotmatch['id']);?>"><?php echo get_game($hotmatch['game_id'],'title');?></a></span>
		<span class="pull-right"> <?php switch($hotmatch['game_status']): case "0": ?>未开始<?php break;?> <?php case "1": ?>正在进行<?php break;?> <?php case "2": ?>已结束<?php break; endswitch;?> </span></li>

		<li><span class="match-item-des-left">	<a
		href="<?php echo U('/matchgame/'.$hotmatch['id']);?>"><?php echo query_match('title',$hotmatch['match_id']);?></a></span>

		<span class="match-item-des-right"><?php echo date('m-d
		H:i',$hotmatch['start_time']);?></span></li>
		
	 

	</ul>
	</div>
	</li><?php endforeach; endif; else: echo "" ;endif; ?>

</ul>

</div>