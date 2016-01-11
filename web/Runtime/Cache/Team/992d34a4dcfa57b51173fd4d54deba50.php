<?php if (!defined('THINK_PATH')) exit();?><div class="">


<?php if($allow_publish): ?><div style="margin-bottom: 12px;margin-top:12px;">
        <a type="button" class="btn btn-large btn-primary forum_post_btn"
           href="<?php echo U('Forum/edit',array('forum_id'=>$forum_id));?>">

            发表新帖
        </a>
    </div><?php endif; ?>

</div>

<?php if($sidevideos): ?><div class="">
	<div class="column-content" >
		<div class="column-content-title" style="margin-bottom: 12px;">
			<i class="title-tip-box"></i> <span class="title-tip"><a
				href="<?php echo U('/fight/hot');?>">战队最新视频</a></span>
		</div>
		 
		 
		 <div class="side-matchvideo-list">
							<ul>
								<?php if(is_array($sidevideos)): $i = 0; $__LIST__ = $sidevideos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nearvideo): $mod = ($i % 2 );++$i;?><li>

									<div class="v-thumb">
										<a href="<?php echo U('/video/'.$nearvideo['id']);?>" onclick=""> <img
											src="/Public/Core/images/placeholder.png"
											lazy-src="<?php echo query_picture('url',$nearvideo['cover']);?>"
											alt="<?php echo ($nearvideo['title']); ?>" width="145px" height="80px"></a>

									</div>

									<div class="v-meta">

										<div class="v-meta-title">
											<a href="<?php echo U('/video/'.$nearvideo['id']);?>"><?php echo ($nearvideo['title']); ?></a>

										</div>

										<div class="v-num">
											<span class="glyphicon glyphicon-facetime-video  "></span> <span
												class="v-meta-des"><?php echo ($nearvideo['views']); ?></span>
										</div>
									</div>

								</li><?php endforeach; endif; else: echo "" ;endif; ?>
							</ul>
						</div>
						
	</div>
</div><?php endif; ?>