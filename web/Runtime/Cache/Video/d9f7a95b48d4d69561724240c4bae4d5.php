<?php if (!defined('THINK_PATH')) exit();?><div class="row">
	<div class="col-xs-12  column-content">
		<div class="column-content-title">
			<i class="title-tip-box"></i> <span class="title-tip"><a
				href="<?php echo U('／video/recommend');?>">推荐视频</a></span> <span class="pull-right"></span>
		</div>
	</div>
	<div class="col-xs-12  column-content">
		<div class="side-matchvideo-list">
			<ul>
				<?php if(is_array($hots)): $i = 0; $__LIST__ = $hots;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hot): $mod = ($i % 2 );++$i;?><li>

					<div class="v-thumb">
						<a href="<?php echo U('/video/'.$hot['id']);?>" > <img
							src="/Public/Static/quntiao/image/placeholder.png"
							lazy-src="<?php echo query_picture('url',$hot['cover']);?>"
							alt="<?php echo ($hot['title']); ?>" width="145px" height="80px"></a>

					</div>

					<div class="v-meta">

						<div class="v-meta-title">
							<a href="<?php echo U('/video/'.$hot['id']);?>"><?php echo ($hot['title']); ?></a>

						</div>

						<div class="v-num">
							<span class="glyphicon glyphicon-facetime-video  "></span> <span
								class="v-meta-des"><?php echo ($hot['views']); ?></span>
						</div>
					</div>

				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
	</div>
</div>