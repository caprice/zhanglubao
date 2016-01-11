<?php if (!defined('THINK_PATH')) exit();?><div class="row">
	<div class="col-xs-12  column-content">
		<div class="column-content-title">
			<i class="title-tip-box"></i> <span class="title-tip"><a
				href="<?php echo U('/fight/hot');?>">战斗排行榜</a></span>
		</div>
		<div class="fighter-list column-content">
			<ul>

				<?php if(is_array($members)): $i = 0; $__LIST__ = $members;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$member): $mod = ($i % 2 );++$i;?><li>
				<div class="cl">
				 <div class="avatar">
				 
				 		<a href="<?php echo U('/u/'.$member['uid']);?>"> <img
						src="/Public/Core/images/placeholder.png"
						lazy-src="<?php echo ($member["avatar"]); ?>"
						  width="80" height="80">
					</a>
				 </div>
				 <div class="fighter-info">
				 
				 <div><a href="<?php echo U('/u/'.$member['uid']);?>"><?php echo ($member["username"]); ?></a></div>
				 
				 <div class="pull-left">
				 <div>赚取: <?php echo ($member["win_coins"]); ?> </div>
				 
				 <div>场次: <?php echo ($member["total_fights"]); ?> </div>
				 </div>
				 <div class="pull-right fighter-invite">
				 
				<a href="<?php echo U('/u/'.$member['uid']);?>">战</a>
				 </div>
				 </div>
				</div>
				
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</div>
</div>