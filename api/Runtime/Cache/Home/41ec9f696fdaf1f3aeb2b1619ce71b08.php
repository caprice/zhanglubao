<?php if (!defined('THINK_PATH')) exit();?><div id="index_slide">

	<div class="mod-banner" style="visibility: visible;">
		<div class="slider">
			<?php if(is_array($recs)): $i = 0; $__LIST__ = $recs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rec): $mod = ($i % 2 );++$i;?><a href="#" class="el"
				data-rkey="HITBANNER" data-index="0"> <img
				src="<?php echo ($rec["rec_picture"]); ?>" class="img" >
				<div class="loadtips">正在努力加载中</div>
				<div class="info"><?php echo ($rec["rec_title"]); ?></div>
			</a><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>

		<div class="count ">
			<div class="inner">

				<span class="control-item"></span> <span class=" control-item"></span>

				<span class=" control-item current"></span>

			</div>
		</div>
		<div class="pagecount ns-none">3/3</div>

	</div>
</div>