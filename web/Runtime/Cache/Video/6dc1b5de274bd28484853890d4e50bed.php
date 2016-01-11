<?php if (!defined('THINK_PATH')) exit();?>
<!-- fight end -->
<div class="row">
	<div class="col-xs-12  column-content">
		<div class="column-content-title">
			<i class="title-tip-box"></i> <span class="title-tip"><a
				href="<?php echo U('/album/index');?>">专题</a></span> <span class="pull-right">
				<a href="<?php echo U('/album/index');?>">更多专题</a>
			</span>
		</div>

		<div class="album-list">
			<ul>
				<?php if(is_array($albums)): $i = 0; $__LIST__ = $albums;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$album): $mod = ($i % 2 );++$i;?><li><span class="album-item-name"><a
						href="<?php echo U('/game/'.$album['game_id']);?>">[<?php echo get_game($album['game_id'],'title');?>]</a></span><span
					class="album-item-title"> <a
						href="<?php echo U('/album/'.$album['id']);?>"><?php echo ($album['title']); ?> </a></span></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
	</div>
</div>