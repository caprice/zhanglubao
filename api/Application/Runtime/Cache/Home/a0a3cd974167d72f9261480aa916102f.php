<?php if (!defined('THINK_PATH')) exit();?><div class="col4  modSwitch">
	<div class="h">
		<h2>最新视频</h2>
		<ul class="t_tab" id="newtab">
			<li class="current"><a target="_blank"   href="<?php echo U('/fresh@v');?>">最新视频</a></li>
			<li><a target="_blank"   href="<?php echo U('/top@v');?>">今日热门</a></li>
			<li><a target="_blank"  href="<?php echo U('/top-week@v');?>">本周热门</a></li>
			<li class=""><a   target="_blank" href="<?php echo U('/top-month@v');?>">本月热门</a></li>
			<li><a   target="_blank" href="<?php echo U('/top-all@v');?>">热门视频</a></li>
		</ul>
	</div>
	<div class="bline"></div>
	<div id="newcontent">
		<div id="secNew" class="c">
			<?php if(is_array($newvideos)): $i = 0; $__LIST__ = $newvideos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$video): $mod = ($i % 2 );++$i;?><div class="col1">

				<div class="pack packc">
					<div class="pic">

						<a href="<?php echo U('/'.$video['id'].'@v');?>" title="<?php echo ($video["video_title"]); ?>"
							target="new"> <img class="quic"
							src="/Public/Static/images/placeholder.png"
							lazy-src="<?php echo ($video["video_picture"]); ?>"></a><span class="vtime"
							style="display: block;"><span class="bg"></span></span>
					</div>
					<div class="txt">
						<h6 class="caption">
							<a href="<?php echo U('/'.$video['id'].'@v');?>" title="<?php echo ($video["video_title"]); ?>"
								target="new"><?php echo ($video["video_title"]); ?></a>
						</h6>

					</div>
					<div class="thumb">
						<a href="<?php echo U('/'.$video['uid'].'@u');?>" class="user"
							target="_blank"><img title="<?php echo ($video['user']['nickname']); ?>"
							  src="/Public/Static/images/placeholder.png"
							lazy-src="<?php echo ($video['user']['avatar_mid_url']); ?>"></a><a
							href="<?php echo U('/'.$video['uid'].'@u');?>" target="_blank"><?php echo ($video['user']['nickname']); ?></a>
					</div>
				</div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>


		<div id="secDay" class="c" style="display: none;">
			<?php if(is_array($dayvideos)): $i = 0; $__LIST__ = $dayvideos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$video): $mod = ($i % 2 );++$i;?><div class="col1">

				<div class="pack packc">
					<div class="pic">

						<a href="<?php echo U('/'.$video['id'].'@v');?>" title="<?php echo ($video["video_title"]); ?>"
							target="new"><img class="quic"
							src="/Public/Static/images/placeholder.png"
							lazy-src="<?php echo ($video["video_picture"]); ?>"></a><span class="vtime"
							style="display: block;"><span class="bg"></span></span>
					</div>
					<div class="txt">
						<h6 class="caption">
							<a href="<?php echo U('/'.$video['id'].'@v');?>" title="<?php echo ($video["video_title"]); ?>"
								target="new"><?php echo ($video["video_title"]); ?></a>
						</h6>

					</div>
					<div class="thumb">
						<a href="<?php echo U('/'.$video['uid'].'@u');?>" class="user"
							target="_blank"><img title="<?php echo ($video['user']['nickname']); ?>"
							src="/Public/Static/images/placeholder.png"
							lazy-src="<?php echo ($video['user']['avatar_mid_url']); ?>"></a><a
							href="<?php echo U('/'.$video['uid'].'@u');?>" target="_blank"><?php echo ($video['user']['nickname']); ?></a>
					</div>
				</div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>



		<div id="secWeek" class="c" style="display: none;">
			<?php if(is_array($weekvideos)): $i = 0; $__LIST__ = $weekvideos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$video): $mod = ($i % 2 );++$i;?><div class="col1">

				<div class="pack packc">
					<div class="pic">

						<a href="<?php echo U('/'.$video['id'].'@v');?>" title="<?php echo ($video["video_title"]); ?>"
							target="new"> <img class="quic"
							src="/Public/Static/images/placeholder.png"
							lazy-src="<?php echo ($video["video_picture"]); ?>"></a><span class="vtime"
							style="display: block;"><span class="bg"></span></span>
					</div>
					<div class="txt">
						<h6 class="caption">
							<a href="<?php echo U('/'.$video['id'].'@v');?>" title="<?php echo ($video["video_title"]); ?>"
								target="new"><?php echo ($video["video_title"]); ?></a>
						</h6>

					</div>
					<div class="thumb">
						<a href="<?php echo U('/'.$video['uid'].'@u');?>" class="user"
							target="_blank"><img title="<?php echo ($video['user']['nickname']); ?>"
							src="/Public/Static/images/placeholder.png"
							lazy-src="<?php echo ($video['user']['avatar_mid_url']); ?>"></a><a
							href="<?php echo U('/'.$video['uid'].'@u');?>" target="_blank"><?php echo ($video['user']['nickname']); ?></a>
					</div>
				</div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>



		<div id="secMonth" class="c" style="display: none;">
			<?php if(is_array($monthvideos)): $i = 0; $__LIST__ = $monthvideos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$video): $mod = ($i % 2 );++$i;?><div class="col1">

				<div class="pack packc">
					<div class="pic">

						<a href="<?php echo U('/'.$video['id'].'@v');?>" title="<?php echo ($video["video_title"]); ?>"
							target="new"> <img class="quic"
							src="/Public/Static/images/placeholder.png"
							lazy-src="<?php echo ($video["video_picture"]); ?>"></a><span class="vtime"
							style="display: block;"><span class="bg"></span></span>
					</div>
					<div class="txt">
						<h6 class="caption">
							<a href="<?php echo U('/'.$video['id'].'@v');?>" title="<?php echo ($video["video_title"]); ?>"
								target="new"><?php echo ($video["video_title"]); ?></a>
						</h6>

					</div>
					<div class="thumb">
						<a href="<?php echo U('/'.$video['uid'].'@u');?>" class="user"
							target="_blank"><img title="<?php echo ($video['user']['nickname']); ?>"
							src="/Public/Static/images/placeholder.png"
							lazy-src="<?php echo ($video['user']['avatar_mid_url']); ?>"></a><a
							href="<?php echo U('/'.$video['uid'].'@u');?>" target="_blank"><?php echo ($video['user']['nickname']); ?></a>
					</div>
				</div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</div>
</div>