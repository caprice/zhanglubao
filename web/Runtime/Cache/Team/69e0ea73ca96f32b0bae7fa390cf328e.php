<?php if (!defined('THINK_PATH')) exit();?>
<div class="col-xs-12  column-content">
	<div class="column-content-title">
		<i class="title-tip-box"></i> <span class="title-tip">最新战队</span> <span class="pull-right"></span>
	</div>

</div>

<div class="col-xs-12  column-content">
	<div class="team-list">
		<ul>
			<?php if(is_array($teams)): $i = 0; $__LIST__ = $teams;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$team): $mod = ($i % 2 );++$i;?><li>
	<div class="cl">
				 <div class="team-icon">
				 
				 		<a href="<?php echo U('/team/'.$team['id']);?>"> <img
						src="/Public/Core/images/placeholder.png"
						lazy-src="<?php echo (get_cover($team["cover"],url)); ?>"
						  width="80" height="80">
					</a>
				 </div>
				 <div class="team-info">
				 
				 <div><a href="<?php echo U('/team/'.$team['id']);?>"><?php echo ($team["name"]); ?></a></div>
				 
				 <div class="pull-left">
				 <div>成员: <?php echo ($team["members"]); ?>人 </div>
				 
				 <div>游戏: <?php echo get_game($team['game_id'],'title');?> </div>
				 </div>
				 
				 </div>
				</div>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
</div>