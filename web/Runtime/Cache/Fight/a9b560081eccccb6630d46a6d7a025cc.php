<?php if (!defined('THINK_PATH')) exit();?><div class="row">
	<div class="col-xs-12  column-content">
		<div class="column-content-title">
			<i class="title-tip-box"></i> <span class="title-tip"><a
				href="<?php echo U('/live/hot');?>">最新比赛</a></span> <span class="pull-right"> <a
				href="<?php echo U('/match/index');?>">更多比赛</a></span>
		</div>
		<div class="match-list">
			<ul>

				<?php if(is_array($matches)): $i = 0; $__LIST__ = $matches;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$match): $mod = ($i % 2 );++$i;?><li>
					<div>
						<a href="<?php echo U('/match/'.$match['id']);?>"> <img
							src="/Public/Core/images/placeholder.png"
							lazy-src="<?php echo query_picture('url',$match['cover']);?>"
							alt="<?php echo ($match['title']); ?>" width="276px" height="130px">
						</a>
					</div>
					<div class="match-des">
					<strong><a href="<?php echo U('/match/'.$match['id']);?>"><?php echo ($match["title"]); ?></a></strong>
					
					<div class="match-time">开始时间:<?php echo date('Y-m-d',$match['start_time']);?></div>
					
					</div>
					
					
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
	</div>
</div>