<?php if (!defined('THINK_PATH')) exit();?><div class="row">
	<div class="col-xs-12  column-content">
		<div class="column-content-title">
			<i class="title-tip-box"></i> <span class="title-tip">热门战队</span>
		</div>
		<div class="hot-list column-content">
			<ul>

				<?php if(is_array($hots)): $i = 0; $__LIST__ = $hots;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hot): $mod = ($i % 2 );++$i;?><li>
				<div class="cl">
				 <div class="team-icon">
				 
				 		<a href="<?php echo U('/team/'.$hot['id']);?>"> <img
						src="/Public/Core/images/placeholder.png"
						lazy-src="<?php echo (get_cover($hot["cover"],url)); ?>"
						  width="80" height="80">
					</a>
				 </div>
				 <div class="team-info">
				 
				 <div><a href="<?php echo U('/team/'.$hot['id']);?>"><?php echo ($hot["name"]); ?></a></div>
				 
				 <div class="pull-left">
				 <div>成员: <?php echo ($hot["members"]); ?>人 </div>
				 
				 <div>游戏: <?php echo get_game($hot['game_id'],'title');?> </div>
				 </div>
				 
				 </div>
				</div>
				
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</div>
</div>