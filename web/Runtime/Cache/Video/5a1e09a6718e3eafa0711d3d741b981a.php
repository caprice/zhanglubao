<?php if (!defined('THINK_PATH')) exit();?><div class="row">
	<div class="col-xs-12  column-content">
		<div class="column-content-title">
			<i class="title-tip-box"></i> <span class="title-tip">作者最新视频</span> <span class="pull-right"></span>
		</div>
	</div>
	<div class="col-xs-12  column-content">
		<div class="side-matchvideo-list">
			<ul>
				<?php if(is_array($uservideos)): $i = 0; $__LIST__ = $uservideos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$uservideo): $mod = ($i % 2 );++$i;?><li>

					<div class="v-thumb">
						<a href="<?php echo U('/video/'.$uservideo['id']);?>" > <img
							src="/Public/Core/images/placeholder.png"
							lazy-src="<?php echo query_picture('url',$uservideo['cover']);?>"
							alt="<?php echo ($uservideo['title']); ?>" width="145px" height="80px"></a>

					</div>

					<div class="v-meta">

						<div class="v-meta-title">
							<a href="<?php echo U('/video/'.$uservideo['id']);?>"><?php echo ($uservideo['title']); ?></a>

						</div>

						<div class="v-num">
							<span class="glyphicon glyphicon-facetime-video  "></span> <span
								class="v-meta-des"><?php echo ($uservideo['views']); ?></span>
						</div>
					</div>

				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
	</div>
</div>