<?php if (!defined('THINK_PATH')) exit();?><div class="col-xs-12">
	<div class="slide slidePic">
		<div class="content" id="flash_content">
			<div class="showBox clearfix">
				<div id="index_flash" class="flash">

					<div class="livePlayer" id="livePlayer">
						<embed id="player" width="690px" height="450px"
							allownetworking="internal" allowscriptaccess="always"
							src="<?php echo current($scrolls)['flash_url'] ?>"
							quality="high" bgcolor="#000" wmode="transparent"
							allowfullscreen="true" allowFullScreenInteractive="true"
							type="application/x-shockwave-flash">
					</div>

					<div class="enter_room">
						<a id="enter_room" href="<?php echo U('/live/'.current($scrolls)['live_id']);?>"></a>
					</div>

				</div>
				<div class="flashR" id="flash_slide">

					<ul class="c12">


						<?php if(is_array($scrolls)): $i = 0; $__LIST__ = $scrolls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$scroll): $mod = ($i % 2 );++$i;?><li rel="channel_<?php echo ($scroll['live_id']); ?>"
							data-url="<?php echo ($scroll['flash_url']); ?>"><a href="javascript:"
							class="showImg"
							onclick="change_channel(<?php echo ($scroll['live_id']); ?>); return false;">
								<img src="<?php echo (get_cover($scroll["cover"],'url')); ?>" width="198"
								height="112">
								<div class="headline"><?php echo ($scroll["title"]); ?></div>
								<div class="shadow"></div>
								<div class="borderPic"></div>
						</a></li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>

				</div>
			</div>
		</div>
	</div>
</div>